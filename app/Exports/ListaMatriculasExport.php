<?php

namespace App\Exports;
use App\Models\TmPersonas;
use App\Models\TmPeriodosLectivos;
use App\Models\TmGeneralidades;
use App\Models\TmCursos;

use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;

class ListaMatriculasExport implements FromView, ShouldAutoSize
{
    use Exportable;
    /*
    * @return \Illuminate\Support\Collection
    */
    public $filters, $resumenMatricula=[], $resumenNivel=[];
    public $dias = [
        0=>'Domingo',
        1=>'Lunes',
        2=>'Martes',
        3=>'Miercoles',
        4=>'Jueves',
        5=>'Viernes',
        6=>'Sabado'
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

    public function __construct($filters)
    {
        $this->filters = json_decode($filters, true);
        
    }


    public function view(): View 
    {   
        $periodo = TmPeriodosLectivos::find($this->filters['srv_periodo'])->toArray(); 
        
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
        ->when($this->filters['srv_estado'],function($query){
            return $query->where('m.estado',"{$this->filters['srv_estado']}");
        })
        ->selectRaw("tm_personas.*, g.descripcion as grupo, s.descripcion as curso, c.paralelo, m.documento as nromatricula 
        ,m.created_at as creado, weekday(m.fecha) as diapersona, weekday(m.fecha) as diamatricula, 
        g2.descripcion as nacionalidad, m.fecha as fechamatricula, month(m.fecha) as mes, 
        r.nombres as nomrepre, r.apellidos as aperepre, r.identificacion as idenrepre, r.parentesco as parenrepre,
        m.registro as tipomatricula, s.nivel_id")
        ->where('tm_personas.tipopersona','=','E')
        /*->where('tm_personas.estado',$this->filters['srv_estado'])*/
        ->orderByRaw('s.modalidad_id, s.nivel_id, s.grado_id, apellidos asc')
        ->get();

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
         
         foreach($resumenN as $mes => $recno){
            $resumen = [];
            $resumen['mes'] = $mes;
            $resumen['estudiantes'] = 0;
            $totalMatricula = 0;
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

        $consulta['periodo'] = $periodo['descripcion'];
        $consulta['curso'] = 'Todos';
        $consulta['grupo'] = 'Todos';

        if(!empty($this->filters['srv_grupo'])){
            $objgrupo = TmGeneralidades::find($this->filters['srv_grupo']);
            $consulta['grupo'] = $objgrupo['descripcion'];
        }

        if(!empty($this->filters['srv_curso'])){
            $objcurso = TmCursos::find($this->filters['srv_curso']);
            $consulta['curso'] = $objcurso->servicio['descripcion']." ".$objcurso['paralelo'];
        }

        return view('export.matriculas',[
            'tblrecords'   => $grupo,
            'data'         => $consulta,
            'dias'         => $this->dias,
            'meses'        => $this->meses,
            'resmatricula' => $this->resumenMatricula,
            'resnivel'     => $this->resumenNivel,
            'nivelestudio' => $nivelestudio,
        ]);

    }
}
