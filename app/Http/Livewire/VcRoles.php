<?php

namespace App\Http\Livewire;

use Livewire\Component;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Livewire\WithPagination;

class VcRoles extends Component
{
    use WithPagination;

    public $showEditModal = false;
    public $selectId;
    public $record=[];
    

    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }


    public function render()
    {
        $tblrecords = Role::paginate(10);   
                
        return view('livewire.vc-roles',[
            'tblrecords'  => $tblrecords
        ]);

    }

    public function add(){
        
        $this->showEditModal = false;
        $this->reset(['record']);
        $this->record['name']= '';  

        $this->emitTo('vc-view-rol-permissions','permisos',0);
        $this->dispatchBrowserEvent('show-form');

    }

    public function edit(Role $tblrecords ){
        
        $this->showEditModal = true;
        $this->record  = $tblrecords->toArray();
       
        $this->selectId = $this -> record['id'];

        $this->emitTo('vc-view-rol-permissions','permisos',$this->selectId); 
        $this->dispatchBrowserEvent('show-form');

    }


    public function delete( $id ){
        
        $this->selectId = $id;
        $record = Role::find($this->selectId);
       
        if (count($record->permissions->pluck('name'))>0){

            $message = "Rol ".$record->name.", tiene asignados permisos.";
            $this->dispatchBrowserEvent('msg-alert', ['newName' => $message]);

        }else{

            $this->dispatchBrowserEvent('show-delete');
        }

    }

    public function deleteData(){

        Role::find($this->selectId)->delete();
        $this->dispatchBrowserEvent('hide-delete');

    }

    /* Procesos */

    public function createData(){

        $this ->validate([
            'record.name' => 'required|min:2',
        ]);

        $rol = Role::Create([
            'name' => $this -> record['name'],
        ]);

        $this->emitTo('vc-view-rol-permissions','asignar','PERMISOS',$rol->id); 

        $this->dispatchBrowserEvent('hide-form');  
        $this->dispatchBrowserEvent('msg-save'); 

        return redirect()->to('/config/rols');

    }

    public function updateData(){

        $this ->validate([
            'record.name' => 'required',       
        ]);
         
        if ($this->selectId){
            
            $record = Role::find($this->selectId);
            $record->update([
                'name' => $this -> record['name'],
            ]);
            
        }
      
        $this->emitTo('vc-view-rol-permissions','asignar','PERMISOS',$this->selectId); 

        
        $this->dispatchBrowserEvent('msg-update'); 
        $this->dispatchBrowserEvent('hide-form');
        
        return redirect()->to('/config/rols');
        
        
    }

}
