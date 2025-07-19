<?php

namespace App\Http\Livewire;
use App\Models\TmGeneralidades;
use App\Models\TmHorariosDocentes;
use App\Models\TmPeriodosLectivos;
use App\Models\TmHorarios;
use App\Models\TdAsistenciaDiarias;

use Livewire\Component;

class VcTeacherAssistance extends Component
{
    public $tblmodalidad=[], $tblparalelo=[], $asignaturas=[], $personas=[], $tblrecords=[];


    public $filters=[
        'modalidadId' => 0,
        'periodoId' => 0,
        'docenteId' => 0,
        'cursoId' => 0, 
        'asignaturaId' => 0,
        'fecha' => '',
        'mes' => 1,
        'periodo' => 0,
        'buscar' => '',
    ];

    protected $listeners = ['setData'];
    
    public function mount()
    {   
        $ldate = date('Y-m-d H:i:s');
        $this->filters['fecha'] = date('Y-m-d',strtotime($ldate));
        $this->filters['docenteId'] = auth()->user()->personaId;
        $this->filters['mes'] = intval(date('m',strtotime($ldate)));

        $tblperiodos = TmPeriodosLectivos::where("aperturado",1)->first();
        $this->filters['periodoId']  = $tblperiodos['id'];
        $this->filters['periodo'] = $tblperiodos['periodo'];

        $this->filters['modalidadId'] = "";
       
    }


    public function render()
    {
        $ids = [3, 4];
        $this->tblmodalidad = TmGeneralidades::query()
        ->whereIn('id', $ids)->get();
        
        $this->tblparalelo = TmHorarios::query()
        ->join("tm_cursos as c","c.id","=","tm_horarios.curso_id")
        ->join("tm_servicios as s","s.id","=","c.servicio_id")
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->where("tm_horarios.periodo_id",$this->filters['periodoId'])
        ->where('tm_horarios.grupo_id',$this->filters['modalidadId'])
        ->where("d.docente_id",$this->filters['docenteId'])
        ->selectRaw('c.id, concat(s.descripcion," ",c.paralelo) as descripcion')
        ->groupBy("c.id","s.descripcion","c.paralelo")
        ->get();


        $this->asignaturas = TmHorarios::query()
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as m","m.id","=","d.asignatura_id")
        /*->where("tm_horarios.periodo_id",$this->filters['periodoId'])
        ->where("tm_horarios.grupo_id",$this->filters['modalidadId'])*/
        ->where("tm_horarios.curso_id",$this->filters['cursoId'])
        ->where("d.docente_id",$this->filters['docenteId'])
        ->selectRaw('m.id, m.descripcion')
        ->get();
        

        return view('livewire.vc-teacher-assistance');
    }

     public function consulta(){

        $this->personas = TmHorarios::query()
        ->join("tm_matriculas as m",function($join){
            $join->on("m.modalidad_id","=","tm_horarios.grupo_id")
                ->on("m.periodo_id","=","tm_horarios.periodo_id")
                ->on("m.curso_id","=","tm_horarios.curso_id");
        })
        ->join("tm_personas as p","p.id","=","m.estudiante_id")
        ->when($this->filters['buscar'],function($query){
            return $query->where(DB::raw('concat(ltrim(rtrim(p.apellidos))," ",ltrim(rtrim(p.nombres)))'), 'LIKE' , "%{$this->filters['buscar']}%");
        })
        ->select("p.*")
        ->where("tm_horarios.curso_id",$this->filters['cursoId'])
        ->where("tm_horarios.periodo_id",$this->filters['periodoId'])
        ->orderBy("p.apellidos")
        ->get();
        
        $this->add();
        //$this->loadfalta();

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

    public function updatedFiltersModalidadId()
    {   
        $this->tblrecords=[];
    }

    public function updatedFiltersFecha($value)
    {   

        foreach ($this->tblrecords as $id => $registro) {
            $this->tblrecords[$id]['falta'] = false;
        }
        $this->loadfalta();  // Se ejecuta cada vez que cambia la fecha

    }

    public function loadfalta(){

        $faltas = TdAsistenciaDiarias::query()
        ->where("curso_id",$this->filters['cursoId'])
        ->where("docente_id",$this->filters['docenteId'])
        ->where("periodo_id",$this->filters['periodoId'])
        ->where("fecha", $this->filters['fecha'])
        ->whereRaw("valor<>''")
        ->get();

        foreach ($faltas as $key => $data)
        {
            $index = $data->persona_id;
            $valor = $data->valor == 1 ? true : false;

            $this->tblrecords[$index]['falta'] = $valor;
            $this->tblrecords[$index]['id'] = $data->id;
        }

    }

    public function createData(){

        $cantidad = collect($this->tblrecords)->where('falta', true)->count();
        
        if ( $cantidad >0){

            $message = "";
            $this->dispatchBrowserEvent('msg-confirm', ['newName' => $message]);

        }else{

            $message = "";
            $this->dispatchBrowserEvent('msg-alert', ['newName' => $message]);

        }        

    }

    public function setData()
    {

        foreach ($this->tblrecords as $index => $data)
        {
            $personaId = $data['personaId'];

            if ($data['falta']==true && $data['id']==0){

                    TdAsistenciaDiarias::Create([
                    'periodo_id' => $this->filters['periodoId'],
                    'mes' => $this->filters['mes'],
                    'docente_id' => $this->filters['docenteId'],
                    'asignatura_id' => $this->filters['asignaturaId'],
                    'curso_id' => $this->filters['cursoId'],
                    'persona_id' => $personaId,
                    'fecha' => $this->filters['fecha'],
                    'valor' => $data['falta'],
                    'usuario' => auth()->user()->name,
                    'estado' => 'A',
                ]);

            }

            if ($data['id']>0){

                $recno = TdAsistenciaDiarias::find($data['id']);
                $recno->update([
                    'valor' => $data['falta'],
                ]);

            }
        
        }

        $message = "Calificaciones grabada con Éxito......";
        $this->dispatchBrowserEvent('msg-grabar', ['newName' => $message]);
        
    }

}
