<?php

namespace App\Http\Livewire;

use App\Models\TmReportes;
use App\Models\TmSedes;

use Livewire\Component;
use PDF;

class VcSolicitudes extends Component
{
    public $fecha,$documento,$nombres,$nui;
    public $solicitud=[];

    public function mount(){
        $this->loadData();
    }

    public function render()
    {
        return view('livewire.vc-solicitudes');
    }

    public function loadData(){
        $objData['categoria'] = 'C';
        $objData['subcategoria'] = 'Matricula';
        $objData['periodo'] = '';
        $objData['curso'] = '';
        $objData['tiempo'] = '2 dias laborales';
        array_push($this->solicitud, $objData);
        $objData['categoria'] = 'C';
        $objData['subcategoria'] = 'Conducta';
        $objData['periodo'] = '';
        $objData['curso'] = '';
        $tobjData['tiempo'] = '2 dias laborales';
        array_push($this->solicitud, $objData);
        $objData['categoria'] = 'C';
        $objData['subcategoria'] = 'Asistencia';
        $objData['periodo'] = '';
        $objData['curso'] = '';
        $objData['tiempo'] = '2 dias laborales';
        array_push($this->solicitud, $objData);
        $objData['categoria'] = 'C';
        $objData['subcategoria'] = 'Aprovechamiento';
        $objData['periodo'] = '';
        $objData['curso'] = '';
        $objData['tiempo'] = '2 dias laborales';
        array_push($this->solicitud, $objData);
        $objData['categoria'] = 'C';
        $objData['subcategoria'] = 'Libreta Escolar';
        $objData['periodo'] = '';
        $objData['curso'] = '';
        $objData['tiempo'] = '2 dias laborales';
        array_push($this->solicitud, $objData);
        $objData['categoria'] = 'C';
        $objData['subcategoria'] = 'Promoción';
        $tobjData['periodo'] = '';
        $objData['curso'] = '';
        $objData['tiempo'] = '8 dias laborales';
        array_push($this->solicitud, $objData);
        $objData['categoria'] = 'C';
        $objData['subcategoria'] = 'Pase Reglamentario';
        $objData['periodo'] = '';
        $objData['curso'] = '';
        $objData['tiempo'] = '2 dias laborales';
        array_push($this->solicitud, $objData);
        $objData['categoria'] = 'C';
        $objData['subcategoria'] = 'Retiro de Expediente';
        $objData['periodo'] = '';
        $objData['curso'] = '';
        $objData['tiempo'] = '15 dias laborales';
        array_push($this->solicitud, $objData);

        $objData['categoria'] = 'E';
        $objData['subcategoria'] = 'Participacion Estudiantil'."\n".'120 Horas';
        $objData['periodo'] = '';
        $objData['curso'] = '';
        $objData['tiempo'] = '8 dias laborales';
        array_push($this->solicitud, $objData);
        $objData['categoria'] = 'E';
        $objData['subcategoria'] = 'Participacion Estudiantil'."\n".'100 Horas';
        $objData['periodo'] = '';
        $objData['curso'] = '';
        $objData['tiempo'] = '8 dias laborales';
        array_push($this->solicitud, $objData);
        $objData['categoria'] = 'E';
        $objData['subcategoria'] = 'Participacion Estudiantil'."\n".'80 Horas';
        $objData['periodo'] = '';
        $objData['curso'] = '';
        $objData['tiempo'] = '8 dias laborales';
        array_push($this->solicitud, $objData);
        $objData['categoria'] = 'E';
        $objData['subcategoria'] = 'Pasantias';
        $objData['periodo'] = '';
        $objData['curso'] = '';
        $objData['tiempo'] = '2 dias laborales';
        array_push($this->solicitud, $objData);
        
        $objData['categoria'] = 'G';
        $objData['subcategoria'] = 'Acta Original'."\n".'2000-2021';
        $objData['periodo'] = '';
        $objData['curso'] = '';
        $objData['tiempo'] = '8 dias laborales';
        array_push($this->solicitud, $objData);
        $objData['categoria'] = 'G';
        $objData['subcategoria'] = 'Duplicado Acta'."\n".'2000-2021';
        $objData['periodo'] = '';
        $objData['curso'] = '';
        $objData['tiempo'] = '8 dias laborales';
        array_push($this->solicitud, $objData);
        $objData['categoria'] = 'G';
        $objData['subcategoria'] = 'Acta Original'."\n".'1984-1999';
        $objData['periodo'] = '';
        $objData['curso'] = '';
        $objData['tiempo'] = '8 dias laborales';
        array_push($this->solicitud, $objData);
        $objData['categoria'] = 'G';
        $objData['subcategoria'] = 'Duplicado Acta'."\n".'1984-1999';
        $objData['periodo'] = '';
        $objData['curso'] = '';
        $objData['tiempo'] = '8 dias laborales';
        array_push($this->solicitud, $objData);
        $objData['categoria'] = 'G';
        $objData['subcategoria'] = 'Título de Bachiller'."\n".'2000-2021';
        $objData['periodo'] = '';
        $objData['curso'] = '';
        $objData['tiempo'] = '8 dias laborales';
        array_push($this->solicitud, $objData);
        $objData['categoria'] = 'G';
        $objData['subcategoria'] = 'Título de Bachiller'."\n".'1984-1999';;
        $objData['periodo'] = '';
        $objData['curso'] = '';
        $objData['tiempo'] = '15 dias laborales';
        array_push($this->solicitud, $objData);

        return $this->solicitud;

    }

    public function print(){

        return redirect()->to('/preview-pdf/requests');

    }

    public function printPDF()
    {   
        $data    = TmReportes::find(7);
        $formato = $this->loadData(); 
        $sede = TmSedes::orderBy('id','desc')->first();

        $pdf = PDF::loadView('reports/solicitudes',[
            'sede'  => $sede,
            'data'  => $data,
            'solicitud' => $formato,
        ]);

        return $pdf->setPaper('a4')->stream('Solicitud.pdf');
    }


}
