<?php

namespace App\Http\Livewire;
use App\Models\TmGeneralidades;
use App\Models\TmHorarios;
use App\Models\TmHorariosDocentes;
use App\Models\TmActividades;
use App\Models\TdAsistenciaDiarias;
use App\Models\TmPeriodosLectivos;
use App\Models\TmCursos;


use Livewire\Component;
use Illuminate\Support\Facades\DB;
use DateTime;
use Carbon\Carbon;

class VcDailyAttendance extends Component
{

    public $modalidadId, $tblmodalidad, $personas=[];
    public $asignaturaId;
    public $tblrecords=[], $diasHabiles=[];
    
    public $filters=[
        'docenteId' => 0,
        'cursoId' => 0, 
        'buscar' => '',
        'fecha' => '',
        'mes' => 1,
        'periodo' => 0,
    ];

    protected $listeners = ['setData'];

    public $objdia=[
        1 => 'L',
        2 => 'M',
        3 => 'X',
        4 => 'J',
        5 => 'V',
    ];

    public $objmes = [
        1 => 'Enero',
        2 => 'Febrero',
        3 => 'Marzo',
        4 => 'Abril',
        5 => 'Mayo',
        6 => 'Junio',
        7 => 'Julio',
        8 => 'Agosto',
        9 => 'Septiembre',
        10=> 'Octubre',
        11=> 'Noviembre',
        12=> 'Diciembre',
    ];

    public function mount()
    {   
        $ldate = date('Y-m-d H:i:s');
        $this->filters['fecha'] = date('Y-m-d',strtotime($ldate));
        $this->filters['docenteId'] = auth()->user()->personaId;
        $this->filters['mes'] = intval(date('m',strtotime($ldate)));

        $tblperiodos = TmPeriodosLectivos::where("aperturado",1)->first();
        $this->periodoId = $tblperiodos['id'];
        $this->filters['periodo'] = $tblperiodos['periodo'];
        
    }

    public function render()
    {
        $this->tblmodalidad = TmGeneralidades::where('superior',1)->get();

        $this->tblparalelo = TmCursos::query()
        ->join('tm_servicios as s', 's.id', '=', 'tm_cursos.servicio_id')
        ->where('tm_cursos.periodo_id',$this->periodoId)
        ->where('s.modalidad_id', $this->modalidadId)
        ->select("tm_cursos.id","s.descripcion","tm_cursos.paralelo")
        ->orderBy('tm_cursos.nivel_id')
        ->orderBy('tm_cursos.grado_id')
        ->get();

        $this->personas = TmHorarios::query()
        ->join("tm_matriculas as m",function($join){
            $join->on("m.modalidad_id","=","tm_horarios.grupo_id")
                ->on("m.periodo_id","=","tm_horarios.periodo_id")
                ->on("m.curso_id","=","tm_horarios.curso_id");
        })
        ->join("tm_personas as p","p.id","=","m.estudiante_id")
        ->when($this->filters['buscar'],function($query){
            return $query->where(DB::raw('concat(ltrim(rtrim(p.apellidos))," ",ltrim(rtrim(p.nombres)))'), 'LIKE' , "%{$this->filters['buscar']}%");
        })
        ->select("p.*")
        ->where("tm_horarios.curso_id",$this->filters['cursoId'])
        ->where("tm_horarios.periodo_id",$this->periodoId)
        ->where("m.estado","A")
        ->orderBy("p.apellidos")
        ->get();

        return view('livewire.vc-daily-attendance');
    }

    public function consulta(){

        $this->personas = TmHorarios::query()
        ->join("tm_matriculas as m",function($join){
            $join->on("m.modalidad_id","=","tm_horarios.grupo_id")
                ->on("m.periodo_id","=","tm_horarios.periodo_id")
                ->on("m.curso_id","=","tm_horarios.curso_id");
        })
        ->join("tm_personas as p","p.id","=","m.estudiante_id")
        ->when($this->filters['buscar'],function($query){
            return $query->where(DB::raw('concat(ltrim(rtrim(p.apellidos))," ",ltrim(rtrim(p.nombres)))'), 'LIKE' , "%{$this->filters['buscar']}%");
        })
        ->select("p.*")
        ->where("tm_horarios.curso_id",$this->filters['cursoId'])
        ->where("tm_horarios.periodo_id",$this->periodoId)
        ->where("m.estado","A")
        ->orderBy("p.apellidos")
        ->get();
        
        $this->add();
        $this->loadfalta();

    }

    public function add(){

       $this->tblrecords=[];
       $this->diasHabiles = $this->obtenerDiasHabiles($this->filters['periodo'],$this->filters['mes']);

        // Datos
        foreach ($this->personas as $key => $data)
        {   
            $index = $data->id;
            $this->tblrecords[$index]['id'] = 0;
            $this->tblrecords[$index]['personaId'] = $data->id;
            $this->tblrecords[$index]['nombres'] = $data->apellidos.' '.$data->nombres;
            foreach ($this->diasHabiles as $dias){
                $lndia = $dias['fecha'];
                $this->tblrecords[$index][$lndia] = "";
            } 
        }

    }

    public function loadfalta(){

        $faltas = TdAsistenciaDiarias::query()
        ->where("curso_id",$this->filters['cursoId'])
        ->where("docente_id",$this->filters['docenteId'])
        ->where("periodo_id", $this->periodoId)
        ->where("mes", $this->filters['mes'])
        ->whereRaw("valor<>''")
        ->get();

        foreach ($faltas as $key => $data)
        {
            $index = $data->persona_id;
            $dia = intval(date("d", strtotime($data->fecha)));

            $this->tblrecords[$index][$dia] = $data->valor;
        }

    }

    public function createData(){

        if (count($this->tblrecords)>0){

            $message = "";
            $this->dispatchBrowserEvent('msg-confirm', ['newName' => $message]);

        }else{

            $message = "";
            $this->dispatchBrowserEvent('msg-alert', ['newName' => $message]);

        }        

    }

    public function setData()
    {
        $periodo = TmPeriodosLectivos::find($this->periodoId);
        $anio = str_pad($periodo->periodo, 4, '0', STR_PAD_LEFT); 
        $mes  = str_pad($this->filters['mes'], 2, '0', STR_PAD_LEFT);


        foreach ($this->tblrecords as $index => $data)
        {
            $personaId = $data['personaId'];

            foreach ($this->diasHabiles as $dias){

                $dia   = str_pad($dias['fecha'], 2, '0', STR_PAD_LEFT);
                $fecha = date("Y-m-d", strtotime("$anio-$mes-$dia"));
                
                $asistencia = TdAsistenciaDiarias::query()
                    ->where("periodo_id", $this->periodoId)
                    ->where("mes", $this->filters['mes'])
                    ->whereRaw("DAY(fecha) = ?", [$dias['fecha']])
                    ->where("persona_id", $personaId)
                    ->where("curso_id",$this->filters['cursoId'])
                    ->first();

                if ($asistencia) {

                    $asistencia->update([
                        'valor' => $this->tblrecords[$personaId][$dias['fecha']],
                    ]);

                }else{
                    
                    TdAsistenciaDiarias::Create([
                        'periodo_id' => $this->periodoId,
                        'mes' => $this->filters['mes'],
                        'docente_id' => $this->filters['docenteId'],
                        'asignatura_id' => null,
                        'curso_id' => $this->filters['cursoId'],
                        'persona_id' => $personaId,
                        'fecha' => $fecha,
                        'valor' =>  $this->tblrecords[$personaId][$dias['fecha']],
                        'usuario' => auth()->user()->name,
                        'estado' => 'A',
                    ]);

                }

            }
        
        }

        $message = "Calificaciones grabada con Éxito......";
        $this->dispatchBrowserEvent('msg-grabar', ['newName' => $message]);
        
    }

    function obtenerDiasHabiles($anio, $mes) {

        $diasHabiles = [];

        // Mapeo manual para forzar letras según índice 0=domingo...6=sábado
        $mapaDias = [
            0 => null,    // domingo (lo excluimos)
            1 => 'L',
            2 => 'M',
            3 => 'X',
            4 => 'J',
            5 => 'V',
            6 => null,    // sábado (lo excluimos)
        ];

        $totalDias = cal_days_in_month(CAL_GREGORIAN, $mes, $anio);

        for ($dia = 1; $dia <= $totalDias; $dia++) {
            $fechaCompleta = "$anio-" . str_pad($mes, 2, '0', STR_PAD_LEFT) . "-" . str_pad($dia, 2, '0', STR_PAD_LEFT);
            $diaSemana = (int) date('w', strtotime($fechaCompleta)); // 0=domingo, ..., 6=sábado

            if (isset($mapaDias[$diaSemana]) && $mapaDias[$diaSemana] !== null) {
                $diasHabiles[] = [
                    'fecha' => $dia,
                    'dia' => $diaSemana,
                    'letra' => $mapaDias[$diaSemana],
                ];
            }
        }

        return $diasHabiles;
    }
    
}


