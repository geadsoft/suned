<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <title>Acta de Calificaciones</title>

    <style>
        /*
        |--------------------------------------------------------------------------
        | Configuración de la página
        |--------------------------------------------------------------------------
        */

        @page {
            margin: 15px 15px 32px 15px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: DejaVu Sans, Arial, Helvetica, sans-serif;
            font-size: 7px;
            color: #000000;
        }

        /*
        |--------------------------------------------------------------------------
        | Utilidades
        |--------------------------------------------------------------------------
        */

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .font-bold {
            font-weight: bold;
        }

        /*
        |--------------------------------------------------------------------------
        | Encabezado
        |--------------------------------------------------------------------------
        */

        .encabezado {
            width: 100%;
            margin-bottom: 10px;
        }

        .encabezado-imagen {
            width: 100%;
            margin-bottom: 10px;
        }

        .encabezado-imagen img {
            display: block;
            width: 100%;
            height: 75px;
        }

        .datos-reporte {
            width: 100%;
            text-align: center;
            font-size: 8px;
            line-height: 1.35;
            margin-bottom: 10px;
        }

        .datos-reporte p {
            margin: 0;
            padding: 0;
        }

        .titulo-institucion {
            font-size: 8px;
        }

        .titulo-reporte {
            font-size: 8px;
            font-weight: bold;
        }

        /*
        |--------------------------------------------------------------------------
        | Tabla principal
        |--------------------------------------------------------------------------
        */

        .tabla-calificaciones {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin: 0;
            padding: 0;
        }

        .tabla-calificaciones thead {
            display: table-header-group;
        }

        .tabla-calificaciones tbody {
            display: table-row-group;
        }

        .tabla-calificaciones tr {
            page-break-inside: avoid;
        }

        .tabla-calificaciones th,
        .tabla-calificaciones td {
            border: 0.5px solid #cfd5dc;
            padding: 2px 1px;
            vertical-align: middle;
            overflow: hidden;
            word-wrap: break-word;
            overflow-wrap: break-word;
            line-height: 1.15;
        }

        .tabla-calificaciones th {
            text-align: center;
            font-size: 6px;
            font-weight: bold;
            color: #586174;
            background-color: #f8f9fa;
            text-transform: uppercase;
        }

        .tabla-calificaciones td {
            font-size: 6.5px;
        }

        /*
        |--------------------------------------------------------------------------
        | Ancho de columnas especiales
        |--------------------------------------------------------------------------
        */

        .columna-nombres {
            width: 18%;
        }

        .columna-promedio {
            width: 5%;
        }

        .columna-cualitativa {
            width: 6%;
        }

        .celda-nombre {
            text-align: left;
            padding-left: 3px !important;
        }

        .celda-nota {
            text-align: center;
            white-space: nowrap;
        }

        .celda-promedio {
            text-align: center;
            font-weight: bold;
            white-space: nowrap;
        }

        /*
        |--------------------------------------------------------------------------
        | Encabezados de grupos
        |--------------------------------------------------------------------------
        */

        .encabezado-grupo {
            height: 18px;
        }

        .encabezado-actividad {
            height: 55px;
            font-size: 5.7px !important;
            line-height: 1.2;
        }

        /*
        |--------------------------------------------------------------------------
        | Fila de totales o fila especial ZZ
        |--------------------------------------------------------------------------
        */

        .fila-total td {
            font-weight: bold;
            background-color: #f4f4f4;
        }

        /*
        |--------------------------------------------------------------------------
        | Pie de página
        |--------------------------------------------------------------------------
        */

        .pie-pagina {
            position: fixed;
            left: 0;
            right: 0;
            bottom: -23px;
            width: 100%;
            font-size: 6.5px;
        }

        .tabla-pie {
            width: 100%;
            border-collapse: collapse;
        }

        .tabla-pie td {
            border: none;
            padding: 0;
            vertical-align: middle;
        }

        .pie-sistema {
            width: 50%;
            text-align: left;
        }

        .pie-usuario {
            width: 35%;
            text-align: center;
        }

        .pie-pagina-numero {
            width: 15%;
            text-align: right;
        }
    </style>
</head>

<body>

    {{-- ================================================================
        ENCABEZADO
    ================================================================= --}}

    <div class="encabezado">

        <div class="encabezado-imagen">
            <img
                src="{{ public_path('assets/images/banner-ueas.jpg') }}"
                alt="Unidad Educativa American School"
            >
        </div>

        <div class="datos-reporte">

            <p class="titulo-institucion">
                UNIDAD EDUCATIVA AMERICAN SCHOOL -
                {{ $datos['nivel'] ?? '' }}
            </p>

            <p class="titulo-reporte">
                ACTA DE CALIFICACIONES
            </p>

            <p>
                {{ $datos['subtitulo'] ?? '' }}
            </p>

            <p>
                {{ $datos['docente'] ?? '' }}
                /
                {{ $datos['materia'] ?? '' }}
            </p>

            <p>
                {{ $datos['curso'] ?? '' }}
            </p>

        </div>

    </div>

    {{-- ================================================================
        TABLA DE CALIFICACIONES
    ================================================================= --}}

    <table class="tabla-calificaciones">

        <colgroup>

            {{-- Columna de nombres --}}
            <col class="columna-nombres">

            {{-- Columnas dinámicas de actividades y promedios --}}
            @foreach ($tblgrupo as $key => $grupo)

                @foreach ($grupo as $data)
                    <col>
                @endforeach

                {{-- Promedio del grupo AI o AG --}}
                <col>

            @endforeach

            {{-- Promedio final --}}
            <col class="columna-promedio">

            {{-- Nota cualitativa --}}
            <col class="columna-cualitativa">

        </colgroup>

        <thead>

            {{-- Primera fila: grupos --}}
            <tr class="encabezado-grupo">

                <th>
                    Nombres
                </th>

                @foreach ($tblgrupo as $key => $grupo)

                    <th colspan="{{ count($grupo) + 1 }}">

                        @if ($key === 'AI')
                            Actividad Individual
                        @elseif ($key === 'AG')
                            Actividad Grupal
                        @else
                            {{ $key }}
                        @endif

                    </th>

                @endforeach

                <th rowspan="2">
                    Promedio
                </th>

                <th rowspan="2">
                    Cualitativa
                </th>

            </tr>

            {{-- Segunda fila: actividades --}}
            <tr class="encabezado-actividad">

                <th></th>

                @foreach ($tblgrupo as $key => $grupo)

                    @foreach ($grupo as $data)

                        <th>
                            {{ $data->nombre ?? '' }}
                        </th>

                    @endforeach

                    <th>
                        Promedio {{ $key }}
                    </th>

                @endforeach

            </tr>

        </thead>

        <tbody>

            @foreach ($tblrecords as $fil => $record)

                <tr class="{{ $fil === 'ZZ' ? 'fila-total' : '' }}">

                    {{-- Nombre del estudiante --}}
                    <td class="celda-nombre">
                        {{ $record['nombres'] ?? '-' }}
                    </td>

                    {{-- Actividades individuales y grupales --}}
                    @foreach ($tblgrupo as $keyGrupo => $grupo)

                        @foreach ($grupo as $keyActividad => $actividad)

                            @php
                                $claveNota = $keyGrupo . $keyActividad;
                                $nota = $record[$claveNota] ?? null;
                            @endphp

                            <td class="celda-nota">

                                @if ($nota !== null && $nota !== '')
                                    {{ number_format((float) $nota, 2) }}
                                @else
                                    -
                                @endif

                            </td>

                        @endforeach

                        @php
                            $clavePromedioGrupo = $keyGrupo . '-prom';
                            $promedioGrupo = $record[$clavePromedioGrupo] ?? null;
                        @endphp

                        <td class="celda-promedio">

                            @if ($promedioGrupo !== null && $promedioGrupo !== '')
                                {{ number_format((float) $promedioGrupo, 2) }}
                            @else
                                -
                            @endif

                        </td>

                    @endforeach

                    {{-- Promedio final --}}
                    <td class="celda-promedio">

                        @if (
                            isset($record['promedio']) &&
                            $record['promedio'] !== ''
                        )
                            {{ number_format((float) $record['promedio'], 2) }}
                        @else
                            -
                        @endif

                    </td>

                    {{-- Nota cualitativa --}}
                    <td class="celda-nota">
                        {{ $record['cualitativa'] ?? '-' }}
                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>

    {{-- ================================================================
        PIE DE PÁGINA
    ================================================================= --}}

    <div class="pie-pagina">

        <table class="tabla-pie">

            <tr>

                <td class="pie-sistema">
                    SAMS | School and Administrative Management System
                </td>

                <td class="pie-usuario">
                    Usuario:
                    {{ auth()->user()->name ?? 'Sistema' }}
                </td>

                <td class="pie-pagina-numero">
                </td>

            </tr>

        </table>

    </div>

    {{-- ================================================================
        NUMERACIÓN DE PÁGINAS DOMPDF
    ================================================================= --}}

    <script type="text/php">
        if (isset($pdf)) {

            $font = $fontMetrics->get_font(
                "DejaVu Sans",
                "normal"
            );

            $pdf->page_script('
                $texto = "Pág. " . $PAGE_NUM . " de " . $PAGE_COUNT;

                $font = $fontMetrics->get_font(
                    "DejaVu Sans",
                    "normal"
                );

                $anchoTexto = $fontMetrics->get_text_width(
                    $texto,
                    $font,
                    7
                );

                $x = $pdf->get_width() - $anchoTexto - 18;
                $y = $pdf->get_height() - 17;

                $pdf->text(
                    $x,
                    $y,
                    $texto,
                    $font,
                    7
                );
            ');
        }
    </script>

</body>
</html>