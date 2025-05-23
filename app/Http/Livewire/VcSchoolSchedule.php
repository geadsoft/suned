<?php

namespace App\Http\Livewire;
use App\Models\TmHorarios;
use App\Models\TmHorariosDocentes;
use App\Models\TmPeriodosLectivos;
use App\Models\TmMatricula;
use App\Models\TmActividades;
use App\Models\TmCambiaModalidad;

use Livewire\Component;

class VcSchoolSchedule extends Component
{
    public $objdetalle=[];
    
    public function mount()
    {
        $ldate = date('Y-m-d H:i:s');
        $this->fecha = date('Y-m-d',strtotime($ldate));
        $this->personaId = auth()->user()->personaId;

        $tblperiodos = TmPeriodosLectivos::where("aperturado",1)->first();
        $this->periodoId = $tblperiodos['id'];

        $matricula = TmCambiaModalidad::query()
        ->where('persona_id',$this->personaId)
        ->first();

        $this->cursoId = $matricula->curso_id;

        $this->loadAsignaturas();

    }
    
    public function render()
    {
        return view('livewire.vc-school-schedule');
    }

    public function loadAsignaturas()
    {

        $this->tblrecords = [];

        $materias = TmHorarios::query()
        ->join("tm_horarios_asignaturas as a","a.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as m","m.id","=","a.asignatura_id")
        ->where("tm_horarios.curso_id",$this->cursoId)
        ->where("tm_horarios.periodo_id",$this->periodoId)
        ->selectRaw("tm_horarios.id, a.dia, a.linea, a.asignatura_id, m.descripcion as asignatura")
        ->orderByRaw('a.dia, a.linea')
        ->get();

        $detalle = $materias->groupby('dia');

        foreach ($detalle as $dia => $recno){

            foreach ($recno as $linea => $data){

                $persona = TmHorariosDocentes::query()
                ->join('tm_personas as p','p.id','=','tm_horarios_docentes.docente_id')
                ->where('horario_id',$data->id)
                ->where('asignatura_id',$data->asignatura_id)
                ->select('tm_horarios_docentes.id','p.apellidos','p.nombres')
                ->first();

                $actividades = TmActividades::query()
                ->where('docente_id',$this->personaId)
                ->where('id',$persona->id)
                ->where('estado','A')
                ->get()
                ->toArray();

                $this->objdetalle[$linea][$dia] = [
                    'asignatura' => $data->asignatura,
                    'docente' => $persona->apellidos.' '.$persona->nombres,
                    'actividades' => $actividades,
                    'recursos' => 0,
                    'clase' => false ,
                ]; 

            }

        }

        /*foreach ($materias as $data){
            $this->objdetalle[$data['linea']][$data['dia']] = [
                'asignatura' => '',
                'docente' => '',
                'actividad' => 0,
                'recursos' => 0,
                'clase' => false ,
            ]; 
        }*/ 

        //dd($this->objdetalle);
      
     
        /*foreach($materias as $recno){

            $asignatura = TmHorariosDocentes::query()
            ->where('horario_id',$recno->id)
            ->where('asignatura_id',$recno->asignatura_id)
            ->where('docente_id',$recno->docente_id)
            ->first();

            $clases = TmActividades::query()
            ->where('docente_id',$recno->docente_id) 
            ->where('paralelo',$asignatura->id)
            ->where('tipo','CV')
            ->where('fecha',$this->fecha)
            ->get();

            $actividad = TmActividades::query()
            ->where('docente_id',$recno->docente_id) 
            ->where('paralelo',$asignatura->id)
            ->where('tipo','CV')
            ->where('fecha',$this->fecha)
            ->get();

            $array['id'] = $recno->id;
            $array['asignatura_id'] = $recno->asignatura_id;
            $array['docente_id'] = $recno->docente_id;
            $array['asignatura'] = $recno->asignatura;
            $array['docente'] = $recno->docente;
            $array['actividad'] = count($actividad);
            $array['clases'] = count($clases);
            $array['data'] = json_encode([
                'horarioId' => $recno->id,
                'docenteId' => $recno->docente_id,
                'asignaturaId' => $asignatura->id, 
            ]);
            array_push($this->tblrecords,$array);


        }*/


    }
}
