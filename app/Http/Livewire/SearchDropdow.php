<?php

namespace App\Http\Livewire;
use App\Models\TmPersonas;

use Livewire\Component;

class SearchDropdow extends Component
{   
    public $query;
    public $filters = [
        'srv_nombre' => ''
    ];

    public $string;
    public $modalshow=false;
    public $tblrecords;

    public function mount(){
        $this->filters['srv_nombre']="";
        $this->tblrecords = [];
        $this->query = "";
    }

    public function updatedQuery(){
        
        $this->tblrecords = TmPersonas::where('nombres','like','%'.$this->query.'%')
        ->orWhere('apellidos','like','%'.$this->query.'%')
        ->get()
        ->toArray();

    }

    public function render()
    {         
            /*$tblrecords = TmPersonas::query()
            ->when($this->filters['srv_nombre'],function($query){
                return $query->where('tm_personas.nombres','LIKE','%'."{$this->filters['srv_nombre']}".'%')
                            ->orWhere('tm_personas.apellidos','LIKE','%'."{$this->filters['srv_nombre']}".'%');
            })
            ->select('identificacion','nombres','apellidos')
            ->paginate(10);*/
        
            return view('livewire.search-dropdow');
    
    }

    


}
