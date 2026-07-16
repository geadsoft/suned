<?php

namespace App\Http\Livewire;
use App\Models\TmPeriodosLectivos;
use App\Models\TmGeneralidades;
use App\Models\TmHorarios;
use App\Models\TmPersonas;
use App\Models\TmMatricula;
use App\Models\TmExpedientes;
use App\Models\TdExpedienteMatricula;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class VcRegistrarDocumentos extends Component
{
    use WithFileUploads;

    public $tblrecords, $fileimg, $foto, $record=[];
    public array $documentos = [];
    public $matriculaId;

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

        $personas = $this->loadPersonas();

        $persona = $personas->firstWhere('id', $this->filters['personaId']);

        if($persona){
            $this->record = TmMatricula::query()
            ->join('tm_personas as p', 'p.id', '=', 'tm_matriculas.estudiante_id')
            ->join('tm_personas as p2', 'p2.id', '=', 'tm_matriculas.representante_id')
            ->where('tm_matriculas.id', $persona->matriculaId)
            ->selectRaw("
                CONCAT(p.nombres, ' ', p.apellidos) AS estudiante,
                CONCAT(p2.nombres, ' ', p2.apellidos) AS representante,
                tm_matriculas.fecha,
                p.foto
            ")
            ->first();
            $this->foto = $this->record->foto;
        }
        
        return view('livewire.vc-registrar-documentos',[
            'modalidades' => $modalidades,
            'cursos' => $cursos,
            'paralelos' => $paralelos,
            'personas' => $personas,
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

    public function consulta()
    {
        //$personas = $this->loadPersonas();
        

        
        
        $expedientes = TmExpedientes::query()
        ->where(function ($query) {
            $query->whereJsonContains('servicios', $this->filters['cursoId'])
                ->orWhereJsonLength('servicios', 0);
        })
        ->get();

        $this->documentos = $expedientes
        ->mapWithKeys(function ($item) {

            $nuevo = is_null($item->detalle_id);

            return [
                $item->id => [
                    'detalle_id' => $item->detalle_id,
                    'descripcion' => $item->descripcion,
                    'desde' => $item->primer_servicio,
                    'hasta' => $item->ultimo_servicio,
                    'entregado' =>  $nuevo ? false : (bool)$item->entregado,
                    'faltante' =>  $nuevo ? true : (bool)$item->faltante,
                    'observacion' => $item->observacion,
                    'archivo_actual' => $item->archivo,
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

    public function guardarDocumento($expedienteId)
    {
        $documento = $this->documentos[$expedienteId];

        $this->validate([
            "documentos.$expedienteId.observacion" => [
                'nullable',
                'string',
                'max:250',
            ],
            "documentos.$expedienteId.archivo_nuevo" => [
                'nullable',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:5120',
            ],
        ]);

        $registro = TdExpedienteMatricula::firstOrNew([
            'matricula_id' => $this->matriculaId,
            'expediente_id' => $expedienteId,
        ]);

        if (!empty($documento['archivo_nuevo'])) {

            if ($registro->archivo) {
                Storage::disk('public')->delete($registro->archivo);
            }

            $ruta = $documento['archivo_nuevo']->store(
                "expedientes/{$this->matriculaId}",
                'public'
            );

            $registro->archivo = $ruta;
        }

        $registro->entregado = $documento['entregado'];
        $registro->faltante = $documento['faltante'];
        $registro->observacion = $documento['observacion'];
        $registro->fecha_entrega = $documento['entregado']
            ? now()->toDateString()
            : null;
        $registro->usuario = auth()->user()->name;

        $registro->save();

        $this->documentos[$expedienteId]['detalle_id'] = $registro->id;
        $this->documentos[$expedienteId]['archivo_actual'] = $registro->archivo;
        $this->documentos[$expedienteId]['archivo_nuevo'] = null;

        $this->dispatch(
            'alert',
            type: 'success',
            message: 'Documento actualizado correctamente.'
        );
    }

    public function eliminarArchivo($expedienteId)
    {
        $registro = TdExpedienteMatricula::query()
            ->where('matricula_id', $this->matriculaId)
            ->where('expediente_id', $expedienteId)
            ->first();

        if (!$registro || !$registro->archivo) {
            return;
        }

        Storage::disk('public')->delete($registro->archivo);

        $registro->update([
            'archivo' => null,
            'entregado' => false,
            'usuario' => auth()->user()->name,
        ]);

        $this->documentos[$expedienteId]['archivo_actual'] = null;
        $this->documentos[$expedienteId]['entregado'] = false;

        $this->dispatch(
            'alert',
            type: 'success',
            message: 'Archivo eliminado correctamente.'
        );
    }

    public function apiDrive($selectId){
 
        $accessToken = $this->token();
        $fileId  ="";
        $msgfile ="";

        sleep(3); // Simula espera

        foreach ($this->array_attach as $attach){

            if ($attach['id']>0) { 
                continue;
            }

            if ($attach['adjunto']=="") { 
                continue;
            }
            
            $file = $attach['adjunto'];

            $name    = $file->getClientOriginalName();
            $name    = pathinfo($name, PATHINFO_FILENAME);
            $archivo = str_replace(".", "_", $name);
            $name = preg_replace('/[^A-Za-z0-9_\-]/', '_', $name); // sanitizar nombre

            
            // Agregar timestamp para hacerlo único
            $uniqueSuffix = now()->format('Ymd_His'); // o usar uniqid() si prefieres algo más corto
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
                'Authorization' => 'Bearer ' . $accessToken,
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

            TmFiles::Create([
                'actividad_id' => $selectId,
                'persona_id' => $this->docenteId,
                'nombre' => $archivo.'.'.$ext,
                'extension' => $ext,
                'entrega' => false,
                'actividad' => true,
                'drive_id' => $fileId,
                'usuario' => auth()->user()->name,
            ]);

        }

       return  $msgfile;
        //return redirect()->to('/activities/activity');

    }
}
