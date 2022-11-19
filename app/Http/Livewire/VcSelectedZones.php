<?php

namespace App\Http\Livewire;
use App\Models\TmZonas;
use Livewire\Component;

class VcSelectedZones extends Component
{   

    public $selectedProvincia=null;
    public $selectedCanton=null;
    public $selectedParroquia=null;
    public $tblcantones=null;
    public $tblparroquias=null;
   
    public function mount()
    {
        $this->updatedselectedProvincia($this->selectedProvincia);
        $this->updatedselectedCanton($this->selectedCanton);
    }


    public function render()
    {
        $tblprovincias = TmZonas::where('superior',0)->get();
        return view('livewire.vc-selected-zones',[
            'tblprovincias' => $tblprovincias,
        ]);
    }

    public function updatedselectedProvincia($id){

        $provincia = TmZonas::where('id',$id)->first();      
        $this->tblcantones = TmZonas::where('superior',$provincia['codigo'])->get();

    }

    public function updatedselectedCanton($id){

        $canton = TmZonas::where('id',$id)->first(); 
        $this->tblparroquias = TmZonas::where('superior',$canton['codigo'])->get();

    }

 

}
