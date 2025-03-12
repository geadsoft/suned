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

use App\Exports\CalificacionesDetalladas;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\Exportable;


class VcReportQuarterlyTeacher extends Component
{
    use Exportable;

    public $nivel,$subtitulo="",$docente="",$materia="",$curso="", $periodolectivo="";
    public $asignaturaId=0, $fechaActual, $horaactual, $datos, $colspan=3;

    public $tblasignatura=[];
    public $tblparalelo=[];
    public $tblexamen=[];
    public $tblrecords=[];
    public $personas=[];
    public $tblgrupo=[];

    public $filters=[
        'docenteId' => 0,
        'paralelo' => 0, 
        'termino' => '3T',
        'bloque' => '1P',
        'actividad' => 'AI',
    ];

    public function mount()
    {

        $this->filters['docenteId'] = auth()->user()->personaId;
        $this->fechaActual = date("d/m/Y");
        $this->horaActual  = date("H:i:s");

        $periodo = TmPeriodosLectivos::where("estado","A")
        ->first();
        $this->periodolectivo = "Periodo Lectivo ".$periodo['descripcion'];

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
        ->where("d.docente_id",$this->filters['docenteId'])
        ->selectRaw('m.id, m.descripcion')
        ->groupBy('m.id','m.descripcion')
        ->get();

        $this->tblparalelo = TmHorarios::query()
        ->join("tm_servicios as s","s.id","=","tm_horarios.servicio_id")
        ->join("tm_cursos as c","c.id","=","tm_horarios.curso_id")
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as m","m.id","=","d.asignatura_id")
        ->where("d.docente_id",$this->filters['docenteId'])
        ->where("m.id",$this->asignaturaId)
        ->selectRaw('d.id, concat(s.descripcion," ",c.paralelo) as descripcion')
        ->get();

        return view('livewire.vc-report-quarterly-teacher');
    }

    public function updatedasignaturaId($id){

        $this->tblparalelo = TmHorarios::query()
        ->join("tm_servicios as s","s.id","=","tm_horarios.servicio_id")
        ->join("tm_cursos as c","c.id","=","tm_horarios.curso_id")
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as m","m.id","=","d.asignatura_id")
        ->where("d.docente_id",$this->filters['docenteId'])
        ->where("m.id",$id)
        ->selectRaw('d.id, concat(s.descripcion," ",c.paralelo) as descripcion')
        ->get();

    }

    public function actividad(){

        $record = TmActividades::query()
        ->when($this->filters['paralelo'],function($query){
            return $query->where('paralelo',"{$this->filters['paralelo']}");
        })
        ->when($this->filters['termino'],function($query){
            return $query->where('termino',"{$this->filters['termino']}");
        })
        ->selectRaw("id,nombre,actividad,puntaje")
        ->where("tipo","AC")
        ->where("docente_id",$this->filters['docenteId'])
        ->orderByRaw("actividad desc")
        ->get();

        $this->colspan = $this->colspan+count($record)+2;
        return  $record;

    }


    public function examenes(){

        $record = TmActividades::query()
        ->when($this->filters['paralelo'],function($query){
            return $query->where('paralelo',"{$this->filters['paralelo']}");
        })
        ->when($this->filters['termino'],function($query){
            return $query->where('termino',"{$this->filters['termino']}");
        })
        ->selectRaw("id,nombre,actividad,puntaje")
        ->where("tipo","ET")
        ->where("docente_id",$this->filters['docenteId'])
        ->orderByRaw("actividad desc")
        ->get();

        return  $record;

    }

    public function consulta(){

        $docente = TmPersonas::find($this->filters['docenteId']);
        $this->fechaActual = date("d/m/Y");
        $this->horaActual  = date("H:i:s");

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

        $this->nivel = $titulo['nivel'];
        $this->subtitulo = "Periodo Lectivo ".$periodo['descripcion'].'/Tercer Trimestre - Primer Parcial';
        $this->docente=$docente['apellidos'].' '.$docente['nombres'];
        $this->materia = $titulo['asignatura'];
        $this->curso = $titulo['servicio'].' '.$titulo['paralelo'];
            
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

        /*Actividades*/
        $record = $this->actividad();
        $this->tblgrupo = $record->groupBy('actividad')->toBase();


        /*Examenes*/
        $this->tblexamen = $this->examenes();


        // Datos Estudiantes
        foreach ($this->personas as $key => $data)
        {   
            $index = $data->id;
            $this->tblrecords[$key]['id'] = 0;
            $this->tblrecords[$key]['personaId'] = $data->id;
            $this->tblrecords[$key]['nui'] = $data->identificacion;
            $this->tblrecords[$key]['nombres'] = $data->apellidos.' '.$data->nombres;
           
            foreach ($this->tblgrupo as $key2 => $grupo){

                foreach ($grupo as $key3 => $actividad){
                    $col = $key2.$key3;
                    $this->tblrecords[$key][$col] = 0.00;                   
                }
                $col = $key2."-prom";
                $this->tblrecords[$key][$col] = 0;
            }

            $this->tblrecords[$key]['promedio'] = 0.00;
            $this->tblrecords[$key]['prom70'] = 0.00;

            foreach ($this->tblexamen as $col => $actividad)
            {
                $column = 'ex'.$col;
                $this->tblrecords[$key][$column] = 0.00;    
            }

            $this->tblrecords[$key]['prom30'] = 0.00;
            $this->tblrecords[$key]['cuanti'] = 0.00;
            $this->tblrecords[$key]['cuali'] = "";
        }

        
        $this->tblrecords['ZZ']['id'] = 0;
        $this->tblrecords['ZZ']['personaId'] = 0;
        $this->tblrecords['ZZ']['nui'] = '';
        $this->tblrecords['ZZ']['nombres'] = 'PROMEDIO DEL CURSO';

        foreach ($this->tblgrupo as $key2 => $grupo){

            foreach ($grupo as $key3 => $actividad){
                $col = $key2.$key3;
                $this->tblrecords['ZZ'][$col] = 0.00;                   
            }
            $col = $key2."-prom";
            $this->tblrecords['ZZ'][$col] = 0;
        }
        $this->tblrecords['ZZ']['promedio'] = 0.00;
        $this->tblrecords['ZZ']['prom70'] = "";

        foreach ($this->tblexamen as $col => $actividad)
        {
            $column = 'ex'.$col;
            $this->tblrecords['ZZ'][$column] = 0.00;    
        }
        $this->tblrecords['ZZ']['prom30'] = 0.00;

        $this->tblrecords['ZZ']['cuanti'] = 0.00;
        $this->tblrecords['ZZ']['cuali'] = "";

        
    }

    public function asignarNotas(){

        foreach ($this->personas as $key => $data)
        {
            $personaId =  $data->id;
            $promedio  = 0; 
            $notafinal = 0;

            /* Actividad */ 
            foreach ($this->tblgrupo as $key2 => $grupo){

                $suma = 0;

                foreach ($grupo as $key3 => $actividad){
                   
                    $actividadId =  $actividad['id'];

                    $notas = TdCalificacionActividades::query()
                    ->where('actividad_id',$actividadId)
                    ->where("persona_id",$personaId)
                    ->first();

                    /*$notas = TmActividades::query()
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
                    ->where("docente_id",$this->filters['docenteId'])
                    ->where("actividad_id",$actividadId)
                    ->where("persona_id",$personaId)
                    ->select("n.*")
                    ->first();*/
                                        
                    $nota =  $notas['nota'];
                    $col = $key2.$key3;
                    $this->tblrecords[$key][$col] = floatval($nota);
                    $suma = $suma + floatval($nota);
                }
                $col = $key2."-prom";
                $this->tblrecords[$key][$col] = $suma/($key3+1);
                $promedio = $promedio+$suma/($key3+1);
            }
            if ($promedio>0){
                $this->tblrecords[$key]['promedio'] = $promedio/count($this->tblgrupo);
                $this->tblrecords[$key]['prom70'] = round(($promedio/count($this->tblgrupo))*0.70,2);
                $notafinal = $notafinal+round(($promedio/count($this->tblgrupo))*0.70,2);
            }

            /*Examenes*/
            foreach ($this->tblexamen as $col => $actividad)
            {
                $examenId =  $actividad['id'];
                $column = 'ex'.$col;
                
                $record = TdCalificacionActividades::query()
                ->where('actividad_id',$examenId)
                ->where("persona_id",$personaId)
                ->first();

                /*$notas = TmActividades::query()
                ->join('td_calificacion_actividades as n','n.actividad_id','=','tm_actividades.id')
                ->where('paralelo',"{$this->filters['paralelo']}")
                ->where('termino',"{$this->filters['termino']}")
                ->where('actividad',"{$this->filters['actividad']}");
                ->where("tipo","ET")
                ->where("docente_id",$this->filters['docenteId'])
                ->where("actividad_id",$examenId)
                ->where("persona_id",$personaId)
                ->select("n.*")
                ->first();*/ 

                $nota =  $record['nota'];
                $this->tblrecords[$key][$column] = floatval($nota);
                $this->tblrecords[$key]['prom30'] = round(floatval($nota)*0.30,2);
                $notafinal = $notafinal+round(floatval($nota)*0.30,2);
            }

            $this->tblrecords[$key]['cuanti'] = $notafinal;
            $this->tblrecords[$key]['cuali'] = "";
            
        }

        foreach ($this->tblgrupo as $key2 => $grupo){
            $col = $key2."-prom";
            $valor = (array_sum(array_column($this->tblrecords,$col)));
            $this->tblrecords['ZZ'][$col] = $valor/count($this->personas);
        }

        $valor = (array_sum(array_column($this->tblrecords,'promedio')));
        $this->tblrecords['ZZ']['promedio'] = $valor/count($this->personas);
        
        foreach ($this->tblexamen as $col => $actividad)
        {
            $col = 'ex'.$col;
            $valor = (array_sum(array_column($this->tblrecords,$col)));
            $this->tblrecords['ZZ'][$col] = $valor/count($this->personas);
        }

        $valor = (array_sum(array_column($this->tblrecords,'prom70')));
        $this->tblrecords['ZZ']['prom70'] = round($valor/count($this->personas),2);

        $valor = (array_sum(array_column($this->tblrecords,'prom30')));
        $this->tblrecords['ZZ']['prom30'] = round($valor/count($this->personas),2);

        $valor = (array_sum(array_column($this->tblrecords,'cuanti')));
        $this->tblrecords['ZZ']['cuanti'] = round($valor/count($this->personas),2);

        $this->datos = json_encode($this->filters);

    }

    public function reporte(){


        $tblactividad = $this->actividad();
        $tblgrupo = $tblactividad->groupBy('actividad')->toBase();

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
           
            foreach ($tblgrupo as $key2 => $grupo){

                foreach ($grupo as $key3 => $actividad){
                    $col = $key2.$key3;
                    $tblrecords[$key][$col] = 0.00;                   
                }
                $col = $key2."-prom";
                $tblrecords[$key][$col] = 0;
            }

            $tblrecords[$key]['promedio'] = 0.00;
            $tblrecords[$key]['cualitativa'] = "";
            $tblrecords[$key]['recomendacion'] = "";
            $tblrecords[$key]['planmejora'] = "";
        }

        $tblrecords['ZZ']['id'] = 0;
        $tblrecords['ZZ']['personaId'] = 0;
        $tblrecords['ZZ']['nui'] = '';
        $tblrecords['ZZ']['nombres'] = 'PROMEDIO DEL CURSO';

        foreach ($tblgrupo as $key2 => $grupo){

            foreach ($grupo as $key3 => $actividad){
                $col = $key2.$key3;
                $this->tblrecords['ZZ'][$col] = 0.00;                   
            }
            $col = $key2."-prom";
            $tblrecords['ZZ'][$col] = 0;
        }

        $tblrecords['ZZ']['promedio'] = 0.00;
        $tblrecords['ZZ']['cualitativa'] = "";
        $tblrecords['ZZ']['recomendacion'] = "";
        $tblrecords['ZZ']['planmejora'] = "";


        // Asigna Notas //
        foreach ($personas as $key => $data)
        {
            $personaId =  $data->id;
            $promedio  = 0; 

            foreach ($tblgrupo as $key2 => $grupo){

                $suma = 0;

                foreach ($grupo as $key3 => $actividad){
                   
                    $actividadId =  $actividad['id'];

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
                    ->where("docente_id",$this->filters['docenteId'])
                    ->where("actividad_id",$actividadId)
                    ->where("persona_id",$personaId)
                    ->select("n.*")
                    ->first();
                                        
                    $nota =  $notas['nota'];
                    $col = $key2.$key3;
                    $tblrecords[$key][$col] = floatval($nota);
                    $suma = $suma + floatval($nota);
                }
                $col = $key2."-prom";
                $tblrecords[$key][$col] = $suma/($key3+1);
                $promedio = $promedio+$suma/($key3+1);
            }
            if ($promedio>0){
                $tblrecords[$key]['promedio'] = $promedio/count($tblgrupo);
            }
            
        }

        foreach ($tblgrupo as $key2 => $grupo){
            $col = $key2."-prom";
            $valor = (array_sum(array_column($tblrecords,$col)));
            $tblrecords['ZZ'][$col] = $valor/count($personas);
        }

        $valor = (array_sum(array_column($tblrecords,'promedio')));
        $tblrecords['ZZ']['promedio'] = $valor/count($personas);

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
            'periodolectivo' => $periodo['descripcion'],
        ];
       
        $tblactividad = $this->actividad();
        $tblgrupo = $tblactividad->groupBy('actividad')->toBase();

        $tblrecords = $this->reporte();

        $pdf = PDF::loadView('pdf/reporte_informe_trimestral',[
            'tblrecords' => $tblrecords,
            'tblgrupo' => $tblgrupo,
            'datos' => $datos,
            'fechaActual' => $fechaActual,
            'horaActual' => $horaActual,
        ]);

        return $pdf->setPaper('a4')->stream('Informe Docente Trimestral.pdf');
    }

}
