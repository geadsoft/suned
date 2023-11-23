<?php

namespace App\Http\Livewire;

use Livewire\Component;

class VcSolicitudes extends Component
{
    public $fecha,$documento,$nombres,$nui;

    public function render()
    {
        return view('livewire.vc-solicitudes');
    }
}
