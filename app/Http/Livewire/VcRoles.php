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
        return view('livewire.vc-roles',['tblrecords' => $tblrecords]);

    }

    public function add(){
        
        $this->showEditModal = false;
        $this->reset(['record']);
        $this->record['name']= '';  
        $this->dispatchBrowserEvent('show-form');

    }

    public function edit(Role $tblrecords ){
        
        $this->showEditModal = true;
        $this->record  = $tblrecords->toArray();
       
        $this->selectId = $this -> record['id'];
        $this->dispatchBrowserEvent('show-form');

    }

    public function delete( $id ){
        
 
        $this->selectId = $id;
        $this->dispatchBrowserEvent('show-delete');

    }

    /* Procesos */

    public function createData(){

        $this ->validate([
            'record.name' => 'required|min:2',
        ]);

        Role::Create([
            'name' => $this -> record['name'],
        ]);

        $this->dispatchBrowserEvent('hide-form');  
        $this->dispatchBrowserEvent('msg-save'); 

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
      
        $this->dispatchBrowserEvent('hide-form');
        $this->dispatchBrowserEvent('msg-update'); 
        
    }

}
