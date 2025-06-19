<?php

namespace App\Http\Livewire;
use App\Models\TmPeriodosLectivos;
use App\Models\TmRecursos;
use App\Models\TdRecursosCursos;

use Livewire\Component;
use Livewire\WithPagination;

class VcResources extends Component
{
    use WithPagination;

    public $periodoId, $docenteId;
     public $selectedId = null;
    public $detalles = [];

    public $tipolink=[
        'youtube' => "ri-youtube-line",
        'link' => "ri-ie-line",
    ];

    public $arrdoc = [
        'doc' => 'ri-file-word-2-line',
        'docx' => 'ri-file-word-2-line',
        'xls' => 'ri-file-excel-2-line',
        'xlsx' => 'ri-file-excel-2-line',
        'ppt' => ' ri-file-ppt-2-line',
        'pptx' => 'ri-file-ppt-2-line',
        'pdf' => 'ri-file-pdf-line',
        'html' => 'ri-file-code-line',
        'jpg' => 'ri-picture-in-picture-fill',
        'png' => 'ri-picture-in-picture-fill',
    ];

    public $arrcolor = [  
        'doc' => 'text-primary',
        'docx' => 'text-primary',
        'jpg' => 'text-warning',
        'png' => 'text-warning',
        'xls' => 'text-success',
        'xlsx' => 'text-success',
        'ppt' => ' text-danger',
        'pptx' => 'text-danger',
        'pdf' => 'text-danger',
        'html' => 'text-info',
    ];

    public function mount(){

        $ldate = date('Y-m-d H:i:s');
        $fecha = date('Y-m-d',strtotime($ldate));

        $this->docenteId = auth()->user()->personaId;

        $tblperiodos = TmPeriodosLectivos::where("aperturado",1)->first();
        $this->periodoId = $tblperiodos['id'];

    }

    
    public function render()
    {
        $tblrecords = TmRecursos::query()
        ->join("tm_asignaturas as a","a.id","=","tm_recursos.asignatura_id")
        ->where("tm_recursos.periodo_id",$this->periodoId)
        ->where("tm_recursos.docente_id",$this->docenteId)
        ->select("a.descripcion","enlace","nombre","tm_recursos.id")
        ->paginate(10);

        $files = TmRecursos::query()
        ->join("tm_files as f","f.actividad_id","=","tm_recursos.id")
        ->where("tm_recursos.periodo_id",$this->periodoId)
        ->where("tm_recursos.docente_id",$this->docenteId)
        ->get();

        return view('livewire.vc-resources',[
            'tblrecords' => $tblrecords,
            'files' => $files
        ]);
    }

    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }

    public function verDetalles($id)
    {
        if ($this->selectedId === $id) {
            // Si ya está abierto, lo cierra
            $this->selectedId = null;
            $this->detalles = [];
        } else {
            $this->selectedId = $id;
            $this->detalles = TdRecursosCursos::query()
            ->join("tm_cursos as c","c.id","=","td_recursos_cursos.curso_id")
            ->join("tm_servicios as s","s.id","=","c.servicio_id")
            ->join("tm_generalidades as g","g.id","=","s.modalidad_id")
            ->select("g.descripcion as modalidad","s.descripcion as curso")
            ->where('recurso_id', $id)
            ->get();
        }
    }

    public function edit($id)
    {
        return redirect()->to('/subject/resource-edit/'.$id);
    }

    public function delete( $id ){
        
 
        $this->selectId = $id;
        $this->dispatchBrowserEvent('show-delete');

    }

    public function deleteData(){
        TmGeneralidades::find($this->selectId)->delete();
        $this->dispatchBrowserEvent('hide-delete');
    }


}
