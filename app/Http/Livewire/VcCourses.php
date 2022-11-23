<?php

namespace App\Http\Livewire;
use App\Models\TmGeneralidades;
use App\Models\TmPeriodosLectivos;
use App\Models\TmCursos;

use Livewire\Component;
use Livewire\WithPagination;

class VcCourses extends Component
{   
    use WithPagination;
    public $showEditModal = false;
    public $selectId;
    public $record;
    public $nivelId;

    public function render()
    {   
        $tblrecords = TmCursos::paginate(10);
        $tblgenerals = TmGeneralidades::all();
        $tblperiodos = TmPeriodosLectivos::all();

        return view('livewire.vc-courses',[
            'tblrecords' => $tblrecords,
            'tblgenerals' => $tblgenerals,
            'tblperiodos' => $tblperiodos,
        ]);
        
    }

    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }
    

    /* Accion */
    public function add(){
        
        $this->showEditModal = false;
        $this->reset(['record']);
        $this->record['nivel_id']= 0;
        $this->record['grado_id']= 0;
        $this->record['paralelo']= "";
        $this->record['grupo_id']= 0; 
        $this->record['especializacion_id']= 0;
        $this->record['periodo_id']= 0;  
        $this->record['vistaplataforma']= ""; 
        $this->record['estado']= "A";      
        $this->dispatchBrowserEvent('show-form');

    }

    public function edit(TmCursos $tblrecords ){
        
        $this->showEditModal = true;
        $this->record  = $tblrecords->toArray();
       
        $this->selectId = $this -> record['id'];
        $this->dispatchBrowserEvent('show-form');

    }

    public function delete( $id ){
        
        $this->selectId = $id;
        $this->dispatchBrowserEvent('show-delete');

    }

    /* Proceso */

    public function createData(){
      
        $this ->validate([
            'record.nivel_id' => 'required',
            'record.grado_id' => 'required',
            'record.grupo_id' => 'required',
            'record.periodo_id' => 'required',
        ]);
        
    
        TmCursos::Create([
            'nivel_id' => $this -> record['nivel_id'],
            'grado_id' => $this -> record['grado_id'],
            'paralelo' => $this -> record['paralelo'],
            'grupo_id' => $this -> record['grupo_id'],
            'periodo_id' => $this -> record['periodo_id'],
            'especializacion_id' => $this -> record['especializacion_id'],
            'vistaplataforma' => $this -> record['vistaplataforma'],
            'estado' => $this -> record['estado'],
            'usuario' => auth()->user()->name,
        ]);

        $this->dispatchBrowserEvent('hide-form', ['message'=> 'added successfully!']);  
        
    }    

    public function updateData(){

        $this ->validate([
            'record.nivel_id' => 'required',
            'record.grado_id' => 'required',
            'record.grupo_id' => 'required',
            'record.periodo_id' => 'required',
        ]);        
        
        if ($this->selectId){
            $record = TmCursos::find($this->selectId);
            $record->update([
                'nivel_id' => $this -> record['nivel_id'],
                'grado_id' => $this -> record['grado_id'],
                'paralelo' => $this -> record['paralelo'],
                'grupo_id' => $this -> record['grupo_id'],
                'especializacion_id' => $this -> record['especializacion_id'],
                'vistaplataforma' => $this -> record['vistaplataforma'],
            ]);
            
        }
      
        $this->dispatchBrowserEvent('hide-form', ['message'=> 'added successfully!']);
        
    }

    public function deleteData(){
        TmCursos::find($this->selectId)->delete();
        $this->dispatchBrowserEvent('hide-delete');
    }



}
