<?php

namespace App\Http\Livewire;

use App\Models\TmPeriodosLectivos;
use App\Models\TmGeneralidades;
use App\Models\TmServicios;
use App\Models\TmCursos;


use Livewire\Component;
use Livewire\WithPagination;

class VcServicesCourse extends Component
{
    use WithPagination;
    public $showEditModal = false;
    public $selectCurso;
    public $record;
    public $objGrado,$nomSeccion;
    public $servicioId,$grupoId,$nivelId,$gradoId,$paralelo,$carreraId,$periodoId,$plataforma;

    public $filters = [
        'srv_grupo' => '',
        'srv_nivel' => '',
        'srv_estado' => 'A',
        'srv_periodo' => '',
    ];

    public function mount()
    {
        $periodo = TmPeriodosLectivos::orderBy("periodo","desc")->first();
        $this->filters['srv_periodo'] = $periodo['id'];  
    }

    public function render()
    {
        
        $tblrecords = TmServicios::query()
        ->when($this->filters['srv_grupo'],function($query){
            return $query->where('modalidad_id',"{$this->filters['srv_grupo']}");
        })
        ->when($this->filters['srv_nivel'],function($query){
            return $query->where('nivel_id',"{$this->filters['srv_nivel']}");
        })
        ->when($this->filters['srv_estado'],function($query){
            return $query->where('estado',"{$this->filters['srv_estado']}");
        })
        ->paginate(10);

        $tblcursos   = TmCursos::query()
        ->when($this->filters['srv_periodo'],function($query){
            return $query->where('periodo_id',"{$this->filters['srv_periodo']}");
        })->get();

        $tblgenerals = TmGeneralidades::all();
        $tblperiodos = TmPeriodosLectivos::orderBy("periodo","desc")->get();

        return view('livewire.vc-services-course',[
            'tblrecords' => $tblrecords,
            'tblgenerals' => $tblgenerals,
            'tblperiodos' => $tblperiodos,
            'tblcursos' => $tblcursos
        ]);
        
    }

    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }

    public function add(TmServicios $tblrecords ){
        
        $this->showEditModal = false;
        $this->objGrado  = $tblrecords->toArray();

        $this->servicioId = $this -> objGrado['id'];
        $this->grupoId = $this -> objGrado['modalidad_id'];
        $this->nivelId = $this -> objGrado['nivel_id'];
        $this->gradoId = $this -> objGrado['grado_id'];
        $this->carreraId = $this -> objGrado['especializacion_id'];
        
       
        $this->dispatchBrowserEvent('show-form');

    }

    public function delete( $id ){
        
        $curso = TmCursos::find($id);

        $this->selectCurso = $id;
        $this->nomSeccion = $curso['paralelo'];

        $this->dispatchBrowserEvent('show-delete');

    }

    
    public function createData(){


        $this ->validate([
            'nivelId' => 'required',
            'gradoId' => 'required',
            'grupoId' => 'required',
            'periodoId' => 'required',
        ]);
        
    
        TmCursos::Create([
            'servicio_id' => $this -> servicioId,
            'nivel_id' => $this -> nivelId,
            'grado_id' => $this -> gradoId,
            'paralelo' => $this -> paralelo,
            'grupo_id' => $this -> grupoId,
            'periodo_id' => $this -> periodoId,
            'especializacion_id' => $this -> carreraId,
            'vistaplataforma' => $this -> plataforma,
            'estado' => "A",
            'usuario' => auth()->user()->name,
        ]);

        $this->dispatchBrowserEvent('hide-form'); 
        $this->addData(); 
        
    } 

    public function deleteData(){
        TmCursos::find($this->selectCurso)->delete();
        $this->dispatchBrowserEvent('hide-delete');
    }

    public function addData(){
        $this->servicioId = 0;
        $this->grupoId = 0;
        $this->nivelId = 0;
        $this->gradoId = 0;
        $this->carreraId = 0;
        $this->paralelo="";
        $this->plataforma="";
        $this->periodoId=0;
    }


}
