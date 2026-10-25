<?php

namespace App\Http\Livewire;
use App\Models\TmPersonas;
use App\Models\TmPeriodosLectivos;
use App\Models\TmGeneralidades;
use App\Models\TmCursos;

use Livewire\Component;
use Livewire\WithPagination;

use App\Exports\RepresentantesExport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\Exportable;

class VcAgents extends Component
{   
    use WithPagination;

    public $filters=[
        'srv_nombre'=>'',
        'srv_periodo' => '',
        'srv_grupo' => '',
        'srv_curso' => ''
    ];

    public function mount()
    {
        $tblperiodos = TmPeriodosLectivos::where("aperturado",1)->first();
        $this->filters['srv_periodo'] = $tblperiodos['id'];
    }
  
    public function render()
    {
        $tblperiodos = TmPeriodosLectivos::orderBy("periodo","desc")->get();
        $tblgenerals = TmGeneralidades::where('superior',1)->get();
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
        ->join("tm_matriculas as m","m.representante_id","=","tm_personas.id")
        ->join("tm_personas as e","m.estudiante_id","=","e.id")
        ->join("tm_cursos as c","c.id","=","m.curso_id")
        ->join("tm_servicios as s","s.id","=","c.servicio_id")
        ->join("tm_periodos_lectivos as p","p.id","=","m.periodo_id")
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
        ->where('tm_personas.tipopersona','=','R')
        ->select('tm_personas.*','m.id as matriculaId','m.estudiante_id','s.descripcion','c.paralelo','m.usuario','e.apellidos as apeestudiante','e.nombres as nomestudiante','p.descripcion as periodo')
        ->orderBy('tm_personas.apellidos','asc')
        ->paginate(12);
        
        /*TmPersonas::query()
        ->when($this->filters['srv_nombre'],function($query){
            return $query->whereRaw("concat(tm_personas.apellidos,' ',tm_personas.nombres) LIKE '%".$this->filters['srv_nombre']."%'");
        })
        ->where('tipopersona','R')
        ->orderBy('apellidos','asc')
        ->paginate(10)*/;

        $views = TmPersonas::find(1);
        $this->view = $views;
        
        return view('livewire.vc-agents',[
            'tblrecords' => $tblrecords,
            'tblperiodos' => $tblperiodos,
            'tblgenerals' => $tblgenerals,
            'tblcursos'   => $tblcursos,
        ]);

    }

    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }

    public function view( $id ){
        
        $this->view = TmPersonas::find($id)->toArray();

    }

    public function edit(TmPersonas $tblrecords ){
        
        $this->record  = $tblrecords->toArray();
        $this->selectId = $this -> record['id'];

        return redirect()->to('/academic/person-add');

    }

    public function exportExcel(){

        $data = json_encode($this->filters);
        return Excel::download(new RepresentantesExport($data), 'Listado de Representantes.xlsx');
        
    }
    
}
