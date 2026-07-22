<?php

namespace App\Http\Livewire;
use App\Models\TmPeriodosLectivos;
use App\Models\TmGeneralidades;
use App\Models\TmHorarios;
use App\Models\TmPersonas;
use App\Models\TmMatricula;
use App\Models\TmExpedientes;
use App\Models\TmExpedienteMatricula;
use App\Models\TdExpedienteMatricula;

use Illuminate\Support\Facades\Http;

use Livewire\Component;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class VcRetirarDocumentos extends Component
{
    use WithFileUploads;

    public $accessToken, $tblrecords, $fileimg, $foto, $record=[], $personas=[];
    public array $documentos = [];
    public $matriculaId;

    public bool $documentacionCompleta = false;
    public bool $documentacionRetirada = false;
    public string $comentarioImpresion = '';
    public string $comentarioSecretaria = '';
    public string $comentarioRetiro = '';

    public $filters=[
        'modalidadId' => 0,
        'periodoId' => 0,
        'cursoId' => 0,
        'paraleloId' => 0,
        'personaId' => 0
    ];
    
    private function token(){

        $client_id = \Config('services.google.client_id');
        $client_secret = \Config('services.google.client_secret');
        $refresh_token = \Config('services.google.refresh_token');
        $response = Http::post('https://oauth2.googleapis.com/token',[
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'refresh_token' => $refresh_token,
            'grant_type' => 'refresh_token'
        ]);

        $accessToken = json_decode((string)$response->getBody(),true)['access_token'];
        return $accessToken;
    }
    
    public function mount($id)
    {
    
        $periodo = TmPeriodosLectivos::where("aperturado",1)->first();
        $this->filters['periodoId'] = $periodo->id;

        if($id>0){
            $this->loadExpediente($id);
        }

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

        $this->personas = $this->loadPersonas();

        return view('livewire.vc-retirar-documentos',[
            'modalidades' => $modalidades,
            'cursos' => $cursos,
            'paralelos' => $paralelos,
            'personas' => $this->personas,
        ]);
       

    }

    public function loadExpediente($id)
    {

        $expediente = TmExpedienteMatricula::query()
            ->where('id', $id)
            ->firstOrFail();

        $matricula = TmMatricula::query()
        ->join('tm_personas as estudiante', 'estudiante.id', '=', 'tm_matriculas.estudiante_id')
        ->join('tm_personas as representante', 'representante.id', '=', 'tm_matriculas.representante_id')
        ->join('tm_cursos as curso', 'curso.id', '=', 'tm_matriculas.curso_id')
        ->join('tm_servicios as servicio', 'servicio.id', '=', 'curso.servicio_id')
        ->where('tm_matriculas.id', $expediente->matricula_id)
        ->selectRaw("
            tm_matriculas.periodo_id as periodoId,
            tm_matriculas.modalidad_id as modalidadId,
            servicio.id as cursoId,
            curso.id  as paraleloId,
            tm_matriculas.estudiante_id as estudianteId
        ")
        ->firstOrFail();

        $this->filters['periodoId']=$matricula->periodoId;
        $this->filters['modalidadId']=$matricula->modalidadId;
        $this->filters['cursoId']    = (string) $matricula->cursoId;
        $this->filters['paraleloId'] =$matricula->paraleloId;
        $this->filters['personaId'] =$matricula->estudianteId;     

        $this->updatedFiltersPersonaId($matricula->estudianteId);

  
    } 

    public function updatedmodalidadId($id)
    {
        $this->filters['modalidadId']=$id;
    }

    public function updatedcursoId($id)
    {
        $this->filters['cursoId']=$id;
    }

    public function updatedparaleloId($id)
    {
        $this->filters['paraleloId']=$id;
    }

    public function updatedFiltersPersonaId($id)
    {
        
        $personas = $this->loadPersonas();

        $estudiante = $personas->firstWhere('id', $this->filters['personaId']);

        if($estudiante){

            $this->matriculaId = $estudiante->matriculaId;
            $this->foto = $estudiante->foto;

            $this->record = TmMatricula::query()
            ->join('tm_personas as p', 'p.id', '=', 'tm_matriculas.estudiante_id')
            ->join('tm_personas as p2', 'p2.id', '=', 'tm_matriculas.representante_id')
            ->where('tm_matriculas.id', $this->matriculaId)
            ->selectRaw("
                CONCAT(p.nombres, ' ', p.apellidos) AS estudiante,
                CONCAT(p2.nombres, ' ', p2.apellidos) AS representante,
                tm_matriculas.fecha,
                p.foto
            ")
            ->first();

            $this->consulta();

        }
        
    }

    public function consulta()
    {

        $cabecera = TmExpedienteMatricula::query()
            ->where('matricula_id', $this->matriculaId)
            ->first();

        $this->documentacionCompleta =
            (bool) ($cabecera?->documentacion_completa ?? false);

        $this->comentarioImpresion =
            $cabecera?->comentario_impresion ?? '';

        $this->comentarioSecretaria =
            $cabecera?->comentario_secretaria ?? '';

        $this->documentacionRetirada =
            (bool) ($cabecera?->documentacion_retirada ?? false);
        
        $this->comentarioRetiro =
            $cabecera?->comentario_retiro ?? '';

        $expedienteMatriculaId = $cabecera?->id ?? 0;
        $cursoId = $this->filters['cursoId'];

        $expedientes = TmExpedientes::query()
            ->leftJoin(
                'td_expediente_matriculas as det',
                function ($join) use ($expedienteMatriculaId) {
                    $join
                        ->on(
                            'det.expediente_id',
                            '=',
                            'tm_expedientes.id'
                        )
                        ->where(
                            'det.expediente_matricula_id',
                            '=',
                            $expedienteMatriculaId
                        );
                }
            )
            ->where('tm_expedientes.estado', 'A')
            ->where(function ($query) use ($cursoId) {
                $query
                    ->whereJsonContains(
                        'tm_expedientes.servicios',
                        $cursoId
                    )
                    ->orWhereJsonLength(
                        'tm_expedientes.servicios',
                        0
                    )
                    ->orWhereNull(
                        'tm_expedientes.servicios'
                    );
            })
            ->select([
                'tm_expedientes.id',
                'tm_expedientes.descripcion',
                'tm_expedientes.servicios',

                'det.id as detalle_id',
                'det.nombre',
                'det.extension',
                'det.observacion',
                'det.drive_id',
                'det.documentacion_retirada'
            ])
            ->orderBy('tm_expedientes.descripcion')
            ->get();

        $this->documentos = $expedientes
            ->mapWithKeys(function ($item) {

                $entregado = !empty($item->detalle_id)
                    && !empty($item->drive_id);

                return [
                    $item->id => [
                        'detalle_id' => $item->detalle_id,
                        'descripcion' => $item->descripcion,
                        'desde' => $item->primer_servicio,
                        'hasta' => $item->ultimo_servicio,

                        'entregado' => $entregado ? 'Si' : 'No',
                        'retirado' => (bool) ($item->documentacion_retirada ?? false),
                        'faltante' => !$entregado,

                        'observacion' => $item->observacion ?? '-',
                        'archivo_actual' => $item->nombre,
                        'extension' => $item->extension,
                        'drive_id' => $item->drive_id,
                        'archivo_nuevo' => null,
                    ],
                ];
            })
            ->toArray();

        
    }

    public function loadPersonas(){

        // IDs de matrículas que ya tienen un pase activo
        $matriculasConPase = DB::table('tm_pase_cursos')
            ->where('estado', 'A')
            ->pluck('matricula_id');

        // Matrículas que no tienen pase activo
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

        // Matrículas que tienen pase activo
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

        // Unión de ambas consultas
        $unionQuery = $matriculasQuery->unionAll($pasesQuery);

        // Consulta de personas
        $personas = TmPersonas::query()
            ->joinSub($unionQuery, 'mat', function ($join) {
                $join->on('tm_personas.id', '=', 'mat.estudiante_id');
            })
            ->where('mat.curso_id', $this->filters['paraleloId'])
            ->select([
                'tm_personas.*',
                'mat.matricula_id as matriculaId',
            ])
            ->orderBy('tm_personas.apellidos')
            ->get();

        return $personas;

    }

    public function marcarRetirado($expedienteId)
    {
        if ($this->documentos[$expedienteId]['retirado']) {
            $this->documentos[$expedienteId]['faltante'] = false;
        }
    }

    public function marcarFaltante($expedienteId)
    {
        if ($this->documentos[$expedienteId]['faltante']) {
            $this->documentos[$expedienteId]['entregado'] = false;
        }
    }

    public function createData()
    {
        $this ->validate([
            'matriculaId' => 'required',
        ]); 

        $cabecera = TmExpedienteMatricula::updateOrCreate(
            [
                'matricula_id' => $this->matriculaId,
            ],
            [
                'documentacion_completa' => $this->documentacionCompleta,
                'comentario_impresion' => filled($this->comentarioImpresion)
                    ? trim($this->comentarioImpresion)
                    : null,
                'comentario_secretaria' => filled($this->comentarioSecretaria)
                    ? trim($this->comentarioSecretaria)
                    : null,
                'documentacion_retirada' => $this->documentacionRetirada,
                'comentario_retiro' => filled($this->comentarioRetiro)
                    ? trim($this->comentarioRetiro)
                    : null,
                'estado' => 'A',
                'usuario' => auth()->user()->name,
            ]
        );


        foreach ($this->documentos as $expedienteId => $documento) {

            TdExpedienteMatricula::updateOrCreate(
                [
                    'expediente_matricula_id' => $cabecera->id,
                    'expediente_id' => $expedienteId,
                ],
                [
                    'documentacion_retirada' =>  $documento['retirado'],
                ]
            );           
            
        }

        $this->dispatchBrowserEvent('msg-save'); 
        $this->consulta();

    }
   

    public function imprimirRetiro($matriculaId)
    {
        $cabecera = TmExpedienteMatricula::query()
            ->where('matricula_id', $matriculaId)
            ->firstOrFail();

        $matricula = TmMatricula::query()
            ->join('tm_personas as estudiante', 'estudiante.id', '=', 'tm_matriculas.estudiante_id')
            ->join('tm_personas as representante', 'representante.id', '=', 'tm_matriculas.representante_id')
            ->join('tm_cursos as curso', 'curso.id', '=', 'tm_matriculas.curso_id')
            ->join('tm_servicios as servicio', 'servicio.id', '=', 'curso.servicio_id')
            ->where('tm_matriculas.id', $matriculaId)
            ->selectRaw("
                tm_matriculas.id,
                CONCAT(estudiante.nombres, ' ', estudiante.apellidos) AS estudiante,
                CONCAT(representante.nombres, ' ', representante.apellidos) AS representante,
                CONCAT(servicio.descripcion, ' ', curso.paralelo) AS curso,
                servicio.id as servicio_id
            ")
            ->firstOrFail();
        
        /*
        * Expedientes aplicables al curso y su detalle.
        */

        $cursoId=(string) $matricula->servicio_id;

        $documentos = TmExpedientes::query()
            ->leftJoin('td_expediente_matriculas as detalle', function ($join) use ($cabecera) {
                $join->on('detalle.expediente_id', '=', 'tm_expedientes.id')
                    ->where('detalle.expediente_matricula_id', '=', $cabecera->id);
            })
            ->where('tm_expedientes.estado', 'A')
            ->where(function ($query) use ($cursoId) {
                $query
                    ->whereJsonContains('tm_expedientes.servicios', $cursoId)
                    ->orWhereJsonLength('tm_expedientes.servicios', 0)
                    ->orWhereNull('tm_expedientes.servicios');
            })
            ->select([
                'tm_expedientes.id',
                'tm_expedientes.descripcion',
                'detalle.id as detalle_id',
                'detalle.drive_id',
                'detalle.documentacion_retirada'
            ])
            ->orderBy('tm_expedientes.descripcion')
            ->get();

        $documentosCompletos = $documentos
            ->filter(fn ($item) => $item->documentacion_retirada)
            ->values();

        $documentosFaltantes = $documentos
            ->filter(fn ($item) => !$item->documentacion_retirada)
            ->values();

        $pdf = Pdf::loadView('pdf.retiro-documentos', [
            'matricula' => $matricula,
            'cabecera' => $cabecera,
            'documentosCompletos' => $documentosCompletos,
            'documentosFaltantes' => $documentosFaltantes,
            'fechaConsulta' => now(),
        ])->setPaper('a4', 'portrait');

        return $pdf->stream(
            'retiro-documentos-' . $matriculaId . '.pdf'
        );
    }

        
    public function downloadPDF($matriculaId)
    {

        $cabecera = TmExpedienteMatricula::query()
            ->where('matricula_id', $matriculaId)
            ->firstOrFail();

        $matricula = TmMatricula::query()
            ->join('tm_personas as estudiante', 'estudiante.id', '=', 'tm_matriculas.estudiante_id')
            ->join('tm_personas as representante', 'representante.id', '=', 'tm_matriculas.representante_id')
            ->join('tm_cursos as curso', 'curso.id', '=', 'tm_matriculas.curso_id')
            ->join('tm_servicios as servicio', 'servicio.id', '=', 'curso.servicio_id')
            ->where('tm_matriculas.id', $matriculaId)
            ->selectRaw("
                tm_matriculas.id,
                CONCAT(estudiante.nombres, ' ', estudiante.apellidos) AS estudiante,
                CONCAT(representante.nombres, ' ', representante.apellidos) AS representante,
                CONCAT(servicio.descripcion, ' ', curso.paralelo) AS curso,
                servicio.id as servicio_id
            ")
            ->firstOrFail();
        
        /*
        * Expedientes aplicables al curso y su detalle.
        */

        $cursoId=(string) $matricula->servicio_id;

        $documentos = TmExpedientes::query()
            ->leftJoin('td_expediente_matriculas as detalle', function ($join) use ($cabecera) {
                $join->on('detalle.expediente_id', '=', 'tm_expedientes.id')
                    ->where('detalle.expediente_matricula_id', '=', $cabecera->id);
            })
            ->where('tm_expedientes.estado', 'A')
            ->where(function ($query) use ($cursoId) {
                $query
                    ->whereJsonContains('tm_expedientes.servicios', $cursoId)
                    ->orWhereJsonLength('tm_expedientes.servicios', 0)
                    ->orWhereNull('tm_expedientes.servicios');
            })
            ->select([
                'tm_expedientes.id',
                'tm_expedientes.descripcion',
                'detalle.id as detalle_id',
                'detalle.drive_id',
                'detalle.documentacion_retirada'
            ])
            ->orderBy('tm_expedientes.descripcion')
            ->get();

        $documentosCompletos = $documentos
            ->filter(fn ($item) => $item->documentacion_retirada)
            ->values();

        $documentosFaltantes = $documentos
            ->filter(fn ($item) => !$item->documentacion_retirada)
            ->values();

        $pdf = Pdf::loadView('pdf.retiro-documentos', [
            'matricula' => $matricula,
            'cabecera' => $cabecera,
            'documentosCompletos' => $documentosCompletos,
            'documentosFaltantes' => $documentosFaltantes,
            'fechaConsulta' => now(),
        ])->setPaper('a4', 'portrait');

        return $pdf->download('retiro-documentos-'.$matriculaId.'.pdf');
    }
}
