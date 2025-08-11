<?php


namespace App\Http\Livewire;
use App\Models\TmHorarios;
use App\Models\TmHorariosDocentes;
use App\Models\TmActividades;
use App\Models\TmAsignaturas;
use App\Models\TmPeriodosLectivos;
use App\Models\TmFiles;
use App\Models\TdCalificacionActividades;
use App\Models\TdPeriodoSistemaEducativos;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class VcExamenView extends Component
{   
    public $asignatura, $curso,  $termino="1T", $bloque="1P", $tipo="AI", $nombre, $fecha, $archivo='SI', $puntaje=10, $enlace="", $descripcion="", $estado="A";
    public $array_attach=[],$control = "enabled";
    public $docenteId, $examenId, $modalidadId, $periodoId;
    public $personas=[];
    public $tblrecords=[];
    
    public $arrtermino=[
        '1T' => 'Primer Trimestre',
        '2T' => 'Segundo Trimestre',
        '3T' => 'Tercer Trimestre',
    ];

    public $arrbloque=[
        '1P' => 'Primer Parcial',
        '2P' => 'Segundo Parcial',
        '3P' => 'Tercer Parcial',
    ];

    public $arractividad=[
        'AI' => 'Actividad Individual',
        'AG' => 'Actividad Grupal',
    ];

    public $arrestado=[
        'A' => 'Activo',
        'I' => 'Inactivo',
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
        $this->examenId = $id;
        $this->modalidadId = 0;

        $tblperiodos = TmPeriodosLectivos::where("aperturado",1)->first();
        $this->periodoId = $tblperiodos['id'];

        $this->edit($id);

    }

    public function render()
    {
        $actividad = TmActividades::find($this->examenId);

        $this->personas = TmHorariosDocentes::query()
        ->join("tm_horarios as h","h.id","=","tm_horarios_docentes.horario_id")
        ->join(DB::raw("(select estudiante_id, modalidad_id, periodo_id, curso_id, estado 
        from tm_matriculas m 
        where m.modalidad_id = ".$this->modalidadId."  and m.periodo_id = ".$this->periodoId."
        union all
        select m.estudiante_id, p.modalidad_id, m.periodo_id, p.curso_id, m.estado
        from tm_pase_cursos p
        inner join tm_matriculas m on m.id = p.matricula_id
        where p.modalidad_id = ".$this->modalidadId."  and m.periodo_id = ".$this->periodoId."
        and p.estado = 'A'        
        ) as m"),function($join){
            $join->on("m.modalidad_id","=","h.grupo_id")
                ->on("m.periodo_id","=","h.periodo_id")
                ->on("m.curso_id","=","h.curso_id");
        })
        ->join("tm_personas as p","p.id","=","m.estudiante_id")
        ->select("p.*")
        ->where("tm_horarios_docentes.id",$actividad->paralelo)
        ->where("m.estado",'A')
        ->orderBy("p.apellidos")
        ->get();
        
        return view('livewire.vc-examen-view');
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

        $this->termino = $record['termino'];
        $this->bloque = $record['bloque'];
        $this->tipo = $record['actividad'];
        $this->nombre = $record['nombre'];
        $this->fecha = $record['fecha'];
        $this->puntaje = $record['puntaje'];
        $this->enlace = $record['enlace'];
        $this->descripcion = json_encode($record['descripcion']);
        $this->estado = $record['estado'];
        //$this->descripcion=".";
        $day = date('l', strtotime($this->fecha));

        $tblmateria = TmAsignaturas::find($record['asignatura_id']);
        $this->asignatura =  $tblmateria['descripcion'];

        $tblcurso = TmHorarios::query()
        ->join("tm_cursos as c","c.id","=","tm_horarios.curso_id")
        ->join("tm_servicios as s","s.id","=","c.servicio_id")
        ->selectRaw("concat(s.descripcion,' ',c.paralelo) as curso, tm_horarios.grupo_id")
        ->where("tm_horarios.id",$record['horario_id'])
        ->first();

        $this->curso =  $tblcurso['curso'];
        $this->modalidadId =  $tblcurso['grupo_id'];

        $this->add();
        $this->asignarNotas();

        $this->control = "enabled";
        $sistema = TdPeriodoSistemaEducativos::query()
        ->where("codigo",$this->termino)
        ->first();

        if ($sistema->cerrar==1){
            $this->control = "disabled";
        }
    }

     public function add(){

        $this->tblrecords=[];

        $actividad = TmActividades::find($this->examenId);

        $this->personas = TmHorariosDocentes::query()
        ->join("tm_horarios as h","h.id","=","tm_horarios_docentes.horario_id")
        ->join(DB::raw("(select estudiante_id, modalidad_id, periodo_id, curso_id, estado 
        from tm_matriculas m 
        where m.modalidad_id = ".$this->modalidadId."  and m.periodo_id = ".$this->periodoId."
        union all
        select m.estudiante_id, p.modalidad_id, m.periodo_id, p.curso_id, m.estado
        from tm_pase_cursos p
        inner join tm_matriculas m on m.id = p.matricula_id
        where p.modalidad_id = ".$this->modalidadId."  and m.periodo_id = ".$this->periodoId."
        and p.estado = 'A'        
        ) as m"),function($join){
            $join->on("m.modalidad_id","=","h.grupo_id")
                ->on("m.periodo_id","=","h.periodo_id")
                ->on("m.curso_id","=","h.curso_id");
        })
        ->join("tm_personas as p","p.id","=","m.estudiante_id")
        ->select("p.*")
        ->where("tm_horarios_docentes.id",$actividad->paralelo)
        ->where("m.estado",'A')
        ->orderBy("p.apellidos")
        ->get();

        // Actualiza Datos Estudiantes
        foreach ($this->personas as $key => $data)
        {   

            $this->tblrecords[$data->id]['personaId'] = $data->id;
            $this->tblrecords[$data->id]['nui'] = $data->identificacion;
            $this->tblrecords[$data->id]['nombres'] = $data->apellidos.' '.$data->nombres;
            $this->tblrecords[$data->id]['archivo'] = "";
            $this->tblrecords[$data->id]['fecha'] = "";
            $this->tblrecords[$data->id]['entregaId'] = 0;
            $this->tblrecords[$data->id]['nota'] = 0;

        }

        $this->array_entregas = TmFiles::query()
        ->where('actividad_id',$this->examenId)
        ->where('entrega',1)
        ->get();

        foreach ($this->array_entregas as $key =>$entrega)
        { 
            $personaId = $entrega->persona_id;
            $this->tblrecords[$personaId]['archivo'] =  $entrega->nombre;
            $this->tblrecords[$personaId]['fecha'] =  $entrega->create_at;
            $this->tblrecords[$personaId]['entregaId'] =  $entrega->id;

        }

    }

    public function asignarNotas(){

        $notas = TmActividades::query()
        ->join('td_calificacion_actividades as n','n.actividad_id','=','tm_actividades.id')
        ->where("tipo","ET")
        ->where("actividad_id",$this->examenId)
        ->where("docente_id",$this->docenteId)
        ->select("n.*")
        ->get();

        foreach ($notas as $recno){
            $personaId = $recno->persona_id;
            $this->tblrecords[$personaId]['nota'] =  $recno->nota;
        }


    }

    public function download_drive($id){

        $url = route('archivo.descargar', ['id' => $id]);
        $this->dispatchBrowserEvent('iniciar-descarga', ['url' => $url]);

    }

    public function grabarNota(){

        foreach ($this->tblrecords as $records){

                TdCalificacionActividades::query()
                ->where("actividad_id","=",$this->examenId)
                ->where("persona_id","=",$records['personaId'])
                ->delete();

                if ($records['nota']>0){
                    
                    TdCalificacionActividades::Create([
                        'actividad_id' => $this->examenId,
                        'persona_id' => $records['personaId'],
                        'nota' =>  $records['nota'],
                        'usuario' => auth()->user()->name,
                        'estado' => 'A',
                    ]);

                }
        }

        $message = "Calificaciones grabada con Éxito......";
        $this->dispatchBrowserEvent('msg-grabar', ['newName' => $message]);

    }

}
