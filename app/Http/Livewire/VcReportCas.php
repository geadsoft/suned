<?php

namespace App\Http\Livewire;
use App\Models\TmPersonas;
use App\Models\TmGeneralidades;
use App\Models\TmPeriodosLectivos;
use App\Models\TmServicios;
use App\Models\TmCursos;
use App\Models\TrRegistrocasCab;
use App\Models\TrRegistrocasDet;

use Livewire\Component;
use Livewire\WithPagination;

class VcReportCas extends Component
{
    use WithPagination;

    public $grupoId, $gradoId, $cursoId, $observacion;
    public $tblgrupos, $tblgrados=[], $tblcursos=[], $ingCas=[];

    public $filters = [
        'srv_periodo' => '',
        'srv_nombre' => '',
    ];

    public $pariente = [
        'PA' => 'Padre',
        'MA' => 'Madre',
        'AP' => 'Apoderado',
        'NN' => '',
    ];

    public  function mount()
    {
        $año   = date('Y');
        $this->tblperiodos = TmPeriodosLectivos::where("estado",'A')->first();
        $this->filters['srv_periodo'] = $this->tblperiodos['id'];
        $this->filters['srv_nombre'] = '';

        $this->tblperiodos = TmPeriodosLectivos::orderBy("periodo",'desc')->get();
        $this->tblgrupos = Tmgeneralidades::where('superior',1)->get();
        $this->grupoId = 2;
        $this->updatedgrupoId();

    }

    public function render()
    {
        $tblrecords = TmPersonas::query()
        ->join("tm_matriculas as m","m.estudiante_id","=","tm_personas.id")
        ->join("tm_generalidades as g1","g1.id","=","tm_personas.nacionalidad_id")
        ->join("tm_personas as p","p.id","=","m.representante_id")
        ->join("tm_generalidades as g2","g2.id","=","p.nacionalidad_id")
        ->when($this->filters['srv_nombre'],function($query){
            return $query->whereRaw("concat(tm_personas.apellidos,' ',tm_personas.nombres) LIKE '%".$this->filters['srv_nombre']."%'");
        })
        ->when($this->filters['srv_periodo'],function($query){
            return $query->where('m.periodo_id',"{$this->filters['srv_periodo']}");
        })
        ->where('tm_personas.tipopersona','=','E')
        ->where('tm_personas.estado','A')
        ->select('tm_personas.*','g1.descripcion as nacest','p.tipoidentificacion as tiponui','p.identificacion as nui',
        'p.nombres as nomrepresentante','p.apellidos as aperepresentante','g2.descripcion as nacrepresentante',
        'p.direccion as dirrepresentante','p.telefono as telfrepresentante','p.parentesco as pariente')
        ->orderBy('apellidos','asc')
        ->paginate(10);

        return view('livewire.vc-report-cas',[
            'tblrecords'  => $tblrecords,
        ]);

    }

    public function addCAS($data){
        
        if (count($this->ingCas)==0){
            array_push($this->ingCas,$data);
        }else{

            foreach ($this->ingCas as $cas){
                if ($cas['id']!=$data['id']){
                    array_push($this->ingCas,$data);
                }
            }

        }
       
    }

    
    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }

    public function updatedgrupoId(){
        
        $this->tblgrados = TmServicios::where('modalidad_id',$this->grupoId)->get();

    }

    public function updatedgradoId(){
        
        $this->tblcursos = TmCursos::where('periodo_id',$this->filters['srv_periodo'])
        ->where('servicio_id',$this->gradoId)
        ->get();
        
    }

    public function createData(){
        
        $this ->validate([
            'grupoId'    => 'required',
            'gradoId'    => 'required',
            'periodoId'  => 'required',
            'cursoId'    => 'required',
        ]);

        $tblcasCab = TrRegistrocasCab::Create([
            'periodo_id' => $this -> periodoId,
            'grupo_id' => $this -> grupoId,
            'servicio_id' => $this -> gradoId,
            'curso_id' => $this -> cursoId,
            'observacion' => $this->observacion,
            'usuario' => auth()->user()->name,
        ]);
        
        $this->selectId = $tblcasCab['id'];



    }




}
