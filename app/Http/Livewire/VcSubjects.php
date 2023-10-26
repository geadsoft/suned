<?php

namespace App\Http\Livewire;
use App\Models\TmGeneralidades;
use App\Models\TmAsignaturas;

use Livewire\Component;
use Livewire\WithPagination;

class VcSubjects extends Component
{   
    use WithPagination;

    public $showEditModal = false;
    public $selectId;
    public $tblareas=null;
    public $record=[];

    public function mount(){

        $this->tblareas = TmGeneralidades::where('superior',10)->get();

    }

    public function render()
    {
       
        $tblrecords = TmAsignaturas::paginate(10);

        return view('livewire.vc-subjects',[
            'tblrecords' => $tblrecords,
            'tblareas' => $this->tblareas,
        ]);

    }

    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }

    public function add(){
        
        $this->showEditModal = false;
        $this->reset(['record']);
        $this->record['area_id']= 0;
        $this->record['descripcion']= '';
        $this->record['estado']= 'A';    
        $this->dispatchBrowserEvent('show-form');

    }


    public function edit(TmAsignaturas $tblrecords ){
        
        $this->showEditModal = true;
        $this->record  = $tblrecords->toArray();
       
        $this->selectId = $this -> record['id'];
        $this->dispatchBrowserEvent('show-form');

    }

    public function delete( $id ){
        
        $this->selectId = $id;
        $this->dispatchBrowserEvent('show-delete');

    }

    public function createData(){
        
        $this ->validate([
            'record.descripcion' => 'required',
            'record.area_id' => 'required',
        ]);

        TmAsignaturas::Create([
            'descripcion' => $this -> record['descripcion'],
            'area_id' => $this -> record['area_id'],
            'estado' => $this -> record['estado'],
            'usuario' => auth()->user()->name,
        ]);

        $this->dispatchBrowserEvent('hide-form');
        $this->dispatchBrowserEvent('msg-save');
        
    }

    public function updateData(){

        $this ->validate([
            'record.id' => 'required',
            'record.descripcion' => 'required',
            'record.area_id' => 'required',
            'record.estado'=> 'required',          
        ]);
        
        
        if ($this->selectId){
            $record = TmAsignaturas::find($this->selectId);
            $record->update([
                'descripcion' => $this -> record['descripcion'],
                'estado' => $this -> record['estado'],
            ]);
            
        }
      
        $this->dispatchBrowserEvent('hide-form');
        $this->dispatchBrowserEvent('msg-edit');
        
    }

    public function deleteData(){

        $record = TmAsignaturas::find($this->selectId);
        $record->update([
            'estado' => 'I',
        ]);

        $this->dispatchBrowserEvent('hide-delete');
        
    }





}
