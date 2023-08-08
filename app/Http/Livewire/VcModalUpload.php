<?php

namespace App\Http\Livewire;
use App\Models\TmPersonas;
use App\Models\TmGeneralidades;
use App\Models\TmDocumentacion;
use App\Models\TmMatricula;
use App\Models\TmServicios;


use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class VcModalUpload extends Component
{   
    use WithFileUploads;
    public $objdocument=[], $tbldocument, $selectId, $nombres, $nui, $curso;

    protected $listeners = ['loadData'];

    public function mount()
    {
        $this->tbldocument = TmGeneralidades::where('superior',9)->get();

        foreach ($this->tbldocument as $key => $row){
            $iddoc = "doc".$key;
            $this->objdocument[$key]['id']   = $row->id;
            $this->objdocument[$key]['name'] = $row->descripcion;
            $this->objdocument[$key]['file'] = "";
        }

    }

    public function render()
    {   
        
        return view('livewire.vc-modal-upload',[
            'tbldocument' => $this->tbldocument,
            'objdocument' => $this->objdocument,
        ]);

    }

    public function loadData($id, $matricula){

        $this->selectId = $id;

        $tblpersona = TmPersonas::find($this->selectId);
        $this->nombres = $tblpersona['apellidos'].' '.$tblpersona['nombres'];
        $this->nui  = $tblpersona['identificacion'];

        $tblmatricula = TmMatricula::find($matricula);
        $servicioId   = $tblmatricula->curso->servicio_id;

        $tblservicio  = TmServicios::find($servicioId);
        $this->curso = $tblservicio->descripcion;
        
 
    }

    public function uploadFiles(){

        $this ->validate([
            'selectId' => 'required',
            'servicioId' => 'required',
            'nui' => 'required',
        ]);

        foreach ($this->objdocument as $data){
            
            if ($data['file'] != ''){

                TmDocumentacion::Create([
                    'estudiante_id' => $this->selectId,
                    'servicio_id' => $this->servicioId,
                    'documentacion_id' => $data['id'],
                    'carpeta' => $this -> $this->nui,
                    'archivo' => $this -> $data['file'],
                    'usuario' => auth()->user()->name,
                ]);

                $extension = $data['file']->getClientOriginalExtension();
                $name = $data['file']->getClientOriginalName();
                
                $file = $name.'.'.$extension;
                $data['file']->storeAs('document/'.$this->nui, $name,'public_uploads');

            }

        }

        $this->dispatchBrowserEvent('hide-form');

    }


}
