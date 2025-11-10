<?php

namespace App\Http\Livewire;

use Livewire\Component;

class DocumentViewer extends Component
{
    public $fileId;
    public $initialRender = 4; // cuántas páginas renderizar al inicio
    public $batchSize = 6;     // cuántas páginas renderizar cuando se necesite más

    public function mount(string $fileId)
    {
        $this->fileId = $fileId;
    }

    public function render()
    {
        return view('livewire.document-viewer');
    }
}