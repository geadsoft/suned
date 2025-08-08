<?php

namespace App\Http\Livewire;
use App\Models\TmHorarios;
use App\Models\TmHorariosDocentes;
use App\Models\TmActividades;
use App\Models\TdCalificacionActividades;
use App\Models\TdPeriodoSistemaEducativos;
use App\Models\TmPeriodosLectivos;
use App\Models\TmPersonas;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class VcQualifyActivity extends Component
{   

    public $asignaturaId=0, $actividadId=0, $paralelo, $termino="1T", $bloque="1P", $tipo="AI", $nombre, $fecha, $archivo='SI', $puntaje=10, $enlace="", $control="enabled";
    public $tblparalelo=[], $tblasignatura=[];
    public $periodoId, $modalidadId=0, $tbltermino, $tblbloque, $tblactividades, $cursoId;
    public $tblactividad=[];
    public $tblrecords=[];
    public $personas=[];
    public $detalle=[];
    public $arrnotas=[];
    public $docenteId;

    public $filters=[
        'paralelo' => 0, 
        'termino' => '1T',
        'bloque' => '1P',
        'actividad' => 'AI',
    ];

    protected $listeners = ['setData'];

    public function mount()
    {
        $this->docenteId = auth()->user()->personaId;

        $tblperiodos = TmPeriodosLectivos::where("aperturado",1)->first();
        $this->periodoId = $tblperiodos['id'];

        $this->tbltermino = TdPeriodoSistemaEducativos::query()
        ->where('periodo_id',$this->periodoId)
        ->where('tipo','EA')
        ->get();

        $this->termino = $this->tbltermino[0]['codigo'];

        $this->tblactividades = TdPeriodoSistemaEducativos::query()
        ->where('periodo_id',$this->periodoId)
        ->where('tipo','AC')
        ->where('codigo','<>','EX')
        ->get();

    }

    public function render()
    {   
        
        $this->tblmodalidad = TmHorarios::query()
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_generalidades as g","g.id","=","tm_horarios.grupo_id")
        ->where("tm_horarios.periodo_id",$this->periodoId)
        ->where("d.docente_id",$this->docenteId)
        ->selectRaw('g.id, g.descripcion')
        ->groupBy('g.id','g.descripcion')
        ->get();
        
        $this->tblbloque = TdPeriodoSistemaEducativos::query()
        ->where('periodo_id',$this->periodoId)
        ->where('tipo','PA')
        ->where('evaluacion',$this->termino)
        ->get();
        
        $this->tblasignatura = TmHorarios::query()
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as m","m.id","=","d.asignatura_id")
        ->where("tm_horarios.periodo_id",$this->periodoId)
        ->where("d.docente_id",$this->docenteId)
        ->where('tm_horarios.grupo_id',$this->modalidadId)
        ->selectRaw('m.id, m.descripcion')
        ->groupBy('m.id','m.descripcion')
        ->get();

        $this->tblparalelo = TmHorarios::query()
        ->join("tm_servicios as s","s.id","=","tm_horarios.servicio_id")
        ->join("tm_cursos as c","c.id","=","tm_horarios.curso_id")
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as m","m.id","=","d.asignatura_id")
        ->where("tm_horarios.periodo_id",$this->periodoId)
        ->where('tm_horarios.grupo_id',$this->modalidadId)
        ->where("d.docente_id",$this->docenteId)
        ->where("m.id",$this->asignaturaId)
        ->selectRaw('d.id, concat(s.descripcion," ",c.paralelo) as descripcion')
        ->get();

        $this->loadPersonas();
        
        return view('livewire.vc-qualify-activity',[
            'tblrecords'  => $this->tblrecords,
            'tbltarea' => $this->tblactividad,
            'tblparalelo' => $this->tblparalelo,
            'tblnotas' => $this->arrnotas,
        ]);
    }

    public function updatedasignaturaId($id){

        $this->tblparalelo = TmHorarios::query()
        ->join("tm_servicios as s","s.id","=","tm_horarios.servicio_id")
        ->join("tm_cursos as c","c.id","=","tm_horarios.curso_id")
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as m","m.id","=","d.asignatura_id")
        ->where("tm_horarios.periodo_id",$this->periodoId)
        ->where('tm_horarios.grupo_id',$this->modalidadId)
        ->where("d.docente_id",$this->docenteId)
        ->where("m.id",$id)
        ->selectRaw('d.id, concat(s.descripcion," ",c.paralelo) as descripcion')
        ->get();

        $this->tblrecords=[];

    }

    public function loadPersonas(){

        $curso = TmHorarios::query()
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->where("d.id",$this->filters['paralelo'])
        ->select("tm_horarios.*")
        ->first();

        $this->cursoId = $curso->curso_id ?? 0;
        
        // Subconsulta para obtener los IDs de matrículas que ya tienen pase activo
        $matriculasConPase = DB::table('tm_pase_cursos')
        ->where('estado', 'A')
        ->pluck('matricula_id');

        // Consulta de matrículas SIN pase
        $matriculasQuery = DB::table('tm_matriculas as m')
        ->select('m.estudiante_id', 'm.documento', 'm.modalidad_id', 'm.periodo_id', 'm.curso_id')
        ->where('m.modalidad_id', $this->modalidadId)
        ->where('m.periodo_id', $this->periodoId)
        ->where('m.estado','A')
        ->whereNotIn('m.id', $matriculasConPase);

        // Consulta de pases activos
        $pasesQuery = DB::table('tm_pase_cursos as p')
        ->join('tm_matriculas as m', 'm.id', '=', 'p.matricula_id')
        ->select('m.estudiante_id', 'm.documento', 'p.modalidad_id', 'm.periodo_id', 'p.curso_id')
        ->where('p.modalidad_id', $this->modalidadId)
        ->where('m.periodo_id', $this->periodoId)
        ->where('m.estado', 'A')
        ->where('p.estado', 'A');

        // UNION de ambas consultas
        $unionQuery = $matriculasQuery->unionAll($pasesQuery);

        // Consulta principal con joinSub en Eloquent
        $this->personas = TmPersonas::query()
            ->joinSub($unionQuery, 'm', function ($join) {
            $join->on('tm_personas.id', '=', 'm.estudiante_id');
        })
        ->where('m.curso_id', $this->cursoId)
        ->select('tm_personas.*', 'm.documento')
        ->orderBy('tm_personas.apellidos')
        ->get();

    }

    public function consulta(){

        $this->tblactividad = TmActividades::query()
        ->when($this->filters['paralelo'],function($query){
            return $query->where('paralelo',"{$this->filters['paralelo']}");
        })
        ->when($this->filters['termino'],function($query){
            return $query->where('termino',"{$this->filters['termino']}");
        })
        ->when($this->filters['bloque'],function($query){
            return $query->where('bloque',"{$this->filters['bloque']}");
        })
        ->when($this->filters['actividad'],function($query){
            return $query->where('actividad',"{$this->filters['actividad']}");
        })
        ->where("tipo","AC")
        ->where("docente_id",$this->docenteId)
        ->orderBy("fecha")
        ->get()
        ->toArray();
            
        $this->add();
        $this->asignarNotas();
        
    }


    public function add(){

        $this->tblrecords=[];

        $this->loadPersonas();

        // Actualiza Datos Estudiantes
        foreach ($this->personas as $key => $data)
        {   
            $index = $data->id;
            $this->tblrecords[$data->id]['personaId'] = $data->id;
            $this->tblrecords[$data->id]['nui'] = $data->identificacion;
            $this->tblrecords[$data->id]['nombres'] = $data->apellidos.' '.$data->nombres;

            foreach ($this->tblactividad as $col => $actividad)
            {
                $this->tblrecords[$data->id][$actividad['id']] = 0.00;    
            }
            $this->tblrecords[$data->id]['promedio'] = 0.00;
        }

        $this->tblrecords['ZZ']['personaId'] = 0;
        $this->tblrecords['ZZ']['nui'] = '';
        $this->tblrecords['ZZ']['nombres'] = 'Promedio';
        foreach ($this->tblactividad as $col => $actividad)
        {
            $this->tblrecords['ZZ'][$actividad['id']] = 0.00;    
        }
        $this->tblrecords['ZZ']['promedio'] = 0.00;

    }

    public function asignarNotas(){

        $notas = TmActividades::query()
        ->join('td_calificacion_actividades as n','n.actividad_id','=','tm_actividades.id')
        ->when($this->filters['paralelo'],function($query){
            return $query->where('paralelo',"{$this->filters['paralelo']}");
        })
        ->when($this->filters['termino'],function($query){
            return $query->where('termino',"{$this->filters['termino']}");
        })
        ->when($this->filters['bloque'],function($query){
            return $query->where('bloque',"{$this->filters['bloque']}");
        })
        ->when($this->filters['actividad'],function($query){
            return $query->where('actividad',"{$this->filters['actividad']}");
        })
        ->where("tipo","AC")
        ->where("docente_id",$this->docenteId)
        ->select("n.*")
        ->get();  

        foreach ($notas as $key => $record){

            $fil = $record->persona_id;
            $col = $record->actividad_id;

            if (isset($this->tblrecords[$fil][$col])) {
                $this->tblrecords[$fil][$col] = $record->nota;
            }
        }

        foreach ($this->tblrecords as $key => $record){
            $suma  = 0;
            $count = 0;
            foreach ($this->tblactividad as $col => $actividad)
            {
                $suma += $this->tblrecords[$key][$actividad['id']];
                $count += 1;    
            }

            if ($suma>0){
                $this->tblrecords[$key]['promedio'] =  round($suma/$count, 2); 
            }
            
        }

        //Promedio Total
        foreach ($this->tblactividad as $col => $actividad)
        {   
            $suma  = 0;
            $count = 0;

            foreach ($this->tblrecords as $key => $record){
                if ($key != 'ZZ'){
                    $suma += $this->tblrecords[$key][$actividad['id']];
                    $count += 1;
                }  
            }

            if($suma>0){
                $this->tblrecords['ZZ'][$actividad['id']] =  round($suma / $count, 2);
            }

        }

        $suma  = 0;
        $count = 0;
        foreach ($this->tblrecords as $key => $record){
            if ($key != 'ZZ'){
                $suma  += $this->tblrecords[$key]['promedio'];
                $count += 1;
            }
        }
        if($suma>0){
            $this->tblrecords['ZZ']['promedio'] = round($suma /($count), 2);
        }
    }

    public function createData(){

        if (count($this->tblactividad)>0){

            $message = "";
            $this->dispatchBrowserEvent('msg-confirm', ['newName' => $message]);

        }else{

            $message = "";
            $this->dispatchBrowserEvent('msg-alert', ['newName' => $message]);

        }

    }

    public function setData()
    {

        $dataRow=[
            'id' => 0,
            'actividad_id' => 0,
            'persona_id' => 0,
            'nota' => 0,
            'estado' => 0,
            'usuario' => 0,
        ];

        foreach ($this->tblrecords as $index => $data)
        {   
            $dataRow   = [];
            $personaId = $index;
            foreach ($this->tblactividad as $col => $actividad)
            {
                $actividadId   = $actividad['id'];
                $dataRow['id'] = 0;               

                $tmpnota = TdCalificacionActividades::query()
                ->where('actividad_id',$actividadId) 
                ->where('persona_id',$personaId)
                ->first();
                
                $dataRow['id'] = $tmpnota?->id ?? 0;  

                $dataRow['actividad_id'] = $actividad['id'];
                $dataRow['persona_id']=$personaId;
                $dataRow['nota'] = $this->tblrecords[$personaId][$actividadId];
                $dataRow['estado'] = 'A';
                $dataRow['usuario'] = auth()->user()->name;   
                
                if ($index!="ZZ"){
                    array_push($this->detalle,$dataRow);
                }
               
            }
            
        }

        foreach ($this->detalle as $detalle){

                TdCalificacionActividades::query()
                ->where("actividad_id","=",$detalle['actividad_id'])
                ->where("persona_id","=",$detalle['persona_id'])
                ->delete();
                
                TdCalificacionActividades::Create([
                    'actividad_id' => $detalle['actividad_id'],
                    'persona_id' => $detalle['persona_id'],
                    'nota' =>  $detalle['nota'],
                    'usuario' => auth()->user()->name,
                    'estado' => 'A',
                ]);

        }

        $message = "Calificaciones grabada con Éxito......";
        $this->dispatchBrowserEvent('msg-grabar', ['newName' => $message]);
    

    }



}
