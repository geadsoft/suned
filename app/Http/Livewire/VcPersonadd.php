<?php

namespace App\Http\Livewire;
use App\Models\TmPersonas;


use Livewire\Component;

class VcPersonadd extends Component
{
    public $record;

    public function render()
    {   

        $record = TmPersonas::find(0);
        $this->add();

        return view('livewire.vc-personadd',[
            'record' => $record
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
        dd($this->record);

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

}
