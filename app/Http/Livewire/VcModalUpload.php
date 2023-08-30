<?php

namespace App\Http\Livewire;
use App\Models\TmPersonas;
use App\Models\TmGeneralidades;
use App\Models\TmDocumentacion;
use App\Models\TmMatricula;
use App\Models\TmServicios;
use App\Models\TmPeriodosLectivos;
use App\Models\TmCursos;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class VcModalUpload extends Component
{   
    use WithFileUploads;
    public $tblperiodos, $documentos, $tblgrados=[];
    public $objdocument=[], $tbldocument, $selectId, $nombres, $nui, $curso, $periodoId, $servicioId;

    protected $listeners = ['loadData'];

    public function mount()
    {
        $this->tbldocument  = TmGeneralidades::where('superior',9)->get();

        $this->tblservicios = TmServicios::where('modalidad_id',2)
        ->orderByRaw('nivel_id,grado_id')
        ->get();

        $this->tblperiodos = TmPeriodosLectivos::orderBy("periodo","desc")->get();
        $this->periodoId   = $this->tblperiodos[0]['id']; 

        foreach ($this->tbldocument as $key => $row){
            $iddoc = "doc".$key;
            $this->objdocument[$key]['id']   = $row->id;
            $this->objdocument[$key]['name'] = $row->descripcion;
            $this->objdocument[$key]['file']    = "";
            $this->objdocument[$key]['archivo'] = "";
            $this->objdocument[$key]['documentoid'] = 0;
        }

    }

    public function render()
    {   
        
        return view('livewire.vc-modal-upload',[
            'tbldocument' => $this->tbldocument,
            'objdocument' => $this->objdocument,
        ]);

    }

    public function loadData($id){

        $this->selectId = $id;

        $tblpersona = TmPersonas::find($this->selectId);
        $this->nombres = $tblpersona['apellidos'].' '.$tblpersona['nombres'];
        $this->nui     = $tblpersona['identificacion'];

        $matriculas = TmMatricula::where('estudiante_id',$id)
        ->where('periodo_id',$this->periodoId)
        ->get()
        ->toArray();

        $matricula = $matriculas[0];

        $this->tblservicios = TmServicios::where('modalidad_id',$matricula['modalidad_id'])
        ->orderByRaw('nivel_id,grado_id')
        ->get();

        $curso = TmCursos::find($matricula['curso_id']);
        $this->servicioId = $curso->servicio_id;

        $this->tblgrados = TmServicios::where('id','<',$this->servicioId)
        ->get();
 
    }

    public function uploadFiles(){

        $this ->validate([
            'selectId' => 'required',
            'servicioId' => 'required',
            'nui' => 'required',
        ]);

        foreach ($this->objdocument as $data){            

            if ($data['file'] != '' && $data['documentoid']==0){
                
                $extension = $data['file']->getClientOriginalExtension();
                $name = $data['file']->getClientOriginalName();
                $file = $name;

                TmDocumentacion::Create([
                    'periodo_id'    => $this->periodoId,
                    'estudiante_id' => $this->selectId,
                    'servicio_id'   => $this->servicioId,
                    'documentacion_id' => $data['id'],
                    'carpeta' => $this->nui,
                    'archivo' => $file,
                    'usuario' => auth()->user()->name,
                ]);
                
                $data['file']->storeAs('document/'.$this->nui, $name,'public_uploads');

            }

            if ($data['file'] != '' && $data['documentoid']>0){
                
                $extension = $data['file']->getClientOriginalExtension();
                $name = $data['file']->getClientOriginalName();
                $file = $name;

                $record = TmDocumentacion::find($data['documentoid']);
                $record->update([
                    'archivo' => $file,
                ]);
                
                $data['file']->storeAs('document/'.$this->nui, $name,'public_uploads');

            }

        }

        $this->dispatchBrowserEvent('hide-form');

    }

    public function updatedservicioId(){

        $this->documentos = TmDocumentacion::where('periodo_id',$this->periodoId)
        ->where('estudiante_id',$this->selectId)
        ->where('servicio_id',$this->servicioId)
        ->get();

        foreach ($this->documentos as $key => $row){

            for ($i=0;$i<=count($this->objdocument)-1;$i++){
                
                if ($this->objdocument[$i]['id']== $row['documentacion_id']){
                    $this->objdocument[$i]['archivo']    =$row['archivo'];
                    $this->objdocument[$i]['documentoid']=$row['id'];
                }

            }

        }       

    }

    public function export($idRow)
    {
        foreach ($this->documentos as $row){
            
            if ($row['documentacion_id']==$idRow){
                $path = 'document/'.$row['carpeta'].'/'.$row['archivo'];
            }

        }

        return Storage::disk('public_uploads')->download($path);
    }

    public function delete($fila)
    {
        $this->objdocument[$fila]['archivo']="";
    }


}
