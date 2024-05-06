<?php

namespace App\Http\Livewire;

use App\Models\TrFacturasCabs;
use App\Models\TrFacturasDets;
use App\Models\TmPeriodosLectivos;
use App\Models\TmPersonas;

use Livewire\Component;
use Livewire\WithPagination;

class VcDocElectronics extends Component
{
    use WithPagination;

    public $doctipo = '';
    public $filters = [
        'srv_fechaini' => '',
        'srv_fechafin' => '',
        'srv_nombre' => '',
        'srv_estado' => 'A',
    ];

    public $estado = [
        'C' => 'Grabado',
        'G' => 'Generado',
        'F' => 'Firmado',
        'A' => 'Autorizado',
        'X' => 'Anulado',
    ];

    public function mount($tipo){

        $ldate = date('Y-m-d H:i:s');
        $ldate = date('Y-m-d',strtotime($ldate));
        $this->doctipo = $tipo; 

        $this->filters['srv_fechaini'] = '';
        $this->filters['srv_fechafin'] = $ldate;

        $this->loadSRI();
    }
    
    public function render()
    {
        
        $tblrecords = TrFacturasCabs::query()
        ->join("tm_personas as p","p.id","=","tr_facturas_cabs.persona_id")
        ->where('tipo',$this->doctipo)
        ->select('tr_facturas_cabs.*','p.apellidos','p.nombres')
        ->orderBy('documento','desc')
        ->paginate(10);

        return view('livewire.vc-doc-electronics',[
            'tblrecords' => $tblrecords,
        ]);

    }

    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
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
        /*$this->grabaXML($firmados);*/
        
    }

    public function grabaXML($data){

        foreach($data as $key){

            $curl = $key['xml'];
            return redirect($curl);

        }

    }

    public function enviaRIDE($facturaId){

        $API_KEY = 'API_11345_12398_6614599c307e6';
        $facCab = TrFacturasCabs::find($facturaId);
        $facDet = TrFacturasDets::where('facturacab_id',$facturaId)->get();
        
        if($facCab['tipo']=='NE'){

            $url = 'https://azur.com.ec/plataforma/api/v2/credito/emision';
            $array=[
                'api_key' => $API_KEY,
                'codigoDoc' => '04',
                'emisor' => '',
                'comprador' => '',
                'items' => '',
                'documento_modificado' => '',
                'informacion_adicional'=>'',
            ];

        }else {

            $url = 'https://azur.com.ec/plataforma/api/v2/factura/emision';
            $array=[
                'api_key' => $API_KEY,
                'codigoDoc' => '01',
                'emisor' => '',
                'comprador' => '',
                'items' => '',
                'pagos' => '',
                'informacion_adicional'=>'',
            ];

        }


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

        /* Documento que aplica para Nota de Credito */
        if ($facCab->tipo=='NE'){

            $docmodificado =[];
            $docmodificado =[
                'codigo_documento_sustento' => '01',
                'numero_documento_sustento' => $facCab['docaplica'],
                'fecha_documento_sustento' => date('Y/m/d',strtotime( $facCab['fecha_docaplica'])),
                'motivo' => $facCab['motivo'],
                'anula_comprobante' => 'NO',
            ];

        }

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
        
        if ($facCab->tipo=='FE'){

            $array['emisor'] = $emisor;
            $array['comprador'] = $comprador;
            $array['items'] = $arraydet;
            $array['pagos'] = $pagos;
            $array['informacion_adicional'] = $informacion;

        }else{

            $array['emisor'] = $emisor;
            $array['comprador'] = $comprador;
            $array['items'] = $arraydet;
            $array['documento_modificado'] = $docmodificado;
            $array['informacion_adicional'] = $informacion;

        }

        $fields = json_encode($array);
        $fields = str_replace("\/","/",$fields);

        /*Uso de API - AZUR*/
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
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
            'mensaje' => $mensaje
        ];

        $dataFact = json_encode($dataFact);
        $this->dispatchBrowserEvent('msg-ride', ['newObj' => $dataFact]);
        
    }



}
