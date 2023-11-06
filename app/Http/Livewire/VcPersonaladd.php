<?php

namespace App\Http\Livewire;
use App\Models\TmPersonas;
use App\Models\TmGeneralidades;
use App\Models\TmFamiliarEstudiantes;


use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class VcPersonaladd extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $record=[];
    public $personaId, $tipo, $eControl='', $fControl='', $fileimg='', $foto;

    public function mount($tipo){

        $this->record  = TmPersonas::find(0);
        $this->record['nombres'] = "";
        $this->record['apellidos'] = "";
        $this->record['tipoidentificacion'] = "C";
        $this->record['identificacion'] = "";
        $this->record['fechanacimiento'] = "";
        $this->record['nacionalidad_id'] = 35;
        $this->record['genero'] = "M";
        $this->record['telefono'] = "";
        $this->record['direccion'] = "";
        $this->record['email'] = "";
        $this->record['etnia'] = "ME";
        $this->record['tipopersona'] = "A";
        $this->record['estado'] = "A";
        $this->record['foto'] = "";
        $this->tipo = $tipo;

    }

    public function render()
    {
        $tblgenerals = TmGeneralidades::where('superior',7)->get();
        $familiares  = TmFamiliarEstudiantes::query()
        ->join("tm_personas as p","p.id","=","tm_familiar_estudiantes.persona_id")
        ->where('estudiante_id',"0")
        ->select('tm_familiar_estudiantes.id','persona_id','apellidos','nombres','tipoidentificacion','identificacion','nacionalidad_id','genero','telefono','direccion','email','parentesco')
        ->get()->toArray();

        return view('livewire.vc-personaladd',[
            'record' => $this->record,
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
            'record.genero' => 'required',
            'record.fechanacimiento' => 'required',
            'record.nacionalidad_id' => 'required',
        ]);

        if($this->fileimg ?? null){
            $this ->validate([
                'fileimg' => ['image', 'mimes:jpg,jpeg,png', 'max:1024'],
                ]);

            $nameFile = $this->record['identificacion'].'.'.$this->fileimg->getClientOriginalExtension();
            $pathfile = 'storage/'.$this->fileimg->storeAs('public/fotos', $nameFile);

            $this->record['foto'] = $nameFile;
        }

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
            'direccion' => $this -> record['direccion'],
            'tipopersona' => $this -> record['tipopersona'],
            'parentesco' => "NN",
            'relacion_id' => 0,
            'usuario' => auth()->user()->name,
            'estado' => $this -> record['estado'],
            'foto' => $this -> record['foto'],
        ]);

        $this->dispatchBrowserEvent('msg-save');  
        return redirect()->to('/headquarters/staff');
        
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

    public function validaNui(){

       
        $records = TmPersonas::where("identificacion",$this -> record['identificacion'])->first();
        
        if ($records != null){
            $this->dispatchBrowserEvent('msg-validanui');
        }
    }


}
