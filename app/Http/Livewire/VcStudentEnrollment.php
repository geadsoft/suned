<?php

namespace App\Http\Livewire;
use App\Models\TmPeriodosLectivos;
use App\Models\TmGeneralidades;
use App\Models\TmPersonas;
use App\Models\TmMatricula;
use App\Models\TmSedes;
use App\Models\TrDeudasCabs;
use App\Models\TrDeudasDets;
use App\Models\TmPensionesCab;
use App\Models\TmPensionesDet;

use Livewire\Component;

class VcStudentEnrollment extends Component
{
    
    public $search_nui, $search_nur;
    public $chkoptnui="si",$eControl="disabled";

    public $estudiante_id=0,$persona_id=0;
    public $codigo, $nombres, $apellidos, $nombrecompleto, $tipoident="C", $identificacion, $genero="H", $fechanace, $nacionalidad=35, $telefono, $etnia="ME";
    public $tipodiscapacidad, $discapacidad, $email, $direccion;
    public $periodoId, $grupoId, $nivelId, $gradoId, $cursoId;
    public $fecha,$crearperson;
    public $meses = [ 
        1 => 'ENE',
        2 => 'FEB',
        3 => 'MAR',
        4 => 'ABR',
        5 => 'MAY',
        6 => 'JUN',
        7 => 'JUL',
        8 => 'AGO',
        9 => 'SEP',
        10 => 'OCT',
        11 => 'NOV',
        12 => 'DIC'];
     

    public $sede;
    protected $listeners = ['postAdded'];

    public function render()
    {
        
        if ($this->chkoptnui=="no"){
            $this->eControl = "";
        }
        
        $this->sede = TmSedes::where('id',1)->first();
        $tblgenerals = TmGeneralidades::where('superior',7)->get();

        $ldate = date('Y-m-d H:i:s');
        $this->fecha = date('Y-m-d',strtotime($ldate));
       
        return view('livewire.vc-student-enrollment',[
            'tblgenerals' => $tblgenerals,
        ]);
       
    }

    public function searchPerson($buscar){
        
        if($buscar==1){
            $records = TmPersonas::where("id",$this->search_nur)->first();
        }else{
            $records = TmPersonas::where([
                ["identificacion",$this->search_nui],
                ["tipopersona","E"],
            ])->first();
        }

        if ( $records != null) {
            
            $this->codigo = 'UEAS-'.str_pad($records->id, 5, "0", STR_PAD_LEFT); 
            $this->estudiante_id = $records->id;
            $this->nombres = $records->nombres;
            $this->apellidos = $records->apellidos;
            $this->nombrecompleto = $records->nombres.' '.$records->apellidos;
            $this->tipoident = $records->tipoidentificacion;
            $this->identificacion = $records->identificacion;
            $this->fechanace = date('Y-m-d',strtotime($records->fechanacimiento));
            $this->nacionalidad = $records->nacionalidad;
            $this->genero = $records->genero;
            $this->telefono = $records->telefono;
            $this->email = $records->email;
            $this->etnia = $records->etnia;
            $this->direccion = $records->direccion;

            $this->dispatchBrowserEvent('searchData');

        }else{
            
            $this->dispatchBrowserEvent('show-message');

        }
    
    }


    public function createData(){

        if ($this->nombrecompleto==""){
            return;
        }
               
        if ($this->estudiante_id==0){
            
            $this->grabaEstudiante();
            
        }

        $this->dispatchBrowserEvent('get-data');
    }

    public function postAdded($objData, $objPers)
    {
        
        foreach ($objData as $data){

            $this->periodoId  = $data['periodoid'];
            $this->grupoId    = $data['grupoid'];
            $this->nivelId    = $data['nivelid'];
            $this->gradoId    = $data['gradoid'];
            $this->cursoId    = $data['cursoid'];
            $this->persona_id = $data['personaid'];
            
        }

        foreach ($objPers as $person){
            
            //Si no existe representante lo registra
            if($person['idpersona']==0){
                $this->grabaPerson($person);
            }

        }

        $this ->validate([
            'fecha' => 'required',
            'periodoId' => 'required',
            'grupoId' => 'required',
            'nivelId' => 'required',
            'gradoId' => 'required',
            'cursoId' => 'required',
            'estudiante_id' => 'required',
            'persona_id' => 'required',
        ]);

        $pLectivo = TmPeriodosLectivos::find($this->periodoId);
        $codperiodo   = $pLectivo['periodo'];
        $nomperiodo   = $pLectivo['descripcion'];
        $nummatricula = $pLectivo['num_matricula']+1;

        TmMatricula::Create([
            'documento' => substr($codperiodo, -2).str_pad($nummatricula, 4, "0", STR_PAD_LEFT),
            'fecha' => $this -> fecha,
            'estudiante_id' => $this -> estudiante_id,
            'nivel_id' => $this -> nivelId,
            'modalidad_id' => $this->grupoId, 
            'grado_id' => $this ->gradoId,
            'periodo_id' => $this ->periodoId,
            'curso_id' => $this -> cursoId,
            'representante_id' => $this -> persona_id,
            'usuario' => auth()->user()->name,
            'estado' => "P",
        ]);
        $matricula = TmMatricula::orderBy("id", "desc")->first();
        $matriculaId = $matricula['id'];

        $pensiones = TmPensionesDet::join("tm_pensiones_cabs","tm_pensiones_cabs.id","=","tm_pensiones_dets.pension_id")
        ->where([
                ['tm_pensiones_cabs.periodo_id',$this->periodoId],
                ['tm_pensiones_cabs.modalidad_id',$this->grupoId],
                ['tm_pensiones_dets.nivel_id',$this->nivelId],
            ])->first();

       
        $valorMatricula  = $pensiones['matricula'];
        $valorPension    = $pensiones['pension'];
        $valorPlataforma = $pensiones['plataforma'];
        $cuotas = 10;
        
        //Matricula
        $mes = date('m',strtotime($this->fecha));
        $año = date('Y',strtotime($this->fecha));

        TrDeudasCabs::Create([
            'matricula_id' => $matriculaId,
            'estudiante_id' => $this -> estudiante_id,
            'periodo_id' => $this -> periodoId,
            'referencia' => 'MAT-PER'.substr($codperiodo, -2).str_pad($nummatricula, 4, "0", STR_PAD_LEFT),
            'fecha' => $this->fecha,
            'basedifgravada' => $valorMatricula,
            'basegravada' =>0.00,
            'impuesto' =>0.00,
            'descuento' =>0.00,
            'neto' => $valorMatricula,
            'debito' => $valorMatricula,
            'credito' =>0.00,
            'saldo' => $valorMatricula,
            'glosa' => 'Matricula Periodo '.$nomperiodo,
            'estado' => 'P',
            'usuario' => auth()->user()->name,
        ]);
        $deuda = TrDeudasCabs::orderBy("id", "desc")->first();
        $deudaId = $deuda['id'];

        TrDeudasDets::Create([
            'deudacab_id' => $deudaId,
            'cobro_id' => 0,
            'fecha' => $this->fecha,
            'detalle' => 'Matricula Periodo '.$nomperiodo,
            'tipo' => "",
            'referencia' => "",
            'tipovalor' => "DB",
            'valor' => $valorMatricula,
            'estado' => 'P',
            'usuario' => auth()->user()->name,
          ]);


        //Plataforma
        TrDeudasCabs::Create([
            'matricula_id' => $matriculaId,
            'estudiante_id' => $this -> estudiante_id,
            'periodo_id' => $this -> periodoId,
            'referencia' => 'PLA-PER'.substr($codperiodo, -2).str_pad($nummatricula, 4, "0", STR_PAD_LEFT),
            'fecha' => $this->fecha,
            'basedifgravada' => $valorPlataforma,
            'basegravada' =>0.00,
            'impuesto' =>0.00,
            'descuento' =>0.00,
            'neto' => $valorPlataforma,
            'debito' => $valorPlataforma,
            'credito' =>0.00,
            'saldo' => $valorPlataforma,
            'glosa' => 'Matricula Periodo '.$nomperiodo,
            'estado' => 'P',
            'usuario' => auth()->user()->name,
        ]);
        $deuda = TrDeudasCabs::orderBy("id", "desc")->first();
        $deudaId = $deuda['id'];

        TrDeudasDets::Create([
            'deudacab_id' => $deudaId,
            'cobro_id' => 0,
            'fecha' => $this->fecha,
            'detalle' => 'Plataforma Periodo '.$nomperiodo,
            'tipo' => "",
            'referencia' => "",
            'tipovalor' => "DB",
            'valor' => $valorPlataforma,
            'estado' => 'P',
            'usuario' => auth()->user()->name,
          ]);


        //Pension
        for ($i=0; $i < $cuotas; $i++){
           
            $mes++ ;

            if ($mes==13){
                $mes = 1;
                $año = $año+1;
            }
            
            TrDeudasCabs::Create([
                'matricula_id' => $matriculaId,
                'estudiante_id' => $this -> estudiante_id,
                'periodo_id' => $this -> periodoId,
                'referencia' => 'PEN-'.$this->meses[$mes].substr($codperiodo, -2).str_pad($nummatricula, 4, "0", STR_PAD_LEFT),
                'fecha' =>  strval($año)."-".str_pad($mes, 2, "0", STR_PAD_LEFT).'-01',
                'basedifgravada' => $valorPension,
                'basegravada' =>0.00,
                'impuesto' =>0.00,
                'descuento' =>0.00,
                'neto' => $valorPension,
                'debito' => $valorPension,
                'credito' =>0.00,
                'saldo' => $valorPension,
                'glosa' => 'Matricula Periodo '.$nomperiodo,
                'estado' => 'P',
                'usuario' => auth()->user()->name,
            ]);

            $deuda = TrDeudasCabs::orderBy("id", "desc")->first();
            $deudaId = $deuda['id'];
    
            TrDeudasDets::Create([
                'deudacab_id' => $deudaId,
                'cobro_id' => 0,
                'fecha' => strval($año)."-".str_pad($mes, 2, "0", STR_PAD_LEFT).'-01',
                'detalle' => 'Pensión '.$this->meses[$mes]." ".$nomperiodo,
                'tipo' => "",
                'referencia' => "",
                'tipovalor' => "DB",
                'valor' => $valorPension,
                'estado' => 'P',
                'usuario' => auth()->user()->name,
            ]);
        }

        /*Actualiza secuencia de matricula*/
        $pLectivo->update([
            'num_matricula' => $nummatricula,
        ]);
        
    }

    public function grabaPerson($data){

        $pernombre   =  $data['nombres'];
        $perapellido =  $data['apellidos'];
        $pertipoiden =  $data['tipo'];
        $peridentifi =  $data['identidad'];
        $pernacional =  $data['nacion'];
        $pergenero   =  $data['genero'];
        $pertelefono =  $data['telefono'];
        $perdirecc   =  $data['direccion'];
        $peremail    =  $data['email'];
        $perparentes =  $data['relacion'];

        TmPersonas::Create([
            'nombres' => $pernombre,
            'apellidos' => $perapellido,
            'tipoidentificacion' => $pertipoiden,
            'identificacion' => $peridentifi, 
            'fechanacimiento' => "1900-01-01",
            'nacionalidad' => $pernacional,
            'genero' => $pergenero,
            'telefono' => $pertelefono,
            'direccion' => $perdirecc,
            'email' => $peremail,
            'etnia' => "",
            'parentesco' => $perparentes,
            'tipopersona' => "R",
            'relacion_id' => $this->estudiante_id,
            'usuario' => auth()->user()->name,
            'estado' => "P",
        ]);

        $newRecno = TmPersonas::orderBy("id", "desc")->first();
        $this->persona_id = $newRecno['id'];

    }    

    public function grabaEstudiante(){

        TmPersonas::Create([
            'nombres' => $this -> nombres,
            'apellidos' => $this -> apellidos,
            'tipoidentificacion' => $this -> tipoident,
            'identificacion' => $this->identificacion, 
            'fechanacimiento' => $this ->fechanace,
            'nacionalidad' => $this ->nacionalidad,
            'genero' => $this -> genero,
            'telefono' => $this -> telefono,
            'direccion' => $this -> direccion,
            'email' => $this -> email,
            'etnia' => $this -> etnia,
            'parentesco' => "",
            'tipopersona' => "E",
            'relacion_id' => 0,
            'usuario' => auth()->user()->name,
            'estado' => "P",
        ]);

        $newRecno = TmPersonas::where("tipopersona","E")
        ->orderBy("id", "desc")
        ->first();

        $this->estudiante_id = $newRecno['id'];

    }

    

}
