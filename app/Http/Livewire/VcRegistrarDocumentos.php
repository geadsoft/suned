<?php

namespace App\Http\Livewire;
use App\Models\TmPeriodosLectivos;
use App\Models\TmGeneralidades;
use App\Models\TmHorarios;

use Livewire\Component;

class VcRegistrarDocumentos extends Component
{
    public $tblrecords, $fileimg, $foto, $tblpersonas;
    public $filters=[
        'modalidadId' => 0,
        'periodoId' => 0,
        'cursoId' => 0,
        'paraleloId' => 0,
        'estudianteId' => 0
    ];
    
    
    public function mount()
    {

        $periodo = TmPeriodosLectivos::where("aperturado",1)->first();
        $this->filters['periodoId'] = $periodo->id;

    }

    public function render()
    {
        
        $modalidades = TmGeneralidades::where('superior',1)->get();

        $cursos = TmHorarios::query()
        ->join("tm_servicios as s","s.id","=","tm_horarios.servicio_id")
        ->where("tm_horarios.periodo_id",$this->filters['periodoId'] )
        ->where('tm_horarios.grupo_id',$this->filters['modalidadId'])
        ->selectRaw('s.id, s.descripcion')
        ->get();

        $paralelos = TmHorarios::query()
        ->join("tm_servicios as s","s.id","=","tm_horarios.servicio_id")
        ->join("tm_cursos as c","c.id","=","tm_horarios.curso_id")
        ->where("tm_horarios.periodo_id",$this->filters['periodoId'] )
        ->where('tm_horarios.grupo_id',$this->filters['modalidadId'])
        ->where('s.id',$this->filters['cursoId'])
        ->selectRaw('c.id, c.paralelo')
        ->groupByRaw('c.id, c.paralelo')
        ->get();
        
        return view('livewire.vc-registrar-documentos',[
            'modalidades' => $modalidades,
            'cursos' => $cursos,
            'paralelos' => $paralelos
        ]);
        

    }

    public function updatedmodalidadId($id)
    {
        $this->filters['modalidadId']=$id;
    }

    public function updatedcursoId($id)
    {
        $this->filters['cursoId']=$id;
    }

    public function consulta()
    {
        $this->loadPersonas();
        $this->add();

    }

    public function loadPersonas(){

        // Subconsulta para obtener los IDs de matrículas que ya tienen pase activo
        $matriculasConPase = DB::table('tm_pase_cursos')
        ->where('estado', 'A')
        ->pluck('matricula_id');

        // Consulta de matrículas SIN pase
        $matriculasQuery = DB::table('tm_matriculas as m')
        ->select('m.estudiante_id', 'm.documento', 'm.modalidad_id', 'm.periodo_id', 'm.curso_id')
        ->where('m.modalidad_id', $this->filters['modalidadId'])
        ->where('m.periodo_id', $this->filters['periodoId'])
        ->where('m.estado','A')
        ->whereNotIn('m.id', $matriculasConPase);

        // Consulta de pases activos
        $pasesQuery = DB::table('tm_pase_cursos as p')
        ->join('tm_matriculas as m', 'm.id', '=', 'p.matricula_id')
        ->select('m.estudiante_id', 'm.documento', 'p.modalidad_id', 'm.periodo_id', 'p.curso_id')
        ->where('p.modalidad_id', $this->filters['modalidadId'])
        ->where('m.periodo_id', $this->filters['periodoId'])
        ->where('m.estado','A')
        ->where('p.estado', 'A');
        
        // UNION de ambas consultas
        $unionQuery = $matriculasQuery->unionAll($pasesQuery);

        // Consulta principal con joinSub en Eloquent
        $this->tblpersonas = TmPersonas::query()
            ->joinSub($unionQuery, 'm', function ($join) {
            $join->on('tm_personas.id', '=', 'm.estudiante_id');
        })
        ->where('m.curso_id', $this->filters['paraleloId'])
        ->select('tm_personas.*', 'm.documento')
        ->orderBy('tm_personas.apellidos')
        ->get();

    }

    public function add(){

        $this->tblrecords=[];
        

    }
}
