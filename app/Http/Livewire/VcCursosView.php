<?php

namespace App\Http\Livewire;
use App\Models\TmHorarios;

use Livewire\Component;

class VcCursosView extends Component
{
    public $seccion, $asignatura, $curso, $search;
    public $estudiantes;
    
    public function mount($id){

        $this->loadCursos($id);

    }
    
    public function render()
    {
        return view('livewire.vc-cursos-view',[
            'tblrecords' => $this->estudiantes 
        ]);

    }


    public function loadCursos($id){

        $tblrecords = TmHorarios::query()
        ->join("tm_servicios as s","s.id","=","tm_horarios.servicio_id")
        ->join("tm_generalidades as g","g.id","=","s.nivel_id")
        ->join("tm_cursos as c","c.id","=","tm_horarios.curso_id")
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as a","a.id","=","d.asignatura_id")
        ->where("d.docente_id",2913)
        ->where("d.id",$id)
        ->selectRaw('d.id, g.descripcion as nivel, a.descripcion as asignatura,s.descripcion as curso ,c.paralelo')
        ->first();

        $this->seccion = $tblrecords['nivel'];
        $this->asignatura = $tblrecords['asignatura'];
        $this->curso = $tblrecords['curso'];

        $this->estudiantes = TmHorarios::query()
        ->join("tm_servicios as s","s.id","=","tm_horarios.servicio_id")
        ->join("tm_cursos as c","c.id","=","tm_horarios.curso_id")
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_matriculas as m","m.curso_id","=","c.id")
        ->join("tm_personas as p","p.id","=","m.estudiante_id")
        ->when($this->search,function($query){
            return $query->where(DB::raw('concat(ltrim(rtrim(apellidos))," ",ltrim(rtrim(nombres)))'), 'LIKE' , "%{$this->search}%");
        })
        ->where("d.docente_id",2913)
        ->where("d.id",$id)

        ->select('p.*')
        ->get();
        

    }




}
