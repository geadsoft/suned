<?php

namespace App\Http\Livewire;
use App\Models\TmHorarios;
use App\Models\TmHorariosDocentes;
use App\Models\TmActividades;
use App\Models\TdCalificacionActividades;

use Livewire\Component;

class VcQualifyActivity extends Component
{   

    public $actividadId=0, $paralelo, $termino="1T", $bloque="1P", $tipo="AI", $nombre, $fecha, $archivo='SI', $puntaje=10, $enlace="", $control="enabled";
    public $tblparalelo=[];
    public $tblactividad=[];
    public $tblrecords=[];
    public $personas=[];

    public $filters=[
        'paralelo' => 0, 
        'termino' => '3T',
        'bloque' => '1P',
        'actividad' => 'AI',
    ];

    protected $listeners = ['setData'];

    public function mount()
    {
        
        $this->tblparalelo = TmHorarios::query()
        ->join("tm_servicios as s","s.id","=","tm_horarios.servicio_id")
        ->join("tm_cursos as c","c.id","=","tm_horarios.curso_id")
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as m","m.id","=","d.asignatura_id")
        ->where("d.docente_id",2913)
        ->selectRaw('d.id, concat(m.descripcion," - ",s.descripcion," ",c.paralelo) as descripcion')
        ->get();

        if (!empty($this->tblparalelo)){
            $this->filters['paralelo'] = $this->tblparalelo[0]["id"];
            $this->consulta();
        }

    }

    public function render()
    {   
        $this->tblparalelo = TmHorarios::query()
        ->join("tm_servicios as s","s.id","=","tm_horarios.servicio_id")
        ->join("tm_cursos as c","c.id","=","tm_horarios.curso_id")
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as m","m.id","=","d.asignatura_id")
        ->where("d.docente_id",2913)
        ->selectRaw('d.id, concat(m.descripcion," - ",s.descripcion," ",c.paralelo) as descripcion')
        ->get();
        
        return view('livewire.vc-qualify-activity',[
            'tblrecords'  => $this->tblrecords,
            'tblactividad' => $this->tblactividad,
            'tblparalelo' => $this->tblparalelo,
        ]);
    }

    public function consulta(){

        $this->tblactividad = TmActividades::query()
        ->when($this->filters['paralelo'],function($query){
            return $query->where('paralelo',"{$this->filters['paralelo']}");
        })
        ->when($this->filters['termino'],function($query){
            return $query->where('termino',"{$this->filters['termino']}");
        })
        ->when($this->filters['bloque'],function($query){
            return $query->where('bloque',"{$this->filters['bloque']}");
        })
        ->when($this->filters['actividad'],function($query){
            return $query->where('actividad',"{$this->filters['actividad']}");
        })
        ->where("tipo","AC")
        ->where("docente_id",2913)
        ->get();

            
        $this->add();

    }


    public function add(){

        $this->tblrecords=[];

        $this->personas = TmHorariosDocentes::query()
        ->join("tm_horarios as h","h.id","=","tm_horarios_docentes.horario_id")
        ->join("tm_matriculas as m",function($join){
            $join->on("m.modalidad_id","=","h.grupo_id")
                ->on("m.periodo_id","=","h.periodo_id")
                ->on("m.curso_id","=","h.curso_id");
        })
        ->join("tm_personas as p","p.id","=","m.estudiante_id")
        ->select("p.*")
        ->where("tm_horarios_docentes.id",$this->filters['paralelo'])
        ->get();



        // Actualiza Datos Estudiantes
        foreach ($this->personas as $index => $data)
        {
            $this->tblrecords[$index]['personaId'] = $data->id;
            $this->tblrecords[$index]['nui'] = $data->identificacion;
            $this->tblrecords[$index]['nombres'] = $data->apellidos.' '.$data->nombres;

            foreach ($this->tblactividad as $actividad)
            {
                $actidadId = $actividad['id'];
                $this->tblrecords[$index][$actidadId] = 0.00;    
            }
            $this->tblrecords[$index]['promedio'] = 0.00;
        }
       
        $this->tblrecords[$index+1]['personaId'] = 0;
        $this->tblrecords[$index]['nui'] = '';
        $this->tblrecords[$index+1]['nombres'] = 'Promedio';
        foreach ($this->tblactividad as $actividad)
        {
            $actidadId = $actividad['id'];
            $this->tblrecords[$index+1][$actidadId] = 0.00;    
        }
        $this->tblrecords[$index+1]['promedio'] = 0.00;
        
    }

    public function createData(){

        if (count($this->tblactividad)>0){

            $message = "";
            $this->dispatchBrowserEvent('msg-confirm', ['newName' => $message]);

        }else{

            $message = "";
            $this->dispatchBrowserEvent('msg-alert', ['newName' => $message]);

        }

    }

    public function setData()
    {

        foreach ($this->tblrecords as $index => $data){

            $personaId = $this->tblrecords[$index]['personaId'];

            foreach ($this->tblactividad as $actividad)
            {
                $actidadId = $actividad['id'];
                $nota = $this->tblrecords[$index][$actidadId];   
            }

            if ($personaId>0){

                TdCalificacionActividades::Create([
                    'actividad_id' => $actidadId,
                    'persona_id' => $personaId,
                    'nota' => $nota,
                    'usuario' => auth()->user()->name,
                    'estado' => 'A',
                ]);

            }

        }
        
        $message = "Calificaciones grabada con Éxito......";
        $this->dispatchBrowserEvent('msg-grabar', ['newName' => $message]);

    }


}
