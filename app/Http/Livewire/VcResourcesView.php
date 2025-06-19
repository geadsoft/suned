<?php

namespace App\Http\Livewire;
use App\Models\TmPeriodosLectivos;
use App\Models\TmAsignaturas;
use App\Models\TmRecursos;
use App\Models\TmFiles;

use Livewire\Component;

class VcResourcesView extends Component
{
    public $docenteId, $recursoId, $periodoId, $nombre, $estado; 
    public $array_attach;

    public $arrestado=[
        'A' => 'Activo',
        'F' => 'Finalizado',
        'C' => 'Cerrado',
    ];


    public function mount($id)
    {

        $this->docenteId = auth()->user()->personaId;
        $this->recursoId = $id;

        $tblperiodos = TmPeriodosLectivos::where("aperturado",1)->first();
        $this->periodoId = $tblperiodos['id'];

        $this->load();

    }

    
    public function render()
    {
        return view('livewire.vc-resources-view');
    }

    public function load(){
        
        $recursos = TmRecursos::find($this->recursoId);

        $tblmateria = TmAsignaturas::find($recursos->asignatura_id);
        $this->asignatura =  $tblmateria['descripcion'];
        $this->nombre = $recursos->nombre;
        $this->enlace = $recursos->enlace;
        $this->docenteId = $recursos->docente_id;
        $this->periodoId = $recursos->periodo_id;
        $this->estado = $recursos->estado;

         //Adjuntos
        $tblfiles = TmFiles::query()
        ->where('actividad_id',$this->recursoId)
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

    }


    
}
