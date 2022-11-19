<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\TmPersonas;
use App\Models\TrCobrosCabs;
use App\Models\TrCobrosDets;
use App\Models\TrDeudasDets;
use App\Models\TmPeriodosLectivos;


class VcEncashment extends Component
{
    public $selectId;
    public $fila=1;
    public $documento;
    public $record;
    public $persona;
    public $idbuscar="";
    public $nombre="";
    public $selectpago = false;

    public $subtotal = 0;
    public $descuento = 0;
    public $total = 0;
    public $totalpago = 0;

    public function render()
    { 
        
        $this->record  = TrCobrosCabs::orderBy('id', 'desc')->first();
        if ($this->record['id']==null){
            $this->selectId = 0;
        }else{
            $this->selectId = $this->record['id'];
        }      

        $tblcobrodet = TrCobrosDets::where('cobrocab_id',$this->selectId)->get();
        $tbldeudas   = TrDeudasDets::where('cobro_id',$this->selectId)->get();
        $tblperiodos = TmPeriodosLectivos::all();
        
        $this->calculatotal($tbldeudas);

        return view('livewire.vc-encashment',[
            'tblcobrodet' => $tblcobrodet,
            'tbldeudas' => $tbldeudas,
            'tblperiodos' => $tblperiodos,

        ]);
        
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


}
