<?php

namespace App\Http\Livewire;
use App\Models\TmPersonas;
use Livewire\WithPagination;

use Livewire\Component;

class VcPersons extends Component
{
    public function render()
    {
        
        $tblrecords = TmPersonas::paginate(10);

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
