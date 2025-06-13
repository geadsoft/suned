<?php

namespace App\Http\Livewire;
use App\Models\TmPeriodosLectivos;
use App\Models\TmRecursos;

use Livewire\Component;
use Livewire\WithPagination;

class VcResources extends Component
{
    use WithPagination;

    public $periodoId, $docenteId;
    public $tipolink=[
        'youtube' => "ri-youtube-line",
        'link' => "ri-ie-line",
    ]

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
        ->select("a.descripcion","enlace","nombre")
        ->paginate(10);

        


        return view('livewire.vc-resources',[
            'tblrecords' => $tblrecords
        ]);
    }

    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }
}
