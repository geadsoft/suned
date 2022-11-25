<?php

namespace App\Http\Livewire;
use App\Models\TmSedes;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class VcHeadquarters extends Component
{   
    use WithFileUploads;
    
    public $record;
    public $selectId;
    public $filefirma;
    public $provinciaid;
    public $cantonid;
    public $parroquiaid;
    public $formestado = 'disabled';
    public $existsrecord = false;


    protected $listeners = [
        'postAdded' => 'UpdateZonas'
    ];

    public function render()
    {   
        $tblsedes  = TmSedes::where('id', 1)->get()->toArray();       
        
        if ($tblsedes!=null){
            $this->existsrecord = true; 
            $this->load($tblsedes);
        }

        return view('livewire.vc-headquarters');
        
    }

    public function load($tblsede){

        foreach ($tblsede as $dato)
        {
            $this->record['codigo'] = $dato['codigo'];
            $this->record['nombre'] = $dato['nombre'];
            $this->record['denominacion'] = $dato['denominacion'];
            $this->record['inicia_actividad'] = $dato['inicia_actividad'];
            $this->record['telefono_sede'] = $dato['telefono_sede'];
            $this->record['email_sede'] = $dato['email_sede'];
            $this->record['website'] = $dato['website'];
            $this->record['representante'] = $dato['representante'];
            $this->record['identificacion'] = $dato['identificacion'];
            $this->record['fin_semana'] = $dato['fin_semana'];
            $this->record['jornada_completa'] = $dato['jornada_completa'];
            $this->record['matutino'] = $dato['matutino'];
            $this->record['vespertino'] = $dato['vespertino'];
            $this->record['nocturno'] = $dato['nocturno'];
            $this->record['direccion_sede'] = $dato['direccion_sede'];
            $this->record['logo_sede'] = $dato['logo_sede'];
            $this->record['ruc'] = $dato['ruc'];
            $this->record['razon_social'] = $dato['razon_social'];
            $this->record['nombre_comercial'] = $dato['nombre_comercial'];
            $this->record['telefono'] = $dato['telefono'];
            $this->record['email'] = $dato['email'];
            $this->record['direccion'] = $dato['direccion'];
            $this->record['lleva_contabilidad'] = $dato['lleva_contabilidad'];
            $this->record['regimen_rimpe'] = $dato['regimen_rimpe'];
            $this->record['contribuyente_especial'] = $dato['contribuyente_especial'];
            $this->record['resolucion_ce'] = $dato['resolucion_ce'];
            $this->record['agente_retencion'] = $dato['agente_retencion'];
            $this->record['resolucion_ar'] = $dato['resolucion_ar'];
            $this->record['establecimiento'] = $dato['establecimiento'];
            $this->record['nombre_establecimiento'] = $dato['nombre_establecimiento'];
            $this->record['direccion_establecimiento'] = $dato['direccion_establecimiento'];
            $this->record['punto_emision'] = $dato['punto_emision'];
            $this->record['secuencia_factura'] = $dato['secuencia_factura'];
            $this->record['clave_firma'] = $dato['clave_firma'];
            
            $this->provinciaid = $dato['provincia_id'];
            $this->cantonid = $dato['canton_id'];
            $this->parroquiaid = $dato['parroquia_id'];

        }
    }

    public function add(){

        $this->formestado = 'enabled';
        
        $this->reset(['record']);
        $this->record['representante']= "prueba";
        $this->record['identificacion']= "";
        $this->record['fin_semana']= false;
        $this->record['jornada_completa']= false;
        $this->record['matutino']= true;
        $this->record['vespertino']= false;
        $this->record['nocturno']= false;
        $this->record['provincia_id']= 1;
        $this->record['canton_id']= 1;
        $this->record['parroquia_id']= 1;
        $this->record['logo_sede']= "";
        $this->record['lleva_contabilidad']= false;
        $this->record['regimen_rimpe']= false;
        $this->record['contribuyente_especial']= false;
        $this->record['agente_retencion']= false;
        $this->record['resolucion_ce']= "";
        $this->record['resolucion_ar']= "";
        $this->record['archivo_firma']= "";
        $this->record['clave_firma']= "";
        $this->record['logo_factura']= "";
        $this->record['secuencia_factura']= 1;

        $this->provinciaid = 0;
        $this->cantonid = 0;
        $this->parroquiaid = 0;
    }
    

    public function edit(){
        $this->formestado = 'enabled';
    }
    

    public function createData()
    {   

        $this ->validate([
            'record.codigo' => 'required',
            'record.nombre' => 'required',
            'record.denominacion' => 'required',
            'record.inicia_actividad' => 'required',
            'record.telefono_sede' => 'required',
            'record.email_sede' => 'required',
            'record.website' => 'required',
            'record.direccion_sede' => 'required',
        ]);


        /*$validatedData['name'] = $this->record['fe_archivo_firma']->store('files', 'public');
        File::create($validatedData);*/


        TmSedes::Create([
            'codigo' => $this -> record['codigo'],
            'nombre' => $this -> record['nombre'],
            'denominacion' => $this -> record['denominacion'],
            'inicia_actividad' => $this -> record['inicia_actividad'],
            'telefono_sede' => $this -> record['telefono_sede'],
            'email_sede' => $this -> record['email_sede'],
            'website' => $this -> record['website'],
            'representante' => $this -> record['representante'],
            'identificacion' => $this -> record['identificacion'],
            'fin_semana' => $this -> record['fin_semana'],
            'jornada_completa' => $this -> record['jornada_completa'],
            'matutino' => $this -> record['matutino'],
            'vespertino' => $this -> record['vespertino'],
            'nocturno' => $this -> record['nocturno'],
            'provincia_id' => $this -> record['provincia_id'],
            'canton_id' => $this -> record['canton_id'],
            'parroquia_id' => $this -> record['parroquia_id'],
            'direccion_sede' => $this -> record['direccion_sede'],
            'logo_sede' => $this -> record['logo_sede'],
            'ruc' => $this -> record['ruc'],
            'razon_social' => $this -> record['razon_social'],
            'nombre_comercial' => $this -> record['nombre_comercial'],
            'telefono' => $this -> record['telefono'],
            'email' => $this -> record['email'],
            'direccion' => $this -> record['direccion'],
            'lleva_contabilidad' => $this -> record['lleva_contabilidad'],
            'regimen_rimpe' => $this -> record['regimen_rimpe'],
            'contribuyente_especial' => $this -> record['contribuyente_especial'],
            'resolucion_ce' => $this -> record['resolucion_ce'],
            'agente_retencion' => $this -> record['agente_retencion'],
            'resolucion_ar' => $this -> record['resolucion_ar'],
            'establecimiento' => $this -> record['establecimiento'],
            'nombre_establecimiento' => $this -> record['nombre_establecimiento'],
            'direccion_establecimiento' => $this -> record['direccion_establecimiento'],
            'punto_emision' => $this -> record['punto_emision'],
            'secuencia_factura' => $this -> record['secuencia_factura'],
            'secuencia_ncredito' => 1,
            'archivo_firma' => $this -> record['archivo_firma'],
            'clave_firma' => $this -> record['clave_firma'],
            'logo-factura' => $this -> record['logo_factura'],
            'usuario' => auth()->user()->name,
            
        ]);

        session()->flash('info', 'Headquarters created sSccessfully');
        
        $this->record = TmSedes::orderBy("id", "desc")->first();
        $this->selectId = $this->record['id'];
       
        
    }

    public function UpdateZonas($idprovincia=null,$idcanton=null,$idparroquia=null){
        
        $record = TmSedes::find($this->selectId);
        $record->update([
            'provincia_id' => $this -> $idprovincia,
            'canton_id' => $this -> $idcanton,
            'parroquia_id' => $this -> $idparroquia,
        ]);

    }



}
