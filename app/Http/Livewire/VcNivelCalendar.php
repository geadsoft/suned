<?php

namespace App\Http\Livewire;
use App\Models\TmGeneralidades;
use App\Models\TmServicios;
use App\Models\TmCalendarioGrados;
use App\Models\TmCalendarioEventos; 

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class VcNivelCalendar extends Component
{
    public $modalidadId, $eventoId, $todos=true, $eControl='disabled';
    public $modalidad=[], $grado=[];
    public $tbldetails=[];

    protected $listeners = ['setGrabaDetalle','setGrado'];

    public function mount($idEvento)
    {
        $this->modalidad = TmGeneralidades::where('superior',1)->get();
        if ($idEvento>0){
            $this->setGrado();
        }
        
    }
    
    public function render()
    {
        return view('livewire.vc-nivel-calendar',[
            'tbldetails' => $this->tbldetails,
        ]);
    }

    public function updatedTodos($boolean)
    {
        if ($boolean){
            $this->eControl="disabled";
        }else{
            $this->eControl="";
        }
        
    }

    public function updatedModalidadId($id)
    {
        $this->tbldetails=[];
        
        $this->modalidadId = $id;
        $this->grado = TmServicios::query()
        ->join('tm_generalidades as g','g.id','=','tm_servicios.nivel_id')
        ->where('tm_servicios.modalidad_id',$id)
        ->selectRaw('g.descripcion as nivel, tm_servicios.descripcion as grado, tm_servicios.id')
        ->orderBy('tm_servicios.id')
        ->get();

        foreach ($this->grado as $recno){
            $array=[
                'seleccionar' => false,
                'id' => 0,
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

            if ($recno['id']>0 && $recno['seleccionar']==false){
                TmCalendarioGrados::find($recno['id'])->delete();
            }
            
            if ($recno['id']==0 && $recno['seleccionar']==true){

                TmCalendarioGrados::Create([
                    'calendario_id' => $calendarioId,
                    'modalidad_id' => $this->modalidadId,
                    'grado_id' => $recno['grado_id'],
                    'usuario' => auth()->user()->name,
                ]);

            }

        }

        $record = TmCalendarioEventos::find($calendarioId);
        $record->update([
            'todos' => $this->todos,            
        ]);

        $this->eControl=true;
    }

    public function setGrado($idEvento)
    {

        $this->tbldetails = [];
        $this->eventoId  = $idEvento;
        $this->modalidad = TmGeneralidades::where('superior',1)->get();

        if ($this->eventoId>0){

            $calendario = TmCalendarioEventos::find($idEvento);
            $this->todos = $calendario->todos;

            if ($this->todos==true){
                $this->modalidadId = 0;
            }else{
                $record = TmCalendarioGrados::query()
                ->where('calendario_id',$this->eventoId)
                ->first();

                $this->modalidadId = $record['modalidad_id'];
            }
        
        }else{
            $this->modalidadId = 0;
        }

        $this->grado = TmCalendarioGrados::query()
        ->rightjoin(DB::raw("(select g.descripcion as nivel, s.descripcion as grado, s.id 
            from tm_servicios s
            inner join tm_generalidades as g on g.id = s.nivel_id
            where s.modalidad_id = ".$this->modalidadId."
        ) as f"),function($join){
            $join->on('f.id', '=', 'tm_calendario_grados.grado_id');
            $join->where('tm_calendario_grados.calendario_id',$this->eventoId);
        })
        ->selectRaw('f.nivel, f.grado, f.id as gradoId, case when tm_calendario_grados.id > 0 then true else false end as seleccion, ifnull(tm_calendario_grados.id,0) as id')
        ->orderBy('f.id')
        ->get();

        foreach ($this->grado as $recno){
            
            $seleccionar = false;
            if ($recno['seleccion']==1){
                $seleccionar = true;
            }

            $array=[
                'id' => $recno['id'],
                'seleccionar' => $seleccionar,
                'nivel' => $recno['nivel'],
                'grado' => $recno['grado'],
                'grado_id' => $recno['gradoId'],
            ];
            array_push($this->tbldetails,$array);
        }

        $this->updatedTodos($this->todos);
        
    }



}
