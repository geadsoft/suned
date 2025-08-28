<?php

namespace App\Http\Livewire;

use Livewire\Component;

class VcFlipbookViewer extends Component
{
           
    public $fileId; // ID del archivo en Google Drive

    public function mount($fileId)
    {
        $this->fileId = $fileId;
    }

    public function render()
    {
        return view('livewire.vc-flipbook-viewer');
    }
    
}
