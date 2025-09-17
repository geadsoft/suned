<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Spatie\PdfToImage\Pdf;
use Illuminate\Support\Facades\Storage;

class VcFlipbookViewer extends Component
{
           
    public $fileId; // ID de Google Drive
    public $pages = []; // URLs de imágenes del flipbook

    public function mount($fileId)
    {
        $this->fileId = $fileId;
        $this->generatePagesFromGoogleDrive($fileId);
    }

    protected function generatePagesFromGoogleDrive($fileId)
    {
        // 1. Descargar PDF desde Google Drive
        $url = "https://drive.google.com/uc?export=download&id={$fileId}";
        $pdfContent = file_get_contents($url);

        if (!$pdfContent) return;

        $tempPath = storage_path('app/temp.pdf');
        file_put_contents($tempPath, $pdfContent);

        // 2. Convertir PDF a imágenes
        $pdf = new Pdf($tempPath);
        $pageCount = $pdf->getNumberOfPages();

        $this->pages = [];
        for ($i = 1; $i <= $pageCount; $i++) {
            $imagePath = storage_path("app/flipbook_page_{$i}.jpg");
            $pdf->setPage($i)->saveImage($imagePath);
            $this->pages[] = asset("storage/flipbook_page_{$i}.jpg");
        }

        // 3. Limpiar archivo temporal
        unlink($tempPath);
    }

    public function render()
    {
        return view('livewire.vc-flipbook-viewer');
    }
    
}
