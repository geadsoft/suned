<?php

namespace App\Http\Livewire;
use App\Models\TmPersonas; 
use App\Models\TmPeriodosLectivos;
use App\Models\TmHorarios;
use App\Models\TmHorariosDocentes;
use App\Models\TmActividades;
use App\Models\TdCalificacionActividades;

use Livewire\Component;

class VcReportTQualify extends Component
{
    
    //public $actividadId=0, $paralelo, $termino="1T", $bloque="1P", $tipo="AI", $nombre, $fecha, $archivo='SI', $puntaje=10, $enlace="", $control="enabled";
    public $nivel,$subtitulo,$docente,$asignatura,$curso;

    public $tblparalelo=[];
    public $tblactividad=[];
    public $tblrecords=[];
    public $personas=[];

    public $filters=[
        'paralelo' => 0, 
        'termino' => '3T',
        'bloque' => '1P',
        'actividad' => 'AI',
    ];

    protected $listeners = ['setData'];

    public function mount()
    {
        
        $this->tblparalelo = TmHorarios::query()
        ->join("tm_servicios as s","s.id","=","tm_horarios.servicio_id")
        ->join("tm_cursos as c","c.id","=","tm_horarios.curso_id")
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as m","m.id","=","d.asignatura_id")
        ->where("d.docente_id",2913)
        ->selectRaw('d.id, concat(m.descripcion," - ",s.descripcion," ",c.paralelo) as descripcion')
        ->get();

        if (!empty($this->tblparalelo)){
            $this->filters['paralelo'] = $this->tblparalelo[0]["id"];
            $this->consulta();
        }

    }

    public function render()
    {
        $this->tblparalelo = TmHorarios::query()
        ->join("tm_servicios as s","s.id","=","tm_horarios.servicio_id")
        ->join("tm_cursos as c","c.id","=","tm_horarios.curso_id")
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as m","m.id","=","d.asignatura_id")
        ->where("d.docente_id",2913)
        ->selectRaw('d.id, concat(m.descripcion," - ",s.descripcion," ",c.paralelo) as descripcion')
        ->get();

        return view('livewire.vc-report-t-qualify');
    }

    public function consulta(){

        $docente = TmPersonas::find(2913);

        $titulo = TmHorarios::query()
        ->join("tm_servicios as s","s.id","=","tm_horarios.servicio_id")
        ->join("tm_generalidades as n","n.id","=","s.nivel_id")
        ->join("tm_cursos as c","c.id","=","tm_horarios.curso_id")
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as m","m.id","=","d.asignatura_id")
        ->where("d.docente_id",2913)
        ->where("d.id",$this->filters['paralelo'])
        ->selectRaw('d.id, m.descripcion as asignatura,s.descripcion as servicio,c.paralelo, n.descripcion as nivel, tm_horarios.periodo_id')
        ->first();

        $periodo = TmPeriodosLectivos::find($titulo['periodo_id']);

        $this->nivel = $titulo['nivel'];
        $this->subtitulo = "Periodo Lectivo ".$periodo['descripcion'].'/Tercer Trimestre - Primer Parcial';
        $this->docente=$docente['apellidos'].' '.$docente['nombres'];
        $this->asignatura = $titulo['asignatura'];
        $this->curso = $titulo['servicio'].' '.$titulo['paralelo'];
        
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
        ->where("docente_id",2913)
        ->get();

        /*Notas*/
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
        ->where("docente_id",2913)
        ->select("n.*")
        ->get();
            
        $this->add();
        $this->asignarNotas($notas);

    }


    public function add(){

        $this->tblrecords=[];

        $this->personas = TmHorariosDocentes::query()
        ->join("tm_horarios as h","h.id","=","tm_horarios_docentes.horario_id")
        ->join("tm_matriculas as m",function($join){
            $join->on("m.modalidad_id","=","h.grupo_id")
                ->on("m.periodo_id","=","h.periodo_id")
                ->on("m.curso_id","=","h.curso_id");
        })
        ->join("tm_personas as p","p.id","=","m.estudiante_id")
        ->select("p.*")
        ->where("tm_horarios_docentes.id",$this->filters['paralelo'])
        ->orderBy("p.apellidos")
        ->get();



        // Actualiza Datos Estudiantes
        foreach ($this->personas as $key => $data)
        {   
            $index = $data->id;
            $this->tblrecords[$index]['id'] = 0;
            $this->tblrecords[$index]['personaId'] = $data->id;
            $this->tblrecords[$index]['nui'] = $data->identificacion;
            $this->tblrecords[$index]['nombres'] = $data->apellidos.' '.$data->nombres;
            $this->tblrecords[$index]['ai'] = 0.00;
            $this->tblrecords[$index]['ag'] = 0.00;
            $this->tblrecords[$index]['promedio'] = 0.00;
            $this->tblrecords[$index]['cualitativa'] = 0.00;
        }
       
        $this->tblrecords['X']['id'] = 0;
        $this->tblrecords['X']['personaId'] = 0;
        $this->tblrecords['X']['nui'] = '';
        $this->tblrecords['X']['nombres'] = 'PROMEDIO DE CURSO';
        $this->tblrecords['X']['ai'] = 0.00;
        $this->tblrecords['X']['ag'] = 0.00;
        $this->tblrecords['X']['promedio'] = 0.00;
        $this->tblrecords['X']['cualitativa'] = 0.00;
        
        
    }

    public function asignarNotas($notas){

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
        ->where("tipo","AC")
        ->where("docente_id",2913)
        ->selectRaw("tm_actividades.actividad,n.persona_id,sum(nota)/count(tm_actividades.actividad) as nota")
        ->groupBy("tm_actividades.actividad","n.persona_id")
        ->get();

        foreach ($notas as $record)
        {
            $index = $record['persona_id'];
            if($record['actividad']=='AI'){
                $this->tblrecords[$index]['ai'] = $record['nota'];
            }else{
                $this->tblrecords[$index]['ag'] = $record['nota'];
            }
            $this->tblrecords[$index]['promedio'] = ($this->tblrecords[$index]['ai']+$this->tblrecords[$index]['ag'])/2;
        }
        
        $registro = count($this->tblrecords)-1;
        $totalAI = (array_sum(array_column( $this->tblrecords,'ai')));
        $totalAG = (array_sum(array_column( $this->tblrecords,'ag')));
        $this->tblrecords['X']['ai'] = $totalAI/$registro;
        $this->tblrecords['X']['ag'] = $totalAG/$registro;

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

        foreach ($this->tblrecords as $index => $data){

            $personaId = $this->tblrecords[$index]['personaId'];

            foreach ($this->tblactividad as $actividad)
            {
                $actidadId = $actividad['id'];
                $nota = $this->tblrecords[$index][$actidadId]; 
                $idnota =  $this->tblrecords[$index]['id']; 

                if ($personaId>0){
                
                    if ($idnota>0){

                        $record = TdCalificacionActividades::find($idnota);
                        $record->update([
                            'nota' => $nota,
                        ]);

                    }else{
                        
                        TdCalificacionActividades::Create([
                            'actividad_id' => $actidadId,
                            'persona_id' => $personaId,
                            'nota' => $nota,
                            'usuario' => auth()->user()->name,
                            'estado' => 'A',
                        ]);

                    }
    
                }
            }

        }
        
        $message = "Calificaciones grabada con Éxito......";
        $this->dispatchBrowserEvent('msg-grabar', ['newName' => $message]);

    }
    
}
