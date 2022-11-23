<?php

namespace App\Http\Livewire;
use App\Models\TmSedes;
use App\Models\TmPersonas;
use App\Models\TrFacturasCabs;
use App\Models\TrFacturasDets;
use App\Models\TrDeudasCabs;


use Livewire\Component;

class VcCreateinvoice extends Component
{
    
    public $record;
    public $fecha;
    public $establecimiento;
    public $ptoemision;
    public $documento=0;
    public $direccion;
    public $telefono;
    public $email;
    public $selectPersona;
    public $plazo=0;
    public $montopago=0;
    public $actual_id;

    public $producto_id, $cantidadDig, $precioventa, $descuento, $itemtotal, $subtotal=0; 
    public $detalleVtas = [];

    public function render()
    {
        
        $tblsedes      = TmSedes::all();
        $tblpersonas   = TmPersonas::where('tipopersona',"C")->get();
        $tbldeudas     = TrDeudasCabs::where('saldo',0)->get();
        $this->record  = TrFacturasCabs::find(0);

    
        if ($this->record==null){
            $this->add($tblsedes);
        }else{
            $this->loaddata($tblpersonas);
        }

        
        return view('livewire.vc-createinvoice',[
            'tblsedes' => $tblsedes,
            'tblpersonas' => $tblpersonas,
            'tbldeudas' => $tbldeudas,
            'detalleVtas' => $this->detalleVtas,
        ]);

    }

    public function add($tblsedes)
    {
        foreach ($tblsedes as $dato)
        {   


            $this->record['documento'] = str_pad($dato['secuencia_factura']+1, 9, "0", STR_PAD_LEFT);
            $this->record['establecimiento'] = $dato['establecimiento'];
            $this->record['punto_emision'] = $dato['punto_emision'];
        }  
        
        $ldate = date('Y-m-d H:i:s');
        $this->fecha = date('Y-m-d',strtotime($ldate));
        $this->record['fecha']= $this->fecha;
         
    }    


    public function loaddata($tblrecords)
    {
        foreach ($tblsedes as $dato)
        {
            $this->record['documento'] = $dato['secuencia_factura']+1;
        }
    }

    public function resetInput()
    {
        $this->producto_id = "";
        $this->cantidadDig = null;
        $this->precioventa = null;
        $this->descuento = null;
        $this->total = null;

    }

    public function addProduct()
    {
       
        if ($this->producto_id=="" || $this->cantidad =0 || $this->precio =0){
            $this->emit('msg-error','Ingrese totdos los campo para agregar al detalle');
        }else{
            $products = TrDeudasCabs::find($this->producto_id);
            $nombre = $products->glosa;
            $this->itemtotal = floatval($this->cantidadDig)*floatval($this->precioventa)-floatval($this->descuento);
            $this->subtotal = floatval($this->subtotal)+$this->itemtotal;
            $this->montopago = floatval($this->subtotal);
            
            $detProductos = array(
                'producto_id' => $this->producto_id,
                'nombre' => $nombre,
                'cantidad' => floatval($this->cantidadDig),
                'precio' => floatval($this->precioventa),
                'descuento' => floatval($this->descuento),
                'total' => $this->itemtotal,
            );
            
            $this->detalleVtas[] = $detProductos;
            
            $this->emit('msgok','Agregado con Exito');
            $this->resetInput();

        }
    }

    public function selectItem(){

        $products = TrDeudasCabs::find($this->producto_id);      
        $this->precioventa = $products->neto;
        $this->descuento = $products->descuento;
        $this->cantidadDig = 1;

    }

    public function updatedselectPersona($id){
       $persons = TmPersonas::find($id);
       $this->direccion =  $persons->direccion;
       $this->telefono = $persons->telefono;
       $this->email = $persons->email;
    }

    public function createData(){

        $this ->validate([
            'establecimiento' => 'required',
            'ptoemision' => 'required',
            'documento' => 'required',
            'selectPersona' => 'required',
            'fecha' => 'required',
        ]);

        TrFacturasCabs::Create([
            'periodo' => 0,
            'mes' => 0,
            'tipo' => 'FE',
            'fecha' => $this -> fecha,
            'establecimiento' => $this -> establecimiento,
            'puntoemision' => $this -> puntoemision,
            'documento' => $this -> documento,
            'persona_id' => $this -> selectedpersona,
            'subtotal_grabado' => 0,
            'subtotal_nograbado' => $this -> subtotal,
            'subtotal_nosujeto' => 0,
            'subtotal_excento' => 0,
            'descuento' => 0,
            'subtotal' => $this -> subtotal,
            'impuesto' => 0,
            'neto' => $this -> subtotal,
            'estado' => "C",
            'usuario' => auth()->user()->name,
            'estado' => "P",
        ]);

        $this->tblFactura = TrFacturasCabs::orderBy("id", "desc")->first();
        $this->$actual_id = $this->tblFactura['id'];

        foreach ($objPago as $pago)
        {
        
        }




    }

    



}
