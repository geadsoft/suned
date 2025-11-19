<?php

namespace App\Http\Livewire;
use App\Models\TmPeriodosLectivos;
use App\Models\TmMatricula;

use Livewire\Component;
use Livewire\WithPagination;

class VcPeriods extends Component
{   
    use WithPagination;

    public $showEditModal = false;
    public $frmcontrol = 'enabled';
    public $selectId;
    public $record=[];
    public $codigo,$periodo;
    public $estado=[
        'A' => 'Activo',
        'C' => 'Cerrado',
        'I' => 'Inactivo',
    ];

    public $meses=[
        1=> 'Enero',
        2=> 'Febrero',
        3=> 'Marzo',
        4=> 'Abril',
        5=> 'Mayo',
        6=> 'Junio',
        7=> 'Julio',
        8=> 'Agosto',
        9=> 'Septiembre',
        10=> 'Octubre',
        11=> 'Noviembre',
        12=> 'Diciembre',
    ];

    public function mount(){

        $data   = TmPeriodosLectivos::where('estado','A')->first();
        $this->codigo = intval($data['periodo']);
    }

    public function render()
    {
        
        $tblrecords = TmPeriodosLectivos::query()
        ->orderBy('periodo','desc')->paginate(13);
        
        return view('livewire.vc-periods',[
            'tblrecords' => $tblrecords,
        ]);
        
    }

    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }

    public function add(){
        
        $this->showEditModal = false;
        $this->frmcontrol = 'enabled';
        $this->reset(['record']);
        $this->record['periodo']= $this->codigo+1;
        $this->record['descripcion']= strval($this->codigo+1).'-'.strval($this->codigo+2);
        $this->record['sede']= 1;
        $this->record['num_recibo']= 0;
        $this->record['num_matricula']= 0;
        $this->record['mes_pension']= 5;
        $this->record['estado']= 'I';     
        $this->record['fecha_empieza']= '';
        $this->record['fecha_termina']= '';
        $this->dispatchBrowserEvent('show-form');

    }

    public function edit(TmPeriodosLectivos $tblrecords ){
        
        $this->showEditModal = true;
        $this->frmcontrol='enable';
        $this->record  = $tblrecords->toArray();
       
        $this->selectId = $this -> record['id'];

        if ($this->record['estado']=='C'){
            $this->frmcontrol='disabled';
        }

        $this->dispatchBrowserEvent('show-form');

    }

    public function delete( $id ){
    
        $this->selectId = $id;
        $data = TmPeriodosLectivos::find($this->selectId);
        $this->periodo = $data['descripcion'];
        
        $record = TmMatricula::where('periodo_id',$this->selectId)->get()->toArray();
        
        if(!empty($record)){
            $message = "Periodo no puede eliminarse, existen registros";
            $this->dispatchBrowserEvent('msg-form', ['newName' => $message]);
        }else{
            $this->dispatchBrowserEvent('show-delete');
        }

    }


    public function createData(){
        
        $this ->validate([
            'record.descripcion' => 'required',
            'record.periodo' => 'required',
            'record.mes_pension' => 'required',
            'record.fecha_empieza' => 'required',
            'record.fecha_termina' => 'required',
        ]);


        $data = TmPeriodosLectivos::where('periodo',$this->record['periodo'])->first();

        if($data!=null){
            $message = "Periodo ya se encuentra registrado!";
            $this->dispatchBrowserEvent('msg-form', ['newName' => $message]);
        }else{

            TmPeriodosLectivos::Create([
                'sede_id' => $this -> record['sede'],
                'periodo' => $this -> record['periodo'],
                'descripcion' => $this -> record['descripcion'],
                'mes_pension' => $this -> record['mes_pension'],
                'rector_id' => 0,
                'secretaria_id' =>0,
                'coordinador_id' =>0,
                'estado' => $this -> record['estado'],
                'fecha_empieza' => $this -> record['fecha_empieza'],
                'fecha_termina' => $this -> record['fecha_termina'],
                'evaluacion' => '',
                'evaluacion_formativa' => 0,
                'evaluacion_sumativa' => 0,
                'usuario' => auth()->user()->name,
            ]);

            $message = "Registro grabado con éxito!";
            $this->dispatchBrowserEvent('msg-grabar', ['newName' => $message]);

        }

        $this->dispatchBrowserEvent('hide-form');
        
    }

    public function updateData(){

        $this ->validate([
            'record.id' => 'required',
            'record.periodo' => 'required',
            'record.descripcion' => 'required',
            'record.mes_pension' => 'required',
            'record.estado'=> 'required',   
            'record.fecha_empieza' => 'required',
            'record.fecha_termina' => 'required',        
        ]);
        
        /*$data = TmPeriodosLectivos::where('estado','A')->first();

        if(!empty($data) & $this->record['estado']=='A'){
            $message = "Existe periodo aperturado, debe cerrar periodo!";
            $this->dispatchBrowserEvent('msg-form', ['newName' => $message]);

            $this->dispatchBrowserEvent('hide-form');
            return;
        }*/
        
        if ($this->selectId){
            
            $record = TmPeriodosLectivos::find($this->selectId);
            $record->update([
                'descripcion' => $this -> record['descripcion'],
                'mes_pension' => $this -> record['mes_pension'],
                'estado' => $this -> record['estado'],
                'fecha_empieza' => $this -> record['fecha_empieza'],
                'fecha_termina' => $this -> record['fecha_termina'],
            ]);
            
        }
      
        $this->dispatchBrowserEvent('hide-form');

        $message = "Registro actualizado con éxito!";
        $this->dispatchBrowserEvent('msg-grabar', ['newName' => $message]);
        
        
    }


    
    public function deleteData(){

        TmPeriodosLectivos::find($this->selectId)->delete();
        $this->dispatchBrowserEvent('hide-delete');
    }


}
