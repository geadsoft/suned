<?php

namespace App\Http\Livewire;
use App\Models\TmHorarios;
use App\Models\TmHorariosDocentes;
use App\Models\TmActividades;
use App\Models\TdAsistenciaDiarias;


use Livewire\Component;
use Illuminate\Support\Facades\DB;

class VcDailyAttendance extends Component
{
    public $asignaturaId;
    public $tblrecords=[];
    
    public $filters=[
        'docenteId' => 0,
        'cursoId' => 0, 
        'buscar' => '',
        'fecha' => '',
    ];

    protected $listeners = ['setData'];

    public function mount()
    {   
        $ldate = date('Y-m-d H:i:s');
        $this->filters['fecha'] = date('Y-m-d',strtotime($ldate));
        $this->filters['docenteId'] = auth()->user()->personaId;

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
        ->selectRaw('c.id, concat(s.descripcion," ",c.paralelo) as descripcion')
        ->get();

        return view('livewire.vc-daily-attendance');
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

    public function consulta(){

        $this->personas = TmHorariosDocentes::query()
        ->join("tm_horarios as h","h.id","=","tm_horarios_docentes.horario_id")
        ->join("tm_matriculas as m",function($join){
            $join->on("m.modalidad_id","=","h.grupo_id")
                ->on("m.periodo_id","=","h.periodo_id")
                ->on("m.curso_id","=","h.curso_id");
        })
        ->join("tm_personas as p","p.id","=","m.estudiante_id")
        ->when($this->filters['buscar'],function($query){
            return $query->where(DB::raw('concat(ltrim(rtrim(p.apellidos))," ",ltrim(rtrim(p.nombres)))'), 'LIKE' , "%{$this->filters['buscar']}%");
        })
        ->select("p.*")
        ->where("tm_horarios_docentes.asignatura_id",$this->asignaturaId)
        ->where("h.curso_id",$this->filters['cursoId'])
        ->orderBy("p.apellidos")
        ->get();
            
        $this->add();
        $this->loadfalta();

    }

    public function add(){

        $this->tblrecords=[];

        // Datos
        foreach ($this->personas as $key => $data)
        {   
            $index = $data->id;
            $this->tblrecords[$index]['id'] = 0;
            $this->tblrecords[$index]['personaId'] = $data->id;
            $this->tblrecords[$index]['nombres'] = $data->apellidos.' '.$data->nombres;
            $this->tblrecords[$index]['falta'] = false;
        }

        
    }

    public function loadfalta(){


        $faltas = TdAsistenciaDiarias::query()
        ->where("asignatura_id",$this->asignaturaId)
        ->where("curso_id",$this->filters['cursoId'])
        ->where("docente_id",$this->filters['docenteId'])
        ->where("fecha",$this->filters['fecha'])
        ->get();

        foreach ($faltas as $key => $data)
        {
            $index = $data->persona_id;
            $this->tblrecords[$index]['id'] = $data['id'];
            $this->tblrecords[$index]['falta'] = true;
        }

        array_multisort(array_column($this->tblrecords, 'nombres'), SORT_ASC, $this->tblrecords);

    }

    public function createData(){


        if (count($this->tblrecords)>0){

            $message = "";
            $this->dispatchBrowserEvent('msg-confirm', ['newName' => $message]);

        }else{

            $message = "";
            $this->dispatchBrowserEvent('msg-alert', ['newName' => $message]);

        }  

    }

    public function setData()
    {

        foreach ($this->tblrecords as $key => $record)
        {
            if ($record['falta']==true && $record['id']==0){

                TdAsistenciaDiarias::Create([
                    'docente_id' => $this->filters['docenteId'],
                    'asignatura_id' => $this->asignaturaId,
                    'curso_id' => $this->filters['cursoId'],
                    'persona_id' => $record['personaId'],
                    'fecha' => $this->filters['fecha'],
                    'falta' =>  $record['falta'],
                    'usuario' => auth()->user()->name,
                    'estado' => 'A',
                ]);

            }
        
        }


    }

    
}


