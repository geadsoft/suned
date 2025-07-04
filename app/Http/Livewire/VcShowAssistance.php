<?php

namespace App\Http\Livewire;
use App\Models\TdAsistenciaDiarias;
use App\Models\TmPeriodosLectivos;
use App\Models\TmCambiaModalidad;

use Livewire\Component;
use Livewire\WithPagination;

class VcShowAssistance extends Component
{
    use WithPagination;

    public $periodoId, $personaId, $cursoId, $faltas=10, $faltasJus=0, $atraso=0, $atrasoJus=0;
    

    public function mount()
    {
         $tblperiodos = TmPeriodosLectivos::where("aperturado",1)->first();
        $this->periodoId = $tblperiodos['id'];
        $this->personaId = auth()->user()->personaId;

         $matricula = TmCambiaModalidad::query()
        ->where('persona_id',$this->personaId)
        ->first();

        $this->cursoId = $matricula->curso_id;

        $ldate = date('Y-m-d H:i:s');
        $this->fecha = date('Y-m-d',strtotime($ldate));

    }
    
    public function render()
    {
        $this->faltas = TdAsistenciaDiarias::query()
        ->where("periodo_id", $this->periodoId)
        ->where("persona_id", $this->personaId)
        ->where("curso_id", $this->cursoId)
        ->whereRaw("fecha <= ?", [date("Ymd", strtotime($this->fecha))])
        ->where("valor", "F")
        ->count();

        $this->atraso = TdAsistenciaDiarias::query()
        ->where("periodo_id", $this->periodoId)
        ->where("persona_id", $this->personaId)
        ->where("curso_id", $this->cursoId)
        ->whereRaw("fecha <= ?", [date("Ymd", strtotime($this->fecha))])
        ->where("valor", "A")
        ->count();

        $tblrecords = TdAsistenciaDiarias::query()
        ->where("periodo_id",$this->periodoId)
        ->where("persona_id",$this->personaId)
        ->where("curso_id",$this->cursoId)
        ->whereRaw("fecha <= ".date("Ymd", strtotime($this->fecha))." and valor <> ''")
        ->orderBy("fecha","desc")
        ->paginate(12);
        
        return view('livewire.vc-show-assistance',[
            'tblrecords' => $tblrecords,
        ]);
    }

    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }
}
