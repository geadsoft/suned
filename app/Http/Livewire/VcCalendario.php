<?php

namespace App\Http\Livewire;
use App\Models\TmGeneralidades;
use App\Models\TmCalendarioEventos;
use App\Models\TmCalendarioGrados;
use App\Models\TmPeriodosLectivos;

use Livewire\Component;

class VcCalendario extends Component
{
    public $showEditModal = false, $eControl = 'disabled', $periodo, $mes;
    public $actividad='GE', $evento, $startdate, $enddate, $comentario, $selectId, $eventoId;
    public $arrevent=[];

    protected $listeners = ['postAdded','newEvent'];

    public function mount()
    {
        $tblperiodos = TmPeriodosLectivos::where("estado",'A')->first();
        $this->periodo = $tblperiodos['periodo'];
        $this->mes = date('m');
        $this->loadEvent();
        
    }

    public function render()
    {
                  
        return view('livewire.vc-calendario');

    }

    public function createData(){

        $this ->validate([
            'actividad' => 'required',
            'evento' => 'required',
            'startdate' => 'required',
            'enddate' => 'required',
            'comentario' => 'required',
        ]);

        $eventos = TmCalendarioEventos::Create([
            'periodo' => $this->periodo,
            'mes' => $this->mes,
            'actividad' => $this->actividad,
            'nombre' => $this->evento,
            'start_date' => $this->startdate,
            'end_date' => $this->enddate,
            'descripcion' => $this->comentario,
            'usuario' => auth()->user()->name,
        ]);

        $this->selectId = $eventos->id;
        $this->emitTo('vc-nivel-calendar','setGrabaDetalle',$this->selectId);

        $this->dispatchBrowserEvent('hide-form');
        $this->loadEvent();  
        
    }


    public function updateData(){

        $this ->validate([
            'actividad' => 'required',
            'evento' => 'required',
            'startdate' => 'required',
            'enddate' => 'required',
            'comentario' => 'required',
        ]);
        
        $record = TmCalendarioEventos::find($this->selectId);
        $record->update([
            'descripcion' => $this->comentario,
            'nombre' => $this->evento,
            'start_date' => $this->startdate,
            'end_date' => $this->enddate,                
        ]);
        
        $this->emitTo('vc-nivel-calendar','setGrabaDetalle',$this->selectId);
        $this->dispatchBrowserEvent('hide-form');
        $this->loadEvent();
        
    }

    public function cerrarModal(){
        $this->dispatchBrowserEvent('hide-form');
    }

    public function deleteData(){

        TmCalendarioGrados::where('calendario_id',$this->eventoId)->delete();
        TmCalendarioEventos::find($this->eventoId)->delete();
        
        $this->dispatchBrowserEvent('hide-form');
        $this->loadEvent();
    }

    public function newEvent(){

        $this->showEditModal = false;
        $this->eControl = '';
        
        $ldate = date('Y-m-d H:i:s');
        $startDate = date('Y-m-d',strtotime($ldate));
        $endDate = date('Y-m-d',strtotime($ldate));

        $this->eventoId = 0;
        $this->actividad = 'GE';
        $this->evento = '';
        $this->startdate = $startDate;
        $this->enddate = $endDate;
        $this->comentario = '';

        $this->emitTo('vc-nivel-calendar','setGrado',$this->eventoId);
        $this->dispatchBrowserEvent('show-form');

    }

    public function loadEvent(){

        $this->eventos = TmCalendarioEventos::query()
        ->where('periodo',$this->periodo)
        ->where('mes',$this->mes)
        ->selectRaw('tm_calendario_eventos.*, DATE(DATE_ADD(end_date, INTERVAL 1 DAY)) as fecha2')
        ->get();

        $this->arrayObject($this->eventos);

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

        $array=[];

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

                $array[] = [
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

                $array[] = [
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

        $this->arrevent = json_encode($array);
        
        
        $this->dispatchBrowserEvent('load-calendar', ['newObj' => $this->arrevent]);


    }

}
