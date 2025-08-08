<?php

namespace App\Http\Livewire;
use App\Models\TmPersonas; 
use App\Models\TmPeriodosLectivos;
use App\Models\TmHorarios;
use App\Models\TmHorariosDocentes;
use App\Models\TmActividades;
use App\Models\TdCalificacionActividades;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use PDF;

use App\Exports\CalificacionesDetalladas;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\Exportable;

class VcReportDetailQualify extends Component
{
    
    use Exportable;

    public $nivel,$subtitulo="",$docente="",$materia="",$curso="", $cursoId;
    public $periodoId, $modalidadId, $asignaturaId=0, $fechaActual, $horaactual, $datos, $colspan=3;

    public $tblasignatura=[];
    public $tblparalelo=[];
    public $tblexamen=[];
    public $tblrecords=[];
    public $personas=[];
    public $tblgrupo=[];

    public $filters=[
        'docenteId' => 0,
        'paralelo' => 0, 
        'termino' => '1T',
        'bloque' => '1P',
        'actividad' => 'AI',
    ];

    public function mount()
    {
        
        $this->docenteId = auth()->user()->personaId;
        $this->filters['docenteId'] = auth()->user()->personaId;
        $this->fechaActual = date("d/m/Y");
        $this->horaActual  = date("H:i:s");

        $periodo = TmPeriodosLectivos::where("aperturado",1)->first();
        $this->periodoId = $periodo->id;

        $this->subtitulo = "Periodo Lectivo ".$periodo['descripcion'].'/ - ';

        if (!empty($this->tblparalelo)){
            $this->filters['paralelo'] = $this->tblparalelo[0]["id"];
            $this->consulta();
        }

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
        
        $this->tblasignatura = TmHorarios::query()
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as m","m.id","=","d.asignatura_id")
        ->where("tm_horarios.periodo_id",$this->periodoId)
        ->where('tm_horarios.grupo_id',$this->modalidadId)
        ->where("d.docente_id",$this->docenteId)
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
        
        return view('livewire.vc-report-detail-qualify');
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

    }

    public function actividad(){

        $record = TmActividades::query()
        ->when($this->filters['paralelo'],function($query){
            return $query->where('paralelo',"{$this->filters['paralelo']}");
        })
        ->when($this->filters['termino'],function($query){
            return $query->where('termino',"{$this->filters['termino']}");
        })
        ->when($this->filters['bloque'],function($query){
            return $query->where('bloque',"{$this->filters['bloque']}");
        })
        ->selectRaw("id,nombre,actividad,puntaje")
        ->where("tipo","AC")
        ->where("docente_id",$this->filters['docenteId'])
        ->orderByRaw("actividad desc")
        ->get();

        $this->colspan = $this->colspan+count($record)+2;
        return  $record;

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

        $record = $this->actividad();

        $this->tblgrupo = $record->groupBy('actividad')->toBase();
            
        $this->add();
        $this->asignarNotas();

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
        ->where('m.estado','A')
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

    public function add(){

        $this->tblrecords=[];

        $this->loadPersonas();

        /*$this->personas = TmHorariosDocentes::query()
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
        ->get();*/

        /*if (count($this->tblgrupo)>0){
            dd($this->tblgrupo);
        }*/

        // Actualiza Datos Estudiantes
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
            $this->tblrecords[$key]['cualitativa'] = "";
        }
        
    }

    public function asignarNotas(){

        foreach ($this->personas as $key => $data)
        {
            $personaId =  $data->id;
            $promedio  = 0; 

            foreach ($this->tblgrupo as $key2 => $grupo){

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
                    ->where("docente_id",$this->docenteId)
                    ->where("actividad_id",$actividadId)
                    ->where("persona_id",$personaId)
                    ->select("n.*")
                    ->first();
                    
                    $nota =  0;
                    if(!is_null($notas)){
                        $nota = $notas['nota'];
                    }

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
            }
            
        }

        $this->datos = json_encode($this->filters);
        
    }


    public function reporte(){


        $tblactividad = $this->actividad();
        $tblgrupo = $tblactividad->groupBy('actividad')->toBase();

        /* Estudiantes */
        $tblrecords=[];

        $this->loadPersonas();

        /*$personas = TmHorariosDocentes::query()
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
        ->get();*/

        foreach ($this->personas as $key => $data)
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
        }

        // Asigna Notas //
        foreach ($this->personas as $key => $data)
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
                                        
                    $nota =  0;
                    if(!is_null($notas)){
                        $nota = $notas['nota'];
                    }

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
       
        $tblactividad = $this->actividad();
        $tblgrupo = $tblactividad->groupBy('actividad')->toBase();

        $tblrecords = $this->reporte();

        $pdf = PDF::loadView('pdf/reporte_calificacion_detallada',[
            'tblrecords' => $tblrecords,
            'tblgrupo' => $tblgrupo,
            'datos' => $datos,
            'fechaActual' => $fechaActual,
            'horaActual' => $horaActual,
        ]);

        return $pdf->setPaper('a4','landscape')->stream('Calificación Detallada.pdf');
    }

    public function exportExcel(){

        $data = json_encode($this->filters);
        return Excel::download(new CalificacionesDetalladas($data), 'Calificaciones Detalladas.xlsx');

    }

}



