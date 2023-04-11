<?php

namespace App\Http\Livewire;
use App\Models\TmPersonas;
use App\Models\TmGeneralidades;
use App\Models\TmFamiliarEstudiantes;

use Livewire\Component;

class VcPersonEnrollment extends Component
{
    
    public $search_nui="";
    public $chkoption="si";
    public $persona_id=0;
    public $nombres, $apellidos, $tipoident="C", $identificacion="", $genero="F", $fechanace, $nacionalidad=35, $telefono, $etnia="ME";
    public $email, $direccion, $parenteso, $eControl;
    public $estudianteId, $datoFamiliar;

    protected $listeners = ['loadFamiliar']; 

    public function mount($estudianteId, $datoFamiliar){

        $this->estudianteId = $estudianteId;
        $this->datoFamiliar  = $datoFamiliar;

    }
   
    public function render()
    {   
        $this->eControl = "";

        if ($this->chkoption=="no"){
            $this->eControl = "";
            $this->persona_id = 0;
        }

        $tblgenerals = TmGeneralidades::where("superior",7)->get();
        $tblfamilys  = TmFamiliarEstudiantes::query()
                        ->join("tm_personas as p","p.id","=","tm_familiar_estudiantes.persona_id")
                        ->where('estudiante_id',"{$this->estudianteId}")
                        ->select('tm_familiar_estudiantes.id','persona_id','apellidos','nombres','tipoidentificacion','identificacion','nacionalidad_id','genero','telefono','direccion','email','parentesco')
                        ->get();
        
        return view('livewire.vc-person-enrollment',[
            'tblgenerals' => $tblgenerals,
            'tblfamilys'  => $tblfamilys,
        ]);
    }

    //protected $listeners = ['grabar' => 'saveperson'];
    //protected $listeners = ['savePerson'];
    public function loadFamiliar($nuifamiliar){
        $this->search_nui = $nuifamiliar;
        $this->searchPerson();
    }

    public function searchPerson(){
        
        $records = TmPersonas::where("identificacion",$this->search_nui)->first();

        if ( $records != null) {

            $this->persona_id = $records->id;
            $this->nombres = $records->nombres;
            $this->apellidos = $records->apellidos;
            $this->tipoident = $records->tipoidentificacion;
            $this->identificacion = $records->identificacion;
            $this->fechanace = date('Y-m-d',strtotime($records->fechanacimiento));
            $this->nacionalidad = $records->nacionalidad_id;
            $this->genero = $records->genero;
            $this->email = $records->email;
            $this->etnia = $records->etnia;
            $this->direccion = $records->direccion;
            $this->parentesco = $records->parentesco;
            $this->telefono=$records->telefono;
        
        }else{
            
            $this->dispatchBrowserEvent('show-message');

        }

    }

    public function validaNui(){
        
        if ($this->search_nui==$this->identificacion){
            return;
        }

        $records = TmPersonas::where("identificacion",$this->identificacion)->first();

        if ($records != null){
            $this->dispatchBrowserEvent('msg-validanui');
        }

    }


    public function savePerson($relacionId)
    {   

        if($this->chkOption=="no"){

            $this ->validate([
                'nombres' => 'required',
                'apellidos' => 'required',
                'tipoident' => 'required',
                'identificacion' => 'required',
                'fechanace' => 'required',
                'nacionalidad' => 'required',
                'genero' => 'required',
                'telefono' => 'required',
                'email' => 'required',
                'etnia' => 'required',
                'direccion' => 'required',
                'parentesco' => 'required',
            ]);

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
                'parentesco' => $this->parentesco,
                'tipopersona' => "R",
                'relacion_id' => $relacionId,
                'usuario' => auth()->user()->name,
                'estado' => "P",
            ]);

            $tblnew = TmPersonas::orderBy("id", "desc")->first();
            $this->persona_id = $this->tblnew['id'];
        }
        
    }

    


}
