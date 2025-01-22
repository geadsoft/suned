<?php

namespace App\Http\Livewire;
use App\Models\TmHorarios;

use Livewire\Component;
use Livewire\WithPagination;

class VcCursosAsignados extends Component
{

    use WithPagination;

    public function render()
    {
        
        $tblrecords = TmHorarios::query()
        ->join("tm_servicios as s","s.id","=","tm_horarios.servicio_id")
        ->join("tm_generalidades as g","g.id","=","s.nivel_id")
        ->join("tm_cursos as c","c.id","=","tm_horarios.curso_id")
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as a","a.id","=","d.asignatura_id")
        ->where("d.docente_id",2913)
        ->selectRaw('d.id, g.descripcion as nivel, a.descripcion as asignatura,s.descripcion as curso ,c.paralelo')
        ->paginate(12);
        
        return view('livewire.vc-cursos-asignados',[
            'tblrecords' => $tblrecords
        ]);

    }

    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }

}
