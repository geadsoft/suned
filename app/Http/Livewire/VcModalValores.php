<?php

namespace App\Http\Livewire;
use App\Models\TmMatricula;
use App\Models\TrDeudasCabs;
use App\Models\TrDeudasDets;

use Livewire\Component;

class VcModalValores extends Component
{   
    public $tblrecords=[];
    public $eControl = "disabled", $alumno;
    public $meses = [
        1 => 'Enero',
        2 => 'Febrero',
        3 => 'Marzo',
        4 => 'Abril',
        5 => 'Mayo',
        6 => 'Junio',
        7 => 'Julio',
        8 => 'Agosto',
        9 => 'Septiembre',
        10 => 'Octubre',
        11 => 'Noviembre',
        12 => 'Diciembre',
    ];

    protected $listeners = ['setValores'];

    public function render()
    {   
        return view('livewire.vc-modal-valores',[
            'tblrecords' => $this->tblrecords,
        ]);

    }

    public function setValores($matriculaId){

        $this->tblrecords=[];
        $tblrecords = TrDeudasCabs::query()
        ->selectRaw("Case When left(referencia,3) = 'MAT' Then 'Matricula'
                          When left(referencia,3) = 'PLI' Then 'Plataforma Ingles' 
                          When left(referencia,3) = 'PLE' Then 'Plataforma Español'
                          Else 'Pensión' End as concepto, neto, debito, id as deudaid, month(fecha) as mes")
        ->where('matricula_id',$matriculaId)
        ->where('saldo','>',0)
        ->get();

        
        foreach ( $tblrecords as $key => $record){
            $this->tblrecords[$key][0] = $record['deudaid'];
            $this->tblrecords[$key][1] = $record['concepto'].' '.$this->meses[$record['mes']];
            $this->tblrecords[$key][2] = floatval($record['neto']);
            $this->tblrecords[$key][3] = floatval($record['debito']);
        }
        
    }

    public function estado(){
        $this->eControl = "";
    }

    public function updateMatricula(){

        foreach($this->tblrecords as $key => $data){

            $iddeuda = $data[0];
            $record = TrDeudasCabs::find($iddeuda);
            $record->update([
                'neto' => $data[3],
                'debito' => $data[3],
            ]);

            $deudadets = TrDeudasDets::where('deudacab_id',$iddeuda)
            ->where('tipovalor','DB')
            ->update([
                'valor' => $data[3],
            ]);

        }
        
        $this->dispatchBrowserEvent('hide-valores');
        $this->dispatchBrowserEvent('msg-grabar');

    }



}
