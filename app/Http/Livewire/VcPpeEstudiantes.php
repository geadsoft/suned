<?php

namespace App\Http\Livewire;
use App\Models\TmPpeEstudiantes;
use App\Models\TmGeneralidades;
use App\Models\TmPeriodosLectivos;
use App\Models\TmServicios;
use App\Models\TmMatricula;
use Livewire\WithPagination;

use Livewire\Component;

class VcPpeEstudiantes extends Component
{
    use WithPagination;

    public $fecha, $hora, $periodoId, $modalidadId, $gradoId;
    public $tbldetalle=[]; 
    public $tblgrados=[];

    public function mount()
    {
        $ldate = date('Y-m-d H:i:s');
        $this->fecha = date('Y-m-d',strtotime($ldate));
        $this->hora = date('H:i');

        $tblperiodos = TmPeriodosLectivos::where("aperturado",1)->first();
        $this->periodoId = $tblperiodos['id'];
    }
    
    public function render()
    {
        $tblgenerals = TmGeneralidades::all();
        
        $tblrecords = TmPpeEstudiantes::query()
        ->join("tm_generalidades as g","g.id","=","tm_ppe_estudiantes.modalidad_id")
        ->join("tm_servicios as s","s.id","=","tm_ppe_estudiantes.grado_id")
        ->join("tm_personas as p","p.id","=","tm_ppe_estudiantes.persona_id")
        ->select("p.identificacion","p.nombres","p.apellidos","g.descripcion as modalidad","s.descripcion as servicio")
        ->paginate(12);

        return view('livewire.vc-ppe-estudiantes',[
            'tblrecords' => $tblrecords,
            'tblgenerals' =>  $tblgenerals,
        ]);
    }

    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }

    public function updatedModalidadId($id){

        $this->tblgrados = TmServicios::query()
        ->where('modalidad_id',$id)
        ->where('nivel_id',11)
        ->get(); 

    }

    public function updatedGradoId($id){

        $this->tbldetalle=[];

       $personas = TmMatricula::query()
        ->join('tm_personas as p', 'p.id', '=', 'tm_matriculas.estudiante_id')
        ->leftJoin('tm_ppe_estudiantes as pp', 'pp.persona_id', '=', 'p.id')
        ->where('tm_matriculas.periodo_id', $this->periodoId)
        ->where('tm_matriculas.modalidad_id', $this->modalidadId)
        ->where('tm_matriculas.grado_id', $this->gradoId)
        ->whereNull('pp.persona_id') // 🔹 solo los que NO están en PPE
        ->orderBy('p.apellidos')
        ->select('p.*')
        ->get();
        
        foreach($personas as $index => $data){
            $this->tbldetalle[$index]['seleccion'] = 0;
            $this->tbldetalle[$index]['personaId'] = $data->id;
            $this->tbldetalle[$index]['nui'] = $data->identificacion;
            $this->tbldetalle[$index]['nombres'] = $data->apellidos.' '.$data->nombres;
        }
        
        $this->dispatchBrowserEvent('show-form');
    }


    public function createData(){

        foreach ($this->tbldetalle as $index => $detalle){

            if($detalle['seleccion']==1){
                
                TmPpeEstudiantes::Create([
                    'periodo_id' => $this->periodoId,
                    'modalidad_id' => $this->modalidadId,
                    'grado_id' => $this->gradoId,
                    'persona_id' => $detalle['personaId'],
                    'usuario' => auth()->user()->name,
                ]);

            }

        }

        $this->dispatchBrowserEvent('hide-form');
        $this->modalidadId="";
        $this->gradoId="";
    }

    public function seleccionar(){
        
        foreach ($this->tbldetalle as $index => $detalle){
            $this->tbldetalle[$index]['seleccion'] = 1;
        }

        $this->createData();

    }


}
