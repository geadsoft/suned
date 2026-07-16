<?php

namespace App\Http\Livewire;

use Livewire\Component;

class VcRegistrarDocumentos extends Component
{
    public $fileimg, $foto;
    
    public function render()
    {
        return view('livewire.vc-registrar-documentos');
    }
}
