<?php

namespace App\Http\Livewire;
use App\Models\TmPersonas;
use Livewire\Component;

use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class VcConfigProfile extends Component
{
    use WithFileUploads;

    public $userId, $usuario, $passwordOld, $passwordNew, $passwordConfirmar,  $personas=[];
    public $foto, $fileimg='';
    public $tipopersona=[
        'E' => 'Estudiante',
        'R' => 'Representante',
        'F' => 'Familiar',
        'D' => 'Docente',
        'P' => 'Apoyo Profesional',
        'A' => 'Administrativo',
        'S' => 'Sistemas',
        'M' => 'Mantenimiento y Operaciones'
    ];

    public function mount()
    {
        $this->userId = auth()->user()->id;
        $this->usuario = auth()->user()->name;
        $this->load();
    }

    
    public function render()
    {
        return view('livewire.vc-config-profile',[
            'personas' => $this->personas,
        ]);

    }

    public function load()
    {
        $personaId = auth()->user()->personaId;
        $this->personas = TmPersonas::find(2913)->toArray();
        
        $this->foto = $this->personas['foto'];

        $contents   = Storage::disk('public')->exists('fotos/'.$this->foto);
        
        if($contents==false){
            $this->foto='';
        }
        
    }

    public function updateData(){

        $nameFile='';

        if($this->fileimg ?? null){
            $this ->validate([
                'fileimg' => ['image', 'mimes:jpg,jpeg,png', 'max:1024'],
                ]);

            $nameFile = $this->personas['identificacion'].'.'.$this->fileimg->getClientOriginalExtension();
            $pathfile = 'storage/'.$this->fileimg->storeAs('public/fotos', $nameFile);
        }

        if ($this->userId){

            $record = TmPersonas::find($this->personas['id']);
            $record->update([
                'nombres' => $this->personas['nombres'],
                'apellidos' => $this->personas['apellidos'],
                'identificacion' => $this->personas['identificacion'], 
                'telefono' => $this->personas['telefono'],
                'direccion' => $this->personas['direccion'],
                'foto' => $nameFile,
                ]);

        }

        $this->dispatchBrowserEvent('msg-actualizar');
        return redirect()->to('/academic/students');

    }

    public function updatePassword(){

        if($this->passwordOld=='' || $this->passwordNew == '' || $this->passwordConfirmar == ''){
            return;
        }

        $password = auth()->user()->password;
        
        if (!Hash::check($this->passwordOld,  $password)) {
            return;
        }

        if ($this->passwordNew != $this->passwordConfirmar){
            return;
        }

        auth()->user()->update([
            'password' => Hash::make($this->passwordNew),
        ]);

        $this->passwordOld="";
        $this->passwordNew="";
        $this->passwordConfirmar="";

        $this->dispatchBrowserEvent('msg-password');

    }

   



}
