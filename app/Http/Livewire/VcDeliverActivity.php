<?php

namespace App\Http\Livewire;
use App\Models\TmActividades;

use Livewire\Component;

class VcDeliverActivity extends Component
{
    public $selectId, $record, $display_estado="", $display_text="display:none";
    
    public function mount($id){

        $this->selectId = $id;
        $this->load();
    }
    
    public function render()
    {
        return view('livewire.vc-deliver-activity');

        $message = "Registro grabado con éxito!";
        $this->dispatchBrowserEvent('msg-grabar', ['newName' => $message]);
    }

    public function load(){

        $this->record = TmActividades::find($this->selectId);
        $this->texteditor = $this->record['descripcion'];
        
       
        

    }
}
