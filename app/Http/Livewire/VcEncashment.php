<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\TmPersonas;
use App\Models\TrCobrosCabs;
use App\Models\TrCobrosDets;
use App\Models\TrDeudasCabs;
use App\Models\TrDeudasDets;
use App\Models\TmPeriodosLectivos;
use App\Models\TmMatricula;
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

    public $documento, $concepto, $fecha, $identificacion, $estudiante, $curso, $grupo, $grado, $comentario, $estado, $nromatricula;

    public $subtotal = 0;
    public $descuento = 0;
    public $total = 0;
    public $totalpago = 0;

    public function mount($id){
        $this->selectId = $id;
    }

    public function render()
    {   

        if ($this->selectId==0){
            $this->record   = TrCobrosCabs::orderBy('id', 'desc')->first();
            $this->selectId = $this->record['id'];
        }else{
            $this->record  = TrCobrosCabs::find($this->selectId);
        }

        $this->loadData();  

        $tblcobrodet = TrCobrosDets::where('cobrocab_id',$this->selectId)->get();
        $tbldeudas   = TrDeudasDets::where([
            ['cobro_id',$this->selectId],
            ['tipovalor',"CR"],
        ])
        ->whereIn('tipo',["PAG","OTR"])
        ->get();
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
        $this->estado = $this->record['estado'];

        $datacobro = TrCobrosCabs::join("tr_deudas_dets as dt","tr_cobros_cabs.id","=","dt.cobro_id")
        ->join("tr_deudas_cabs as dc","dc.id","=","dt.deudacab_id")
        ->where('tr_cobros_cabs.id',$this->selectId)
        ->first();

        $matricula = TmMatricula::join("tm_cursos","tm_matriculas.curso_id","=","tm_cursos.id")
        ->join("tm_servicios","tm_cursos.servicio_id","=","tm_servicios.id")
        ->join("tm_generalidades","tm_servicios.modalidad_id","=","tm_generalidades.id")
        ->where('tm_matriculas.id',$datacobro['matricula_id'])
        ->select('tm_generalidades.descripcion AS nomGrupo', 'tm_servicios.descripcion AS nomGrado', 'tm_cursos.paralelo', 'tm_matriculas.comentario','tm_matriculas.documento')
        ->first();
            
        if($matricula!=null){
            $this->grupo = $matricula['nomGrupo'];
            $this->curso = $matricula['nomGrado']." - ".$matricula['paralelo'];
            $this->comentario   = $matricula['comentario'];
            $this->nromatricula = $matricula['documento'];
        }

    }

    public function calculatotal($tblDeuda){
        
        foreach ($tblDeuda as $deudas)
        {
            $this->subtotal += $deudas->deudacab->saldo+$deudas['valor']+$deudas->deudacab->descuento;
            $this->descuento += $deudas->deudacab->descuento;
            $this->totalpago += $deudas['valor'];
        }
        $this->total = $this->subtotal-$this->descuento;

    }

    public function add(){

        $this->dispatchBrowserEvent('show-form');
    }

    public function delete($selectId){

        $this->dispatchBrowserEvent('show-delete');

    }

    public function anular($selectId){

        $this->dispatchBrowserEvent('show-anular');

    }

    public function deleteData(){
        
        $detdeudas = TrDeudasDets::where("cobro_id",$this->selectId)->get();

        foreach($detdeudas as $deuda){

            $cabdeuda = TrDeudasCabs::find($deuda['deudacab_id']);
            $cabdeuda->update([
                'credito' => $cabdeuda['credito']-$deuda['valor'],
                'saldo' => $cabdeuda['saldo']+$deuda['valor'],
            ]);

            TrDeudasDets::find($deuda['id'])->delete();
        }

        TrCobrosDets::where("cobrocab_id",$this->selectId)->delete();
        TrCobrosCabs::find($this->selectId)->delete();

        $this->dispatchBrowserEvent('hide-delete');
        
        return redirect()->to('/financial/list-income');

    }

    public function anularData(){
        
        $detdeudas = TrDeudasDets::where("cobro_id",$this->selectId)->get();

        if($this->estado=='A'){

            foreach($detdeudas as $deuda){

                $cabdeuda = TrDeudasCabs::find($deuda['deudacab_id']);
                $cabdeuda->update([
                    'credito' => $cabdeuda['credito']+$deuda['valor'],
                    'saldo' => $cabdeuda['saldo']-$deuda['valor'],
                ]);

                TrDeudasDets::find($deuda['id'])->update([
                    'estado' => 'P',
                ]);
            }

            TrCobrosDets::where("cobrocab_id",$this->selectId)->update([
                'estado' => 'P',
            ]);
            
            TrCobrosCabs::find($this->selectId)->update([
                'estado' => 'P',
            ]);

        }else{

            foreach($detdeudas as $deuda){

                $cabdeuda = TrDeudasCabs::find($deuda['deudacab_id']);
                $cabdeuda->update([
                    'credito' => $cabdeuda['credito']-$deuda['valor'],
                    'saldo' => $cabdeuda['saldo']+$deuda['valor'],
                ]);

                TrDeudasDets::find($deuda['id'])->update([
                    'estado' => 'A',
                ]);
            }

            TrCobrosDets::where("cobrocab_id",$this->selectId)->update([
                'estado' => 'A',
            ]);
            
            TrCobrosCabs::find($this->selectId)->update([
                'estado' => 'A',
            ]);

        }

        $this->dispatchBrowserEvent('hide-anular');
        
        return redirect()->to('/financial/list-income');

    }


    public function liveWirePDF($selectId)
    {   

        $fpago = [
            'EFE' => 'Efectivo',
            'CHQ' => 'Cheque',
            'TAR' => 'Tarjeta',
            'DEP' => 'Depósito',
            'TRA' => 'Transferencia',
            'APP' => 'App Movil',
            'RET' => 'Retención',
            'OTR' => 'Otros',
            'CON' => 'Convenio',
        ];

        $this->record = TrCobrosCabs::find($selectId);
        $tblcobrodet  = TrCobrosDets::where('cobrocab_id',$selectId)->get();
        $tbldeudas    = TrDeudasDets::query()
        ->join("tr_deudas_cabs","tr_deudas_cabs.id","=","tr_deudas_dets.deudacab_id")
        ->select('tr_deudas_cabs.referencia','tr_deudas_dets.fecha','tr_deudas_dets.detalle','tr_deudas_cabs.descuento','tr_deudas_dets.valor','tr_deudas_cabs.saldo','tr_deudas_cabs.debito')
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
            'TRA' => 'Transferencia',
            'APP' => 'App Movil',
            'RET' => 'Retención',
            'OTR' => 'Otros',
            'CON' => 'Convenio',
        ];

        $this->record = TrCobrosCabs::find($selectId);
        $tblcobrodet  = TrCobrosDets::where('cobrocab_id',$selectId)->get();
        $tbldeudas    = TrDeudasDets::query()
        ->join("tr_deudas_cabs","tr_deudas_cabs.id","=","tr_deudas_dets.deudacab_id")
        ->select('tr_deudas_cabs.referencia','tr_deudas_dets.fecha','tr_deudas_dets.detalle','tr_deudas_cabs.descuento','tr_deudas_dets.valor','tr_deudas_cabs.saldo','tr_deudas_cabs.debito')
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
