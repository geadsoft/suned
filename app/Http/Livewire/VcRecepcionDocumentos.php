<?php

namespace App\Http\Livewire;
use App\Models\TmPeriodosLectivos;
use App\Models\TmExpedienteMatricula;
use App\Models\TmGeneralidades;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class VcRecepcionDocumentos extends Component
{
    
    use WithPagination;

    public $documento;

    public $filters=[
        'periodoId' => 0,
        'nombre' => 0,
    ];

    public function mount(){
        
        $periodos = TmPeriodosLectivos::where("aperturado",1)->first();
        $this->filters['periodoId'] = $periodos['id'];

    }

    public function render()
    {
       
        $tblperiodos = TmPeriodosLectivos::orderBy("periodo",'desc')->get();
        $modalidades = TmGeneralidades::where('superior',1)->get();

       $tblrecords = TmExpedienteMatricula::query()
        ->join('tm_matriculas as m', 'm.id', '=', 'tm_expediente_matriculas.matricula_id')
        ->join('tm_cursos as c', 'c.id', '=', 'm.curso_id')
        ->join('tm_servicios as s', 's.id', '=', 'c.servicio_id')
        ->join('tm_personas as p', 'p.id', '=', 'm.estudiante_id')
        ->select(
            'tm_expediente_matriculas.*',
            'm.documento',
            'm.fecha',
            DB::raw("CONCAT(p.apellidos, ' ', p.nombres) AS estudiante"),
            DB::raw("CONCAT(s.descripcion, ' - ', c.paralelo) AS curso")
        )
        ->where('m.periodo_id', $this->filters['periodoId'])
        ->withCount('detalles')
        ->paginate(12);

    
        return view('livewire.vc-recepcion-documentos',[
            'tblperiodos' => $tblperiodos,
            'tblrecords' => $tblrecords,
            'modalidades' => $modalidades,
        ]);
    }

    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }


}
