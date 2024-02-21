<?php

namespace App\Http\Livewire;
use App\Models\TmSedes;
use App\Models\TmPersonas;
use App\Models\TmPeriodosLectivos;
use App\Models\TmGeneralidades;
use App\Models\TmCursos;
use App\Models\TmMatricula;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use PDF;

use App\Exports\ListaMatriculasExport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\Exportable;

class VcPersons extends Component
{   
    use WithPagination;
    use Exportable;

    public $datos, $estudiante, $selectId, $estado=false, $periodoOld, $matriculaId;
    public $resumenMatricula = [], $resumenNivel = [], $nivelestudio=[];
    public $filters = [
        'srv_nombre' => '',
        'srv_periodo' => '',
        'srv_grupo' => '',
        'srv_curso' => '',
        'srv_genero' => '',
        'srv_reporte' => '',
        'srv_estado' => 'A',
    ];

    public $consulta = [
        'curso'   => '',
        'grupo'   => '',
        'periodo' => '',
    ];

    public $meses = [
        1 => 'Enero',
        2 => 'Febrero',
        3 => 'Marzo',
        4 => 'Abril',
        5 => 'Mayo',
        6 => 'Junio',
        7 => 'Julio',
        8 => 'Agosto',
        9 => 'Septiembre',
        10=> 'Octubre',
        11=> 'Noviembre',
        12=> 'Diciembre',
    ];
  
    public function mount(){
        
        $año   = date('Y');
        $periodo = TmPeriodosLectivos::where("periodo",$año)->first();
        $this->filters['srv_periodo'] = $periodo['id'];    

        $anioant = TmPeriodosLectivos::where('periodo',$periodo['periodo']-1)->first();
        $this->periodoOld  = $anioant['id'];
    }

    public function render()
    {
        
        $tblperiodos = TmPeriodosLectivos::orderBy("periodo","desc")->get();
        $tblgenerals = TmGeneralidades::where('superior',1)->get();
        $tblcursos   = TmCursos::query()
        ->when($this->filters['srv_periodo'],function($query){
            return $query->where('periodo_id',"{$this->filters['srv_periodo']}");
        })
        ->when($this->filters['srv_grupo'],function($query){
            return $query->where('grupo_id',"{$this->filters['srv_grupo']}");
        })
        ->orderByRaw('nivel_id,grado_id,paralelo')
        ->get();

        $tblrecords = TmPersonas::query()
        ->join("tm_matriculas as m","m.estudiante_id","=","tm_personas.id")
        ->join("tm_cursos as c","c.id","=","m.curso_id")
        ->join("tm_servicios as s","s.id","=","c.servicio_id")
        ->when($this->filters['srv_nombre'],function($query){
            return $query->whereRaw("concat(tm_personas.apellidos,' ',tm_personas.nombres) LIKE '%".$this->filters['srv_nombre']."%'");
        })
        ->when($this->filters['srv_periodo'],function($query){
            return $query->where('m.periodo_id',"{$this->filters['srv_periodo']}");
        })
        ->when($this->filters['srv_grupo'],function($query){
            return $query->where('m.modalidad_id',"{$this->filters['srv_grupo']}");
        })
        ->when($this->filters['srv_curso'],function($query){
            return $query->where('m.curso_id',"{$this->filters['srv_curso']}");
        })
        ->where('tm_personas.tipopersona','=','E')
        ->where('m.estado',$this->filters['srv_estado'])
        ->select('tm_personas.*','m.id as matriculaId','m.estudiante_id','s.descripcion','c.paralelo')
        ->orderBy('apellidos','asc')
        ->paginate(12);

        $this->datos = json_encode($this->filters);

        return view('livewire.vc-persons',[
            'tblrecords' => $tblrecords,
            'tblperiodos' => $tblperiodos,
            'tblgenerals' => $tblgenerals,
            'tblcursos' => $tblcursos,
        ]);

    }

    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }

    public function updatedEstado(){

        $this->filters['srv_estado']  = 'A';

        if ($this->estado){
            $this->filters['srv_estado']  = 'R';
        }
    }

    public function view( $id ){
        
        $this->view = TmPersonas::find($id)->toArray();

    }

    public function edit(TmPersonas $tblrecords ){
        
        $this->record  = $tblrecords->toArray();
        $this->selectId = $this -> record['id'];

        return redirect()->to('/academic/person-add');

    }

    public function delete($IdEstudiante, $IdMatricula){
        
        $tbldata = TmPersonas::find($IdEstudiante);

        $this->estudiante = $tbldata['apellidos'].' '.$tbldata['nombres'];
        $this->selectId   = $tbldata['id'];
        $this->matriculaId = $IdMatricula;

        $this->dispatchBrowserEvent('show-delete');
    }

    public function deleteData(){
        
        /*$record = TmPersonas::find($this->selectId);
        $record->update([
            'estado' => 'R',
        ]);*/
        $matricula = TmMatricula::find($this->matriculaId);

        $matricula->update([
            'estado' => 'R',
        ]);

        $this->dispatchBrowserEvent('hide-delete');
    }

    public function reintegrar($IdEstudiante, $IdMatricula){
        
        $tbldata = TmPersonas::find($IdEstudiante);

        $this->estudiante = $tbldata['apellidos'].' '.$tbldata['nombres'];
        $this->selectId   = $tbldata['id'];
        $this->matriculaId = $IdMatricula;

        $this->dispatchBrowserEvent('show-reintegrar');
    }

    public function reintegrarData(){
        
        /*$record = TmPersonas::find($this->selectId);
        $record->update([
            'estado' => 'A',
        ]);*/

        $matricula = TmMatricula::find($this->matriculaId);
        $matricula->update([
            'estado' => 'A',
        ]);

        $this->dispatchBrowserEvent('hide-reintegrar');
    }

    public function estudiantes(){

        $tblrecords = TmPersonas::query()
        ->join("tm_matriculas as m","m.estudiante_id","=","tm_personas.id")
        ->join("tm_personas as r","r.id","=","m.representante_id")
        ->join("tm_cursos as c","c.id","=","m.curso_id")
        ->join("tm_servicios as s","s.id","=","c.servicio_id")
        ->join("tm_generalidades as g","g.id","=","m.modalidad_id")
        ->join("tm_generalidades as g2","g2.id","=","tm_personas.nacionalidad_id")
        ->when($this->filters['srv_nombre'],function($query){
            return $query->whereRaw("concat(tm_personas.apellidos,' ',tm_personas.nombres) LIKE '%".$this->filters['srv_nombre']."%'");
        })
        ->when($this->filters['srv_periodo'],function($query){
            return $query->where('m.periodo_id',"{$this->filters['srv_periodo']}");
        })
        ->when($this->filters['srv_grupo'],function($query){
            return $query->where('m.modalidad_id',"{$this->filters['srv_grupo']}");
        })
        ->when($this->filters['srv_curso'],function($query){
            return $query->where('m.curso_id',"{$this->filters['srv_curso']}");
        })
        ->selectRaw("tm_personas.*, g.descripcion as grupo, s.descripcion as curso, c.paralelo, m.documento as nromatricula 
        ,m.created_at as creado, weekday(tm_personas.created_at) as diapersona, weekday(m.created_at) as diamatricula, 
        g2.descripcion as nacionalidad, m.fecha as fechamatricula, month(m.fecha) as mes, 
        r.nombres as nomrepre, r.apellidos as aperepre, r.identificacion as idenrepre, r.parentesco as parenrepre,
        m.registro as tipomatricula, s.nivel_id")
        ->where('tm_personas.tipopersona','=','E')
        ->where('m.estado',$this->filters['srv_estado'])
        ->orderByRaw('s.modalidad_id, s.nivel_id, s.grado_id,c.paralelo,apellidos asc')
        ->get();

        return $tblrecords;
        
    }

    public function familiares(){

        $tblrecords = TmPersonas::query()
        ->join("tm_matriculas as m","m.estudiante_id","=","tm_personas.id")
        ->join("tm_cursos as c","c.id","=","m.curso_id")
        ->join("tm_servicios as s","s.id","=","c.servicio_id")
        ->join("tm_generalidades as g","g.id","=","m.modalidad_id")
        ->join("tm_familiar_estudiantes as f","f.estudiante_id","=","tm_personas.id")
        ->join("tm_personas as p","p.id","=","f.persona_id")
        ->when($this->filters['srv_nombre'],function($query){
            return $query->whereRaw("concat(tm_personas.apellidos,' ',tm_personas.nombres) LIKE '%".$this->filters['srv_nombre']."%'");
        })
        ->when($this->filters['srv_periodo'],function($query){
            return $query->where('m.periodo_id',"{$this->filters['srv_periodo']}");
        })
        ->when($this->filters['srv_grupo'],function($query){
            return $query->where('m.modalidad_id',"{$this->filters['srv_grupo']}");
        })
        ->when($this->filters['srv_curso'],function($query){
            return $query->where('m.curso_id',"{$this->filters['srv_curso']}");
        })
        ->selectRaw("tm_personas.nombres,tm_personas.apellidos,tm_personas.identificacion, g.descripcion as grupo, s.descripcion as curso, c.paralelo, p.nombres as nomfamilia, 
        p.apellidos as apefamilia, p.identificacion as nui, p.telefono, p.email, p.parentesco")
        ->where('tm_personas.tipopersona','E')
        ->where('tm_personas.estado',$this->filters['srv_estado'])
        ->orderByRaw('s.modalidad_id, s.nivel_id, s.grado_id, apellidos asc')
        ->get();

        return  $tblrecords ;
        

    }


    public function printFichaPDF($objdata)
    { 
        $data = json_decode($objdata);

        $this->filters['srv_nombre'] = $data->srv_nombre;
        $this->filters['srv_periodo'] = $data->srv_periodo;
        $this->filters['srv_grupo'] = $data->srv_grupo;
        $this->filters['srv_curso'] = $data->srv_curso;
        $this->filters['srv_genero'] = $data->srv_genero;
        $this->filters['srv_estado']  = $data->srv_estado;

        $periodo = TmPeriodosLectivos::find($this->filters['srv_periodo'])->toArray();
           
        $tblrecords  = $this->estudiantes();
        $tblfamiliar = $this->familiares();
        $tblcia = TmSedes::all();

        
        $this->consulta['periodo'] = $periodo['descripcion'];

        //Vista
        $pdf = PDF::loadView('reports/ficha_estudiante',[
            'tblrecords'  => $tblrecords,
            'tblfamiliar' => $tblfamiliar,
            'data' => $this->consulta,
            'tblcia' => $tblcia,
        ]);

        return $pdf->setPaper('a4')->stream('Ficha de Estudiantes.pdf');

    }

    public function listEstudiantesPDF($report,$objdata)
    { 
        ini_set('max_execution_time', 60);

        $data = json_decode($objdata);

        $this->filters['srv_nombre']  = $data->srv_nombre;
        $this->filters['srv_periodo'] = $data->srv_periodo;
        $this->filters['srv_grupo']   = $data->srv_grupo;
        $this->filters['srv_curso']   = $data->srv_curso;
        $this->filters['srv_genero']  = $data->srv_genero;
        $this->filters['srv_estado']  = $data->srv_estado;

        $periodo = TmPeriodosLectivos::find($this->filters['srv_periodo'])->toArray();       
        $anioant = TmPeriodosLectivos::where('periodo',$periodo['periodo']-1)->first();
        if ($anioant != ''){
            $this->periodoOld  = $anioant['id'];
        }
                   
        $tblrecords  = $this->estudiantes();
        $totalalumno = $tblrecords->count(); 

        if(empty($tblrecords)){
            return;
        }

        $tblcia = TmSedes::all();

        $grupo    = $tblrecords->groupBy(['grupo','curso','paralelo'])->toArray();
        $resumenM = $tblrecords->groupBy(['mes','tipomatricula','genero'])->toArray();
        $resumenN = $tblrecords->groupBy(['mes','nivel_id'])->toArray();

        ksort($resumenM);
        ksort($resumenN);

        /*Resumen Estudiante por Genero*/        
        foreach($resumenM as $mes => $recno){
            $resumen['mes'] = $mes;
            $resumen['estudiantes'] = 0;
            $totM = 0;
            $totF = 0;
            $totN = 0;
            $totA = 0;

            foreach($recno as $tipo => $data){

                if ($tipo=='N'){
                    
                    if (isset($data['M'])){
                        $totM = $totM + count($data['M']);
                        $totN = $totN + count($data['M']);
                    }

                    if (isset($data['F'])){
                        $totF = $totF + count($data['F']);
                        $totN = $totN+count($data['F']);
                    }
                    
                }else{
                    
                    if (isset($data['M'])){
                        $totM = $totM + count($data['M']);
                        $totA = $totA + count($data['M']);
                    }

                    if (isset($data['F'])){
                        $totF = $totF + count($data['F']);
                        $totA = $totA + count($data['F']);
                    }

                }

            }
            $resumen['mujeres'] = $totF;
            $resumen['hombres'] = $totM;
            $resumen['nuevos']  = $totN;
            $resumen['propios'] = $totA;
            $resumen['estudiantes'] = $totN+$totA;
            array_push($this->resumenMatricula,$resumen);
        }

         /*Resumen Estudiante por Nivel de Estudio*/
         $resumen = [];
         $totalMatricula = 0;
         foreach($resumenN as $mes => $recno){
            $resumen['mes'] = $mes;
            $resumen['estudiantes'] = 0;
            $total = 0;
            foreach($recno as $nivel => $data){
                $resumen[$nivel] = count($data);
                $total = $total + count($data);
            }
            $resumen['estudiantes'] = $total;
            $totalMatricula = $totalMatricula + $total;
            array_push($this->resumenNivel,$resumen);
         }

        $nivelestudio = TmGeneralidades::where("superior",2)->get()->toArray();

        $this->consulta['periodo'] = $periodo['descripcion'];
        $this->consulta['curso'] = 'Todos';
        $this->consulta['grupo'] = 'Todos';

        if(!empty($this->filters['srv_grupo'])){
            $objgrupo = TmGeneralidades::find($this->filters['srv_grupo']);
            $this->consulta['grupo'] = $objgrupo['descripcion'];
        }

        if(!empty($this->filters['srv_curso'])){
            $objcurso = TmCursos::find($this->filters['srv_curso']);
            $this->consulta['curso'] = $objcurso->servicio['descripcion']." ".$objcurso['paralelo'];
        }
        
        $dias = [0=>'Domingo',1=>'Lunes',2=>'Martes',3=>'Miercoles',4=>'Jueves',5=>'Viernes',6=>'Sabado'];

        //Vista
        if ($report=="LE"){
            
           
            $pdf = PDF::loadView('reports/lista_estudiantes',[
                'tblrecords' => $grupo,
                'data' => $this->consulta,
                'tblcia' => $tblcia,
                'dias' => $dias,
                'totalalumno' => $totalalumno,
            ]);
            
            return $pdf->setPaper('a4')->stream('Ficha Estudiantes.pdf');
        }

        if ($report=="RM"){

            $pdf = PDF::loadView('reports/lista_matriculas',[
                'tblrecords' => $grupo,
                'data' => $this->consulta,
                'tblcia' => $tblcia,
                'dias' => $dias,
                'meses' => $this->meses,
                'resmatricula'=>$this->resumenMatricula,
                'resnivel'=>$this->resumenNivel,
                'nivelestudio' => $nivelestudio,
                'totalmatricula' => $totalMatricula
            ]);
            
            return $pdf->setPaper('a4')->stream('Reporte Matriculas.pdf');
        }            

    }


    public function listFamiliarPDF($objdata)
    { 
        $data = json_decode($objdata);

        $this->filters['srv_nombre']  = $data->srv_nombre;
        $this->filters['srv_periodo'] = $data->srv_periodo;
        $this->filters['srv_grupo']   = $data->srv_grupo;
        $this->filters['srv_curso']   = $data->srv_curso;
        $this->filters['srv_genero']  = $data->srv_genero;
        $this->filters['srv_estado']  = $data->srv_estado;
           
        $tblrecords = $this->familiares();

        if(empty($tblrecords)){
            return;
        }

        $tblcia = TmSedes::all();

        $grupo = $tblrecords->groupBy(['grupo','curso','paralelo'])->toArray();
        
        $periodo = TmPeriodosLectivos::find($this->filters['srv_periodo'])->toArray();
        $this->consulta['periodo'] = $periodo['descripcion'];
        $this->consulta['curso'] = 'Todos';
        $this->consulta['grupo'] = 'Todos';

        if(!empty($this->filters['srv_grupo'])){
            $objgrupo = TmGeneralidades::find($this->filters['srv_grupo']);
            $this->consulta['grupo'] = $objgrupo['descripcion'];
        }

        if(!empty($this->filters['srv_curso'])){
            $objcurso = TmCursos::find($this->filters['srv_curso']);
            $this->consulta['curso'] = $objcurso->servicio['descripcion']." ".$objcurso['paralelo'];
        }
        
        $dias = [0=>'Domingo',1=>'Lunes',2=>'Martes',3=>'Miercoles',4=>'Jueves',5=>'Viernes',6=>'Sabado'];

        //Vista
        $pdf = PDF::loadView('reports/lista_familiares',[
            'tblrecords' => $grupo,
            'data' => $this->consulta,
            'tblcia' => $tblcia,
            'dias' => $dias,
        ]);
        
        return $pdf->setPaper('a4','landscape')->stream('Listado Representante.pdf');
                   

    }

    //Download
    public function downloadFichaPDF($objdata)
    { 
        $data = json_decode($objdata);

        $this->filters['srv_nombre'] = $data->srv_nombre;
        $this->filters['srv_periodo'] = $data->srv_periodo;
        $this->filters['srv_grupo'] = $data->srv_grupo;
        $this->filters['srv_curso'] = $data->srv_curso;
        $this->filters['srv_genero'] = $data->srv_genero;
        $this->filters['srv_estado']  = $data->srv_estado;
           
        $tblrecords = $this->estudiantes();
        $tblfamiliar = $this->familiares();

        $tblcia = TmSedes::all();

        $periodo = TmPeriodosLectivos::find($this->filters['srv_periodo'])->toArray();
        $this->consulta['periodo'] = $periodo['descripcion'];

        //Vista
        $pdf = PDF::loadView('reports/ficha_estudiante',[
            'tblrecords'  => $tblrecords,
            'tblfamiliar' => $tblfamiliar,
            'data' => $this->consulta,
            'tblcia' => $tblcia,
        ]);

        return $pdf->download('Ficha de Estudiantes.pdf');

    }

    public function downloadEstudiantesPDF($report,$objdata)
    { 
        ini_set('max_execution_time', 60);
        $data = json_decode($objdata);

        $this->filters['srv_nombre']  = $data->srv_nombre;
        $this->filters['srv_periodo'] = $data->srv_periodo;
        $this->filters['srv_grupo']   = $data->srv_grupo;
        $this->filters['srv_curso']   = $data->srv_curso;
        $this->filters['srv_genero']  = $data->srv_genero;
        $this->filters['srv_estado']  = $data->srv_estado;

        $periodo = TmPeriodosLectivos::find($this->filters['srv_periodo'])->toArray();       
        $anioant = TmPeriodosLectivos::where('periodo',$periodo['periodo']-1)->first();
        if ($anioant != ''){
            $this->periodoOld  = $anioant['id'];
        }
           
        $tblrecords = $this->estudiantes();
        $totalalumno = $tblrecords->count(); 

        $tblcia = TmSedes::all();

        $grupo    = $tblrecords->groupBy(['grupo','curso','paralelo'])->toArray();
        $resumenM = $tblrecords->groupBy(['mes','tipomatricula','genero'])->toArray();
        $resumenN = $tblrecords->groupBy(['mes','nivel_id'])->toArray();

        /*Resumen Estudiante por Genero*/        
        foreach($resumenM as $mes => $recno){
            $resumen['mes'] = $mes;
            $resumen['estudiantes'] = 0;
            $totM = 0;
            $totF = 0;
            $totN = 0;
            $totA = 0;

            foreach($recno as $tipo => $data){

                if ($tipo=='N'){
                    
                    if (isset($data['M'])){
                        $totM = $totM + count($data['M']);
                        $totN = $totN + count($data['M']);
                    }

                    if (isset($data['F'])){
                        $totF = $totF + count($data['F']);
                        $totN = $totN+count($data['F']);
                    }
                    
                }else{
                    
                    if (isset($data['M'])){
                        $totM = $totM + count($data['M']);
                        $totA = $totA + count($data['M']);
                    }

                    if (isset($data['F'])){
                        $totF = $totF + count($data['F']);
                        $totA = $totA + count($data['F']);
                    }

                }

            }
            $resumen['mujeres'] = $totF;
            $resumen['hombres'] = $totM;
            $resumen['nuevos']  = $totN;
            $resumen['propios'] = $totA;
            $resumen['estudiantes'] = $totN+$totA;
            array_push($this->resumenMatricula,$resumen);
        }

         /*Resumen Estudiante por Nivel de Estudio*/
         $resumen = [];
         $totalMatricula = 0;
         foreach($resumenN as $mes => $recno){
            $resumen['mes'] = $mes;
            $resumen['estudiantes'] = 0;
            $total = 0;
            foreach($recno as $nivel => $data){
                $resumen[$nivel] = count($data);
                $total = $total + count($data);
            }
            $resumen['estudiantes'] = $total;
            $totalMatricula = $totalMatricula + $total;
            array_push($this->resumenNivel,$resumen);
         }

        $nivelestudio = TmGeneralidades::where("superior",2)->get()->toArray();

        $this->consulta['periodo'] = $periodo['descripcion'];
        $this->consulta['curso'] = 'Todos';
        $this->consulta['grupo'] = 'Todos';

        if(!empty($this->filters['srv_grupo'])){
            $objgrupo = TmGeneralidades::find($this->filters['srv_grupo']);
            $this->consulta['grupo'] = $objgrupo['descripcion'];
        }

        if(!empty($this->filters['srv_curso'])){
            $objcurso = TmCursos::find($this->filters['srv_curso']);
            $this->consulta['curso'] = $objcurso->servicio['descripcion']." ".$objcurso['paralelo'];
        }
        
        $dias = [0=>'Domingo',1=>'Lunes',2=>'Martes',3=>'Miercoles',4=>'Jueves',5=>'Viernes',6=>'Sabado'];

        //Vista
        if ($report=="LE"){

            $pdf = PDF::loadView('reports/lista_estudiantes',[
                'tblrecords' => $grupo,
                'data' => $this->consulta,
                'tblcia' => $tblcia,
                'dias' => $dias,
                'totalalumno' => $totalalumno,
            ]);

            return $pdf->download('Lista Estudiantes.pdf');
        }

        if ($report=="RM"){

            $pdf = PDF::loadView('reports/lista_matriculas',[
                'tblrecords' => $grupo,
                'data' => $this->consulta,
                'tblcia' => $tblcia,
                'dias' => $dias,
                'meses' => $this->meses,
                'resmatricula'=>$this->resumenMatricula,
                'resnivel'=>$this->resumenNivel,
                'nivelestudio' => $nivelestudio,
                'totalmatricula' => $totalMatricula
            ]);
            
            return $pdf->download('Reporte Matrículas.pdf');
        }            

    }

    public function downloadFamiliarPDF($objdata)
    { 
        $data = json_decode($objdata);

        $this->filters['srv_nombre']  = $data->srv_nombre;
        $this->filters['srv_periodo'] = $data->srv_periodo;
        $this->filters['srv_grupo']   = $data->srv_grupo;
        $this->filters['srv_curso']   = $data->srv_curso;
        $this->filters['srv_genero']  = $data->srv_genero;
        $this->filters['srv_estado']  = $data->srv_estado;
           
        $tblrecords = $this->familiares();

        if(empty($tblrecords)){
            return;
        }

        $tblcia = TmSedes::all();

        $grupo = $tblrecords->groupBy(['grupo','curso','paralelo'])->toArray();
        
        $periodo = TmPeriodosLectivos::find($this->filters['srv_periodo'])->toArray();
        $this->consulta['periodo'] = $periodo['descripcion'];
        $this->consulta['curso'] = 'Todos';
        $this->consulta['grupo'] = 'Todos';

        if(!empty($this->filters['srv_grupo'])){
            $objgrupo = TmGeneralidades::find($this->filters['srv_grupo']);
            $this->consulta['grupo'] = $objgrupo['descripcion'];
        }

        if(!empty($this->filters['srv_curso'])){
            $objcurso = TmCursos::find($this->filters['srv_curso']);
            $this->consulta['curso'] = $objcurso->servicio['descripcion'].' '.$objcurso['paralelo'];
        }
        
        $dias = [0=>'Domingo',1=>'Lunes',2=>'Martes',3=>'Miercoles',4=>'Jueves',5=>'Viernes',6=>'Sabado'];

        //Vista
        $pdf = PDF::loadView('reports/lista_familiares',[
            'tblrecords' => $grupo,
            'data' => $this->consulta,
            'tblcia' => $tblcia,
            'dias' => $dias,
        ]);
             
        return $pdf->setPaper('a4','landscape')->download('Listado Representante.pdf');      

    }

    public function exportExcel(){

        $data = json_encode($this->filters);
        return Excel::download(new ListaMatriculasExport($data), 'Reporte Matriculas.xlsx');

    }
    
}
