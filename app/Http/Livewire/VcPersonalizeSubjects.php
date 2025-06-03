<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\TmPeriodosLectivos;
use App\Models\TmHorarios;
use App\Models\TmPersonalizaAsignaturas;

use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class VcPersonalizeSubjects extends Component
{
    use WithFileUploads;

    public $fileimg, $foto;
    public $imagen;
    public $docenteId, $periodoId;
    public $array_materias=[];
    
    public function mount()
    {
        $this->docenteId = auth()->user()->personaId;

        $tblperiodos = TmPeriodosLectivos::where("aperturado",1)->first();
        $this->periodoId = $tblperiodos['id'];

        $this->asignaturas();
        $this->loadData();
    }
    
    public function render()
    {        
        return view('livewire.vc-personalize-subjects');
    }

    public function asignaturas()
    {   
        $asignatura = TmHorarios::query()
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as a","a.id","=","d.asignatura_id")
        ->select("a.id","a.descripcion")
        ->where("tm_horarios.periodo_id",$this->periodoId)
        ->where("d.docente_id",$this->docenteId)
        ->groupby("a.id","a.descripcion")
        ->get();


        foreach($asignatura as $recno){

            $array = [
                'id' => $recno->id,
                'nombre' => $recno->descripcion,
                'fileimg' => '',
                'imagen' => '',
                'ruta' => '',
                'abreviatura' => 'SN',
                'personaliza_id' => 0,
            ];
            array_push($this->array_materias,$array);
        }

    }

    public function loadData()
    {   
        $tblrecord = TmPersonalizaAsignaturas::query()
        ->where('periodo_id',$this->periodoId)
        ->get();

        foreach($this->array_materias as $key => $materia){
            foreach($tblrecord as $record){
                if($record->asignatura_id==$materia['id']){
                    
                    $this->array_materias[$key]['ruta'] = $record->imagen;
                    $this->array_materias[$key]['imagen'] = $record->nombre;
                    $this->array_materias[$key]['abreviatura'] = $record->abreviatura;
                    $this->array_materias[$key]['personaliza_id'] = $record->id;
                }
            }
        }


    }

    public function grabar()
    {
        
        foreach($this->array_materias as $materias){

            $pathfile = '';
            $nameFile = '';
            $this->fileimg = $materias['fileimg'];
            
            if($materias['fileimg'] ?? null){
                $this ->validate([
                    'fileimg' => ['image', 'mimes:jpg,jpeg,png', 'max:1024'],
                    ]);

                $nameFile = $materias['fileimg']->getClientOriginalName();
                $contents = Storage::disk('public')->exists('asignatura/'.$nameFile);
                if ($contents){
                    Storage::disk('public')->delete('asignatura/'.$nameFile);
                    
                }

                //Elimino foto anterior
                $contents = Storage::disk('public')->exists('asignatura/'.$materias['imagen']);
                if ($contents){
                    Storage::disk('public')->delete('asignatura/'.$materias['imagen']);
                }

                $pathfile = 'storage/'.$materias['fileimg']->storeAs('public/asignatura', $nameFile);
                                
            }

            if ($materias['personaliza_id']>0){

                if($materias['fileimg'] == ''){
                    $pathfile = $materias['ruta'];
                    $nameFile = $materias['imagen'];
                }

                $recno = TmPersonalizaAsignaturas::find($materias['personaliza_id']);
                $recno->update([
                    'nombre' => $nameFile,
                    'imagen' => $pathfile,
                    'abreviatura' => $materias['abreviatura'],
                ]);

            }else{
                
                $recno = TmPersonalizaAsignaturas::Create([
                    'periodo_id' => $this->periodoId,
                    'asignatura_id' => $materias['id'],
                    'nombre' => $nameFile,
                    'imagen' => $pathfile,
                    'abreviatura' => $materias['abreviatura'],
                ]);

            }

        }
        
        $message = "Registro actualizados con éxito!";
        $this->dispatchBrowserEvent('msg-grabar', ['newName' => $message]);
        
    }


}
