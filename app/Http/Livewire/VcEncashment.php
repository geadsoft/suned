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


}
