<?php

namespace App\Http\Livewire;
use App\Models\TdPeriodoSistemaEducativos;
use App\Models\TmPeriodosLectivos;
use App\Models\TmHorarios;
use App\Models\TmPersonas;
use App\Models\TmActividades;
use App\Models\TmGeneralidades;
use App\Models\TmCursos;

use Livewire\Component;
use PDF;

class VcReportCard extends Component
{
    public $periodoId, $modalidadId=0, $tblpersonas, $datos;
    public $arrtipo=[];
    public $tblbloque=[];
    public $tblparalelo=[];
    public $tblescala=[];
    
    public $filters=[
        'periodoId' => 0,
        'modalidadId' => 0,
        'paralelo' => 0, 
        'termino' => '1T',
        'bloque' => '1P',
        'estudianteId' => 0,
    ];

    public function mount()
    {

        $this->fechaActual = date("d/m/Y");
        $this->horaActual  = date("H:i:s");

        //$this->personaId = auth()->user()->personaId;

        $periodo = TmPeriodosLectivos::where("aperturado",1)->first();
        $this->periodoId = $periodo['id'];
        $this->filters['periodoId'] = $this->periodoId;
        
        $this->tblescala = TdPeriodoSistemaEducativos::query()
        ->where("periodo_id",$this->periodoId)
        ->where("tipo","EC")
        ->get();

        $tipoactividad = TdPeriodoSistemaEducativos::query()
        ->where("periodo_id",$this->periodoId)
        ->where("tipo","AC")
        ->get();

        foreach ($tipoactividad as $objarr){
            $this->arrtipo[$objarr->codigo] = $objarr->descripcion;
        }
    
        $this->tbltermino = TdPeriodoSistemaEducativos::query()
        ->where('periodo_id',$this->periodoId)
        ->where('tipo','EA')
        ->get();

        $this->termino = $this->tbltermino[0]['codigo'];

        //$this->add();
        //$this->asignarNotas()
        
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

        $this->tblpersonas = TmPersonas::query()
        ->join("tm_matriculas as m","m.estudiante_id","=","tm_personas.id")
        ->select("tm_personas.*","m.documento")
        ->where("m.curso_id",$this->filters['paralelo'])
        ->where("m.modalidad_id",$this->modalidadId)
        ->where("m.periodo_id",$this->periodoId)
        ->orderBy("tm_personas.apellidos")
        ->get();

        $this->filters['modalidadId'] = $this->modalidadId;
        
        return view('livewire.vc-report-card');
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

    public function add(){

        $this->tblrecords=[];

        $this->asignaturas = TmHorarios::query()
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as a","a.id","=","d.asignatura_id")
        ->select("a.*")
        ->where("tm_horarios.curso_id",$this->filters['paralelo'])
        ->orderBy("a.descripcion")
        ->get();

        foreach ($this->tblpersonas as $key => $person)
        { 
            $idPerson = $person->id;

            // Actualiza Datos Asignaturas
            foreach ($this->asignaturas as $key => $data)
            {   
                $index = $data->id;
                $this->tblrecords[$idPerson][$index]['id'] = 0;
                $this->tblrecords[$idPerson][$index]['asignaturaId'] = $data->id;
                $this->tblrecords[$idPerson][$index]['nombres'] = strtoupper($data->descripcion);
                        
                $record = $this->actividad($data->id);
                $this->tblgrupo = $record->groupBy('actividad')->toBase();
                
                foreach ($this->tblgrupo as $key2 => $grupo){

                    foreach ($grupo as $key3 => $actividad){
                        $col = $key2.$actividad->id;
                        $this->tblrecords[$idPerson][$index][$col] = 0.00;                   
                    }
                    $col = $key2."-prom";
                    $this->tblrecords[$idPerson][$index][$col] = 0;
                }

                $this->tblrecords[$idPerson][$index]['promedio'] = 0.00;
                $this->tblrecords[$idPerson][$index]['nota70'] = 0.00;
                $this->tblrecords[$idPerson][$index]['examen'] = 0.00;
                $this->tblrecords[$idPerson][$index]['nota30'] = 0.00;
                $this->tblrecords[$idPerson][$index]['cuantitativo'] = "";
                $this->tblrecords[$idPerson][$index]['cualitativo'] = "";
            }
            /*$this->tblrecords[$idPerson]['ZZ']['id'] = 0;
            $this->tblrecords[$idPerson]['ZZ']['personaId'] = 0;
            $this->tblrecords[$idPerson]['ZZ']['nui'] = '';
            $this->tblrecords[$idPerson]['ZZ']['nombres'] = 'PROMEDIO DEL CURSO';*/

            /*foreach ($this->tblgrupo as $key2 => $grupo){

                foreach ($grupo as $key3 => $actividad){
                    $col = $key2.$actividad->id;
                    $this->tblrecords[$idPerson]['ZZ'][$col] = 0.00;                   
                }
                $col = $key2."-prom";
                $this->tblrecords['ZZ'][$col] = 0;
            }*/

           /* $this->tblrecords[$idPerson]['ZZ']['promedio'] = 0.00;
            $this->tblrecords[$idPerson]['ZZ']['nota70'] = 0.00;
            $this->tblrecords[$idPerson]['ZZ']['examen'] = 0.00;
            $this->tblrecords[$idPerson]['ZZ']['nota30'] = 0.00;
            $this->tblrecords[$idPerson]['ZZ']['cuantitativo'] = "";
            $this->tblrecords[$idPerson]['ZZ']['cualitativo'] = "";*/
            
            //dd($this->tblrecords);
        } 
        
        $this->datos = json_encode($this->filters);
    }


    public function asignarNotas(){

        $this->tblgrupo  = TmActividades::query()
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
        ->selectRaw("tm_actividades.actividad")
        ->where("tipo","AC")
        ->groupBy("tm_actividades.actividad")
        ->get();

        
        foreach ($this->tblpersonas as $key => $person){

            $idPerson = $person->id;
            $this->filters['estudianteId'] = $idPerson;

            //Asignar Notas Actividad
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

            foreach ($notas as $key => $objnota){

                $fil  = $objnota->asignatura_id;
                $tipo = $objnota->actividad;
                $actividadId = $objnota->actividadId;
                $col = $tipo.$actividadId;

                if (isset($this->tblrecords[$idPerson][$fil][$col])) {
                    $this->tblrecords[$idPerson][$fil][$col] = $objnota->nota;
                }
            }

            //Asginar Nota Examen
            $examen = TmActividades::query()
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
            ->where('tm_actividades.tipo', 'ET')
            ->where('n.persona_id', $this->filters['estudianteId'])
            ->select([
                'tm_actividades.id as actividadId',
                'tm_actividades.actividad',
                'n.nota',
                'd.asignatura_id'
            ])
            ->get();

            foreach ($examen as $key => $objnota){

                $fil  = $objnota->asignatura_id;
                $tipo = $objnota->actividad;
                $actividadId = $objnota->actividadId;
                $col = $tipo.$actividadId;

                if (isset($this->tblrecords[$idPerson][$fil]['examen'])) {
                    $this->tblrecords[$idPerson][$fil]['examen'] = $objnota->nota;
                }
            }


            //Calcula Totales
            foreach ($this->asignaturas as $key => $data){
                $materias[] = $data->id;
            }    

            foreach ($materias as $key => $data) {

                //dump("Iterando ID: $data (tipo: " . gettype($data) . ")");
                
                $record = $this->tblrecords[$idPerson][$data];
                $promedio = 0;
                $countprm = 0;
                
                foreach ($this->tblgrupo as $grupo){

                    $suma  = 0;
                    $count = 0;
                    $key2 = $grupo->actividad;

                    foreach ($record as $campo => $recno){
                    
                        $ncampo = substr($campo, 0, 2); 
                        if ($ncampo==$key2){
                            $suma += $recno;
                            $count += 1;
                        }
                    }                

                    $col = $key2."-prom";
                    if ($count > 0){
                        $this->tblrecords[$idPerson][$data][$col] = $suma/($count-1);
                        $promedio += $suma/($count-1);
                        $countprm += 1;
                    }
                    
                }

                if ($countprm > 0){
                    $this->tblrecords[$idPerson][$data]['promedio'] = $promedio/($countprm);  
                }

                $nota70 = $this->tblrecords[$idPerson][$data]['promedio']*0.70;
                $nota30 = $this->tblrecords[$idPerson][$data]['examen']*0.30;
                
                $this->tblrecords[$idPerson][$data]['nota70'] = $nota70;
                $this->tblrecords[$idPerson][$data]['nota30'] = $nota30;
                $this->tblrecords[$idPerson][$data]['cuantitativo'] = $nota70+$nota30; 

                $promedio = $nota70+$nota30; 
                
                foreach ($this->tblescala as $escala) {

                    $nota1 = ($escala->nota-1)+0.01; 
                    $nota2 = $escala->nota;
                    $letra = $escala->evaluacion;

                    if ($promedio >= $nota1 && $promedio <= $nota2) {
                        $this->tblrecords[$idPerson][$data]['cualitativo'] = $letra;
                    }
                    
                }
            
            }
        
        }

    }

    public function printPDF($objdata)
    {   
        $data = json_decode($objdata);
        $this->filters['periodoId']   = $data->periodoId;
        $this->filters['modalidadId']   = $data->modalidadId;
        $this->filters['paralelo'] = $data->paralelo;
        $this->filters['termino']   = $data->termino;
        $this->filters['bloque']  = $data->bloque;
        $this->filters['estudianteId'] = $data->estudianteId;

        $asignaturas = TmHorarios::query()
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as a","a.id","=","d.asignatura_id")
        ->select("a.*")
        ->where("tm_horarios.curso_id",$this->filters['paralelo'])
        ->orderBy("a.descripcion")
        ->get();

        $this->tblpersonas = TmPersonas::query()
        ->join("tm_matriculas as m","m.estudiante_id","=","tm_personas.id")
        ->select("tm_personas.*","m.documento")
        ->where("m.curso_id",$this->filters['paralelo'])
        ->where("m.modalidad_id",$this->filters['modalidadId'])
        ->where("m.periodo_id",$this->filters['periodoId'])
        ->when(!empty($this->filters['estudianteId']), function($query) {
                return $query->where('tm_personas.id', $this->filters['estudianteId']);
            })
        ->orderBy("tm_personas.apellidos")
        ->get();

        $escalas = TdPeriodoSistemaEducativos::query()
        ->where("periodo_id",$this->filters['periodoId'])
        ->where("tipo","EC")
        ->get()->toArray();

        // Definimos los rangos
        $rangos = [
            ["min" => 9, "max" => 10, "codigo" => "DA", "desc" => "Domina los aprendizajes"],
            ["min" => 7, "max" => 8.99, "codigo" => "AA", "desc" => "Alcanza los aprendizajes"],
            ["min" => 5, "max" => 6.99, "codigo" => "PA", "desc" => "Está próximo a alcanzar"],
            ["min" => 1, "max" => 4.99, "codigo" => "NA", "desc" => "No alcanza los aprendizajes"]
        ];

        // Agrupamos las notas según el rango
        $arrescala = [];
        foreach ($rangos as $r) {
            $arrescala[] = [
                "rango" => "{$r['min']} - {$r['max']}",
                "codigo" => $r["codigo"],
                "desc" => $r["desc"],
                "notas" => array_column(
                    array_filter($escalas, function($n) use ($r) {
                        return $n["nota"] >= $r["min"] && $n["nota"] <= $r["max"];
                    }),
                    "nota"
                )
            ];
        }

        $this->add();
        $this->asignarNotas();

        $periodo = TmPeriodosLectivos::find($this->filters['periodoId']);

        $curso = TmCursos::query()
        ->join("tm_servicios as s","s.id","=","tm_cursos.servicio_id")
        ->join("tm_generalidades as g","g.id","=","s.modalidad_id")
        ->where("tm_cursos.id",$this->filters['paralelo'])
        ->select("s.descripcion","tm_cursos.paralelo","g.descripcion as nivel")
        ->first();

        $datos = [
            'nivel' => $curso['nivel'],
            'subtitulo' => "Periodo Lectivo ".$periodo['descripcion'].' / Tercer Trimestre - Primer Parcial',
            'curso' => $curso['descripcion'].' '.$curso['paralelo'],
        ];

        $this->fechaActual = date("d/m/Y");
        $this->horaActual  = date("H:i:s");
        $notaParcial = $periodo->evaluacion_formativa;
        $notaExamen = $periodo->evaluacion_sumativa;


        $pdf = PDF::loadView('pdf/reporte_boletin_notas',[
            'tblrecords' => $this->tblrecords,
            'asignaturas' => $asignaturas,
            'tblpersons' => $this->tblpersonas,
            'datos' => $datos,
            'fechaActual' => $this->fechaActual,
            'horaActual' => $this->horaActual,
            'notaParcial' => $notaParcial,
            'notaExamen' => $notaExamen,
            'arrescala' => $arrescala,
        ]);

        return $pdf->setPaper('a4','landscape')->stream('Informe Aprendizaje.pdf');

    }

    public function imprimir($id){

        $this->filters['estudianteId'] = $id;
        $this->datos = json_encode($this->filters);
        
        $this->dispatchBrowserEvent('abrir-pdf', ['url' => "/preview-pdf/report-card/{$this->datos}"]);         
    }


}
