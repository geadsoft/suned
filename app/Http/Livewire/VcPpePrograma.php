<?php

namespace App\Http\Livewire;

use App\Models\TmPeriodosLectivos;
use App\Models\TmPpeActividades;
use App\Models\TdPeriodoSistemaEducativos;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class VcPpePrograma extends Component
{
    use WithPagination;
    public $fechaentrega, $horaentrega;
    public $tblactividad;

    public $periodoId;
    public $activity;
    public $arrtipo=[
        'F1' => 'FASE 1',
        'F2' => 'FASE 2',
        'F3' => 'FASE 3'
    ];

    public function mount()
    {
        $tblperiodos = TmPeriodosLectivos::where("aperturado",1)->first();
        $this->periodoId = $tblperiodos['id'];

        $this->tblactividad = TdPeriodoSistemaEducativos::query()
        ->where('periodo_id',$this->periodoId)
        ->where('tipo','AC')
        ->where('codigo','<>','EX')
        ->get();
    }

    public function render()
    {
        
        $sub = DB::table('tm_ppe_fases')
        ->select('periodo_id', 'persona_id', 'fase', 'enlace')
        ->where('periodo_id', $this->periodoId)
        ->where('enlace', '<>', '');

        $tblclases = DB::table('tm_ppe_fases as f')
        ->joinSub($sub, 'f2', function ($join) {
            $join->on('f2.periodo_id', '=', 'f.periodo_id')
                ->on('f2.persona_id', '=', 'f.persona_id')
                ->on('f2.fase', '=', 'f.fase');
        })
        ->join('tm_personas as p', 'p.id', '=', 'f.persona_id')
        ->where('f.periodo_id', 8)
        ->select('p.apellidos', 'p.nombres','f.fase', 'f.fecha', 'f2.enlace')
        ->paginate(10);

        $tblrecords = DB::table('tm_ppe_estudiantes as e')
        ->join('tm_ppe_actividades as a', function ($join) {
            $join->on('a.periodo_id', '=', 'e.periodo_id')
                ->on('a.modalidad_id', '=', 'e.modalidad_id')
                ->on('a.grado_id', '=', 'e.grado_id');
        })
        ->join('tm_personas as p', 'p.id', '=', 'a.docente_id')
        ->where('e.persona_id', 686)
        ->select('a.*','p.apellidos','p.nombres')
        ->paginate(10);

        return view('livewire.vc-ppe-programa',[
            "tblrecords" => $tblrecords,
            "tblclases" => $tblclases
        ]);
    }

    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }

    public function visualizar($id){
        
        $this->activity  = TmPpeActividades::find($id)->toArray();

        $this->fechaentrega = date('Y-m-d',strtotime($this->activity['fecha_entrega']));
        $this->horaentrega = date('H:i',strtotime($this->activity['fecha_entrega']));
        $this->dispatchBrowserEvent('show-form');

    }
}
