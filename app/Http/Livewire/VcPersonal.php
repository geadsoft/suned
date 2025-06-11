<?php

namespace App\Http\Livewire;
use App\Models\TmPersonas;

use Livewire\Component;
use Livewire\WithPagination;

class VcPersonal extends Component
{   
    use WithPagination;

    public $buscarDato;
    public $arrtipo=[
        'A' => 'Administrativo',
        'D' => 'Docente',
        'P' => 'Apoyo Profesional',
        'M' => 'Mantenimiento y Operaciones'
    ];

    
  
    public function render()
    {
        
        $tblrecords = TmPersonas::whereRaw("tipopersona in ('A','D','P','M')")
        ->when($this->buscarDato,function($query){
            return $query->whereRaw("concat(tm_personas.apellidos,' ',tm_personas.nombres) LIKE '%".$this->buscarDato."%'");
        })
        ->orderBy('apellidos','asc')->paginate(12);
        
        return view('livewire.vc-personal',[
            'tblrecords' => $tblrecords
        ]);

    }

    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }

    public function edit($personalId){

        return redirect()->to('/headquarters/staff-edit/'.$personalId);

    }

    public function view($personalId){

        return redirect()->to('/headquarters/staff-view/'.$personalId);

    }

     public function retirar($personalId){

        $personal = TmPersonas::find($personalId);

        if ($personal->tipopersona=='D'){
            return redirect()->to('/headquarters/remove-teacher/'.$personalId);
        }else{

        }
        
    }

    
}
