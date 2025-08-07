<?php

namespace App\Http\Livewire;
use App\Models\TmPersonas; 
use App\Models\TmPeriodosLectivos;
use App\Models\TmHorarios;
use App\Models\TmHorariosDocentes;
use App\Models\TmActividades;
use App\Models\TdCalificacionActividades;
use App\Models\TdPeriodoSistemaEducativos;

use Livewire\Component;
use PDF;

use App\Exports\CalificacionesTotalesExport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\Exportable;

class VcReportTQualify extends Component
{
    
    use Exportable;

    public $nivel,$subtitulo="",$docente="",$materia="",$curso="";
    public $periodoId, $modalidadId=0, $asignaturaId=0, $fechaActual, $horaactual, $datos, $colspan=3;

    public $tblmodalidad=[];
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
        'periodoId' => 0,
    ];

    protected $listeners = ['setData'];

    public function mount()
    {
        
        $this->docenteId = auth()->user()->personaId;
        $this->filters['docenteId'] = auth()->user()->personaId;
        $this->fechaActual = date("d/m/Y");
        $this->horaActual  = date("H:i:s");

        $periodo = TmPeriodosLectivos::where("aperturado",1)->first();
        $this->filters['periodoId'] = $periodo->id;

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
        ->where("tm_horarios.periodo_id",$this->filters['periodoId'])
        ->where("d.docente_id",$this->docenteId)
        ->selectRaw('g.id, g.descripcion')
        ->groupBy('g.id','g.descripcion')
        ->get();
        
        
        $this->tblasignatura = TmHorarios::query()
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as m","m.id","=","d.asignatura_id")
        ->where("tm_horarios.periodo_id",$this->filters['periodoId'])
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
        ->where("tm_horarios.periodo_id",$this->filters['periodoId'])
        ->where('tm_horarios.grupo_id',$this->modalidadId)
        ->where("d.docente_id",$this->docenteId)
        ->where("m.id",$this->asignaturaId)       
        ->selectRaw('d.id, concat(s.descripcion," ",c.paralelo) as descripcion')
        ->get();

        return view('livewire.vc-report-t-qualify');
    }

    public function updatedasignaturaId($id){

        $this->tblparalelo = TmHorarios::query()
        ->join("tm_servicios as s","s.id","=","tm_horarios.servicio_id")
        ->join("tm_cursos as c","c.id","=","tm_horarios.curso_id")
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as m","m.id","=","d.asignatura_id")
        ->where("tm_horarios.periodo_id",$this->filters['periodoId'])
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
        $this->tblrecords['ZZ']['cualitativa'] = "";
        
        
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

        foreach ($this->tblgrupo as $key2 => $grupo){
            $col = $key2."-prom";
            $valor = (array_sum(array_column($this->tblrecords,$col)));
            $this->tblrecords['ZZ'][$col] = $valor/count($this->personas);
        }

        $valor = (array_sum(array_column($this->tblrecords,'promedio')));
        $this->tblrecords['ZZ']['promedio'] = $valor/count($this->personas);
        
        // Escala Cualitativa
        $escalas = TdPeriodoSistemaEducativos::query()
        ->where("periodo_id",$this->filters['periodoId'])
        ->where("tipo","EC")
        ->get()->toArray();
       
        foreach ($this->tblrecords as $key1 => $records){

            $promedio = $records['promedio']; 
                
            foreach ($this->tblescala as $escala) {
                
                $nota  = $escala['nota'];                  
                $letra = $escala['evaluacion'];

                if ($promedio >= ($nota-1)+0.01 && $promedio <= $nota) {
                    $this->tblrecords[$key1]['cualitativa'] = $letra;
                }
                
            }

        } 
        
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

        foreach ($tblgrupo as $key2 => $grupo){
            $col = $key2."-prom";
            $valor = (array_sum(array_column($tblrecords,$col)));
            $tblrecords['ZZ'][$col] = $valor/count($personas);
        }

        $valor = (array_sum(array_column($tblrecords,'promedio')));
        $tblrecords['ZZ']['promedio'] = $valor/count($personas);

        
        $escalas = TdPeriodoSistemaEducativos::query()
        ->where("periodo_id",$this->filters['periodoId'])
        ->where("tipo","EC")
        ->get()->toArray();


        // Escala Cualitativa
        foreach ($this->tblrecords as $key1 => $records){

            $promedio = $records['promedio']; 
                
            foreach ($this->tblescala as $escala) {
                
                $nota  = $escala['nota'];                  
                $letra = $escala['evaluacion'];

                if ($promedio >= ($nota-1)+0.01 && $promedio <= $nota) {
                    $this->tblrecords[$key1]['cualitativa'] = $letra;
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
        $this->filters['periodoId'] = $data->periodoId;
        

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

        $pdf = PDF::loadView('pdf/reporte_calificacion_total',[
            'tblrecords' => $tblrecords,
            'tblgrupo' => $tblgrupo,
            'datos' => $datos,
            'fechaActual' => $fechaActual,
            'horaActual' => $horaActual,
        ]);

        return $pdf->setPaper('a4')->stream('Calificaciones Totales.pdf');
    }

    public function exportExcel(){

        $data = json_encode($this->filters);
        return Excel::download(new CalificacionesTotalesExport($data), 'Calificaciones Totales.xlsx');

    }
    
}
