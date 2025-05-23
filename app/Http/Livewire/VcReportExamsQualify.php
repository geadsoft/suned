<?php

namespace App\Http\Livewire;
use App\Models\TmPersonas; 
use App\Models\TmPeriodosLectivos;
use App\Models\TmHorarios;
use App\Models\TmHorariosDocentes;
use App\Models\TmActividades;
use App\Models\TdCalificacionActividades;

use Livewire\Component;
use PDF;

class VcReportExamsQualify extends Component
{
    
    public $nivel,$subtitulo="",$docente="",$materia="",$curso="";
    public $asignaturaId=0, $fechaActual, $horaactual, $datos;

    public $tblasignatura=[];
    public $tblparalelo=[];
    public $tblexamen=[];
    public $tblrecords=[];
    public $personas=[];

    public $filters=[
        'docenteId' => 0,
        'paralelo' => 0, 
        'termino' => '3T',
        'bloque' => '1P',
        'actividad' => 'AI',
    ];

    protected $listeners = ['setData'];

    public function mount()
    {
        
        $this->docenteId = auth()->user()->personaId;
        $this->filters['docenteId'] = auth()->user()->personaId;
        $this->fechaActual = date("d/m/Y");
        $this->horaActual  = date("H:i:s");

        $periodo = TmPeriodosLectivos::where("estado","A")
        ->first();
        $this->subtitulo = "Periodo Lectivo ".$periodo['descripcion'].'/ - ';


        if (!empty($this->tblparalelo)){
            $this->filters['paralelo'] = $this->tblparalelo[0]["id"];
            $this->consulta();
        }

    }

    public function render()
    {
        $this->tblasignatura = TmHorarios::query()
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as m","m.id","=","d.asignatura_id")
        ->where("d.docente_id",$this->docenteId)
        ->selectRaw('m.id, m.descripcion')
        ->groupBy('m.id','m.descripcion')
        ->get();

        $this->tblparalelo = TmHorarios::query()
        ->join("tm_servicios as s","s.id","=","tm_horarios.servicio_id")
        ->join("tm_cursos as c","c.id","=","tm_horarios.curso_id")
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as m","m.id","=","d.asignatura_id")
        ->where("d.docente_id",$this->docenteId)
        ->where("m.id",$this->asignaturaId)
        ->selectRaw('d.id, concat(s.descripcion," ",c.paralelo) as descripcion')
        ->get();
        
        return view('livewire.vc-report-exams-qualify');
    }

    public function updatedasignaturaId($id){

        $this->tblparalelo = TmHorarios::query()
        ->join("tm_servicios as s","s.id","=","tm_horarios.servicio_id")
        ->join("tm_cursos as c","c.id","=","tm_horarios.curso_id")
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as m","m.id","=","d.asignatura_id")
        ->where("d.docente_id",$this->docenteId)
        ->where("m.id",$id)
        ->selectRaw('d.id, concat(s.descripcion," ",c.paralelo) as descripcion')
        ->get();

    }

    public function consulta(){

        $docente = TmPersonas::find($this->docenteId);
        $this->fechaActual = date("d/m/Y");
        $this->horaActual  = date("H:i:s");

        $titulo = TmHorarios::query()
        ->join("tm_servicios as s","s.id","=","tm_horarios.servicio_id")
        ->join("tm_generalidades as n","n.id","=","s.nivel_id")
        ->join("tm_cursos as c","c.id","=","tm_horarios.curso_id")
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as m","m.id","=","d.asignatura_id")
        ->where("d.docente_id",$this->docenteId)
        ->where("d.id",$this->filters['paralelo'])
        ->selectRaw('d.id, m.descripcion as asignatura,s.descripcion as servicio,c.paralelo, n.descripcion as nivel, tm_horarios.periodo_id')
        ->first();

        $periodo = TmPeriodosLectivos::find($titulo['periodo_id']);

        $this->nivel = $titulo['nivel'];
        $this->subtitulo = "Periodo Lectivo ".$periodo['descripcion'].'/Tercer Trimestre - Primer Parcial';
        $this->docente=$docente['apellidos'].' '.$docente['nombres'];
        $this->materia = $titulo['asignatura'];
        $this->curso = $titulo['servicio'].' '.$titulo['paralelo'];

        $this->tblexamen = TmActividades::query()
        ->when($this->filters['paralelo'],function($query){
            return $query->where('paralelo',"{$this->filters['paralelo']}");
        })
        ->when($this->filters['termino'],function($query){
            return $query->where('termino',"{$this->filters['termino']}");
        })
        ->when($this->filters['actividad'],function($query){
            return $query->where('actividad',"{$this->filters['actividad']}");
        })
        ->where("tipo","ET")
        ->where("docente_id",$this->docenteId)
        ->get();
            
        $this->add();
        $this->asignarNotas();

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
            $this->tblrecords[$key]['id'] = 0;
            $this->tblrecords[$key]['personaId'] = $data->id;
            $this->tblrecords[$key]['nui'] = $data->identificacion;
            $this->tblrecords[$key]['nombres'] = $data->apellidos.' '.$data->nombres;
           
            foreach ($this->tblexamen as $col => $actividad)
            {
                $this->tblrecords[$key][$col] = 0.00;    
            }
        }
        
    }

    public function asignarNotas(){

        foreach ($this->personas as $key => $data)
        {
            $personaId =  $data->id; 

            foreach ($this->tblexamen as $col => $actividad)
            {
                $actividadId =  $actividad['id'];
                
                /*Notas*/
                $notas = TmActividades::query()
                ->join('td_calificacion_actividades as n','n.actividad_id','=','tm_actividades.id')
                ->when($this->filters['paralelo'],function($query){
                    return $query->where('paralelo',"{$this->filters['paralelo']}");
                })
                ->when($this->filters['termino'],function($query){
                    return $query->where('termino',"{$this->filters['termino']}");
                })
                ->when($this->filters['actividad'],function($query){
                    return $query->where('actividad',"{$this->filters['actividad']}");
                })
                ->where("tipo","ET")
                ->where("docente_id",$this->docenteId)
                ->where("actividad_id",$actividadId)
                ->where("persona_id",$personaId)
                ->select("n.*")
                ->get();  

                foreach ($notas as $record)
                {
                    $nota =  $record['nota'];
                    $this->tblrecords[$key][$col] = floatval($nota); 
                }

            }
        }

        $this->datos = json_encode($this->filters);
        
    }


    public function reporte(){


        $tblexamen = TmActividades::query()
        ->where('paralelo',$this->filters['paralelo'])
        ->where('termino',$this->filters['termino'])
        ->where('actividad',$this->filters['actividad'])
        ->where("tipo","ET")
        ->where("docente_id",$this->filters['docenteId'])
        ->get();


        /* Estudiantes */
        $tblrecords=[];

        $personas = TmHorariosDocentes::query()
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

        foreach ($personas as $key => $data)
        {   
            $index = $data->id;
            $tblrecords[$key]['id'] = 0;
            $tblrecords[$key]['personaId'] = $data->id;
            $tblrecords[$key]['nui'] = $data->identificacion;
            $tblrecords[$key]['nombres'] = $data->apellidos.' '.$data->nombres;
           
            foreach ($tblexamen as $col => $actividad)
            {
                $tblrecords[$key][$col] = 0.00;    
            }
        }

        // Asigna Notas //
        foreach ($personas as $key => $data)
        {
            $personaId =  $data->id; 

            foreach ($tblexamen as $col => $actividad)
            {
                $actividadId =  $actividad['id'];
                
                /*Notas*/
                $notas = TmActividades::query()
                ->join('td_calificacion_actividades as n','n.actividad_id','=','tm_actividades.id')
                ->where('paralelo',$this->filters['paralelo'])
                ->where('termino',$this->filters['termino'])
                ->where('actividad',$this->filters['actividad'])
                ->where("tipo","ET")
                ->where("docente_id",$this->filters['docenteId'])
                ->where("actividad_id",$actividadId)
                ->where("persona_id",$personaId)
                ->select("n.*")
                ->get();  

                foreach ($notas as $record)
                {
                    $nota =  $record['nota'];
                    $tblrecords[$key][$col] = floatval($nota); 
                }

            }
        }

        return $tblrecords;

    }

    public function printPDF($objdata)
    {   

        $data = json_decode($objdata);
        $this->filters['docenteId'] = $data->docenteId;
        $this->filters['paralelo'] = $data->paralelo;
        $this->filters['termino'] = $data->termino;
        $this->filters['bloque'] = $data->bloque;
        $this->filters['actividad'] = $data->actividad;
        

        $docente = TmPersonas::find($this->filters['docenteId']);
        $fechaActual = date("d/m/Y");
        $horaActual  = date("H:i:s");

        $titulo = TmHorarios::query()
        ->join("tm_servicios as s","s.id","=","tm_horarios.servicio_id")
        ->join("tm_generalidades as n","n.id","=","s.nivel_id")
        ->join("tm_cursos as c","c.id","=","tm_horarios.curso_id")
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as m","m.id","=","d.asignatura_id")
        ->where("d.docente_id",$this->filters['docenteId'])
        ->where("d.id",$this->filters['paralelo'])
        ->selectRaw('d.id, m.descripcion as asignatura,s.descripcion as servicio,c.paralelo, n.descripcion as nivel, tm_horarios.periodo_id')
        ->first();

        $periodo = TmPeriodosLectivos::find($titulo['periodo_id']);

        $datos = [
            'nivel' => $titulo['nivel'],
            'subtitulo' => "Periodo Lectivo ".$periodo['descripcion'].' / Tercer Trimestre - Primer Parcial',
            'docente' => $docente['apellidos'].' '.$docente['nombres'],
            'materia' => $titulo['asignatura'],
            'curso' => $titulo['servicio'].' '.$titulo['paralelo'],
        ];
       
        $tblexamen = TmActividades::query()
        ->where('paralelo',$this->filters['paralelo'])
        ->where('termino',$this->filters['termino'])
        ->where('actividad',$this->filters['actividad'])
        ->where("tipo","ET")
        ->where("docente_id",$this->filters['docenteId'])
        ->get();

        $tblrecords = $this->reporte();

        $pdf = PDF::loadView('pdf/reporte_calificacion_examen',[
            'tblrecords' => $tblrecords,
            'tblexamen' => $tblexamen,
            'datos' => $datos,
            'fechaActual' => $fechaActual,
            'horaActual' => $horaActual,
        ]);

        return $pdf->setPaper('a4')->stream('Calificación de Exámenes.pdf');
    }


    
}
