<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\TmPersonas;
use App\Models\TrCobrosCabs;
use App\Models\TrCobrosDets;
use App\Models\TrDeudasDets;
use App\Models\TmPeriodosLectivos;
use PDF;


class VcEncashment extends Component
{
    public $selectId;
    public $fila=1;
    public $record;
    public $persona;
    public $idbuscar="";
    public $nombre="";
    public $selectpago = false;

    public $documento, $concepto, $fecha, $identificacion, $estudiante, $grupo, $grado, $comentario;

    public $subtotal = 0;
    public $descuento = 0;
    public $total = 0;
    public $totalpago = 0;

    public function render()
    { 
        
        $this->record  = TrCobrosCabs::orderBy('id', 'desc')->first();
        if ($this->record==null){
            $this->selectId = 0;
        }else{
            $this->selectId = $this->record['id'];
            $this->loadData();
        }      

        $tblcobrodet = TrCobrosDets::where('cobrocab_id',$this->selectId)->get();
        $tbldeudas   = TrDeudasDets::where([
            ['cobro_id',$this->selectId],
            ['tipovalor',"CR"],
            ['tipo',"PAG"],
        ])->get();
        $tblperiodos = TmPeriodosLectivos::all();
        
        $this->calculatotal($tbldeudas);

        return view('livewire.vc-encashment',[
            'tblcobrodet' => $tblcobrodet,
            'tbldeudas' => $tbldeudas,
            'tblperiodos' => $tblperiodos,

        ]);
        
    }

    public function loadData(){

        $this->fecha = date('Y-m-d',strtotime($this->record['fecha']));
        $this->documento =  $this->record['documento'];
        $this->concepto = $this->record['concepto'];
        $this->identificacion = $this->record->estudiante->identificacion;
        $this->estudiante = $this->record->estudiante->apellidos." ".$this->record->estudiante->nombres;

    }

    public function calculatotal($tblDeuda){
        
        foreach ($tblDeuda as $deudas)
        {
            $this->subtotal += $deudas->deudacab->saldo+$deudas['valor'];
            $this->descuento += 0.00;
            $this->totalpago += $deudas['valor'];
        }
        $this->total = $this->subtotal-$this->descuento;

    }

    public function add(){
        
        $this->dispatchBrowserEvent('search-form');
    }


    public function liveWirePDF($selectId)
    {   

        $fpago = [
            'EFE' => 'Efectivo',
            'CHQ' => 'Cheque',
            'TAR' => 'Tarjeta',
            'DEP' => 'Depósito',
            'TRA' => 'Tarjeta',
            'CON' => 'Convenio',
        ];

        $this->record = TrCobrosCabs::find($selectId);
        $tblcobrodet  = TrCobrosDets::where('cobrocab_id',$selectId)->get();
        $tbldeudas    = TrDeudasDets::query()
        ->join("tr_deudas_cabs","tr_deudas_cabs.id","=","tr_deudas_dets.deudacab_id")
        ->select('tr_deudas_cabs.referencia','tr_deudas_dets.fecha','tr_deudas_dets.detalle','tr_deudas_cabs.descuento','tr_deudas_dets.valor','tr_deudas_cabs.saldo')
        ->where([
            ['cobro_id',$selectId],
            ['tipovalor',"CR"],
            ['tipo',"PAG"],
        ])->get();          
        
        $pdf = PDF::loadView('financial/comprobante_cobro',[
            'tblrecords' => $this->record,
            'tblcobros' => $tblcobrodet,
            'tbldeudas' => $tbldeudas,
            'fpago' => $fpago,
        ]);

        return $pdf->setPaper('a4')->stream('Comprobante.pdf');
    }

    public function downloadPDF($selectId)
    {   

        $fpago = [
            'EFE' => 'Efectivo',
            'CHQ' => 'Cheque',
            'TAR' => 'Tarjeta',
            'DEP' => 'Depósito',
            'TRA' => 'Tarjeta',
            'CON' => 'Convenio',
        ];

        $this->record = TrCobrosCabs::find($selectId);
        $tblcobrodet  = TrCobrosDets::where('cobrocab_id',$selectId)->get();
        $tbldeudas    = TrDeudasDets::query()
        ->join("tr_deudas_cabs","tr_deudas_cabs.id","=","tr_deudas_dets.deudacab_id")
        ->select('tr_deudas_cabs.referencia','tr_deudas_dets.fecha','tr_deudas_dets.detalle','tr_deudas_cabs.descuento','tr_deudas_dets.valor','tr_deudas_cabs.saldo')
        ->where([
            ['cobro_id',$selectId],
            ['tipovalor',"CR"],
            ['tipo',"PAG"],
        ])->get();          
        
        $pdf = PDF::loadView('financial/comprobante_cobro',[
            'tblrecords' => $this->record,
            'tblcobros' => $tblcobrodet,
            'tbldeudas' => $tbldeudas,
            'fpago' => $fpago,
        ]);

        $documento = 'Comprobante_'.$this->record['documento'].'.pdf';
        return $pdf->download($documento);
    }


}
