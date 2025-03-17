<?php

namespace App\Http\Livewire;
use App\Models\TmGeneralidades;
use App\Models\TmServicios;
use App\Models\TmCalendarioGrados;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class VcNivelCalendar extends Component
{
    public $modalidadId;
    public $modalidad=[], $grado=[];
    public $tbldetails=[];

    protected $listeners = ['setGrabaDetalle','setGrado'];

    public function mount($eventoId)
    {
        $this->modalidad = TmGeneralidades::where('superior',1)->get();
        if ($eventoId>0){
            dd($eventoId);
            $this->setGrado();
        }
        
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

    public function setGrado($eventoId)
    {

        $record = TmCalendarioGrados::query()
        ->where('calendario_id',$eventoId)
        ->first();

        $this->modalidadId = $record['modalidad_id'];

        $this->grado = TmCalendarioGrados::query()
        ->leftjoin(DB::raw("(select g.descripcion as nivel, s.descripcion as grado, s.id 
            from tm_servicios s
            inner join tm_generalidades as g on g.id = s.nivel_id
            where s.modalidad_id = ".$this->modalidadId."
        ) as f"),function($join){
            $join->on('f.id', '=', 'tm_calendario_grados.grado_id');
        })
        ->selectRaw('f.nivel, f.grado, f.id as gradoId, case when tm_calendario_grados.id > 0 then true else false end as seleccion')
        ->get();


        foreach ($this->grado as $recno){

            $array=[
                'seleccionar' => $recno['seleccion'],
                'nivel' => $recno['nivel'],
                'grado_id' => $recno['gradoId'],
                'grado_id' => $recno['id'],
            ];
            array_push($this->tbldetails,$array);
        }
        
        dd($this->tbldetails);

    }



}
