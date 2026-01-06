<?php

namespace App\Http\Livewire;
use App\Models\TmGeneralidades;
use App\Models\TmCalendarioEventos;
use App\Models\TmCalendarioGrados;
use App\Models\TmPeriodosLectivos;
use App\Models\TmMatricula;
use App\Models\TmPersonas;
use App\Models\TmCambiaModalidad;
use App\Models\TmPaseCursos;

use Livewire\Component;

class VcViewCalendar extends Component
{
    
    public $showEditModal = false, $eControl = 'disabled', $periodo, $mes;
    public $actividad='GE', $evento, $startdate, $enddate, $comentario, $selectId, $eventoId;
    public $eventos, $arrevent=[], $lstevent, $array;
    public $modalidadId, $gradoId, $fechaEmpieza, $fechaTermina;

    protected $listeners = ['postAdded','newEvent','viewEvent'];

    public function mount()
    {
        $this->personaId = auth()->user()->personaId;
        
        $tblperiodos = TmPeriodosLectivos::where("aperturado",1)->first();
        $this->periodoId = $tblperiodos['id'];
        
        $this->fechaEmpieza = $tblperiodos['fecha_empieza'];
        $this->fechaTermina = $tblperiodos['fecha_termina'];

        $this->periodo = date('Y');
        $this->mes = date('m');

        $this->loadEvent();
    }

    public function render()
    {
                  
        return view('livewire.vc-view-calendar');

    }

    public function loadEvent(){

        $this->array=[];
        $persona = TmPersonas::find($this->personaId);

        if ($persona->tipopersona=='E'){

            /*$matricula = TmCambiaModalidad::query()
            ->where('persona_id',$this->personaId)
            ->first();

            if(empty($matricula)){
                $this->modalidadId = 0;
                $this->gradoId = 0;
            }else{
                $this->modalidadId = $matricula['modalidadId'];
                $this->gradoId = $matricula['gradoId'];
            }*/
            $matricula = TmCambiaModalidad::query()
            ->where('persona_id',$this->personaId)
            ->first();

            if (!$matricula) {
                $matricula = TmMatricula::query()
                ->where('periodo_id',$this->periodoId)
                ->where('estudiante_id',$this->personaId)
                ->first();

                $matriculaId = $matricula->id;
            }else{
                $matriculaId = $matricula->modalidad_id;
            }


            $this->gradoId = $matricula->grado_id;
            $this->modalidadId = $matricula->modalidad_id;

            //Si tiene pase de curso en otra modalidad
            $pasecurso = TmPaseCursos::query()
            ->where('matricula_id',$matriculaId)
            ->where('estado','A')
            ->first();

            if (!empty($pasecurso)){
                
                $this->modalidadId = $pasecurso->modalidad_id;
                $this->gradoId = $pasecurso->grado_id;
            }


            // Eventos Todos
            $evenTodos = TmCalendarioEventos::query()
            ->where('periodo',$this->periodo)
            //->where('mes',$this->mes)
            ->where('todos',1)
            ->selectRaw('tm_calendario_eventos.*, DATE(DATE_ADD(end_date, INTERVAL 1 DAY)) as fecha2')
            ->get();
           
            $this->arrayObject($evenTodos);            

            // Eventos Modalidad
            $eventModalidad = TmCalendarioEventos::query()
            ->join('tm_calendario_grados as g','g.calendario_id','=','tm_calendario_eventos.id')
            //->where('periodo',$this->periodo)
            //->where('mes',$this->mes)
            ->whereDate('start_date', '>=', $this->fechaEmpieza)
            ->whereDate('end_date', '<=', $this->fechaTermina)
            ->where('g.modalidad_id',$this->modalidadId)
            ->where('g.grado_id',$this->gradoId)
            ->selectRaw('tm_calendario_eventos.*, DATE(DATE_ADD(end_date, INTERVAL 1 DAY)) as fecha2')
            ->get();

            $this->arrayObject($eventModalidad);

        }else{

            $this->eventos = TmCalendarioEventos::query()
            ->whereDate('start_date', '>=', $this->fechaEmpieza)
            ->whereDate('end_date', '<=', $this->fechaTermina)
            ->selectRaw('tm_calendario_eventos.*, DATE(DATE_ADD(end_date, INTERVAL 1 DAY)) as fecha2')
            ->get();

             $this->arrayObject($this->eventos);

        }

        $fechafin = date('Y-m-t');
 
        if ($persona->tipopersona=='E'){

            $this->lstevent = TmCalendarioEventos::query()
            ->join('tm_calendario_grados as g','g.calendario_id','=','tm_calendario_eventos.id')
            ->where('periodo',$this->periodo)
            ->where('start_date','>',$fechafin)
            ->where('g.modalidad_id',$this->modalidadId)
            ->where('g.grado_id',$this->gradoId)
            ->selectRaw('tm_calendario_eventos.*, DATE(DATE_ADD(end_date, INTERVAL 1 DAY)) as fecha2')
            ->get();

        }else{

            $this->lstevent = TmCalendarioEventos::query()
            ->where('periodo',$this->periodo)
            ->where('start_date','>',$fechafin)
            ->selectRaw('tm_calendario_eventos.*, DATE(DATE_ADD(end_date, INTERVAL 1 DAY)) as fecha2')
            ->get();

        }

        

        //Asigna Eventos
        $this->arrevent = json_encode($this->array);
        
        
        $this->dispatchBrowserEvent('load-calendar', ['newObj' => $this->arrevent]);

    }

    public function postAdded($idEvent){

        $calendario = TmCalendarioEventos::find($idEvent);

        $startDate = date('Y-m-d',strtotime($calendario['start_date']));
        $endDate = date('Y-m-d',strtotime($calendario['end_date']));

        $this->eventoId = $calendario['id'];
        $this->actividad = $calendario['actividad'];
        $this->evento = $calendario['nombre'];
        $this->startdate = $startDate;
        $this->enddate = $endDate;
        $this->comentario = $calendario['descripcion']; 
        $this->selectId = $this->eventoId;

        /*$this->emitTo('vc-nivel-calendar','setGrado',$this->eventoId);*/
        $this->dispatchBrowserEvent('show-event');
        
    }

    public function editEvent(){

        $this->showEditModal = true;
        $this->eControl = 'disabled';
        $this->emitTo('vc-nivel-calendar','setGrado',$this->eventoId);
        $this->dispatchBrowserEvent('show-form');
        
    }

    public function arrayObject($eventos){


        foreach ($eventos as $key => $event){

            $fecha1 = date('Y-m-d',strtotime($event['start_date']));
            $fecha2 = date('Y-m-d',strtotime($event['fecha2']));

            switch ($event['actividad']) {
                case 'NO':
                    $color = "bg-soft-success";
                    break;
                case 'CO':
                    $color = "bg-soft-info";
                    break;
                case 'RE':
                    $color = "bg-soft-warning";
                    break;
                case 'EX':
                    $color = "bg-soft-danger";
                    break;
                default:
                    $color = "bg-soft-primary";
                    break;
            }

            if($event['start_date'] ==$event['end_date']){

                $this->array[] = [
                    'id' =>  $event['id'],
                    'title' => $event['nombre'],
                    'start' => $fecha1,
                    'className' => $color,
                    'location' => '',
                    'allDay' => false,
                    'extendedProps' => ['department'=>'All Day Event'],
                    'description' => $event['descripcion'] 
                ];

            }else{

                $this->array[] = [
                    'id' =>  $event['id'],
                    'title' => $event['nombre'],
                    'start' => $fecha1,
                    'end' => $fecha2,
                    'className' => $color,
                    'location' => '',
                    'allDay' => true,
                    'extendedProps' => ['department'=>'All Day Event'],
                    'description' => $event['descripcion'] 
                ];

            }
        }

    }

    public function viewEvent($mes,$periodo){

        $timestamp = mktime(0, 0, 0, $mes+1, 1, $periodo);
        $fechafin = date('Y-m-d', $timestamp);
        $messig = $mes+1;

        $this->lstevent = TmCalendarioEventos::query()
        ->whereDate('start_date','>=',$fechafin)
        /*->where('periodo',$this->periodo)
        ->where('mes',$messig)*/
        ->selectRaw('tm_calendario_eventos.*, DATE(DATE_ADD(end_date, INTERVAL 1 DAY)) as fecha2')
        ->get();

    }
    
}
