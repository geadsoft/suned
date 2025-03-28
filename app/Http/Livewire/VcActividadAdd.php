<?php

namespace App\Http\Livewire;

use App\Models\TmHorarios;
use App\Models\TmActividades;
use App\Models\TdPeriodoSistemaEducativos;
use App\Models\TmPeriodosLectivos;
use Illuminate\Support\Facades\Http;


use Livewire\Component;
use Livewire\WithFileUploads;
use Str;

class VcActividadAdd extends Component
{
    use WithFileUploads;

    public $asignaturaId=0, $actividadId=0, $paralelo, $termino="1T", $bloque="1P", $tipo="AI", $nombre, $fecha, $archivo='SI', $puntaje=10, $enlace="", $control="enabled";
    public $periodoId, $tbltermino, $tblbloque, $tblactividad;
    public $tblparalelo=[], $tblasignatura=[];
    public $array_attach=[];
    public $docenteId;

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
        $this->docenteId = auth()->user()->personaId;

        $tblperiodos = TmPeriodosLectivos::where("aperturado",1)->first();
        $this->periodoId = $tblperiodos['id'];

        $this->tbltermino = TdPeriodoSistemaEducativos::query()
        ->where('periodo_id',$this->periodoId)
        ->where('tipo','EA')
        ->get();

        $this->termino = $this->tbltermino[0]['codigo'];

        $this->tblactividad = TdPeriodoSistemaEducativos::query()
        ->where('periodo_id',$this->periodoId)
        ->where('tipo','AC')
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
        
        $this->tblasignatura = TmHorarios::query()
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as m","m.id","=","d.asignatura_id")
        ->where("d.docente_id",$this->docenteId)
        ->where("tm_horarios.periodo_id",$this->periodoId)
        ->selectRaw('m.id, m.descripcion')
        ->groupBy('m.id','m.descripcion')
        ->get();

        $this->updatedasignaturaId($this->asignaturaId);

        return view('livewire.vc-actividad-add',[
            'tblasignatura' => $this->tblasignatura,
        ]);

    }

    public function edit($id){
        
        $record = TmActividades::query()
        ->join("tm_horarios_docentes as d","d.id","=","tm_actividades.paralelo")
        ->select("tm_actividades.*","d.horario_id","d.asignatura_id")
        ->where("tm_actividades.id",$id)
        ->first()
        ->toArray();

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
        $this->descripcion = $record['descripcion'];
        $this->control="disabled";

        $fecha = date('Y-m-d',strtotime($record['fecha']));
        $this->fecha = $fecha;

        $this->descripcion=".";

    }

    public function updatedasignaturaId($id){

        $this->asignaturaId = $id;

        $this->tblparalelo = TmHorarios::query()
        ->join("tm_servicios as s","s.id","=","tm_horarios.servicio_id")
        ->join("tm_cursos as c","c.id","=","tm_horarios.curso_id")
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as m","m.id","=","d.asignatura_id")
        ->where("d.docente_id",$this->docenteId)
        ->where("tm_horarios.periodo_id",$this->periodoId)
        ->where("m.id",$id)
        ->selectRaw('d.id, concat(s.descripcion," ",c.paralelo) as descripcion')
        ->get();

        $message = "";
        $this->dispatchBrowserEvent('chk-editor', ['newName' => $message]);
    }


    public function createData(){

        $accessToken = $this->token();

        foreach ($this->array_attach as $attach){
            $file = $attach['adjunto'];
            $name = Str::sLug($file->getClientOriginalName());
            $mime = $file->getClientMimeType();
        }

            $reponse = Http::withHeaders([
                'Autorization' => 'Bearer '.$accessToken,
                'Content-Type' => 'Application/json'
            ])->post('https://www.gooleapis.com/drive/v3/file',[
                'data' => $name,
                'mimeType' => $mime,
                'uploadType' => 'media',
            ]);

            if ($reponse->successful()){
                $msgfile = "Archivo cargado a Google Drive";
            }else{
                $msgfile = "Cargar fallida en Google Drive";
            }

            $message = "Registro grabado con éxito!"."/n".$msgfile;
            $this->dispatchBrowserEvent('msg-grabar', ['newName' => $message]);

        /*$this ->validate([
            'paralelo' => 'required',
            'termino' => 'required',
            'nombre' => 'required',
            'fecha' => 'required',
            'puntaje' => 'required',
            'nombre' => 'required',
        ]);

        if ($this->actividadId>0){

            $this->updateData();            

        }else {
            
            TmActividades::Create([
                'docente_id' => $this->docenteId,
                'paralelo' => $this->paralelo,
                'termino' => $this->termino,
                'bloque' => $this->bloque,
                'tipo' => 'AC',
                'actividad' => $this->tipo,
                'nombre' => $this->nombre,
                'descripcion' => "",
                'fecha' => $this->fecha,
                'subir_archivo' => $this->archivo,
                'puntaje' => $this->puntaje,
                'enlace' => $this->enlace,
                'estado' => "A",
                'usuario' => auth()->user()->name,
            ]);

            $accessToken = $this->token();

            $name = Str::sLug($file->getClientOriginalName());
            $mime = $file->getClientMimeType();

            $reponse = Https::withHeaders([
                'Autorization' => 'Bearer '.$accessToken,
                'Content-Type' => 'Application/json'
            ])->post('https://www.gooleapis.com/drive/v3/file',[
                'data' => $name,
                'mimeType' => $mime,
                'uploadType' => 'resumable',
            ]);

            if ($reponse->successful()){
                $msgfile = "Archivo cargado a Google Drive"
            }else{
                $msgfile = "Cargar fallida en Google Drive"
            }

            $message = "Registro grabado con éxito!"."/n".$msgfile;
            $this->dispatchBrowserEvent('msg-grabar', ['newName' => $message]);

            return redirect()->to('/activities/activity');
        }*/
        
    }


    public function updateData(){

        $record = TmActividades::find($this->actividadId);
            
        $record->update([
            'actividad' => $this->tipo,
            'nombre' => $this->nombre,
            'descripcion' => "",
            'fecha' => $this->fecha,
            'subir_archivo' => $this->archivo,
            'puntaje' => $this->puntaje,
            'enlace' => $this->enlace,
            'usuario' => auth()->user()->name,
        ]);

        $message = "Registro actualizado con éxito!";
        $this->dispatchBrowserEvent('msg-grabar', ['newName' => $message]);

        return redirect()->to('/activities/activity');

    }
        
    public function attach_add()
    {
        $linea = count($this->array_attach);
        $linea = $linea+1;

        $attach=[
            'linea' => $linea,
            'adjunto' => "",
        ];

        array_push($this->array_attach,$attach);
        
    }


    public function attach_del($linea){

        $recnoToDelete = $this->array_attach;
        foreach ($recnoToDelete as $index => $recno)
        {
            if ($recno['linea'] == $linea){
                unset ($recnoToDelete[$index]);
            } 
        }

        $this->reset(['array_attach']);
        $this->array_attach = $recnoToDelete;
    
    }








}
