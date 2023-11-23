<?php

namespace App\Http\Livewire;
use App\Models\TmPeriodosLectivos;
use App\Models\TmGeneralidades;
use App\Models\TmServicios;
use App\Models\TmCursos;
use App\Models\TmHorarios;
use App\Models\TmHorariosDocentes;

use Livewire\Component;
use Livewire\WithPagination;

class VcHorarios extends Component
{

    use WithPagination;
    public $tblgenerals=null, $datos;
    public $tblperiodos=null;
    public $tblcursos=null;
    public $tblservicios=null;
    public $tbldatogen=null;

    public function mount(){

        $this->tblgenerals = TmGeneralidades::whereRaw('superior in (1,2,3)')->get();
        $this->tblperiodos = TmPeriodosLectivos::orderBy("periodo","desc")->get();
    
    }
    
    
    public function render()
    {
        $tblrecords = TmHorarios::paginate(10);
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

    public function edit(TmHorarios $tblrecords ){
        
        $this->record  = $tblrecords->toArray();
       
        $this->selectId = $this -> record['id'];
        return redirect()->to('/headquarters/schedules-edit/'.$this->selectId);

    }

}
