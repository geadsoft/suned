<?php

namespace App\Http\Livewire;
use App\Models\TmPeriodosLectivos;
use App\Models\TmGeneralidades;
use App\Models\TmServicios;
use App\Models\TmCursos;
use App\Models\TmHorarios;
use App\Models\TmHorariosDocentes;
use App\Models\TmHorariosAsignaturas;

use Livewire\Component;
use Livewire\WithPagination;

class VcHorarios extends Component
{

    use WithPagination;
    public $selectId;
    public $tblgenerals=null, $datos;
    public $tblperiodos=null;
    public $tblcursos=null;
    public $tblservicios=null;
    public $tbldatogen=null;

    public $filters=[
        'srv_periodo' => 0,
        'srv_grupo' => 2,
        'srv_nivel' => 0,
    ];

    public function mount(){

        $tblperiodos = TmPeriodosLectivos::where("aperturado",1)->first();
        $this->filters['srv_periodo'] = $tblperiodos['id'];
        
        $this->tblgenerals = TmGeneralidades::whereRaw('superior in (1,2,3)')->get();
        $this->tblperiodos = TmPeriodosLectivos::orderBy("periodo","desc")->get();
    
    }
    
    
    public function render()
    {
        $tblrecords = TmHorarios::query()
        ->join('tm_servicios as s','s.id','=','tm_horarios.servicio_id')
        ->when($this->filters['srv_periodo'],function($query){
            return $query->where('periodo_id',"{$this->filters['srv_periodo']}");
        })
        ->when((int)$this->filters['srv_grupo']>0,function($query){
            return $query->where('grupo_id',"{$this->filters['srv_grupo']}");
        })
        ->when((int)$this->filters['srv_nivel']>0,function($query){
            return $query->where('s.nivel_id',"{$this->filters['srv_nivel']}");
        })
        ->select('tm_horarios.*')
        ->paginate(10);

        $this->datos = TmHorariosDocentes::selectRaw('horario_id, count(asignatura_id) as materias, count(docente_id) as docentes')
        ->groupBy('horario_id')
        ->get();
        
        return view('livewire.vc-horarios',[
            'tblrecords' => $tblrecords,
            'tblgenerals' => $this->tblgenerals,
            'tblperiodos' => $this->tblperiodos,
        ]);
    }  

    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }

    public function edit($horarioId){
        
        $this->selectId = $horarioId;
        return redirect()->to('/headquarters/schedules-edit/'.$this->selectId);

    }

    public function delete($id){
        
        $this->selectId = $id;
        $actividad = TmHorariosDocentes::query()
        ->join("tm_actividades as a","a.paralelo","=","tm_horarios_docentes.id")
        ->where("tm_horarios_docentes.horario_id",$this->selectId)
        ->get();

        if ($actividad->isNotEmpty()){
            $this->dispatchBrowserEvent('msg-error');
        }else{
            $this->dispatchBrowserEvent('show-delete');
        }

    }

     public function deleteData(){

        TmHorariosDocentes::where('horario_id', $this->selectId)->delete();
        TmHorariosAsignaturas::where('horario_id', $this->selectId)->delete();
        TmHorarios::find($this->selectId)->delete();
        $this->dispatchBrowserEvent('hide-delete');
    }

}
