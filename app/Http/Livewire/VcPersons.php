<?php

namespace App\Http\Livewire;
use App\Models\TmSedes;
use App\Models\TmPersonas;
use App\Models\TmPeriodosLectivos;
use App\Models\TmGeneralidades;
use App\Models\TmCursos;
use App\Models\TmMatricula;
use App\Models\User;
use App\Models\TdPeriodoSistemaEducativos;
use App\Models\TmActividades;
use App\Models\TmHorarios;
use App\Models\TdBoletinFinal;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use PDF;

use App\Exports\ListaMatriculasExport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Support\Facades\Hash;

class VcPersons extends Component
{   
    use WithPagination;
    use Exportable;

     protected $listeners = ['guardarNuevaPassword'];

    public $datos, $estudiante, $selectId, $estado=false, $periodoOld, $matriculaId, $registros;
    public $resumenMatricula = [], $resumenNivel = [], $nivelestudio=[], $personaId;
    public $termino, $tblboletin, $tblpersonas, $variables, $tblescala;

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
        $periodo = TmPeriodosLectivos::where("estado","A")->first();
        $this->filters['srv_periodo'] = $periodo['id'];    

        $anioant = TmPeriodosLectivos::where('periodo',$periodo['periodo']-1)->first();
        $this->periodoOld  = $anioant['id'];

        $this->tbltermino = TdPeriodoSistemaEducativos::query()
        ->where('periodo_id',$this->filters['srv_periodo'])
        ->where('tipo','EA')
        ->get();

        $this->tblescala = TdPeriodoSistemaEducativos::query()
        ->where("periodo_id",$this->filters['srv_periodo'])
        ->where("tipo","EC")
        ->selectRaw("*,nota + case when nota=10 then 0 else 0.99 end as nota2")
        ->get();
    }

    public function render()
    {
        if ($this->filters['srv_estado']==''){
            $this->filters['srv_estado'] = "A";
        }

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

        $users = User::all();

        $this->datos = json_encode($this->filters);

        $this->registros = $tblrecords->total();

        return view('livewire.vc-persons',[
            'tblrecords'  => $tblrecords,
            'tblperiodos' => $tblperiodos,
            'tblgenerals' => $tblgenerals,
            'tblcursos'   => $tblcursos,
            'users' => $users,
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


    public function resetPassword($estudianteId){

        $this->personaId = $estudianteId;
        $person = TmPersonas::find($estudianteId);
        $this->dispatchBrowserEvent('resetPasswordSwal', ['newName' => $person->identificacion]);

    }

    public function guardarNuevaPassword($password)
    {
        $password = str_replace(' ', '', $password);
        User::where('personaId',$this->personaId)->update(['password' => Hash::make($password)]);

        $this->dispatchBrowserEvent('msg-grabar', [
            'newName' => 'La contraseña ha sido actualizada correctamente.'
        ]);

    }

    public function reintegrarData(){
        
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
        m.registro as tipomatricula, s.nivel_id, m.estado as status")
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

        $this->filters['srv_estado'] = '';
        $data = json_encode($this->filters);
        return Excel::download(new ListaMatriculasExport($data), 'Reporte Matriculas.xlsx');
        
    }

    public function excelActivos(){

        $this->filters['srv_estado'] = 'A';
        $data = json_encode($this->filters);
        return Excel::download(new ListaMatriculasExport($data), 'Reporte Matriculas.xlsx');

    }

    public function generarBoletin($id){

        $matricula = TmMatricula::find($id);

        $this->variables['periodoId']   =  $this->filters['srv_periodo'];
        $this->variables['modalidadId']   = $matricula->modalidad_id;
        $this->variables['paralelo'] = $matricula->curso_id;
        $this->variables['bloque'] = "1P";
        $this->variables['estudianteId'] = $matricula->estudiante_id;
        
        foreach ($this->tbltermino as $termObj) {

            $this->termino = $termObj->codigo; // '1T','2T','3T'
            $this->variables['termino'] = $this->termino;
           
            $this->tblpersonas = TmPersonas::where('id',$matricula->estudiante_id)->get();

            $this->add();
            $this->asignarNotas();

            if (!in_array($this->termino, ['1T','2T','3T'])) {
                continue;
            }

            $periodo = $this->variables['periodoId'];
            $modalidad = $this->variables['modalidadId'];
            $curso = $this->variables['paralelo'];
            $term = $this->termino;


            // 1) Recolectar persona_ids y asignatura_ids que vamos a procesar
            $personaIds = [];
            $asignaturaIds = [];
            foreach ($this->tblboletin as $personaId => $record) {
                foreach ($record as $k2 => $data) {
                    if ($k2 === 'ZZ') continue;
                    if (empty($data['asignaturaId'])) continue;
                    $personaIds[] = $personaId;
                    $asignaturaIds[] = $data['asignaturaId'];
                }
            }
            $personaIds = array_values(array_unique($personaIds));
            $asignaturaIds = array_values(array_unique($asignaturaIds));

            // 2) Prefetch: traer todos los boletines existentes para esas personas/asignaturas
            $existing = TdBoletinFinal::query()
                ->where('periodo_id', $periodo)
                ->where('modalidad_id', $modalidad)
                ->where('curso_id', $curso)
                ->when(!empty($personaIds), fn($q)=> $q->whereIn('persona_id', $personaIds))
                ->when(!empty($asignaturaIds), fn($q)=> $q->whereIn('asignatura_id', $asignaturaIds))
                ->get();

            // 3) Mapear para acceso O(1)
            $map = [];
            foreach ($existing as $row) {
                $map[$row->persona_id . '|' . $row->asignatura_id] = $row;
            }

            // 4) Dentro de una transacción, crear o actualizar según exista en el mapa
            DB::transaction(function() use ($map, $periodo, $modalidad, $curso, $term) {
                foreach ($this->tblboletin as $personaId => $record) {
                    foreach ($record as $k2 => $data) {
                        if ($k2 === 'ZZ') continue;
                        $asigId = $data['asignaturaId'] ?? null;
                        if (is_null($asigId)) continue;

                        $key = $personaId . '|' . $asigId;

                        $payload = [
                            "{$term}_notaparcial"   => isset($data['promedio']) ? floatval($data['promedio']) : null,
                            "{$term}_nota70"        => isset($data['nota70']) ? floatval($data['nota70']) : null,
                            "{$term}_evaluacion"    => isset($data['examen']) ? floatval($data['examen']) : null,
                            "{$term}_nota30"        => isset($data['nota30']) ? floatval($data['nota30']) : null,
                            "{$term}_notatrimestre" => isset($data['cuantitativo']) ? floatval($data['cuantitativo']) : null,
                        ];

                        if (isset($map[$key])) {
                            // existe: actualizar solo las columnas del término
                            $map[$key]->update($payload);
                        } else {
                            // no existe: crear registro completo con claves foráneas + payload
                            TdBoletinFinal::create(array_merge([
                                'periodo_id'    => $periodo,
                                'modalidad_id'  => $modalidad,
                                'curso_id'      => $curso,
                                'persona_id'    => $personaId,
                                'asignatura_id' => $asigId,
                            ], $payload));
                            // si quieres evitar re-check en el mismo ciclo, agrega al mapa para próximas actualizaciones
                            $map[$key] = true; // marca simple; no es modelo, pero evita crear doble
                        }
                    }
                }
            });
        }

        $boletin = TdBoletinFinal::query()
        ->where('periodo_id',$this->variables['periodoId'])
        ->where('modalidad_id',$this->variables['modalidadId'])
        ->where('curso_id', $this->variables['paralelo'])
        ->when($this->variables['estudianteId'], function($query) {
            return $query->where('persona_id', $this->variables['estudianteId']);
        })
        ->get()->toArray();

         // Escala Cualitativa
        $rangos = TdPeriodoSistemaEducativos::query()
        ->where("periodo_id",$this->variables['periodoId'])
        ->where("tipo","EC")
        ->selectRaw("min(nota) as min, max(nota)+case when max(nota)=10 then 0 else 0.99 end as max, evaluacion as codigo, glosa as descr")
        ->groupBy("evaluacion","glosa")
        ->get()->toArray();


        foreach($boletin as $objnotas){

            $promedioanual = $objnotas['1T_notatrimestre']+$objnotas['2T_notatrimestre']+$objnotas['3T_notatrimestre'];
            $promediofinal = $promedioanual + $objnotas['supletorio'];
            $notacualitativo = '';

            foreach ($rangos as $escala) {
                
                $nota1 = $escala['min'];
                $nota2 = $escala['max'];                  
                $letra = $escala['codigo'];

                if ($promediofinal >= ($nota1) && $promediofinal <= $nota2) {
                    $notacualitativo = $letra;
                }
                
            }

            $updateNota = TdBoletinFinal::find($objnotas['id']);
            $updateNota->update([
                'promedio_anual' => round($promedioanual/3,2),
                'supletorio' => 0,
                'promedio_final' => round($promediofinal/2,2),
                'promedio_cualitativo' => $notacualitativo
            ]);

        }

        $datos = json_encode($this->variables);
        $this->dispatchBrowserEvent('abrir-pdf', ['url' => "/preview-pdf/final-bulletin/{$datos}"]); 

    }

    public function add(){

        $this->tblboletin=[];

        $asignaturas = TmHorarios::query()
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as a","a.id","=","d.asignatura_id")
        ->select("a.*")
        ->where("tm_horarios.curso_id",$this->variables['paralelo'])
        ->orderBy("a.descripcion")
        ->get();

        foreach ($this->tblpersonas as $key => $person)
        { 
            $idPerson = $person->id;

            // Actualiza Datos Asignaturas
            foreach ($asignaturas as $key => $data)
            {   
                $index = $data->id;
                $this->tblboletin[$idPerson][$index]['id'] = 0;
                $this->tblboletin[$idPerson][$index]['asignaturaId'] = $data->id;
                $this->tblboletin[$idPerson][$index]['nombres'] = strtoupper($data->descripcion);
                        
                $record = $this->actividad($data->id);
                $tblgrupo = $record->groupBy('actividad')->toBase();
                
                foreach ($tblgrupo as $key2 => $grupo){

                    foreach ($grupo as $key3 => $actividad){
                        $col = $key2.$actividad->id;
                        $this->tblboletin[$idPerson][$index][$col] = 0.00;                   
                    }
                    $col = $key2."-prom";
                    $this->tblboletin[$idPerson][$index][$col] = 0;
                }

                $this->tblboletin[$idPerson][$index]['promedio'] = 0.00;
                $this->tblboletin[$idPerson][$index]['nota70'] = 0.00;
                $this->tblboletin[$idPerson][$index]['examen'] = 0.00;
                $this->tblboletin[$idPerson][$index]['nota30'] = 0.00;
                $this->tblboletin[$idPerson][$index]['cuantitativo'] = 0.00;
                $this->tblboletin[$idPerson][$index]['cualitativo'] = "";
            }

        } 

        foreach ($this->tblpersonas as $key => $person)
        { 
            $idPerson = $person->id;
            $this->tblboletin[$idPerson]['ZZ']['id'] = 0;
            $this->tblboletin[$idPerson]['ZZ']['asignaturaId'] = 0;
            $this->tblboletin[$idPerson]['ZZ']['nombres'] = 'PROMEDIO FINAL';
            
            foreach ($tblgrupo as $key2 => $grupo){

                foreach ($grupo as $key3 => $actividad){
                    $col = $key2.$actividad->id;
                    $this->tblboletin[$idPerson]['ZZ'][$col] = 0.00;                   
                }
                $col = $key2."-prom";
                $this->tblboletin[$idPerson]['ZZ'][$col] = 0;

            }

            $this->tblboletin[$idPerson]['ZZ']['promedio'] = 0.00;
            $this->tblboletin[$idPerson]['ZZ']['nota70'] = 0.00;
            $this->tblboletin[$idPerson]['ZZ']['examen'] = 0.00;
            $this->tblboletin[$idPerson]['ZZ']['nota30'] = 0.00;
            $this->tblboletin[$idPerson]['ZZ']['cuantitativo'] = 0.00;
            $this->tblboletin[$idPerson]['ZZ']['cualitativo'] = "";
        
        }

        /*//Observaciones
        $observaciones = TdObservacionActa::query()
        ->where("termino",$this->filters['termino'])
        ->where("bloque",$this->filters['bloque'])
        ->where("curso_id",$this->filters['paralelo'])
        ->get();

        foreach ($observaciones as $obsr) {
            $this->arrComentario[$obsr->persona_id]['comentario'] = $obsr->comentario;
        }
        
        $this->datos = json_encode($this->filters);*/
    }

    public function asignarNotas(){

        $servicio = TmCursos::query()
        ->join("tm_servicios as s","s.id","=","tm_cursos.servicio_id")
        ->where("tm_cursos.id",$this->variables['paralelo'])
        ->first();

        $calificacion = $servicio->calificacion;

        $tblgrupo  = TmActividades::query()
        ->join("tm_horarios_docentes as d",function($join){
            $join->on("d.id","=","tm_actividades.paralelo")
                ->on("d.docente_id","=","tm_actividades.docente_id");
        })
        ->join("tm_horarios as h","h.id","=","d.horario_id")
        ->when($this->variables['paralelo'],function($query){
            return $query->where('h.curso_id',"{$this->variables['paralelo']}");
        })
        ->when($this->variables['termino'],function($query){
            return $query->where('termino',"{$this->variables['termino']}");
        })
        /*->when($this->filters['bloque'],function($query){
            return $query->where('bloque',"{$this->filters['bloque']}");
        })*/
        ->selectRaw("tm_actividades.actividad")
        ->where("tipo","AC")
        ->groupBy("tm_actividades.actividad")
        ->get();

        
        foreach ($this->tblpersonas as $key => $person){

            $idPerson = $person->id;
            /*$this->filters['estudianteId'] = $idPerson;*/

            $notas = TmActividades::query()
            ->join('td_calificacion_actividades as n', 'n.actividad_id', '=', 'tm_actividades.id')
            ->join('tm_horarios_docentes as d', function($join) {
                $join->on('d.id', '=', 'tm_actividades.paralelo')
                    ->on('d.docente_id', 'tm_actividades.docente_id');
            })
            ->when(!empty($this->variables['termino']), function($query) {
                return $query->where('tm_actividades.termino', $this->variables['termino']);
            })
            /*->when(!empty($this->filters['bloque']), function($query) {
                return $query->where('tm_actividades.bloque', $this->filters['bloque']);
            })*/
            ->where('tm_actividades.tipo', 'AC')
            ->where('n.persona_id', $idPerson)
            ->select([
                'tm_actividades.id as actividadId',
                'tm_actividades.actividad',
                'n.nota',
                'd.asignatura_id'
            ])
            ->get(); 

            foreach ($notas as $key => $objnota){

                $fil  = $objnota->asignatura_id;
                $tipo = $objnota->actividad;
                $actividadId = $objnota->actividadId;
                $col = $tipo.$actividadId;

                if (isset($this->tblboletin[$idPerson][$fil][$col])) {
                    $this->tblboletin[$idPerson][$fil][$col] = $objnota->nota;
                }
            }

            //Asginar Nota Examen
            /*$objtermino = TdPeriodoSistemaEducativos::query()
            ->where('periodo_id',$this->filters['periodoId'])
            ->where('tipo','EA')
            ->get();

            foreach($objtermino as $data){
                if ($this->filters['termino'] == $data['codigo']){
                    
                }
            }*/
            $termino = $this->variables['termino'] ?? null;
            $bloque = $this->variables['termino'] ?? null;
            $bloqueEx = $bloque ? str_replace('T', 'E', $bloque) : null;
            $estudianteId = $this->variables['estudianteId'] ?? null;

            $examen = TmActividades::query()
                ->join('td_calificacion_actividades as n', 'n.actividad_id', '=', 'tm_actividades.id')
                ->join('tm_horarios_docentes as d', function($join) {
                    $join->on('d.id', '=', 'tm_actividades.paralelo')
                        ->on('d.docente_id', '=', 'tm_actividades.docente_id');
                })
                ->when(!empty($termino), function($query) use ($termino) {
                    return $query->where('tm_actividades.termino', $termino);
                })
                ->when(!empty($bloque), function($query) use ($bloqueEx) {
                    return $query->where('tm_actividades.bloque', $bloqueEx);
                })
                ->where('tm_actividades.tipo', 'ET')
                ->where('n.persona_id', $estudianteId)
                ->groupBy('d.asignatura_id')
                ->selectRaw('d.asignatura_id, ROUND(AVG(n.nota), 2) as promedio')
                ->pluck('promedio', 'asignatura_id');

            foreach ($examen as $key => $objnota){
                
                $fil = $key;
                
                if (isset($this->tblboletin[$idPerson][$fil]['examen'])) {
                    $this->tblboletin[$idPerson][$fil]['examen'] = $objnota;
                }
            }
        
        }

        // Calcula Promedio
        foreach ($this->tblboletin as $key1 => $records){

            if ($key1!='ZZ'){
                
                foreach ($records as $key2 => $recno){

                    $promedio = 0;
                    $countprm = 0;
                    $nota30 = 0;
                    $nota70=0;

                    foreach ($tblgrupo as $grupo){

                        $tipo  = $grupo->actividad;
                        $suma  = 0;
                        $count = 0;

                        foreach ($recno as $campo => $valor){
                        
                            $ncampo = substr($campo, 0, 2); 
                            
                            if ($ncampo==$tipo){
                                $suma += $valor;
                                $count += 1;
                            }

                        }

                        $col = $tipo."-prom";
                        if ($count > 0){
                            $this->tblboletin[$key1][$key2][$col] = round($suma/($count-1), 2);
                            $promedio += $suma/($count-1);
                            $countprm += 1;
                        }

                    }
                    if ($countprm > 0){
                        $this->tblboletin[$key1][$key2]['promedio'] = round($promedio/($countprm), 2);  
                    }else{
                        $this->tblboletin[$key1][$key2]['promedio'] = 0.00;
                    }

                    if ($promedio > 0){
                        $nota70 = round($this->tblboletin[$key1][$key2]['promedio']*0.70,2);
                        $this->tblboletin[$key1][$key2]['nota70'] = round($nota70, 2);
                    }else{

                        $this->tblboletin[$key1][$key2]['nota70'] = 0.00;
                    }

                    if ($this->tblboletin[$key1][$key2]['examen'] > 0){
                        $nota30 = round($this->tblboletin[$key1][$key2]['examen']*0.30,2);
                        $this->tblboletin[$key1][$key2]['nota30'] = round($nota30, 2);
                    }else{
                        $this->tblboletin[$key1][$key2]['nota30'] = 0.00;
                    }

                    $this->tblboletin[$key1][$key2]['cuantitativo'] = $nota70+$nota30; 

                }
            }
        }

        // Promedio Final
        foreach ($this->tblboletin as $key => $records){
            $aiprom = 0;
            $agprom = 0;
            $promedio = 0;
            $nota70 = 0;
            $notaex = 0;
            $nota30 = 0;
            $promfinal = 0;
            $count = count($records)-1;

            foreach ($records as $key2 => $recno){
                
                $notaex += $recno['examen'];
                
                if (isset($recno['AI-prom'])){
                    $aiprom += $recno['AI-prom'];
                }

                if (isset($recno['AG-prom'])){
                    $agprom += $recno['AG-prom'];
                }                
                
                $promedio += $recno['promedio'];
                $nota70 += $recno['nota70'];
                $nota30 += $recno['nota30'];
                $promfinal += $recno['cuantitativo'];
            }

            $this->tblboletin[$key]['ZZ']['AI-prom']  = round($aiprom/$count,2);
            $this->tblboletin[$key]['ZZ']['AG-prom']  = round($agprom/$count,2);
            $this->tblboletin[$key]['ZZ']['promedio'] = round($promedio/$count,2);
            $this->tblboletin[$key]['ZZ']['nota70'] = round($nota70/$count,2);
            $this->tblboletin[$key]['ZZ']['examen'] = round($notaex/$count,2);
            $this->tblboletin[$key]['ZZ']['nota30'] = round($nota30/$count,2);
            $this->tblboletin[$key]['ZZ']['cuantitativo'] = round($promfinal/$count,2);

        }
                
        // Escala Cualitativa
        $rangos = TdPeriodoSistemaEducativos::query()
        ->where("periodo_id",$this->variables['periodoId'])
        ->where("tipo","EC")
        ->selectRaw("min(nota) as min, max(nota)+case when max(nota)=10 then 0 else 0.99 end as max, evaluacion as codigo, glosa as descr")
        ->groupBy("evaluacion","glosa")
        ->get()->toArray();

        foreach ($this->tblboletin as $key1 => $records){

            foreach ($records as $key2 => $recno){

                $promedio = $recno['cuantitativo']; 
                    
                foreach ($rangos as $escala) {
                    
                    $nota1 = $escala['min'];
                    $nota2 = $escala['max'];                  
                    $letra = $escala['codigo'];

                    if ($promedio >= ($nota1) && $promedio <= $nota2) {
                        $this->tblboletin[$key1][$key2]['cualitativo'] = $letra;
                    }
                    
                }
            
            }

        }

        $notas = $this->tblescala;        

        if($calificacion=="L"){

            foreach($this->tblboletin as $person => $record){

                foreach ($this->asignaturas as $key => $data)
                {   
                    $index = $data->id;
                    
                    if (isset($this->tblboletin[$person][$index]["AI-prom"])){

                        $aiprom = $this->tblboletin[$person][$index]["AI-prom"];
                        if ($aiprom>0){
                            $resultado = array_filter($notas, function($notas) use ($aiprom) {
                                return $aiprom >= $notas['nota'] && $aiprom <= $notas['nota2'];
                            });
                            $this->tblboletin[$person][$index]["AI-prom"] = reset($resultado)['codigo'] ?? 0;
                        }

                    };

                    if (isset($this->tblboletin[$person][$index]["AG-prom"])){

                        $agprom = $this->tblboletin[$person][$index]["AG-prom"];
                        if ($agprom>0){
                            $resultado = array_filter($notas, function($notas) use ($agprom) {
                                return $agprom >= $notas['nota'] && $agprom <= $notas['nota2'];
                            });
                            $this->tblboletin[$person][$index]["AG-prom"] = reset($resultado)['codigo'] ?? 0;
                        }

                    };

                    $promedio = $this->tblboletin[$person][$index]["promedio"];
                    $examen   = $this->tblboletin[$person][$index]["examen"];
                    $cuantitativo = $this->tblboletin[$person][$index]["cuantitativo"];
                   
                    if ($promedio>0){
                         $resultado = array_filter($notas, function($notas) use ($promedio) {
                            return $promedio >= $notas['nota'] && $promedio <= $notas['nota2'];
                        });
                        $this->tblboletin[$person][$index]["promedio"] = reset($resultado)['codigo'] ?? 0;
                    }

                    if ($examen>0){
                         $resultado = array_filter($notas, function($notas) use ($examen) {
                            return $examen >= $notas['nota'] && $examen <= $notas['nota2'];
                        });
                        $this->tblboletin[$person][$index]["examen"] = reset($resultado)['codigo'] ?? 0;
                    }

                    if ($cuantitativo>0){
                         $resultado = array_filter($notas, function($notas) use ($cuantitativo) {
                            return $cuantitativo >= $notas['nota'] && $cuantitativo <= $notas['nota2'];
                        });
                        $this->tblboletin[$person][$index]["cuantitativo"] = reset($resultado)['codigo'] ?? 0;
                    }

                }

                //Promedio Final
                if (isset($this->tblboletin[$person]['ZZ']["AI-prom"])){

                    $aiprom = $this->tblboletin[$person]['ZZ']["AI-prom"];
                    if ($aiprom>0){
                        $resultado = array_filter($notas, function($notas) use ($aiprom) {
                            return $aiprom >= $notas['nota'] && $aiprom <= $notas['nota2'];
                        });
                        $this->tblboletin[$person]['ZZ']["AI-prom"] = reset($resultado)['codigo'] ?? 0;
                    }

                };

                if (isset($this->tblboletin[$person]['ZZ']["AG-prom"])){

                    $agprom = $this->tblboletin[$person]['ZZ']["AG-prom"];
                    if ($agprom>0){
                        $resultado = array_filter($notas, function($notas) use ($agprom) {
                            return $agprom >= $notas['nota'] && $agprom <= $notas['nota2'];
                        });
                        $this->tblboletin[$person]['ZZ']["AG-prom"] = reset($resultado)['codigo'] ?? 0;
                    }

                };

                $promedio = $this->tblboletin[$person]['ZZ']["promedio"];
                $examen   = $this->tblboletin[$person]['ZZ']["examen"];
                $cuantitativo = $this->tblboletin[$person]['ZZ']["cuantitativo"];
                
                if ($promedio>0){
                        $resultado = array_filter($notas, function($notas) use ($promedio) {
                        return $promedio >= $notas['nota'] && $promedio <= $notas['nota2'];
                    });
                    $this->tblboletin[$person]['ZZ']["promedio"] = reset($resultado)['codigo'] ?? 0;
                }

                if ($examen>0){
                        $resultado = array_filter($notas, function($notas) use ($examen) {
                        return $examen >= $notas['nota'] && $examen <= $notas['nota2'];
                    });
                    $this->tblboletin[$person]['ZZ']["examen"] = reset($resultado)['codigo'] ?? 0;
                }

                if ($cuantitativo>0){
                        $resultado = array_filter($notas, function($notas) use ($cuantitativo) {
                        return $cuantitativo >= $notas['nota'] && $cuantitativo <= $notas['nota2'];
                    });
                    $this->tblboletin[$person]['ZZ']["cuantitativo"] = reset($resultado)['codigo'] ?? 0;
                }

            }

        }


    }

    public function actividad($id){

        $record = TmActividades::query()
        ->join("tm_horarios_docentes as d",function($join){
            $join->on("d.id","=","tm_actividades.paralelo")
                ->on("d.docente_id","=","tm_actividades.docente_id");
        })
        ->join("tm_horarios as h","h.id","=","d.horario_id")
        ->when($this->variables['paralelo'],function($query){
            return $query->where('h.curso_id',"{$this->variables['paralelo']}");
        })
        ->when($this->variables['termino'],function($query){
            return $query->where('termino',"{$this->variables['termino']}");
        })
        ->when($this->variables['bloque'],function($query){
            return $query->where('bloque',"{$this->variables['bloque']}");
        })
        ->selectRaw("tm_actividades.id,tm_actividades.nombre,tm_actividades.actividad,tm_actividades.puntaje")
        ->where("tipo","AC")
        ->where("d.asignatura_id",$id)
        ->orderByRaw("actividad desc")
        ->get();

        return  $record;

    }
    
}
