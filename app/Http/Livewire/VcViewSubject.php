<?php

namespace App\Http\Livewire;
use App\Models\TmHorarios;
use App\Models\TmHorariosDocentes;
use App\Models\TmPeriodosLectivos;
use App\Models\TmMatricula;
use App\Models\TmActividades;

use Livewire\Component;

class VcViewSubject extends Component
{
    public $personaId, $horarioId, $docenteId, $paraleloId;
    public $clases=[], $actividad=[], $recursos=[], $datos=[];
    public $fecha, $asignatura = "";
    
    public function mount($data)
    {
        $this->personaId = auth()->user()->personaId;

        $datos = json_decode($data);
        $this->horarioId  = $datos->horarioId;
        $this->docenteId  = $datos->docenteId;
        $this->paraleloId = $datos->asignaturaId;

        $ldate = date('Y-m-d H:i:s');
        $this->fecha = date('Y-m-d',strtotime($ldate));
        $this->datos = $data;
        $this->load();
    }
    
    public function render()
    {
        return view('livewire.vc-view-subject',[
            'clases' =>  $this->clases,
            'actividad' =>  $this->actividad,
        ]);

    }

    public function load(){

        $materia = TmHorariosDocentes::query()
        ->join('tm_asignaturas as m','m.id','=','tm_horarios_docentes.asignatura_id')
        ->where('horario_id',$this->horarioId)
        ->where('tm_horarios_docentes.id',$this->paraleloId)
        ->where('docente_id',$this->docenteId)
        ->first();

        $this->asignatura = $materia->descripcion;

        $this->clases = TmActividades::query()
        ->where('docente_id',$this->docenteId) 
        ->where('paralelo',$this->paraleloId)
        ->where('tipo','CV')
        ->whereRaw("fecha >= '".$this->fecha."'")
        ->get();

        $this->actividad = TmActividades::query()
        ->leftJoin('td_actividades_entregas as e', function($join)
        {
            $join->on('e.actividad_id', '=', 'tm_actividades.id');
            $join->where('e.persona_id',$this->personaId);
        })
        ->selectRaw('tm_actividades.*, e.fecha as fechaEntrega, e.nota')
        ->where('docente_id',$this->docenteId) 
        ->where('paralelo',$this->paraleloId)
        ->where('tipo','AC')
        ->whereRaw("tm_actividades.fecha >= '".$this->fecha."'")
        ->get();

        $this->recursos= TmActividades::query()
        ->where('docente_id',$this->docenteId) 
        ->where('paralelo',$this->paraleloId)
        ->where('tipo','AC')
        ->whereRaw("enlace <> ''")
        ->whereRaw("fecha >= '".$this->fecha."'")
        ->get();

    }

}
