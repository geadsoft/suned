<?php

namespace App\Http\Livewire;

use App\Models\TmHorarios;
use App\Models\TmActividades;
use App\Models\TdPeriodoSistemaEducativos;
use App\Models\TmPeriodosLectivos;

use Livewire\Component;

class VcExamenAdd extends Component
{
    
    public $asignaturaId=0, $actividadId=0, $paralelo, $termino="1T", $bloque="3E", $tipo="EX", $nombre, $fecha, $hora;
    public $archivo='SI', $puntaje=10, $enlace="", $control="enabled";
    public $tblparalelo=[], $tblasignatura=[];
    public $periodoId, $tbltermino, $tblbloque=[];
    public $array_attach=[];
    public $docenteId;

    public function mount($id)
    {   
        $ldate = date('Y-m-d H:i:s');
        $this->fecha = date('Y-m-d',strtotime($ldate));
        $this->hora = date('H:i');

        $this->docenteId = auth()->user()->personaId;

        $tblperiodos = TmPeriodosLectivos::where("aperturado",1)->first();
        $this->periodoId = $tblperiodos['id'];

        $this->tbltermino = TdPeriodoSistemaEducativos::query()
        ->where('periodo_id',$this->periodoId)
        ->where('tipo','EA')
        ->get();

        $this->attach_add();

        if ($id>0){
            $this->edit($id);
        }

    }
    
    public function render()
    {
        $this->tblbloque=[];
        foreach($this->tbltermino as $data){
            if ($this->termino == $data['codigo']){
                $arrbloque['codigo'] = str_replace('T','E',$data['codigo']);
                $arrbloque['descripcion'] = 'Examen '.$data['descripcion'];

                array_push($this->tblbloque,$arrbloque);
            }
        }

        $this->updatedasignaturaId($this->asignaturaId);
        
        $this->tblasignatura = TmHorarios::query()
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as m","m.id","=","d.asignatura_id")
        ->where("d.docente_id",$this->docenteId)
        ->selectRaw('m.id, m.descripcion')
        ->groupBy('m.id','m.descripcion')
        ->get();

        return view('livewire.vc-examen-add',[
            'tblasignatura' => $this->tblasignatura,
        ]);

    }


    public function edit($id){
        
        $record = TmActividades::query()
        ->join("tm_horarios_docentes as d","d.id","=","tm_actividades.paralelo")
        ->select("tm_actividades.*","d.horario_id","d.asignatura_id")
        ->where("tm_actividades.id",$id)
        ->first()
        ->toArray();

        $this->asignaturaId = $record['asignatura_id'];
        $this->updatedasignaturaId($this->asignaturaId);

        $this->actividadId = $id;
        $this->paralelo = $record['paralelo'];
        $this->termino = $record['termino'];
        $this->bloque = $record['bloque'];
        $this->tipo = $record['actividad'];
        $this->nombre = $record['nombre'];
        $this->puntaje = $record['puntaje'];
        $this->enlace = $record['enlace'];
        $this->descripcion = $record['descripcion'];
        $this->estado = $record['estado'];

        $this->control="disabled";

        $this->fecha = date('Y-m-d',strtotime($record['fecha']));
        $this->hora = date('H:i',strtotime($record['fecha']));

        $this->descripcion=".";

    }

    public function updatedasignaturaId($id){

        $this->asignaturaId = $id;

        $this->tblparalelo = TmHorarios::query()
        ->join("tm_servicios as s","s.id","=","tm_horarios.servicio_id")
        ->join("tm_cursos as c","c.id","=","tm_horarios.curso_id")
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as m","m.id","=","d.asignatura_id")
        ->where("d.docente_id",$this->docenteId)
        ->where("m.id",$id)
        ->selectRaw('d.id, concat(s.descripcion," ",c.paralelo) as descripcion')
        ->get();

        $message = "";
        $this->dispatchBrowserEvent('chk-editor', ['newName' => $message]);
    }


    public function createData(){

        $this ->validate([
            'paralelo' => 'required',
            'termino' => 'required',
            'nombre' => 'required',
            'fecha' => 'required',
            'puntaje' => 'required',
            'nombre' => 'required',
        ]);

        if ($this->actividadId>0){

            $this->updateData();            

        }else {
            
            TmActividades::Create([
                'docente_id' => 2913,
                'paralelo' => $this->paralelo,
                'termino' => $this->termino,
                'bloque' => $this->bloque,
                'tipo' => 'ET',
                'actividad' => $this->tipo,
                'nombre' => $this->nombre,
                'descripcion' => "",
                'fecha' => $this->fecha.' '.$this->hora,
                'subir_archivo' => $this->archivo,
                'puntaje' => $this->puntaje,
                'enlace' => $this->enlace,
                'estado' => "A",
                'usuario' => auth()->user()->name,
            ]);

            $message = "Registro grabado con éxito!";
            $this->dispatchBrowserEvent('msg-grabar', ['newName' => $message]);

            return redirect()->to('/activities/exams');
        }
        
    }


    public function updateData(){

        $record = TmActividades::find($this->actividadId);
            
        $record->update([
            'actividad' => $this->tipo,
            'nombre' => $this->nombre,
            'descripcion' => "",
            'fecha' => $this->fecha.' '.$this->hora,
            'subir_archivo' => $this->archivo,
            'puntaje' => $this->puntaje,
            'enlace' => $this->enlace,
            'estado' => $this->estado,
            'usuario' => auth()->user()->name,
        ]);

        $message = "Registro actualizado con éxito!";
        $this->dispatchBrowserEvent('msg-grabar', ['newName' => $message]);

        return redirect()->to('/activities/exams');

    }
        
    public function attach_add()
    {
        $linea = count($this->array_attach);
        $linea = $linea+1;

        $attach=[
            'linea' => $linea,
            'adjunto' => "",
        ];

        array_push($this->array_attach,$attach);

    }


    public function attach_del($linea){

        $recnoToDelete = $this->array_attach;
        foreach ($recnoToDelete as $index => $recno)
        {
            if ($recno['linea'] == $linea){
                unset ($recnoToDelete[$index]);
            } 
        }

        $this->reset(['array_attach']);
        $this->array_attach = $recnoToDelete;
    
    }

}
