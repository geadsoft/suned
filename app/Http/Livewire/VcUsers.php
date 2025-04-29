<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Roles;
use App\Models\User;


use Livewire\WithPagination;

class VcUsers extends Component
{

    use WithPagination;

    public $showEditModal = false;
    public $selectId;
    public $record=[];

    public function render()
    {
        $tblusers = User::paginate(10);   
                
        return view('livewire.vc-users',[
            'tblusers'  => $tblusers
        ]);
        
    }

    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }

    public function add(){
        
        $this->showEditModal = false;
        $this->reset(['record']);
        $this->record['name']= '';
        $this->record['email']= ''; 
        $this->record['password']= '';
        $this->record['acceso']= 0; 

        $this->emitTo('vc-view-rol-permissions','roles',0);
        $this->dispatchBrowserEvent('show-form');

    }

    public function editRol(User $tblusers ){
        
        $this->showEditModal = true;
        $this->record  = $tblusers->toArray();
       
        $this->selectId = $this -> record['id'];

        $this->emitTo('vc-view-rol-permissions','roles',$this->selectId); 
        $this->dispatchBrowserEvent('show-form');

    }

    public function editPermiso(User $tblusers ){
        
        $this->showEditModal = true;
        $this->record  = $tblusers->toArray();
       
        $this->selectId = $this -> record['id'];

        $this->emitTo('vc-view-rol-permissions','permisos',$this->selectId); 
        $this->dispatchBrowserEvent('show-form');

    }

    public function createData(){

        $this ->validate([
            'record.name' => 'required|min:2',
            'record.email' => 'required|string|email|max:255',
            'record.clave' => 'required'
        ]);

        $rol = User::Create([
            'name' => $this->record['name'],
            'email' => $this->record['email'],
            'password' => bcrypt($this->record['clave']) ,
            'perfil' => 'U',
            'personaId' => 0,
            'acceso' => 1,
        ]);

        $this->emitTo('vc-view-rol-permissions','asignar','ROL',$rol->id); 

        $this->dispatchBrowserEvent('hide-form');  
        $this->dispatchBrowserEvent('msg-save'); 

        return redirect()->to('/config/users');

    }

    public function updateData(){

        $this ->validate([
            'record.name' => 'required|min:2',
            'record.email' => 'required|string|email|max:255',      
        ]);
         
        if ($this->selectId){
            
            $record = User::find($this->selectId);
            $record->update([
                'name' => $this -> record['name'],
                'acceso' => $this -> record['acceso'],
            ]);
            
        }
      
        $this->emitTo('vc-view-rol-permissions','asignar','ROL',$this->selectId); 

        
        $this->dispatchBrowserEvent('msg-update'); 
        $this->dispatchBrowserEvent('hide-form');
        
        return redirect()->to('/config/users');
        
        
    }

}
