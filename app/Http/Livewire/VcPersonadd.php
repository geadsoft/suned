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
        'nacionalidad' => '',
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
        $this->record['genero']= "";  
        $this->record['fechanacimiento']= "";
        $this->record['nacionalidad']= 0; 
        $this->record['telefono']= "";
        $this->record['email']= "";
        $this->record['etnia']= "";
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
                       ->join("tm_personas as p","p.id","=","tm_familiar_estudiantes.estudiante_id")
                       ->where('estudiante_id',"{$this->personaId}")
                       ->select('tm_familiar_estudiantes.id','persona_id','apellidos','nombres','tipoidentificacion','identificacion','nacionalidad','genero','telefono','direccion','email','parentesco')
                       ->get();

        
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
            'record.nacionalidad' => 'required',
        ]);

        TmPersonas::Create([
            'nombres' => $this -> record['nombres'],
            'apellidos' => $this -> record['apellidos'],
            'tipoidentificacion' => $this -> record['tipoidentificacion'],
            'identificacion' => $this -> record['identificacion'],
            'genero' => $this -> record['genero'],
            'fechanacimiento' => $this -> record['fechanacimiento'],
            'nacionalidad' => $this -> record['nacionalidad'],
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

    public function newRelacion(){
        $this->relacion['id'] = 0;
        $this->relacion['persona_Id']='';
        $this->relacion['apellidos']='';
        $this->relacion['nombres']='';
        $this->relacion['tipoidentificacion']='';
        $this->relacion['identificacion']='';
        $this->relacion['nacionalidad']='';
        $this->relacion['genero']='';
        $this->relacion['telefono']='';
        $this->relacion['direccion']='';
        $this->relacion['email']='';
        $this->relacion['parentesco']='';
    }

    public function addRelacion()
    {
        array_push($this->relacions,$this->relacion);
        $this->newRelacion();
    }





    

}
