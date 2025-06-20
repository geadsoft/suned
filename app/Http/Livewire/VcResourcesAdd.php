<?php

namespace App\Http\Livewire;
use App\Models\TmFiles;
use App\Models\TmPeriodosLectivos;
use App\Models\TmHorarios;
use App\Models\TmRecursos;
use App\Models\TdRecursosCursos;

use Illuminate\Support\Facades\Http;


use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class VcResourcesAdd extends Component
{
    use WithFileUploads;

    public $recursoId, $asignaturaId, $nombre, $enlace="", $control, $texteditor, $estado='A';
    public $array_attach=[], $tblasignatura, $accion;
    public $selectedCursos = [];

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

    public function mount($id, $action)
    {
        $this->accion = $action;

        $ldate = date('Y-m-d H:i:s');
        $this->recursoId = $id;

        $this->docenteId = auth()->user()->personaId;

        $tblperiodos = TmPeriodosLectivos::where("aperturado",1)->first();
        $this->periodoId = $tblperiodos['id'];

        $this->attach_add();

        if ($id>0){
            $this->edit($id);
        }

    }
    
    public function render()
    {
        $this->tblasignatura = TmHorarios::query()
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as m","m.id","=","d.asignatura_id")
        ->where("tm_horarios.periodo_id",$this->periodoId)
        ->where("d.docente_id",$this->docenteId)
        ->selectRaw('m.id, m.descripcion')
        ->groupBy('m.id','m.descripcion')
        ->get();

        $this->tblparalelo = TmHorarios::query()
        ->join("tm_servicios as s","s.id","=","tm_horarios.servicio_id")
        ->join("tm_cursos as c","c.id","=","tm_horarios.curso_id")
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as m","m.id","=","d.asignatura_id")
        ->join("tm_generalidades as g","g.id","=","tm_horarios.grupo_id")
        ->join("tm_generalidades as g2","g2.id","=","s.nivel_id")
        ->where("tm_horarios.periodo_id",$this->periodoId)
        ->where("d.docente_id",$this->docenteId)        
        ->selectRaw('g.descripcion as modalidad,g2.descripcion as nivel,s.descripcion as curso,c.paralelo,c.id')
        ->groupByRaw('g.descripcion,g2.descripcion,s.descripcion,c.paralelo,c.id')
        ->get();

        $this->tblparalelo = $this->tblparalelo
        ->groupBy('modalidad')
        ->map(function ($modalidadGroup) {
            return $modalidadGroup->groupBy('nivel');
        });
        
        return view('livewire.vc-resources-add');
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

    public function edit($id){

        $tblrecords = TmRecursos::find($id);
        $this->periodoId = $tblrecords->periodo_id;
        $this->docenteId = $tblrecords->docente_id;
        $this->asignaturaId = $tblrecords->asignatura_id;
        $this->nombre = $tblrecords->nombre;
        $this->enlace = $tblrecords->enlace;

        $tblfiles = TmFiles::query()
        ->where('actividad_id',$id)
        ->where('persona_id',$this->docenteId)
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

        $cursos = TdRecursosCursos::where("recurso_id",$id)->get();
        foreach($cursos as $key => $curso){
            $this->selectedCursos[] = $curso->curso_id;
        }
       
        
        if (count($tblfiles)==0){
            $this->attach_add();
        }

        $this->control = 'disabled';

    }

    public function createData(){

        $this ->validate([
            'asignaturaId' => 'required',
            'nombre' => 'required',
        ]);

        $msgfile="";

        if ($this->recursoId>0){

            $this->updateData();
            $msgfile = $this->apiDrive($this->recursoId);            

        }else {
            
            $tblData = TmRecursos::Create([
                'periodo_id' => $this->periodoId,
                'docente_id' => $this->docenteId,
                'asignatura_id' => $this->asignaturaId,
                'nombre' => $this->nombre,
                'enlace' => $this->enlace,
                'estado' => "A",
                'usuario' => auth()->user()->name,
            ]);

            foreach($this->selectedCursos as $recurso){
                TdRecursosCursos::Create([
                'recurso_id' => $tblData->id,
                'curso_id' => $recurso,
                'usuario' => auth()->user()->name,
            ]);
            } 

            $msgfile = $this->apiDrive($tblData->id);
            
        }

        $message = nl2br("Registro grabado con éxito!\n".$msgfile);
        $this->dispatchBrowserEvent('msg-grabar', ['newName' => $message]);
        
    }


    public function updateData(){

        $record = TmRecursos::find($this->recursoId);

        $record->update([
            'nombre' => $this->nombre,
            'enlace' => $this->enlace,
            'estado' => $this->estado,
            'usuario' => auth()->user()->name,
        ]);

        TdRecursosCursos::where('recurso_id',$this->recursoId)->delete();

        foreach($this->selectedCursos as $recurso){
                TdRecursosCursos::Create([
                'recurso_id' => $this->recursoId,
                'curso_id' => $recurso,
                'usuario' => auth()->user()->name,
            ]);
        } 

    }

    public function apiDrive($selectId){
 
        $accessToken = $this->token();
        $fileId  ="";
        $msgfile ="";

        foreach ($this->array_attach as $attach){

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
                'recurso' => true,
                'drive_id' => $fileId,
                'usuario' => auth()->user()->name,
            ]);

        }

       return  $msgfile;
    }

}
