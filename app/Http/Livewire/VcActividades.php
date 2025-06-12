<?php

namespace App\Http\Livewire;
use App\Models\TmHorarios;
use App\Models\TmPeriodosLectivos;
use App\Models\TmActividades;
use App\Models\TdActividadesEntregas;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class VcActividades extends Component
{
    use WithPagination;

    public $selectId, $actividadId, $docenteId, $pendientes;
    public $tblasignaturas=[], $paralelos=[];
    public $tab1="active", $tab2, $tab3, $tab4;

    public $arrtermino=[
        '1T' => 'Primer Trimestre',
        '2T' => 'Segundo Trimestre',
        '3T' => 'Tercer Trimestre',
    ];

    public $arrbloque=[
        '1P' => 'Primer Parcial',
        '2P' => 'Segundo Parcial',
        '3P' => 'Tercer Parcial',
    ];

    public $arractividad=[
        'AI' => 'Actividad Individual',
        'AG' => 'Actividad Grupal',
    ];
    
    public $filters=[
        'modalidadId' => '',
        'asignaturaId' => '',
        'paralelo' => '',
        'tipo' => '',
        'termino' => '',
        'bloque' => '',
    ];

    public $arrestado=[
        'A' => 'Activo',
        'I' => 'Inactivo',
        'C' => 'Cerrado',
    ];

    public function mount(){

        $ldate = date('Y-m-d H:i:s');
        $fecha = date('Y-m-d',strtotime($ldate));

        $this->docenteId = auth()->user()->personaId;

        $tblperiodos = TmPeriodosLectivos::where("aperturado",1)->first();
        $this->periodoId = $tblperiodos['id'];

        $modalidad = TmHorarios::query()
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_generalidades as g","g.id","=","tm_horarios.grupo_id")
        ->select("g.id","g.descripcion")
        ->groupBy("g.id","g.descripcion")
        ->where("d.docente_id",$this->docenteId)
        ->where("tm_horarios.periodo_id",$this->periodoId)
        ->get();

        $this->filters['modalidadId']=$modalidad[0]['id'];

    }
    
    
    public function render()
    {
        
        $tblmodalidad = TmHorarios::query()
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_generalidades as g","g.id","=","tm_horarios.grupo_id")
        ->select("g.id","g.descripcion")
        ->groupBy("g.id","g.descripcion")
        ->where("d.docente_id",$this->docenteId)
        ->where("tm_horarios.periodo_id",$this->periodoId)
        ->get();

        $this->tblparalelo = TmHorarios::query()
        ->join("tm_servicios as s","s.id","=","tm_horarios.servicio_id")
        ->join("tm_cursos as c","c.id","=","tm_horarios.curso_id")
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->where("d.docente_id",$this->docenteId)
        ->where("tm_horarios.periodo_id",$this->periodoId)
        ->selectRaw('s.id, concat(s.descripcion," ",c.paralelo) as descripcion')
        ->groupBy("s.id","s.descripcion","c.paralelo")
        ->orderByRaw("s.modalidad_id, s.nivel_id, s.grado_id")
        ->get(); 

        $this->tblasignaturas = TmHorarios::query()
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_generalidades as g","g.id","=","tm_horarios.grupo_id")
        ->join("tm_asignaturas as m","m.id","=","d.asignatura_id")
        ->select("m.id","m.descripcion")
        ->groupBy("m.id","m.descripcion")
        ->where("d.docente_id",$this->docenteId)
        ->where("tm_horarios.periodo_id",$this->periodoId)
        ->get();
      
        $tblrecords = TmHorarios::query()
        ->join("tm_servicios as s","s.id","=","tm_horarios.servicio_id")
        ->join("tm_cursos as c","c.id","=","tm_horarios.curso_id")
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as m","m.id","=","d.asignatura_id")
        ->join("tm_actividades as a","a.paralelo","=","d.id")
        ->when($this->filters['paralelo'],function($query){
            return $query->where('s.id',"{$this->filters['paralelo']}");
        })
        ->when($this->filters['tipo'],function($query){
            return $query->where('actividad',"{$this->filters['tipo']}");
        })
        ->when($this->filters['termino'],function($query){
            return $query->where('termino',"{$this->filters['termino']}");
        })
        ->when($this->filters['bloque'],function($query){
            return $query->where('bloque',"{$this->filters['bloque']}");
        })
        ->when($this->filters['asignaturaId'],function($query){
            return $query->where('m.id',"{$this->filters['asignaturaId']}");
        })
        ->where("a.docente_id",$this->docenteId)
        ->where("a.tipo","AC")
        ->selectRaw('m.descripcion as asignatura, s.descripcion as curso, c.paralelo as aula, a.*')
        ->orderby("a.fecha","desc")
        ->paginate(10);

        return view('livewire.vc-actividades',[
            'tblrecords' => $tblrecords,
            'tblmodalidad' => $tblmodalidad,
            'tblparalelo' => $this->paralelos,
        ]);

    }

    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }

    public function edit($Id)
    {
        return redirect()->to('/activities/activity-edit/'.$Id);
    }

    public function delete( $id ){
         
        $this->selectId = $id;

        $entregas = TdActividadesEntregas::query()
        ->join("tm_actividades as a","a.id","=","td_actividades_entregas.actividad_id")
        ->where("td_actividades_entregas.actividad_id",$this->selectId)
        ->get();

        if($entregas->isEmpty()){
            $this->dispatchBrowserEvent('show-delete');
        }else{
            $this->dispatchBrowserEvent('msg-alert'); 
        }

    }

    public function deleteData(){

        TmActividades::find($this->selectId)->delete();
        $this->dispatchBrowserEvent('hide-delete');

    }

    public function filtrar($data){

        $this->tab1=""; 
        $this->tab2="";
        $this->tab3="";
        $this->tab4="";

        switch ($data) {
        case "AI":
            $this->tab2 = "active";
            break;
        case "AG":
            $this->tab3 = "active";
            break;
        default:
            $this->tab1 = "active";
        }

        $this->filters['tipo'] = $data;

    }

}
