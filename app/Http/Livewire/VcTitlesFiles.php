<?php

namespace App\Http\Livewire;
use App\Models\TmPeriodosLectivos;
use App\Models\TmGeneralidades;
use App\Models\TmPersonas;
use App\Models\TmMatricula;
use App\Models\TmServicios;
use App\Models\TmCursos;
use App\Models\TdTitulosActas;
use App\Models\TmHorarios;
use App\Models\User;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;


class VcTitlesFiles extends Component
{
    use WithPagination;
    use WithFileUploads;

    public bool $mostrarPanel = false;

    public ?int $estudianteSeleccionadoId = null;

    public $estudianteSeleccionado = null;

    public $archivo = null;

    protected $messages = [
        'form.recibido_acta_por.required' => 'Debe indicar quién recibió el Acta.',
        'form.recibido_titulo_por.required' => 'Debe indicar quién recibió el Título.',
        'form.fecha_acta.required' => 'Debe ingresar la fecha de entrega del Acta.',
        'form.fecha_titulo.required' => 'Debe ingresar la fecha de entrega del Título.',
    ];

    public array $form = [
        'acta' => false,
        'fecha_acta' => null,
        'entregado_acta_por' => '',
        'recibido_acta_por' => '',

        'titulo' => false,
        'fecha_titulo' => null,
        'entregado_titulo_por' => '',
        'recibido_titulo_por' => '',

        'comentario' => '',
    ];

    public $previus='', $current='', $nomnivel, $nomcurso, $documento;
    public $estudianteId,$periodoId,$grupoId,$nivelId,$gradoId,$cursoId,$numreg,$matriculaId;
    public $alumno,$titulo=false,$acta=false,$comentario,$fecha;

    public $filters = [
        'periodo' => '',
        'modalidad' => '',
        'curso' => '',
        'paralelo' => '',
        'nombre' => '',
        'estado' => '',
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

    public function mount(){

        $año   = date('Y');
        $ldate = date('Y-m-d H:i:s');
        $this->fecha = date('Y-m-d',strtotime($ldate));
        $tblperiodos = TmPeriodosLectivos::where("periodo",$año)->first();
        $this->filters['periodo'] = $tblperiodos['id'];
    }

    public function render()
    {   

        $modalidades = TmGeneralidades::where('superior',1)->get();

        $cursos = TmHorarios::query()
        ->join("tm_servicios as s","s.id","=","tm_horarios.servicio_id")
        ->where("tm_horarios.periodo_id",$this->filters['periodo'] )
        ->where('tm_horarios.grupo_id',$this->filters['modalidad'])
        ->selectRaw('s.id, s.descripcion')
        ->where('s.nivel_id',11)
        ->where('s.grado_id',17)
        ->get();

        $paralelos = TmHorarios::query()
        ->join("tm_servicios as s","s.id","=","tm_horarios.servicio_id")
        ->join("tm_cursos as c","c.id","=","tm_horarios.curso_id")
        ->where("tm_horarios.periodo_id",$this->filters['periodo'] )
        ->where('tm_horarios.grupo_id',$this->filters['modalidad'])
        ->where('s.id',$this->filters['curso'])
        ->where('s.nivel_id',11)
        ->where('s.grado_id',17)
        ->selectRaw('c.id, c.paralelo')
        ->groupByRaw('c.id, c.paralelo')
        ->get();

        $tblrecords = TmPersonas::query()
        ->join("tm_matriculas as m","tm_personas.id","=","m.estudiante_id")
        ->join("tm_cursos as c","c.id","=","m.curso_id")
        ->join("tm_servicios as s","s.id","=","c.servicio_id")
        ->join("tm_periodos_lectivos as p","p.id","=","m.periodo_id")
        ->join("tm_generalidades as g","g.id","=","m.modalidad_id")
        ->leftJoin('td_titulos_actas as t', function($join)
        {
            $join->on('t.matricula_id', '=', 'm.id');
        })
        ->when($this->filters['nombre'],function($query){
            return $query->where(DB::raw('concat(ltrim(rtrim(apellidos))," ",ltrim(rtrim(nombres)))'), 'LIKE' , "%{$this->filters['nombre']}%");
        })
        ->when($this->filters['periodo'],function($query){
            return $query->where('m.periodo_id',"{$this->filters['periodo']}");
        })
        ->when($this->filters['modalidad'],function($query){
            return $query->where('m.modalidad_id',"{$this->filters['modalidad']}");
        })
        ->when($this->filters['curso'],function($query){
            return $query->where('s.id',"{$this->filters['curso']}");
        })
        ->when($this->filters['paralelo'],function($query){
            return $query->where('c.id',"{$this->filters['paralelo']}");
        })
        
        ->when($this->filters['estado'] ?? null, function ($query, $estado) {

            switch ($estado) {
                case 'CO':
                    $query->where('t.acta_entreg', 1)
                        ->where('t.titulo_retirado', 1);
                    break;

                case 'AE':
                    $query->where('t.acta_retirada', 1)
                        ->where('t.titulo_retirado', 0);
                    break;

                case 'TE':
                    $query->where('t.acta_retirada', 0)
                        ->where('t.titulo_retirado', 1);
                    break;

                case 'PE':
                    $query->where(function ($q) {
                        $q->where('t.acta_retirada', 0)
                        ->orWhereNull('t.acta_retirada');
                    })
                    ->where(function ($q) {
                        $q->where('t.titulo_retirado', 0)
                        ->orWhereNull('t.titulo_retirado');
                    });
                    break;
            }

            return $query;
        })


        ->where('s.nivel_id',11)
        ->where('s.grado_id',17)
        ->select('m.id','identificacion','nombres','apellidos', 'documento', 'm.fecha', 'g.descripcion as nomgrupo','p.descripcion as nomperiodo',
        's.descripcion as nomgrado','c.paralelo','m.periodo_id','m.modalidad_id','m.nivel_id','c.servicio_id','m.curso_id','m.estudiante_id',
        'tm_personas.foto','t.acta_retirada','t.titulo_retirado','t.fecha_acta','t.fecha_titulo','t.usuario')
        ->orderbyRaw('m.modalidad_id,apellidos')
        ->paginate(10);

        $this->estudianteSeleccionado = TmMatricula::query()
        ->Join('tm_personas','tm_personas.id','=','tm_matriculas.estudiante_id')
        ->Join('tm_cursos','tm_cursos.id','=','tm_matriculas.curso_id')
        ->Join('tm_servicios','tm_servicios.id','=','tm_cursos.servicio_id')
        ->Join('tm_periodos_lectivos','tm_periodos_lectivos.id','=','tm_matriculas.periodo_id')
        ->where('tm_matriculas.id', $this->estudianteSeleccionadoId)
        ->select([
            'tm_matriculas.id',
            'tm_personas.nombres',
            'tm_personas.apellidos',
            'tm_matriculas.documento',
            'tm_personas.foto',
            'tm_servicios.descripcion as nomgrado',
            'tm_periodos_lectivos.descripcion as periodo',
        ])
        ->first();
        
        $tblgenerals = TmGeneralidades::where('superior',1)->get();
        $tblperiodos = TmPeriodosLectivos::orderBy("periodo","desc")->get();
        $this->tblservicios = TmServicios::all();
        $this->tblcursos    = TmCursos::all();
        $this->tbldatogen   = TmGeneralidades::all();

        $responsables = User::query()
        ->orderBy('name')
        ->get(['id', 'name']);
        
        return view('livewire.vc-titles-files',[
            'modalidades' => $modalidades,
            'cursos' => $cursos,
            'paralelos' => $paralelos,
            'estudiantes' => $tblrecords,
            'tblgenerals' => $tblgenerals,
            'tblperiodos' => $tblperiodos,
            'responsables' => $responsables,
        ]);

    }

    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }

    /*public function edit( $recnoId ){
               
        $this->selectId = $recnoId;
        $matricula = TmMatricula::find($this->selectId);
        $this->alumno = $matricula->estudiante['apellidos'].' '.$matricula->estudiante['nombres'];
        $this->estudianteId = $matricula['estudiante_id'];
        $this->dispatchBrowserEvent('show-form');

    }*/

    public function updatedFormActa(bool $valor): void
    {
        if ($valor) {
            $this->form['fecha_acta'] = now()->format('Y-m-d');

            $this->form['entregado_acta_por'] =
                auth()->user()?->name ?? '';
        } else {
            $this->form['fecha_acta'] = null;
            $this->form['entregado_acta_por'] = '';
            $this->form['recibido_acta_por'] = '';
        }

    }

    public function updatedFormTitulo(bool $valor): void
    {
           
        if ($valor) {
            $this->form['fecha_titulo'] = now()->format('Y-m-d');

            $this->form['entregado_titulo_por'] =
                auth()->user()?->name ?? '';
        } else {
            $this->form['fecha_titulo'] = null;
            $this->form['entregado_titulo_por'] = '';
            $this->form['recibido_titulo_por'] = '';
        }
    }
   
    protected function rules(): array
    {
        return [
            'form.acta' => ['boolean'],
            'form.fecha_acta' => [
                $this->form['acta']
                    ? 'required'
                    : 'nullable',
                'date',
            ],
            'form.entregado_acta_por' => [
                $this->form['acta']
                    ? 'required'
                    : 'nullable',
                'string',
                'max:100',
            ],
            'form.recibido_acta_por' => [
                $this->form['acta']
                    ? 'required'
                    : 'nullable',
                'string',
                'max:100',
            ],

            'form.titulo' => ['boolean'],
            'form.fecha_titulo' => [
                $this->form['titulo']
                    ? 'required'
                    : 'nullable',
                'date',
            ],
            'form.entregado_titulo_por' => [
                $this->form['titulo']
                    ? 'required'
                    : 'nullable',
                'string',
                'max:100',
            ],
            'form.recibido_titulo_por' => [
                $this->form['titulo']
                    ? 'required'
                    : 'nullable',
                'string',
                'max:100',
            ],

            'form.comentario' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'archivo' => [
                'nullable',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:10240',
            ],
        ];

    }
    
    public function guardarEntrega(): void
    {
        $this->validate();

        //dd($this->estudianteSeleccionadoId);

        if (!$this->estudianteSeleccionadoId) {
            $this->addError(
                'estudiante',
                'No se ha seleccionado un estudiante.'
            );

            return;
        }

    
        $registro = TdTitulosActas::query()->firstOrNew([
            'matricula_id' => $this->estudianteSeleccionadoId,
        ]);

        $registro->acta_retirada =
            (bool) $this->form['acta'];

        $registro->fecha_acta =
            $this->form['acta']
                ? $this->form['fecha_acta']
                : null;

        $registro->entregado_acta_por =
            $this->form['acta']
                ? $this->form['entregado_acta_por']
                : null;

        $registro->recibido_acta_por =
            $this->form['acta']
                ? $this->form['recibido_acta_por']
                : null;

        $registro->titulo_retirado =
            (bool) $this->form['titulo'];

        $registro->fecha_titulo =
            $this->form['titulo']
                ? $this->form['fecha_titulo']
                : null;

        $registro->entregado_titulo_por =
            $this->form['titulo']
                ? $this->form['entregado_titulo_por']
                : null;

        $registro->recibido_titulo_por =
            $this->form['titulo']
                ? $this->form['recibido_titulo_por']
                : null;

        $registro->comentario =
            !empty($this->form['comentario'])
                ? $this->form['comentario']
                : null;

        $registro->usuario =
            auth()->user()?->name;

        if ($this->archivo) {
        
            $apidrive = $this->apiDrive($this->estudianteSeleccionadoId,$this->archivo);
            
            $registro->archivo =
            !empty($apidrive['archivo'])
                ? $apidrive['archivo']
                : null;

            $registro->drive_id =
            !empty($apidrive['driveId'])
                ? $apidrive['driveId']
                : null;

        }

        $registro->save();
       
        $this->dispatchBrowserEvent('show-message', [
            'type'    => 'success',
            'message' => 'Entrega de documentos guardada correctamente.',
        ]);

        $this->cerrarPanel();
    }

    public function abrirPanel(int $estudianteId): void
    {
        $this->resetValidation();
        $this->reset('archivo');

        $this->estudianteSeleccionadoId = $estudianteId;
        
        /*
        * Reemplaza TmMatricula por el mismo modelo o consulta
        * que utilizas para obtener $estudiantes.
        */
        $this->estudianteSeleccionado = TmMatricula::query()
            ->Join('tm_personas','tm_personas.id','=','tm_matriculas.estudiante_id')
            ->Join('tm_cursos','tm_cursos.id','=','tm_matriculas.curso_id')
            ->Join('tm_servicios','tm_servicios.id','=','tm_cursos.servicio_id')
            ->Join('tm_periodos_lectivos','tm_periodos_lectivos.id','=','tm_matriculas.periodo_id')
            ->where('tm_matriculas.id', $estudianteId)
            ->select([
                'tm_matriculas.id',
                'tm_personas.nombres',
                'tm_personas.apellidos',
                'tm_matriculas.documento',
                'tm_personas.foto',
                'tm_servicios.descripcion as nomgrado',
                'tm_periodos_lectivos.descripcion as periodo',
            ])
            ->first();

        $registro = TdTitulosActas::query()
            ->where('matricula_id', $estudianteId)
            ->first();

        $this->form = [
            'acta' => (bool) ($registro?->acta_retirada ?? false),

            'fecha_acta' => $registro?->fecha_acta
                ? \Carbon\Carbon::parse($registro->fecha_acta)
                    ->format('Y-m-d')
                : null,

            'entregado_acta_por' =>
                $registro?->entregado_acta_por ?? '',

            'recibido_acta_por' =>
                $registro?->recibido_acta_por ?? '',

            'titulo' => (bool) ($registro?->titulo_retirado ?? false),

            'fecha_titulo' => $registro?->fecha_titulo
                ? \Carbon\Carbon::parse($registro->fecha_titulo)
                    ->format('Y-m-d')
                : null,

            'entregado_titulo_por' =>
                $registro?->entregado_titulo_por ?? '',

            'recibido_titulo_por' =>
                $registro?->recibido_titulo_por ?? '',

            'comentario' => $registro?->comentario ?? '',
        ];

        $this->mostrarPanel = true;
    }
    
    public function cerrarPanel(): void
    {
        $this->mostrarPanel = false;
        $this->estudianteSeleccionadoId = null;
        $this->estudianteSeleccionado = null;

        $this->reset('archivo');
        $this->resetValidation();

        $this->form = [
            'acta' => false,
            'fecha_acta' => null,
            'entregado_acta_por' => '',
            'recibido_acta_por' => '',

            'titulo' => false,
            'fecha_titulo' => null,
            'entregado_titulo_por' => '',
            'recibido_titulo_por' => '',

            'comentario' => '',
        ];
    }
    
    public function apiDrive($matriculaId, $archivo){
 
        $accessToken = $this->token();
        $fileId  ="";
        $msgfile ="";

        sleep(3); // Simula espera
            
        $file = $archivo;

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
        
        return [
                'archivo' =>  $archivo.'.'.$ext,
                'driveId' => $fileId,
            ];
        

    }
}
