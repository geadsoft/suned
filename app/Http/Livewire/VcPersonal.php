<?php

namespace App\Http\Livewire;
use App\Models\TmPersonas;

use Livewire\Component;
use Livewire\WithPagination;

class VcPersonal extends Component
{   
    use WithPagination;

    
  
    public function render()
    {
        
        $tblrecords = TmPersonas::whereRaw("tipopersona <> 'E' and tipopersona <> 'R'")->orderBy('apellidos','asc')->paginate(10);
        
        return view('livewire.vc-personal',[
            'tblrecords' => $tblrecords
        ]);

    }

    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }

    public function edit(TmPersonas $tblrecords ){
        
        $this->record  = $tblrecords->toArray();
        $this->selectId = $this -> record['id'];

        return redirect()->to('/academic/person-add');

    }

    
}
