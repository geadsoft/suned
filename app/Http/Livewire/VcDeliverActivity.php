<?php

namespace App\Http\Livewire;
use App\Models\TmActividades;
use App\Models\TdActividadesEntregas;
use App\Models\TmFiles;
use Illuminate\Support\Facades\Http;


use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class VcDeliverActivity extends Component
{
    
    use WithFileUploads;
    
    public $selectId, $record, $display_estado="", $display_text="display:none";
    public $data, $personaId, $tiempo, $estado="No Entregado", $texteditor="", $descripcion;
    public $array_attach=[], $files=[], $entregas=[], $datos=[];
    public $showEditor = false;
    public bool $showModal=false;

    public $arrdoc = [
        'doc' => 'ri-file-word-2-line',
        'docx' => 'ri-file-word-2-line',
        'xls' => 'ri-file-excel-2-line',
        'xlsx' => 'ri-file-excel-2-line',
        'ppt' => ' ri-file-ppt-2-line',
        'pptx' => 'ri-file-ppt-2-line',
        'pdf' => 'ri-file-pdf-line',
        'html' => 'ri-file-code-line',
        'jpg' => 'ri-picture-in-picture-fill',
        'png' => 'ri-picture-in-picture-fill',
    ];

    public $arrcolor = [  
        'doc' => 'text-primary',
        'docx' => 'text-primary',
        'jpg' => 'text-warning',
        'png' => 'text-warning',
        'xls' => 'text-success',
        'xlsx' => 'text-success',
        'ppt' => ' text-danger',
        'pptx' => 'text-danger',
        'pdf' => 'text-danger',
        'html' => 'text-info',
    ];

    protected $listeners = ['updateEditorData','cancel','apiDrive'];

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
    
    public function mount($id, $data){

        $this->selectId  = $id;
        $this->personaId = auth()->user()->personaId;
        $this->datos = $data;

        $this->attach_add();
        $this->load();
        
    }
    
    public function render()
    {

        $this->record = TmActividades::query()
        ->join("tm_horarios_docentes as h","h.id","=","tm_actividades.paralelo")
        ->join("tm_asignaturas as a","a.id","=","h.asignatura_id")
        ->where("tm_actividades.id",$this->selectId) 
        ->select("tm_actividades.*","a.descripcion as asignatura")   
        ->where("tm_actividades.id",$this->selectId)
        ->first();
        
        return view('livewire.vc-deliver-activity');
        
    }

    public function updateEditorData($editor)
    {
        $this->texteditor = $editor;
    }

    public function setEditorData($editor){
        $this->texteditor = $editor;
    }

    public function load(){

        $this->record = TmActividades::query()
        ->join("tm_horarios_docentes as h","h.id","=","tm_actividades.paralelo")
        ->join("tm_asignaturas as a","a.id","=","h.asignatura_id")
        ->where("tm_actividades.id",$this->selectId) 
        ->select("tm_actividades.*","a.descripcion as asignatura")   
        ->where("tm_actividades.id",$this->selectId)
        ->first();
        
        $this->descripcion = json_encode($this->record['descripcion']);
        
        $fechaInicial  = date('Y-m-d H:i:s');
        $fechaFinal = $this->record['fecha'];
        
        $segundos = strtotime($fechaFinal) - strtotime($fechaInicial);
        $this->tiempo = $this->seg_a_dhms( $segundos );

        $this->entrega = TdActividadesEntregas::query()
        ->where('actividad_id',$this->selectId)
        ->where('persona_id',$this->personaId)
        ->first();

        if (!empty($this->entrega)){
            $this->estado = "Enviado para Calificar";
            $this->estado_alert = "alert-success";
            $this->texteditor = $this->entrega->comentario;
        }

        //Archivos Adjuntos
        $this->adjuntos = TmFiles::query()
        ->where('actividad_id',$this->selectId)
        ->where('actividad',1)
        ->get();
        

        //Entregas Realizadas
        $this->files = TmFiles::query()
        ->where('actividad_id',$this->selectId)
        ->where('persona_id',$this->personaId)
        ->where('tarea',1)
        ->get();


         if ($this->files->isEmpty() && $this->entrega !== null){
            $this->estado = "Archivo no pudo ser cargado..";
            $this->estado_alert = "alert-danger";
        }

        if (count($this->files)>0){

            $this->array_attach = [];
            foreach($this->files as $key => $files){

            $linea = count($this->array_attach);
            $linea = $linea+1;

                $attach=[
                'id' => $files->id,
                'linea' => $linea,
                'adjunto' => $files->nombre,
                'drive_id' => $files->drive_id,
                'user_id' => auth()->id(),
                ];

                array_push($this->array_attach,$attach);

            }

        }

    }

    function seg_a_dhms($seg) { 
        $d = floor($seg / 86400);
        $h = floor(($seg - ($d * 86400)) / 3600);
        $m = floor(($seg - ($d * 86400) - ($h * 3600)) / 60);
        $s = $seg % 60; 

        return "$d Días, $h horas, $m minutos, $s segundos"; 
    }
    
    public function createData(){

        $fecha = date('Y-m-d H:i:s');
        $msgfile = "";

        if ($this->showEditor){

            $entregaId = $this->entrega->id;
            $record = TdActividadesEntregas::find($entregaId);
            $record->update([
                'comentario' => $this->texteditor,
            ]);

        }else{

            $record = TdActividadesEntregas::Create([
                'fecha' => $fecha,
                'actividad_id' => $this->selectId,
                'persona_id' => $this->personaId,
                'comentario' => $this->texteditor,
                'nota' => 0,
                'usuario' => auth()->user()->name,
            ]);

        }
 
        $this->showModal = true;

        // Espera simulada
        $this->dispatchBrowserEvent('mostrar-modal-espera');       
    } 

    public function entrega(){
        
        $this->display_estado="display:none";
        
        if (!empty($this->entrega)){
            $this->showEditor=true;
        }
            
        //$message = json_decode($this->descripcion);
        //$this->dispatchBrowserEvent('entrega', ['newName' => $message]);
    }

    public function attach_add()
    {
        $linea = count($this->array_attach);
        $linea = $linea+1;

        $attach=[
            'id' => 0,
            'linea' => $linea,
            'adjunto' => "",
            'drive_id' => "",
            'user_id' => auth()->id(),
        ];

        array_push($this->array_attach,$attach);
        
        
    }


    public function attach_del($linea){

        $recnoToDelete = $this->array_attach;
        foreach ($recnoToDelete as $index => $recno) {
            if ($recno['linea'] == $linea && $recno['user_id'] == auth()->id())  {

                // Seguridad: verificar que el archivo pertenece al usuario antes de eliminar
                $archivo = TmFiles::where('id', $recno['id'])
                            ->where('persona_id', $this->personaId)
                            ->first();

                if ($archivo) {
                    $archivo->delete();
                    unset($recnoToDelete[$index]);
                    $this->deleteFromDrive($recno['drive_id']);
                }
            }
        }

        $this->reset(['array_attach']);
        $this->array_attach = array_values($recnoToDelete); 
    
    }

    private function deleteFromDrive($fileId)
    {
        $accessToken = $this->token(); // Tu función que obtiene el access_token

        $response = Http::withToken($accessToken)
        ->delete("https://www.googleapis.com/drive/v3/files/{$fileId}");

        /*if ($response->successful()) {
            return "Archivo eliminado correctamente.";
        } else {
            return "Error al eliminar el archivo: " . $response->body();
        }*/
    }

    #[On('apiDrive')]
    public function apiDrive(){
        
        $selectId = $this->selectId;
        $accessToken = $this->token();
        $fileId  ="";
        $msgfile ="";

        
        foreach ($this->array_attach as $attach){

            if (isset($attach['user_id']) && $attach['user_id'] != auth()->id()) {
                continue; // Ignora si no es del usuario actual
            }

            if ($attach['id']>0) { 
                continue;
            }

            if ($attach['adjunto']=="") { 
                continue;
            }
            
            $file = $attach['adjunto'];

            $name = $file->getClientOriginalName();
            $name = pathinfo($name, PATHINFO_FILENAME);
            $name = preg_replace('/[^A-Za-z0-9_\-]/', '_', $name); // sanitizar nombre

            $archivo = $name;
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
            $fileContent = file_get_contents(storage_path("app/public/$pathfile"));

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

            $responseData = json_decode($response->body(), true);
            if ($response->successful() && isset($responseData['id'])) {
                $fileId = $responseData['id'];
                $msgfile = "Archivo cargado a Google Drive";
            } else {
                $msgfile = "Error al subir a Google Drive: " . ($response->body() ?: 'Sin respuesta');
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
                'tarea' => true,
                'actividad_id' => $selectId,
                'persona_id' => $this->personaId,
                'nombre' => $archivo.'.'.$ext,
                'extension' => $ext,
                'entrega' => true,
                'drive_id' => $fileId,
                'usuario' => auth()->user()->name,
            ]);

        }

        //return $msgfile;

        /*$message = "Registro grabado con éxito!"."\n".$msgfile;
        $this->dispatchBrowserEvent('msg-grabar', ['newName' => $message]);*/
        $message = nl2br("Registro grabado con éxito!\n".$msgfile);
        $this->dispatchBrowserEvent('msg-grabar', ['newName' => $message]);

        $this->showModal = false; // Oculta modal después de subir
        $this->array_attach = [];

    }

    public function download_drive($id){

        $file = TmFiles::find($id);

        $accessToken = $this->token();
        
        // Obtener el contenido del archivo
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
        ])->get("https://www.googleapis.com/drive/v3/files/{$file->drive_id}?alt=media");

        if ($response->successful()) {
            $fileName = $file->nombre;

            // Guardar en el disco 'public' dentro de la carpeta 'archivos'
            $filePath = 'archivos/' . $fileName;
            Storage::disk('public')->put($filePath, $response->body());

            // Descargar el archivo (desde almacenamiento local)
            return response()->download(storage_path('app/public/' . $filePath));

            $contents = Storage::disk('public')->exists('archivos/'.$fileName);
            if ($contents){
                Storage::disk('public')->delete('archivos/'.$fileName);
            }

        }


    }

    public function cancel(){
        return redirect(request()->header('Referer'));
    }

    public function retornar(){
        return redirect('student/activities');
    }
    
}
