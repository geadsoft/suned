<?php

namespace App\Http\Livewire;
use App\Models\TmPensionesCab;
use App\Models\TmPensionesDet;
use App\Models\TmGeneralidades;
use App\Models\TmPeriodosLectivos;

use Livewire\Component;
use Livewire\WithPagination;

class VcPension extends Component
{
    
    use WithPagination;
    public $showEditModal = false;
    public $visible = "";
    public $selectId;
    public $record;
    public $count=1; 
    public array $tblvalores = []; 
    public $fecha;

    public function mount(){
        $ldate = date('Y-m-d H:i:s');
        $this->fecha = date('Y-m-d',strtotime($ldate));
    }
    
    public function render()
    {
        
        $tblrecords  = TmPensionesCab::orderBy("periodo_id","desc")->paginate(10);
        $tblgenerals = TmGeneralidades::all();
        $tblperiodos = TmPeriodosLectivos::orderBy("periodo","desc")->get();
        
        return view('livewire.vc-pension',[
            'tblrecords' => $tblrecords,
            'tblgenerals'=> $tblgenerals,
            'tblperiodos' => $tblperiodos,
        ]);
           
    }

    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }

    public function add(){

        $tblniveles  = TmGeneralidades::where('superior',2)->get();

        $this->showEditModal = false;
        $this->reset(['record']);
        $this->reset(['tblvalores']);
        $this->record['descripcion']= "";
        $this->record['fecha']= $this->fecha;
        $this->record['periodo_id']= 0;
        $this->record['modalidad_id']= 0;
        $this->record['estado']= "A";
        
        $this->loadDetalle($tblniveles);
        $this->dispatchBrowserEvent('show-form');

    }

    protected $listeners = ['postAdded'];

    public function postAdded($objData=Null)
    {

        TmPensionesCab::Create([
            'descripcion' => $this -> record['descripcion'],
            'fecha' => $this -> record['fecha'],
            'periodo_id' => $this -> record['periodo_id'],
            'modalidad_id' => $this -> record['modalidad_id'],
            'estado' => $this -> record['estado'],
            'usuario' => auth()->user()->name,
        ]);

        $tbldata=TmPensionesCab::orderBy("id","desc")->first();

        foreach ($objData as $detalle)
        {
            
            TmPensionesDet::Create([
            'pension_id' =>  $tbldata['id'],  
            'nivel_id' => $detalle['id'],
            'matricula' => $detalle['matricula'],
            'matricula2' => $detalle['matricula2'],
            'pension' => $detalle['pension'],
            'eplataforma' => $detalle['eplataforma'],
            'iplataforma' => $detalle['iplataforma'],
            'estado' => "A",
            'usuario' => auth()->user()->name,
            ]);
            
        }     
        
        $this->dispatchBrowserEvent('hide-form', ['message'=> 'added successfully!']);

    }
 
    public function edit(TmPensionesCab $tblrecords ){
        
        $this->showEditModal = true;
        $this->visible = "";
        $this->record  = $tblrecords->toArray();
        $this->record['fecha'] = date('Y-m-d',strtotime($this->record['fecha']));
        $this->selectId = $this -> record['id'];
        $this->reset(['tblvalores']);

        $tblniveles  = TmPensionesDet::where('pension_id',$this->selectId)->get();

        $this->loadDetalle($tblniveles);
        
        $this->dispatchBrowserEvent('show-form');

    }


    public function view(TmPensionesCab $tblrecords ){
        
        $this->showEditModal = true;
        $this->visible = "display: none";
        $this->record  = $tblrecords->toArray();      
        $this->selectId = $this -> record['id'];
        $this->reset(['tblvalores']);

        $tblniveles =  TmPensionesDet::where('pension_id',$this->selectId)->get();
        
        $this->loadDetalle($tblniveles);

        $this->dispatchBrowserEvent('show-form');

    }
    
    
    public function delete( $id ){
        
        $this->selectId = $id;
        $this->dispatchBrowserEvent('show-delete');

    }

    public function loadDetalle($dataDet){

        $tblData = [];
        $matricula = 0.00;
        $matricula2 = 0.00;
        $pension = 0.00;
        $eplataforma = 0.00;
        $iplataforma = 0.00;
        
        foreach ($dataDet as $general)
        {   
            if ($this->showEditModal==true){
                $id = $general->nivel_id;
                $nombre = $general->nivel->descripcion;
                $matricula = $general->matricula;
                $matricula2 = $general->matricula2;
                $pension = $general->pension;
                $eplataforma = $general->eplataforma;
                $iplataforma = $general->iplataforma;

            }else{
                $id = $general->id;
                $nombre = $general->descripcion;
            }

            $arrayData = [
                'nivel_id' => $id,
                'descripcion' => $nombre,
                'matricula' => $matricula,
                'matricula2' => $matricula2,
                'pension' => $pension,
                'eplataforma'  => $eplataforma,
                'iplataforma'  => $iplataforma,
            ];

            array_push($this->tblvalores,$arrayData);
        }
                
    }


    /* Proceso */

    public function createData(){

        $this ->validate([
            'record.descripcion' => 'required',
            'record.fecha' => 'required',
            'record.periodo_id' => 'required',
            'record.modalidad_id' => 'required',
        ]);
        
        $this->dispatchBrowserEvent('save-det', ['message'=> 'added successfully!']);  
        
    }    

    public function updateData(){

        $this ->validate([
            'record.nombre' => 'required',
            'record.periodo_id' => 'required',
            'record.modalidad_id' => 'required',
        ]);        
        
        if ($this->selectId){
            $record = TmPensionesCab::find($this->selectId);
            $record->update([
                'nombre' => $this -> record['nombre'],
                'periodo_id' => $this -> record['periodo_id'],
                'modalidad_id' => $this -> record['modalidad_id'],
            ]);
            
        }
      
        $this->dispatchBrowserEvent('hide-form', ['message'=> 'added successfully!']);
        
    }

    public function deleteData(){
        TmPensionesCab::find($this->selectId)->delete();
        $this->dispatchBrowserEvent('hide-delete');
    }



}
