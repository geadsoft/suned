<?php

namespace App\Http\Livewire;

use App\Models\TrInventarioCabs;
use App\Models\TrInventarioDets;
use App\Models\TmProductos;

use Livewire\Component;
use Livewire\WithPagination;

class VcInventaryMovements extends Component
{
    
    use WithPagination;

    public $registro;

    public $tipo = [
        'EGR' => 'Egreso',
        'ING' => 'Ingreso'
    ];

    public $movimiento=[
        'II' => 'Inventario Inicial',
        'CL' => 'Compras Locales',
        'IA' => 'Ingreso por Ajuste',
        'VE' => 'Venta',
        'EA' => 'Egreso por Ajuste',
    ];

    public $fpago=[
        "NN" => 'Ninguno',
        "EFE" => 'Efectivo',
        "CHQ" => 'Cheque',
        "TAR" => 'Tarjeta',
        "DEP" => 'Depósito',
        "TRA" => 'Transferencia',
        "APP" => 'App Movil',

    ];

    public $filters=[
        'producto_id' => '',
        'tipo' => '',
        'movimiento' => '',
        'fecha_ini' => '',
        'fecha_fin' => '',
        'estado' => '',
    ];
    
    public function render()
    {
        
        $tblrecords = TrInventarioCabs::query()
        ->when($this->filters['producto_id'],function($query){
            return $query->where('producto_id',"{$this->filters['producto_id']}");
        })
        ->when($this->filters['tipo'],function($query){
            return $query->where('tipo',"{$this->filters['tipo']}");
        })
        ->when($this->filters['movimiento'],function($query){
            return $query->where('movimiento',"{$this->filters['movimiento']}");
        })
        ->when($this->filters['fecha_ini'],function($query){
            return $query->where('fecha','>',"{$this->filters['fecha_ini']}");
        })
        ->when($this->filters['fecha_fin'],function($query){
            return $query->where('fecha','<',"{$this->filters['fecha_fin']}");
        })
        ->when($this->filters['estado'],function($query){
            return $query->where('estado',"{$this->filters['estado']}");
        })
        ->paginate(12);

        $this->registro = $tblrecords->where('estado','G')->count();
       
        return view('livewire.vc-inventary-movements',[
            'tblrecords' => $tblrecords
        ]);

    }

    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }

    public function filterTab($filter){

        if($filter=='G'){
            $this->filters['estado'] = $filter;
        }else{
            $this->filters['tipo'] = $filter;
        }

    }

    public function edit($id){

        $invCab = TrInventarioCabs::find($id);

        if($invCab['estado']=='P'){
            return;
        }

        return redirect()->to('/inventary/register-edit/'.$id);
    }

    public function procesar($id){

        $registroId = $id;
        
        $invCab = TrInventarioCabs::find($registroId);
        $invtra = TrInventarioDets::where('inventariocab_id',$registroId)->get();

        if($invCab['estado']=='P'){
            return;
        }
        
        if ($invCab['tipo']=='ING'){
        
            foreach ($invtra as $index => $record)
            {
                $producto = TmProductos::find($record['producto_id']);
                $producto->update([
                    'stock' => $producto['stock']+$record['cantidad'],
                ]);
            }

            $invCab->update([
                'estado' => 'P',
            ]);

            TrInventarioDets::where("inventariocab_id",$registroId)->update(["estado" => "P"]);

        }else{
            
            $error='';

            /*Valida Stock*/
            foreach ($invtra as $index => $record)
            {
                $producto = TmProductos::find($record['producto_id']);
                $stock = $producto['stock'];
                
                if ($record['cantidad']>$stock & $producto['maneja_stock']==1){
                    $error = $error.$producto['nombre'].', Cantidad Digitada: '.$record['cantidad'].' es mayor al Stock: '.$stock."\n";
                }
            }

            if (!empty($error)){
                $this->dispatchBrowserEvent('error-stock', ['newName' => $error]);
                return;
            }

            /* Actualiza Stock*/
            foreach ($invtra as $index => $record)
            {
                $producto = TmProductos::find($record['producto_id']);
                $producto->update([
                    'stock' => $producto['stock']-$record['cantidad'],
                ]);
            }

            $invCab->update([
                'estado' => 'P',
            ]);

            TrInventarioDets::where("inventariocab_id",$registroId)->update(["estado" => "P"]);

        }

        $message = "Documento ".$invCab['documento']." procesado con éxito!";
        $this->dispatchBrowserEvent('msg-grabar', ['newName' => $message]);

    }


}
