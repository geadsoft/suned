<?php

namespace App\Http\Livewire;
use App\Models\TmSedes;
use App\Models\TmPersonas;
use App\Models\TmPeriodosLectivos;
use App\Models\TmHorarios;
use App\Models\TmGeneralidades;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

use PDF;

class VcStudents extends Component
{
    use WithPagination;

    public $modalidadId='';
    public $tblmodalidad;
    public $tblcursos;
    
    public $filters = [
        'docenteId' => 0,
        'periodoId' => '',
        'cursoId' => '',
        'estudianteId' => 0,
    ];

    public function mount(){
        
        $año   = date('Y');
        $periodo = TmPeriodosLectivos::where("aperturado",1)->first();
        $this->filters['periodoId'] = $periodo['id']; 
        $this->filters['docenteId'] = auth()->user()->personaId;    

        $this->tblcursos = TmHorarios::query()
        ->join("tm_servicios as s","s.id","=","tm_horarios.servicio_id")
        ->join("tm_cursos as c","c.id","=","tm_horarios.curso_id")
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as m","m.id","=","d.asignatura_id")
        ->where("d.docente_id",$this->filters['docenteId'])
        ->selectRaw('c.id, concat(s.descripcion," ",c.paralelo) as descripcion')
        ->groupByRaw(' c.id, descripcion')
        ->get();

        //$this->filters['cursoId'] = $this->tblcursos[0]['id'];

    }

    
    public function render()
    {
        $this->tblmodalidad = TmGeneralidades::where('superior',1)->get();
        
        $this->tblcursos = TmHorarios::query()
        ->join("tm_servicios as s","s.id","=","tm_horarios.servicio_id")
        ->join("tm_cursos as c","c.id","=","tm_horarios.curso_id")
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as m","m.id","=","d.asignatura_id")
        ->where("d.docente_id",$this->filters['docenteId'])
        ->where("tm_horarios.periodo_id",$this->filters['periodoId'])
        ->selectRaw('c.id, concat(s.descripcion," ",c.paralelo) as descripcion')
        ->groupByRaw(' c.id, descripcion')
        ->get();

        $tblrecords = TmPersonas::query()
        ->join("tm_matriculas as m","m.estudiante_id","=","tm_personas.id")
        ->join("tm_generalidades as g","g.id","=","m.modalidad_id")
        ->join("tm_cursos as c","c.id","=","m.curso_id")
        ->join("tm_servicios as s","s.id","=","c.servicio_id")
        ->join(DB::raw('(select h.curso_id from tm_horarios h
                inner join tm_horarios_docentes d on d.horario_id = h.id
                where d.docente_id = '.$this->filters['docenteId'].' and 
                h.periodo_id = '.$this->filters['periodoId'].'
                group by h.curso_id)
               cursos'), 
        function($join)
        {
           $join->on('cursos.curso_id', '=', 'm.curso_id');
        })
        ->when($this->modalidadId,function($query){
            return $query->where('m.modalidad_id',"{$this->modalidadId}");
        })
        ->when($this->filters['periodoId'],function($query){
            return $query->where('m.periodo_id',"{$this->filters['periodoId']}");
        })
        ->when($this->filters['cursoId'],function($query){
            return $query->where('m.curso_id',"{$this->filters['cursoId']}");
        })
        ->where('tm_personas.tipopersona','=','E')
        ->select('tm_personas.*','m.id as matriculaId','m.estudiante_id','s.descripcion','c.paralelo','g.descripcion as modalidad')
        ->orderByRaw('g.descripcion,apellidos asc')
        ->paginate(12);

        
        return view('livewire.vc-students',[
            'tblrecords'  => $tblrecords,
            'tblcursos'   => $this->tblcursos,
        ]);
        
    }

    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }

    public function printData($id)
    {
        $this->filters['estudianteId'] = $id;
        $datos = json_encode($this->filters);


        $this->dispatchBrowserEvent('print-pdf', ['newName' => $datos]);
        //return redirect()->to('/preview-pdf/informacion-student/'.$datos);
        

    }


    public function printFichaPDF($objdata)
    { 

        $data = json_decode($objdata);
        $this->filters['estudianteId'] = $data->estudianteId;
        $this->filters['periodoId'] = $data->periodoId;

        $periodo = TmPeriodosLectivos::find($this->filters['periodoId'])->toArray();
           
        $tblrecords  = $this->estudiantes();
        $tblfamiliar = $this->familiares();
        $tblcia = TmSedes::all();

        $consulta['periodo'] = $periodo['descripcion'];

        //Vista
        $pdf = PDF::loadView('reports/ficha_estudiante',[
            'tblrecords'  => $tblrecords,
            'tblfamiliar' => $tblfamiliar,
            'data' => $consulta,
            'tblcia' => $tblcia,
        ]);

        return $pdf->setPaper('a4')->stream('Ficha de Estudiantes.pdf');

    }

    public function estudiantes(){

        $tblrecords = TmPersonas::query()
        ->join("tm_matriculas as m","m.estudiante_id","=","tm_personas.id")
        ->join("tm_personas as r","r.id","=","m.representante_id")
        ->join("tm_cursos as c","c.id","=","m.curso_id")
        ->join("tm_servicios as s","s.id","=","c.servicio_id")
        ->join("tm_generalidades as g","g.id","=","m.modalidad_id")
        ->join("tm_generalidades as g2","g2.id","=","tm_personas.nacionalidad_id")
        ->selectRaw("tm_personas.*, g.descripcion as grupo, s.descripcion as curso, c.paralelo, m.documento as nromatricula 
        ,m.created_at as creado, weekday(tm_personas.created_at) as diapersona, weekday(m.created_at) as diamatricula, 
        g2.descripcion as nacionalidad, m.fecha as fechamatricula, month(m.fecha) as mes, 
        r.nombres as nomrepre, r.apellidos as aperepre, r.identificacion as idenrepre, r.parentesco as parenrepre,
        m.registro as tipomatricula, s.nivel_id, m.estado as status")
        ->where('tm_personas.tipopersona','=','E')
        ->where("tm_personas.id",$this->filters['estudianteId'])
        ->where("m.periodo_id",$this->filters['periodoId'])
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
        ->selectRaw("tm_personas.nombres,tm_personas.apellidos,tm_personas.identificacion, g.descripcion as grupo, s.descripcion as curso, c.paralelo, p.nombres as nomfamilia, 
        p.apellidos as apefamilia, p.identificacion as nui, p.telefono, p.email, p.parentesco")
        ->where('tm_personas.tipopersona','E')
        ->where("tm_personas.id",$this->filters['estudianteId'])
        ->where("m.periodo_id",$this->filters['periodoId'])
        ->orderByRaw('s.modalidad_id, s.nivel_id, s.grado_id, apellidos asc')
        ->get();

        return  $tblrecords ;
        

    }



}
