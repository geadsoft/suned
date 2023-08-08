<?php

namespace App\Http\Livewire;

use App\Models\TmPersonas;
use App\Models\TmPeriodosLectivos;
use App\Models\TmGeneralidades;
use App\Models\TmCursos;

use Livewire\Component;
use Livewire\WithPagination;

use Illuminate\Support\Facades\Storage;
use App\Document;

class VcDocumentos extends Component
{
    use WithPagination;
    
    public $tblperiodos, $tblgenerals;
    public $estudiante, $selectId, $matriculaId;

    public $filters = [
        'srv_nombre' => '',
        'srv_periodo' => '',
        'srv_grupo' => '',
        'srv_curso' => '',
        'srv_genero' => '',
        'srv_reporte' => '',
        'srv_estado' => 'A',
    ];

    public  function mount()
    {
        $this->tblperiodos = TmPeriodosLectivos::orderBy("periodo","desc")->get();
        $this->tblgenerals = TmGeneralidades::where('superior',1)->get();

        $this->filters['srv_periodo'] = $this->tblperiodos[0]['id'];
    }


    public function render()
    {
        
        $tblcursos   = TmCursos::query()
        ->when($this->filters['srv_periodo'],function($query){
            return $query->where('periodo_id',"{$this->filters['srv_periodo']}");
        })
        ->when($this->filters['srv_grupo'],function($query){
            return $query->where('grupo_id',"{$this->filters['srv_grupo']}");
        })
        ->orderByRaw('nivel_id,grado_id,paralelo')
        ->get();
        
        $tblrecords = TmPersonas::query()
        ->join("tm_matriculas as m","m.estudiante_id","=","tm_personas.id")
        ->when($this->filters['srv_nombre'],function($query){
            return $query->whereRaw("concat(tm_personas.apellidos,' ',tm_personas.nombres) LIKE '%".$this->filters['srv_nombre']."%'");
        })
        ->when($this->filters['srv_periodo'],function($query){
            return $query->where('m.periodo_id',"{$this->filters['srv_periodo']}");
        })
        ->when($this->filters['srv_grupo'],function($query){
            return $query->where('m.modalidad_id',"{$this->filters['srv_grupo']}");
        })
        ->when($this->filters['srv_curso'],function($query){
            return $query->where('m.curso_id',"{$this->filters['srv_curso']}");
        })
        ->where('tm_personas.tipopersona','=','E')
        ->where('tm_personas.estado',$this->filters['srv_estado'])
        ->select('tm_personas.*','m.documento', 'm.id as matricula_id')
        ->orderBy('apellidos','asc')
        ->paginate(12);

        return view('livewire.vc-documentos',[
            'tblrecords'  => $tblrecords,
            'tblperiodos' => $this->tblperiodos,
            'tblgenerals' => $this->tblgenerals,
            'tblcursos'   => $tblcursos,
        ]);

    }

    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }

    public function add($id, $matricula){

        $this->selectId    = $id;
        $this->matriculaId = $matricula;

        $this->dispatchBrowserEvent('show-form');
        $this->emitTo('vc-modal-upload','loadData',$id,$matricula);
    }


}
