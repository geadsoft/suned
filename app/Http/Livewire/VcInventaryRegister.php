<?php

namespace App\Http\Livewire;

use Livewire\Component;

class VcInventaryRegister extends Component
{
    public $linea, $fecha, $tipo='ING', $transac='CL', $referencia, $estudianteId, $comentario, $fpago='NN';
    protected $listeners = ['view'];

    public function mount(){
        $ldate = date('Y-m-d H:i:s');
        $this->fecha = date('Y-m-d',strtotime($ldate));
    }

    public function render()
    {
        return view('livewire.vc-inventary-register');
    }

    public function view($linea){
        $this->linea = $linea;
        $this->dispatchBrowserEvent('show-form');
    }

    public function buscar(){
        $this->dispatchBrowserEvent('show-persona');
    }

    public function updatedtipo($id){

        if($id=="ING"){
            $this->transac="CL";
            $this->fpago='NN';
        }else{
            $this->transac="VE";
            $this->fpago='EFE';
        }

    }       

}
