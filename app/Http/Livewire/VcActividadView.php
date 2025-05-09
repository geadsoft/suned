<?php

namespace App\Http\Livewire;
use App\Models\TmHorarios;
use App\Models\TmHorariosDocentes;
use App\Models\TmActividades;
use App\Models\TmAsignaturas;
use App\Models\TdPeriodoSistemaEducativos;
use App\Models\TmPeriodosLectivos;
use App\Models\TmFiles;

use Livewire\Component;

class VcActividadView extends Component
{
    public $asignatura, $curso,  $termino="1T", $bloque="1P", $tipo="AI", $nombre, $fecha, $archivo='SI', $puntaje=10, $enlace="", $descripcion="", $estado="A";
    public $periodoId, $tbltermino, $tblbloque, $tblactividad;
    public $array_attach=[];
    public $arrtermino, $arrbloque, $arractividad;
    
    /*public $arrtermino=[
        '1T' => 'Primer Trimestre',
        '2T' => 'Segundo Trimestre',
        '3T' => 'Tercer Trimestre',
    ];

    public $arrbloque=[
        '1P' => 'Primer Parcial',
        '2P' => 'Segundo Parcial',
        '3P' => 'Tercer Parcial',
    ];

    public $arractividad=[
        'AI' => 'Actividad Individual',
        'AG' => 'Actividad Grupal',
    ];*/

    public $arrestado=[
        'A' => 'Activo',
        'F' => 'Finalizado',
        'C' => 'Cerrado',
    ];


    public function mount($id)
    {

        $this->docenteId = auth()->user()->personaId;

        $tblperiodos = TmPeriodosLectivos::where("aperturado",1)->first();
        $this->periodoId = $tblperiodos['id'];

        $this->tbltermino = TdPeriodoSistemaEducativos::query()
        ->where('periodo_id',$this->periodoId)
        ->where('tipo','EA')
        ->get();

        foreach ($this->tbltermino as $data){
            $this->arrtermino[$data['codigo']] = $data['descripcion'];
        }

        $this->termino = $this->tbltermino[0]['codigo'];


        $this->tblbloque = TdPeriodoSistemaEducativos::query()
        ->where('periodo_id',$this->periodoId)
        ->where('tipo','PA')
        ->where('evaluacion',$this->termino)
        ->get();

        foreach ($this->tblbloque as $data){
            $this->arrbloque[$data['codigo']] = $data['descripcion'];
        }

        $this->tblactividad = TdPeriodoSistemaEducativos::query()
        ->where('periodo_id',$this->periodoId)
        ->where('tipo','AC')
        ->get();

        foreach ($this->tblactividad as $data){
            $this->arractividad[$data['codigo']] = $data['descripcion'];
        }

        $this->edit($id);

    }

    public function render()
    {
        return view('livewire.vc-actividad-view');
    }

    public function edit($id){
        
        $record = TmActividades::query()
        ->join("tm_horarios_docentes as d","d.id","=","tm_actividades.paralelo")
        ->select("tm_actividades.*","d.horario_id","d.asignatura_id")
        ->where("tm_actividades.id",$id)
        ->first()
        ->toArray();

        $tblfiles = TmFiles::query()
        ->where('actividad_id',$id)
        ->where('persona_id',$this->docenteId)
        ->get();

        $this->array_attach = [];
        foreach($tblfiles as $key => $files){

            $linea = count($this->array_attach);
            $linea = $linea+1;

            $attach=[
                'id' => $files['id'],
                'linea' => $linea,
                'adjunto' => $files['nombre'],
                'drive_id' => $files['drive_id'],
            ];

            array_push($this->array_attach,$attach);

        }

        $this->termino = $record['termino'];
        $this->bloque = $record['bloque'];
        $this->tipo = $record['actividad'];
        $this->nombre = $record['nombre'];
        $this->fecha = $record['fecha'];
        $this->puntaje = $record['puntaje'];
        $this->enlace = $record['enlace'];
        $this->descripcion = strip_tags($record['descripcion']); 
        $this->estado = $record['estado'];


        //$this->descripcion=".";
        $day = date('l', strtotime($this->fecha));
        //dd($day);

        $tblmateria = TmAsignaturas::find($record['asignatura_id']);
        $this->asignatura =  $tblmateria['descripcion'];

        $tblcurso = TmHorarios::query()
        ->join("tm_cursos as c","c.id","=","tm_horarios.curso_id")
        ->join("tm_servicios as s","s.id","=","c.servicio_id")
        ->selectRaw("concat(s.descripcion,' ',c.paralelo) as curso")
        ->where("tm_horarios.id",$record['horario_id'])
        ->first();

        $this->curso =  $tblcurso['curso'];

    }

}
