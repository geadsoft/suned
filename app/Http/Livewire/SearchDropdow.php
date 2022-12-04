<?php

namespace App\Http\Livewire;
use App\Models\TmPersonas;

use Livewire\Component;

class SearchDropdow extends Component
{   

    public $filters = [
        'srv_nombre' => ''
    ];
    public $string;
    public $modalshow=false;

    public function mount(){
        $this->filters['srv_nombre']="";
    }

    public function render()
    {   
            $this->modalshow = true;        
            $tblrecords = TmPersonas::query()
            ->when($this->filters['srv_nombre'],function($query){
                return $query->where('tm_personas.nombres','LIKE','%'."{$this->filters['srv_nombre']}".'%')
                            ->orWhere('tm_personas.apellidos','LIKE','%'."{$this->filters['srv_nombre']}".'%');
            })
            ->select('identificacion','nombres','apellidos')
            ->paginate(10);
        
            return view('livewire.search-dropdow',[
                'tblrecords' => $tblrecords,
            ]);
    

    }

    


}
