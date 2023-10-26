<?php

namespace App\Http\Livewire;
use App\Models\TmPersonas;
use App\Models\TmGeneralidades;
use App\Models\TmFamiliarEstudiantes;


use Livewire\Component;
use Livewire\WithPagination;

class VcPersonaladd extends Component
{
    use WithPagination;

    public $personaId, $tipo, $eControl='', $fControl='', $fileimg, $foto;

    public function mount($tipo){

        $this->tipo = $tipo;

    }

    public function render()
    {
        $record      = TmPersonas::find(0);
        $tblgenerals = TmGeneralidades::where('superior',7)->get();
        $familiares  = TmFamiliarEstudiantes::query()
        ->join("tm_personas as p","p.id","=","tm_familiar_estudiantes.persona_id")
        ->where('estudiante_id',"0")
        ->select('tm_familiar_estudiantes.id','persona_id','apellidos','nombres','tipoidentificacion','identificacion','nacionalidad_id','genero','telefono','direccion','email','parentesco')
        ->get()->toArray();

        return view('livewire.vc-personaladd',[
            'record' => $record,
            'tblgenerals' => $tblgenerals,
            'familiares' => $familiares
        ]);
    }

    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
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
            'etnia' => $this -> record['direccion'],
            'tipopersona' => $this->tipo,
            'usuario' => auth()->user()->name,
            'estado' => $this -> record['estado'],
            'foto' => $this -> record['foto'],
        ]);

        //$this->dispatchBrowserEvent('hide-form', ['message'=> 'added successfully!']);  
        
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
                'relacion_id' => 0,
                'foto' => $nameFile,
                ]);
            
            }
        
        $this->dispatchBrowserEvent('msg-actualizar');
        return redirect()->to('/academic/students');

    }


}
