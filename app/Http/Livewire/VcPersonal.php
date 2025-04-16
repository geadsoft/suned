<?php

namespace App\Http\Livewire;
use App\Models\TmPersonas;

use Livewire\Component;
use Livewire\WithPagination;

class VcPersonal extends Component
{   
    use WithPagination;

    public $arrtipo=[
        'A' => 'Administrativo',
        'D' => 'Docente',
        'P' => 'Apoyo Profesional',
        'M' => 'Mantenimiento y Operaciones'
    ];
  
    public function render()
    {
        
        $tblrecords = TmPersonas::whereRaw("tipopersona in ('A','D','P','M')")
        ->orderBy('apellidos','asc')->paginate(13);
        
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

    
}
