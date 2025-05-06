<?php

namespace App\Http\Livewire;
use App\Models\TmAsignaturas;
use App\Models\TmHorariosAsignaturas;
use App\Models\TmHorariosDocentes;

use Livewire\Component;

class VcHorariosClase extends Component
{
    public $objdetalle, $filas, $horarioId, $detalle=[], $edit=false;
    public $horarios;
    
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

        if (!empty($this->horarios)){

            $this->edit = true;
            foreach ($this->horarios as $data){
                $this->objdetalle[$data['linea']][$data['dia']] = $data['asignatura_id']; 
            } 

        }
        
    }

    public function newdetalle(){

        $this->objdetalle = [];

        for ($i = 1; $i <= $this->filas; $i++) {
            $horario = [];
            for ($col = 1; $col <= 5; $col++) {
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
            for ($col = 1; $col <= 5; $col++) {
                
                $objdata['horario_id'] = $this->horarioId;
                $objdata['linea'] = $key;
                $objdata['dia'] = $col;
                if ($asignatura[$col] == ''){
                    $objdata['asignatura_id'] = null;
                }else {
                    $objdata['asignatura_id'] = $asignatura[$col];
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

        $this->emitTo('vc-horarios-docentes','setHorario',$this->horarioId);
        
    }

    public function editData(){

        dd($this->horarios);

        foreach($this->horarios as $key => $recno){

            foreach ($this->objdetalle as $linea => $asignatura){
                if ($linea==$recno['linea']){
                    
                    $record = TmHorariosAsignaturas::find($recno['id']);
                    $record->update([
                        'asignatura_id' => $asignatura[$recno['dia']],
                    ]);
                    
                }
            }

        }

        /*Docente por Asignatura*/
        $tbldata = TmHorariosAsignaturas::where('horario_id',$this->horarioId)
        ->where('asignatura_id','<>','null')
        ->select('asignatura_id')
        ->groupBy('asignatura_id')
        ->get()->toArray();

        $objdocente=[];
        foreach ($tbldata as $recno){

            $record = TmHorariosDocentes::where('horario_id',$this->horarioId)
            ->where('asignatura_id',$recno['asignatura_id'])
            ->get()->toArray();

            if (empty($record)){
                
                TmHorariosDocentes::Create([
                    'horario_id' => $this->horarioId,
                    'asignatura_id' => $recno['asignatura_id'],
                    'docente_id' => null,
                    'usuario' => auth()->user()->name,
                ]);

            }

        }

        $this->emitTo('vc-horarios-docentes','setHorario',$this->horarioId);

    }


}
