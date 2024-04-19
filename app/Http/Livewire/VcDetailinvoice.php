<?php

namespace App\Http\Livewire;

use App\Models\TmPeriodosLectivos;
use App\Models\TmPersonas;
use App\Models\TmMatricula;
use App\Models\TrCobrosCabs;
use App\Models\TrDeudasDets;
use App\Models\TrFacturasCabs;
use App\Models\TrFacturasDets;

use Livewire\Component;

class VcDetailinvoice extends Component
{
    public $detCobros=[];
    public $tbldetails=[];
    public $tblstudent=[];
    public $tblperiodos, $facturaCab;
    public $filters = [
        'srv_personaid' => 0,
        'srv_periodoid' => '',
        'srv_estudianteid' => '',
    ];

    protected $listeners = ['setCobros','setGrabaDetalle'];

    public function render()
    {
        return view('livewire.vc-detailinvoice',[
            'tblrecords' => $this->tbldetails
        ]);

    }

    public function setCobros($estudianteId,$periodoId)
    {
      
        $this->filters['srv_estudianteid'] = $estudianteId;
        $this->filters['srv_periodoid'] = $periodoId;

        $this->detCobros = TmMatricula::query()
        ->join("tr_deudas_cabs as c","c.matricula_id","=","tm_matriculas.id")
        ->join("tr_deudas_dets as d","d.deudacab_id","=","c.id")
        ->leftJoin("tr_facturas_dets as f","f.deudadet_id","=","d.id")        
        ->when($this->filters['srv_estudianteid'],function($query){
            return $query->where('tm_matriculas.estudiante_id',"{$this->filters['srv_estudianteid']}");
        })
        ->when($this->filters['srv_periodoid'],function($query){
            return $query->where('tm_matriculas.periodo_id',"{$this->filters['srv_periodoid']}");
        })        
        ->select('d.*','c.referencia')
        ->where('d.tipo','PAG')
        ->where('d.estado','P')
        ->whereRaw('f.deudadet_id is null')
        ->get();

        $this->addDetalle();
        
    }

    public function addDetalle(){

        $total = 0;
        $this->tbldetails = [];

        foreach ($this->detCobros as $index => $recno)
        { 
            $detalle=[];
            $detalle['seleccion'] = 1;
            $detalle['linea'] = $index+1;
            $detalle['deudadet_id'] = $recno->id;
            $detalle['codigo'] =  $recno->referencia;
            $detalle['descripcion'] =  $recno->detalle;
            $detalle['unidad'] =  'UND';
            $detalle['cantidad'] = 1;
            $detalle['precio'] = $recno->valor;
            $detalle['total'] = $recno->valor;

            $total= $total + $recno->valor;
            array_push($this->tbldetails, $detalle);
        }

        $arrtotales['TotalSinImpto'] = $total;
        $arrtotales['Subtotal0'] = $total;
        $arrtotales['Total'] = $total;

        $this->emitTo('vc-createinvoice','setTotales',$arrtotales);

    }

    public function removeItem($linea){

        $recnoToDelete = $this->tbldetails;
        foreach ($recnoToDelete as $index => $recno)
        {
            if ($recno['linea'] == $linea){
                //$this->cancela = $this->cancela-floatval($recno['valor']);
                unset ($recnoToDelete[$index]);
            } 
        }

        $this->reset(['tbldetails']);
        $this->tbldetails = $recnoToDelete;

        $total = array_sum(array_column($this->tbldetails,'total'));
        $arrtotales['TotalSinImpto'] = $total;
        $arrtotales['Subtotal0'] = $total;
        $arrtotales['Total'] = $total;

        $this->emitTo('vc-createinvoice','setTotales',$arrtotales);
    }

    public function setGrabaDetalle($facturaId){

        $this->facturaCab = TrFacturasCabs::find($facturaId);
        $this->createData();
    }

    public function createData(){

        foreach ($this->tbldetails as $index => $recno)
        {
            TrFacturasDets::Create([
                'periodo' => $this->facturaCab->periodo,
                'mes' => $this->facturaCab->mes,
                'facturacab_id' => $this->facturaCab->id,
                'linea' => $recno['linea'],
                'deudadet_id' => $recno['deudadet_id'],
                'codigo' => $recno['codigo'],
                'descripcion' => $recno['descripcion'],
                'unidad' => $recno['unidad'],
                'cantidad' => $recno['cantidad'],
                'precio' => $recno['precio'],
                'descuento' => 0,
                'impuesto' => 0,
                'total' => $recno['total'],
                'estado' => 'C',
                'usuario' => auth()->user()->name,
            ]);
            
            $record = TrFacturasDets::find($recno['deudadet_id']);
            $record->update([
                'facturado' => true,
            ]);

        }

    }

}
