<?php

namespace App\Http\Livewire;
use Livewire\Component;
use App\Models\TmSedes;
use App\Models\TmPersonas;
use App\Models\TrCobrosCabs;
use App\Models\TrCobrosDets;
use App\Models\TrDeudasCabs;
use App\Models\TrDeudasDets;
use App\Models\TmPeriodosLectivos;
use App\Models\TmGeneralidades;
use App\Models\TmMatricula;
use App\Models\TdFacturaEstudiantes;
use App\Models\TrFacturasCabs;
use App\Models\TrFacturasDets;

use Illuminate\Support\Facades\DB;


class VcEncashmentadd extends Component
{
    public $selectId=0;
    public $documento;
    public $record;
    public $persona;
    public $idbuscar="";
    public $nombre="";
    public $periodo_id;
    public $fecha, $fechapago;
    public $secuencia=0;
    public $tblCobro, $objPago=[];
    public $estudiante_id=0, $grupo, $curso, $concepto, $comentario, $matricula_id, $nromatricula;
    public $tipopago='EFE', $entidadbco=0, $entidadtar=0, $valor=0, $referencia='', $cancela=0;
    public $establecimiento, $ptoemision, $generaFactura=false, $dias=0, $plazo='Dias', $formapago=20;
    public $factura=[
        'persona_id' => 0,
        'nui' => '',
        'cliente' => '',
        'direccion' => '',
        'telefono' => '',
        'email' => '',
        'documento' => '',        
    ];
   
    public $totalPago = 0;
    public $valpago   = 0;
    public $despago   = 0;
    
    protected $listeners = ['postAdded','setCedula'];

    public function mount($periodoid,$matriculaid){

        $ldate = date('Y-m-d H:i:s');
        $this->fecha = date('Y-m-d',strtotime($ldate));
        $this->fechapago = date('Y-m-d',strtotime($ldate));
        $this->tblsedes  = TmSedes::where('id','>',0)->first();
        
        $tblmatricula  = TmMatricula::find($matriculaid);
        $tblpersona    = TmPersonas::find($tblmatricula['estudiante_id']);

        $this->idbuscar      = $tblpersona['identificacion'];
        $this->periodo_id    = $periodoid;
        $this->estudiante_id = $tblpersona['id'];
        $this->matricula_id  = $matriculaid;
        $this->nromatricula  = $tblmatricula['documento'];

        $this->add();
        $this->search(1);
          
    }


    public function render()
    {   
                
        $record  = TrCobrosCabs::find(0);
        $tblperiodos = TmPeriodosLectivos::orderBy("periodo","desc")->get();
        $tblentidads = TmGeneralidades::where('superior',6)->get();
        $tbltarjetas = TmGeneralidades::where('superior',8)->get();

        return view('livewire.vc-encashmentadd',[
            'record' => $record,
            'tblperiodos' => $tblperiodos,
            'tblentidads' => $tblentidads,
            'tbltarjetas' => $tbltarjetas,
        ]);
        
    }

    public function add(){

        $this->establecimiento = $this->tblsedes['establecimiento'];
        $this->ptoemision = $this->tblsedes['punto_emision'];
        $this->secuencia = str_pad($this->tblsedes['secuencia_factura']+1, 9, "0", STR_PAD_LEFT);
        
        $this->reset(['record']);
        $this->record['fecha']= $this->fecha;
        $this->record['estudiante_id']= $this->estudiante_id;;
        $this->record['documento']= "";
        $this->record['concepto']= "";
        $this->record['monto']= 0;  
        $this->record['estado']= 'P';
        $this->record['fechapago']= $this->fechapago;

        $datosfact = TdFacturaEstudiantes::query()
        ->join("tm_personas as p","p.id","=","td_factura_estudiantes.persona_id")
        ->select("p.*")
        ->where("estudiante_id",$this->estudiante_id)
        ->orderBy("td_factura_estudiantes.created_at","desc")
        ->first();

        if (!Empty($datosfact)){

            $this->generaFactura = true;
            $this->factura['persona_id'] = $datosfact['id'];
            $this->factura['nui'] = $datosfact['identificacion']; 
            $this->factura['cliente'] = $datosfact['nombres'].' '.$datosfact['apellidos'];
            $this->factura['direccion'] = $datosfact['direccion'];
            $this->factura['telefono'] = $datosfact['telefono']; 
            $this->factura['email'] = $datosfact['email'];  
            $this->factura['documento'] = $this->establecimiento.' '.$this->ptoemision.' '.$this->secuencia; 
        }
    }


    public function createData(){

        $this->record['fecha'] = $this->fecha;
        $this->record['fechapago'] = $this->fechapago;
        $this->dispatchBrowserEvent('save-det');

    }

    public function addPago(){

        if ($this->valor==0){
            return;
        }

        $idEntidad = 32;

        if ($this->entidadbco>0){
            $idEntidad = $this->entidadbco;
        }
        
        if ($this->entidadtar>0){
            $idEntidad = $this->entidadtar;
        }

        $entidad = TmGeneralidades::find($idEntidad);

        $detpago = [];
        $detpago['tipopago']   = $this->tipopago;
        $detpago['entidadid']  = $idEntidad;
        $detpago['numero']     = '';
        $detpago['valor']      = $this->valor;
        $detpago['referencia'] = $this->referencia;

        if ($idEntidad>0){
            $detpago['detalle']    = $entidad['descripcion'].' '.$this->referencia;
        }
        

        $this->cancela = $this->cancela+floatval($this->valor);

        array_push($this->objPago, $detpago);
        $this->tipopago='EFE';
        $this->entidadbco=0;
        $this->entidadtar=0;
        $this->valor=0;
        $this->referencia='';

    }

    public function deletePago($row){

        $recnoToDelete = $this->objPago;
        foreach ($recnoToDelete as $index => $recno)
        {
            if ($index == $row){
                $this->cancela = $this->cancela-floatval($recno['valor']);
                unset ($recnoToDelete[$index]);
            } 
        }

        $this->reset(['objPago']);
        $this->objPago = $recnoToDelete;

    }

    public function validapago($objDeuda){

        $pago  = 0;
        $monto = (array_sum(array_column($objDeuda,'valpago')));
        $mNumber_monto = (float) str_replace(',', '', $monto);
        $mNumber_pago = (float) str_replace(',', '', $this->cancela);
        
        if ($mNumber_pago>$mNumber_monto){
            return true ; 
        }else{
            return false ; 
        }

    }

    public function postAdded($objDeuda=null)
    {

        if ($this->validapago($objDeuda)){
            $this->dispatchBrowserEvent('msg-pago');
            return;
        }

        foreach ($this->objPago as $pago)
        {
            $this->totalPago += $pago['valor'];
        }    

        if ($this->totalPago==0){ 
            return;
        }
        
        $this->record['monto']= $this->totalPago;
        
        $this ->validate([
            'record.fecha' => 'required',
            'record.estudiante_id' => 'required',
            'record.monto' => 'required',
        ]);

        $comentario = "";
        $this->tblCobro = TrCobrosCabs::orderBy('id', 'desc')->first();

        /*-- Begin Registro de Recibo */
        $pLectivo        = TmPeriodosLectivos::find($this->periodo_id);
        $this->secuencia = $pLectivo['num_recibo']+1;

        $this->document = str_pad($this->secuencia, 7, "0", STR_PAD_LEFT);
        
        TrCobrosCabs::Create([
            'fecha' => $this -> record['fecha'],
            'estudiante_id' => $this -> record['estudiante_id'],
            'matricula_id' =>  $this->matricula_id,
            'tipo' => "CP",
            'documento' => $this -> document,
            'fechapago' => $this -> record['fechapago'],
            'concepto' => 'Gestión de Cobro - Recibo No. '.$this -> document, 
            'monto' => $this -> record['monto'],
            'usuario' => auth()->user()->name,
            'estado' => "P",
        ]);

        $pLectivo['num_recibo'] = $this->secuencia;
        $pLectivo->update();
        /* End Registro Recibo --*/

        $this->tblCobro = TrCobrosCabs::orderBy("id", "desc")->first();
        $this->selectId = $this->tblCobro['id'];
                
        foreach ($this->objPago as $pago)
        {
            
            TrCobrosDets::Create([
            'cobrocab_id' =>  $this->selectId,  
            'tipopago' => $pago['tipopago'],
            'entidad_id' => $pago['entidadid'],
            'referencia' => $pago['referencia'],
            'numero' => $pago['numero'],
            'cuenta' => "",
            'valor' => $pago['valor'],
            'estado' => "P",
            'usuario' => auth()->user()->name,
            ]);
            
        } 
       
        foreach ($objDeuda as $deuda)
        {
            $this->valpago = floatval($deuda['valpago']);
            $this->despago = floatval($deuda['desct']);
           
            if ($this->totalPago>=$this->valpago){
                $this->totalPago = $this->totalPago-$this->valpago;
            }else{
                $this->valpago = $this->totalPago;
            }

            if ($this->valpago>0){
                
                TrDeudasDets::Create([
                    'deudacab_id' =>  $deuda ['id'],  
                    'cobro_id' => $this->selectId,
                    'fecha' => $this -> fecha,
                    'detalle' => $deuda['detalle'],
                    'tipo' => "PAG",
                    'referencia' => $this->document,
                    'tipovalor' => "CR",
                    'valor' => $this->valpago,
                    'estado' => "P",
                    'usuario' => auth()->user()->name,
                    ]);
                
                if ($this->despago>0){

                    TrDeudasDets::Create([
                        'deudacab_id' =>  $deuda['id'],  
                        'cobro_id' => $this->selectId,
                        'fecha' => $this -> record['fecha'],
                        'detalle' => $deuda['detalle'],
                        'tipo' => "DES",
                        'referencia' => $this->document,
                        'tipovalor' => "CR",
                        'valor' => $this->despago,
                        'estado' => "P",
                        'usuario' => auth()->user()->name,
                        ]);
                }

                $tbldeuda = TrDeudasCabs::find($deuda['id']);
                $tbldeuda->update([
                    'descuento' => $tbldeuda['descuento']+($this->despago), 
                    'credito' => $tbldeuda['credito']+($this->valpago+$this->despago),
                    'saldo' => $tbldeuda['saldo']-($this->valpago+$this->despago),
                ]); 

            }
        
        }
        
        if ($this->generaFactura==true){
            $this->generaFact();
        }else{

            $mensaje = "Registro Grabado con Exito...."."\n";
            $mensaje = $mensaje."Comprobante N° ".$this->document."\n";
            
            $this->dispatchBrowserEvent('msg-confirm', ['newName' => $mensaje]);

        }

        //return redirect()->to('/financial/encashment');
    }

    public function setCedula($data){
        
        $this->idbuscar = $data;
        $this->search(1);
    }
    
    public function search($tipo){


        if ($tipo=1){
            
            $this->persona   = TmPersonas::where('identificacion',$this->idbuscar)->first(); 
            
            
            if (  $this->persona != null) {

                $this->nombre    = $this->persona['nombres'].' '.$this->persona['apellidos'];
                $this->estudiante_id = $this->persona['id'];

                $matricula = TmMatricula::join("tm_cursos","tm_matriculas.curso_id","=","tm_cursos.id")
                ->join("tm_servicios","tm_cursos.servicio_id","=","tm_servicios.id")
                ->join("tm_generalidades","tm_servicios.modalidad_id","=","tm_generalidades.id")
                ->where("tm_matriculas.id",$this->matricula_id)
                ->select('tm_generalidades.descripcion AS nomGrupo', 'tm_servicios.descripcion AS nomGrado', 'tm_cursos.paralelo', 'tm_matriculas.comentario')
                ->first();
                   
                if($matricula!=null){
                    $this->grupo = $matricula['nomGrupo'];
                    $this->curso = $matricula['nomGrado']." - ".$matricula['paralelo'];
                    $this->comentario = $matricula['comentario'];
                }
                                                
                $this->emitTo('vc-encashment-debts','deudas',$this->persona['id']);

            } else {

                $this->dispatchBrowserEvent('show-message');

            }

        }else{

        }

    }

    public function generaFact(){

        $sqlQuery = DB::select("call sp_genera_factura_cobro(".$this->selectId.")");
        foreach ($sqlQuery as $factura){
            $this->enviaRIDE($factura->facturaId);
        }
        
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
        
        $mensaje = "Registro Grabado con Exito...."."\n";
        $mensaje = $mensaje."Comprobante N° ". $this->document."\n";
        $mensaje = $mensaje."Factura N° ".$facCab['establecimiento'].'-'.$facCab['puntoemision'].'-'.$facCab['documento']."\n";
        
        $this->dispatchBrowserEvent('msg-confirm', ['newName' => $mensaje]);

    }

}
