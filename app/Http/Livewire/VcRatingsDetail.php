<?php

namespace App\Http\Livewire;
use App\Models\TmSedes;
use App\Models\TrCalificacionesCabs;
use App\Models\TmPeriodosLectivos;
use App\Models\TmGeneralidades;
use App\Models\TmCursos;
use App\Models\TmServicios;
use App\Models\TmHorarios;
use App\Models\TmPersonas;

use Livewire\Component;
use Livewire\WithPagination;
use PDF;

class VcRatingsDetail extends Component
{
    public $tblservicios=[],$tblcursos=[],$detalles=[], $tblcomponentes, $datos, $consulta=[];
    public $materias;
    public $selectId,$grupoId,$servicioId,$periodoId,$cursoId,$mostrar=false;
    public $filters=[
        'periodoId'=> 0,
        'grupoId'  => 0,
        'gradoId'  => 0,
        'cursoId'  => 0,
    ];

    public function mount(){

        $this->tblgenerals  = TmGeneralidades::whereRaw('superior in (1,2,4)')->get();
        $this->tblperiodos  = TmPeriodosLectivos::orderBy("periodo","desc")->get();
    
        $this->periodoId    = $this->tblperiodos[0]['id'];
        $this->grupoId      = "";

    }
    
    public function render()
    { 
        return view('livewire.vc-ratings-detail',[
            'detalles'    => $this->detalles,
            'tblperiodos' => $this->tblperiodos,
            'tblgenerals' => $this->tblgenerals,
        ]);
    }

    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }

    public function updatedgrupoId($id){   
        
        $this->tblservicios = TmServicios::where('modalidad_id',$id)->get();
    }

    public function updatedservicioId($id){
        
        $this->cursoId = '';

        $this->tblcursos = TmCursos::where('periodo_id',$this->periodoId)
        ->where('servicio_id',$this->servicioId)
        ->where('grupo_id',$this->grupoId)
        ->get(); 
    }

    public function updatedcursoId(){
        $this->loadData();
    }

    public function loadData(){   

        $tblrecords = TrCalificacionesCabs::query()
        ->join("tr_calificaciones_dets as d","d.calificacioncab_id","=","tr_calificaciones_cabs.id")
        ->when($this->grupoId,function($query){
            return $query->where('grupo_id',"{$this->grupoId}");
        })
        ->when($this->servicioId,function($query){
            return $query->where('servicio_id',"{$this->servicioId}");
        })
        ->when($this->cursoId,function($query){
            return $query->where('curso_id',"{$this->cursoId}");
        }) 
        ->where('periodo_id',$this->periodoId)  
        ->select('d.estudiante_id','d.calificacion','d.escala_cualitativa','tr_calificaciones_cabs.*')     
        ->get(); 

        $this->tblcomponentes = TrCalificacionesCabs::query()
        ->join("tm_asignaturas as m","tr_calificaciones_cabs.asignatura_id","=","m.id")
        ->when($this->grupoId,function($query){
            return $query->where('grupo_id',"{$this->grupoId}");
        })
        ->when($this->servicioId,function($query){
            return $query->where('servicio_id',"{$this->servicioId}");
        })
        ->when($this->cursoId,function($query){
            return $query->where('curso_id',"{$this->cursoId}");
        }) 
        ->where('periodo_id',$this->periodoId)  
        ->select('tr_calificaciones_cabs.*','m.descripcion')     
        ->get(); 

        $alumnos = $tblrecords->groupBy('estudiante_id');
        
        foreach ($alumnos as $key => $pers)
        {
            $persona = TmPersonas::find($key)->toArray();
            
            $detalle['id']     = $key;
            $detalle['nombres'] = $persona['apellidos'].' '.$persona['nombres'] ;
            $detalle['comportamiento'] = '';

            foreach ($this->tblcomponentes as $data)
            {
                $detalle['P1_'.$data['asignatura_id']] ='';
                $detalle['P2_'.$data['asignatura_id']] ='';
                $detalle['P3_'.$data['asignatura_id']] ='';
                $detalle['PR_'.$data['asignatura_id']] ='';
                $detalle['PF_'.$data['asignatura_id']] ='';
            }
            array_push($this->detalles,$detalle);
        }
        

        /*Asigna Calificación*/
        foreach ($tblrecords as $data){
           
            foreach ($this->detalles as $fila => $detalle){
                if ($detalle['id'] == $data['estudiante_id']){

                    if ($data['evaluacion']=='N'){
                        $this->detalles[$fila][$data['parcial'].'_'.$data['asignatura_id']] = $data['calificacion']; 
                    }else{
                        $this->detalles[$fila][$data['parcial'].'_'.$data['asignatura_id']] = $data['escala_cualitativa']; 
                    }
                    
                }
            }

        }

        if (count($this->detalles)>0) {
            $this->mostrar = true;
        }

        $this->filters['periodoId'] = $this->periodoId;
        $this->filters['grupoId'] = $this->grupoId;
        $this->filters['gradoId'] = $this->servicioId;
        $this->filters['cursoId'] = $this->cursoId;
        $this->datos = json_encode($this->filters);

    }

    public function consulta()
    {
        $arrNotas = [];
        $tblrecords = TrCalificacionesCabs::query()
        ->join("tr_calificaciones_dets as d","d.calificacioncab_id","=","tr_calificaciones_cabs.id")        
        ->where('periodo_id',$this->periodoId)  
        ->where('grupo_id',$this->grupoId)
        ->where('servicio_id',$this->servicioId)
        ->where('curso_id',$this->cursoId)
        ->select('d.estudiante_id','d.calificacion','d.escala_cualitativa','tr_calificaciones_cabs.*')     
        ->get();

        $this->materias = TrCalificacionesCabs::query()
        ->join("tm_asignaturas as m","tr_calificaciones_cabs.asignatura_id","=","m.id")
        ->where('periodo_id',$this->periodoId)  
        ->where('grupo_id',$this->grupoId)
        ->where('servicio_id',$this->servicioId)
        ->where('curso_id',$this->cursoId)
        ->where('periodo_id',$this->periodoId)  
        ->select('tr_calificaciones_cabs.*','m.descripcion')     
        ->get(); 

        $alumnos = $tblrecords->groupBy('estudiante_id');

        foreach ($alumnos as $key => $pers)
        {
            $persona = TmPersonas::find($key)->toArray();
            
            $detalle['id']     = $key;
            $detalle['nombres'] = $persona['apellidos'].' '.$persona['nombres'] ;
            $detalle['comportamiento'] = '';

            foreach ($this->materias as $data)
            {
                $detalle['P1_'.$data['asignatura_id']] ='';
                $detalle['P2_'.$data['asignatura_id']] ='';
                $detalle['P3_'.$data['asignatura_id']] ='';
                $detalle['PR_'.$data['asignatura_id']] ='';
                $detalle['PF_'.$data['asignatura_id']] ='';
            }
            array_push($arrNotas,$detalle);
        }

        /*Asigna Calificación*/
        foreach ($tblrecords as $data){

            foreach ($this->detalles as $fila => $detalle){
                if ($detalle['id'] == $data['estudiante_id']){

                    $arrNotas[$fila][$data['parcial'].'_'.$data['asignatura_id']] = $data['calificacion']; 
                }
            }

        }
        
        return $arrNotas;

    }

    public function printPDF($objdata)
    {
        $data = json_decode($objdata);
        $this->periodoId = $data->periodoId;
        $this->grupoId   = $data->grupoId;
        $this->servicioId = $data->gradoId;
        $this->cursoId    = $data->cursoId;

        $tblperiodo = TmPeriodosLectivos::find($this->periodoId);
        $tblrecords = $this->consulta();
        $tblcia = TmSedes::all()->first();

        $this->consulta['referencia'] = $tblperiodo['descripcion'];
        $this->consulta['nombre'] = $tblcia['nombre'];
        $this->consulta['direccion'] = $tblcia['direccion'];
        $this->consulta['telefono'] = $tblcia['telefono_sede'];
        $this->consulta['email'] = $tblcia['email'];
        $this->consulta['periodo'] = 'PERIODO LECTIVO '.$tblperiodo['descripcion'];
        $this->consulta['codigo'] = $tblcia['codigo'];
        $this->consulta['rector'] = '';
        $this->consulta['secretaria'] = '';

        $pdf = PDF::loadView('reports/calificaciones',[
            'tblrecords'  => $tblrecords,
            'data' => $this->consulta,
            'materias' => $this->materias
        ]);

        return $pdf->setPaper('a4','landscape')->stream('Cuadro de Calificaciones.pdf');

    }

    public function downloadPDF($objdata)
    {

    }



}
