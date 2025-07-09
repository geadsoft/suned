<?php

namespace App\Http\Livewire;
use App\Models\TmHorarios;
use App\Models\TmHorariosDocentes;
use App\Models\TmActividades;
use App\Models\TdCalificacionActividades;
use App\Models\TdPeriodoSistemaEducativos;
use App\Models\TmPeriodosLectivos;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class VcQualifyActivity extends Component
{   

    public $asignaturaId=0, $actividadId=0, $paralelo, $termino="1T", $bloque="1P", $tipo="AI", $nombre, $fecha, $archivo='SI', $puntaje=10, $enlace="", $control="enabled";
    public $tblparalelo=[], $tblasignatura=[];
    public $periodoId, $modalidadId=0, $tbltermino, $tblbloque, $tblactividades;
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
        ->get();

    }

    public function render()
    {   
        $this->personas = TmHorariosDocentes::query()
        ->join("tm_horarios as h","h.id","=","tm_horarios_docentes.horario_id")
        ->join(DB::raw("(select estudiante_id, modalidad_id, periodo_id, curso_id, estado 
        from tm_matriculas m 
        where m.modalidad_id = ".$this->modalidadId."  and m.periodo_id = ".$this->periodoId."
        union all
        select m.estudiante_id, p.modalidad_id, m.periodo_id, p.curso_id, m.estado
        from tm_pase_cursos p
        inner join tm_matriculas m on m.id = p.matricula_id
        where p.modalidad_id = ".$this->modalidadId."  and m.periodo_id = ".$this->periodoId."
        and p.estado = 'A'        
        ) as m"),function($join){
            $join->on("m.modalidad_id","=","h.grupo_id")
                ->on("m.periodo_id","=","h.periodo_id")
                ->on("m.curso_id","=","h.curso_id");
        })
        ->join("tm_personas as p","p.id","=","m.estudiante_id")
        ->select("p.*")
        ->where("tm_horarios_docentes.id",$this->filters['paralelo'])
        ->where("m.estado",'A')
        ->orderBy("p.apellidos")
        ->get();
        
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

        $this->personas = TmHorariosDocentes::query()
        ->join("tm_horarios as h","h.id","=","tm_horarios_docentes.horario_id")
        ->join(DB::raw("(select estudiante_id, modalidad_id, periodo_id, curso_id, estado 
        from tm_matriculas m 
        where m.modalidad_id = ".$this->modalidadId."  and m.periodo_id = ".$this->periodoId."
        union all
        select m.estudiante_id, p.modalidad_id, m.periodo_id, p.curso_id, m.estado
        from tm_pase_cursos p
        inner join tm_matriculas m on m.id = p.matricula_id
        where p.modalidad_id = ".$this->modalidadId."  and m.periodo_id = ".$this->periodoId."
        and p.estado = 'A'        
        ) as m"),function($join){
            $join->on("m.modalidad_id","=","h.grupo_id")
                ->on("m.periodo_id","=","h.periodo_id")
                ->on("m.curso_id","=","h.curso_id");
        })
        ->join("tm_personas as p","p.id","=","m.estudiante_id")
        ->select("p.*")
        ->where("tm_horarios_docentes.id",$this->filters['paralelo'])
        ->where("m.estado",'A')
        ->orderBy("p.apellidos")
        ->get();

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

        //array_multisort(array_column($this->tblrecords, 'nombres'), SORT_ASC, $this->tblrecords);

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

            //$this->tblrecords[$fil][$col] = $record->nota; 
            if (isset($this->tblrecords[$fil][$col])) {
                $this->tblrecords[$fil][$col] = $record->nota;
            }
        }


        /*foreach ($this->personas as $key => $data)
        {
            $personaId =  $data->id; 

            foreach ($this->tblactividad as $col => $actividad)
            {
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
                ->when($this->filters['actividad'],function($query){
                    return $query->where('actividad',"{$this->filters['actividad']}");
                })
                ->where("tipo","AC")
                ->where("docente_id",$this->docenteId)
                ->where("actividad_id",$actividadId)
                ->where("persona_id",$personaId)
                ->select("n.*")
                ->get();  

                foreach ($notas as $record)
                {
                    $nota =  $record['nota'];
                    $this->tblrecords[$key][$col] = $nota; 
                }

            }
        }*/

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
        
        dd($this->tblrecords);

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
            
            if ($detalle['id']>0){

                $record = TdCalificacionActividades::find($detalle['id']);
                $record->update([
                    'nota' => $detalle['nota'],
                ]);

            }else{
                
                TdCalificacionActividades::Create([
                    'actividad_id' => $detalle['actividad_id'],
                    'persona_id' => $detalle['persona_id'],
                    'nota' =>  $detalle['nota'],
                    'usuario' => auth()->user()->name,
                    'estado' => 'A',
                ]);

            }
        }

        $message = "Calificaciones grabada con Éxito......";
        $this->dispatchBrowserEvent('msg-grabar', ['newName' => $message]);
    

    }



}
