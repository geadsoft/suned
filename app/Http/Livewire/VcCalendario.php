<?php

namespace App\Http\Livewire;
use App\Models\TmGeneralidades;
use App\Models\TmCalendarioEventos;

use Livewire\Component;

class VcCalendario extends Component
{
    public $showEditModal = false;
    public $actividad='GE', $evento, $startdate, $enddate, $comentario, $selectId, $eventoId;
    public $arrevent=[];

    protected $listeners = ['postAdded'];

    public function mount()
    {
       
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
            'periodo' => 2024,
            'mes' => 12,
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

    public function loadEvent(){

        $this->eventos = TmCalendarioEventos::query()
        ->where('periodo',2024)
        ->where('mes',12)
        ->selectRaw('tm_calendario_eventos.*, DATE(DATE_ADD(end_date, INTERVAL 1 DAY)) as fecha2')
        ->get();

        $this->arrayObject($this->eventos);

    }

    public function postAdded($idEvent){
       
        $this->$showEditModal = true;
        $calendario = TmCalendarioEventos::find($idEvent);

        $startDate = date('Y-m-d',strtotime($calendario['start_date']));
        $endDate = date('Y-m-d',strtotime($calendario['end_date']));

        $this->eventoId = $calendario['id'];
        $this->actividad = $calendario['actividad'];
        $this->evento = $calendario['nombre'];
        $this->startdate = $startDate;
        $this->enddate = $endDate;
        $this->comentario = $calendario['descripcion'];

        /*$this->dispatchBrowserEvent('show-form');*/
        
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
