<?php

namespace App\Http\Livewire;
use App\Models\TmPersonas;
use App\Models\TmGeneralidades;
use App\Models\TmDomicilioEstudiantes;
use App\Models\TmFamiliarEstudiantes;


use Livewire\Component;

class VcPersonadd extends Component
{
    public $record;
    public $search_nui;
    public $eControl="";
    public $eControl2="disabled";
    public $showEditModal=false;
    public $directions = [];
    public $familiares = [];
    public $direction = [
        'id' => 0,
        'estudiante_id' => 0,
        'direccion' => '',
        'domingo' => 0,
        'lunes' => 3,
        'martes' => 3,
        'miercoles' => 3,
        'jueves' => 3,
        'viernes' => 3,
        'sabado' => 0,
        'usuario' => '',
        'created_at' => '',
        'updated_at' => '',
    ];
    public $familiar = [
        'id' => 0,
        'persona_Id' => 0,
        'apellidos' => '',
        'nombres' => '',
        'tipoidentificacion' => '',
        'identificacion' => '',
        'nacionalidad_id' => 0,
        'genero' => '',
        'telefono' => '',
        'direccion' => '',
        'email' => '',
        'parentesco' => '',
    ];
    public $dia = [
        0 =>'Libre',
        1 =>'Va',
        2 =>'Viene',
        3 =>'Viene/Va'
    ];
    public $relacion = [
        'MA' => 'Madre',
        'PA' => 'Padre',
        'AP' => 'Apoderado',
        'OT' => 'Otro',
    ];

    public $personaId, $nombres, $apellidos, $tipoident, $identificacion, $genero, $fechanace, $nacionalidad, $telefono, $etnia;
    public $tipodiscapacidad, $discapacidad, $email, $direccion;

    public $fnombres, $fapellidos, $ftipoident, $fidentificacion, $fgenero, $fnacionalidad, $ftelefono, $femail, $fdireccion, $fparentesco;
 
    public function mount($tuition_id){
        
        if ($tuition_id!=""){
            $this->search_nui = $tuition_id;
            $this->searchPerson();  
        }else{
            $this->chkoptnui="no";
        }

    }

    public function render()
    {   

        $record = TmPersonas::find(0);
        $tblgenerals = TmGeneralidades::where('superior',7)->get();

        return view('livewire.vc-personadd',[
            'record' => $record,
            'tblgenerals' => $tblgenerals,
        ]);

    }

    public function add(){
        
        $this->reset(['record']);
        $this->record['nombres']= "";
        $this->record['apellidos']= "";
        $this->record['tipoidentificacion']= "C";
        $this->record['identificacion']= "";
        $this->record['genero']= "M";  
        $this->record['fechanacimiento']= "";
        $this->record['nacionalidad_id']= 0; 
        $this->record['telefono']= "";
        $this->record['email']= "";
        $this->record['etnia']= "ME";
        $this->record['tipopersona']= "E";
        $this->record['estado']= 'A';

    }

    public function searchPerson(){
        
        $record = TmPersonas::where("identificacion",$this->search_nui)->first();
        $this->personaId = $record->id;
        $this->nombres = $record->nombres;
        $this->apellidos = $record->apellidos;
        $this->tipoident = $record->tipoidentificacion;
        $this->identificacion = $record->identificacion;
        $this->fechanace = date('Y-m-d',strtotime($record->fechanacimiento));
        $this->nacionalidad = $record->nacionalidad;
        $this->genero = $record->genero;
        $this->telefono = $record->telefono;
        $this->email = $record->email;
        $this->etnia = $record->etnia;
        $this->direccion = $record->direccion;

        $domicilios = TmDomicilioEstudiantes::where("estudiante_id",$this->personaId)->get()->toArray();
       
        if (empty($domicilios)) {
            $this->newDirections();
        }else{
            $this->directions =  $domicilios;
        }

        $familys =  TmFamiliarEstudiantes::query()
                    ->join("tm_personas as p","p.id","=","tm_familiar_estudiantes.persona_id")
                    ->where('estudiante_id',"{$this->personaId}")
                    ->select('tm_familiar_estudiantes.id','persona_id','apellidos','nombres','tipoidentificacion','identificacion','nacionalidad_id','genero','telefono','direccion','email','parentesco')
                    ->get()->toArray();

        if (empty($familys)) {
            $this->newFamiliar();
        }else{
            $this->familiares =  $familys;
        }

    }

    public function createData(){
      
        $this ->validate([
            'record.nombres' => 'required',
            'record.apellidos' => 'required',
            'record.tipoidentificacion' => 'required',
            'record.identificacion' => 'required',
            'record.genero' => 'genero',
            'record.fechanacimiento' => 'required',
            'record.nacionalidad_id' => 'required',
        ]);

        TmPersonas::Create([
            'nombres' => $this -> record['nombres'],
            'apellidos' => $this -> record['apellidos'],
            'tipoidentificacion' => $this -> record['tipoidentificacion'],
            'identificacion' => $this -> record['identificacion'],
            'genero' => $this -> record['genero'],
            'fechanacimiento' => $this -> record['fechanacimiento'],
            'nacionalidad_id' => $this -> record['nacionalidad_id'],
            'telefono' => $this -> record['telefono'],
            'email' => $this -> record['email'],
            'etnia' => $this -> record['etnia'],
            'tipopersona' => $this -> record['tipopersona'],
            'usuario' => auth()->user()->name,
            'estado' => $this -> record['estado'],
        ]);

        $this->dispatchBrowserEvent('hide-form', ['message'=> 'added successfully!']);  
        
    }

    public function updateData(){
        
        if ($this->personaId){
            $record = TmPersonas::find($this->personaId);
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
                'etnia' => $this -> etnia,
                'parentesco' => "",
                'tipopersona' => "E",
                'relacion_id' => 0
                ]);
            
        }

        foreach ($this->directions as $data){
            
            if ($data['id']>0){
                $record = TmDomicilioEstudiantes::find($data['id']);
                $record->update([
                    'estudiante_id' => $this->personaId,
                    'direccion' => $data['direccion'],
                    'domingo' => $data['domingo'],
                    'lunes' => $data['lunes'],
                    'martes' => $data['martes'],
                    'miercoles' => $data['miercoles'],
                    'jueves' => $data['jueves'],
                    'viernes' => $data['viernes'],
                    'sabado' => $data['sabado'],
                ]);
            }else {

                TmDomicilioEstudiantes::Create([
                    'estudiante_id' => $this->personaId,
                    'direccion' => $data['direccion'],
                    'domingo' => $data['domingo'],
                    'lunes' => $data['lunes'],
                    'martes' => $data['martes'],
                    'miercoles' => $data['miercoles'],
                    'jueves' => $data['jueves'],
                    'viernes' => $data['viernes'],
                    'sabado' => $data['sabado'],
                    'usuario' => auth()->user()->name,    
                ]); 
            }
            
        }

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
                    'estudiante_id'=> $this->personaId,
                    'persona_id'=> $newRecno['id'],
                    'informacion'=>'',
                    'usuario' => auth()->user()->name,
                ]);

            }

        }
        
    }

    public function newDirections(){

        $this->direction['id'] = 0;
        $this->direction['estudiante_id'] = 0;
        $this->direction['direccion'] = '';
        $this->direction['domingo'] = 0;
        $this->direction['lunes'] = 3;
        $this->direction['martes'] = 3;
        $this->direction['miercoles'] = 3;
        $this->direction['jueves'] = 3;
        $this->direction['viernes'] = 3;
        $this->direction['sabado'] = 0;
        $this->direction['usuario'] = '';
        $this->direction['created_at'] = '';
        $this->direction['updated_at'] = '';

    }

    public function addDirections()
    {
        array_push($this->directions,$this->direction);
        $this->newDirections();
    }

    public function activeControl(){
        $this->eControl2 = "";
        $this->newFamiliar();
        $this->dispatchBrowserEvent('active-tab');
    }

    public function newFamiliar(){
        $this->familiar['id'] = 0;
        $this->familiar['persona_Id']=0;
        $this->familiar['apellidos']='';
        $this->familiar['nombres']='';
        $this->familiar['tipoidentificacion']="C";
        $this->familiar['identificacion']='';
        $this->familiar['nacionalidad_id']=0;
        $this->familiar['genero']="M";
        $this->familiar['telefono']='';
        $this->familiar['direccion']='';
        $this->familiar['email']='';
        $this->familiar['parentesco']="MA";
    }

    public function addFamiliar()
    {
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

        if ($ape=='' || $nom=='' || $tip=='' || $ide=='' || $nac=='' || $gen=='' || $par==''){
            $this->dispatchBrowserEvent('family-msg');
            return;
        }else{ 
            array_push($this->familiares,$this->familiar);
            $this->newFamiliar();
            $this->eControl2 = "disabled";
            $this->dispatchBrowserEvent('active-tab');
        }
    }





    

}
