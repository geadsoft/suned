<?php

namespace App\Exports;
use App\Models\TmPersonas;
use App\Models\TdBoletinFinal;
use App\Models\TdConductas;
use App\Models\TmSedes;
use App\Models\TmPeriodosLectivos;
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
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Conditional;


class RatingsDetailExport implements FromView, WithColumnWidths, WithStyles
{
    use Exportable;

    public $colspan, $col="", $colprom="";
    public $grupoId,$servicioId,$periodoId,$cursoId, $alumnos, $asignaturas;

    public function __construct($filters)
    {
        $data = json_decode($filters, true);

        $this->periodoId  = $data['periodoId'];
        $this->grupoId    = $data['grupoId'];
        $this->servicioId = $data['gradoId'];
        $this->cursoId    = $data['cursoId'];

    }

    public function view(): View 
    {

        $tblperiodo = TmPeriodosLectivos::find($this->periodoId);
        $detalles = $this->notas();
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

        $materias = count($this->asignaturas);

        return view('export.cuadroCalificaciones',[
            'alumnos'     => $this->alumnos,
            'asignaturas' => $this->asignaturas,
            'detalles'  => $detalles,
            'data' => $this->consulta,
            'column' => 3+($materias*5)+$materias,
        ]);
    
    }

    public function boletin(){

        $records = TdBoletinFinal::query()
        ->join('tm_personas as p', 'p.id', '=', 'td_boletin_finals.persona_id')
        ->join('tm_asignaturas as m', 'm.id', '=', 'td_boletin_finals.asignatura_id')
        ->when($this->cursoId, function ($query) {
            return $query->where('curso_id', $this->cursoId);
        })
        ->where('periodo_id', $this->periodoId)
        ->select(
            'td_boletin_finals.*',
            'p.apellidos',
            'p.nombres',
            'm.descripcion as asignatura'
        )
        ->orderBy('p.apellidos')
        ->orderBy('m.descripcion')
        ->get();

        return $records;

    }

    public function notas(){

        $records = $this->boletin();

        $this->alumnos = $records
        ->groupBy('persona_id')
        ->map(function ($items) {
            return [
                'persona_id' => $items->first()->persona_id,
                'apellidos'  => $items->first()->apellidos,
                'nombres'    => $items->first()->nombres,
            ];
        })
        ->values();

        $this->asignaturas = $records
        ->groupBy('asignatura_id')
        ->map(function ($items) {
            return [
                'asignatura_id' => $items->first()->asignatura_id,
                'descripcion'   => $items->first()->asignatura,
            ];
        })
        ->values();

        $linea=1;
        $detalle = [];

        //Conducta
        $escalas = TdPeriodoSistemaEducativos::query()
        ->where("periodo_id",$this->periodoId)
        ->where("modalidad_id",$this->grupoId)
        ->where("tipo","EC")
        ->selectRaw("*,nota + case when nota=10 then 0 else 0.99 end as nota2")
        ->get()->toArray();

        $arrconducta = TdConductas::query()
        ->join("td_periodo_sistema_educativos as s", function($join){
            $join->on("s.periodo_id","=","td_conductas.periodo_id")
                ->on("s.codigo","=","td_conductas.evaluacion")
                ->where("s.tipo","EC");
        })
        ->where("td_conductas.periodo_id", $this->periodoId)
        ->where("td_conductas.modalidad_id", $this->grupoId)
        ->where("td_conductas.curso_id", $this->cursoId)
        ->whereIn("td_conductas.persona_id", $this->alumnos->pluck('persona_id'))
        ->select('termino', 'td_conductas.evaluacion', 'persona_id','s.nota')
        ->get()
        ->groupBy('persona_id')
        ->map(function ($items) {

            $promedio = round($items->avg('nota'),2);

            return [
                'conducta' => $items->pluck('evaluacion', 'termino')->toArray(),
                'promedio' => $promedio
            ];
        })
        ->toArray();

        foreach ($arrconducta as $persona => $data) {

            $promedio = $data['promedio'];
            $letra = '';

            foreach ($escalas as $eq) {
                if ($promedio >= $eq['nota'] && $promedio <= $eq['nota2']) {
                    $letra = $eq['codigo'];
                    break;
                }
            }

            $arrconducta[$persona]['promedio_letra'] = $letra;
        }

        //Detalle
        foreach ($this->alumnos as $persona)
        {
            $idpersona = $persona['persona_id'];
            $detalles[$idpersona]['linea'] = $linea;
            $detalles[$idpersona]['nombres'] = $persona['apellidos'].' '.$persona['nombres'];
            $detalles[$idpersona]['comportamiento'] = $arrconducta[$idpersona]['promedio_letra'] ?? '';

            foreach($this->asignaturas as $asignatura){
                $idasignatura = $asignatura['asignatura_id'];

                $nota = $records
                ->where('persona_id', $idpersona)
                ->where('asignatura_id', $idasignatura)
                ->first();

                $detalles[$idpersona][$idasignatura]['1T'] = $nota->{'1T_notatrimestre'} ?? 0;
                $detalles[$idpersona][$idasignatura]['2T'] = $nota->{'2T_notatrimestre'} ?? 0;
                $detalles[$idpersona][$idasignatura]['3T'] = $nota->{'3T_notatrimestre'} ?? 0;
                $detalles[$idpersona][$idasignatura]['PR'] = $nota->promedio_anual ?? 0;
                $detalles[$idpersona][$idasignatura]['PF'] = $nota->promedio_final ?? 0;
            }

            $linea = $linea+1;
        }

        return $detalles;

    }

    public function columnWidths(): array
    {
        $columnWidths = [];

        // Columnas fijas
        $columnWidths['A'] = 8;   // N°
        $columnWidths['B'] = 40;  // Nómina
        $columnWidths['C'] = 17;  // Comportamiento

        // Columnas dinámicas (asignaturas)
        $colIndex = 4; // D

        foreach ($this->asignaturas as $asignatura) {

            for ($i = 0; $i < 6; $i++) { // 6 columnas por materia
                $letra = Coordinate::stringFromColumnIndex($colIndex);

                if ($i==5){
                    $columnWidths[$letra] = 1;
                }else{
                    $columnWidths[$letra] = 7;
                }
                $colIndex++;
            }
            
        }
        
        return $columnWidths;
    }

    public function styles(Worksheet $sheet)
    {
        // Total columnas = 3 fijas + (asignaturas * 6)
        $totalColumnas = 3 + (count($this->asignaturas) * 6);

        $ultimaColumna = Coordinate::stringFromColumnIndex($totalColumnas);

        // ENCABEZADO
        $range = 'A1:' . $ultimaColumna . '6';

        $sheet->getStyle($range)->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
            'font' => [
                'bold' => true,
            ]
        ]);

        // OPCIONAL: Bordes a toda la tabla
        $lastRow = $sheet->getHighestRow();

        $sheet->getStyle('A1:' . $ultimaColumna . $lastRow)
            ->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ]);

        //Color por Materia
        $colIndex = 4; // desde D

        foreach ($this->asignaturas as $asignatura) {

            $inicio = Coordinate::stringFromColumnIndex($colIndex);
            $fin = Coordinate::stringFromColumnIndex($colIndex + 4); // 5 columnas visibles

            $sheet->getStyle($inicio . '8:' . $fin . $sheet->getHighestRow())
                ->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => '#75736F' // gris suave
                        ],
                    ],
                ]);

            $colIndex += 6; // saltar bloque completo
        }

        // Reprobados
        $lastRow = $sheet->getHighestRow();

        $colIndex = 4; // empieza en D

        foreach ($this->asignaturas as $asignatura) {

            // Columna FINAL (PF) → posición 5 del bloque
            $finalCol = Coordinate::stringFromColumnIndex($colIndex + 4);

            $conditional = new Conditional();
            $conditional->setConditionType(Conditional::CONDITION_CELLIS);
            $conditional->setOperatorType(Conditional::OPERATOR_LESSTHAN);
            $conditional->addCondition('7');

            // Estilo rojo solo texto (puedes cambiar a fondo si quieres)
            $conditional->getStyle()->getFont()->getColor()->setRGB('FF0000');

            // Aplicar solo a columna FINAL
            $sheet->getStyle($finalCol . '7:' . $finalCol . $lastRow)
                ->setConditionalStyles([$conditional]);

            $colIndex += 6; // siguiente asignatura
        }

        //Promedio Negrita
        $colIndex = 4;

        foreach ($this->asignaturas as $asignatura) {

            // Promedio (col + 3)
            //$promCol = Coordinate::stringFromColumnIndex($colIndex + 3);

            // Final (col + 4)
            $finalCol = Coordinate::stringFromColumnIndex($colIndex + 4);

            //$sheet->getStyle($promCol . '7:' . $promCol . $sheet->getHighestRow())
            //    ->getFont()->setBold(true);

            $sheet->getStyle($finalCol . '7:' . $finalCol . $sheet->getHighestRow())
                ->getFont()->setBold(true);

            $colIndex += 6;
        }

        $sheet->getDefaultRowDimension()->setRowHeight(16);

        $sheet->getStyle('A1:' . $ultimaColumna . $sheet->getHighestRow())
        ->getAlignment()
        ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $lastRow = $sheet->getHighestRow();

        // Auto height
        for ($row = 7; $row <= $lastRow; $row++) {
            $sheet->getRowDimension($row)->setRowHeight(-1);
        }

        // Wrap text global
        $sheet->getStyle('A1:' . $ultimaColumna . $lastRow)
            ->getAlignment()
            ->setWrapText(true);


    }
}
