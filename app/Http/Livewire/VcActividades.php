<?php

namespace App\Http\Livewire;
use App\Models\TmHorarios;

use Livewire\Component;
use Livewire\WithPagination;

class VcActividades extends Component
{
    use WithPagination;

    public $actividadId;

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
        
        $this->tblparalelo = TmHorarios::query()
        ->join("tm_servicios as s","s.id","=","tm_horarios.servicio_id")
        ->join("tm_cursos as c","c.id","=","tm_horarios.curso_id")
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as m","m.id","=","d.asignatura_id")
        ->where("d.docente_id",2913)
        ->selectRaw('d.id, concat(m.descripcion," - ",s.descripcion," ",c.paralelo) as descripcion')
        ->get();
        
    }
    
    
    public function render()
    {
        
        $tblrecords = TmHorarios::query()
        ->join("tm_servicios as s","s.id","=","tm_horarios.servicio_id")
        ->join("tm_cursos as c","c.id","=","tm_horarios.curso_id")
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as m","m.id","=","d.asignatura_id")
        ->join("tm_actividades as a","a.paralelo","=","d.id")
        ->when($this->filters['paralelo'],function($query){
            return $query->where('a.paralelo',"{$this->filters['paralelo']}");
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
        ->where("a.docente_id",2913)
        ->where("a.tipo","AC")
        ->selectRaw('m.descripcion as asignatura, s.descripcion as curso, c.paralelo as aula, a.*')
        ->paginate(12);
        
        return view('livewire.vc-actividades',[
            'tblrecords' => $tblrecords
        ]);

    }

    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }

    public function edit($Id)
    {
        return redirect()->to('/activities/activity-edit/'.$Id);
    }


}
