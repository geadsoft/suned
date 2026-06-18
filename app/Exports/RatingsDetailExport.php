<?php

namespace App\Exports;
use App\Models\TmPersonas;
use App\Models\TdBoletinFinal;
use App\Models\TdConductas;
use App\Models\TmSedes;
use App\Models\TmPeriodosLectivos;
use App\Models\TdPeriodoSistemaEducativos;
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
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Conditional;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Illuminate\Support\Facades\DB;

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
        $curso  = TmCursos::query()
        ->join('tm_servicios as s','s.id','=','tm_cursos.servicio_id')
        ->select('s.descripcion','tm_cursos.paralelo')
        ->where('tm_cursos.id',$this->cursoId)  
        ->first();   

        $this->consulta['referencia'] = $tblperiodo['descripcion'];
        $this->consulta['nombre'] = $tblcia['nombre'];
        $this->consulta['direccion'] = $tblcia['direccion'];
        $this->consulta['telefono'] = $tblcia['telefono_sede'];
        $this->consulta['email'] = $tblcia['email'];
        $this->consulta['periodo'] = 'PERIODO LECTIVO '.$tblperiodo['descripcion'];
        $this->consulta['codigo'] = $tblcia['codigo'];
        $this->consulta['rector'] = '';
        $this->consulta['secretaria'] = '';
        $this->consulta['curso'] = $curso->descripcion.' - '.$curso->paralelo;

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
        ->select('termino', 'td_conductas.evaluacion', 'persona_id','s.nota', DB::raw('LEFT(s.evaluacion, 1) as letra'))
        ->get()
        ->groupBy('persona_id')
        ->map(function ($items) {

            $promedio = round($items->avg('nota'),2);

            return [
                'conducta' => $items->pluck('letra', 'termino')->toArray(),
                'promedio' => $promedio
            ];
        })
        ->toArray();

        foreach ($arrconducta as $persona => $data) {

            $promedio = $data['promedio'];
            $letra = '';

            foreach ($escalas as $eq) {
                if ($promedio >= $eq['nota'] && $promedio <= $eq['nota2']) {
                    $letra = substr($eq['evaluacion'], 0, 1); 
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
            $detalles[$idpersona]['suma_total'] = 0;
            $detalles[$idpersona]['promedio_final'] = 0;
            $detalles[$idpersona]['conducta']['1T'] = $arrconducta[$idpersona]['conducta']['1T'] ?? '';
            $detalles[$idpersona]['conducta']['2T'] = $arrconducta[$idpersona]['conducta']['2T'] ?? '';
            $detalles[$idpersona]['conducta']['3T'] = $arrconducta[$idpersona]['conducta']['3T'] ?? '';
            $detalles[$idpersona]['comportamiento'] = $arrconducta[$idpersona]['promedio_letra'] ?? '';
            $detalles[$idpersona]['promocion'] = '';

            $linea = $linea+1;
        }

        $numAsignaturas=count($this->asignaturas);
        foreach ($detalles as $idpersona => $asignaturas) {

            $suma = collect($asignaturas)->sum('PR');

            $promedio = count($this->asignaturas) > 0
                ? round($suma / $numAsignaturas, 2)
                : 0;

            $detalles[$idpersona]['suma_total'] = $suma;
            $detalles[$idpersona]['promedio_final'] = $promedio;

            if ($promedio >= 0 && $promedio <= 3.99) {
                $promocion = "PIERDE AÑO";
            } elseif ($promedio <= 6.99) {
                $promocion = "SUPLETORIO";
            } elseif ($promedio <= 10) {
                $promocion = "APROBADO";
            }
            
            $detalles[$idpersona]['promocion'] = $promocion;

        }

        
        return $detalles;

    }

    public function columnWidths(): array
    {
        $columnWidths = [];

        // Columnas fijas
        $columnWidths['A'] = 8;   // N°
        $columnWidths['B'] = 40;  // Nómina

        // Columnas dinámicas (asignaturas)
        $colIndex = 3; // D

        foreach ($this->asignaturas as $asignatura) {

            for ($i = 0; $i < 4; $i++) { // 6 columnas por materia
                $letra = Coordinate::stringFromColumnIndex($colIndex);
                $columnWidths[$letra] = 8;
                $colIndex++;
            }
            
        }

        $letra = Coordinate::stringFromColumnIndex($colIndex);
        $columnWidths[$letra] = 13;
        $colIndex++;

        $letra = Coordinate::stringFromColumnIndex($colIndex);
        $columnWidths[$letra] = 13;
        $colIndex++;

        for ($i = 0; $i < 4; $i++) { // 6 columnas por materia
            $letra = Coordinate::stringFromColumnIndex($colIndex);
            $columnWidths[$letra] = 8;
            $colIndex++;
        }

        $letra = Coordinate::stringFromColumnIndex($colIndex);
        $columnWidths[$letra] = 20;
        
        return $columnWidths;
    }

    public function styles(Worksheet $sheet)
    {
        //Encabezado
        $ultimaColumna = $sheet->getHighestColumn();

        for ($fila = 1; $fila <= 6; $fila++) {

            $rango = 'A' . $fila . ':' . $ultimaColumna . $fila;

            // Combinar fila completa
            $sheet->mergeCells($rango);

            // Centrar horizontal y verticalmente
            $sheet->getStyle($rango)->applyFromArray([
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical'   => Alignment::VERTICAL_CENTER,
                    'wrapText'   => true,
                ],
            ]);
        }

        //Centrar Datos
        $ultimaFila    = $sheet->getHighestRow();

        $sheet->getStyle('C7:' . $ultimaColumna . $ultimaFila)
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER);

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

        //Negrita Subtitulo
        $colmaterias = 2+count($this->asignaturas) * 4;
        $colfinal =  Coordinate::stringFromColumnIndex($colmaterias);
        $subtitulo = 'C8:' . $colfinal.'8';
        $sheet->getStyle($subtitulo)
        ->getFont()
        ->setBold(true);


        //Color por Materia
        $colIndex = 3; // desde D

        foreach ($this->asignaturas as $asignatura) {

            $inicio = Coordinate::stringFromColumnIndex($colIndex);
            $fin = Coordinate::stringFromColumnIndex($colIndex + 3); // 5 columnas visibles

            $sheet->getStyle($inicio . '8:' . $fin . $sheet->getHighestRow())
                ->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => '#75736F' // gris suave
                        ],
                    ],
                ]);

            $colIndex += 4; // saltar bloque completo
        }

        // Reprobados
        $lastRow = $sheet->getHighestRow();

        $colIndex = 3; // empieza en D

        foreach ($this->asignaturas as $asignatura) {

            // Columna FINAL (PF) → posición 5 del bloque
            $finalCol = Coordinate::stringFromColumnIndex($colIndex + 3);

            $conditional = new Conditional();
            $conditional->setConditionType(Conditional::CONDITION_CELLIS);
            $conditional->setOperatorType(Conditional::OPERATOR_LESSTHAN);
            $conditional->addCondition('7');

            // Estilo rojo solo texto (puedes cambiar a fondo si quieres)
            $conditional->getStyle()->getFont()->getColor()->setRGB('FF0000');

            // Aplicar solo a columna FINAL
            $sheet->getStyle($finalCol . '7:' . $finalCol . $lastRow)
                ->setConditionalStyles([$conditional]);

            $colIndex += 4; // siguiente asignatura
        }

        
        //Promedio Negrita
        $colIndex = 3;

        foreach ($this->asignaturas as $asignatura) {

            $finalCol = Coordinate::stringFromColumnIndex($colIndex + 3);

            $sheet->getStyle($finalCol . '9:' . $finalCol . $sheet->getHighestRow())
                ->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => 'B8CCE4',
                        ],
                    ],
                ]);

            $colIndex += 4;
        }

        $ultimaFila = $sheet->getHighestRow();
        // Columna A
        $sheet->getStyle('A7:A' . $ultimaFila)->applyFromArray([
            'borders' => [
                'outline' => [
                    'borderStyle' => Border::BORDER_MEDIUM,
                    'color' => ['argb' => '000000'],
                ],
                'inside' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        // Columna B
        $sheet->getStyle('B7:B' . $ultimaFila)->applyFromArray([
            'borders' => [
                'outline' => [
                    'borderStyle' => Border::BORDER_MEDIUM,
                    'color' => ['argb' => '000000'],
                ],
                'inside' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        $colIndex = 3; // C

        foreach ($this->asignaturas as $asignatura) {

            $inicioCol = Coordinate::stringFromColumnIndex($colIndex);
            $finCol    = Coordinate::stringFromColumnIndex($colIndex + 3);

            // Desde la fila del encabezado hasta la última fila de datos
            $rango = $inicioCol . '7:' . $finCol . $sheet->getHighestRow();

            $sheet->getStyle($rango)->applyFromArray([
                'borders' => [
                    'outline' => [
                        'borderStyle' => Border::BORDER_MEDIUM,
                        'color' => ['argb' => '000000'],
                    ],
                ],
            ]);

            $colIndex += 4;
        }

        $sheet->getStyle('A7:' . $ultimaColumna . '8')
        ->applyFromArray([
            'borders' => [
                'outline' => [
                    'borderStyle' => Border::BORDER_MEDIUM,
                    'color' => ['argb' => '000000'],
                ]
            ],
        ]);

        //Totales
        $indexColIni = $colIndex;
        $indexColFin = $colIndex;

        $iniCol = Coordinate::stringFromColumnIndex($indexColIni);
        $finCol = Coordinate::stringFromColumnIndex($indexColFin);
        $rango = $iniCol . '7:' . $finCol . $sheet->getHighestRow();

        $sheet->getStyle($rango)->applyFromArray([
            'borders' => [
                'outline' => [
                    'borderStyle' => Border::BORDER_MEDIUM,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        $indexColIni = $indexColIni+1;
        $indexColFin = $indexColFin+1;

        $iniCol = Coordinate::stringFromColumnIndex($indexColIni);
        $finCol = Coordinate::stringFromColumnIndex($indexColFin);
        $rango = $iniCol . '7:' . $finCol . $sheet->getHighestRow();

        $sheet->getStyle($rango)->applyFromArray([
            'borders' => [
                'outline' => [
                    'borderStyle' => Border::BORDER_MEDIUM,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        $indexColIni = $indexColIni+1;
        $indexColFin = $indexColIni+3;

        $iniCol = Coordinate::stringFromColumnIndex($indexColIni);
        $finCol = Coordinate::stringFromColumnIndex($indexColFin);
        $rango = $iniCol . '7:' . $finCol . $sheet->getHighestRow();

        $sheet->getStyle($rango)->applyFromArray([
            'borders' => [
                'outline' => [
                    'borderStyle' => Border::BORDER_MEDIUM,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        $indexColIni = $indexColIni+1;
        $indexColFin = $indexColFin+1;

        $iniCol = Coordinate::stringFromColumnIndex($indexColIni);
        $finCol = Coordinate::stringFromColumnIndex($indexColFin);
        $rango = $iniCol . '7:' . $finCol . $sheet->getHighestRow();

        $sheet->getStyle($rango)->applyFromArray([
            'borders' => [
                'outline' => [
                    'borderStyle' => Border::BORDER_MEDIUM,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        //Formula Suma
        // C = 3
        // Cada asignatura ocupa 4 columnas
        $colInicioMaterias = 3;
        $totalMaterias = count($this->asignaturas);

        // Columna SUMA TOTAL
        $colSumaTotal = Coordinate::stringFromColumnIndex(
            $colInicioMaterias + ($totalMaterias * 4)
        );

        // Columna PROMEDIO FINAL
        $colPromedioFinal = Coordinate::stringFromColumnIndex(
            3 + ($totalMaterias * 4) + 1
        );

        $filaInicio = 9;
        $filaFin = $sheet->getHighestRow();

        for ($fila = $filaInicio; $fila <= $filaFin; $fila++) {

            $formula = [];
            $colIndex = 3; // C

            foreach ($this->asignaturas as $asignatura) {

                // 4ta columna del bloque = Promedio
                $colPromedio = Coordinate::stringFromColumnIndex($colIndex + 3);

                $formula[] = $colPromedio . $fila;

                $colIndex += 4;
            }

            $sheet->setCellValue(
                $colSumaTotal . $fila,
                '=SUM(' . implode(',', $formula) . ')'
            );
        }

        $filaInicio = 9;
        $filaFin = $sheet->getHighestRow();

        for ($fila = $filaInicio; $fila <= $filaFin; $fila++) {

            $sheet->setCellValue(
                $colPromedioFinal . $fila,
                '=ROUND(' . $colSumaTotal . $fila . '/' . $totalMaterias . ',2)'
            );

        }

        $sheet->getStyle(
            $colSumaTotal . '9:' . $colPromedioFinal . $ultimaFila
        )->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'B8CCE4',
                ],
            ],
            'font' => [
                'bold' => true,
            ],
        ]);

        $colPromConducta = Coordinate::stringFromColumnIndex(
            3 + ($totalMaterias * 4) + 5
        );

        $sheet->getStyle(
            $colPromConducta . '9:' . $colPromConducta . $sheet->getHighestRow()
        )->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'B8CCE4',
                ],
            ],
            'font' => [
                'bold' => true,
            ],
        ]);
        
    }
}
