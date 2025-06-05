<?php

namespace App\Http\Livewire;
use App\Models\TmHorarios;
use App\Models\TmHorariosDocentes;
use App\Models\TmActividades;
use App\Models\TmAsignaturas;
use App\Models\TdPeriodoSistemaEducativos;
use App\Models\TmPeriodosLectivos;
use App\Models\TmFiles;
use App\Models\TmMatriculas;
use Illuminate\Support\Facades\Http;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class VcActividadView extends Component
{
    public $asignatura, $curso,  $termino="1T", $bloque="1P", $tipo="AI", $nombre, $fecha, $archivo='SI', $puntaje=10, $enlace="", $descripcion="", $estado="A";
    public $periodoId, $tbltermino, $tblbloque, $tblactividad, $actividadId;
    public $array_attach=[];
    public $array_entregas=[];
    public $personas=[];
    public $arrtermino, $arrbloque, $arractividad;
    
    public $arrestado=[
        'A' => 'Activo',
        'F' => 'Finalizado',
        'C' => 'Cerrado',
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

        $this->docenteId = auth()->user()->personaId;
        $this->actividadId = $id;

        $tblperiodos = TmPeriodosLectivos::where("aperturado",1)->first();
        $this->periodoId = $tblperiodos['id'];

        $this->tbltermino = TdPeriodoSistemaEducativos::query()
        ->where('periodo_id',$this->periodoId)
        ->where('tipo','EA')
        ->get();

        foreach ($this->tbltermino as $data){
            $this->arrtermino[$data['codigo']] = $data['descripcion'];
        }

        $this->termino = $this->tbltermino[0]['codigo'];


        $this->tblbloque = TdPeriodoSistemaEducativos::query()
        ->where('periodo_id',$this->periodoId)
        ->where('tipo','PA')
        ->where('evaluacion',$this->termino)
        ->get();

        foreach ($this->tblbloque as $data){
            $this->arrbloque[$data['codigo']] = $data['descripcion'];
        }

        $this->tblactividad = TdPeriodoSistemaEducativos::query()
        ->where('periodo_id',$this->periodoId)
        ->where('tipo','AC')
        ->get();

        foreach ($this->tblactividad as $data){
            $this->arractividad[$data['codigo']] = $data['descripcion'];
        }

        $this->edit($id);

    }

    public function render()
    {
        $actividad = TmActividades::find($this->actividadId);
        
        //Entregas
        $this->array_entregas = TmFiles::query()
        ->where('actividad_id',$this->actividadId)
        ->where('entrega',1)
        ->get();

        $this->personas = TmHorarios::query()
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_matriculas as m","m.curso_id","=","tm_horarios.curso_id")
        ->join("tm_personas as p","p.id","=","m.estudiante_id")
        ->select("p.id","nombres","apellidos")
        ->where('d.id',$actividad->paralelo)
        ->orderByRaw("apellidos, nombres")
        ->get();

        return view('livewire.vc-actividad-view');
    }

    public function edit($id){
        
        $record = TmActividades::query()
        ->join("tm_horarios_docentes as d","d.id","=","tm_actividades.paralelo")
        ->select("tm_actividades.*","d.horario_id","d.asignatura_id")
        ->where("tm_actividades.id",$id)
        ->first()
        ->toArray();

        //Adjuntos
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

        $this->termino = $record['termino'];
        $this->bloque = $record['bloque'];
        $this->tipo = $record['actividad'];
        $this->nombre = $record['nombre'];
        $this->fecha = $record['fecha'];
        $this->puntaje = $record['puntaje'];
        $this->enlace = $record['enlace'];
        $this->descripcion = json_encode($record['descripcion']);

        $this->estado = $record['estado'];

        $day = date('l', strtotime($this->fecha));

        $tblmateria = TmAsignaturas::find($record['asignatura_id']);
        $this->asignatura =  $tblmateria['descripcion'];

        $tblcurso = TmHorarios::query()
        ->join("tm_cursos as c","c.id","=","tm_horarios.curso_id")
        ->join("tm_servicios as s","s.id","=","c.servicio_id")
        ->selectRaw("concat(s.descripcion,' ',c.paralelo) as curso")
        ->where("tm_horarios.id",$record['horario_id'])
        ->first();

        $this->curso =  $tblcurso['curso'];

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

}
