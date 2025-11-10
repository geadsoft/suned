<?php

namespace App\Http\Livewire;
use App\Models\TmPeriodosLectivos;
use App\Models\TmLibros;
use App\Models\TmAsignaturas;
use App\Models\TmGeneralidades;
use App\Models\TmCursos;
use App\Models\TdLibrosCursos;
use App\Models\TmCambiaModalidad;
use App\Models\TmPaseCursos;

use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Str;


class VcStudentLibrary extends Component
{
    public $showEditModal, $periodoId, $personaId, $fileimg='';
    public $record, $tblasignaturas, $tblmodalidad;

    public function mount()
    {
        $this->personaId = auth()->user()->personaId;

        $tblperiodos = TmPeriodosLectivos::where("aperturado",1)->first();
        $this->periodoId = $tblperiodos['id'];

        $matricula = TmCambiaModalidad::query()
        ->where('persona_id',$this->personaId)
        ->first();

        $this->cursoId = $matricula->curso_id;
        $this->modalidadId = $matricula->modalidad_id;

        //Si tiene pase de curso en otra modalidad
        $pasecurso = TmPaseCursos::query()
        ->where('matricula_id',$matricula->matricula_id)
        ->where('estado','A')
        ->first();

        if (!empty($pasecurso)){  
            $this->cursoId = $pasecurso->curso_id;
        }
        
    }


    public function render()
    {

        $curso = TmCursos::find($this->cursoId);

        $tblrecords = TmLibros::query()
        ->join('td_libros_cursos as c','c.libro_id','=','tm_libros.id')
        ->join('tm_servicios as s','s.id','=','c.curso_id')   
        ->where('periodo_id',$this->periodoId)
        ->where('c.curso_id',$curso->servicio_id)
        ->selectRaw('tm_libros.id, tm_libros.nombre, tm_libros.asignatura_id, tm_libros.drive_id, tm_libros.autor, tm_libros.portada')
        ->GroupByRaw('tm_libros.id, tm_libros.nombre, tm_libros.asignatura_id, tm_libros.drive_id, tm_libros.autor, tm_libros.portada')
        ->get(); 
        
        return view('livewire.vc-student-library',[
             'tblrecords' => $tblrecords,
        ]);
    }

}
