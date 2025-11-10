<?php

namespace App\Http\Livewire;

use Livewire\Component;
use GuzzleHttp\Client;
use Spatie\PdfToImage\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class VcFlipbookViewer extends Component
{
    public $fileId;

    public function mount($id){
        $this->fileId = $id;
    }
    
    public function render()
    {
        return view('livewire.vc-flipbook-viewer');
    }
    
}
