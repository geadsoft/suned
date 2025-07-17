<?php

namespace App\Http\Livewire;
use App\Models\TmPeriodosLectivos;
use App\Models\TmHorarios;
use App\Models\TmPersonas; 
use App\Models\TmGeneralidades;
use App\Models\TmCursos;
use App\Models\TmActividades;
use App\Models\TmHorariosDocentes;
use App\Models\TmMatricula;
use App\Models\TdPeriodoSistemaEducativos;

use Livewire\Component;

class VcStudentPartial extends Component
{
    public $nivel,$subtitulo="",$docente="",$materia="",$curso="";
    public $periodoId, $modalidadId=0, $datos;
    public $asignaturas=[];
    public $tblrecords=[];
    public $tblescala=[];
    public $tbltermino=[];

    public $filters=[
        'docenteId' => 0,
        'paralelo' => 0, 
        'termino' => '1T',
        'bloque' => '1P',
        'estudianteId' => 0,
    ];
    
    public function mount()
    {

        $this->filters['docenteId'] = auth()->user()->personaId;
        $this->fechaActual = date("d/m/Y");
        $this->horaActual  = date("H:i:s");

        $periodo = TmPeriodosLectivos::where("aperturado",1)->first();
        $this->periodoId = $periodo['id'];
        $this->periodolectivo = "Periodo Lectivo ".$periodo['descripcion'];

        $this->tblescala = TdPeriodoSistemaEducativos::query()
        ->where("periodo_id",$this->periodoId)
        ->where("tipo","EC")
        ->get();

         $this->tbltermino = TdPeriodoSistemaEducativos::query()
        ->where('periodo_id',$this->periodoId)
        ->where('tipo','EA')
        ->get();

        $this->termino = $this->tbltermino[0]['codigo'];

    }
    
    public function render()
    {
        $this->tblmodalidad = TmGeneralidades::query()
        ->where("superior",1)
        ->get();

        $this->tblbloque = TdPeriodoSistemaEducativos::query()
        ->where('periodo_id',$this->periodoId)
        ->where('tipo','PA')
        ->where('evaluacion',$this->termino)
        ->get();
        
       $this->tblparalelo = TmHorarios::query()
        ->join("tm_servicios as s","s.id","=","tm_horarios.servicio_id")
        ->join("tm_cursos as c","c.id","=","tm_horarios.curso_id")
        ->where("tm_horarios.periodo_id",$this->periodoId)
        ->where('tm_horarios.grupo_id',$this->modalidadId)
        ->selectRaw('c.id, concat(s.descripcion," ",c.paralelo) as descripcion')
        ->get();

        $this->personas = TmPersonas::query()
        ->join("tm_matriculas as m","m.estudiante_id","=","tm_personas.id")
        ->select("tm_personas.*")
        ->where("m.curso_id",$this->filters['paralelo'])
        ->where("m.modalidad_id",$this->modalidadId)
        ->where("m.periodo_id",$this->periodoId)
        ->orderBy("tm_personas.apellidos")
        ->get();
        
        return view('livewire.vc-student-partial');
    }

    

    public function actividad($id){

        $record = TmActividades::query()
        ->join("tm_horarios_docentes as d",function($join){
            $join->on("d.id","=","tm_actividades.paralelo")
                ->on("d.docente_id","=","tm_actividades.docente_id");
        })
        ->join("tm_horarios as h","h.id","=","d.horario_id")
        ->when($this->filters['paralelo'],function($query){
            return $query->where('h.curso_id',"{$this->filters['paralelo']}");
        })
        ->when($this->filters['termino'],function($query){
            return $query->where('termino',"{$this->filters['termino']}");
        })
        ->when($this->filters['bloque'],function($query){
            return $query->where('bloque',"{$this->filters['bloque']}");
        })
        ->selectRaw("tm_actividades.id,tm_actividades.nombre,tm_actividades.actividad,tm_actividades.puntaje")
        ->where("tipo","AC")
        ->where("d.asignatura_id",$id)
        ->orderByRaw("actividad desc")
        ->get();

        //$this->colspan = $this->colspan+count($record)+2;
        return  $record;

    }

    public function consulta(){

        //$docente = TmPersonas::find($this->filters['docenteId']);
        $this->fechaActual = date("d/m/Y");
        $this->horaActual  = date("H:i:s");

        $titulo = TmCursos::query()
        ->join("tm_servicios as s","s.id","=","tm_cursos.servicio_id")
        ->join("tm_generalidades as n","n.id","=","s.nivel_id")
        ->where("tm_cursos.id",$this->filters['paralelo'])
        ->selectRaw('s.descripcion as servicio,tm_cursos.paralelo, n.descripcion as nivel')
        ->first();
        
        
        /*TmHorarios::query()
        ->join("tm_servicios as s","s.id","=","tm_horarios.servicio_id")
        ->join("tm_generalidades as n","n.id","=","s.nivel_id")
        ->join("tm_cursos as c","c.id","=","tm_horarios.curso_id")
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as m","m.id","=","d.asignatura_id")
        ->where("d.docente_id",$this->filters['docenteId'])
        ->where("c.id",$this->filters['paralelo'])
        ->selectRaw('d.id, m.descripcion as asignatura,s.descripcion as servicio,c.paralelo, n.descripcion as nivel, tm_horarios.periodo_id')
        ->first();*/

        $periodo = TmPeriodosLectivos::find($this->periodoId);

        $this->nivel = $titulo['nivel'];
        $this->subtitulo = "Periodo Lectivo ".$periodo['descripcion'].'/Tercer Trimestre - Primer Parcial';
        $this->docente= ''; //$docente['apellidos'].' '.$docente['nombres'];
        $this->materia = ''; // $titulo['asignatura'];
        $this->curso = $titulo['servicio'].' '.$titulo['paralelo'];
            
        //$this->add();
        $this->asignarNotas();

    }


    public function add(){

        $this->tblrecords=[];
        
        $this->asignaturas = TmHorarios::query()
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as a","a.id","=","d.asignatura_id")
        ->select("a.*")
        ->where("tm_horarios.curso_id",$this->filters['paralelo'])
        ->orderBy("a.descripcion")
        ->get();

        // Actualiza Datos Asignaturas
        foreach ($this->asignaturas as $key => $data)
        {   
            $index = $data->id;
            $this->tblrecords[$index]['id'] = 0;
            $this->tblrecords[$index]['asignaturaId'] = $data->id;
            $this->tblrecords[$index]['nombres'] = $data->descripcion;
           
            $record = $this->actividad($data->id);
            $this->tblgrupo = $record->groupBy('actividad')->toBase();
            
            foreach ($this->tblgrupo as $key2 => $grupo){

                foreach ($grupo as $key3 => $actividad){
                    $col = $key2.$actividad->id;
                    $this->tblrecords[$index][$col] = 0.00;                   
                }
                $col = $key2."-prom";
                $this->tblrecords[$index][$col] = 0;
            }

            $this->tblrecords[$index]['promedio'] = 0.00;
            $this->tblrecords[$index]['cualitativa'] = "";
            $this->tblrecords[$index]['recomendacion'] = "";
            $this->tblrecords[$index]['planmejora'] = "";
        }
        $this->tblrecords['ZZ']['id'] = 0;
        $this->tblrecords['ZZ']['personaId'] = 0;
        $this->tblrecords['ZZ']['nui'] = '';
        $this->tblrecords['ZZ']['nombres'] = 'PROMEDIO DEL CURSO';

        foreach ($this->tblgrupo as $key2 => $grupo){

            foreach ($grupo as $key3 => $actividad){
                $col = $key2.$actividad->id;
                $this->tblrecords['ZZ'][$col] = 0.00;                   
            }
            $col = $key2."-prom";
            $this->tblrecords['ZZ'][$col] = 0;
        }

        $this->tblrecords['ZZ']['promedio'] = 0.00;
        $this->tblrecords['ZZ']['cualitativa'] = "";
        $this->tblrecords['ZZ']['recomendacion'] = "";
        $this->tblrecords['ZZ']['planmejora'] = "";
        
        //dd($this->tblrecords);
    }

    public function asignarNotas(){
                
        $notas = TmActividades::query()
        ->join('td_calificacion_actividades as n', 'n.actividad_id', '=', 'tm_actividades.id')
        ->join('tm_horarios_docentes as d', function($join) {
            $join->on('d.id', '=', 'tm_actividades.paralelo')
                ->on('d.docente_id', 'tm_actividades.docente_id');
        })
        ->when(!empty($this->filters['termino']), function($query) {
            return $query->where('tm_actividades.termino', $this->filters['termino']);
        })
        ->when(!empty($this->filters['bloque']), function($query) {
            return $query->where('tm_actividades.bloque', $this->filters['bloque']);
        })
        ->where('tm_actividades.tipo', 'AC')
        ->where('n.persona_id', $this->filters['estudianteId'])
        ->select([
            'tm_actividades.id as actividadId',
            'tm_actividades.actividad',
            'n.nota',
            'd.asignatura_id'
        ])
        ->get(); 
        
        //Asignar Notas

        foreach ($notas as $key => $record){

            $fil  = $record->asignatura_id;
            $tipo = $record->actividad;
            $actividadId = $record->actividadId;
            $col = $tipo.$actividadId;

            if (isset($this->tblrecords[$fil][$col])) {
                $this->tblrecords[$fil][$col] = $record->nota;
            }
        }

        //Calcula Totales

        foreach ($this->asignaturas as $key => $data){
            $materias[] = $data->id;
        }    

        foreach ($materias as $key => $data) {

            //dump("Iterando ID: $data (tipo: " . gettype($data) . ")");
            
            $record = $this->tblrecords[$data];
            $promedio = 0;
            $countprm = 0;
            
            foreach ($this->tblgrupo as $key2 => $grupo){

                $suma  = 0;
                $count = 0;

                foreach ($record as $campo => $recno){
                   
                    $ncampo = substr($campo, 0, 2); 
                    if ($ncampo==$key2){
                        $suma += $recno;
                        $count += 1;
                    }
                }                

                $col = $key2."-prom";
                if ($count > 0){
                    $this->tblrecords[$data][$col] = $suma/($count-1);
                    $promedio += $suma/($count-1);
                    $countprm += 1;
                }
                
            }

            if ($countprm > 0){
                $this->tblrecords[$data]['promedio'] = $promedio/($countprm);  
            }
                    
        }

        foreach ($this->tblescala as $escala) {

            $nota1 = ($escala->nota-1)+0.01; 
            $nota2 = $escala->nota;
            $letra = $escala->evaluacion;

            foreach ($this->tblrecords as $key => $record) {
                $promedio = $record['promedio'];
                if ($promedio >= $nota1 && $promedio <= $nota2) {
                    $this->tblrecords[$key]['cualitativa'] = $letra;
                }
            }

        }
               

    }

}
