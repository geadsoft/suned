<?php

namespace App\Http\Livewire;
use App\Models\TmSedes;
use App\Models\TmPersonas;
use App\Models\TrFacturasCabs;
use App\Models\TrFacturasDets;
use App\Models\TrDeudasCabs;
use App\Models\TmPeriodosLectivos;
use Illuminate\Support\Facades\Http;


use Livewire\Component;

class VcCreateinvoice extends Component
{
    
    public $record;
    public $fecha;
    public $establecimiento;
    public $ptoemision;
    public $documento=0;
    public $cliente;
    public $ruc;
    public $direccion;
    public $telefono;
    public $email;
    public $personaId=0;
    public $dias=0;
    public $plazo='Dias';
    public $formapago=20;
    public $montopago=0;
    public $facturaId=0, $periodoId=0, $estudianteId;

    public $totales = [
        'subtotalsinImpto' => 0,
        'subtotalIVA' => 0,
        'subtotal0' => 0,
        'subtotalIVA' => 0,
        'subtotalExcento' => 0,
        'descuentos' => 0,
        'Iva' => 0,
        'valortotal' => 0,
    ];

    public $producto_id, $cantidadDig, $precioventa, $descuento, $itemtotal, $subtotal=0; 
    public $detalleVtas = [], $tblsedes;
    public $tblperiodos;
    public $tblstudent=[];

    protected $listeners = ['setPersona','setTotales'];

    public function mount()
    {
        $this->tblperiodos = TmPeriodosLectivos::orderBy("periodo","desc")->get();
        $periodo = TmPeriodosLectivos::where('estado','A')->first();
        
        $this->tblsedes      = TmSedes::where('id','>',0)->first();
        
    }
    
    public function render()
    {
        
        $tblpersonas   = TmPersonas::where('tipopersona',"C")->get();
        $tbldeudas     = TrDeudasCabs::where('saldo',0)->get();
        $this->record  = TrFacturasCabs::find(0);
    
        if ($this->record==null){
            $this->add($this->tblsedes);
        }else{
            $this->loaddata($tblpersonas);
        }

        
        return view('livewire.vc-createinvoice',[
            'tblsedes' => $this->tblsedes,
            'tbldeudas' => $tbldeudas,
            'detalleVtas' => $this->detalleVtas,
            'tblperiodos' => $this->tblperiodos,
            'totales' =>$this->totales,
        ]);

    }

    public function add($tblsedes)
    {
        /*foreach ($tblsedes as $dato)
        {*/   
            $this->record['documento'] = str_pad($tblsedes['secuencia_factura']+1, 9, "0", STR_PAD_LEFT);
            $this->record['establecimiento'] = $tblsedes['establecimiento'];
            $this->record['punto_emision'] = $tblsedes['punto_emision'];
        /*}*/ 
        
        $ldate = date('Y-m-d H:i:s');
        $this->fecha = date('Y-m-d',strtotime($ldate));
        $this->record['fecha']= $this->fecha;
        $this->establecimiento = $tblsedes['establecimiento'];
        $this->ptoemision = $tblsedes['punto_emision'];
        $this->documento = str_pad($tblsedes['secuencia_factura']+1, 9, "0", STR_PAD_LEFT);
         
    }    


    public function loaddata($tblrecords)
    {
        foreach ($tblsedes as $dato)
        {
            $this->record['documento'] = $dato['secuencia_factura']+1;
        }
    }

    /*Cabecera Factura*/
    public function buscar(){

        $this->dispatchBrowserEvent('show-form');
    }

    public function setPersona($personaId,$estudianteId){

        $record = TmPersonas::find($personaId);
        $this->personaId = $record['id'];
        $this->cliente = $record['apellidos'].' '.$record['nombres'];
        $this->ruc = $record['identificacion'];
        $this->direccion =  $record['direccion'];
        $this->telefono =  $record['telefono'];
        $this->email =  $record['email'];

        $this->tblstudent = TmPersonas::query()
        ->join("tm_familiar_estudiantes as f","f.estudiante_id","=","tm_personas.id")
        ->where("f.persona_id",$personaId)
        ->select("tm_personas.*")
        ->get();

        $this->estudianteId = $estudianteId;
        $this->updatedestudianteId($this->estudianteId);

    }

    /* Detalle Factura*/ 
    public function updatedestudianteId($id){

        $this->emitTo('vc-detailinvoice','setCobros',$id,$this->periodoId);

    }

    public function updatedperiodoId($id){

        $this->emitTo('vc-detailinvoice','setCobros',$this->estudianteId,$id);

    }

    /* Totales */
    public function setTotales($data){

        $this->totales['subtotalsinImpto'] = $data['TotalSinImpto'];
        $this->totales['subtotal0'] = $data['Subtotal0'];
        $this->totales['valortotal'] = $data['Total'];
        $this->montopago = $data['Total'];
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

    public function createData(){

        $this ->validate([
            'establecimiento' => 'required',
            'ptoemision' => 'required',
            'documento' => 'required',
            'cliente' => 'required',
            'fecha' => 'required',
            'estudianteId' => 'required',
            'montopago' => 'required',
            'formapago' => 'required',
            'plazo' => 'required',
        ]);

        $this->documento = str_pad($this->tblsedes['secuencia_factura']+1, 9, "0", STR_PAD_LEFT);

        $facturaCab = TrFacturasCabs::Create([
            'periodo' => date("Y",strtotime($this -> fecha)),
            'mes' => date("m",strtotime($this -> fecha)),
            'tipo' => 'FE',
            'fecha' => $this -> fecha,
            'establecimiento' => $this -> establecimiento,
            'puntoemision' => $this -> ptoemision,
            'documento' => $this -> documento,
            'persona_id' => $this -> personaId,
            'periodo_id' => $this -> periodoId,
            'estudiante_id' => $this -> estudianteId,
            'formapago' => $this -> formapago,
            'dias' => $this -> dias,
            'plazo' => $this -> plazo,
            'subtotal_grabado' => 0,
            'subtotal_nograbado' => $this->totales['subtotalsinImpto'],
            'subtotal_nosujeto' => 0,
            'subtotal_excento' => 0,
            'descuento' => 0,
            'subtotal' => $this->totales['subtotalsinImpto'],
            'impuesto' => 0,
            'neto' => $this->totales['valortotal'],
            'estado' => "C",
            'usuario' => auth()->user()->name,
        ]);

        $this->facturaId = $facturaCab->id;
        $this->emitTo('vc-detailinvoice','setGrabaDetalle',$this->facturaId);

        /* Actualiza Secuencia */
        $record = TmSedes::find($this->tblsedes['id']);
        $record->update([
            'secuencia_factura' => intval($this->documento),
        ]);

        /* Actualiza Cobros Facturados */

        $this->dispatchBrowserEvent('msg-grabar');

    }

    public function enviaRIDE($facturaId){

        $API_KEY = 'API_11345_12398_6614599c307e6';
        $facCab = TrFacturasCabs::find($facturaId);
        $facDet = TrFacturasDets::where('facturacab_id',$facturaId)->get();

        $array=[
            'api_key' => $API_KEY,
            'codigoDoc' => '01',
            'emisor' => '',
            'comprador' => '',
            'items' => '',
            'pagos' => '',
            'informacion_adicional'=>'',
        ];

        $emisor=[
            "manejo_interno_secuencia"=> "NO",
            "secuencial"=>  $facCab['documento'],
            "fecha_emision"=> date('Y/m/d',strtotime( $facCab['fecha'])),
        ];

        switch ($facCab->persona->tipoidentificacion) {
            case 'C':
                $tipoident  = '05';
                break;
            case 'R':
                $tipoident  = '04';
                break;
            case 'P':
                $tipoident  = '06';
                break;
        }

        $comprador=[
            "tipo_identificacion"=>$tipoident, 
            "identificacion"=>$facCab->persona->identificacion,
            "razon_social"=>$facCab->persona->apellidos.' '.$facCab->persona->nombres,
            "direccion"=>$facCab->persona->direccion,
            "telefono"=>$facCab->persona->telefono,
            "celular"=> null,
            "correo"=>$facCab->persona->email,
        ];

        $arraydet=[];
        foreach ($facDet as $recno)
        {
            $items=[
                "codigo_principal"=> $recno['codigo'],
                "codigo_auxiliar"=> null,
                "descripcion"=>$recno['descripcion'],
                "tipoproducto"=> 2,
                "tipo_iva"=> 0,
                "precio_unitario"=> floatVal($recno['precio']),
                "cantidad"=> floatVal($recno['cantidad']),
                "descuento"=> 0.00,
                "tipo_ice"=> 0,
                "valor_ice"=> 0.00,
                "tarifa_ice"=> 0,
            ];
            array_push($arraydet, $items);
        }

        $pagos=[];
        $pago=[
            "tipo"=>'20',
            "total"=>floatVal($facCab->neto),
        ];
        array_push($pagos, $pago);
        
        $informacion=[];
        if ($facCab['periodo_id']>0){
            $periodo = TmPeriodosLectivos::find($facCab['periodo_id']);
            $datos=[
                "nombre"=> 'Periodo',
                "detalle"=> $periodo['descripcion'],
            ];
            array_push($informacion, $datos);
        }

        if ($facCab['estudiante_id']>0){
            $persona = TmPersonas::find($facCab['estudiante_id']);
            $datos=[
                "nombre"=> 'Estudiante',
                "detalle"=> $persona ['apellidos'].' '.$persona ['nombres'],
            ];
            array_push($informacion, $datos);
        }  
        
        $array['emisor'] = $emisor;
        $array['comprador'] = $comprador;
        $array['items'] = $arraydet;
        $array['pagos'] = $pagos;
        $array['informacion_adicional'] = $informacion;

        $fields = json_encode($array);
        $fields = str_replace("\/","/",$fields);

        /*Uso de API - AZUR*/
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://azur.com.ec/plataforma/api/v2/factura/emision");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        if(curl_errno($ch)){
            echo curl_errno($ch);
        }else{
            $respuesta = json_decode($response,true);
        }

        curl_close($ch);
        
        $claveAcceso = '';
        $mensaje = '';
        $error = 0;

        if($respuesta == null){
            $mensaje = 'Error al Generar y Firmar Documento';
            $error = 1;
        }else{
            
            if($respuesta['creado']==true){
            
                $claveAcceso = $respuesta['claveacceso'];
                $mensaje = 'Documento firmado....';
    
                /* actualiza clave en factura*/
                $record = TrFacturasCabs::find($facturaId);
                $record->update([
                    'estado' => 'F',
                    'autorizacion' => $claveAcceso,
                ]);
            }else{

                $error=1;
                foreach ($respuesta['errors'] as $key)
                {
                    $mensaje = $mensaje.' '.$key."\n";
                }
            }       
        
        }
        
        $dataFact = [
            'factura' => $facCab['establecimiento'].'-'.$facCab['puntoemision'].'-'.$facCab['documento'],
            'claveacceso' => $claveAcceso,
            'error' => $error,
            'mensaje' => $mensaje
        ];

        $dataFact = json_encode($dataFact);
        $this->dispatchBrowserEvent('msg-ride', ['newObj' => $dataFact]);

    }

}
