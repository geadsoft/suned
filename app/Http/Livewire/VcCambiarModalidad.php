<?php

namespace App\Http\Livewire;
use App\Models\TmMatricula;
use App\Models\TmPeriodosLectivos;
use App\Models\TmCambiaModalidad;
use App\Models\TmPersonas;
use App\Models\TmPaseCursos;
use App\Models\TmCursos;

use Livewire\Component;

class VcCambiarModalidad extends Component
{
    public $personaId, $periodoId, $cursoId, $datos=null, $matricula;
    public $personas;

    public function mount()
    {
        $tblperiodos = TmPeriodosLectivos::where("aperturado",1)->first();

        $this->periodoId = $tblperiodos['id']; 
        $this->personaId = auth()->user()->personaId;
        
        if ($this->personaId>0){

            $this->personas  = TmPersonas::find($this->personaId);
        
            $record = TmCambiaModalidad::where('persona_id',$this->personaId)->first();

            if(empty($record) && $this->personas->tipopersona=='E'){
                auth()->user()->createData($this->personaId);
            }

            $this->loadPersonaId();

        } else {

            $this->loadPersona();

        }
        
    }

    public function render()
    {
        
        return view('livewire.vc-cambiar-modalidad',[
            'matricula' => $this->matricula,
            'datos' => $this->datos,
        ]);

    }

    public function loadPersonaId(){

        $this->matricula = []; 

        if ($this->personas->tipopersona=='E'){

            $datos = TmCambiaModalidad::query()
            ->join('tm_generalidades as d','d.id','=','tm_cambia_modalidad.modalidad_id')
            ->join('tm_servicios as s','s.id','=','tm_cambia_modalidad.grado_id')
            ->selectRaw('d.descripcion as nommodalidad, s.descripcion as nomservicio, curso_id, matricula_id')
            ->where('persona_id',$this->personaId)
            ->first();

            $this->matricula = TmMatricula::query()
            ->join('tm_generalidades as g','g.id','=','tm_matriculas.modalidad_id')
            ->where('periodo_id',$this->periodoId)
            ->where('estudiante_id',$this->personaId)
            ->where('curso_id','<>',$datos->curso_id)
            ->select('g.id','g.descripcion','tm_matriculas.id')
            ->get();

            $nommodalidad = "";
            $nomservicio = "";
            if(!empty($datos)){

                $curso = TmCursos::find($datos->curso_id);

                $nommodalidad = $datos->nommodalidad;
                $nomservicio  = $datos->nomservicio.' - '.$curso->paralelo;
            }

            //Si tiene pase de curso en otra modalidad
            $pasecurso = TmPaseCursos::query()
            ->join('tm_servicios as s','s.id','=','tm_pase_cursos.grado_id')
            ->join('tm_generalidades as g','g.id','=','s.modalidad_id')
            ->selectRaw('g.descripcion as nommodalidad, s.descripcion as nomservicio, tm_pase_cursos.curso_id')
            ->where('tm_pase_cursos.matricula_id',$datos->matricula_id)
            ->where('tm_pase_cursos.estado','A')
            ->first();

            if ($pasecurso){

                $curso = TmCursos::find($pasecurso->curso_id);

                $nommodalidad = $pasecurso->nommodalidad;
                $nomservicio  = $pasecurso->nomservicio.' - '.$curso->paralelo;
            }

            $this->datos = [
                'tipo' => 'E',
                'rol' => auth()->user()->roles->pluck('name')->implode(', '),
                'modalidad' => $nommodalidad,
                'curso' => $nomservicio,
            ];

        }else{
                $this->datos = [
                'tipo' => '',
                'rol' => auth()->user()->roles->pluck('name')->implode(', '),
                'modalidad' => '',
                'curso' => '',
            ];
        }

    }

    public function loadPersona(){

        $this->matricula = [];
        $this->datos = null;
    }

    public function cambiar($id)
    {

        $matricula = TmMatricula::query()
        ->join('tm_generalidades as d','d.id','=','tm_matriculas.modalidad_id')
        ->join('tm_servicios as s','s.id','=','tm_matriculas.grado_id')
        ->selectRaw('tm_matriculas.id, d.descripcion as nommodalidad, s.descripcion as nomservicio,tm_matriculas.modalidad_id,tm_matriculas.grado_id,tm_matriculas.curso_id')
        ->where('tm_matriculas.id',$id)
        ->first();

        TmCambiaModalidad::where('persona_id', '=', $this->personaId)->update([
            'matricula_id' => $matricula->id,
            'modalidad_id' => $matricula->modalidad_id,
            'grado_id' => $matricula->grado_id,
            'curso_id' => $matricula->curso_id,
            'modalidad' => $matricula->nommodalidad,
            'curso' => $matricula->nomservicio,
        ]);
        
        $this->datos = [
            'tipo' => 'E',
            'rol' => auth()->user()->roles->pluck('name')->implode(', '),
            'modalidad' => $matricula->nommodalidad,
            'curso' => $matricula->nomservicio,
        ];


        return redirect(request()->header('Referer'));

    }


}
