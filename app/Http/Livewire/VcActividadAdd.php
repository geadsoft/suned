<?php

namespace App\Http\Livewire;

use App\Models\TmHorarios;
use App\Models\TmActividades;
use App\Models\TmFiles;
use App\Models\TdPeriodoSistemaEducativos;
use App\Models\TmPeriodosLectivos;
use Illuminate\Support\Facades\Http;


use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Str;

class VcActividadAdd extends Component
{
    use WithFileUploads;

    public $asignaturaId=0, $actividadId=0, $paralelo, $termino="1T", $bloque="1P", $tipo="AI", $nombre, $fecha, $hora;
    public $archivo='SI', $puntaje=10, $enlace="", $control="enabled";
    public $periodoId, $modalidadId, $tbltermino, $tblbloque, $tblactividad, $texteditor="";
    public $tblparalelo=[], $tblasignatura=[];
    public $array_attach=[];
    public $docenteId;

    protected $listeners = ['updateEditorData','retornar'];

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
        
        $ldate = date('Y-m-d H:i:s');
        $this->fecha = date('Y-m-d',strtotime($ldate));
        $this->hora = date('H:i');

        $this->docenteId = auth()->user()->personaId;

        $tblperiodos = TmPeriodosLectivos::where("aperturado",1)->first();
        $this->periodoId = $tblperiodos['id'];

        $this->tbltermino = TdPeriodoSistemaEducativos::query()
        ->where('periodo_id',$this->periodoId)
        ->where('tipo','EA')
        ->when($id==0,function($query){
            return $query->where('cerrar',0);
        })
        ->orderByRaw("cerrar,codigo")
        ->get();

        $this->termino = $this->tbltermino[0]['codigo'];

        $this->tblactividad = TdPeriodoSistemaEducativos::query()
        ->where('periodo_id',$this->periodoId)
        ->where('tipo','AC')
        ->where('codigo','<>','EX')
        ->get();

        $this->attach_add();

        if (!empty($this->tblparalelo)){
            $this->paralelo = $this->tblparalelo[0]["id"];
        }

        if ($id>0){
            $this->edit($id);
        }

    }

    
    public function render()
    {
        $this->tblbloque = TdPeriodoSistemaEducativos::query()
        ->where('periodo_id',$this->periodoId)
        ->where('tipo','PA')
        ->where('evaluacion',$this->termino)
        ->get();

        $this->tblmodalidad = TmHorarios::query()
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_generalidades as g","g.id","=","tm_horarios.grupo_id")
        ->where("tm_horarios.periodo_id",$this->periodoId)
        ->where("d.docente_id",$this->docenteId)
        ->selectRaw('g.id, g.descripcion')
        ->groupBy('g.id','g.descripcion')
        ->get();
        
        $this->tblasignatura = TmHorarios::query()
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as m","m.id","=","d.asignatura_id")
        ->where("tm_horarios.periodo_id",$this->periodoId)
        ->where('tm_horarios.grupo_id',$this->modalidadId)
        ->where("d.docente_id",$this->docenteId)
        ->selectRaw('m.id, m.descripcion')
        ->groupBy('m.id','m.descripcion')
        ->get();

        $this->updatedasignaturaId($this->asignaturaId);

        return view('livewire.vc-actividad-add',[
            'tblasignatura' => $this->tblasignatura,
        ]);

    }

    public function updateEditorData($data)
    {
        $this->texteditor = $data;
       
    }

    public function edit($id){

        
        /*$sistema = TdPeriodoSistemaEducativos::query()
        ->where("codigo",$this->termino)
        ->first();

        if ($sistema->cerrar==1){
            $this->control = "disabled";
        }*/

        
        $record = TmActividades::query()
        ->join("tm_horarios_docentes as d","d.id","=","tm_actividades.paralelo")
        ->join("tm_horarios as h","h.id","=","d.horario_id")
        ->select("tm_actividades.*","d.horario_id","d.asignatura_id","h.grupo_id")
        ->where("tm_actividades.id",$id)
        ->first()
        ->toArray();

        $this->modalidadId  = $record['grupo_id'];
        $this->asignaturaId = $record['asignatura_id'];


        $this->updatedasignaturaId($this->asignaturaId);

        $this->actividadId = $id;
        $this->paralelo = $record['paralelo'];
        $this->termino = $record['termino'];
        $this->bloque = $record['bloque'];
        $this->tipo = $record['actividad'];
        $this->nombre = $record['nombre'];
        $this->puntaje = $record['puntaje'];
        $this->enlace = $record['enlace'];
        $this->texteditor = $record['descripcion'];
        $this->estado = $record['estado'];


        $this->control="disabled";

        $this->fecha = date('Y-m-d',strtotime($record['fecha']));
        $this->hora = date('H:i',strtotime($record['fecha']));

        $this->descripcion=".";

        $tblfiles = TmFiles::query()
        ->where('actividad_id',$id)
        ->where('persona_id',$this->docenteId)
        ->where('actividad',1)
        ->get();

        $this->array_attach = [];
        foreach($tblfiles as $key => $files){

            $linea = count($this->array_attach);
            $linea = $linea+1;

            $attach=[
                'id' => $files['id'],
                'linea' => $linea,
                'adjunto' => $files['nombre'],
                'drive_id' => $files['drive_id'],
            ];

            array_push($this->array_attach,$attach);

        }

        if (count($tblfiles)==0){
            $this->attach_add();
        }

        $this->setEditorData($this->texteditor);

    }

    public function setEditorData($data){
        $this->texteditor = $data;
        
    }

    public function updatedasignaturaId($id){

        $this->asignaturaId = $id;

        $this->tblparalelo = TmHorarios::query()
        ->join("tm_servicios as s","s.id","=","tm_horarios.servicio_id")
        ->join("tm_cursos as c","c.id","=","tm_horarios.curso_id")
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as m","m.id","=","d.asignatura_id")
        ->where("tm_horarios.periodo_id",$this->periodoId)
        ->where('tm_horarios.grupo_id',$this->modalidadId)
        ->where("d.docente_id",$this->docenteId)        
        ->where("m.id",$id)
        ->selectRaw('d.id, concat(s.descripcion," ",c.paralelo) as descripcion')
        ->get();

        $message = "";
        
    }

    public function createData(){

        $this ->validate([
            'paralelo' => 'required',
            'termino' => 'required',
            'nombre' => 'required',
            'fecha' => 'required',
            'puntaje' => 'required'
        ]);

        $msgfile="";

        if ($this->actividadId>0){

            $this->updateData();
            $msgfile = $this->apiDrive($this->actividadId);            

        }else {
            
            $tblData = TmActividades::Create([
                'docente_id' => $this->docenteId,
                'paralelo' => $this->paralelo,
                'termino' => $this->termino,
                'bloque' => $this->bloque,
                'tipo' => 'AC',
                'actividad' => $this->tipo,
                'nombre' => $this->nombre,
                'descripcion' => $this->texteditor,
                'fecha' => $this->fecha.' '.$this->hora,
                'subir_archivo' => $this->archivo,
                'puntaje' => $this->puntaje,
                'enlace' => $this->enlace,
                'estado' => "A",
                'usuario' => auth()->user()->name,
            ]);

            $msgfile = $this->apiDrive($tblData->id);
            
        }

        $message = nl2br("Registro grabado con éxito!\n".$msgfile);
        $this->dispatchBrowserEvent('msg-grabar', ['newName' => $message]);
        
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


    public function updateData(){

        $record = TmActividades::find($this->actividadId);

        $record->update([
            'actividad' => $this->tipo,
            'nombre' => $this->nombre,
            'descripcion' => $this->texteditor,
            'fecha' => $this->fecha.' '.$this->hora,
            'subir_archivo' => $this->archivo,
            'puntaje' => $this->puntaje,
            'enlace' => $this->enlace,
            'estado' => $this->estado,
            'usuario' => auth()->user()->name,
        ]);


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
        ];

        array_push($this->array_attach,$attach);
        
    }


    public function attach_del($linea){

        $recnoToDelete = $this->array_attach;
        foreach ($recnoToDelete as $index => $recno)
        {
            if ($recno['linea'] == $linea){
                unset ($recnoToDelete[$index]);
                if ($recno['id']>0){
                    TmFiles::find($recno['id'])->delete();
                }
            } 
        }

        $this->reset(['array_attach']);
        $this->array_attach = $recnoToDelete;

        $linea = count($this->array_attach);
        
        if ($linea==0){
            $this->attach_add();
        }
    
    }


    public function download_drive($id){

        $url = route('archivo.descargar', ['id' => $id]);

        // Emitir evento para el navegador
        $this->dispatchBrowserEvent('iniciar-descarga', ['url' => $url]);

    }

    public function retornar(){
        return redirect()->to('/activities/activity');
    }

}
