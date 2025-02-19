<?php

namespace App\Http\Livewire;
use App\Models\TmPersonas;
use App\Models\TmFamiliarEstudiantes;
use App\Models\TmGeneralidades;

use Livewire\Component;

class VcPersonsFamily extends Component
{
    public $personaId, $familiarId;
    public $familiares, $familiar;
    public $eControl2 = 'disabled';
    public $tblgenerals;
    public $relacion = [
        'MA' => 'Madre',
        'PA' => 'Padre',
        'AP' => 'Apoderado',
        'OT' => 'Otro',
        'NN' => 'Selecione Relacion',
    ];
    
    public function mount($personaId)
    {
        
        $this->tblgenerals = TmGeneralidades::where('superior',7)->get();

        if($personaId>0){
            $this->personaId = $personaId;
            $this->loadFamiliar();
        }
        
    }


    public function render()
    {
        return view('livewire.vc-persons-family',[
            'familiares' => $this->familiares
        ]);
    }

    public function loadFamiliar(){

        $this->familiares = TmFamiliarEstudiantes::query()
        ->join("tm_personas as p","p.id","=","tm_familiar_estudiantes.persona_id")
        ->where('estudiante_id',$this->personaId)
        ->select('p.*')
        ->get()->toArray(); 

    }

    public function loadNui(){

        $records = TmPersonas::where("identificacion",$this->familiar['identificacion'])->first();
        if (!empty($records)){

            $this->familiarId = $records['id'];
            $this->familiar = TmPersonas::find($this->familiarId)->toArray();
            
        }

    }

    public function newData(){

        $this->familiarId = 0;
        $this->familiar['nombres'] = '';
        $this->familiar['apellidos'] = '';
        $this->familiar['tipoidentificacion'] = 'C';
        $this->familiar['identificacion'] = '';
        $this->familiar['genero'] = '';
        $this->familiar['nacionalidad_id'] = '';
        $this->familiar['telefono'] = '';
        $this->familiar['parentesco'] = 'NN';
        $this->familiar['email'] = '';
        $this->familiar['direccion'] = '';
        $this->eControl2 = '';
        
    }

    public function editData($familiarId){

        $this->familiarId = $familiarId;
        $this->familiar = TmPersonas::find($familiarId)->toArray();
        $this->eControl2 = '';
        
    }

    public function createData(){

        $familiar = TmPersonas::Create([
            'nombres' => $this -> familiar['nombres'],
            'apellidos' => $this -> familiar['apellidos'],
            'tipoidentificacion' => $this -> familiar['tipoidentificacion'],
            'identificacion' => $this -> familiar['identificacion'],
            'genero' => $this -> familiar['genero'],
            'fechanacimiento' => "1900-01-01",
            'nacionalidad_id' => $this -> familiar['nacionalidad_id'],
            'genero' => $this->familiar['genero'],
            'telefono' => $this -> familiar['telefono'],
            'email' => $this -> familiar['email'],
            'etnia' => "",
            'parentesco' => $this -> familiar['parentesco'],
            'tipopersona' => "R",
            'relacion_id' => 0,
            'direccion' => $this->familiar['direccion'],
            'usuario' => auth()->user()->name,
            'estado' => "A",
        ]);

        TmFamiliarEstudiantes::Create([
            'estudiante_id'=> $this->personaId,
            'persona_id'=> $familiar['id'],
            'informacion'=>'',
            'usuario' => auth()->user()->name,
        ]);

        $this->newData(); 
        $this->loadFamiliar();
        $this->eControl2 = 'disabled'; 

    }

    public function updateData(){

        $record = TmPersonas::find($this->familiarId);
        $record->update([
            'nombres' => $this->familiar['nombres'],
            'apellidos' => $this->familiar['apellidos'],
            'tipoidentificacion' => $this->familiar['tipoidentificacion'],
            'identificacion' => $this->familiar['identificacion'],
            'nacionalidad_id' => $this->familiar['nacionalidad_id'],
            'genero' => $this->familiar['genero'],
            'telefono' => $this->familiar['telefono'],
            'direccion' => $this->familiar['direccion'],
            'email' => $this->familiar['email'],
            'etnia' => $this->familiar['etnia'],
            'parentesco' => $this->familiar['parentesco'],
            ]);

        $familiar = TmFamiliarEstudiantes::query()
        ->where("estudiante_id",$this->personaId)
        ->where("persona_id",$this->familiarId)
        ->first();

        if (empty($familiar)){

            TmFamiliarEstudiantes::Create([
                'estudiante_id'=> $this->personaId,
                'persona_id'=> $this->familiarId,
                'informacion'=>'',
                'usuario' => auth()->user()->name,
            ]);

        }
         
        $this->newData(); 
        $this->loadFamiliar();
        $this->eControl2 = 'disabled'; 
    }

    public function deleteData($familiarId){

        TmFamiliarEstudiantes::where('persona_id',$familiarId)->delete();
        TmPersonas::find($familiarId)->delete();
        
        $this->loadFamiliar();

    }


}
