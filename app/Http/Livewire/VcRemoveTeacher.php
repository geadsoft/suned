<?php

namespace App\Http\Livewire;
use App\Models\TmPersonas;
use App\Models\TmHorarios;
use App\Models\TmPeriodosLectivos;
use App\Models\TmHorariosDocentes;
use App\Models\TmActividades;

use Livewire\Component;

class VcRemoveTeacher extends Component
{   
    public $personaId, $nombres, $newPersonaId=0, $persona;
    public $tblrecords=[];

    protected $listeners = ['setDocente'];

    public function mount($id)
    {
        $this->personaId = $id;

        $tblperiodos = TmPeriodosLectivos::where("aperturado",1)->first();
        $this->periodoId = $tblperiodos['id'];

        $persona = TmPersonas::find($this->personaId);
        $this->nombres = $persona->apellidos.' '.$persona->nombres;
        $this->loadData();
    }

    public function render()
    {
        return view('livewire.vc-remove-teacher');
    }

    public function loadData()
    {
        $data = TmHorarios::query()
        ->join("tm_horarios_docentes as h","h.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as a","a.id","=","h.asignatura_id")
        ->join("tm_servicios as s","s.id","=","tm_horarios.servicio_id")
        ->join("tm_generalidades as g","g.id","=","tm_horarios.grupo_id")
        ->where("tm_horarios.periodo_id",$this->periodoId)
        ->where("h.docente_id",$this->personaId)
        ->select("tm_horarios.id","h.asignatura_id","g.descripcion as modalidad","s.descripcion as curso", "a.descripcion as asignatura")
        ->orderByRaw("g.descripcion,s.descripcion,a.descripcion")
        ->get();

        $this->tblrecords=[];
        foreach ($data as $recno){
            $array=[
                'aplicar' => false,
                'horario_id' => $recno->id,
                'modalidad' => $recno->modalidad,
                'curso' => $recno->curso,
                'asignatura_id' => $recno->asignatura_id,
                'asignatura' => $recno->asignatura,
                'persona_id' => 0,
                'docente' => "",
            ];
            array_push($this->tblrecords,$array);
        }

    }

    public function updateData(){

        $contador = count(array_filter($this->tblrecords, function ($item) {
            return $item['persona_id'] === 0;
        }));
        
        if ($contador>0){

            $message = "Existen asignaturas sin asignar docente!";
            $this->dispatchBrowserEvent('msg-alert', ['newName' => $message]);

        }else{

            foreach ($this->tblrecords as $key => $recno){

                $horarioId = $this->tblrecords[$key]['horario_id'];
                $asignaturaId =  $this->tblrecords[$key]['asignatura_id'];

                $horarios = TmHorariosDocentes::query()
                ->where('horario_id',$horarioId)
                ->where('asignatura_id',$asignaturaId)
                ->get();
                
                TmHorariosDocentes::where('horario_id',$horarioId)
                ->where('asignatura_id',$asignaturaId)
                ->update([
                    'docente_id' => $recno['persona_id']
                ]);

                foreach ($horarios as $horario){

                    TmActividades::where('docente_id',$this->personaId)
                    ->where('paralelo',$horario->id)
                    ->update([
                        'docente_id' => $recno['persona_id']
                    ]);
                }

            }

            $persona = TmPersonas::find($this->personaId);
            $persona->update([
                'estado' => 'R',
            ]);

            $message = "Registros actualizados con éxito!";
            $this->dispatchBrowserEvent('msg-grabar', ['newName' => $message]);

            return redirect()->to('/headquarters/staff');

        }


    }

    public function aplicarTodos(){

        if ($this->newPersonaId==0){
            return;
        }

        foreach ($this->tblrecords as $key => $recno){

            $this->tblrecords[$key]['aplicar']=true;
            $this->tblrecords[$key]['persona_id']=$this->newPersonaId;
            $this->tblrecords[$key]['docente']=$this->persona;

        }

    }

    public function aplicar($key){

        if ($this->newPersonaId==0){
            $this->loadData();
            return;
        }

        $this->tblrecords[$key]['aplicar']=true;
        $this->tblrecords[$key]['persona_id']=$this->newPersonaId;
        $this->tblrecords[$key]['docente']=$this->persona;

    }

    public function delete($key){

        $this->tblrecords[$key]['aplicar']=false;
        $this->tblrecords[$key]['persona_id']=0;
        $this->tblrecords[$key]['docente']="";

    }

    public function buscar(){

        $this->dispatchBrowserEvent('search-personal');

    }

    public function setDocente($id){

        $this->newPersonaId = $id;
        $persona = TmPersonas::find($this->newPersonaId);
        $this->persona = $persona->apellidos.' '.$persona->nombres;

    } 


}
