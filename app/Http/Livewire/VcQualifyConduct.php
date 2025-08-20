<?php

namespace App\Http\Livewire;
use App\Models\TmPeriodosLectivos;
use App\Models\TdPeriodoSistemaEducativos;
use App\Models\TmGeneralidades;
use App\Models\TmCursos;
use App\Models\TmPersonas;
use App\Models\TdConductas;


use Livewire\Component;
use Illuminate\Support\Facades\DB;

class VcQualifyConduct extends Component
{   
    public $modalidadId, $termino, $periooId, $cursoId, $tblescala;

    protected $listeners = ['setData'];
    
    public function mount()
    {   

        $tblperiodos = TmPeriodosLectivos::where("aperturado",1)->first();
        $this->periodoId = $tblperiodos['id'];
        
        $this->tbltermino = TdPeriodoSistemaEducativos::query()
        ->where('periodo_id',$this->periodoId)
        ->where('tipo','EA')
        ->orderByRaw("cerrar,codigo")
        ->get();

        $this->tblescala =  TdPeriodoSistemaEducativos::query()
        ->where('periodo_id',$this->periodoId)
        ->where('tipo','EC')
        ->orderByRaw("cerrar,codigo")
        ->get();

        $this->termino = $this->tbltermino[0]['codigo'];
        
    }

    public function render()
    {   
        $this->tblmodalidad = TmGeneralidades::where('superior',1)->get();

        $this->tblparalelo = TmCursos::query()
        ->join('tm_servicios as s', 's.id', '=', 'tm_cursos.servicio_id')
        ->where('tm_cursos.periodo_id',$this->periodoId)
        ->where('s.modalidad_id', $this->modalidadId)
        ->select("tm_cursos.id","s.descripcion","tm_cursos.paralelo")
        ->orderBy('tm_cursos.nivel_id')
        ->orderBy('tm_cursos.grado_id')
        ->get();

        $this->loadPersonas();

        return view('livewire.vc-qualify-conduct');
    }

    public function consulta(){

        $this->loadPersonas();
        $this->add();
        $this->loadfalta();

    }
    
    
    public function loadPersonas(){
        
        // Subconsulta para obtener los IDs de matrículas que ya tienen pase activo
        $matriculasConPase = DB::table('tm_pase_cursos')
        ->where('estado', 'A')
        ->pluck('matricula_id');

        // Consulta de matrículas SIN pase
        $matriculasQuery = DB::table('tm_matriculas as m')
        ->select('m.estudiante_id', 'm.documento', 'm.modalidad_id', 'm.periodo_id', 'm.curso_id')
        ->where('m.modalidad_id', $this->modalidadId)
        ->where('m.periodo_id', $this->periodoId)
        ->where('m.estado','A')
        ->whereNotIn('m.id', $matriculasConPase);

        // Consulta de pases activos
        $pasesQuery = DB::table('tm_pase_cursos as p')
        ->join('tm_matriculas as m', 'm.id', '=', 'p.matricula_id')
        ->select('m.estudiante_id', 'm.documento', 'p.modalidad_id', 'm.periodo_id', 'p.curso_id')
        ->where('p.modalidad_id', $this->modalidadId)
        ->where('m.periodo_id', $this->periodoId)
        ->where('m.estado', 'A')
        ->where('p.estado', 'A');

        // UNION de ambas consultas
        $unionQuery = $matriculasQuery->unionAll($pasesQuery);

        // Consulta principal con joinSub en Eloquent
        $this->personas = TmPersonas::query()
            ->joinSub($unionQuery, 'm', function ($join) {
            $join->on('tm_personas.id', '=', 'm.estudiante_id');
        })
        ->where('m.curso_id', $this->cursoId)
        ->select('tm_personas.*', 'm.documento')
        ->orderBy('tm_personas.apellidos')
        ->get();

    }

    public function add(){

       $this->tblrecords=[];
      
        // Datos
        foreach ($this->personas as $key => $data)
        {   
            $index = $data->id;
            $this->tblrecords[$index]['id'] = 0;
            $this->tblrecords[$index]['personaId']  = $data->id;
            $this->tblrecords[$index]['nombres']    = $data->apellidos.' '.$data->nombres;
            $this->tblrecords[$index]['evaluacion'] = '';
        }

    }

    public function loadfalta(){

        $conducta = TdConductas::query()
        ->where("periodo_id",$this->periodoId)
        ->where("modalidad_id",$this->modalidadId)
        ->where("termino", $this->termino)
        ->where("curso_id", $this->cursoId)
        ->get();

        foreach ($conducta as $key => $data)
        {
            $index = $data->persona_id;
            $valor = $data->evaluacion;

            $this->tblrecords[$index]['id'] = $data->id;
            $this->tblrecords[$index]['evaluacion'] = $valor;
        }

    }

    public function createData(){

        if (count($this->tblrecords)>0){

            $message = "";
            $this->dispatchBrowserEvent('msg-confirm', ['newName' => $message]);

        }else{

            $message = "";
            $this->dispatchBrowserEvent('msg-alert', ['newName' => $message]);

        }        

    }

    public function setData()
    {
        $periodo = TmPeriodosLectivos::find($this->periodoId);

        foreach ($this->tblrecords as $index => $data)
        {
            $personaId = $index;
            $asistencia = TdConductas::find($data['id']);

            if ($asistencia) {

                $asistencia->update([
                    'evaluacion' => $this->tblrecords[$personaId]['evaluacion'],
                ]);

            }else{

                TdConductas::Create([
                    'periodo_id' => $this->periodoId,
                    'modalidad_id' => $this->modalidadId,
                    'termino' => $this->termino,
                    'curso_id' => $this->cursoId,
                    'persona_id' => $data['personaId'],
                    'evaluacion' => $data['evaluacion'],
                    'usuario' => auth()->user()->name,
                    'estado' => 'A',
                ]);

            }
        
        }

        $message = "Calificaciones grabada con Éxito......";
        $this->dispatchBrowserEvent('msg-grabar', ['newName' => $message]);
        
    }


}
