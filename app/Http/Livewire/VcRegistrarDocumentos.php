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

class VcRegistrarDocumentos extends Component
{
    use WithFileUploads;

    public $accessToken, $tblrecords, $fileimg, $foto, $record=[], $personas=[];
    public array $documentos = [];
    public $matriculaId, $selectId;

    public bool $documentacionCompleta = false;
    public string $comentarioImpresion = '';
    public string $comentarioSecretaria = '';

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

        $this->personas = $this->loadPersonas();

        $this->record = TmMatricula::query()
        ->join('tm_personas as p', 'p.id', '=', 'tm_matriculas.estudiante_id')
        ->join('tm_personas as p2', 'p2.id', '=', 'tm_matriculas.representante_id')
        ->join('tm_cursos as curso', 'curso.id', '=', 'tm_matriculas.curso_id')
        ->join('tm_servicios as servicio', 'servicio.id', '=', 'curso.servicio_id')
        ->where('tm_matriculas.id', $this->matriculaId)
        ->selectRaw("
            CONCAT(p.nombres, ' ', p.apellidos) AS estudiante,
            CONCAT(p2.nombres, ' ', p2.apellidos) AS representante,
            CONCAT(servicio.descripcion, ' ', curso.paralelo) AS curso,
            tm_matriculas.fecha,
            p.foto
        ")
        ->first();

        return view('livewire.vc-registrar-documentos',[
            'modalidades' => $modalidades,
            'cursos' => $cursos,
            'paralelos' => $paralelos,
            'personas' => $this->personas,
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
            ->join('tm_cursos as curso', 'curso.id', '=', 'tm_matriculas.curso_id')
            ->join('tm_servicios as servicio', 'servicio.id', '=', 'curso.servicio_id')
            ->where('tm_matriculas.id', $this->matriculaId)
            ->selectRaw("
                CONCAT(p.nombres, ' ', p.apellidos) AS estudiante,
                CONCAT(p2.nombres, ' ', p2.apellidos) AS representante,
                CONCAT(servicio.descripcion, ' ', curso.paralelo) AS curso,
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

        $this->selectId = $cabecera?->id ?? 0;

        $this->documentacionCompleta =
            (bool) ($cabecera?->documentacion_completa ?? false);

        $this->comentarioImpresion =
            $cabecera?->comentario_impresion ?? '';

        $this->comentarioSecretaria =
            $cabecera?->comentario_secretaria ?? '';

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

                        'entregado' => $entregado,
                        'faltante' => !$entregado,

                        'observacion' => $item->observacion ?? '',
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

    public function marcarEntregado($expedienteId)
    {
        if ($this->documentos[$expedienteId]['entregado']) {
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
                'estado' => 'A',
                'usuario' => auth()->user()->name,
            ]
        );

        foreach ($this->documentos as $expedienteId => $documento) {

            if ($documento['archivo_actual']!="") { 
                continue;
            }

            if ($documento['archivo_nuevo']=="") { 
                continue;
            }

            $this->accessToken = $this->token();
            $this->apiDrive($cabecera->id, $expedienteId, $documento);           
            
        }

        $this->dispatchBrowserEvent('msg-save'); 
        $this->consulta();

    }


    public function apiDrive($cabeceraId, $expedienteId, $attach){
 
        //$accessToken = $this->token();
        $fileId  ="";
        $msgfile ="";

        sleep(3); // Simula espera
            
        $file = $attach['archivo_nuevo'];

        $name    = $file->getClientOriginalName();
        $name    = pathinfo($name, PATHINFO_FILENAME);
        $archivo = str_replace(".", "_", $name);
        $name = preg_replace('/[^A-Za-z0-9_\-]/', '_', $name); // sanitizar nombre

        
        // Agregar timestamp para hacerlo único
        $uniqueSuffix = now()->format('Ymd_His');
        $name = $name . '_' . $uniqueSuffix;

        $ext =  $file->getClientOriginalExtension();
        $mime = $file->getClientMimeType();

        $filesave = $name.'.'.$ext;

        $contents = Storage::disk('public')->exists('archivos/'.$filesave);
        if ($contents){
            Storage::disk('public')->delete('archivos/'.$filesave);
        }

        // Guarda el archivo localmente
        $pathfile = $file->storeAs('archivos', $filesave,'public');
        $fileContent = file_get_contents($file->getRealPath());

        // Configuración de los metadatos
        $metadata = [
            'name' => $name . '.' . $ext,  // Nombre del archivo
            'mimeType' => $mime,  // Tipo MIME del archivo
            'parents' => ['134KruGoDFkvG20vA0VlxR2NHjJ9u-Yuw'],
        ];

        // Preparar el cuerpo multipart
        $boundary = '----WebKitFormBoundary' . md5(time());  // Crear un boundary único

        // Cuerpo multipart con los metadatos y el contenido del archivo
        $body = "--$boundary\r\n";
        $body .= "Content-Type: application/json; charset=UTF-8\r\n\r\n";
        $body .= json_encode($metadata) . "\r\n";  // Metadatos del archivo
        $body .= "--$boundary\r\n";
        $body .= "Content-Type: $mime\r\n";
        $body .= "Content-Transfer-Encoding: base64\r\n\r\n";
        $body .= base64_encode($fileContent) . "\r\n";  // El contenido del archivo
        $body .= "--$boundary--\r\n";

        // Realizar la solicitud POST a la API de Google Drive
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->accessToken,
            'Content-Type' => 'multipart/related; boundary=' . $boundary,  // Definir el tipo multipart
        ])->withBody($body, 'multipart/related')  // Usar el cuerpo con los metadatos y el archivo
        ->post('https://www.googleapis.com/upload/drive/v3/files?uploadType=multipart');

        if ($response->successful()){
            $fileId = json_decode($response->body())->id;
            $msgfile = " Archivo cargado a Google Drive";
        }else {
            $msgfile = "Error al subir a Google Drive: " . $response->body();
            logger()->error('Google Drive Upload Error', [
                'status' => $response->status(),
                'body' => $response->body(),
                'name' => $name . '.' . $ext
            ]);
        }

        $contents = Storage::disk('public')->exists('archivos/'.$filesave);
        if ($contents){
            Storage::disk('public')->delete('archivos/'.$filesave);
        }
        
        TdExpedienteMatricula::updateOrCreate(
            [
                'expediente_matricula_id' => $cabeceraId,
                'expediente_id' => $expedienteId,
            ],
            [
                'nombre' =>  $archivo.'.'.$ext,
                'extension' => $ext,
                'observacion' => filled($documento['observacion'] ?? null)
                    ? trim($documento['observacion'])
                    : null,
                'drive_id' => $fileId,
                'usuario' => auth()->user()->name,
            ]
        );

    }

    public function eliminarArchivo($expedienteId)
    {
        $registro = TdExpedienteMatricula::query()
            ->where('expediente_matricula_id', $this->selectId)
            ->where('expediente_id', $expedienteId)
            ->first();

        if (!$registro || !$registro->drive_id) {
            return;
        }

        //Storage::disk('public')->delete($registro->archivo);

        $registro->update([
            'nombre' => null,
            'extension' => null,
            'drive_id' => null,
            'usuario' => auth()->user()->name,
        ]);

        $this->documentos[$expedienteId]['archivo_actual'] = null;
        $this->documentos[$expedienteId]['entregado'] = false;
        $this->deleteFromDrive($registro->drive_id);


    }

    private function deleteFromDrive($fileId)
    {
        $accessToken = $this->token(); // Tu función que obtiene el access_token

        $response = Http::withToken($accessToken)
        ->delete("https://www.googleapis.com/drive/v3/files/{$fileId}");

    }

    public function imprimirRecepcion($matriculaId)
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
            ])
            ->orderBy('tm_expedientes.descripcion')
            ->get();

        $documentosCompletos = $documentos
            ->filter(fn ($item) => !empty($item->detalle_id) && !empty($item->drive_id))
            ->values();

        $documentosFaltantes = $documentos
            ->filter(fn ($item) => empty($item->detalle_id) || empty($item->drive_id))
            ->values();

        $pdf = Pdf::loadView('pdf.recepcion-documentos', [
            'matricula' => $matricula,
            'cabecera' => $cabecera,
            'documentosCompletos' => $documentosCompletos,
            'documentosFaltantes' => $documentosFaltantes,
            'fechaConsulta' => now(),
        ])->setPaper('a4', 'portrait');

        return $pdf->stream(
            'recepcion-documentos-' . $matriculaId . '.pdf'
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
            ])
            ->orderBy('tm_expedientes.descripcion')
            ->get();

        $documentosCompletos = $documentos
            ->filter(fn ($item) => !empty($item->detalle_id) && !empty($item->drive_id))
            ->values();

        $documentosFaltantes = $documentos
            ->filter(fn ($item) => empty($item->detalle_id) || empty($item->drive_id))
            ->values();

        $pdf = Pdf::loadView('pdf.recepcion-documentos', [
            'matricula' => $matricula,
            'cabecera' => $cabecera,
            'documentosCompletos' => $documentosCompletos,
            'documentosFaltantes' => $documentosFaltantes,
            'fechaConsulta' => now(),
        ])->setPaper('a4', 'portrait');

        return $pdf->download('recepcion-documentos-'.$matriculaId.'.pdf');
    }

}
