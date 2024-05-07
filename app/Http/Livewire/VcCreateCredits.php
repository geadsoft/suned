<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\TmSedes;
use App\Models\TmPersonas;
use App\Models\TrFacturasCabs;
use App\Models\TrFacturasDets;

class VcCreateCredits extends Component
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
    public $facturaId=0, $periodoId=0, $estudianteId, $factura, $fecha_factura, $motivo;

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

    protected $listeners = ['setDocModifica','setTotales'];

    public function mount()
    {
        $this->tblsedes  = TmSedes::where('id','>',0)->first(); 
        $this->loadSRI();       
    }
    
    public function render()
    {
        
        $this->add($this->tblsedes);
       
        return view('livewire.vc-create-credits',[
            'tblsedes' => $this->tblsedes,
            'totales' =>$this->totales,
        ]);
    }

    public function add($tblsedes)
    {

        $this->record['documento'] = str_pad($tblsedes['secuencia_ncredito']+1, 9, "0", STR_PAD_LEFT);
        $this->record['establecimiento'] = $tblsedes['establecimiento'];
        $this->record['punto_emision'] = $tblsedes['punto_emision'];
                
        $ldate = date('Y-m-d H:i:s');
        $this->fecha = date('Y-m-d',strtotime($ldate));
        $this->record['fecha']= $this->fecha;
        $this->establecimiento = $tblsedes['establecimiento'];
        $this->ptoemision = $tblsedes['punto_emision'];
        $this->documento = str_pad($tblsedes['secuencia_ncredito']+1, 9, "0", STR_PAD_LEFT);
         
    }  

    public function loaddata()
    {

        $this->record['documento'] = $this->tblsedes['secuencia_ncredito']+1;
        
    }

    /*Doc Modificado*/
    public function buscar(){

        $this->dispatchBrowserEvent('show-form');
    }

    public function setDocModifica($facturaId){

        $record = TrFacturasCabs::find($facturaId);
        $this->factura = $record['establecimiento'].$record['puntoemision'].$record['documento'];
        $fecha = $record['fecha'];
        $this->fecha_factura = date('Y-m-d',strtotime($fecha));
        $this->estudianteId = $record['estudiante_id'];
        
        $this->tblstudent = TmPersonas::where('id',$record['estudiante_id'])->get();

        $record = TmPersonas::find($record['persona_id']);
        $this->personaId = $record['id'];
        $this->cliente = $record['apellidos'].' '.$record['nombres'];
        $this->ruc = $record['identificacion'];
        $this->direccion =  $record['direccion'];
        $this->telefono =  $record['telefono'];
        $this->email =  $record['email'];   

    }

    /* Totales */
    public function setTotales($data){

        $this->totales['subtotalsinImpto'] = $data['TotalSinImpto'];
        $this->totales['subtotal0'] = $data['Subtotal0'];
        $this->totales['valortotal'] = $data['Total'];
        $this->montopago = $data['Total'];
    }


    public function createData(){

        if ($this->totales['valortotal']==0){
            $message = "No existen valores en el Documento!";
            $this->dispatchBrowserEvent('msg-error', ['newName' => $message]);
            return;
        }

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
            'factura' => 'required',
            'fecha_factura' => 'required',
            'motivo' => 'required',
        ]);

        $this->documento = str_pad($this->tblsedes['secuencia_ncredito']+1, 9, "0", STR_PAD_LEFT);

        $facturaCab = TrFacturasCabs::Create([
            'periodo' => date("Y",strtotime($this -> fecha)),
            'mes' => date("m",strtotime($this -> fecha)),
            'tipo' => 'NE',
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
            'docaplica' => $this -> factura,
            'fecha_docaplica' => $this -> fecha_factura,
            'motivo' => $this -> motivo,
            'estado' => "C",
            'usuario' => auth()->user()->name,
        ]);

        $this->facturaId = $facturaCab->id;
        $this->emitTo('vc-detail-credits','setGrabaDetalle',$this->facturaId);

        /* Actualiza Secuencia */
        $record = TmSedes::find($this->tblsedes['id']);
        $record->update([
            'secuencia_ncredito' => intval($this->documento),
        ]);

        $this->dispatchBrowserEvent('msg-grabar');

    }


    public function loadSRI()
    {
        $API_KEY = 'API_11345_12398_6614599c307e6';
        $url = 'https://azur.com.ec/plataforma/api/v2/consulta/comprobante';
        $firmados = [];

        $facturas  = TrFacturasCabs::where('estado','F')
        ->get();

        $ch = curl_init();
        foreach($facturas as $recno){

            $datos=[
                "api_key" => $API_KEY,
                "claveacceso" => $recno['autorizacion'],
            ];
            $fields = json_encode($datos);

            /*Uso de API - AZUR*/
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            $respuesta = json_decode($response,true);
            

            if ($respuesta['estado_texto']=='Autorizado'){

                $record = TrFacturasCabs::find($recno['id']);
                $record->update([
                    'estado' => 'A',
                ]);
                
                $docfir['claveacceso'] = $recno['autorizacion'];
                $docfir['xml'] = $respuesta['enlace_xml'];
                array_push($firmados, $docfir);
            }

        }

        curl_close($ch);
        
    }

    public function enviaRIDE($facturaId){

        $API_KEY = 'API_11345_12398_6614599c307e6';
        $facCab = TrFacturasCabs::find($facturaId);
        $facDet = TrFacturasDets::where('facturacab_id',$facturaId)->get();

        $array=[
            'api_key' => $API_KEY,
            'codigoDoc' => '04',
            'emisor' => '',
            'comprador' => '',
            'items' => '',
            'documento_modificado' => '',
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

        /*$pagos=[];
        $pago=[
            "tipo"=>'20',
            "total"=>floatVal($facCab->neto),
        ];
        array_push($pagos, $pago);*/
        $docmodificado =[];
        $docmodificado =[
            'codigo_documento_sustento' => '01',
            'numero_documento_sustento' => $facCab['docaplica'],
            'fecha_documento_sustento' => date('Y/m/d',strtotime( $facCab['fecha_docaplica'])),
            'motivo' => $facCab['motivo'],
            'anula_comprobante' => 'NO',
        ];
        
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
        $array['documento_modificado'] = $docmodificado;
        $array['informacion_adicional'] = $informacion;

        $fields = json_encode($array);
        $fields = str_replace("\/","/",$fields);

        /*Uso de API - AZUR*/
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://azur.com.ec/plataforma/api/v2/credito/emision");
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

                TrFacturasDets::where("facturacab_id",$facturaId)->update(["estado" => "F"]);

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
