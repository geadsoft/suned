<?php

namespace App\Http\Livewire;

use Livewire\Component;

class VcSuggestionBox extends Component
{
    public $proceso, $tipo, $identificacion, $nombres, $email, $telefono, $texteditor;
    
    public function render()
    {
        return view('livewire.vc-suggestion-box');
    }
}
