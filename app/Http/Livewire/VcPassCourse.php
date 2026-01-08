<?php

namespace App\Http\Livewire;
use App\Models\TmGeneralidades;
use App\Models\TmPeriodosLectivos;
use App\Models\TmServicios;
use App\Models\TmCursos;
use App\Models\TmMatricula;
use App\Models\TmPaseCursos;


use Livewire\Component;

class VcPassCourse extends Component
{   
    public $matriculaId, $personaId, $persona;
    public $selectedCourse=null;
    public $periodoId, $periodo;
    public $grupoId, $pase_grupoId;
    public $tblcursos=null, $tblcursos_pase=null;
    public $tblservicios=null, $tblservicios_pase=null;
    public $nivelId, $pase_nivelId;
    public $gradoId, $pase_gradoId;
    public $cursoId, $pase_cursoId;
    public $paseId=null;
    public $datos =[
        'grupoId' => 0,
        'periodoId' => 0,
        'nivelId' => 0,
        'gradoId' => 0,
        'seccionId' => 0,
    ];

    protected $listeners = ['setPersona','setGrabar'];
   
    public function mount(){

        $tblperiodos = TmPeriodosLectivos::where("aperturado",1)->first();
        $this->periodoId = $tblperiodos['id'];
        $this->periodo = $tblperiodos['descripcion'];
    }


    public function render()
    {   
        $tblgenerals = TmGeneralidades::all();
        $q1 = TmPaseCursos::query()
        ->join('tm_matriculas as m','m.id','=','tm_pase_cursos.matricula_id')
        ->join('tm_servicios as s','s.id','=','m.grado_id')
        ->join('tm_generalidades as g','g.id','=','m.modalidad_id') 
        ->join('tm_cursos as c','c.id','=','m.curso_id')        
        ->selectRaw("m.documento,s.descripcion, g.descripcion as nomModalidad, c.paralelo, tm_pase_cursos.*")
        ->whereNull('curso_anterior');  // equivalente a curso_anterior is null

        $q2 = TmPaseCursos::query()
        ->join('tm_pase_cursos as pa','pa.id','=','tm_pase_cursos.curso_anterior')
        ->join('tm_matriculas as m','m.id','=','pa.matricula_id')
        ->join('tm_servicios as s','s.id','=','pa.grado_id')
        ->join('tm_generalidades as g','g.id','=','pa.modalidad_id') 
        ->join('tm_cursos as c','c.id','=','pa.curso_id')
        ->selectRaw("m.documento,s.descripcion, g.descripcion as nomModalidad, c.paralelo, tm_pase_cursos.*") 
        ->where('tm_pase_cursos.curso_anterior','>',0);

        // unir con unionAll
        $tblrecords = $q1->unionAll($q2)
            ->orderBy('estudiante_id')
            ->orderByDesc('created_at')
            ->get();

            return view('livewire.vc-pass-course',[
            'tblgenerals' => $tblgenerals,
            'tblrecords' => $tblrecords
        ]);
    }

    public function updatedgrupoId($id){
        $this->datos['grupoId'] =  $id;
    }

    public function updatedperiodoId($id){
        $this->datos['periodoId'] =  $id;

        /* Mantiene Deuda */
        $this->deudas = TrDeudasCabs::query()
        ->join("tm_periodos_lectivos as p","p.id","=","tr_deudas_cabs.periodo_id")
        ->selectRaw("p.descripcion, sum(saldo) as monto")
        ->where("tr_deudas_cabs.estudiante_id",$this->estudiante_id)
        ->where("tr_deudas_cabs.periodo_id","<>",$this->id)
        ->groupBy("p.descripcion")
        ->get()->toArray();
        
    }

    public function updatednivelId($id){

        $this->datos['nivelId'] =  $id;        
        
        $this->tblservicios = TmServicios::where([
            ['nivel_id',$id],
            ['modalidad_id',$this->grupoId],
        ])->get();

    }

    public function updatedgradoId($id){

        $this->datos['gradoId'] =  $id; 

        $this->tblcursos = TmCursos::where([
                ['periodo_id',$this->periodoId],
                ['servicio_id',$id],
            ])->get();

    }

    public function updatedcursoId($id){
        
        $this->datos['seccionId'] =  $id;

    }

    public function buscar(){

        $this->dispatchBrowserEvent('show-form');
    }

    public function setPersona($matriculaId){

        $matricula = TmMatricula::find($matriculaId);
        $this->matriculaId = $matricula->id;

        $this->grupoId = $matricula->modalidad_id;
        $this->nivelId = $matricula->nivel_id;
        $this->updatednivelId($this->nivelId);
        $this->gradoId = $matricula->grado_id;
        $this->updatedgradoId($this->gradoId);
        $this->cursoId = $matricula->curso_id;
        $this->personaId = $matricula->estudiante_id;
        $this->persona = $matricula->estudiante->nombres.' '.$matricula->estudiante->apellidos;
        $this->paseId  = 0;
        
        $pase = TmPaseCursos::query()
        ->where("matricula_id",$this->matriculaId)
        ->orderby("created_at","desc")
        ->first();

        if ($pase){

            $this->paseId  = $pase->id;
            $this->grupoId = $pase->modalidad_id;
            $this->nivelId = $pase->nivel_id;
            $this->updatednivelId($this->nivelId);
            $this->gradoId = $pase->grado_id;
            $this->updatedgradoId($this->gradoId);
            $this->cursoId = $pase->curso_id;
        }      

    }
    
    public function asignacurso(){

        $this->pase_nivelId = $this->nivelId;
        
        $this->tblservicios_pase = TmServicios::where([
            ['nivel_id',$this->pase_nivelId],
            ['modalidad_id',$this->pase_grupoId],
        ])->get();

    }

    public function asignaseccion(){

        $this->tblcursos_pase = TmCursos::where([
            ['periodo_id',$this->periodoId],
            ['servicio_id',$this->pase_gradoId],
        ])->get();
        
    }

     public function createData(){

         $this ->validate([
            'periodoId' => 'required',
            'pase_grupoId' => 'required',
            'pase_nivelId' => 'required',
            'pase_gradoId' => 'required',
            'pase_cursoId' => 'required',
            'personaId' => 'required',
            'matriculaId' => 'required',
        ]);

        $message = "";
        $this->dispatchBrowserEvent('msg-confirm', ['newName' => $message]);
            
    }

    public function setGrabar(){


        TmPaseCursos::Create([
            'matricula_id' => $this -> matriculaId,
            'estudiante_id' => $this -> personaId,
            'modalidad_id' => $this->pase_grupoId, 
            'nivel_id' => $this -> pase_nivelId,
            'grado_id' => $this ->pase_gradoId,
            'curso_id' => $this -> pase_cursoId,
            'curso_anterior' => $this->paseId == 0 ? null : $this->paseId,
            'usuario' => auth()->user()->name,
            'estado' => "A",
        ]);

        if ($this->paseId>0){

            $pase = TmPaseCursos::find($this->paseId);
            $pase->update([
                'estado' => 'I',
            ]);
            
        }   
        
        $message = "Cambio de Modalidad grabada con Éxito......";
        $this->dispatchBrowserEvent('msg-grabar', ['newName' => $message]);

        return redirect()->to('/academic/pass-course');

    }

}
