<?php

namespace App\Http\Livewire;
use App\Models\TmPersonas;
use App\Models\TdFacturaEstudiantes;
use App\Models\TmGeneralidades;

use Livewire\Component;

class VcPersonsBilling extends Component
{
    
    public $personaId, $familiarId, $editControl = false, $search_nui;
    public $familiares, $familiar, $exists = false, $error=0;
    public $eControl2 = 'disabled';
    public $tblgenerals;
    public $relacion = [
        'MA' => 'Madre',
        'PA' => 'Padre',
        'AP' => 'Apoderado',
        'OT' => 'Otro',
        'NN' => 'Selecione Relacion',
    ];
    
    protected $listeners = ['setGrabaFactura'];

    public function mount($personaId)
    {

        $this->tblgenerals = TmGeneralidades::where('superior',7)->get();

        if($personaId>0){
            $this->personaId = $personaId;
            $this->loadFamiliar();
        }else{
            $this->familiares = [];
            $this->eControl2 = '';
        }

        
    }


    public function render()
    {
        return view('livewire.vc-persons-billing',[
            'familiares' => $this->familiares
        ]);
    }

    public function loadFamiliar(){

        $this->familiares = TdFacturaEstudiantes::query()
        ->join("tm_personas as p","p.id","=","td_factura_estudiantes.persona_id")
        ->where('estudiante_id',$this->personaId)
        ->selectRaw('p.id,p.nombres,p.apellidos,p.tipoidentificacion,p.identificacion,p.genero,p.nacionalidad_id,p.telefono,p.parentesco,p.email,p.direccion,p.tipopersona')
        ->get()->toArray(); 

    }

    public function loadNui(){

        $this->error=0;
        $records = TmPersonas::where("identificacion",$this->search_nui)->first();
        if (!empty($records)){

            $this->familiarId = $records['id'];
            $this->familiar = TmPersonas::find($this->familiarId)->toArray();
            $this->exists = true;
            
        }

    }

    public function newData(){

        $this->familiarId = 0;
        $this->familiar['id'] = 0;
        $this->familiar['nombres'] = '';
        $this->familiar['apellidos'] = '';
        $this->familiar['tipoidentificacion'] = 'C';
        $this->familiar['identificacion'] = '';
        $this->familiar['genero'] = '';
        $this->familiar['nacionalidad_id'] = 35;
        $this->familiar['telefono'] = '';
        $this->familiar['parentesco'] = 'NN';
        $this->familiar['email'] = '';
        $this->familiar['direccion'] = '';
        $this->eControl2 = '';
        $this->editControl = false;
        
    }

    public function editData($familiarId){

        $this->familiarId = $familiarId;
        $this->familiar = TmPersonas::find($familiarId)->toArray();
        $this->eControl2 = '';
        $this->editControl = true;
        
    }

    public function setGrabaFactura($personaId){


        foreach ($this->familiares as $index => $recno)
        {
           
            if ($recno['id']>0){

                $record = TmPersonas::find($recno['id']);

                if ($record['tipopersona']!='F'){

                    $recno['nombres'] = $record['nombres'];
                    $recno['apellidos'] = $record['apellidos'];   
                    $recno['tipoidentificacion'] =  $record['tipoidentificacion'];  
                    $recno['identificacion'] =  $record['identificacion'];
                    $recno['genero'] = $record['genero']; 
                    $recno['telefono'] =  $record['telefono'];  
                    $recno['direccion'] = $record['direccion'];  
                    $recno['email'] = $record['email'];

                }

                $record->update([
                    'nombres' => $recno['nombres'],
                    'apellidos' => $recno['apellidos'],
                    'tipoidentificacion' => $recno['tipoidentificacion'],
                    'identificacion' => $recno['identificacion'],
                    'genero' => $recno['genero'],
                    'telefono' => $recno['telefono'],
                    'direccion' => $recno['direccion'],
                    'email' => $recno['email'],
                    ]);

                $factura = TdFacturaEstudiantes::query()
                ->where("estudiante_id",$personaId)
                ->where("persona_id",$recno['id'])
                ->first();

                if (empty($factura)){

                    TdFacturaEstudiantes::Create([
                        'estudiante_id'=> $personaId,
                        'persona_id'=> $recno['id'],
                        'informacion'=>'',
                        'usuario' => auth()->user()->name,
                    ]);

                }

            }else{

                $records = TmPersonas::where("identificacion",$recno['identificacion'])->first();


                if (!empty($records)){
                    
                    TdFacturaEstudiantes::Create([
                        'estudiante_id'=> $personaId,
                        'persona_id'=> $records['id'],
                        'informacion'=>'',
                        'usuario' => auth()->user()->name,
                    ]);

                }else{

                    $familiar = TmPersonas::Create([
                        'nombres' => $recno['nombres'],
                        'apellidos' => $recno['apellidos'],
                        'tipoidentificacion' => $recno['tipoidentificacion'],
                        'identificacion' => $recno['identificacion'],
                        'genero' => '',
                        'fechanacimiento' => "1900-01-01",
                        'nacionalidad_id' => $recno['nacionalidad_id'],
                        'telefono' => $recno['telefono'],
                        'email' => $recno['email'],
                        'etnia' => "",
                        'parentesco' => $recno['parentesco'],
                        'tipopersona' => "F",
                        'relacion_id' => 0,
                        'direccion' => $recno['direccion'],
                        'usuario' => auth()->user()->name,
                        'estado' => "A",
                    ]);

                    TdFacturaEstudiantes::Create([
                        'estudiante_id'=> $personaId,
                        'persona_id'=> $familiar['id'],
                        'informacion'=>'',
                        'usuario' => auth()->user()->name,
                    ]);
                }
            }


        }

        
    }

    public function createData(){


        $values = array_values($this->familiar);
        $this->error = 0;

        for ($i = 1; $i <= 10; $i++) {
            if ($values[$i]==""){
                $this->error = $this->error+1;
            }
        }
        
        if ($this->error==0){

            $recnoToDelete = $this->familiares;
            foreach ($recnoToDelete as $index => $recno)
            {
                if ($recno['id'] == $this->familiarId){
                    unset ($recnoToDelete[$index]);
                } 
            }
            $this->reset(['familiares']);
            $this->familiares = $recnoToDelete;

            array_push($this->familiares,$this->familiar);
            $this->newData();

        }


    }

    public function updateData(){

        $record = TmPersonas::find($this->familiarId);
        $record->update([
            'nombres' => $this->familiar['nombres'],
            'apellidos' => $this->familiar['apellidos'],
            'tipoidentificacion' => $this->familiar['tipoidentificacion'],
            'identificacion' => $this->familiar['identificacion'],
            'genero' => $this->familiar['genero'],
            'telefono' => $this->familiar['telefono'],
            'direccion' => $this->familiar['direccion'],
            'email' => $this->familiar['email'],
            ]);

        $factura = TdFacturaEstudiantes::query()
        ->where("estudiante_id",$this->personaId)
        ->where("persona_id",$this->familiarId)
        ->first();

        if (empty($factura)){

            TdFacturaEstudiantes::Create([
                'estudiante_id'=> $this->personaId,
                'persona_id'=> $this->familiarId,
                'informacion'=>'',
                'usuario' => auth()->user()->name,
            ]);

        }
         
        $this->newData(); 
        $this->loadFamiliar();
        $this->eControl2 = 'disabled'; 
        $this->exists = false;
    }

    public function deleteData($familiarId){

        TdFacturaEstudiantes::where('persona_id',$familiarId)->delete();
        TmPersonas::find($familiarId)->delete();
        
        $this->loadFamiliar();

    }


}
