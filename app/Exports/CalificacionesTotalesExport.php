<?php

namespace App\Exports;


use App\Models\TmPersonas; 
use App\Models\TmPeriodosLectivos;
use App\Models\TmHorarios;
use App\Models\TmHorariosDocentes;
use App\Models\TmActividades;
use App\Models\TdPeriodoSistemaEducativos;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CalificacionesTotalesExport implements FromView, WithColumnWidths, WithStyles
{
    use Exportable;

    public $filters, $colspan, $col="", $colprom="";

    public function __construct($filters)
    {
        $this->filters = json_decode($filters, true);
    }

    public function view(): View 
    { 

        $docente = TmPersonas::find($this->filters['docenteId']);
        $fechaActual = date("d/m/Y");
        $horaActual  = date("H:i:s");

        $titulo = TmHorarios::query()
        ->join("tm_servicios as s","s.id","=","tm_horarios.servicio_id")
        ->join("tm_generalidades as n","n.id","=","s.nivel_id")
        ->join("tm_cursos as c","c.id","=","tm_horarios.curso_id")
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as m","m.id","=","d.asignatura_id")
        ->where("d.docente_id",$this->filters['docenteId'])
        ->where("d.id",$this->filters['paralelo'])
        ->selectRaw('d.id, m.descripcion as asignatura,s.descripcion as servicio,c.paralelo, n.descripcion as nivel, tm_horarios.periodo_id')
        ->first();

        $periodo = TmPeriodosLectivos::find($titulo['periodo_id']);

        $datos = [
            'nivel' => $titulo['nivel'],
            'subtitulo' => "Periodo Lectivo ".$periodo['descripcion'].' / Tercer Trimestre - Primer Parcial',
            'docente' => $docente['apellidos'].' '.$docente['nombres'],
            'materia' => $titulo['asignatura'],
            'curso' => $titulo['servicio'].' '.$titulo['paralelo'],
        ];

        $tblactividad = $this->actividad();
        $tblgrupo = $tblactividad->groupBy('actividad')->toBase();

        $tblrecords = $this->reporte();
        $column = count($tblgrupo)+3;

        return view('export.calificacionTotales',[
            'tblrecords' => $tblrecords,
            'tblgrupo' => $tblgrupo,
            'datos' => $datos,
            'fechaActual' => $fechaActual,
            'horaActual' => $horaActual,
            'colspan' => $this->colspan,
            'col' => $this->col,
            'colprom' => $this->colprom,
            'column' => $column,
        ]);
    }

    public function actividad(){

        $record = TmActividades::query()
        ->when($this->filters['paralelo'],function($query){
            return $query->where('paralelo',"{$this->filters['paralelo']}");
        })
        ->when($this->filters['termino'],function($query){
            return $query->where('termino',"{$this->filters['termino']}");
        })
        ->when($this->filters['bloque'],function($query){
            return $query->where('bloque',"{$this->filters['bloque']}");
        })
        ->selectRaw("id,nombre,actividad,puntaje")
        ->where("tipo","AC")
        ->where("docente_id",$this->filters['docenteId'])
        ->orderByRaw("actividad desc")
        ->get();

        return  $record;

    }

    public function reporte(){


        $tblactividad = $this->actividad();
        $tblgrupo = $tblactividad->groupBy('actividad')->toBase();

        /* Estudiantes */
        $tblrecords=[];

        $personas = TmHorariosDocentes::query()
        ->join("tm_horarios as h","h.id","=","tm_horarios_docentes.horario_id")
        ->join("tm_matriculas as m",function($join){
            $join->on("m.modalidad_id","=","h.grupo_id")
                ->on("m.periodo_id","=","h.periodo_id")
                ->on("m.curso_id","=","h.curso_id");
        })
        ->join("tm_personas as p","p.id","=","m.estudiante_id")
        ->select("p.*")
        ->where("tm_horarios_docentes.id",$this->filters['paralelo'])
        ->orderBy("p.apellidos")
        ->get();

        foreach ($personas as $key => $person)
        {   
            $index = $person->id;
            $tblrecords[$key]['id'] = 0;
            $tblrecords[$key]['personaId'] = $person->id;
            $tblrecords[$key]['nui'] = $person->identificacion;
            $tblrecords[$key]['nombres'] = $person->apellidos.' '.$person->nombres;
           
            foreach ($tblgrupo as $key2 => $grupo){

                foreach ($grupo as $key3 => $actividad){
                    $col = $key2.$key3;
                    $tblrecords[$key][$col] = 0.00;                   
                }
                $col = $key2."prom";
                $tblrecords[$key][$col] = 0;
            }

            $tblrecords[$key]['promedio'] = 0.00;
            $tblrecords[$key]['cualitativa'] = "";
        }

        $tblrecords['ZZ']['id'] = 0;
        $tblrecords['ZZ']['personaId'] = 0;
        $tblrecords['ZZ']['nui'] = '';
        $tblrecords['ZZ']['nombres'] = 'PROMEDIO DEL CURSO';

        foreach ($tblgrupo as $key2 => $grupo){

            foreach ($grupo as $key3 => $actividad){
                $col = $key2.$key3;
                $this->tblrecords['ZZ'][$col] = 0.00;                   
            }
            $col = $key2."prom";
            $tblrecords['ZZ'][$col] = 0;
        }

        $tblrecords['ZZ']['promedio'] = 0.00;
        $tblrecords['ZZ']['cualitativa'] = "";


        // Asigna Notas //
        foreach ($personas as $key => $person)
        {
            $personaId =  $person->id;
            $promedio  = 0; 

            foreach ($tblgrupo as $key2 => $grupo){

                $suma = 0;

                foreach ($grupo as $key3 => $actividad){
                   
                    $actividadId =  $actividad['id'];

                    $notas = TmActividades::query()
                    ->join('td_calificacion_actividades as n','n.actividad_id','=','tm_actividades.id')
                    ->when($this->filters['paralelo'],function($query){
                        return $query->where('paralelo',"{$this->filters['paralelo']}");
                    })
                    ->when($this->filters['termino'],function($query){
                        return $query->where('termino',"{$this->filters['termino']}");
                    })
                    ->when($this->filters['bloque'],function($query){
                        return $query->where('bloque',"{$this->filters['bloque']}");
                    })
                    ->where("tipo","AC")
                    ->where("docente_id",$this->filters['docenteId'])
                    ->where("actividad_id",$actividadId)
                    ->where("persona_id",$personaId)
                    ->select("n.*")
                    ->first();
                                        
                    $nota =  $notas['nota'];
                    $col = $key2.$key3;
                    $tblrecords[$key][$col] = floatval($nota);
                    $suma = $suma + floatval($nota);
                }
                $col = $key2."prom";
                $tblrecords[$key][$col] = $suma/($key3+1);
                $promedio = $promedio+$suma/($key3+1);
            }
            if ($promedio>0){
                $tblrecords[$key]['promedio'] = $promedio/count($tblgrupo);
            }
            
        }


        foreach ($tblgrupo as $key2 => $grupo){
            $col = $key2."prom";
            $valor = (array_sum(array_column($tblrecords,$col)));
            $tblrecords['ZZ'][$col] = $valor/count($personas);
        }

        $valor = (array_sum(array_column($tblrecords,'promedio')));
        $tblrecords['ZZ']['promedio'] = $valor/count($personas);

        // Escala Cualitativa
        $escalas = TdPeriodoSistemaEducativos::query()
        ->where("periodo_id",$this->filters['periodoId'])
        ->where("tipo","EC")
        ->get()->toArray();

        foreach ($tblrecords as $key1 => $records){

            $promedio = $records['promedio']; 
                
            foreach ($escalas as $escala) {
                
                $nota  = $escala['nota'];                  
                $letra = $escala['evaluacion'];

                if ($promedio >= ($nota-1)+0.01 && $promedio <= $nota) {
                    $tblrecords[$key1]['cualitativa'] = $letra;
                }
                
            }

        }        
           
        return $tblrecords;

    }

    public function columnWidths():array{
        return [
            'A' => 40,
            'B' => 15,
            'C' => 15,
            'D' => 15,
            'E' => 15,
            'F' => 15,
            'G' => 15,
            'H' => 15,
            'I' => 15,
            'J' => 15,
            'K' => 15,
            'L' => 15,
            'M' => 15,
            'N' => 15,
            'O' => 15,
            'P' => 15,
            'Q' => 15,
            'R' => 15,
            'S' => 15,
            'T' => 15,
            'U' => 15,
            'V' => 15,
            'W' => 15,
            'X' => 15,
            'Y' => 15,
            'Z' => 15
        ];
    }

    public function styles(Worksheet $sheet)
    {
        /*return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],

            // Styling a specific cell by coordinate.
            'B6' => ['font' => ['italic' => true]],

            // Styling an entire column.
            'C'  => ['font' => ['size' => 16]],
        ];*/
        $range = 'A1:K6';
        $style = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
            'font' => [
                'bold' => true,
            ]
        ];
        $sheet->getStyle($range)->applyFromArray($style);
        
    }

}
