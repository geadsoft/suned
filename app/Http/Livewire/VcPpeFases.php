<?php

namespace App\Http\Livewire;
use App\Models\TmPeriodosLectivos;
use App\Models\TmCalendarioEventos;
use App\Models\TmCalendarioGrados;
use App\Models\TmPpeFases;
use App\Models\TmPpeEstudiantes;
use App\Models\TdPeriodoSistemaEducativos;
use App\Models\TmPpeActividades;
use Livewire\WithPagination;
use App\Models\TmGeneralidades;
use App\Models\TmServicios;
use App\Models\TdPpeAsistencias;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class VcPpeFases extends Component
{   
    use WithPagination;
    
    public $fecha, $hora, $fase, $periodoId, $docenteId, $filas=0, $enlace, $showEditModal=false;
    public $tipo="AI", $descripcion="", $fechaentrega, $horaentrega, $archivo="NO", $puntaje, $comentario, $enlace2="";
    public $selectId, $nombreActividad, $modalidadId, $gradoId;

    public $tblactividad=[];
    public $tblasistencia=[];
    public $tblrecords=[];
    public $objdetalle=[];
    public $personas=[];
    public $tblmodalidad;
    public $detallelink=[];

    public $filters=[
        'modalidadId' => '',
        'gradoId' => ''
    ];

    public $selTab=[
        1 => 'active',
        2 => '',
        3 => ''
    ];

    public function mount($fase)
    {
        $ldate = date('Y-m-d H:i:s');
        $this->fecha = date('Y-m-d',strtotime($ldate));
        $this->hora = date('H:i');

        $this->fase = $fase;
        $this->docenteId = auth()->user()->personaId;

        $tblperiodos = TmPeriodosLectivos::where("aperturado",1)->first();
        $this->periodoId = $tblperiodos['id'];

        $this->tblactividad = TdPeriodoSistemaEducativos::query()
        ->where('periodo_id',$this->periodoId)
        ->where('tipo','AC')
        ->where('codigo','<>','EX')
        ->get();

        $this->tblmodalidad = TmGeneralidades::where('superior',1)->get();
        $this->modalidadId = $this->tblmodalidad->first()->id;
        $this->filters['modalidadId'] = $this->modalidadId;

        $this->loadPersonas();
        $this->loadData();

    }
    
    public function render()
    {
        $this->loadPersonas();

        $fase = 'F'.$this->fase;

        $actividades = TmPpeActividades::query()
        ->when($this->filters['modalidadId'],function($query){
            return $query->where('modalidad_id',"{$this->filters['modalidadId']}");
        })
        ->when($this->filters['gradoId'],function($query){
            return $query->where('grado_id',"{$this->filters['gradoId']}");
        })
        ->where('periodo_id',$this->periodoId)
        ->where('tipo',$fase)
        ->where('actividad','<>','CV')
        ->paginate(12);

        $tblgrados = TmServicios::query()
        ->where('modalidad_id',$this->modalidadId)
        ->where('nivel_id',11)
        ->get(); 
        
        $filtrargrados = TmServicios::query()
        ->where('modalidad_id',$this->filters['modalidadId'])
        ->where('nivel_id',11)
        ->get(); 
        
        return view('livewire.vc-ppe-fases',[
            'actividades' => $actividades,
            'tblgrados' => $tblgrados,
            'filtrargrados' => $filtrargrados,
        ]);
    }

    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }

    public function newdetalle(){

        $this->objdetalle = [];
        $this->filas = (int) $this->filas;

        for ($i = 1; $i <= $this->filas; $i++) {
            
            $this->objdetalle[$i]['linea'] = $i ;
            $this->objdetalle[$i]['id'] = 0;
            $this->objdetalle[$i]['fecha'] = "";
           
        } 

    }

    public function edit($id){
        
        $this->showEditModal = true;
        $activity  = TmPpeActividades::find($id);
       
        $this->selectId = $activity->id;
        $this->tipo = $activity->actividad;
        $this->descripcion = $activity->nombre;
        $this->fechaentrega = date('Y-m-d',strtotime($activity->fecha_entrega));
        $this->horaentrega = date('H:i',strtotime($activity->fecha_entrega));
        $this->archivo = $activity->subir_archivo;
        $this->puntaje = $activity->puntaje;
        $this->comentario = $activity->descripcion;
        $this->enlace2 = $activity->enlace;

        $this->dispatchBrowserEvent('show-form');

    }


    public function loadData(){

        $tblfases = TmPpeFases::query()
        ->where('periodo_id',$this->periodoId)
        ->where('fase',$this->fase)
        ->where('persona_id',$this->docenteId)
        ->where('enlace',"")
        ->orderby('fecha')
        ->get();

        foreach($tblfases as $key => $fase){
            $this->objdetalle[$key]['linea'] = $key+1 ;
            $this->objdetalle[$key]['id'] = $fase->id;
            $this->objdetalle[$key]['fecha'] = date('Y-m-d',strtotime($fase->fecha));
        }

        $this->filas = count($tblfases);

        //Clase Virtual
        $this->detallelink=[];

        $clases = TmPpeActividades::query()
        ->where('periodo_id',$this->periodoId)
        ->where('tipo','F'.$this->fase)
        ->where('docente_id',$this->docenteId)
        ->where('actividad','CV')
        ->get();

        foreach ($clases as $key => $value) {
            $arrlink = [
                'id' => $value->id,
                'modalidadId' => $value->modalidad_id,
                'modalidad' => $value->modalidad->descripcion,
                'gradoId' => $value->grado_id,
                'grado' => $value->grado->descripcion,
                'enlace' => $value->enlace
            ];

            array_push($this->detallelink,$arrlink);
        }

        
        /*foreach($this->personas as $index => $persona){

            $personaId = $persona->id;

            foreach($this->objdetalle as $key => $fecha){

                $col = 'dia'.$key;
                
                $this->tblrecords[$personaId]['personaid'] = $persona->id;
                $this->tblrecords[$personaId]['nombres'] = $persona->apellidos.' '.$persona->nombres;
                $this->tblrecords[$personaId]['nui'] = $persona->identificacion;
                $this->tblrecords[$personaId][$col] = 0;
            
            }

        }*/

        $fase = 'F'.$this->fase;
        
    }

    public function consultar(){

        $this->loadPersonas();

        //Asistencia
        foreach($this->personas as $index => $persona){

            $personaId = $persona->id;
            $this->tblasistencia[$personaId]['personaid'] = $persona->id;
            $this->tblasistencia[$personaId]['nombres'] = $persona->apellidos.' '.$persona->nombres;
            $this->tblasistencia[$personaId]['nui'] = $persona->identificacion;

            foreach($this->objdetalle as $key => $detalle){

                $mes = date('m', strtotime($detalle['fecha'])); 
                $dia = date('d', strtotime($detalle['fecha']));
                $col = $mes.$dia;
                $this->tblasistencia[$personaId][$col] = '';
            
            }
        }

        //Asigna Asistencia
        $asistencia = TdPpeAsistencias::query()
        ->where('periodo_id',$this->periodoId)
        ->where('docente_id',$this->docenteId)
        ->where('curso_id',$this->filters['gradoId'])
        ->where('fase','F'.$this->fase)
        ->get();

        foreach ($asistencia as $asistencia){
            
            $personaId = $asistencia->persona_id;
            $col = date('md', strtotime($asistencia->fecha));
            $this->tblasistencia[$personaId][$col] = $asistencia->valor;
        }


    }

    public function loadPersonas(){

        $this->personas =  TmPpeEstudiantes::query()
        ->join('tm_personas as p','p.id','=','tm_ppe_estudiantes.persona_id')
        ->where('periodo_id',$this->periodoId)
        ->where('modalidad_id',$this->filters['modalidadId'])
        ->where('grado_id',$this->filters['gradoId'])
        ->select('p.*')
        ->get(); 

    }

    public function createData(){

        $fechasVacias = array_filter($this->objdetalle, fn($fase) => empty($fase['fecha']));

        if (!empty($fechasVacias)) {
            $this->dispatchBrowserEvent('msg-vacio');
            return;
        }

        //Clases
        foreach ($this->objdetalle as $detalle) {
            $data = [
                'fecha' => $detalle['fecha'],
            ];

            if (empty($detalle['id']) || $detalle['id'] == 0) {
                // Inserta nuevo registro
                TmPpeFases::create([
                    'periodo_id' => $this->periodoId,
                    'persona_id' => $this->docenteId,
                    'fase' => $this->fase,
                    'enlace' => '',
                    'usuario' => auth()->user()->name,
                ] + $data);
            } else {
                // Actualiza registro existente
                TmPpeFases::where('id', $detalle['id'])->update($data);
            }
        }
    
        // Link Clases
        foreach($this->detallelink as $detalle){

            if ($detalle['id']==0){

                $tblData = TmPpeActividades::Create([
                    'periodo_id' => $this->periodoId,
                    'modalidad_id' => $detalle['modalidadId'],
                    'grado_id' => $detalle['gradoId'],
                    'docente_id' => $this->docenteId,
                    'tipo' => 'F'.$this->fase,
                    'actividad' => 'CV',
                    'nombre' => 'Clase Virtual',
                    'descripcion' => '',
                    'fecha_entrega' => '1900-01-01',
                    'subir_archivo' => 'NO',
                    'puntaje' => 0,
                    'enlace' => $detalle['enlace'],
                    'estado' => "A",
                    'usuario' => auth()->user()->name,
                ]);

            } 

        }

        //Eventos
        $linkEvent = collect($this->detallelink)->contains(fn($item) => $item['id'] == 0);
        if ($linkEvent){  
            
            foreach ($this->detallelink as $link){

                if ($link['id']==0){

                    foreach ($this->objdetalle as $detalle) {

                        $mes = date('m', strtotime($detalle['fecha']));
                        $periodo = date('Y', strtotime($detalle['fecha']));

                        $eventos = TmCalendarioEventos::query()
                        ->where('actividad','PP')
                        ->where('start_date',$detalle['fecha'])
                        ->first();
                        
                        if ($eventos){

                            TmCalendarioGrados::Create([
                                'calendario_id' => $eventos->id,
                                'modalidad_id' => $link['modalidadId'],
                                'grado_id' => $link['gradoId'],
                                'usuario' => auth()->user()->name,
                            ]);

                        }else{

                            $eventos = TmCalendarioEventos::Create([
                                'periodo' => $periodo,
                                'mes' => $mes,
                                'actividad' => 'PP',
                                'nombre' => 'Recepción de clase PPE',
                                'start_date' => $detalle['fecha'],
                                'end_date' => $detalle['fecha'],
                                'descripcion' => 'Fecha programada para la recepción y revisión de la clase correspondiente al Programa de Participación Estudiantil.',
                                'todos' => 0,
                                'usuario' => auth()->user()->name,
                            ]);
                            
                            TmCalendarioGrados::Create([
                                'calendario_id' => $eventos->id,
                                'modalidad_id' => $link['modalidadId'],
                                'grado_id' => $link['gradoId'],
                                'usuario' => auth()->user()->name,
                            ]);

                        }
                    }
                }
            }
        }

        if(count($this->tblasistencia)>0){
            $this->grabaAsistencia();
        }
        
        $this->loadData();
        $this->render();

    }

    public function grabaAsistencia(){

        $this->loadPersonas();

        $personaIds = collect($this->personas)->pluck('id')->unique()->values()->all();
        $fechas = collect($this->objdetalle)->pluck('fecha')->unique()->values()->all();
        
        $periodoId = $this->periodoId;
        $docenteId = $this->docenteId;
        $faseStr = 'F' . $this->fase;
        $cursoId = $this->filters['gradoId'];
        $userName = auth()->user()->name;
        $now = now();

        // Mapear fecha -> col (mes + dia) para reutilizar
        $fechaToCol = [];
        foreach ($fechas as $fecha) {
            $mes = date('m', strtotime($fecha));
            $dia = date('d', strtotime($fecha));
            $fechaToCol[$fecha] = $mes . $dia;
        }

        // Traer asistencias existentes en una sola consulta
        $existing = TdPpeAsistencias::query()
        ->where('periodo_id', $periodoId)
        ->where('docente_id', $docenteId)
        ->where('fase', $faseStr)
        ->where('curso_id', $cursoId)
        ->whereIn('persona_id', $personaIds)
        ->whereIn('fecha', $fechas)
        ->get()
        ->keyBy(function($item) {
            $fecha = date('Y-m-d', strtotime($item->fecha));
            return "{$item->persona_id}|{$fecha}";
        });

        // Arrays para operaciones
        $toInsert = [];
        $toUpdate = []; // pairs [id => valor] o full row si prefieres

        foreach ($this->personas as $persona) {
            $personaId = $persona->id;

            foreach ($this->objdetalle as $detalle) {
                $fecha = $detalle['fecha'];
                $mes = date('m', strtotime($fecha));
                $dia = date('d', strtotime($fecha));
                $col = $mes . $dia;

                // ajusta a la fuente correcta (tblrecords o tblasistencia)
                $valor = $this->tblasistencia[$personaId][$col] ?? null;
                
                $key = "{$personaId}|{$fecha}";

                if (isset($existing[$key])) {
                    // actualizar por id (evita duplicados)
                    $existingRow = $existing[$key];
                    $toUpdate[] = [
                        'id' => $existingRow->id,
                        'valor' => $valor,
                        'usuario' => $userName,
                        'updated_at' => $now,
                    ];
                } else {

                    if ($valor == null || $valor =='') {
                        continue;
                    }

                    // preparar inserción
                    $toInsert[] = [
                        'periodo_id' => $periodoId,
                        'docente_id' => $docenteId,
                        'fase'       => $faseStr,
                        'curso_id'   => $cursoId,
                        'persona_id' => $personaId,
                        'fecha'      => $fecha,
                        'valor'      => $valor,
                        'usuario'    => $userName,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
            }
        }

        // Ejecutar en transacción
        DB::transaction(function() use ($toInsert, $toUpdate) {
            if (!empty($toInsert)) {
                // Insert masivo
                TdPpeAsistencias::insert($toInsert);
            }

            if (!empty($toUpdate)) {
                // Actualizaciones masivas: no hay updatemany nativo, iteramos por lotes.
                // Para evitar N queries enormes, agrupa en chunks (por ejemplo 100).
                foreach (array_chunk($toUpdate, 100) as $chunk) {
                    foreach ($chunk as $row) {
                        TdPpeAsistencias::where('id', $row['id'])
                            ->update([
                                'valor' => $row['valor'],
                                'usuario'=> $row['usuario'],
                                'updated_at' => $row['updated_at'],
                            ]);
                    }
                }
            }
        });

    }


    public function addActivity(){
        
        $ldate = date('Y-m-d H:i:s');
        $this->fechaentrega = date('Y-m-d',strtotime($ldate));
        $this->horaentrega = date('H:i');
        $this->puntaje = 10;
        
        $this->dispatchBrowserEvent('show-form');

    }

    public function createActivity(){

        $this ->validate([
            'tipo' => 'required',
            'descripcion' => 'required',
            'fechaentrega' => 'required',
            'horaentrega' => 'required',
            'puntaje' => 'required'
        ]);

        /*$grados = TmPpeEstudiantes::query()
        ->where('periodo_id', $this->periodoId)
        ->select('modalidad_id', 'grado_id')
        ->groupBy('modalidad_id', 'grado_id')
        ->get();
        
        foreach ($grados as $key => $grado){*/

            $tblData = TmPpeActividades::Create([
                'periodo_id' => $this->periodoId,
                'modalidad_id' => $this->modalidadId,
                'grado_id' => $this->gradoId,
                'docente_id' => $this->docenteId,
                'tipo' => 'F'.$this->fase,
                'actividad' => $this->tipo,
                'nombre' => $this->descripcion,
                'descripcion' => $this->comentario,
                'fecha_entrega' => $this->fechaentrega.' '.$this->horaentrega,
                'subir_archivo' => $this->archivo,
                'puntaje' => $this->puntaje,
                'enlace' => $this->enlace2,
                'estado' => "A",
                'usuario' => auth()->user()->name,
            ]);
        /*}*/

        $this->dispatchBrowserEvent('hide-form');

    }

    public function updateActivity(){

        $this ->validate([
            'tipo' => 'required',
            'descripcion' => 'required',
            'fechaentrega' => 'required',
            'horaentrega' => 'required',
            'puntaje' => 'required'
        ]);        
        
        if ($this->selectId){
            $record = TmPpeActividades::find($this->selectId);
            $record->update([
                'actividad' => $this->tipo,
                'nombre' => $this->descripcion,
                'descripcion' => $this->comentario,
                'fecha_entrega' => $this->fechaentrega.' '.$this->horaentrega,
                'subir_archivo' => $this->archivo,
                'puntaje' => $this->puntaje,
                'enlace' => $this->enlace2,
            ]);
            
        }
      
        $this->dispatchBrowserEvent('hide-form');
        
    }
    
    public function delete( $id ){

        $this->selectId = $id;
        $activity  = TmPpeActividades::find($id);
        $this->nombreActividad = $activity->nombre;

        $this->dispatchBrowserEvent('show-delete');

    }

    public function deleteActivity(){

        TmPpeActividades::find($this->selectId)->delete();
        $this->dispatchBrowserEvent('hide-delete');

    }

    public function updatedModalidadId($value)
    {
        // cargar grados filtrados por modalidad
        $this->tblgrados = TmServicios::query()
        ->where('modalidad_id',$value)
        ->where('nivel_id',11)
        ->get();    

        $this->gradoId = null; // limpiar selección anterior, opcional
    }

    public function newlink(){

        $this->gradoId='';
         $this->enlace='';
        
        $this->dispatchBrowserEvent('show-class');

    }

    public function addlink(){

        $modalidad = TmGeneralidades::find($this->modalidadId);
        $grado = TmServicios::find($this->gradoId);

        $arrlink = [
            'id' => 0,
            'modalidadId' => $this->modalidadId,
            'modalidad' => $modalidad->descripcion,
            'gradoId' => $this->gradoId,
            'grado' => $grado->descripcion,
            'enlace' => $this->enlace
        ];

        array_push($this->detallelink,$arrlink);
        
        $this->dispatchBrowserEvent('hide-class');

    }

    public function viewlink(){

    }

    public function dellink($linea){

        $id = $this->detallelink[$linea]['id'];
        
        if ($id==0){
            unset($this->detallelink[$linea]);
        }else{
            TmPpeActividades::where('id', $id)->delete();
            $this->loadData();
        }

    }

    public function filterTab($tab){
        $this->selTab[1] = '';
        $this->selTab[2] = '';
        $this->selTab[3] = '';
        $this->selTab[$tab] = 'active';
    }

}
