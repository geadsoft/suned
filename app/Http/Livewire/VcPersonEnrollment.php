<?php

namespace App\Http\Livewire;
use App\Models\TmPersonas;

use Livewire\Component;

class VcPersonEnrollment extends Component
{
    
    public $search_nui;
    public $chkoption="si";
    public $persona_id=0;
    public $nombres, $apellidos, $tipoident, $identificacion, $genero, $fechanace, $nacionalidad, $telefono, $etnia="ME";
    public $email, $direccion, $parenteso, $eControl;
    
    public function render()
    {   
        $this->eControl = "disabled";

        if ($this->chkoption=="no"){
            $this->eControl = "";
            $this->persona_id = 0;
        }
        
        return view('livewire.vc-person-enrollment');
    }

    //protected $listeners = ['grabar' => 'saveperson'];
    protected $listeners = ['savePerson'];

    public function searchPerson(){
        
        $records = TmPersonas::where("identificacion",$this->search_nui)->first();

        if ( $records != null) {

            $this->persona_id = $records->id;
            $this->nombres = $records->nombres;
            $this->apellidos = $records->apellidos;
            $this->tipoident = $records->tipoidentificacion;
            $this->identificacion = $records->identificacion;
            $this->fechanace = date('Y-m-d',strtotime($records->fechanacimiento));
            $this->nacionalidad = $records->nacionalidad;
            $this->genero = $records->genero;
            $this->nacionalidad = $records->telefono;
            $this->email = $records->email;
            $this->etnia = $records->etnia;
            $this->direccion = $records->direccion;
            $this->parentesco = $records->parentesco;
            $this->telefono=$records->telefono;
        
        }else{
            
            $this->dispatchBrowserEvent('show-message');

        }

    }

    public function savePerson($relacionId)
    {   
        dd($this->$chkoption);

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
