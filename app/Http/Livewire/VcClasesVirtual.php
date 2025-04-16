<?php

namespace App\Http\Livewire;
use App\Models\TmHorarios;
use App\Models\TmActividades;
use App\Models\TmPeriodosLectivos;

use Livewire\Component;
use Livewire\WithPagination;

class VcClasesVirtual extends Component
{
    
    public $showEditModal, $paralelo, $actividadId=0, $tblasignatura, $asignaturaId;

    public $record=[];
    public $tblparalelo=[];

    public $filters=[
        'paralelo' => '',
    ];

    use WithPagination;

    protected $listeners = ['setCursoId'];

    public function mount()
    {
        $this->docenteId = auth()->user()->personaId;

        $tblperiodos = TmPeriodosLectivos::where("aperturado",1)->first();
        $this->periodoId = $tblperiodos['id'];

    }

    public function render()
    {
        /*$this->tblasignatura = TmHorarios::query()
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as m","m.id","=","d.asignatura_id")
        ->where("d.docente_id",$this->docenteId)
        ->where("tm_horarios.periodo_id",$this->periodoId)
        ->selectRaw('m.id, m.descripcion')
        ->groupBy('m.id','m.descripcion')
        ->get();*/
        
        $tblrecords = TmHorarios::query()
        ->join("tm_servicios as s","s.id","=","tm_horarios.servicio_id")
        ->join("tm_cursos as c","c.id","=","tm_horarios.curso_id")
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as m","m.id","=","d.asignatura_id")
        ->join("tm_actividades as a","a.paralelo","=","d.id")
        ->when($this->filters['paralelo'],function($query){
            return $query->where('a.paralelo',"{$this->filters['paralelo']}");
        })
        ->where("a.docente_id",$this->docenteId)
        ->where("tm_horarios.periodo_id",$this->periodoId)
        ->where("a.tipo","CV")
        ->selectRaw('m.descripcion as asignatura, s.descripcion as curso, c.paralelo as aula, a.*')
        ->paginate(12);

        return view('livewire.vc-clases-virtual',[
            'tblrecords' =>  $tblrecords
        ]);
    }

    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }

    /*public function updatedasignaturaId($id){

        $this->asignaturaId = $id;

        $this->tblparalelo = TmHorarios::query()
        ->join("tm_servicios as s","s.id","=","tm_horarios.servicio_id")
        ->join("tm_cursos as c","c.id","=","tm_horarios.curso_id")
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as m","m.id","=","d.asignatura_id")
        ->where("d.docente_id",$this->docenteId)
        ->where("tm_horarios.periodo_id",$this->periodoId)
        ->where("m.id",$id)
        ->selectRaw('d.id, concat(s.descripcion," ",c.paralelo) as descripcion')
        ->get();

    }*/

    public function setCursoId($cursoId){
        
        dd(1);
        $this->record['paralelo'] = $cursoId;
        
    }

    public function add(){

        $ldate = date('Y-m-d H:i:s');

        /*$this->tblparalelo = TmHorarios::query()
        ->join("tm_servicios as s","s.id","=","tm_horarios.servicio_id")
        ->join("tm_cursos as c","c.id","=","tm_horarios.curso_id")
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as m","m.id","=","d.asignatura_id")
        ->where("d.docente_id",$this->docenteId)
        ->where("tm_horarios.periodo_id",$this->periodoId)
        ->selectRaw('d.id, concat(m.descripcion," - ",s.descripcion," ",c.paralelo) as descripcion')
        ->get();*/
        
        $this->showEditModal = false;
        $this->reset(['record']);
        $this->record['docente_id']= '';
        $this->record['termino']= '';
        $this->record['bloque']= '';
        $this->record['actividad']= 'AI';
        $this->record['tipo']= 'CV';
        $this->record['nombre']= 0;
        $this->record['paralelo']= 0;
        $this->record['enlace']= '';
        $this->record['fecha']= date('Y-m-d',strtotime($ldate));
        $this->record['estado']= 'A';       
        $this->dispatchBrowserEvent('show-form');

    }


    public function createData(){

        $this ->validate([
            'record.paralelo' => 'required',
            'record.enlace' => 'required',
        ]);

        if ($this->actividadId>0){

            $this->updateData();            

        }else {
            
            TmActividades::Create([
                'docente_id' => $this->docenteId,
                'paralelo' => $this->record['paralelo'],
                'termino' => $this->record['termino'],
                'bloque' => $this->record['bloque'],
                'tipo' => $this->record['tipo'],
                'actividad' => $this->record['actividad'],
                'nombre' => 'Clase Virtual',
                'descripcion' => "",
                'enlace' => $this->record['enlace'],
                'fecha' => $this->record['fecha'],
                'subir_archivo' => 'NO',
                'puntaje' => 0,
                'estado' => "A",
                'usuario' => auth()->user()->name,
            ]);

            $message = "Registro grabado con éxito!";
            $this->dispatchBrowserEvent('msg-grabar', ['newName' => $message]);

            return redirect()->to('/activities/virtual-classes');
        }
        
    }


}
