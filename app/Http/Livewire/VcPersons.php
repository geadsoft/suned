<?php

namespace App\Http\Livewire;
use App\Models\TmPersonas;

use Livewire\Component;
use Livewire\WithPagination;

class VcPersons extends Component
{   
    use WithPagination;

    public $filters = [
        'srv_nombre' => '',
    ];
  
    public function render()
    {
        
        /*$tblrecords = TmPersonas::where('tipopersona','E')->orderBy('apellidos','asc')->paginate(10);*/
        $tblrecords = TmPersonas::query()
        ->when($this->filters['srv_nombre'],function($query){
            return $query->where('tm_personas.nombres','like','%'.$this->filters['srv_nombre'].'%')
                        ->orWhere('tm_personas.apellidos','like','%'.$this->filters['srv_nombre'].'%');
        })
        ->where('tm_personas.tipopersona','=','E')
        ->orderBy('apellidos','asc')
        ->paginate(10);


        $views = TmPersonas::find(1);
        $this->view = $views;
        
        return view('livewire.vc-persons',[
            'tblrecords' => $tblrecords
        ]);

    }

    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }

    public function view( $id ){
        
        $this->view = TmPersonas::find($id)->toArray();

    }

    public function edit(TmPersonas $tblrecords ){
        
        $this->record  = $tblrecords->toArray();
        $this->selectId = $this -> record['id'];

        return redirect()->to('/academic/person-add');

    }

    
}
