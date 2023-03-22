<?php

namespace App\Http\Livewire;
use App\Models\TmPeriodosLectivos;
use App\Models\TmMatricula;
use App\Models\TmGeneralidades;

use Livewire\Component;

class VcModalSearch extends Component
{

    public $filters = [
        'srv_nombre' => '',
        'srv_grupo' => 0,
        'srv_periodo' => 0,
    ];

    public function mount()
    {
        $tblperiodo = TmPeriodosLectivos::orderBy('periodo','desc')->first();
        $this->filters['srv_periodo'] = $tblperiodo['id'];
    }
    
    public function render()
    {
        $tblgenerals = TmGeneralidades::where('superior',1)->get();
        $tblperiodos = TmPeriodosLectivos::orderBy("periodo","desc")->get(); 
        $tblrecords  = [];

        if (!empty($this->filters['srv_nombre'])){
            $tblrecords = $this->loadpersona();
        }
        
        return view('livewire.vc-modal-search',[
            'tblrecords' => $tblrecords,
            'tblgenerals' => $tblgenerals,
            'tblperiodos' => $tblperiodos,
        ]);

    }

    public function loadpersona(){

        $tbldata = TmMatricula::query()
        ->join('tm_personas as p','p.id','=','tm_matriculas.estudiante_id')
        ->when($this->filters['srv_nombre'],function($query){
            return $query->where('p.apellidos','LIKE','%'.$this->filters['srv_nombre'].'%')
                        ->orWhere('p.nombres','LIKE','%'.$this->filters['srv_nombre'].'%');
        })
        ->when($this->filters['srv_periodo'],function($query){
            return $query->where('tm_matriculas.periodo_id',"{$this->filters['srv_periodo']}");
        })
        ->where('tm_matriculas.estado','A')
        ->limit(10)
        ->get();

       return $tbldata;

    }

    public function addCobro($personaId){

        $this->dispatchBrowserEvent('hide-form');
        return redirect()->to('/financial/encashment-add/'.$this->filters['srv_periodo'].'/'.$personaId);

    }

}
