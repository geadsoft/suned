<?php

namespace App\Http\Livewire;
use App\Models\TdPeriodoSistemaEducativos;
use App\Models\TmPeriodosLectivos;
use App\Models\TmHorarios;
use App\Models\TmPersonas;
use App\Models\TmActividades;
use App\Models\TmGeneralidades;
use App\Models\TmCursos;
use App\Models\TmHorariosDocentes;
use App\Models\TdObservacionActa;
use App\Models\TdConductas;
use App\Models\TdCalificacionActividades;


use Livewire\Component;
use Illuminate\Support\Facades\DB;
use PDF;

class VcReportCard extends Component
{
    public $periodoId, $modalidadId=0, $tblpersonas, $datos, $bloqueEx, $estudianteId, $mensaje="", $calificacion="N";
    public $arrComentario=[];
    public $arrtipo=[];
    public $tblbloque=[];
    public $tblparalelo=[];
    public $tblescala=[];
    public $tbltermino=[];
    
    public $filters=[
        'periodoId' => 0,
        'modalidadId' => 0,
        'paralelo' => 0, 
        'paralelo_pase' => 0,
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
        ->selectRaw("*,nota + case when nota=10 then 0 else 0.99 end as nota2")
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
        ->selectRaw('c.id, concat(s.descripcion," ",c.paralelo) as descripcion,s.calificacion')
        ->get();

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
        ->where('p.estado', 'A');

        // UNION de ambas consultas
        $unionQuery = $matriculasQuery->unionAll($pasesQuery);

        // Consulta principal con joinSub en Eloquent
        $this->tblpersonas = TmPersonas::query()
            ->joinSub($unionQuery, 'm', function ($join) {
            $join->on('tm_personas.id', '=', 'm.estudiante_id');
        })
        ->where('m.curso_id', $this->filters['paralelo'])
        ->select('tm_personas.*', 'm.documento')
        ->orderBy('tm_personas.apellidos')
        ->get();

        $this->filters['modalidadId'] = $this->modalidadId;
     
        return view('livewire.vc-report-card');
    }

    public function loadPersonas(){

        
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
        $this->tblpersonas = TmPersonas::query()
            ->joinSub($unionQuery, 'm', function ($join) {
            $join->on('tm_personas.id', '=', 'm.estudiante_id');
        })
        ->when(!empty($this->filters['estudianteId']), function($query) {
            return $query->where('tm_personas.id', $this->filters['estudianteId']);
        })
        ->where('m.curso_id', $this->filters['paralelo'])
        ->select('tm_personas.*', 'm.documento')
        ->orderBy('tm_personas.apellidos')
        ->get();

    }

    public function actividad($idPerson,$id){

        $registros = TdCalificacionActividades::join('tm_actividades as a', 'a.id', '=', 'td_calificacion_actividades.actividad_id')
        ->join("tm_horarios_docentes as d",function($join){
            $join->on("d.id","=","tm_actividades.paralelo")
                ->on("d.docente_id","=","tm_actividades.docente_id");
        })
        ->join('tm_horarios as h', 'h.id', '=', 'd.horario_id')
        ->where('td_calificacion_actividades.persona_id', $idPerson)
        ->where('d.asignatura_id', $id)
        ->where('h.curso_id',$this->filters['paralelo_pase'])
        ->where('a.termino', $this->filters['termino'])
        ->where('a.tipo', 'ET')
        ->count('a.id');

        if ($registros==0){
            $this->filters['paralelo_pase']=0; 
        }

        $record = TmActividades::query()
        ->join("tm_horarios_docentes as d",function($join){
            $join->on("d.id","=","tm_actividades.paralelo")
                ->on("d.docente_id","=","tm_actividades.docente_id");
        })
        ->join("tm_horarios as h","h.id","=","d.horario_id")
        ->when(
            $this->filters['paralelo'] && ($this->filters['paralelo_pase'] == 0),
            function ($query) {
                $query->where('h.curso_id', $this->filters['paralelo']);
            }
        )
        ->when(
            $this->filters['paralelo_pase'] > 0,
            function ($query) {
                $query->where('h.curso_id', $this->filters['paralelo_pase']);
            }
        )
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

        $pases = DB::table('tm_pase_cursos as p')
        ->join('tm_matriculas as m', 'm.id', '=', 'p.matricula_id')
        ->where('p.curso_id', $this->filters['paralelo'])
        ->where('p.estado',"A")
        ->select('m.curso_id', 'p.modalidad_id', 'p.estudiante_id')
        ->get();

    
        foreach ($this->tblpersonas as $key => $person)
        { 
            $idPerson = $person->id;

            $registro = $pases->firstWhere('estudiante_id', $idPerson);

            if($registro){

                $this->filters['paralelo_pase'] = $registro->curso_id;

            }

            $this->tblgrupo  = TmActividades::query()
            ->join("tm_horarios_docentes as d",function($join){
                $join->on("d.id","=","tm_actividades.paralelo")
                    ->on("d.docente_id","=","tm_actividades.docente_id");
            })
            ->join("tm_horarios as h","h.id","=","d.horario_id")
            ->when(
                $this->filters['paralelo'] && ($this->filters['paralelo_pase'] == 0),
                function ($query) {
                    $query->where('h.curso_id', $this->filters['paralelo']);
                }
            )
            ->when(
                $this->filters['paralelo_pase'] > 0,
                function ($query) {
                    $query->where('h.curso_id', $this->filters['paralelo_pase']);
                }
            )
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

            // Actualiza Datos Asignaturas
            foreach ($this->asignaturas as $key => $data)
            {   
                $index = $data->id;
                $this->tblrecords[$idPerson][$index]['id'] = 0;
                $this->tblrecords[$idPerson][$index]['asignaturaId'] = $data->id;
                $this->tblrecords[$idPerson][$index]['nombres'] = strtoupper($data->descripcion);
                        
                $record = $this->actividad($idPerson,$data->id);
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
                $this->tblrecords[$idPerson][$index]['cuantitativo'] = 0.00;
                $this->tblrecords[$idPerson][$index]['cualitativo'] = "";
            }

        } 

        foreach ($this->tblpersonas as $key => $person)
        { 
            $idPerson = $person->id;
            $this->tblrecords[$idPerson]['ZZ']['id'] = 0;
            $this->tblrecords[$idPerson]['ZZ']['asignaturaId'] = 0;
            $this->tblrecords[$idPerson]['ZZ']['nombres'] = 'PROMEDIO FINAL';
            
            foreach ($this->tblgrupo as $key2 => $grupo){

                foreach ($grupo as $key3 => $actividad){
                    $col = $key2.$actividad->id;
                    $this->tblrecords[$idPerson]['ZZ'][$col] = 0.00;                   
                }
                $col = $key2."-prom";
                $this->tblrecords[$idPerson]['ZZ'][$col] = 0;

            }

            $this->tblrecords[$idPerson]['ZZ']['promedio'] = 0.00;
            $this->tblrecords[$idPerson]['ZZ']['nota70'] = 0.00;
            $this->tblrecords[$idPerson]['ZZ']['examen'] = 0.00;
            $this->tblrecords[$idPerson]['ZZ']['nota30'] = 0.00;
            $this->tblrecords[$idPerson]['ZZ']['cuantitativo'] = 0.00;
            $this->tblrecords[$idPerson]['ZZ']['cualitativo'] = "";
        
        }

        //Observaciones
        $observaciones = TdObservacionActa::query()
        ->where("termino",$this->filters['termino'])
        ->where("bloque",$this->filters['bloque'])
        ->where("curso_id",$this->filters['paralelo'])
        ->get();

        foreach ($observaciones as $obsr) {
            $this->arrComentario[$obsr->persona_id]['comentario'] = $obsr->comentario;
        }
        
        $this->datos = json_encode($this->filters);
    }


    public function asignarNotas(){

        $servicio = TmCursos::query()
        ->join("tm_servicios as s","s.id","=","tm_cursos.servicio_id")
        ->where("tm_cursos.id",$this->filters['paralelo'])
        ->first();

        $this->calificacion = $servicio->calificacion;

        $pases = DB::table('tm_pase_cursos as p')
        ->join('tm_matriculas as m', 'm.id', '=', 'p.matricula_id')
        ->where('p.curso_id', $this->filters['paralelo'])
        ->where('p.estado',"A")
        ->select('m.curso_id', 'p.modalidad_id', 'p.estudiante_id')
        ->get();

        
        foreach ($this->tblpersonas as $key => $person){

            $idPerson = $person->id;
            
            $registro = $pases->firstWhere('estudiante_id', $idPerson);

            if($registro){

                $this->filters['paralelo_pase'] = $registro->curso_id;

                $registros = TdCalificacionActividades::join('tm_actividades as a', 'a.id', '=', 'td_calificacion_actividades.actividad_id')
                ->join('tm_horarios_docentes as d', 'd.id', '=', 'a.paralelo')
                ->join('tm_horarios as h', 'h.id', '=', 'd.horario_id')
                ->where('td_calificacion_actividades.persona_id', $idPerson)
                ->where('h.curso_id',$this->filters['paralelo_pase'])
                ->where('a.termino', $this->filters['termino'])
                ->where('a.tipo', 'ET')
                ->count('a.id');

                if ($registros==0){
                   $this->filters['paralelo_pase']=0; 
                }

            }

            $this->tblgrupo  = TmActividades::query()
            ->join("tm_horarios_docentes as d",function($join){
                $join->on("d.id","=","tm_actividades.paralelo")
                    ->on("d.docente_id","=","tm_actividades.docente_id");
            })
            ->join("tm_horarios as h","h.id","=","d.horario_id")
            ->when(
                $this->filters['paralelo'] && ($this->filters['paralelo_pase'] == 0),
                function ($query) {
                    $query->where('h.curso_id', $this->filters['paralelo']);
                }
            )
            ->when(
                $this->filters['paralelo_pase'] > 0,
                function ($query) {
                    $query->where('h.curso_id', $this->filters['paralelo_pase']);
                }
            )
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
            ->where('n.persona_id', $idPerson)
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
           
            $bloque = $this->filters['bloque'] ?? null;
            $bloqueEx = $bloque ? str_replace('P', 'E', $bloque) : null;

            $examen = TmActividades::query()
            ->join('td_calificacion_actividades as n', 'n.actividad_id', '=', 'tm_actividades.id')
            ->join('tm_horarios_docentes as d', function($join) {
                $join->on('d.id', '=', 'tm_actividades.paralelo')
                    ->on('d.docente_id', '=', 'tm_actividades.docente_id');
            })
            ->join("tm_horarios as h","h.id","=","d.horario_id")
            ->when(
                $this->filters['paralelo'] && ($this->filters['paralelo_pase'] == 0),
                function ($query) {
                    $query->where('h.curso_id', $this->filters['paralelo']);
                }
            )
            ->when(
                $this->filters['paralelo_pase'] > 0,
                function ($query) {
                    $query->where('h.curso_id', $this->filters['paralelo_pase']);
                }
            )
            ->when(!empty($this->filters['termino']), function($query) {
                return $query->where('tm_actividades.termino', $this->filters['termino']);
            })
            ->when(!empty($bloque), function($query) use ($bloqueEx) {
                return $query->where('tm_actividades.bloque', $bloqueEx);
            })
            ->where('tm_actividades.tipo', 'ET')
            ->where('n.persona_id', $idPerson)
            ->groupBy('d.asignatura_id')
            ->selectRaw('d.asignatura_id, ROUND(AVG(n.nota), 2) as promedio')
            ->pluck('promedio', 'asignatura_id');

            foreach ($examen as $key => $objnota){
                
                $fil = $key;
                
                if (isset($this->tblrecords[$idPerson][$fil]['examen'])) {
                    $this->tblrecords[$idPerson][$fil]['examen'] = $objnota;
                }
            }
        
        }

        // Calcula Promedio
        foreach ($this->tblrecords as $key1 => $records){

            if ($key1!='ZZ'){
                
                foreach ($records as $key2 => $recno){

                    $promedio = 0;
                    $countprm = 0;
                    $nota30 = 0;
                    $nota70=0;

                    foreach ($this->tblgrupo as $grupo){

                        $tipo  = $grupo->actividad;
                        $suma  = 0;
                        $count = 0;

                        foreach ($recno as $campo => $valor){
                        
                            $ncampo = substr($campo, 0, 2); 
                            
                            if ($ncampo==$tipo){
                                $suma += $valor;
                                $count += 1;
                            }

                        }

                        $col = $tipo."-prom";
                        if ($count > 0){
                            $this->tblrecords[$key1][$key2][$col] = round($suma/($count-1), 2);
                            $promedio += $suma/($count-1);
                            $countprm += 1;
                        }

                    }
                    if ($countprm > 0){
                        $this->tblrecords[$key1][$key2]['promedio'] = round($promedio/($countprm), 2);  
                    }else{
                        $this->tblrecords[$key1][$key2]['promedio'] = 0.00;
                    }

                    if ($promedio > 0){
                        $nota70 = round($this->tblrecords[$key1][$key2]['promedio']*0.70,2);
                        $this->tblrecords[$key1][$key2]['nota70'] = round($nota70, 2);
                    }else{

                        $this->tblrecords[$key1][$key2]['nota70'] = 0.00;
                    }

                    if ($this->tblrecords[$key1][$key2]['examen'] > 0){
                        $nota30 = round($this->tblrecords[$key1][$key2]['examen']*0.30,2);
                        $this->tblrecords[$key1][$key2]['nota30'] = round($nota30, 2);
                    }else{
                        $this->tblrecords[$key1][$key2]['nota30'] = 0.00;
                    }

                    $this->tblrecords[$key1][$key2]['cuantitativo'] = $nota70+$nota30; 

                }
            }
        }

        // Promedio Final
        foreach ($this->tblrecords as $key => $records){
            $aiprom = 0;
            $agprom = 0;
            $promedio = 0;
            $nota70 = 0;
            $notaex = 0;
            $nota30 = 0;
            $promfinal = 0;
            $count = count($records)-1;

            foreach ($records as $key2 => $recno){
                
                $notaex += $recno['examen'];
                
                if (isset($recno['AI-prom'])){
                    $aiprom += $recno['AI-prom'];
                }

                if (isset($recno['AG-prom'])){
                    $agprom += $recno['AG-prom'];
                }                
                
                $promedio += $recno['promedio'];
                $nota70 += $recno['nota70'];
                $nota30 += $recno['nota30'];
                $promfinal += $recno['cuantitativo'];
            }

            $this->tblrecords[$key]['ZZ']['AI-prom']  = round($aiprom/$count,2);
            $this->tblrecords[$key]['ZZ']['AG-prom']  = round($agprom/$count,2);
            $this->tblrecords[$key]['ZZ']['promedio'] = round($promedio/$count,2);
            $this->tblrecords[$key]['ZZ']['nota70'] = round($nota70/$count,2);
            $this->tblrecords[$key]['ZZ']['examen'] = round($notaex/$count,2);
            $this->tblrecords[$key]['ZZ']['nota30'] = round($nota30/$count,2);
            $this->tblrecords[$key]['ZZ']['cuantitativo'] = round($promfinal/$count,2);

        }
                
        // Escala Cualitativa
        $rangos = TdPeriodoSistemaEducativos::query()
        ->where("periodo_id",$this->filters['periodoId'])
        ->where("tipo","EC")
        ->selectRaw("min(nota) as min, max(nota)+case when max(nota)=10 then 0 else 0.99 end as max, evaluacion as codigo, glosa as descr")
        ->groupBy("evaluacion","glosa")
        ->get()->toArray();

        foreach ($this->tblrecords as $key1 => $records){

            foreach ($records as $key2 => $recno){

                $promedio = $recno['cuantitativo']; 
                    
                foreach ($rangos as $escala) {
                    
                    $nota1 = $escala['min'];
                    $nota2 = $escala['max'];                  
                    $letra = $escala['codigo'];

                    if ($promedio >= ($nota1) && $promedio <= $nota2) {
                        $this->tblrecords[$key1][$key2]['cualitativo'] = $letra;
                    }
                    
                }
            
            }

        }

        $notas = $this->tblescala;        

        if($this->calificacion=="L"){

            foreach($this->tblrecords as $person => $record){

                foreach ($this->asignaturas as $key => $data)
                {   
                    $index = $data->id;
                    
                    if (isset($this->tblrecords[$person][$index]["AI-prom"])){

                        $aiprom = $this->tblrecords[$person][$index]["AI-prom"];
                        if ($aiprom>0){
                            $resultado = array_filter($notas, function($notas) use ($aiprom) {
                                return $aiprom >= $notas['nota'] && $aiprom <= $notas['nota2'];
                            });
                            $this->tblrecords[$person][$index]["AI-prom"] = reset($resultado)['codigo'] ?? 0;
                        }

                    };

                    if (isset($this->tblrecords[$person][$index]["AG-prom"])){

                        $agprom = $this->tblrecords[$person][$index]["AG-prom"];
                        if ($agprom>0){
                            $resultado = array_filter($notas, function($notas) use ($agprom) {
                                return $agprom >= $notas['nota'] && $agprom <= $notas['nota2'];
                            });
                            $this->tblrecords[$person][$index]["AG-prom"] = reset($resultado)['codigo'] ?? 0;
                        }

                    };

                    $promedio = $this->tblrecords[$person][$index]["promedio"];
                    $examen   = $this->tblrecords[$person][$index]["examen"];
                    $cuantitativo = $this->tblrecords[$person][$index]["cuantitativo"];
                   
                    if ($promedio>0){
                         $resultado = array_filter($notas, function($notas) use ($promedio) {
                            return $promedio >= $notas['nota'] && $promedio <= $notas['nota2'];
                        });
                        $this->tblrecords[$person][$index]["promedio"] = reset($resultado)['codigo'] ?? 0;
                    }

                    if ($examen>0){
                         $resultado = array_filter($notas, function($notas) use ($examen) {
                            return $examen >= $notas['nota'] && $examen <= $notas['nota2'];
                        });
                        $this->tblrecords[$person][$index]["examen"] = reset($resultado)['codigo'] ?? 0;
                    }

                    if ($cuantitativo>0){
                         $resultado = array_filter($notas, function($notas) use ($cuantitativo) {
                            return $cuantitativo >= $notas['nota'] && $cuantitativo <= $notas['nota2'];
                        });
                        $this->tblrecords[$person][$index]["cuantitativo"] = reset($resultado)['codigo'] ?? 0;
                    }

                }

                //Promedio Final
                if (isset($this->tblrecords[$person]['ZZ']["AI-prom"])){

                    $aiprom = $this->tblrecords[$person]['ZZ']["AI-prom"];
                    if ($aiprom>0){
                        $resultado = array_filter($notas, function($notas) use ($aiprom) {
                            return $aiprom >= $notas['nota'] && $aiprom <= $notas['nota2'];
                        });
                        $this->tblrecords[$person]['ZZ']["AI-prom"] = reset($resultado)['codigo'] ?? 0;
                    }

                };

                if (isset($this->tblrecords[$person]['ZZ']["AG-prom"])){

                    $agprom = $this->tblrecords[$person]['ZZ']["AG-prom"];
                    if ($agprom>0){
                        $resultado = array_filter($notas, function($notas) use ($agprom) {
                            return $agprom >= $notas['nota'] && $agprom <= $notas['nota2'];
                        });
                        $this->tblrecords[$person]['ZZ']["AG-prom"] = reset($resultado)['codigo'] ?? 0;
                    }

                };

                $promedio = $this->tblrecords[$person]['ZZ']["promedio"];
                $examen   = $this->tblrecords[$person]['ZZ']["examen"];
                $cuantitativo = $this->tblrecords[$person]['ZZ']["cuantitativo"];
                
                if ($promedio>0){
                        $resultado = array_filter($notas, function($notas) use ($promedio) {
                        return $promedio >= $notas['nota'] && $promedio <= $notas['nota2'];
                    });
                    $this->tblrecords[$person]['ZZ']["promedio"] = reset($resultado)['codigo'] ?? 0;
                }

                if ($examen>0){
                        $resultado = array_filter($notas, function($notas) use ($examen) {
                        return $examen >= $notas['nota'] && $examen <= $notas['nota2'];
                    });
                    $this->tblrecords[$person]['ZZ']["examen"] = reset($resultado)['codigo'] ?? 0;
                }

                if ($cuantitativo>0){
                        $resultado = array_filter($notas, function($notas) use ($cuantitativo) {
                        return $cuantitativo >= $notas['nota'] && $cuantitativo <= $notas['nota2'];
                    });
                    $this->tblrecords[$person]['ZZ']["cuantitativo"] = reset($resultado)['codigo'] ?? 0;
                }

            }

        }


    }

    public function addNota($id){

        $this->estudianteId =  $id;
        
        $observaciones = TdObservacionActa::query()
        ->where("termino",$this->filters['termino'])
        ->where("bloque",$this->filters['bloque'])
        ->when(
            $this->filters['paralelo'] && ($this->filters['paralelo_pase'] == 0),
            function ($query) {
                $query->where('h.curso_id', $this->filters['paralelo']);
            }
        )
        ->when(
            $this->filters['paralelo_pase'] > 0,
            function ($query) {
                $query->where('h.curso_id', $this->filters['paralelo_pase']);
            }
        )
        ->where("persona_id",$this->estudianteId)
        ->first();
        
        $this->mensaje = $observaciones?->comentario ?? '';
        $this->comentarioId = $observaciones?->id ?? 0;
        
        $this->dispatchBrowserEvent('add-mensaje');

    }

    public function grabar(){

        if ($this->comentarioId==0){
                TdObservacionActa::Create([
                'curso_id' => $this->filters['paralelo'],
                'termino' => $this->filters['termino'],
                'bloque' => $this->filters['bloque'],
                'persona_id' => $this->estudianteId,
                'comentario' => $this->mensaje,
                'estado' => 'A',
                'usuario' => auth()->user()->name,
            ]);
        }else{

            $record = TdObservacionActa::find($this->comentarioId);
            $record->update([
                'comentario' => $this->mensaje,
            ]);

        }     
        
        $this->arrComentario[$this->estudianteId]['comentario'] =  $this->mensaje;

        $this->dispatchBrowserEvent('close-mensaje');

    }

    public function printPDF($objdata)
    {   
        set_time_limit(300);
        
        $data = json_decode($objdata);
        $this->filters['periodoId']   = $data->periodoId;
        $this->filters['modalidadId']   = $data->modalidadId;
        $this->filters['paralelo'] = $data->paralelo;
        $this->filters['termino']   = $data->termino;
        $this->filters['bloque']  = $data->bloque;
        $this->filters['estudianteId'] = $data->estudianteId;

        $this->modalidadId =  $data->modalidadId;
        $this->periodoId = $data->periodoId;

        $asignaturas = TmHorarios::query()
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as a","a.id","=","d.asignatura_id")
        ->select("a.*")
        ->where("tm_horarios.curso_id",$this->filters['paralelo'])
        ->orderBy("a.descripcion")
        ->get();

        $this->loadPersonas();

        $escalas = TdPeriodoSistemaEducativos::query()
        ->where("periodo_id",$this->filters['periodoId'])
        ->where("tipo","EC")
        ->selectRaw("*,nota + case when nota=10 then 0 else 0.99 end as nota2")
        ->get()->toArray();

        $this->tblescala = $escalas;

        // Definimos los rangos
        /*TdPeriodoSistemaEducativos::query()
        ->where("periodo_id",$this->filters['periodoId'])
        ->where("tipo","EC")
        ->get()->toArray();*/

        $rangos = TdPeriodoSistemaEducativos::query()
        ->where("periodo_id",$this->filters['periodoId'])
        ->where("tipo","EC")
        ->selectRaw("min(nota) as min, max(nota)+case when max(nota)=10 then 0 else 0.99 end as max, evaluacion as codigo, glosa as descr")
        ->groupBy("evaluacion","glosa")
        ->get()->toArray();

        
        // Agrupamos las notas según el rango
        $arrescala = [];
        foreach ($rangos as $r) {
            $arrescala[] = [
                "rango" => "{$r['min']} - {$r['max']}",
                "codigo" => $r["codigo"],
                "desc" => $r["descr"],
                "notas" => array_column(
                    array_filter($escalas, function($n) use ($r) {
                        return $n["nota"] >= $r["min"] && $n["nota"] <= $r["max"];
                    }),
                    "nota"
                ),
                "rango2" => "",
                "codigo2" => "",
                "desc2" => "",
            ];
        }

        $arrescala[0]["rango2"] = "9.5 a 10";
        $arrescala[0]["codigo2"] = "EX";
        $arrescala[0]["desc2"] = "Excelente";

        $arrescala[1]["rango2"] = "8 a 9.49";
        $arrescala[1]["codigo2"] = "MB";
        $arrescala[1]["desc2"] = "Muy Bueno";

        $arrescala[2]["rango2"] = "6.5 a 7.99";
        $arrescala[2]["codigo2"] = "B";
        $arrescala[2]["desc2"] = "Bueno";

        $arrescala[3]["rango2"] = "0 a 6.49";
        $arrescala[3]["codigo2"] = "R";
        $arrescala[3]["desc2"] = "Regular";

        $this->add(); 
        $this->asignarNotas();
        $this->filters['paralelo_pase'] = 0;

        $periodo = TmPeriodosLectivos::find($this->filters['periodoId']);

        $curso = TmCursos::query()
        ->join("tm_servicios as s","s.id","=","tm_cursos.servicio_id")
        ->join("tm_generalidades as g","g.id","=","s.modalidad_id")
        ->where("tm_cursos.id",$this->filters['paralelo'])
        ->select("s.descripcion","tm_cursos.paralelo","g.descripcion as nivel")
        ->first();

        $trimestre = TdPeriodoSistemaEducativos::query()
        ->where('codigo',$this->filters['termino'])
        ->where('periodo_id',$this->filters['periodoId'])
        ->first();

        $datos = [
            'nivel' => $curso['nivel'],
            'trimestre' => $trimestre->descripcion,
            'subtitulo' => "Periodo Lectivo ".$periodo['descripcion'],
            'curso' => $curso['descripcion'].' '.$curso['paralelo'],
        ];

        $this->fechaActual = date("d/m/Y");
        $this->horaActual  = date("H:i:s");
        $notaParcial = $periodo->evaluacion_formativa;
        $notaExamen = $periodo->evaluacion_sumativa;

        //Faltas
        $faltas = [];
        foreach ($this->tblpersonas as $person) {

            $conteos = DB::table('td_asistencia_diarias')
            ->selectRaw("
                SUM(CASE WHEN valor = 'F' THEN 1 ELSE 0 END) as total_f,
                SUM(CASE WHEN valor = 'FJ' THEN 1 ELSE 0 END) as total_fj,
                SUM(CASE WHEN valor = 'A' THEN 1 ELSE 0 END) as total_a,
                SUM(CASE WHEN valor = 'AJ' THEN 1 ELSE 0 END) as total_aj
            ")
            ->where('persona_id', $person->id)
            ->where('periodo_id', $this->filters['periodoId'])
            ->where('termino', $this->filters['termino'])
            ->first();

            $faltas[$person->id]['faltas'] = $conteos->total_f ?? 0;
            $faltas[$person->id]['fjustificada'] = $conteos->total_fj ?? 0;
            $faltas[$person->id]['total'] = $faltas[$person->id]['faltas']+$faltas[$person->id]['fjustificada'];
            $faltas[$person->id]['atrasos'] = $conteos->total_a ?? 0;
            $faltas[$person->id]['ajustificada'] = $conteos->total_aj ?? 0;
            $faltas[$person->id]['total_a'] = $faltas[$person->id]['atrasos']+$faltas[$person->id]['ajustificada'];
        }

        //Conducta
        $arrconducta=[];
        foreach ($this->tblpersonas as $person) {
            $conducta =  TdConductas::query()
            ->where("periodo_id",$this->filters['periodoId'])
            ->where("modalidad_id",$this->filters['modalidadId'])
            ->where("termino",$this->filters['termino'])
            ->where("curso_id",$this->filters['paralelo'])
            ->where("persona_id",$person->id)
            ->first();

            if($conducta){
                $arrconducta[$person->id]['evaluacion'] = $conducta->evaluacion;
            }
        }   

        if ($this->calificacion=="L"){

            $pdf = PDF::loadView('pdf/reporte_boletin_notasletra',[
                'tblrecords' => $this->tblrecords,
                'asignaturas' => $asignaturas,
                'tblpersons' => $this->tblpersonas,
                'datos' => $datos,
                'fechaActual' => $this->fechaActual,
                'horaActual' => $this->horaActual,
                'notaParcial' => $notaParcial,
                'notaExamen' => $notaExamen,
                'arrescala' => $arrescala,
                'faltas' => $faltas,
                'arrComentario' => $this->arrComentario,
                'arrconducta' => $arrconducta,
            ]);

        }else{

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
                'faltas' => $faltas,
                'arrComentario' => $this->arrComentario,
                'arrconducta' => $arrconducta,
            ]);

        }

        return $pdf->setPaper('a4','landscape')->stream('Informe Aprendizaje.pdf');

    }

    public function imprimir($id){

        $this->filters['estudianteId'] = $id;
        $this->datos = json_encode($this->filters);
        
        $this->dispatchBrowserEvent('abrir-pdf', ['url' => "/preview-pdf/report-card/{$this->datos}"]);         
    }


}
