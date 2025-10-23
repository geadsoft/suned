<?php

namespace App\Http\Livewire;
use App\Models\TrBuzon;

use Livewire\Component;

class VcSuggestionBox extends Component
{
    public $proceso, $tipo, $identificacion, $nombres, $email, $telefono, $texteditor;

    protected $listeners = ['updateEditorData'];
    
    public function mount()
    {
        $this->add();
    }
    
    public function render()
    {
        return view('livewire.vc-suggestion-box');
    }

    public function add()
    {
        $this->proceso = 'S'; 
        $this->tipo = 'C'; 
        $this->identificacion = '';
        $this->nombres = ''; 
        $this->email = '';
        $this->telefono = ''; 
        $this->texteditor = '';
    }

    public function createData(){
        
        $this ->validate([
            'proceso' => 'required',
            'tipo' => 'required',
            'identificacion' => 'required',
            'nombres' => 'required',
            'email' => 'required',
            'telefono' => 'required',
            'texteditor' => 'required',
        ]);

        TrBuzon::Create([
            'categoria' => $this -> proceso,
            'tipo' => $this -> tipo,
            'identificacion' => $this -> identificacion,
            'nombres' => $this -> nombres,
            'email' => $this -> email,
            'telefono' => $this -> telefono,
            'comentario' =>  trim(strip_tags($this -> texteditor)),
            'usuario' => auth()->user()->name,
        ]);

        $message = nl2br("¡Gracias por compartir su opinión! Valoramos mucho sus comentarios y trabajamos constantemente para mejorar.");
        $this->dispatchBrowserEvent('msg-grabar', ['newName' => $message]);
        
    }

    public function updateEditorData($data)
    {
        $this->texteditor = $data;
    }

    public function setEditorData($data){
        $this->texteditor = $data;
        
    }

}
