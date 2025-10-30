<?php

namespace App\Http\Livewire;
use App\Models\TmPeriodosLectivos;
use App\Models\TmCalendarioEventos;
use App\Models\TmCalendarioGrados;
use App\Models\TmPpeFases;
use App\Models\TmPpeEstudiantes;
use App\Models\TdPeriodoSistemaEducativos;
use App\Models\TmPpeActividades;
use Livewire\WithPagination;

use Livewire\Component;

class VcPpeFases extends Component
{   
    use WithPagination;
    
    public $fecha, $hora, $fase, $periodoId, $docenteId, $filas=0, $enlace, $showEditModal=false;
    public $tipo="AI", $descripcion="", $fechaentrega, $horaentrega, $archivo="NO", $puntaje, $comentario, $enlace2="";
    public $selectId, $nombreActividad;

    public $tblactividad=[];
    public $tblrecords=[];
    public $objdetalle=[];
    public $personas=[];

    public function mount($fase)
    {
        $ldate = date('Y-m-d H:i:s');
        $this->fecha = date('Y-m-d',strtotime($ldate));
        $this->hora = date('H:i');

        $this->fase = $fase;
        $this->docenteId = auth()->user()->personaId;

        $tblperiodos = TmPeriodosLectivos::where("aperturado",1)->first();
        $this->periodoId = $tblperiodos['id'];

        $this->tblactividad = TdPeriodoSistemaEducativos::query()
        ->where('periodo_id',$this->periodoId)
        ->where('tipo','AC')
        ->where('codigo','<>','EX')
        ->get();

        $this->loadPersonas();
        $this->loadData();

    }
    
    public function render()
    {
        $this->loadPersonas();

        $fase = 'F'.$this->fase;

        $actividades = TmPpeActividades::query()
        ->where('periodo_id',$this->periodoId)
        ->where('tipo',$fase)
        ->paginate(12);
        
        return view('livewire.vc-ppe-fases',[
            'actividades' => $actividades,
        ]);
    }

    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }

    public function newdetalle(){

        $this->objdetalle = [];
        $this->filas = (int) $this->filas;

        for ($i = 1; $i <= $this->filas; $i++) {
            
            $this->objdetalle[$i]['linea'] = $i ;
            $this->objdetalle[$i]['fecha'] = "";
           
        } 

    }

    public function edit($id){
        
        $this->showEditModal = true;
        $activity  = TmPpeActividades::find($id);
       
        $this->selectId = $activity->id;
        $this->tipo = $activity->actividad;
        $this->descripcion = $activity->nombre;
        $this->fechaentrega = date('Y-m-d',strtotime($activity->fecha_entrega));
        $this->horaentrega = date('H:i',strtotime($activity->fecha_entrega));
        $this->archivo = $activity->subir_archivo;
        $this->puntaje = $activity->puntaje;
        $this->comentario = $activity->descripcion;
        $this->enlace2 = $activity->enlace;

        $this->dispatchBrowserEvent('show-form');

    }


    public function loadData(){

        $tblfases = TmPpeFases::query()
        ->where('periodo_id',$this->periodoId)
        ->where('fase',$this->fase)
        ->where('persona_id',$this->docenteId)
        ->where('enlace',"")
        ->orderby('fecha')
        ->get();

        foreach($tblfases as $key => $fase){
            $this->objdetalle[$key]['linea'] = $key+1 ;
            $this->objdetalle[$key]['fecha'] = date('Y-m-d',strtotime($fase->fecha));
        }

        $this->filas = count($tblfases);
        
        $tblfases = TmPpeFases::query()
        ->where('periodo_id', $this->periodoId)
        ->where('fase',$this->fase)
        ->where('persona_id', $this->docenteId)
        ->whereNotNull('enlace')       // que no sea NULL
        ->where('enlace', '<>', '')    // que no esté vacío
        ->first();

        if ($tblfases){
            $this->enlace = $tblfases->enlace; 
            //$this->loadPersonas();
        }

        foreach($this->personas as $index => $persona){

            $personaId = $persona->id;

            foreach($this->objdetalle as $key => $fecha){

                $col = 'dia'.$key;
                
                $this->tblrecords[$personaId]['personaid'] = $persona->id;
                $this->tblrecords[$personaId]['nombres'] = $persona->apellidos.' '.$persona->nombres;
                $this->tblrecords[$personaId]['nui'] = $persona->identificacion;
                $this->tblrecords[$personaId][$col] = 0;
            
            }

        }

        $fase = 'F'.$this->fase;
        
    }

    public function loadPersonas(){

        $this->personas =  TmPpeEstudiantes::query()
        ->join('tm_personas as p','p.id','=','tm_ppe_estudiantes.persona_id')
        ->where('periodo_id',$this->periodoId)
        ->select('p.*')
        ->get(); 

    }

    public function createData(){

        $vacios = collect($this->objdetalle)->filter(fn($d) => empty($d->fecha))->count();

        foreach ($this->objdetalle as $index => $detalle)
        {
            TmPpeFases::Create([
                'periodo_id' => $this->periodoId,
                'persona_id' => $this->docenteId,
                'fase' => $this->fase,
                'fecha' => $detalle['fecha'],
                'enlace' => "",
                'usuario' => auth()->user()->name,
            ]);

            $mes = date('m', strtotime($detalle['fecha']));
            $periodo = date('Y', strtotime($detalle['fecha']));

            $eventos = TmCalendarioEventos::Create([
                'periodo' => $periodo,
                'mes' => $mes,
                'actividad' => 'PP',
                'nombre' => 'Recepción de clase PPE',
                'start_date' => $detalle['fecha'],
                'end_date' => $detalle['fecha'],
                'descripcion' => 'Fecha programada para la recepción y revisión de la clase correspondiente al Programa de Participación Estudiantil.',
                'todos' => 0,
                'usuario' => auth()->user()->name,
            ]);

            $grados = TmPpeEstudiantes::query()
            ->where('periodo_id', $this->periodoId)
            ->select('modalidad_id', 'grado_id')
            ->groupBy('modalidad_id', 'grado_id')
            ->get();
            
            foreach ($grados as $key => $grado){

                TmCalendarioGrados::Create([
                    'calendario_id' => $eventos->id,
                    'modalidad_id' => $grado->modalidad_id,
                    'grado_id' => $grado->grado_id,
                    'usuario' => auth()->user()->name,
                ]);

            }
            
        }

        //Link clase virtual
        TmPpeFases::Create([
            'periodo_id' => $this->periodoId,
            'persona_id' => $this->docenteId,
            'fase' => $this->fase,
            'fecha' => $this->fecha,
            'enlace' => $this->enlace,
            'usuario' => auth()->user()->name,
        ]); 
        
        $this->loadData();

    }


    public function addActivity(){
        
        $ldate = date('Y-m-d H:i:s');
        $this->fechaentrega = date('Y-m-d',strtotime($ldate));
        $this->horaentrega = date('H:i');
        $this->puntaje = 10;
        
        $this->dispatchBrowserEvent('show-form');

    }

    public function createActivity(){

        $this ->validate([
            'tipo' => 'required',
            'descripcion' => 'required',
            'fechaentrega' => 'required',
            'horaentrega' => 'required',
            'puntaje' => 'required'
        ]);

        $grados = TmPpeEstudiantes::query()
        ->where('periodo_id', $this->periodoId)
        ->select('modalidad_id', 'grado_id')
        ->groupBy('modalidad_id', 'grado_id')
        ->get();
        
        foreach ($grados as $key => $grado){

            $tblData = TmPpeActividades::Create([
                'periodo_id' => $this->periodoId,
                'modalidad_id' => $grado->modalidad_id,
                'grado_id' => $grado->grado_id,
                'docente_id' => $this->docenteId,
                'tipo' => 'F'.$this->fase,
                'actividad' => $this->tipo,
                'nombre' => $this->descripcion,
                'descripcion' => $this->comentario,
                'fecha_entrega' => $this->fechaentrega.' '.$this->horaentrega,
                'subir_archivo' => $this->archivo,
                'puntaje' => $this->puntaje,
                'enlace' => $this->enlace2,
                'estado' => "A",
                'usuario' => auth()->user()->name,
            ]);
        }

        $this->dispatchBrowserEvent('hide-form');

    }

    public function updateActivity(){

        $this ->validate([
            'tipo' => 'required',
            'descripcion' => 'required',
            'fechaentrega' => 'required',
            'horaentrega' => 'required',
            'puntaje' => 'required'
        ]);        
        
        if ($this->selectId){
            $record = TmPpeActividades::find($this->selectId);
            $record->update([
                'actividad' => $this->tipo,
                'nombre' => $this->descripcion,
                'descripcion' => $this->comentario,
                'fecha_entrega' => $this->fechaentrega.' '.$this->horaentrega,
                'subir_archivo' => $this->archivo,
                'puntaje' => $this->puntaje,
                'enlace' => $this->enlace2,
            ]);
            
        }
      
        $this->dispatchBrowserEvent('hide-form');
        
    }
    
    public function delete( $id ){

        $this->selectId = $id;
        $activity  = TmPpeActividades::find($id);
        $this->nombreActividad = $activity->nombre;

        $this->dispatchBrowserEvent('show-delete');

    }

    public function deleteActivity(){

        TmPpeActividades::find($this->selectId)->delete();
        $this->dispatchBrowserEvent('hide-delete');

    }

}
