<?php

namespace App\Http\Livewire;
use App\Models\TmAsignaturas;
use App\Models\TmHorarios;
use App\Models\TmHorariosAsignaturas;
use App\Models\TmHorariosDocentes;
use App\Models\TdPeriodoSistemaEducativos;
use App\Models\TmActividades;

use Livewire\Component;

class VcHorariosClase extends Component
{
    public $objdetalle, $filas, $horarioId, $detalle=[], $edit=false;
    public $horarios, $horas=[], $modalidadId;
    
    public function mount($horarioId){

        $this->tblmaterias  = TmAsignaturas::orderBy('descripcion','asc')->get();
        $this->filas = 5;
        $this->newdetalle();

        if ($horarioId>0){
            $this->setHorario($horarioId);
        }
        
    }

    protected $listeners = ['setHorario'];

    public function render()
    {
        return view('livewire.vc-horarios-clase');
    }
    
    public function setHorario($horarioId){

        $this->horarioId = $horarioId;
        $this->horarios = TmHorariosAsignaturas::where('horario_id',$this->horarioId)
        ->get()->toArray();

        $horario = TmHorarios::find($horarioId);
        $this->modalidadId = $horario->grupo_id;

        $this->horas = TdPeriodoSistemaEducativos::query()
        ->where('periodo_id',$horario->periodo_id)
        ->where('modalidad_id',$horario->grupo_id)
        ->where('tipo',"HC")
        ->get();

        if (!empty($this->horarios)){

            $this->edit = true;
            foreach ($this->horarios as $data){
                $this->objdetalle[$data['linea']][$data['dia']] = $data['asignatura_id']; 
                $this->objdetalle[$data['linea']][7] = $data['hora_id']; 
            } 

        }
        
    }

    public function newdetalle(){

        $this->objdetalle = [];

        for ($i = 1; $i <= $this->filas; $i++) {
            $horario = [];
            for ($col = 1; $col <= 7; $col++) {
                $horario[$col] = "";
            }
            array_push($this->objdetalle, $horario);
        } 
    }

    public function createData(){

        if ($this->edit){

            $this->editData();
            return;

        }
        
        $this ->validate([
            'horarioId' => 'required',
        ]);

        /*Asignaturas*/
        foreach ($this->objdetalle as $key => $asignatura){
            $objdata = [];
            for ($col = 1; $col <= 6; $col++) {
                
                $objdata['horario_id'] = $this->horarioId;
                $objdata['linea'] = $key;
                $objdata['dia'] = $col;
                if ($asignatura[$col] == ''){
                    $objdata['asignatura_id'] = null;
                }else {
                    $objdata['asignatura_id'] = $asignatura[$col];
                }
                
                if ($asignatura[7] == ''){
                    $objdata['hora_id'] = null;
                }else {
                    $objdata['hora_id'] = $asignatura[7];
                }
                
                $objdata['usuario'] = auth()->user()->name;
                array_push($this->detalle, $objdata);
            }
            
        }

        TmHorariosAsignaturas::insert($this->detalle); 
        
        /*Docente por Asignatura*/
        $tbldata = TmHorariosAsignaturas::where('horario_id',$this->horarioId)
        ->where('asignatura_id','<>','null')
        ->select('asignatura_id')
        ->groupBy('asignatura_id')
        ->get()->toArray();

        $objdocente=[];
        foreach ($tbldata as $recno){

            TmHorariosDocentes::Create([
                'horario_id' => $this->horarioId,
                'asignatura_id' => $recno['asignatura_id'],
                'docente_id' => null,
                'usuario' => auth()->user()->name,
            ]);

        }

        $message = "Asignaturas grabadas con éxito!"."\n".'Asigne docente para cada asignatura.';
        $this->dispatchBrowserEvent('msg-grabar-asignatura', ['newName' => $message]);

        $this->emitTo('vc-horarios-docentes','setHorario',$this->horarioId);
        $this->setHorario($this->horarioId);
    }

    public function editData(){

        TmHorariosAsignaturas::where('horario_id', $this->horarioId)->delete();

        /*Asignaturas*/
        foreach ($this->objdetalle as $key => $asignatura){
            $objdata = [];
            for ($col = 1; $col <= 6; $col++) {
                
                $objdata['horario_id'] = $this->horarioId;
                $objdata['linea'] = $key;
                $objdata['dia'] = $col;
                if ($asignatura[$col] == ''){
                    $objdata['asignatura_id'] = null;
                }else {
                    $objdata['asignatura_id'] = $asignatura[$col];
                }
                
                if ($asignatura[7] == ''){
                    $objdata['hora_id'] = null;
                }else {
                    $objdata['hora_id'] = $asignatura[7];
                }
                
                $objdata['usuario'] = auth()->user()->name;
                array_push($this->detalle, $objdata);
            }
            
        }

        TmHorariosAsignaturas::insert($this->detalle);

        /*foreach($this->horarios as $key => $recno){

            $record = TmHorariosAsignaturas::find($recno['id']);


            if($this->objdetalle[$recno['linea']][$recno['dia']]==""){
                $record->update([
                    'asignatura_id' => null,
                ]);  
            }else{

                 $record->update([
                    'asignatura_id' => $this->objdetalle[$recno['linea']][$recno['dia']],
                ]);
            }

            if($this->objdetalle[$recno['linea']][7]==""){
                $record->update([
                    'hora_id' => null,
                ]);  
            }else{
                 $record->update([
                    'hora_id' => $this->objdetalle[$recno['linea']][7],
                ]);
            }

        }*/

        /*Docente por Asignatura*/
        $tbldata = TmHorariosAsignaturas::query()
        ->leftJoin('tm_horarios_docentes as d', function ($join) {
            $join->on('d.asignatura_id', '=', 'tm_horarios_asignaturas.asignatura_id')
                ->where('d.horario_id', $this->horarioId); // Filtro en el LEFT JOIN
        })
        ->where('tm_horarios_asignaturas.horario_id',$this->horarioId)
        ->where('tm_horarios_asignaturas.asignatura_id','<>','null')
        ->select('tm_horarios_asignaturas.asignatura_id',"d.docente_id")
        ->groupBy('tm_horarios_asignaturas.asignatura_id','d.docente_id')
        ->get()->toArray();
     
        //TmHorariosDocentes::where('horario_id', $this->horarioId)->delete();

        $objdocente=[];
        foreach ($tbldata as $recno){

            $record = TmHorariosDocentes::where('horario_id',$this->horarioId)
            ->where('asignatura_id',$recno['asignatura_id'])
            ->get()->toArray();

            if (empty($record)){
                
                TmHorariosDocentes::Create([
                    'horario_id' => $this->horarioId,
                    'asignatura_id' => $recno['asignatura_id'],
                    'docente_id' => $recno['docente_id'],
                    'usuario' => auth()->user()->name,
                ]);

            }

        }

        //Asignatura no asignadas en Horario Clase
        $temp = TmHorariosDocentes::query()
        ->leftJoin('tm_horarios_asignaturas as d', function ($join) {
            $join->on('d.asignatura_id', '=', 'tm_horarios_docentes.asignatura_id')
                 ->on('d.horario_id','=','tm_horarios_docentes.horario_id');
        })
        ->where("tm_horarios_docentes.horario_id",$this->horarioId)
        ->whereRaw("d.asignatura_id is null")
        ->select("tm_horarios_docentes.*")
        ->get();

        foreach ($temp as $recno){

            $actividades = TmActividades::query()
            ->where("paralelo",$recno->id)
            ->where("docente_id",$recno->docente_id)
            ->get();

            if ($actividades->isEmpty()){
                TmHorariosDocentes::find($recno->id)->delete();
            }
        }

        $message = "Asignaturas actualizadas con éxito!"."\n".'Asigne docente para cada asignatura.';
        $this->dispatchBrowserEvent('msg-grabar-asignatura', ['newName' => $message]);

        $this->emitTo('vc-horarios-docentes','setHorario',$this->horarioId);

    }


}
