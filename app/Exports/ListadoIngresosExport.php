<?php

namespace App\Exports;
use App\Models\TrCobrosCabs;
use App\Models\TmGeneralidades;
use App\Models\TmPeriodosLectivos;
use App\Models\TmCursos;

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
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ListadoIngresosExport implements FromView, WithColumnWidths, WithStyles, WithColumnFormatting
{
    use Exportable;

    public $filters;

    public function __construct($filters)
    {
        $this->filters = json_decode($filters, true);
        
    }

    public function view(): View 
    { 
        $tblrecords = TrCobrosCabs::query()
        ->join("tr_cobros_dets as cd","tr_cobros_cabs.id","=","cd.cobrocab_id")
        ->join("tr_deudas_dets as dd","dd.cobro_id","=","tr_cobros_cabs.id")
        ->join("tr_deudas_cabs as dc","dc.id","=","dd.deudacab_id")
        ->join("tm_matriculas as m","m.id","=","dc.matricula_id")
        ->join("tm_personas as p","p.id","=","m.estudiante_id")
        ->join("tm_personas as pe","pe.id","=","m.representante_id")
        ->join("tm_cursos as c","c.id","=","m.curso_id")
        ->join("tm_servicios as s","s.id","=","c.servicio_id")
        ->join("tm_generalidades as bc","bc.id","=","cd.entidad_id")

        ->when($this->filters['srv_nombre'], function ($query) {
            return $query->where('tr_cobros_cabs.documento', $this->filters['srv_nombre']);
        })
        ->when($this->filters['srv_periodo'], function ($query) {
            return $query->where('m.periodo_id', $this->filters['srv_periodo']);
        })
        ->when($this->filters['srv_grupo'], function ($query) {
            return $query->where('m.modalidad_id', $this->filters['srv_grupo']);
        })
        ->when($this->filters['srv_curso'], function ($query) {
            return $query->where('m.id', $this->filters['srv_curso']);
        })
        ->when($this->filters['srv_fechaini'], function ($query) {
            return $query->whereBetween(
                'tr_cobros_cabs.fecha',
                [
                    date('Ymd', strtotime($this->filters['srv_fechaini'])),
                    date('Ymd', strtotime($this->filters['srv_fechafin']))
                ]
            );
        })

        ->select(
            'tr_cobros_cabs.fecha',
            'tr_cobros_cabs.fechapago',
            'tr_cobros_cabs.documento',
            'tr_cobros_cabs.monto',
            'p.nombres',
            'p.apellidos',
            's.descripcion',
            'c.paralelo',
            'cd.tipopago',
            DB::raw("GROUP_CONCAT(dd.detalle ORDER BY dd.detalle SEPARATOR ', ') as detalle"),
            'cd.referencia',
            'bc.descripcion as entidad',
            DB::raw('SUM(dd.valor) as pago'),
            'cd.valor',
            'tr_cobros_cabs.usuario',
            DB::raw("CONCAT(pe.nombres,' ',pe.apellidos) as representante"),
            'pe.identificacion as nuirepresentante' 
        )

        ->where('dd.tipo','<>','DES')
        ->where('tr_cobros_cabs.tipo','=','CP')
        ->where('tr_cobros_cabs.estado','=',$this->filters['srv_estado'])

        ->groupBy(
            'tr_cobros_cabs.fecha',
            'tr_cobros_cabs.fechapago',
            'tr_cobros_cabs.documento',
            'tr_cobros_cabs.monto',
            'p.nombres',
            'p.apellidos',
            's.descripcion',
            'c.paralelo',
            'cd.tipopago',
            'cd.referencia',
            'bc.descripcion',
            'cd.valor',
            'tr_cobros_cabs.usuario',
            'representante',
            'pe.identificacion'
        )

        ->orderBy('tr_cobros_cabs.fecha')
        ->get();

        return view('export.listadoIngresos',[
            'tblrecords' => $tblrecords,
            'filters' => $this->filters,
        ]);
    }

    public function columnWidths():array{
        return [
            'A' => 14,
            'B' => 14,
            'C' => 10,
            'D' => 15,
            'E' => 37,
            'F' => 37,
            'G' => 37,
            'H' => 15,
            'I' => 11,
            'J' => 20,
            'K' => 21,
            'L' => 15,
            'M' => 40,
            'N' => 25,
        ];
    }

    public function styles(Worksheet $sheet)
    {

        $range = 'A1:N3';
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
                'H' => NumberFormat::FORMAT_TEXT,
            ];
        }
    

}
