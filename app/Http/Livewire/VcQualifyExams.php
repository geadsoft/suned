<?php

namespace App\Http\Livewire;
use App\Models\TmHorarios;
use App\Models\TmHorariosDocentes;
use App\Models\TmActividades;
use App\Models\TdCalificacionActividades;

use Livewire\Component;

class VcQualifyExams extends Component
{
    
    public $asignaturaId=0, $actividadId=0, $paralelo, $termino="1T", $bloque="3E", $tipo="EX", $nombre, $fecha, $archivo='SI', $puntaje=10, $enlace="", $control="enabled";
    public $tblparalelo=[], $tblasignatura=[];
    public $tblexamen=[];
    public $tblrecords=[];
    public $personas=[];
    public $detalle=[];
    public $arrnotas=[];
    public $docenteId;

    public $filters=[
        'paralelo' => 0, 
        'termino' => '3T',
        'bloque' => '3E',
        'actividad' => 'EX',
    ];

    protected $listeners = ['setData'];

    public function mount()
    {   
        $this->docenteId = auth()->user()->personaId;
        
        if (!empty($this->tblparalelo)){
            $this->filters['paralelo'] = $this->tblparalelo[0]["id"];
            $this->consulta();
        }

    }

    public function render()
    {
        $this->tblasignatura = TmHorarios::query()
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as m","m.id","=","d.asignatura_id")
        ->where("d.docente_id",$this->docenteId)
        ->selectRaw('m.id, m.descripcion')
        ->groupBy('m.id','m.descripcion')
        ->get();

        $this->tblparalelo = TmHorarios::query()
        ->join("tm_servicios as s","s.id","=","tm_horarios.servicio_id")
        ->join("tm_cursos as c","c.id","=","tm_horarios.curso_id")
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as m","m.id","=","d.asignatura_id")
        ->where("d.docente_id",$this->docenteId)
        ->where("m.id",$this->asignaturaId)
        ->selectRaw('d.id, concat(s.descripcion," ",c.paralelo) as descripcion')
        ->get();

        return view('livewire.vc-qualify-exams',[
            'tblrecords'  => $this->tblrecords,
            'tblexamen' => $this->tblexamen,
            'tblparalelo' => $this->tblparalelo,
        ]);

    }

    public function consulta(){

        $this->tblexamen = TmActividades::query()
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
        ->where("tipo","ET")
        ->where("docente_id",$this->docenteId)
        ->get();
            
        $this->add();
        $this->asignarNotas();

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
        ->orderBy("p.apellidos")
        ->get();

        // Actualiza Datos Estudiantes
        foreach ($this->personas as $key => $data)
        {   
            $index = $data->id;
            $this->tblrecords[$key]['personaId'] = $data->id;
            $this->tblrecords[$key]['nui'] = $data->identificacion;
            $this->tblrecords[$key]['nombres'] = $data->apellidos.' '.$data->nombres;

            foreach ($this->tblexamen as $col => $actividad)
            {
                $this->tblrecords[$key][$col] = 0.00;    
            }
            $this->tblrecords[$key]['promedio'] = 0.00;
        }
       
        $this->tblrecords['ZZ']['personaId'] = 0;
        $this->tblrecords['ZZ']['nui'] = '';
        $this->tblrecords['ZZ']['nombres'] = 'Promedio';
        foreach ($this->tblexamen as $col => $actividad)
        {
            $this->tblrecords['ZZ'][$col] = 0.00;    
        }
        $this->tblrecords['ZZ']['promedio'] = 0.00;
        
    }

    public function asignarNotas(){

        foreach ($this->personas as $key => $data)
        {
            $personaId =  $data->id; 

            foreach ($this->tblexamen as $col => $actividad)
            {
                $actividadId =  $actividad['id'];
                
                /*Notas*/
                $notas = TmActividades::query()
                ->join('td_calificacion_actividades as n','n.actividad_id','=','tm_actividades.id')
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
                ->where("tipo","ET")
                ->where("docente_id",2913)
                ->where("actividad_id",$actividadId)
                ->where("persona_id",$personaId)
                ->select("n.*")
                ->get();  

                foreach ($notas as $record)
                {
                    $nota =  $record['nota'];
                    $this->tblrecords[$key][$col] = $nota; 
                }

            }
        }
    }

    public function createData(){

        if (count($this->tblexamen)>0){

            $message = "";
            $this->dispatchBrowserEvent('msg-confirm', ['newName' => $message]);

        }else{

            $message = "";
            $this->dispatchBrowserEvent('msg-alert', ['newName' => $message]);

        }

    }

    public function setData()
    {

        $dataRow=[
            'id' => 0,
            'actividad_id' => 0,
            'persona_id' => 0,
            'nota' => 0,
            'estado' => 0,
            'usuario' => 0,
        ];

        foreach ($this->tblrecords as $index => $data)
        {   
            $personaId = $data['personaId'];
            foreach ($this->tblexamen as $col => $actividad)
            {
                
                $dataRow['id'] = 0;               

                $tmpnota = TdCalificacionActividades::query()
                ->where('actividad_id',$actividad['id']) 
                ->where('persona_id',$personaId)
                ->first();
                
                if (!empty($tmpnota)){
                    $dataRow['id'] = $tmpnota['id'];
                }
                
                $dataRow['actividad_id'] = $actividad['id'];
                $dataRow['persona_id']=$this->tblrecords[$index]['personaId'];
                $dataRow['nota'] = $this->tblrecords[$index][$col];
                $dataRow['estado'] = 'A';
                $dataRow['usuario'] = auth()->user()->name;   
                
                if ($index!="ZZ"){
                    array_push($this->detalle,$dataRow);
                }
               
            }
            
        }

        foreach ($this->detalle as $detalle){
            
            if ($detalle['id']>0){

                $record = TdCalificacionActividades::find($detalle['id']);
                $record->update([
                    'nota' => $detalle['nota'],
                ]);

            }else{
                
                TdCalificacionActividades::Create([
                    'actividad_id' => $detalle['actividad_id'],
                    'persona_id' => $detalle['persona_id'],
                    'nota' =>  $detalle['nota'],
                    'usuario' => auth()->user()->name,
                    'estado' => 'A',
                ]);

            }
        }

        $message = "Calificaciones grabada con Éxito......";
        $this->dispatchBrowserEvent('msg-grabar', ['newName' => $message]);
    
    }

}
