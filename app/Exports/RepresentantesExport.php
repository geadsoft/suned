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
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;


class RepresentantesExport implements FromView, ShouldAutoSize, WithStyles, WithColumnFormatting
{
    use Exportable;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($filters)
    {
        $this->filters = json_decode($filters, true);
        
    }

    public function view(): View 
    {
        if($this->filters['srv_periodo']!=""){
            $periodo = TmPeriodosLectivos::find($this->filters['srv_periodo'])->toArray(); 
        }
                
        $tblrecords = TmPersonas::query()
        ->join("tm_matriculas as m","m.representante_id","=","tm_personas.id")
        ->join("tm_personas as e","m.estudiante_id","=","e.id")
        ->join("tm_cursos as c","c.id","=","m.curso_id")
        ->join("tm_servicios as s","s.id","=","c.servicio_id")
        ->join("tm_periodos_lectivos as p","p.id","=","m.periodo_id")
        ->join("tm_generalidades as g","g.id","=","tm_personas.nacionalidad_id")
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
        ->where('tm_personas.tipopersona','=','R')
        ->select('tm_personas.*','m.id as matriculaId','m.estudiante_id','s.descripcion','c.paralelo','m.usuario','e.apellidos as apeestudiante','e.nombres as nomestudiante','p.descripcion as periodo','g.descripcion as nacionalidad')
        ->orderBy('tm_personas.apellidos','asc')
        ->get();

        $nivelestudio = TmGeneralidades::where("superior",2)->get()->toArray();

        $consulta['periodo'] = $periodo['descripcion'] ?? 'Todos';
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

        return view('export.representantes',[
            'tblrecords'   => $tblrecords,
            'data'         => $consulta,
        ]);

    }

    public function styles(Worksheet $sheet)
    {

        $range = 'A7:H7';
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

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
        ];
    }

}
