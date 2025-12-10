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
            'record.archivo' => 'required|file|mimes:pdf|max:204800', // 204800 KB = 200 MB
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
        $origName = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $ext = $uploadedFile->getClientOriginalExtension();
        $safeName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $origName);
        $unique = $safeName . '_' . now()->format('Ymd_His') . '.' . $ext;
        $rel = $uploadedFile->storeAs($tmpDir, $unique, 'local');
        $path = storage_path('app/' . $rel);
        if (!file_exists($path)) throw new \Exception("No temporal file: {$path}");

        $size = filesize($path);
        $mime = $uploadedFile->getClientMimeType() ?: 'application/octet-stream';
        $name = $unique;

        try {
            // INIT - capturar headers y body
            $initUrl = 'https://www.googleapis.com/upload/drive/v3/files?uploadType=resumable';
            $meta = ['name' => $name];
            if ($folderId) $meta['parents'] = [$folderId];

            $ch = curl_init($initUrl);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HEADER => true,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_HTTPHEADER => [
                    "Authorization: Bearer {$access}",
                    'Content-Type: application/json; charset=UTF-8',
                    "X-Upload-Content-Type: {$mime}",
                    "X-Upload-Content-Length: {$size}",
                ],
                CURLOPT_POSTFIELDS => json_encode($meta),
                CURLOPT_TIMEOUT => 0,
            ]);
            $resp = curl_exec($ch);
            $err = curl_error($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $hsize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $headers = substr($resp, 0, $hsize);
            $body = substr($resp, $hsize);
            curl_close($ch);

            logger()->info('Drive init', ['http' => $httpCode, 'err' => $err, 'headers' => $headers, 'body' => $body]);

            if ($err) throw new \Exception("Init curl error: {$err}");
            if ($httpCode < 200 || $httpCode >= 300) {
                throw new \Exception("Init failed HTTP {$httpCode}. Body: {$body}");
            }

            if (!preg_match('/Location:\s*(\S+)/i', $headers, $m)) {
                throw new \Exception("No Location header en init. Headers: {$headers} Body: {$body}");
            }
            $uploadUrl = trim($m[1]);

            // UPLOAD por chunks con reintentos simples
            $chunkSize = 10 * 1024 * 1024;
            $handle = fopen($path, 'rb');
            if ($handle === false) throw new \Exception("No se abre archivo {$path}");

            $offset = 0;
            $fileId = null;
            while ($offset < $size) {
                $bytes = min($chunkSize, $size - $offset);
                $data = fread($handle, $bytes);
                if ($data === false) { fclose($handle); throw new \Exception("Error leyendo chunk at {$offset}"); }

                $start = $offset;
                $end = $offset + $bytes - 1;
                $contentRange = "bytes {$start}-{$end}/{$size}";

                $tries = 0;
                RETRY:
                $tries++;
                $ch = curl_init($uploadUrl);
                curl_setopt_array($ch, [
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_CUSTOMREQUEST => 'PUT',
                    CURLOPT_POSTFIELDS => $data,
                    CURLOPT_HTTPHEADER => [
                        "Authorization: Bearer {$access}",
                        "Content-Length: {$bytes}",
                        "Content-Range: {$contentRange}",
                    ],
                    CURLOPT_TIMEOUT => 0,
                ]);
                $resp = curl_exec($ch);
                $err = curl_error($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);

                logger()->info('Drive chunk', ['start'=>$start,'end'=>$end,'http'=>$httpCode,'err'=>$err,'resp_snippet'=>substr($resp,0,400)]);

                if ($err) {
                    if ($tries < 3) { sleep(1); goto RETRY; }
                    fclose($handle); throw new \Exception("Chunk curl error: {$err}");
                }

                if (in_array($httpCode, [200,201])) {
                    $json = json_decode($resp, true);
                    $fileId = $json['id'] ?? null;
                    break;
                } elseif ($httpCode == 308) {
                    // continuar
                    // opcional parsear Range devuelto para recalcular offset
                    $offset = $end + 1;
                    continue;
                } else {
                    fclose($handle);
                    throw new \Exception("Chunk failed HTTP {$httpCode}. Resp: {$resp}");
                }
            }

            fclose($handle);
            if (!$fileId) throw new \Exception("No se obtuvo fileId tras upload. Último http: {$httpCode}");
            return $fileId;
        } finally {
            @unlink($path);
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
