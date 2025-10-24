<?php

namespace App\Http\Livewire;
use App\Models\TmPeriodosLectivos;
use App\Models\TmCalendarioEventos;
use App\Models\TmCalendarioGrados;
use App\Models\TmPpeFases;
use App\Models\TmPpeEstudiantes;

use Livewire\Component;

class VcPpeFases extends Component
{   
    public $fecha, $hora, $fase, $periodoId, $docenteId, $filas=0, $enlace;
    public $objdetalle=[];
    public $personas;


    public function mount($fase)
    {
        $ldate = date('Y-m-d H:i:s');
        $this->fecha = date('Y-m-d',strtotime($ldate));
        $this->hora = date('H:i');

        $this->fase = $fase;
        $this->docenteId = auth()->user()->personaId;

        $tblperiodos = TmPeriodosLectivos::where("aperturado",1)->first();
        $this->periodoId = $tblperiodos['id'];

        $this->loadData();

    }
    
    public function render()
    {
                
        return view('livewire.vc-ppe-fases');
    }

    public function newdetalle(){

        $this->objdetalle = [];
        $this->filas = (int) $this->filas;

        for ($i = 1; $i <= $this->filas; $i++) {
            
            $this->objdetalle[$i]['linea'] = $i ;
            $this->objdetalle[$i]['fecha'] = "";
           
        } 

    }

    public function loadData(){

        $tblfases = TmPpeFases::query()
        ->where('periodo_id',$this->periodoId)
        ->where('persona_id',$this->docenteId)
        ->where('enlace',"")
        ->get();

        foreach($tblfases as $key => $fase){
            $this->objdetalle[$key]['linea'] = $key+1 ;
            $this->objdetalle[$key]['fecha'] = date('Y-m-d',strtotime($fase->fecha));
        }

        $this->filas = count($tblfases);
        
        $tblfases = TmPpeFases::query()
        ->where('periodo_id', $this->periodoId)
        ->where('persona_id', $this->docenteId)
        ->whereNotNull('enlace')       // que no sea NULL
        ->where('enlace', '<>', '')    // que no esté vacío
        ->first();

        $this->enlace = $tblfases->enlace; 
        $this->loadPersonas();
        
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
                'usuario' => auth()->user()->name,
            ]);

            TmCalendarioGrados::Create([
                'calendario_id' => $eventos->id,
                'modalidad_id' => 2,
                'grado_id' => 13,
                'usuario' => auth()->user()->name,
            ]);
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

}
