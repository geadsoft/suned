<?php

namespace App\Http\Livewire;
use App\Models\TmPeriodosLectivos;
use App\Models\TmLibros;
use App\Models\TmAsignaturas;
use App\Models\TmGeneralidades;
use App\Models\TmHorarios;
use App\Models\TdLibrosCursos;


use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Str;

class VcLibrary extends Component
{
    use WithFileUploads;

    public $showEditModal, $periodoId, $docenteId, $fileimg='';
    public $record, $tblasignaturas, $tblmodalidad;
    public $selectedCursos = [];

    public $filters=[
        'buscar' => '',
        'modalidadId' => '',
        'asignaturaId' => '',
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
        $this->docenteId = auth()->user()->personaId;

        $tblperiodos = TmPeriodosLectivos::where("aperturado",1)->first();
        $this->periodoId = $tblperiodos['id'];

        $this->tblmodalidad = TmGeneralidades::where('superior',1)->get();
        $this->tblasignaturas = TmAsignaturas::all();
        $this->filters['periodoId'] = $this->periodoId;
    }

    public function render()
    {

        $tblparalelo = TmHorarios::query()
        ->join("tm_servicios as s","s.id","=","tm_horarios.servicio_id")
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as m","m.id","=","d.asignatura_id")
        ->join("tm_generalidades as g","g.id","=","tm_horarios.grupo_id")
        ->join("tm_generalidades as g2","g2.id","=","s.nivel_id")
        ->where("tm_horarios.periodo_id",$this->periodoId)
        ->where("d.docente_id",$this->docenteId)        
        ->selectRaw('g.descripcion as modalidad,g2.descripcion as nivel,s.descripcion as curso,s.id')
        ->groupByRaw('g.descripcion,g2.descripcion,s.descripcion,s.id')
        ->get();

        $tblparalelo = $tblparalelo
        ->groupBy('modalidad')
        ->map(function ($modalidadGroup) {
            return $modalidadGroup->groupBy('nivel');
        });
        
        $tblrecords = TmLibros::query()
        ->join('td_libros_cursos as c','c.libro_id','=','tm_libros.id')
        ->join('tm_servicios as s','s.id','=','c.curso_id')
        ->when($this->filters['buscar'],function($query){
            return $query->where('nombre', 'LIKE' , "%{$this->filters['buscar']}%");
        })
        ->when($this->filters['modalidadId'],function($query){
            return $query->where('s.modalidad_id',"{$this->filters['modalidadId']}");
        })
        ->when($this->filters['asignaturaId'],function($query){
            return $query->where('asignatura_id',"{$this->filters['asignaturaId']}");
        })
        ->where('periodo_id',$this->periodoId)
        ->where('docente_id',$this->docenteId)
        ->selectRaw('tm_libros.id, tm_libros.nombre, tm_libros.asignatura_id, tm_libros.drive_id, tm_libros.autor, tm_libros.portada')
        ->GroupByRaw('tm_libros.id, tm_libros.nombre, tm_libros.asignatura_id, tm_libros.drive_id, tm_libros.autor, tm_libros.portada')
        ->get();  
 

        return view('livewire.vc-library',[
            'tblrecords' => $tblrecords,
            'tblparalelo' => $tblparalelo,
        ]);
    }
   

    public function add(){
        
        $this->showEditModal = false;
        $this->reset(['record']);
        $this->record['periodoId']= $this->periodoId;
        $this->record['docenteId']= $this->docenteId;
        $this->record['asignaturaId']= '';
        $this->record['nombre']= '';
        $this->record['autor']= ''; 
        $this->record['portada']= '';
        $this->record['archivo']= '';
        $this->record['driveId']= '';
        $this->record['imagen']= '';        
        $this->dispatchBrowserEvent('show-form');

    }


    public function createData(){

        
        /*$this ->validate([
            'record.periodoId' => 'required',
            'record.docenteId' => 'required',
            'record.nombre' => 'required',
            'record.autor' => 'required',
            'record.portada' => 'required',
            'record.archivo' => 'required',
            'record.asignatura' => 'required',
        ]);*/

        $this->validate([
            'record.archivo' => 'required|mimes:pdf|max:204800', // 200 MB (KB)
        ]);

        if (count($this->selectedCursos)==0){
            return;
        }

        $pathfile = '';
        $nameFile = '';
        $this->fileimg = $this->record['portada'];
        
        if($this->record['portada'] ?? null){
            $this ->validate([
                'fileimg' => ['image', 'mimes:jpg,jpeg,png', 'max:1024'],
                ]);

            $nameFile = $this->record['portada']->getClientOriginalName();
            $contents = Storage::disk('public')->exists('libros/'.$nameFile);
            if ($contents){
                Storage::disk('public')->delete('libros/'.$nameFile);
            }

            //Elimino foto anterior
            $contents = Storage::disk('public')->exists('libros/'.$this->record['imagen']);
            if ($contents){
                Storage::disk('public')->delete('libros/'.$this->record['imagen']);
            }

            $pathfile = 'storage/'.$this->record['portada']->storeAs('public/libros', $nameFile);
                            
        }

        if ($this->record['archivo']!=""){
            $this->apiDrive();
        }

        $libros = TmLibros::Create([
            'periodo_id' => $this -> record['periodoId'],
            'docente_id' => $this -> record['docenteId'],
            'nombre' => $this -> record['nombre'],
            'autor' => $this -> record['autor'],
            'portada' => $pathfile,
            'drive_id' => $this -> record['driveId'],
            'asignatura_id' => $this -> record['asignaturaId'],
            'usuario' => auth()->user()->name,
        ]);

        foreach($this->selectedCursos as $recurso){
            TdLibrosCursos::Create([
                'libro_id' => $libros->id,
                'curso_id' => $recurso,
                'usuario' => auth()->user()->name,
            ]);
        } 

        $this->selectedCursos = [];
        $this->dispatchBrowserEvent('hide-form', ['message'=> 'Registro grabado con éxito!']);  
        
    }

    public function eliminar($id){

        TdLibrosCursos::where('libro_id',$id)->delete();
        TmLibros::find($id)->delete();

    }

    public function apiDrive(){

        $accessToken = $this->token();

        sleep(3); // Simula espera
        
        if (empty($accessToken)) {
            throw new \Exception("No se obtuvo access token desde \$this->token()");
        }

        // 2) Guardar temporalmente en disco (storage/app/tmp)
        $uploadedFile = $this->record['archivo'];
        $folderId = '1x2ECW-r4JdnRkMixMPKU37zPdh1X1iGE';
        $tmpDir = 'tmp';
        $origName = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $ext = $uploadedFile->getClientOriginalExtension();
        $safeName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $origName);
        $unique = $safeName . '_' . now()->format('Ymd_His') . '.' . $ext;
        $relativePath = $uploadedFile->storeAs($tmpDir, $unique, 'local'); // storage/app/tmp/...
        $fullPath = storage_path('app/' . $relativePath);

        if (!file_exists($fullPath)) {
            throw new \Exception("No se pudo guardar archivo temporal en {$fullPath}");
        }

        $fileSize = filesize($fullPath);
        $mime = $uploadedFile->getClientMimeType() ?: 'application/octet-stream';
        $fileName = $unique;

        try {
            // 3) Iniciar sesión resumible (POST, obtener Location header)
            $initUrl = 'https://www.googleapis.com/upload/drive/v3/files?uploadType=resumable';
            $metadata = ['name' => $fileName];
            if ($folderId) $metadata['parents'] = [$folderId];

            $ch = curl_init($initUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, true); // queremos headers para capturar Location
            curl_setopt($ch, CURLOPT_NOBODY, false);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Authorization: Bearer {$accessToken}",
                'Content-Type: application/json; charset=UTF-8',
                "X-Upload-Content-Type: {$mime}",
                "X-Upload-Content-Length: {$fileSize}",
            ]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($metadata));
            $resp = curl_exec($ch);

            if ($resp === false) {
                $err = curl_error($ch);
                curl_close($ch);
                throw new \Exception("Error iniciando sesión resumible: {$err}");
            }

            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $headers = substr($resp, 0, $headerSize);
            $body = substr($resp, $headerSize);
            curl_close($ch);

            if ($httpCode < 200 || $httpCode >= 300) {
                // mostrar body para debug
                throw new \Exception("Inicio de sesión resumible falló. HTTP {$httpCode}. Body: {$body}");
            }

            // Parsear Location header
            if (!preg_match('/Location:\s*(\S+)/i', $headers, $m)) {
                throw new \Exception("No se obtuvo Location header para la sesión resumible. Headers: {$headers}");
            }
            $uploadUrl = trim($m[1]);

            // 4) Subir por chunks (PUT con Content-Range)
            $chunkSize = 10 * 1024 * 1024; // 10 MB
            $handle = fopen($fullPath, 'rb');
            if ($handle === false) {
                throw new \Exception("No se pudo abrir el archivo temporal para lectura: {$fullPath}");
            }

            $offset = 0;
            $fileId = null;

            while ($offset < $fileSize) {
                $bytesToRead = min($chunkSize, $fileSize - $offset);
                $data = fread($handle, $bytesToRead);
                if ($data === false) {
                    fclose($handle);
                    throw new \Exception("Error leyendo chunk del archivo en offset {$offset}");
                }

                $start = $offset;
                $end = $offset + $bytesToRead - 1;
                $contentRange = "bytes {$start}-{$end}/{$fileSize}";

                $ch = curl_init($uploadUrl);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT'); // PUT para resumable
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    "Authorization: Bearer {$accessToken}",
                    "Content-Length: {$bytesToRead}",
                    "Content-Range: {$contentRange}",
                ]);
                curl_setopt($ch, CURLOPT_TIMEOUT, 0); // sin timeout rígido
                $resp = curl_exec($ch);

                if ($resp === false) {
                    $err = curl_error($ch);
                    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    curl_close($ch);
                    fclose($handle);
                    throw new \Exception("Error upload chunk: {$err} (HTTP {$httpCode})");
                }

                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);

                if (in_array($httpCode, [200, 201])) {
                    // terminado; $resp contiene metadata JSON del archivo
                    $json = json_decode($resp, true);
                    $fileId = $json['id'] ?? null;
                    break;
                } elseif ($httpCode == 308) {
                    // Resume Incomplete: continuar con siguiente chunk
                    // Opcional: parsear Range header para saber el offset correcto
                    $offset = $end + 1;
                    continue;
                } else {
                    fclose($handle);
                    throw new \Exception("Error en chunk upload. HTTP {$httpCode}. Resp: {$resp}");
                }
            }

            fclose($handle);

            if (!$fileId) {
                throw new \Exception("No se obtuvo fileId después de la subida resumible.");
            }

            // 5) Retornar fileId (o hacer lo que necesites)
            return $fileId;
        } finally {
            // 6) Limpiar el temporal siempre
            try { @unlink($fullPath); } catch (\Throwable $_) {}
        }
 
        /*$accessToken = $this->token();
        $fileId  ="";
        $msgfile ="";

        sleep(3); // Simula espera

        $file = $this->record['archivo'];

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
            'parents' => ['1x2ECW-r4JdnRkMixMPKU37zPdh1X1iGE'],
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
            $this->record['driveId'] = $fileId;
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
        }*/

    }

}
