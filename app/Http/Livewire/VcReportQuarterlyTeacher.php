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


class VcReportQuarterlyTeacher extends Component
{
    use Exportable;

    public $nivel,$subtitulo="",$docente="",$materia="",$curso="", $periodolectivo="";
    public $asignaturaId=0, $fechaActual, $horaactual, $datos, $colspan=3, $cursoId;

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

        /*Actividades*/
        $record = $this->actividad();
        $this->tblgrupo = $record->groupBy('actividad')->toBase();


        /*Examenes*/
        $this->tblexamen = $this->examenes();

        foreach ($this->personas as $key => $data)
        {   
            $personaId = $data['id'];
            $this->tblrecords[$personaId]['id'] = 0;
            $this->tblrecords[$personaId]['personaId'] = $data->id;
            $this->tblrecords[$personaId]['nui'] = $data->identificacion;
            $this->tblrecords[$personaId]['nombres'] = $data->apellidos.' '.$data->nombres;
        
            foreach ($this->tblgrupo as $key2 => $grupo){

                foreach ($grupo as $key3 => $actividad){
                    $col = $key2.$actividad['id'];
                    $this->tblrecords[$personaId][$col] = 0.00;                   
                }
                $col = $key2."-prom";
                $this->tblrecords[$personaId][$col] = 0;
            }

            $this->tblrecords[$personaId]['promedio'] = 0.00;
            $this->tblrecords[$personaId]['prom70'] = 0.00;

            foreach ($this->tblexamen as $col => $actividad)
            {
                $column = 'EX'.$actividad['id'];
                $this->tblrecords[$personaId][$column] = 0.00;    
            }

            $this->tblrecords[$personaId]['prom30'] = 0.00;
            $this->tblrecords[$personaId]['cuanti'] = 0.00;
            $this->tblrecords[$personaId]['cuali'] = "";

        }
        
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
        ->where("docente_id",$this->filters['docenteId'])
        ->selectRaw("n.*,tm_actividades.actividad")
        ->get();

        if ($notas!=null){
            
            $grupo = $notas->groupBy('actividad')->toBase();
            
            foreach ($grupo as $key => $data){
                foreach ($data as $recno){
                    $personaId = $recno['persona_id'];
                    $col = $key.$recno['actividad_id'];
                    $this->tblrecords[$personaId][$col] = $recno['nota'];                   
                }
    
            }

        }

        /* Totales */
        foreach ($this->personas as $key => $data)
        { 
            $personaId = $data['id'];
            $promedio  = 0; 
            $notafinal = 0;

            foreach ($this->tblgrupo as $key2 => $grupo){

                $suma = 0;
                foreach ($grupo as $key3 => $actividad){
                    $col = $key2.$actividad['id'];
                    $nota = $this->tblrecords[$personaId][$col];
                    $suma = $suma + floatval($nota);
                }
                $col = $key2."-prom";
                $this->tblrecords[$personaId][$col] = $suma/($key3+1);
                $promedio = $promedio+$suma/($key3+1);
                
            }
            if ($promedio>0){
                $this->tblrecords[$personaId]['promedio'] = $promedio/count($this->tblgrupo);
                $this->tblrecords[$personaId]['prom70'] = round(($promedio/count($this->tblgrupo))*0.70,2);
                $notafinal = $notafinal+round(($promedio/count($this->tblgrupo))*0.70,2);
            }

            foreach ($this->tblexamen as $actividad)
            {
                $col = 'EX'.$actividad['id'];
                $nota = $this->tblrecords[$personaId][$col];
                $this->tblrecords[$personaId]['prom30'] = round(floatval($nota)*0.30,2);
                $notafinal = $notafinal+round(floatval($nota)*0.30,2);
            }

            $this->tblrecords[$personaId]['cuanti'] = $notafinal;
            $this->tblrecords[$personaId]['cuali'] = "";
        }
        
        array_multisort(array_column($this->tblrecords, 'nombres'), SORT_ASC, $this->tblrecords);

        
        $this->tblrecords['ZZ']['id'] = 0;
        $this->tblrecords['ZZ']['personaId'] = 0;
        $this->tblrecords['ZZ']['nui'] = '';
        $this->tblrecords['ZZ']['nombres'] = 'PROMEDIO DEL CURSO';

        foreach ($this->tblgrupo as $key2 => $grupo){
            $col = $key2."-prom";
            $valor = (array_sum(array_column($this->tblrecords,$col)));
            $this->tblrecords['ZZ'][$col] = $valor/count($this->personas);
        }

        $valor = (array_sum(array_column($this->tblrecords,'promedio')));
        $this->tblrecords['ZZ']['promedio'] = $valor/count($this->personas);
        
        foreach ($this->tblexamen as $col => $actividad)
        {
            $col = 'EX'.$actividad['id'];
            $valor = (array_sum(array_column($this->tblrecords,$col)));
            $this->tblrecords['ZZ'][$col] = $valor/count($this->personas);
        }

        $valor = (array_sum(array_column($this->tblrecords,'prom70')));
        $this->tblrecords['ZZ']['prom70'] = round($valor/count($this->personas),2);

        $valor = (array_sum(array_column($this->tblrecords,'prom30')));
        $this->tblrecords['ZZ']['prom30'] = round($valor/count($this->personas),2);

        $valor = (array_sum(array_column($this->tblrecords,'cuanti')));
        $this->tblrecords['ZZ']['cuanti'] = round($valor/count($this->personas),2);
        $this->tblrecords['ZZ']['cuali'] = "";

        $this->datos = json_encode($this->filters);

    }

    public function reporte(){

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

        /*Actividades*/
        $record = $this->actividad();
        $this->tblgrupo = $record->groupBy('actividad')->toBase();

        /*Examenes*/
        $tblexamen = $this->examenes();

        foreach ($this->personas as $key => $data)
        {   
            $personaId = $data['id'];
            $tblrecords[$personaId]['id'] = 0;
            $tblrecords[$personaId]['personaId'] = $data->id;
            $tblrecords[$personaId]['nui'] = $data->identificacion;
            $tblrecords[$personaId]['nombres'] = $data->apellidos.' '.$data->nombres;
        
            foreach ($tblgrupo as $key2 => $grupo){

                foreach ($grupo as $key3 => $actividad){
                    $col = $key2.$actividad['id'];
                    $tblrecords[$personaId][$col] = 0.00;                   
                }
                $col = $key2."-prom";
                $tblrecords[$personaId][$col] = 0;
            }

            $tblrecords[$personaId]['promedio'] = 0.00;
            $tblrecords[$personaId]['prom70'] = 0.00;

            foreach ($tblexamen as $col => $actividad)
            {
                $column = 'EX'.$actividad['id'];
                $tblrecords[$personaId][$column] = 0.00;    
            }

            $tblrecords[$personaId]['prom30'] = 0.00;
            $tblrecords[$personaId]['cuanti'] = 0.00;
            $tblrecords[$personaId]['cuali'] = "";

        }

        /* Asignar Notas*/
        $notas = TmActividades::query()
        ->join('td_calificacion_actividades as n','n.actividad_id','=','tm_actividades.id')
        ->when($this->filters['paralelo'],function($query){
            return $query->where('paralelo',"{$this->filters['paralelo']}");
        })
        ->when($this->filters['termino'],function($query){
            return $query->where('termino',"{$this->filters['termino']}");
        })
        ->where("docente_id",$this->filters['docenteId'])
        ->selectRaw("n.*,tm_actividades.actividad")
        ->get();

        if ($notas!=null){
            
            $grupo = $notas->groupBy('actividad')->toBase();
            
            foreach ($grupo as $key => $data){
                foreach ($data as $recno){
                    $personaId = $recno['persona_id'];
                    $col = $key.$recno['actividad_id'];
                    $tblrecords[$personaId][$col] = $recno['nota'];                   
                }
    
            }

        }

    }

    public function printPDF($objdata)
    {   
        $data=[
            'tblrecords' => $this->tblrecords,
        ];

        $pdf = PDF::loadView('pdf/reporte_informe_trimestral',$data);

        /*return $pdf->setPaper('a4')->stream('Informe Docente Trimestral.pdf');*/
        return response()->streamDownLoad(function() use($pdf){
            echo $pdf->setPaper('a4')->stream();
        },'pdf/reporte_informe_trimestral');
        
    }

}
