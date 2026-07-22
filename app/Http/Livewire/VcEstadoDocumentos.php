<?php

namespace App\Http\Livewire;
use App\Models\TmPeriodosLectivos;
use App\Models\TmGeneralidades;
use App\Models\TmHorarios;
use App\Models\TmPersonas;
use App\Models\TmExpedientes;
use App\Models\TmExpedienteMatricula;
use App\Models\TdExpedienteMatricula;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class VcEstadoDocumentos extends Component
{
    public $personas=[], $documentos=[];   
    public array $listadoDocumentos = []; 
    public $totalEstudiantes, $totalFaltantes, $totalCompletos, $totalIncompletos, $porcentajeCompletos, $porcentajeIncompletos;

    public $estudianteSeleccionado = null;
    public $archivosEstudiante = [];

    public $filters=[
        'periodoId' => 0,
        'modalidadId' => 0,
        'periodoId' => 0,
        'cursoId' => 0,
        'paraleloId' => 0,
    ];

    public function mount()
    {

        $periodo = TmPeriodosLectivos::where("aperturado",1)->first();
        $this->filters['periodoId'] = $periodo->id;

    }

    public function render()
    {   
        $periodos =  TmPeriodosLectivos::query()
        ->orderBy('id','desc')
        ->get();   

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

        return view('livewire.vc-estado-documentos',[
            'periodos' => $periodos,
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

    public function updatedFiltersParaleloId($id)
    {
        $this->filters['paraleloId']=$id;
        $this->cargarListadoDocumentos();

    }

    public function cargarListadoDocumentos()
    {
        /*
        |--------------------------------------------------------------------------
        | Estudiantes del paralelo
        |--------------------------------------------------------------------------
        */

        $matriculasConPase = DB::table('tm_pase_cursos')
            ->where('estado', 'A')
            ->pluck('matricula_id');

        $matriculasQuery = DB::table('tm_matriculas as m')
            ->select([
                'm.estudiante_id',
                'm.id as matricula_id',
                'm.modalidad_id',
                'm.periodo_id',
                'm.curso_id',
            ])
            ->where('m.modalidad_id', $this->filters['modalidadId'])
            ->where('m.periodo_id', $this->filters['periodoId'])
            ->where('m.estado', 'A')
            ->whereNotIn('m.id', $matriculasConPase);

        $pasesQuery = DB::table('tm_pase_cursos as p')
            ->join('tm_matriculas as m', 'm.id', '=', 'p.matricula_id')
            ->select([
                'm.estudiante_id',
                'm.id as matricula_id',
                'p.modalidad_id',
                'm.periodo_id',
                'p.curso_id',
            ])
            ->where('p.modalidad_id', $this->filters['modalidadId'])
            ->where('m.periodo_id', $this->filters['periodoId'])
            ->where('m.estado', 'A')
            ->where('p.estado', 'A');

        $unionQuery = $matriculasQuery->unionAll($pasesQuery);

        $personas = TmPersonas::query()
            ->joinSub($unionQuery, 'mat', function ($join) {
                $join->on('tm_personas.id', '=', 'mat.estudiante_id');
            })
            ->join('tm_cursos as c', 'c.id', '=', 'mat.curso_id')
            ->join('tm_servicios as s', 's.id', '=', 'c.servicio_id')
            ->where('mat.curso_id', $this->filters['paraleloId'])
            ->select([
                'tm_personas.id',
                'tm_personas.nombres',
                'tm_personas.apellidos',
                'mat.matricula_id as matriculaId',
                's.id as servicio_id',
                DB::raw("
                    CONCAT(s.descripcion, ' - ', c.paralelo) as curso
                "),
            ])
            ->orderBy('tm_personas.apellidos')
            ->orderBy('tm_personas.nombres')
            ->get();

        if ($personas->isEmpty()) {
            $this->listadoDocumentos = [];
            return;
        }

        $this->totalEstudiantes = $personas->count();

        /*
        |--------------------------------------------------------------------------
        | Documentos requeridos para el curso
        |--------------------------------------------------------------------------
        */

        $servicioId = (string) $personas->first()->servicio_id;

        $expedienteIds = TmExpedientes::query()
            ->where('estado', 'A')
            ->where(function ($query) use ($servicioId) {
                $query
                    ->whereJsonContains('servicios', $servicioId)
                    ->orWhereJsonLength('servicios', 0)
                    ->orWhereNull('servicios');
            })
            ->pluck('id');

        $totalRequeridos = $expedienteIds->count();

        /*
        |--------------------------------------------------------------------------
        | Cabeceras por matrícula
        |--------------------------------------------------------------------------
        */

        $matriculaIds = $personas
            ->pluck('matriculaId')
            ->filter()
            ->values();

        $cabeceras = TmExpedienteMatricula::query()
            ->whereIn('matricula_id', $matriculaIds)
            ->select([
                'id',
                'matricula_id',
                'documentacion_completa',
            ])
            ->get()
            ->keyBy('matricula_id');

        /*
        |--------------------------------------------------------------------------
        | Documentos realmente cargados
        |--------------------------------------------------------------------------
        */

        $cabeceraIds = $cabeceras
            ->pluck('id')
            ->filter()
            ->values();

        $documentosCargados = collect();

        if ($cabeceraIds->isNotEmpty() && $expedienteIds->isNotEmpty()) {
            $documentosCargados = TdExpedienteMatricula::query()
                ->whereIn('expediente_matricula_id', $cabeceraIds)
                ->whereIn('expediente_id', $expedienteIds)
                ->whereNotNull('drive_id')
                ->where('drive_id', '<>', '')
                ->selectRaw("
                    expediente_matricula_id,
                    COUNT(DISTINCT expediente_id) as total
                ")
                ->groupBy('expediente_matricula_id')
                ->pluck('total', 'expediente_matricula_id');
        }

        /*
        |--------------------------------------------------------------------------
        | Armar listado
        |--------------------------------------------------------------------------
        */

        $this->listadoDocumentos = $personas
            ->map(function ($persona) use (
                $cabeceras,
                $documentosCargados,
                $totalRequeridos
            ) {
                $cabecera = $cabeceras->get($persona->matriculaId);

                $totalCargados = $cabecera
                    ? (int) $documentosCargados->get($cabecera->id, 0)
                    : 0;

                $totalFaltantes = ($cabecera?->documentacion_completa ?? false)
                ? 0
                : max($totalRequeridos - $totalCargados, 0);

                return [
                    'persona_id' => $persona->id,
                    'matricula_id' => $persona->matriculaId,
                    'estudiante' => trim(
                        $persona->apellidos . ' ' . $persona->nombres
                    ),
                    'curso' => $persona->curso,

                    /*
                    * Completa depende únicamente del campo de cabecera.
                    */
                    'documentacion_completa' => (bool) (
                        $cabecera?->documentacion_completa ?? false
                    ),

                    'total_requeridos' => $totalRequeridos,
                    'total_cargados' => $totalCargados,
                    'total_faltantes' => $totalFaltantes,
                ];
            })
            ->values()
            ->toArray();

            $this->totalCompletos = collect($this->listadoDocumentos)
            ->where('documentacion_completa', 1)
            ->count();

            $this->totalIncompletos = collect($this->listadoDocumentos)
            ->where('documentacion_completa', 0)
            ->count();

            $this->totalFaltantes = collect($this->listadoDocumentos)
            ->where('total_cargados','=',0)
            ->count();

            $this->porcentajeCompletos = $this->totalEstudiantes > 0
                ? round(($this->totalCompletos / $this->totalEstudiantes) * 100, 2)
                : 0;

            $this->porcentajeIncompletos = $this->totalEstudiantes > 0
                ? round(( $this->totalFaltantes  / $this->totalEstudiantes) * 100, 2)
                : 0;
        }

    public function verArchivos($estudianteId, $matriculaId)
    {
        // Si vuelve a hacer clic en el mismo estudiante, se cierra el detalle
        if ($this->estudianteSeleccionado == $estudianteId) {
            $this->estudianteSeleccionado = null;
            $this->archivosEstudiante = [];

            return;
        }

        $this->estudianteSeleccionado = $estudianteId;

        $this->archivosEstudiante = TdExpedienteMatricula::query()
            ->join('tm_expediente_matriculas as m','m.id','=','td_expediente_matriculas.expediente_matricula_id')
            ->where('m.matricula_id', $matriculaId)
            ->whereNotNull('drive_id')
            ->get()
            ->toArray();
    }



}

