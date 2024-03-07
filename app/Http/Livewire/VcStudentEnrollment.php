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
use App\Models\TmFamiliarEstudiantes;
use App\Models\TmCursos;

use Livewire\Component;

class VcStudentEnrollment extends Component
{
    
    public $search_nui, $search_nur;
    public $chkoptnui="si",$eControl="";

    public $estudiante_id=0,$persona_id=0;
    public $codigo, $nombres="", $apellidos="", $nombrecompleto, $tipoident="C", $identificacion="", $genero="M", $fechanace, $nacionalidad=35, $telefono="", $etnia="ME";
    public $tipodiscapacidad, $discapacidad, $email="", $direccion="", $comentario="";
    public $periodoId, $grupoId, $nivelId, $gradoId, $cursoId, $datosFamiliar=0;
    public $fecha,$crearperson, $estudentnew=0, $mespension, $fControl='disabled'; 
    public $familiares = [], $deudas, $montoDeuda = 0;
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

    public $familiar = [
        'id' => 0,
        'persona_id' => 0,
        'apellidos' => '',
        'nombres' => '',
        'tipoidentificacion' => 'C',
        'identificacion' => '',
        'nacionalidad_id' => 35,
        'genero' => 'M',
        'telefono' => '',
        'direccion' => '',
        'email' => '',
        'parentesco' => 'MA',
    ];
    public $relacion = [
        'MA' => 'Madre',
        'PA' => 'Padre',
        'AP' => 'Apoderado',
        'OT' => 'Otro',
        'NN' => 'Selecione Relacion',

    ];
     
    public $sede;
    protected $listeners = ['postAdded','updateFamiliar'];

    public function mount($tuition_id){
        
        if ($tuition_id!=""){
            $this->search_nui = $tuition_id;
            $this->searchPerson(2);  
        }else{
            $this->chkoptnui="no";
            $this->newFamiliar();
        }

    }

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
            $this->nacionalidad = $records->nacionalidad_id;
            $this->genero = $records->genero;
            $this->telefono = $records->telefono;
            $this->email = $records->email;
            $this->etnia = $records->etnia;
            $this->direccion = $records->direccion;
            $this->comentario = '';

            $familys =  TmFamiliarEstudiantes::query()
            ->join("tm_personas as p","p.id","=","tm_familiar_estudiantes.persona_id")
            ->where('estudiante_id',"{$this->estudiante_id}")
            ->select('tm_familiar_estudiantes.id','persona_id','apellidos','nombres','tipoidentificacion','identificacion','nacionalidad_id','genero','telefono','direccion','email','parentesco')
            ->get()->toArray();
            
            if (empty($familys)) {
                $this->newFamiliar();
            }else{
                $this->familiares =  $familys;
                $this->datosFamiliar = 1;
            }
            
            /* Mantiene Deuda */
            $this->deudas = TrDeudasCabs::query()
            ->join("tm_periodos_lectivos as p","p.id","=","tr_deudas_cabs.periodo_id")
            ->selectRaw("p.descripcion, sum(saldo) as monto")
            ->where("tr_deudas_cabs.estudiante_id",$this->estudiante_id)
            ->groupBy("p.descripcion")
            ->get()->toArray();

            $this->montoDeuda = (array_sum(array_column($this->deudas,'monto')));

        }else{
            
            $this->dispatchBrowserEvent('show-message');

        }
    
    }

    public function validaNui(){
        $records = TmPersonas::where("identificacion",$this->identificacion)->first();
        
        if ($this->chkoptnui=="si"){
            return;
        }

        if ($records != null){
            $this->dispatchBrowserEvent('msg-validanui');
        }
    }


    public function createData(){

        if ($this->nombres=="" || $this->apellidos==""){
            return;
       }
               
        if ($this->estudiante_id==0){

            $this->grabaEstudiante();
            $this->estudentnew=1;

        }else{

            $this->updateEstudiante();
        
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
        
        /* Inicia Representante - No existe*/
        foreach ($objPers as $person){
            
            if($person['idpersona']==0){
                $this->grabaPerson($person);
            }

        }
        /* Fin Representante */

        /* -- Registro de Matricula */
        $pLectivo     = TmPeriodosLectivos::find($this->periodoId);
        $codperiodo   = $pLectivo['periodo'];
        $nomperiodo   = $pLectivo['descripcion'];
        $nromatricula = $pLectivo['num_matricula']+1;
        $this->mespension = $pLectivo['mes_pension'];
        $registro     = 'N';
        
        if($this->estudentnew==0){
            $registro = 'P';
        }

        TmMatricula::Create([
            'documento' => substr($codperiodo, -2).str_pad($nromatricula, 4, "0", STR_PAD_LEFT),
            'registro' => $registro,
            'fecha' => $this -> fecha,
            'estudiante_id' => $this -> estudiante_id,
            'nivel_id' => $this -> nivelId,
            'modalidad_id' => $this->grupoId, 
            'grado_id' => $this ->gradoId,
            'periodo_id' => $this ->periodoId,
            'curso_id' => $this -> cursoId,
            'representante_id' => $this -> persona_id,
            'comentario' => $this-> comentario,
            'usuario' => auth()->user()->name,
            'estado' => "A",
        ]);
        $matricula   = TmMatricula::orderBy("id", "desc")->first();
        $matriculaId = $matricula['id'];

        /*Actualiza secuencia*/
        $pLectivo['num_matricula'] = $nromatricula;
        $pLectivo->update();
        /* -- Fin Matricula*/

        $familiares = TmFamiliarEstudiantes::where([
            ['estudiante_id',$this->estudiante_id],
            ['persona_id',$this->persona_id],
            ])->get()->toArray();

        if (empty($familiares)) {
            TmFamiliarEstudiantes::Create([
                'estudiante_id'=>$this -> estudiante_id,
                'persona_id'=>$this -> persona_id,
                'informacion'=>'',
                'usuario' => auth()->user()->name,
            ]);
        }

        $this->GrabaDeuda($matriculaId,$codperiodo,$nomperiodo,$nromatricula);

        /*-- Familiar --*/
        foreach ($this->familiares as $data){

            if ($data['id']>0){

                $record = TmPersonas::find($data['persona_id']);
                $record->update([
                    'nombres' => $data['nombres'],
                    'apellidos' => $data['apellidos'],
                    'identificacion' => $data['identificacion'],
                    'nacionalidad_id' => $data['nacionalidad_id'],
                    'genero' => $data['genero'],
                    'telefono' => $data['telefono'],
                    'direccion' => $data['direccion'],
                    'email' => $data['email'],
                    'parentesco' => $data['parentesco'],
                ]);

            }else{

                $familiar = TmPersonas::where('identificacion',$data['identificacion'])->first();

                if ($familiar==null) {

                    TmPersonas::Create([
                        'nombres' => $data['nombres'],
                        'apellidos' => $data['apellidos'],
                        'tipoidentificacion' => $data['tipoidentificacion'],
                        'identificacion' => $data['identificacion'], 
                        'fechanacimiento' => "1900-01-01",
                        'nacionalidad_id' => $data['nacionalidad_id'],
                        'genero' => $data['genero'],
                        'telefono' => $data['telefono'],
                        'direccion' => $data['direccion'],
                        'email' => $data['email'],
                        'etnia' => "",
                        'parentesco' => $data['parentesco'],
                        'tipopersona' => "R",
                        'relacion_id' => 0,
                        'usuario' => auth()->user()->name,
                        'estado' => "A",
                    ]);
                    $newRecno = TmPersonas::orderBy("id", "desc")->first();

                    TmFamiliarEstudiantes::Create([
                        'estudiante_id'=> $this->estudiante_id,
                        'persona_id'=> $newRecno['id'],
                        'informacion'=>'',
                        'usuario' => auth()->user()->name,
                    ]);
                    
                } else {

                    TmFamiliarEstudiantes::Create([
                        'estudiante_id'=> $this->personaId,
                        'persona_id'=> $familiar['id'],
                        'informacion'=>'',
                        'usuario' => auth()->user()->name,
                    ]);

                }


            }

        }
        /* Fin Familiar--*/

        /* Inicia Representante - Existe*/
        foreach ($objPers as $person){

            if($person['idpersona']>0){
                $this->updatePerson($person);
            }

        }
        /* Fin Representante */

        $this->dispatchBrowserEvent('msg-grabar');
        return redirect()->to('/academic/tuition');
        
    }

    public function grabaDeuda($idactual,$codigo,$nombre,$secuencia){

        $matriculaId = $idactual;
        $codperiodo = $codigo;
        $nomperiodo = $nombre;
        $nromatricula = $secuencia;

        /* Registro de Deuda */
        $pensiones = TmPensionesDet::join("tm_pensiones_cabs","tm_pensiones_cabs.id","=","tm_pensiones_dets.pension_id")
        ->where([
                ['tm_pensiones_cabs.periodo_id',$this->periodoId],
                ['tm_pensiones_cabs.modalidad_id',$this->grupoId],
                ['tm_pensiones_dets.nivel_id',$this->nivelId],
            ])->first();
        
        $valorMatricula  = $pensiones['matricula'];
        if ($this->estudentnew==1){
            $valorMatricula  = $pensiones['matricula2'];
        }
        $valorPension     = $pensiones['pension'];
        $valorePlataforma = $pensiones['eplataforma'];
        $valoriPlataforma = $pensiones['iplataforma'];
        $valorGrado       = $pensiones['grado']; 

        $cuotas = 10;
        
        //Matricula
        //$mes = date('m',strtotime($this->fecha));
        $mes = $this->mespension;
        $año = date('Y',strtotime($this->fecha));

        TrDeudasCabs::Create([
            'matricula_id' => $matriculaId,
            'estudiante_id' => $this -> estudiante_id,
            'periodo_id' => $this -> periodoId,
            'referencia' => 'MAT-PER'.substr($codperiodo, -2).str_pad($nromatricula, 4, "0", STR_PAD_LEFT),
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

        //Plataforma Ingles
        if($valoriPlataforma>0){

            TrDeudasCabs::Create([
                'matricula_id' => $matriculaId,
                'estudiante_id' => $this -> estudiante_id,
                'periodo_id' => $this -> periodoId,
                'referencia' => 'PLI-PER'.substr($codperiodo, -2).str_pad($nromatricula, 4, "0", STR_PAD_LEFT),
                'fecha' => $this->fecha,
                'basedifgravada' => $valoriPlataforma,
                'basegravada' =>0.00,
                'impuesto' =>0.00,
                'descuento' =>0.00,
                'neto' => $valoriPlataforma,
                'debito' => $valoriPlataforma,
                'credito' =>0.00,
                'saldo' => $valoriPlataforma,
                'glosa' => 'Plataforma Ingles Periodo '.$nomperiodo,
                'estado' => 'P',
                'usuario' => auth()->user()->name,
            ]);

            $deuda = TrDeudasCabs::orderBy("id", "desc")->first();
            $deudaId = $deuda['id'];

            TrDeudasDets::Create([
                'deudacab_id' => $deudaId,
                'cobro_id' => 0,
                'fecha' => $this->fecha,
                'detalle' => 'Plataforma Ingles Periodo '.$nomperiodo,
                'tipo' => "",
                'referencia' => "",
                'tipovalor' => "DB",
                'valor' => $valoriPlataforma,
                'estado' => 'P',
                'usuario' => auth()->user()->name,
                ]);
                
        }


        //Plataforma Español
        TrDeudasCabs::Create([
            'matricula_id' => $matriculaId,
            'estudiante_id' => $this -> estudiante_id,
            'periodo_id' => $this -> periodoId,
            'referencia' => 'PLE-PER'.substr($codperiodo, -2).str_pad($nromatricula, 4, "0", STR_PAD_LEFT),
            'fecha' => $this->fecha,
            'basedifgravada' => $valorePlataforma,
            'basegravada' =>0.00,
            'impuesto' =>0.00,
            'descuento' =>0.00,
            'neto' => $valorePlataforma,
            'debito' => $valorePlataforma,
            'credito' =>0.00,
            'saldo' => $valorePlataforma,
            'glosa' => 'Plataforma Español Periodo '.$nomperiodo,
            'estado' => 'P',
            'usuario' => auth()->user()->name,
        ]);

        $deuda = TrDeudasCabs::orderBy("id", "desc")->first();
        $deudaId = $deuda['id'];

        TrDeudasDets::Create([
            'deudacab_id' => $deudaId,
            'cobro_id' => 0,
            'fecha' => $this->fecha,
            'detalle' => 'Plataforma Español Periodo '.$nomperiodo,
            'tipo' => "",
            'referencia' => "",
            'tipovalor' => "DB",
            'valor' => $valorePlataforma,
            'estado' => 'P',
            'usuario' => auth()->user()->name,
          ]);

        //Pension
        for ($i=0; $i < $cuotas; $i++){
           
            if ($mes==13){
                $mes = 1;
                $año = $año+1;
            }
            
            TrDeudasCabs::Create([
                'matricula_id' => $matriculaId,
                'estudiante_id' => $this -> estudiante_id,
                'periodo_id' => $this -> periodoId,
                'referencia' => 'PEN-'.$this->meses[$mes].substr($codperiodo, -2).str_pad($nromatricula, 4, "0", STR_PAD_LEFT),
                'fecha' =>  strval($año)."-".str_pad($mes, 2, "0", STR_PAD_LEFT).'-01',
                'basedifgravada' => $valorPension,
                'basegravada' =>0.00,
                'impuesto' =>0.00,
                'descuento' =>0.00,
                'neto' => $valorPension,
                'debito' => $valorPension,
                'credito' =>0.00,
                'saldo' => $valorPension,
                'glosa' => 'Pensión Cuota '.strval($i+1).' '.$nomperiodo,
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

            $mes++ ;
        }


        //Grado
        $curso = TmCursos::find($this -> cursoId);

        if ($curso['aplica_derechogrado']){

            $newDeuda = TrDeudasCabs::Create([
                'matricula_id' => $matriculaId,
                'estudiante_id' => $this -> estudiante_id,
                'periodo_id' => $this -> periodoId,
                'referencia' => 'DGR-PER'.substr($codperiodo, -2).str_pad($nromatricula, 4, "0", STR_PAD_LEFT),
                'fecha' => $this->fecha,
                'basedifgravada' => $valorGrado,
                'basegravada' =>0.00,
                'impuesto' =>0.00,
                'descuento' =>0.00,
                'neto' => $valorGrado,
                'debito' => $valorGrado,
                'credito' =>0.00,
                'saldo' => $valorGrado,
                'glosa' => 'Derecho de Grado '.$nomperiodo,
                'estado' => 'P',
                'usuario' => auth()->user()->name,
            ]);
            
            $deudaId = $newDeuda['id'];

            TrDeudasDets::Create([
                'deudacab_id' => $deudaId,
                'cobro_id' => 0,
                'fecha' => $this->fecha,
                'detalle' => 'Derecho de Grado '.$nomperiodo,
                'tipo' => "",
                'referencia' => "",
                'tipovalor' => "DB",
                'valor' => $valorGrado,
                'estado' => 'P',
                'usuario' => auth()->user()->name,
            ]);

        }


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
            'nacionalidad_id' => $pernacional,
            'genero' => $pergenero,
            'telefono' => $pertelefono,
            'direccion' => $perdirecc,
            'email' => $peremail,
            'etnia' => "",
            'parentesco' => $perparentes,
            'tipopersona' => "R",
            'relacion_id' => $this->estudiante_id,
            'usuario' => auth()->user()->name,
            'estado' => "A",
        ]);

        $newRecno = TmPersonas::orderBy("id", "desc")->first();
        $this->persona_id = $newRecno['id'];

    }  

    public function updatePerson($data){

        $perId       =  $data['idpersona'];
        $record = TmPersonas::find($perId);

        $record->update([
            'nombres' => $data['nombres'],
            'apellidos' => $data['apellidos'],
            'tipoidentificacion' => $data['tipo'],
            'identificacion' => $data['identidad'], 
            'nacionalidad_id' => $data['nacion'],
            'genero' => $data['genero'],
            'telefono' => $data['telefono'],
            'direccion' => $data['direccion'],
            'email' => $data['email'],
            'parentesco' => $data['relacion']
            ]);

    } 

    public function grabaEstudiante(){

        TmPersonas::Create([
            'nombres' => $this -> nombres,
            'apellidos' => $this -> apellidos,
            'tipoidentificacion' => $this -> tipoident,
            'identificacion' => $this->identificacion, 
            'fechanacimiento' => $this ->fechanace,
            'nacionalidad_id' => $this ->nacionalidad,
            'genero' => $this -> genero,
            'telefono' => $this -> telefono,
            'direccion' => $this -> direccion,
            'email' => $this -> email,
            'etnia' => $this -> etnia,
            'parentesco' => "",
            'tipopersona' => "E",
            'relacion_id' => 0,
            'usuario' => auth()->user()->name,
            'estado' => "A",
        ]);

        $newRecno = TmPersonas::where("tipopersona","E")
        ->orderBy("id", "desc")
        ->first();

        $this->estudiante_id = $newRecno['id'];

    }

    public function updateEstudiante(){

        $record = TmPersonas::find($this->estudiante_id);
        $record->update([
            'nombres' => $this -> nombres,
            'apellidos' => $this -> apellidos,
            'tipoidentificacion' => $this -> tipoident,
            'identificacion' => $this->identificacion, 
            'fechanacimiento' => $this ->fechanace,
            'nacionalidad_id' => $this ->nacionalidad,
            'genero' => $this -> genero,
            'telefono' => $this -> telefono,
            'direccion' => $this -> direccion,
            'email' => $this -> email,
            'etnia' => $this -> etnia
        ]);

    }
    
    public function activeControl(){
        $this->fControl = "";
        $this->newFamiliar();
        $this->dispatchBrowserEvent('active-tab');
    }

    public function newFamiliar(){
        $this->familiar['id'] = 0;
        $this->familiar['persona_id']=0;
        $this->familiar['apellidos']='';
        $this->familiar['nombres']='';
        $this->familiar['tipoidentificacion']="C";
        $this->familiar['identificacion']='';
        $this->familiar['nacionalidad_id']=35;
        $this->familiar['genero']="M";
        $this->familiar['telefono']='';
        $this->familiar['direccion']='';
        $this->familiar['email']='';
        $this->familiar['parentesco']="MA";
    }

    public function addFamiliar($opcion)
    {   

        if ($opcion=="U"){

            $this->dispatchBrowserEvent('family-add');

        } else {
        
            $ape = $this->familiar['apellidos'];
            $nom = $this->familiar['nombres'];
            $tip = $this->familiar['tipoidentificacion'];
            $ide = $this->familiar['identificacion'];
            $nac = $this->familiar['nacionalidad_id'];
            $gen = $this->familiar['genero'];
            $tel = $this->familiar['telefono'];
            $dir = $this->familiar['direccion'];
            $ema = $this->familiar['email'];
            $par = $this->familiar['parentesco'];

            if ($ape=='' || $nom=='' || $tip=='' || $ide=='' || $gen=='' || $par=='' || $nac=0 ){
                $this->dispatchBrowserEvent('family-msg');
                $this->dispatchBrowserEvent('active-tab');
                return;
            }else{ 
                array_push($this->familiares,$this->familiar);
                $this->newFamiliar();
                $this->eControl2 = "disabled";
                $this->dispatchBrowserEvent('active-tab');
            }

        }
    }

    public function updateFamiliar($data=null){
        
        $familiarId = $data['id'];

        $recnoToDelete = $this->familiares;
        foreach ($recnoToDelete as $index => $recno)
        {
            if ($recno['id'] == $familiarId){
                unset ($recnoToDelete[$index]);
            } 
        }

        $this->reset(['familiares']);
        $this->familiares = $recnoToDelete;
        array_push($this->familiares,$data); 
        $this->newFamiliar();
        $this->eControl2 = "disabled";
        $this->dispatchBrowserEvent('active-tab'); 
        
    }

}
