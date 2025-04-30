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

    protected $listeners = ['setMensaje'];

    public function mount()
    {
        $this->docenteId = auth()->user()->personaId;

        $tblperiodos = TmPeriodosLectivos::where("aperturado",1)->first();
        $this->periodoId = $tblperiodos['id'];

    }

    public function render()
    {
            
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


    public function add(){

        $ldate = date('Y-m-d H:i:s');
        
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

        $this->emitTo('vc-asignatura-cursos','setGrabar',$this->record['enlace']);
                
    }

    public function setMensaje(){

        $message = "Registro grabado con éxito!";
        $this->dispatchBrowserEvent('msg-grabar', ['newName' => $message]);

        $this->dispatchBrowserEvent('hide-form');

    }


}
