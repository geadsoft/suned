<?php

namespace App\Http\Livewire;
use App\Models\TdAsistenciaDiarias;
use App\Models\TmPeriodosLectivos;
use App\Models\TmCambiaModalidad;
use App\Models\TdPeriodoSistemaEducativos;

use Livewire\Component;
use Livewire\WithPagination;

class VcShowAssistance extends Component
{
    use WithPagination;

    public $periodoId, $personaId, $cursoId, $faltas=10, $faltasJus=0, $atraso=0, $atrasoJus=0, $tabactive='';
    public $tbltermino=[];
    

    public function mount()
    {   
        $ldate = date('Y-m-d H:i:s');
        $this->fecha = date('Y-m-d',strtotime($ldate));

        $tblperiodos = TmPeriodosLectivos::where("aperturado",1)->first();
        $this->periodoId = $tblperiodos['id'];
        $this->personaId = auth()->user()->personaId;

         $matricula = TmCambiaModalidad::query()
        ->where('persona_id',$this->personaId)
        ->first();

        $this->cursoId = $matricula->curso_id;

        $this->tbltermino = TdPeriodoSistemaEducativos::query()
        ->where('periodo_id',$this->periodoId )
        ->where('tipo','EA')
        ->orderByRaw("cerrar,codigo")
        ->get();

        $this->tabactive = $this->tbltermino[0]['codigo']; 

    }
    
    public function render()
    {
        
        $tblrecords = TdAsistenciaDiarias::query()
        ->where("periodo_id",$this->periodoId)
        ->where("persona_id",$this->personaId)
        ->where("curso_id",$this->cursoId)
        ->when($this->tabactive,function($query){
            return $query->where('termino',"{$this->tabactive}");
        })
        ->whereRaw("fecha <= ".date("Ymd", strtotime($this->fecha))." and valor <> ''")
        ->orderBy("fecha","desc")
        ->paginate(12);

        $this->consulta();
        
        return view('livewire.vc-show-assistance',[
            'tblrecords' => $tblrecords,
        ]);
    }

    public function consulta(){

        $this->faltas = TdAsistenciaDiarias::query()
        ->where("periodo_id", $this->periodoId)
        ->where("persona_id", $this->personaId)
        ->where("curso_id", $this->cursoId)
        ->when($this->tabactive,function($query){
            return $query->where('termino',"{$this->tabactive}");
        })
        ->whereRaw("fecha <= ?", [date("Ymd", strtotime($this->fecha))])
        ->where("valor", "F")
        ->count();

        $this->faltasJus = TdAsistenciaDiarias::query()
        ->where("periodo_id", $this->periodoId)
        ->where("persona_id", $this->personaId)
        ->where("curso_id", $this->cursoId)
        ->when($this->tabactive,function($query){
            return $query->where('termino',"{$this->tabactive}");
        })
        ->whereRaw("fecha <= ?", [date("Ymd", strtotime($this->fecha))])
        ->where("valor", "FJ")
        ->count();

        $this->atraso = TdAsistenciaDiarias::query()
        ->where("periodo_id", $this->periodoId)
        ->where("persona_id", $this->personaId)
        ->where("curso_id", $this->cursoId)
        ->when($this->tabactive,function($query){
            return $query->where('termino',"{$this->tabactive}");
        })
        ->whereRaw("fecha <= ?", [date("Ymd", strtotime($this->fecha))])
        ->where("valor", "A")
        ->count();

        $this->atrasoJus = TdAsistenciaDiarias::query()
        ->where("periodo_id", $this->periodoId)
        ->where("persona_id", $this->personaId)
        ->where("curso_id", $this->cursoId)
        ->when($this->tabactive,function($query){
            return $query->where('termino',"{$this->tabactive}");
        })
        ->whereRaw("fecha <= ?", [date("Ymd", strtotime($this->fecha))])
        ->where("valor", "AJ")
        ->count();

        dd($this->faltas);

    }

    public function filtrar($codigo)
    {   
        if ($codigo=='A') {
            $this->tabactive = '';
        }else {
            $this->tabactive = $codigo;
        }
       
    }

    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }
}
