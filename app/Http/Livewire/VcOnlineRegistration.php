<?php

namespace App\Http\Livewire;
use App\Models\TmGeneralidades;
use App\Models\TmPersonas;
use App\Models\TmFamiliarEstudiantes;
use App\Models\TmPeriodosLectivos;
use App\Models\TmServicios;
use App\Models\TmCambiaModalidad;

use Livewire\Component;

class VcOnlineRegistration extends Component
{
    public $estudianteId, $modalidad, $search_nui, $cursos=[];
    public $persona=[];
    public $periodos=[];
    public $arrfamiliar=[];
    public $servicios=[];

    public $matricula=[
        'modalidad' => "",
        'periodo' => "",
        'nivel' => "",
        "curso" => "",
    ];
    
    public function mount()
    { 
        $this->estudianteId = auth()->user()->personaId;
        $this->loadPersonas('E');

        $this->periodos = TmPeriodosLectivos::query()
        ->where('estado','I')
        ->orderBy('periodo','desc')
        ->get();

        $periodo =  $this->periodos->first(); 
        $this->matricula['periodo'] = $periodo->id;
        
    }
    
    
    public function render()
    {   
        $modalidad = TmGeneralidades::where('superior',1)->get();
        
        $nivel = TmGeneralidades::where('superior',2)
        ->when($this->matricula['nivel'],function($query){
            return $query->where('id',">=","{$this->matricula['nivel']}");
        })
        ->get();

        $tblgenerals = TmGeneralidades::where('superior',7)
        ->get();

        $tblfamilys  = TmFamiliarEstudiantes::query()
        ->join("tm_personas as p","p.id","=","tm_familiar_estudiantes.persona_id")
        ->where('estudiante_id',"{$this->estudianteId}")
        ->select('tm_familiar_estudiantes.id','persona_id','apellidos','nombres','tipoidentificacion','identificacion','nacionalidad_id','genero','telefono','direccion','email','parentesco')
        ->get();

        return view('livewire.vc-online-registration',[
            'modalidad' => $modalidad,
            'nivel' => $nivel,
            'tblgenerals' => $tblgenerals,
            'tblfamilys' => $tblfamilys,
        ]);
    }


    public function loadPersonas($tipo)
    {
        if($tipo=="E"){
            $this->persona =  TmPersonas::find($this->estudianteId)->toArray();
        }else{
            $this->personr =  TmPersonas::where('identificacion',$this->search_nui)->first()->toArray();
        }         
    }

    public function validaNui(){
        
    }

    public function updatedModalidad ($value){

        $this->cursos = [];

        $tmpcursos = TmCambiaModalidad::query()
        ->join("tm_cursos as c","c.id","=","tm_cambia_modalidad.curso_id")
        ->select("c.grupo_id","c.nivel_id","c.grado_id")
        ->where("persona_id",$this->estudianteId)
        ->first();

        $tmservicios = TmServicios::select(
            'g.codigo as nivel_codigo',
            'g.descripcion as nivel_descripcion',
            'g2.codigo as grado_codigo',
            'g2.descripcion as grado_descripcion',
            'tm_servicios.especializacion_id',
            'tm_servicios.modalidad_id',
            'tm_servicios.nivel_id',
            'tm_servicios.grado_id',
            'tm_servicios.descripcion as servicio_descripcion',
            'tm_servicios.id as servicio_id'
        )
        ->join('tm_generalidades as g', 'g.id', '=', 'tm_servicios.nivel_id')
        ->join('tm_generalidades as g2', 'g2.id', '=', 'tm_servicios.grado_id')
        ->where('tm_servicios.modalidad_id', $value)
        ->where('g.id', '>=', $tmpcursos->nivel_id)
        ->where('g2.id', '>', $tmpcursos->grado_id)
        ->orderBy('tm_servicios.modalidad_id')
        ->orderBy('g.codigo')
        ->orderBy('tm_servicios.especializacion_id')
        ->orderBy('g2.codigo')
        ->get();

        
        
        $maxNivel = $tmservicios->max('nivel_id');
        foreach($tmservicios as $recno){
            $this->cursos[] = $recno;
        }
        
        $tmservicios = TmServicios::select(
            'g.codigo as nivel_codigo',
            'g.descripcion as nivel_descripcion',
            'g2.codigo as grado_codigo',
            'g2.descripcion as grado_descripcion',
            'tm_servicios.especializacion_id',
            'tm_servicios.modalidad_id',
            'tm_servicios.nivel_id',
            'tm_servicios.grado_id',
            'tm_servicios.descripcion as servicio_descripcion',
            'tm_servicios.id as servicio_id'
        )
        ->join('tm_generalidades as g', 'g.id', '=', 'tm_servicios.nivel_id')
        ->join('tm_generalidades as g2', 'g2.id', '=', 'tm_servicios.grado_id')
        ->where('tm_servicios.modalidad_id', $value)
        ->where('g.id', '>', $maxNivel)
        ->where('g2.id', '>=', 15)
        ->orderBy('tm_servicios.modalidad_id')
        ->orderBy('g.codigo')
        ->orderBy('tm_servicios.especializacion_id')
        ->orderBy('g2.codigo')
        ->get();

        foreach($tmservicios as $recno){
            $this->cursos[] = $recno;
        }
        
        $this->matricula['modalidad'] = $value;
        $this->matricula['nivel'] = $tmpcursos->nivel_id;
    }

    public function updatedMatriculaNivel($value){

    }

}
