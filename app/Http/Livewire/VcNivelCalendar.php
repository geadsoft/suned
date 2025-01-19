<?php

namespace App\Http\Livewire;
use App\Models\TmGeneralidades;
use App\Models\TmServicios;
use App\Models\TmCalendarioGrados;

use Livewire\Component;

class VcNivelCalendar extends Component
{
    public $modalidadId;
    public $modalidad=[], $grado=[];
    public $tbldetails=[];

    protected $listeners = ['setGrabaDetalle'];

    public function mount()
    {
        $this->modalidad = TmGeneralidades::where('superior',1)->get();
        
    }
    
    public function render()
    {
        return view('livewire.vc-nivel-calendar');
    }

    public function updatedModalidadId($id)
    {
        $this->modalidadId = $id;
        $this->grado = TmServicios::query()
        ->join('tm_generalidades as g','g.id','=','tm_servicios.nivel_id')
        ->where('tm_servicios.modalidad_id',$id)
        ->selectRaw('g.descripcion as nivel, tm_servicios.descripcion as grado, tm_servicios.id')
        ->get();

        foreach ($this->grado as $recno){
            $array=[
                'seleccionar' => false,
                'nivel' => $recno['nivel'],
                'grado' => $recno['grado'],
                'grado_id' => $recno['id'],
            ];
            array_push($this->tbldetails,$array);
        }

    }

    public function checkall()
    {
        foreach($this->tbldetails as $key => $detail){
            $this->tbldetails[$key]['seleccionar'] = true;
        }

    }

    public function setGrabaDetalle($calendarioId)
    {
        
        foreach ($this->tbldetails as $index => $recno)
        {
            if ($recno['seleccionar']==true){

                TmCalendarioGrados::Create([
                    'calendario_id' => $calendarioId,
                    'modalidad_id' => $this->modalidadId,
                    'grado_id' => $recno['grado_id'],
                    'usuario' => auth()->user()->name,
                ]);

            }
        }

    }

}
