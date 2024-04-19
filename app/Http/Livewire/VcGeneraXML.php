<?php

namespace App\Http\Livewire;

use App\Models\TmSedes;
use App\Models\TmPersonas;
use App\Models\TrFacturasCabs;
use App\Models\TrFacturasDets;
use App\Models\TmPeriodosLectivos;

use Livewire\Component;
use DOMDocument;
use PDF;

class VcGeneraXML extends Component
{
        
    public function render()
    {
        return view('livewire.vc-genera-x-m-l');
    }

    protected $listeners = ['setGeneraXML'];

    public function setGeneraXML($facturaid)
    {
                
        /*<-- Datos Emisor */ 

        $emisor  =  TmSedes::where('id','>',0)->first();

        /*-->*/ 


        /*<-- Datos del Documento */
        $factCab = TrFacturasCabs::query()
        ->join("tm_personas as p","p.id","=","tr_facturas_cabs.persona_id")
        ->selectRaw('p.nombres,p.apellidos,p.tipoidentificacion,p.identificacion,tr_facturas_cabs.*')
        ->where('tr_facturas_cabs.id',$facturaid)
        ->first();

        $factDet = TrFacturasDets::where('facturacab_id',$facturaid)->get();
        
        /*-->*/

        /*<-- CLAVE DE ACCESO */

        $fecha = date('dmY',strtotime($factCab['fecha']));
        $ruc   = $emisor['ruc'];
        $establ = $factCab['establecimiento'];
        $ptoemi = $factCab['puntoemision'];
        $secdoc = $factCab['documento'];
        $codnum = '12345678';
        $tipemi = '1';
        $tipamb = $emisor['ambiente']; 

        $clave = $fecha.'01'.$ruc.$tipamb.$establ.$ptoemi.$secdoc.$codnum.$tipemi;
       
        $digver = $this->digitoVerificador($clave);
        $clave = $clave.$digver;
        
        /*-->/ 

        /* Crea XML */
        
        $xml = new DOMDocument('1.0','utf-8');
        $xml->xmlStandalone = true;
	    $xml->formatOutput = true;

        $xml_fac  = $xml->createElement('factura');
        $cabecera = $xml->createAttribute('id');
        $cabecera->value='comprobante';
        $cabecerav = $xml->createAttribute('version');
        $cabecerav->value='1.1.0';

        $xml_inf  = $xml->createElement('infoTributaria');
        $xml_amb  = $xml->createElement('ambiente',1);
        $xml_tip  = $xml->createElement('tipoEmision',1);
        $xml_raz  = $xml->createElement('razonSocial',$emisor['razon_social']);
        $xml_ruc  = $xml->createElement('ruc',$emisor['ruc']);
        $xml_cla  = $xml->createElement('claveAcceso',$clave);
        $xml_doc  = $xml->createElement('codDoc','01');
        $xml_est  = $xml->createElement('estab',$factCab->establecimiento);
        $xml_pto  = $xml->createElement('ptoEmi',$factCab['puntoemision']);
        $xml_sec  = $xml->createElement('secuencial',$factCab['documento']);
        $xml_dir  = $xml->createElement('dirMatriz',$emisor['direccion']);

        $xml_ifa  = $xml->createElement('infoFactura');
        $xml_fec  = $xml->createElement('fechaEmision',date('d/m/Y',strtotime($factCab['fecha'])));
        $xml_des  = $xml->createElement('dirEstablecimiento',$emisor['direccion_establecimiento']);

        if($emisor['lleva_contabilidad']==0){
            $xml_obl  = $xml->createElement('obligadoContabilidad','NO');
        }else{
            $xml_obl  = $xml->createElement('obligadoContabilidad','SI');
        }
        
        switch ($factCab['tipoidentificacion']) {
            case 'C':
                $xml_ide  = $xml->createElement('tipoIdentificacionComprador','05');
                break;
            case 'R':
                $xml_ide  = $xml->createElement('tipoIdentificacionComprador','04');
                break;
            case 'P':
                $xml_ide  = $xml->createElement('tipoIdentificacionComprador','06');
                break;
        }

        $xml_rco  = $xml->createElement('razonSocialComprador',$factCab['apellidos'].' '.$factCab['nombres']);
        $xml_ico  = $xml->createElement('identificacionComprador',$factCab['identificacion']);
        $xml_tsi  = $xml->createElement('totalSinImpuestos',$factCab['subtotal_grabado']+$factCab['subtotal_nograbado']);
        $xml_tde  = $xml->createElement('totalDescuento',$factCab['descuento']);

        $xml_tci  = $xml->createElement('totalConImpuestos');

        if ($factCab['subtotal_nograbado']>0){
            $xml_tim  = $xml->createElement('totalImpuesto');
            $xml_tco  = $xml->createElement('codigo',2);
            $xml_cpo  = $xml->createElement('codigoPorcentaje',0);
            $xml_bim  = $xml->createElement('baseImponible',number_format($factCab['subtotal_nograbado'],6));
            $xml_val  = $xml->createElement('valor',0.00);
        }

        if ($factCab['subtotal_grabado']>0){
            $xml_tim  = $xml->createElement('totalImpuesto');
            $xml_tco  = $xml->createElement('codigo',2);
            $xml_cpo  = $xml->createElement('codigoPorcentaje',15);
            $xml_bim  = $xml->createElement('baseImponible',0.00);
            $xml_val  = $xml->createElement('valor',0.00);
        }       

        $xml_pro  = $xml->createElement('propina',0.00);
        $xml_ito  = $xml->createElement('importeTotal',number_format($factCab['neto'],6));
        $xml_mon  = $xml->createElement('moneda','DOLAR');

        $xml_pgs  = $xml->createElement('pagos');
        $xml_pag  = $xml->createElement('pago');
        $xml_fpg  = $xml->createElement('formaPago',$factCab['formapago']);
        $xml_tpg  = $xml->createElement('total',number_format($factCab['neto'],6));
        $xml_plz  = $xml->createElement('plazo',$factCab['dias']);
        $xml_utp  = $xml->createElement('unidadTiempo',$factCab['plazo']);

        $xml_dts  = $xml->createElement('detalles');


        /*Agrega Nodo para infoTributaria*/
        $xml_inf->appendChild($xml_amb);
        $xml_inf->appendChild($xml_tip);
        $xml_inf->appendChild($xml_raz);
        $xml_inf->appendChild($xml_ruc);
        $xml_inf->appendChild($xml_cla);
        $xml_inf->appendChild($xml_doc);
        $xml_inf->appendChild($xml_est);
        $xml_inf->appendChild($xml_pto);
        $xml_inf->appendChild($xml_sec);
        $xml_inf->appendChild($xml_dir);
        $xml_fac->appendChild($xml_inf);

        /*Agregamos Nodo para infoFactura*/
        $xml_ifa->appendChild($xml_fec);
        $xml_ifa->appendChild($xml_des);
        $xml_ifa->appendChild($xml_obl);
        $xml_ifa->appendChild($xml_ide);
        $xml_ifa->appendChild($xml_rco);
        $xml_ifa->appendChild($xml_ico);
        $xml_ifa->appendChild($xml_tsi);
        $xml_ifa->appendChild($xml_tde);

        $xml_ifa->appendChild($xml_tci);
        $xml_tci->appendChild($xml_tim);
        $xml_tim->appendChild($xml_tco);
        $xml_tim->appendChild($xml_cpo);
        $xml_tim->appendChild($xml_bim);
        $xml_tim->appendChild($xml_val);

        $xml_ifa->appendChild($xml_pro);
        $xml_ifa->appendChild($xml_ito);
        $xml_ifa->appendChild($xml_mon);

        $xml_ifa->appendChild($xml_pgs);
        $xml_pgs->appendChild($xml_pag);
        $xml_pag->appendChild($xml_fpg);
        $xml_pag->appendChild($xml_tpg);
        $xml_pag->appendChild($xml_plz);
        $xml_pag->appendChild($xml_utp);
        $xml_fac->appendChild($xml_ifa);

        /*Agregamos Nodos detalles*/
        $xml_fac->appendChild($xml_dts);


        foreach ($factDet as $recno)
        {
            $xml_det  = $xml->createElement('detalle');
            $xml_cod  = $xml->createElement('codigoPrincipal',$recno['codigo']);
            $xml_dpr  = $xml->createElement('descripcion',$recno['descripcion']);
            $xml_can  = $xml->createElement('cantidad',number_format($recno['cantidad'],6));
            $xml_pun  = $xml->createElement('precioUnitario',number_format($recno['precio'],6));
            $xml_dto  = $xml->createElement('descuento',number_format($recno['descuento'],6));
            $xml_psi  = $xml->createElement('precioTotalSinImpuesto',number_format($recno['total']-$recno['descuento'],6));

            $xml_ips  = $xml->createElement('impuestos');

             /*Agregamos Nodos detalles*/
            $xml_dts->appendChild($xml_det);
            $xml_det->appendChild($xml_cod);
            $xml_det->appendChild($xml_dpr);
            $xml_det->appendChild($xml_can);
            $xml_det->appendChild($xml_pun);
            $xml_det->appendChild($xml_psi);

            /*Agregamos Nodos impuestos*/
            $xml_det->appendChild($xml_ips);

            $xml_ipt  = $xml->createElement('impuesto');
            $xml_cdg  = $xml->createElement('codigo','2');
            if ($recno['impuesto']>0){
                $xml_por  = $xml->createElement('codigoPorcentaje','2');
                $xml_tar  = $xml->createElement('tarifa','15.00');
            }else{
                $xml_por  = $xml->createElement('codigoPorcentaje','0');
                $xml_tar  = $xml->createElement('tarifa','0.00');
            }
            $xml_bas  = $xml->createElement('baseImponible',$recno['total']-$recno['descuento']);
            $xml_vim  = $xml->createElement('valor','0.00');

            $xml_ips->appendChild($xml_ipt);
            $xml_ipt->appendChild($xml_cdg);
            $xml_ipt->appendChild($xml_por);
            $xml_ipt->appendChild($xml_tar);
            $xml_ipt->appendChild($xml_bas);
            $xml_ipt->appendChild($xml_vim);
            
        }

        $xml_adc  = $xml->createElement('infoAdicional');

        /*Agregamos Nodos infoAdicional*/
        $xml_fac->appendChild($xml_adc);

        if ($factCab['periodo_id']>0){

            $Periodo = TmPeriodosLectivos::find($factCab['periodo_id']);
 
            $xml_cad1 = $xml->createElement('campoAdicional',$Periodo['descripcion']);
            $atricad1 = $xml->createAttribute('nombre');
            $atricad1->value='Periodo';

            $xml_adc->appendChild($xml_cad1);
            $xml_cad1->appendChild($atricad1);
        }

        if ($factCab['estudiante_id']>0){

            $Persona = TmPersonas::find($factCab['estudiante_id']);
 
            $xml_cad2 = $xml->createElement('campoAdicional',$Persona['apellidos'].' '.$Persona['nombres']);
            $atricad2 = $xml->createAttribute('nombre');
            $atricad2->value='Estudiante';

            $xml_adc->appendChild($xml_cad2);
            $xml_cad2->appendChild($atricad2);
        }

        $xml_fac->appendChild($cabecera);
        $xml_fac->appendChild($cabecerav);
        $xml->appendChild($xml_fac,);

	    
        $ruta= $emisor['docgenerado'];
        $xml->save($ruta."/".$clave.".xml");

        /*$record = TrFacturasCabs::find($facturaid);
        $record->update([
            'autorizacion' => $clave,
        ]);*/

        return redirect()->to('/invoice/ride-pdf/'.$facturaid);

    }

    public function digitoVerificador($ncClaveAcceso)
    {
        $imultiplicador = 2;
        $itotal = 0;
        $iverificador = 0;
        $iBaseMultiplicador = 7;

        $iCnt = strlen($ncClaveAcceso);

        while ($iCnt > 0) {
           
            $iValor = intval(substr($ncClaveAcceso,$iCnt-1,1));
            $iValor = $iValor*$imultiplicador;
            $imultiplicador = $imultiplicador+1;

            if ($imultiplicador > $iBaseMultiplicador){
                $imultiplicador = 2;
            }

            $itotal = $itotal + $iValor;
            $iCnt = $iCnt-1;
        }

        if (($itotal==0) || ($itotal==1)){
            $iverificador = 0;
        }else{

            if (11-fmod($itotal,11)==11){
                $iverificador = 0;
            }else{
                $iverificador = 11-fmod($itotal,11);
            }
             
        }

        if ($iverificador == 10){
            $iverificador = 1;
        }        

        return strval($iverificador);
       
    }

    public function ImprimeRide($facturaId)
    {
        $fpago=[
            '01'=>'Sin utilización del sistema financiero',
            '16'=>'Tarjetas de Debito',
            '17'=>'Dinero Electrónic0',
            '18'=>'Tarjeta Prepago',
            '19'=>'Tarjeta de Crédito',
            '20'=>'Otros con Utilización del Sistema Financiero',
            '21'=>'Endoso de Títulos',
        ];

        /*<-- Datos Emisor */ 
        $emisor  =  TmSedes::where('id','>',0)->first();
        /*-->*/ 

        /*<-- Datos del Documento */
        $factCab = TrFacturasCabs::find($facturaId);
        $factDet = TrFacturasDets::where('facturacab_id',$facturaId)->get();
        /*-->*/

        $pdf = PDF::loadView('docelectronicos/ride_facturaxml',[
            'emisor' => $emisor,
            'faccab' => $factCab,
            'facdet' => $factDet,
            'fpago' => $fpago,
        ]);
    
        return $pdf->setPaper('a4')->stream('clave.pdf');
    }
    
}
