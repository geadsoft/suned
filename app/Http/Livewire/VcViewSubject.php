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
    public $horarioId, $docenteId, $paraleloId;
    public $clases=[], $actividad=[];
    public $fecha, $asignatura = "";
    
    public function mount($data)
    {
            
        $datos = json_decode($data);
        $this->horarioId = $datos->horarioId;
        $this->docenteId = $datos->docenteId;
        $this->paraleloId = $datos->asignaturaId;

        $ldate = date('Y-m-d H:i:s');
        $this->fecha = date('Y-m-d',strtotime($ldate));
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
        ->where('docente_id',$this->docenteId) 
        ->where('paralelo',$this->paraleloId)
        ->where('tipo','AC')
        ->whereRaw("fecha >= '".$this->fecha."'")
        ->get();

    }

}
