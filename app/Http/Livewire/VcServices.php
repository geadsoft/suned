<?php

namespace App\Http\Livewire;
use App\Models\TmGeneralidades;
use App\Models\TmServicios;

use Livewire\Component;
use Livewire\WithPagination;

class VcServices extends Component
{   
    use WithPagination;
    public $showEditModal = false;
    public $selectId;
    public $record;

    public function render()
    {   
        $tblrecords = TmServicios::paginate(10);
        $tblgenerals = TmGeneralidades::all();

        return view('livewire.vc-services',[
            'tblrecords' => $tblrecords,
            'tblgenerals' => $tblgenerals
        ]);
        
    }

    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }

    /* Accion */
    public function add(){
        
        $this->showEditModal = false;
        $this->reset(['record']);
        $this->record['descripcion']= "";
        $this->record['modalidad_id']= 0; 
        $this->record['nivel_id']= 0;
        $this->record['grado_id']= 0;       
        $this->record['especializacion_id']= 0;
        $this->record['estado']= "A";      
        $this->dispatchBrowserEvent('show-form');

    }

    public function edit(TmServicios $tblrecords ){
        
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
            'record.descripcion' => 'required',
            'record.nivel_id' => 'required',
            'record.grado_id' => 'required',
            'record.modalidad_id' => 'required',
            'record.especializacion_id' => 'required',
        ]);
        
    
        TmServicios::Create([
            'descripcion' => $this -> record['descripcion'],
            'modalidad_id' => $this -> record['modalidad_id'],
            'nivel_id' => $this -> record['nivel_id'],
            'grado_id' => $this -> record['grado_id'],
            'especializacion_id' => $this -> record['especializacion_id'],
            'estado' => $this -> record['estado'],
            'usuario' => auth()->user()->name,
        ]);

        $this->dispatchBrowserEvent('hide-form', ['message'=> 'added successfully!']);  
        
    }    

    public function updateData(){

        $this ->validate([
            'record.descripcion' => 'required',
            'record.modalidad_id' => 'required',
            'record.nivel_id' => 'required',
            'record.grado_id' => 'required',
            'record.especializacion_id' => 'required',
        ]);        
        
        if ($this->selectId){
            $record = TmServicios::find($this->selectId);
            $record->update([
                'descripcion' => $this -> record['descripcion'],
                'modalidad_id' => $this -> record['modalidad_id'],
                'nivel_id' => $this -> record['nivel_id'],
                'grado_id' => $this -> record['grado_id'],           
                'especializacion_id' => $this -> record['especializacion_id'],
            ]);
            
        }
      
        $this->dispatchBrowserEvent('hide-form', ['message'=> 'added successfully!']);
        
    }

    public function deleteData(){
        TmServicios::find($this->selectId)->delete();
        $this->dispatchBrowserEvent('hide-delete');
    }



}
