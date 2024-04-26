<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\TrInventarioCabs;
use App\Models\TrInventarioDets;
use App\Models\TmProductos;

class VcInventaryRegister extends Component
{
    public $linea, $status, $tipo='ING', $fecha, $inventarioId=0;
    public $record=[];
    
    protected $listeners = ['view'];

    public function mount(){
        
        $record = TrInventarioCabs::find(0);
        $this->load();
        
    }

    public function render()
    {
        return view('livewire.vc-inventary-register');
    }

    public function load(){
        
        $this->status = 'disabled';
        $this->record = TrInventarioCabs::orderBy('id','desc')->first();
               
        if (empty($this->record)){
            $ldate = date('Y-m-d H:i:s');
            $this->record['documento'] = '';
            $this->record['fecha'] = date('Y-m-d',strtotime($ldate));
            $this->record['tipo'] = 'ING';
            $this->record['movimiento'] = 'CL';
            $this->record['tipopago'] = 'NN';
        }else{

            $this->record = $this->record->toarray();

            $fecha = $this->record['fecha'];
            $this->record['fecha'] = date('Y-m-d',strtotime($fecha));
            $this->inventarioId = $this->record['id'];

        }

    }

    public function view($linea){
        $this->linea = $linea;
        $this->dispatchBrowserEvent('show-form');
    }

    public function buscar(){
        $this->dispatchBrowserEvent('show-persona');
    }

    public function updatedtipo($tipo){

        if($tipo=="ING"){
            $this->record['tipo'] = $tipo;
            $this->record['movimiento'] = 'CL';
            $this->record['tipopago'] = 'NN';
        }else{
            $this->record['tipo'] = $tipo;
            $this->record['movimiento'] = 'VE';
            $this->record['tipopago'] = 'NN';
        }

    }
    
    public function add()
    {
        $this->status = 'enabled';       
        $this->record = TrInventarioCabs::find(0);
        $this->inventarioId = 0;

        $ldate = date('Y-m-d H:i:s');
        $this->record['documento'] = '';
        $this->record['fecha'] = date('Y-m-d',strtotime($ldate));
        $this->record['tipo'] = 'ING';
        $this->record['movimiento'] = 'CL';
        $this->record['tipopago'] = 'NN';
        $this->record['estudiante_id'] = 0;
        $this->record['observacion'] = '';
        $this->record['estado'] = 'G';

    }

    public function createData(){
    
        $this ->validate([
            'record.fecha' => 'required',
            'record.tipo' => 'required',
            'record.movimiento' => 'required',
            'record.referencia' => 'required',
            'record.tipopago' => 'required',
        ]);
        
        $invCab = TrInventarioCabs::where('tipo',$this->record['tipo'])
        ->where('movimiento',$this->record['tipo'])
        ->select('documento')
        ->orderby('documento','desc')
        ->first();
        
        $secuencia = 1;
        if(!empty($invCab)){
            $secuencia = intval(right($invCab->documento,5))+1;
        }

        $documento = $this->record['movimiento'].str_pad($secuencia, 5, "0", STR_PAD_LEFT); 

        $invCab = TrInventarioCabs::Create([
            'periodo' => date("Y",strtotime($this->record['fecha'])),
            'mes' => date("m",strtotime($this->record['fecha'])),
            'tipo' => $this->record['tipo'],
            'documento' => $documento,
            'fecha'=>$this->record['fecha'],
            'movimiento' => $this->record['movimiento'],
            'referencia' => $this->record['referencia'],
            'estudiante_id' => $this->record['estudiante_id'],
            'tipopago' => $this->record['tipopago'],
            'observacion' => $this->record['observacion'],
            'neto' => 0,
            'estado' => $this -> record['estado'],
            'usuario' => auth()->user()->name,
        ]);

        $this->inventarioId = $invCab->id;
        $this->emitTo('vc-inventary-registerdet','setGrabaDetalle',$this->inventarioId);

        $this->dispatchBrowserEvent('msg-grabar');
        $this->status = 'disabled'; 
        
    }

    public function procesar(){
    
        $invtra = TrInventarioDets::where('inventariocab_id',$this->inventarioId)->get();
        
        if ($this->record['tipo']=='ING'){
        
            foreach ($invtra as $index => $record)
            {
                $producto = TmProductos::find($record['producto_id']);
                $producto->update([
                    'stock' => $stock+$record['cantidad'],
                ]);
            }

            $invCab = TrInventarioCabs::find($this->inventarioId);
            $invCab->update([
                'estado' => 'P',
            ]);

        }else{
            
            $error='';

            foreach ($invtra as $index => $record)
            {
                $producto = TmProductos::find($record['producto_id']);
                $stock = $producto['stock'];
                
                if ($record['cantidad']>$stock & $producto['maneja_stock']==1){
                    $error = 'Producto: '.$producto['nombre'].', cantidad digitada: '.$record['cantidad'].' es mayor al stock: '.$stock.'/n';
                }
            }

            if (!empty($error)){
                return
            }

            $invCab = TrInventarioCabs::find($this->inventarioId);
            $invCab->update([
                'estado' => 'P',
            ]);

        }

        $this->dispatchBrowserEvent('msg-procesar');

    }

}
