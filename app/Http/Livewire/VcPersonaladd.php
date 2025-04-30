<?php

namespace App\Http\Livewire;
use App\Models\TmPersonas;
use App\Models\TmGeneralidades;
use App\Models\TmFamiliarEstudiantes;
use App\Models\User;


use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class VcPersonaladd extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $record=[];
    public $personaId, $tipo, $eControl='', $fControl='', $fileimg='', $foto;
    public $editar;

    public function mount($personaId){

        if ($personaId==0){

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

        } else {
            
            $this->personaId = $personaId;
            $this->editData();
        }

        
        //$this->tipo = $tipo;

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

    public function editData(){

        $personal = TmPersonas::find($this->personaId);

        $fecha = date('Y-m-d',strtotime($personal->fechanacimiento));

        $this->record['nombres'] = $personal->nombres;
        $this->record['apellidos'] = $personal->apellidos;
        $this->record['tipoidentificacion'] = $personal->tipoidentificacion;
        $this->record['identificacion'] = $personal->identificacion;
        $this->record['fechanacimiento'] =  $fecha;
        $this->record['nacionalidad_id'] = $personal->nacionalidad_id;
        $this->record['genero'] = $personal->genero;
        $this->record['telefono'] = $personal->telefono;
        $this->record['direccion'] = $personal->direccion;
        $this->record['email'] = $personal->email;
        $this->record['etnia'] = $personal->etnia;
        $this->record['tipopersona'] = $personal->tipopersona;
        $this->record['estado'] = $personal->estado;
        $this->record['foto'] = $personal->foto;
        $this->editar = true;


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

        $dominio = str_contains($this->record['email'],'@americanschool.edu.ec');
        if ($dominio){

            $pos = strpos($this->record['nombres'], ' ');
            if ($pos==0){
                $name = $this->record['nombres'];
            }else{
                $name = substr($this->record['nombres'],0,$pos);
            }

            $pos = strpos($this->record['apellidos'], ' ');
            if ($pos==0){
                $name = $name.' '.$this->record['apellidos'];
            }else{
                $name = $name.' '.substr($this->record['apellidos'],0,$pos);
            }

            User::Create([
                'name' => $name,
                'email' => $this->record['email'],
                'password' => Hash::make($this->record['identificacion']),
                'perfil' => 'U',
                'personaId' => $this->personaId,
                'acceso' => 1,
            ]);
        } 

        $this->dispatchBrowserEvent('msg-save');  
        return redirect()->to('/headquarters/staff');
        
    }

    public function updateData(){

        $record = TmPersonas::find($this->personaId);
        $record->update([
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

        $users   = User::where('personaid',$this->personaId)->get();
        $dominio = str_contains($this->record['email'],'@americanschool.edu.ec');
        if (count($users)==0 && $dominio){

            $pos = strpos($this->record['nombres'], ' ');
            if ($pos==0){
                $name = $this->record['nombres'];
            }else{
                $name = substr($this->record['nombres'],0,$pos);
            }

            $pos = strpos($this->record['apellidos'], ' ');
            if ($pos==0){
                $name = $name.' '.$this->record['apellidos'];
            }else{
                $name = $name.' '.substr($this->record['apellidos'],0,$pos);
            }

            User::Create([
                'name' => $name,
                'email' => $this->record['email'],
                'password' => Hash::make($this->record['identificacion']),
                'perfil' => 'U',
                'personaId' => $this->personaId,
                'acceso' => 1,
            ]);
        }       
        
        $this->dispatchBrowserEvent('msg-updated');
        return redirect()->to('/headquarters/staff');

    }

    public function validaNui(){

       
        $records = TmPersonas::where("identificacion",$this -> record['identificacion'])->first();
        
        if ($records != null){
            $this->dispatchBrowserEvent('msg-validanui');
        }
    }


}
