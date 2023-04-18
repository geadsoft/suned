<?php

namespace App\Http\Livewire;
use App\Models\TmSedes;
use App\Models\TmPersonas;
use App\Models\TmPeriodosLectivos;
use App\Models\TmGeneralidades;
use App\Models\TmCursos;

use Livewire\Component;
use Livewire\WithPagination;
use PDF;

class VcPersons extends Component
{   
    use WithPagination;

    public $datos, $estudiante, $selectId, $estado=false;
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
  
    public function mount(){
        $periodo = TmPeriodosLectivos::orderBy("periodo","desc")->first();
        $this->filters['srv_periodo'] = $periodo['id'];    
    }

    public function render()
    {
        
        $tblperiodos = TmPeriodosLectivos::orderBy("periodo","desc")->get();
        $tblgenerals = TmGeneralidades::where('superior',1)->get();
        $tblcursos   = TmCursos::query()
        ->where('periodo_id',$this->filters['srv_periodo'])
        ->when($this->filters['srv_grupo'],function($query){
            return $query->where('grupo_id',"{$this->filters['srv_grupo']}");
        })
        ->get();

        $tblrecords = TmPersonas::query()
        ->join("tm_matriculas as m","m.estudiante_id","=","tm_personas.id")
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
        ->where('tm_personas.estado',$this->filters['srv_estado'])
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

    public function delete($IdEstudiante){
        
        $tbldata = TmPersonas::find($IdEstudiante);

        $this->estudiante = $tbldata['apellidos'].' '.$tbldata['nombres'];
        $this->selectId   = $tbldata['id'];

        $this->dispatchBrowserEvent('show-delete');
    }

    public function deleteData(){
        
        $record = TmPersonas::find($this->selectId);
        $record->update([
            'estado' => 'R',
        ]);

        $this->dispatchBrowserEvent('hide-delete');
    }


    public function estudiantes(){

        $tblrecords = TmPersonas::query()
        ->join("tm_matriculas as m","m.estudiante_id","=","tm_personas.id")
        ->join("tm_cursos as c","c.id","=","m.curso_id")
        ->join("tm_servicios as s","s.id","=","c.servicio_id")
        ->join("tm_generalidades as g","g.id","=","m.modalidad_id")
        ->join("tm_generalidades as g2","g2.id","=","tm_personas.nacionalidad_id")
        ->when($this->filters['srv_nombre'],function($query){
            return $query->whereRaw("concat(p.apellidos,' ',p.nombres) LIKE '%".$this->filters['srv_nombre']."%'");
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
        g2.descripcion as nacionalidad")
        ->where('tm_personas.tipopersona','=','E')
        ->where('tm_personas.estado',$this->filters['srv_estado'])
        ->orderByRaw('s.modalidad_id, s.nivel_id, s.grado_id, apellidos asc')
        ->get();

        return $tblrecords;
        
    }

    public function fimiliares(){

        $tblrecords = TmPersonas::query()
        ->join("tm_matriculas as m","m.estudiante_id","=","tm_personas.id")
        ->join("tm_cursos as c","c.id","=","m.curso_id")
        ->join("tm_servicios as s","s.id","=","c.servicio_id")
        ->join("tm_generalidades as g","g.id","=","m.modalidad_id")
        ->join("tm_familiar_estudiantes as f","f.estudiante_id","=","tm_personas.id")
        ->join("tm_personas as p","p.id","=","f.persona_id")
        ->when($this->filters['srv_nombre'],function($query){
            return $query->where('tm_personas.nombres','like','%'.$this->filters['srv_nombre'].'%')
                        ->orWhere('tm_personas.apellidos','like','%'.$this->filters['srv_nombre'].'%');
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
        p.apellidos as apefamilia, p.identificacion as nui, p.telefono, p.email")
        ->where('tm_personas.tipopersona','=','E')
        ->where('tm_personas.estado',$this->filters['srv_estado'])
        ->orderBy('apellidos','asc')
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
           
        $tblrecords = $this->estudiantes();
        $tblcia = TmSedes::all();

        $periodo = TmPeriodosLectivos::find($this->filters['srv_periodo'])->toArray();
        $this->consulta['periodo'] = $periodo['descripcion'];

        //Vista
        $pdf = PDF::loadView('reports/ficha_estudiante',[
            'tblrecords' => $tblrecords,
            'data' => $this->consulta,
            'tblcia' => $tblcia,
        ]);

        return $pdf->setPaper('a4')->stream('Ficha de Estudiantes.pdf');

    }

    public function listEstudiantesPDF($report,$objdata)
    { 
        $data = json_decode($objdata);

        $this->filters['srv_nombre']  = $data->srv_nombre;
        $this->filters['srv_periodo'] = $data->srv_periodo;
        $this->filters['srv_grupo']   = $data->srv_grupo;
        $this->filters['srv_curso']   = $data->srv_curso;
        $this->filters['srv_genero']  = $data->srv_genero;
        $this->filters['srv_estado']  = $data->srv_estado;
           
        $tblrecords  = $this->estudiantes();
        $totalalumno = $tblrecords->count(); 

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
           
        $tblrecords = $this->fimiliares();

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
            $this->consulta['curso'] = $objcurso->servicio['descripcion'] + $objcurso['paralelo'];
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
        $tblcia = TmSedes::all();

        $periodo = TmPeriodosLectivos::find($this->filters['srv_periodo'])->toArray();
        $this->consulta['periodo'] = $periodo['descripcion'];

        //Vista
        $pdf = PDF::loadView('reports/ficha_estudiante',[
            'tblrecords' => $tblrecords,
            'data' => $this->consulta,
            'tblcia' => $tblcia,
        ]);

        return $pdf->download('Ficha de Estudiantes.pdf');

    }

    public function downloadEstudiantesPDF($report,$objdata)
    { 
        $data = json_decode($objdata);

        $this->filters['srv_nombre']  = $data->srv_nombre;
        $this->filters['srv_periodo'] = $data->srv_periodo;
        $this->filters['srv_grupo']   = $data->srv_grupo;
        $this->filters['srv_curso']   = $data->srv_curso;
        $this->filters['srv_genero']  = $data->srv_genero;
        $this->filters['srv_estado']  = $data->srv_estado;
           
        $tblrecords = $this->estudiantes();
        $totalalumno = $tblrecords->count(); 

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
           
        $tblrecords = $this->fimiliares();

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
            $this->consulta['curso'] = $objcurso->servicio['descripcion'] + $objcurso['paralelo'];
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





    
}
