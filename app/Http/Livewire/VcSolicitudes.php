<?php

namespace App\Http\Livewire;

use App\Models\TmReportes;

use Livewire\Component;
use PDF;

class VcSolicitudes extends Component
{
    public $fecha,$documento,$nombres,$nui;

    public function render()
    {
        return view('livewire.vc-solicitudes');
    }

    public function print(){

        return redirect()->to('/preview-pdf/requests');

    }

    public function printPDF()
    {   
        $data  = TmReportes::find(8);
        
        $pdf = PDF::loadView('reports/solicitudes',[
            'data'  => $data,
        ]);

        return $pdf->setPaper('a4')->stream('Solicitud.pdf');
    }


}
