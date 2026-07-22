<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <title>Recepción de documentos</title>

    <style>
        @page {
            margin: 20px 22px 20px 22px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 9px;
            color: #1f2937;
        }

        .contenedor {
            width: 96%;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            padding: 12px;
        }

        .tabla-encabezado {
            width: 96%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        .tabla-encabezado td {
            vertical-align: middle;
        }

        .logo {
            width: 150px;
            height: auto;
        }

        .institucion {
            width: 38%;
            font-size: 8px;
            font-weight: bold;
        }

        .titulo {
            width: 52%;
            text-align: right;
            font-size: 15px;
            font-weight: bold;
            color: #1d4ed8;
        }

        .datos-estudiante {
            width: 96%;
            border: 1px solid #dbe3ec;
            border-radius: 7px;
            padding: 10px 12px;
            margin-bottom: 10px;
        }

        .tabla-datos {
            width: 100%;
            border-collapse: collapse;
        }

        .tabla-datos td {
            padding: 2px 3px;
            vertical-align: top;
        }

        .etiqueta {
            width: 32%;
            text-align: right;
            font-weight: bold;
            color: #111827;
        }

        .valor {
            width: 68%;
            padding-left: 8px !important;
        }

        .tabla-documentos {
            width: 100%;
            border-collapse: separate;
            border-spacing: 6px 0;
            table-layout: fixed;
        }

        .tabla-documentos td {
            width: 50%;
            vertical-align: top;
            border: 1px solid #dbe3ec;
            border-radius: 7px;
            padding: 0;
        }

        .titulo-seccion {
            text-align: center;
            font-size: 10px;
            font-weight: bold;
            padding: 7px 4px;
            border-bottom: 1px solid #dbe3ec;
        }

        .titulo-completo {
            color: #16a34a;
        }

        .titulo-faltante {
            color: #dc2626;
        }

        .contenido-documentos {
            height: 690px;
            padding: 9px 9px 12px 9px;
        }

        .lista-documentos {
            margin: 0;
            padding-left: 17px;
        }

        .lista-documentos li {
            margin-bottom: 4px;
            line-height: 1.25;
            font-size: 8px;
        }

        .sin-documentos {
            font-size: 8px;
            text-align: center;
            color: #6b7280;
            padding-top: 12px;
        }

        .comentario {
            margin-top: 8px;
            border: 1px solid #93c5fd;
            background-color: #eff6ff;
            border-radius: 5px;
            padding: 7px 8px;
            min-height: 45px;
        }

        .comentario-titulo {
            font-weight: bold;
            font-size: 8px;
            margin-bottom: 5px;
        }

        .comentario-texto {
            font-size: 8px;
            line-height: 1.3;
        }

        .firmas {
            width: 100%;
            border-collapse: collapse;
            margin-top: 27px;
        }

        .firmas td {
            width: 50%;
            text-align: center;
            vertical-align: bottom;
        }

        .linea-firma {
            width: 145px;
            border-top: 1px solid #4b5563;
            margin: 0 auto 5px auto;
        }

        .nombre-firma {
            font-size: 8px;
        }

        .estado-general {
            margin-top: 6px;
            text-align: center;
            font-weight: bold;
            font-size: 8px;
        }

        .estado-completo {
            color: #16a34a;
        }

        .estado-pendiente {
            color: #dc2626;
        }
    </style>
</head>

<body>

<div class="contenedor">

    {{-- Encabezado --}}
    <table class="tabla-encabezado">
        <tr>
            <td style="width: 10%">
                <img
                    src="{{ URL::asset('assets/images/American Schooll.png')}}"
                    class="logo"
                    alt="Logo"
                >
            </td>
            <td class="titulo">
                RECEPCIÓN DE DOCUMENTOS
            </td>
        </tr>
    </table>

    {{-- Información del estudiante --}}
    <div class="datos-estudiante">
        <table class="tabla-datos">
            <tr>
                <td class="etiqueta">Estudiante:</td>
                <td class="valor">
                    {{ mb_strtoupper($matricula->estudiante ?? '') }}
                </td>
            </tr>

            <tr>
                <td class="etiqueta">Curso:</td>
                <td class="valor">
                    {{ mb_strtoupper($matricula->curso ?? '') }}
                </td>
            </tr>

            <tr>
                <td class="etiqueta">Representante:</td>
                <td class="valor">
                    {{ mb_strtoupper($matricula->representante ?? '') }}
                </td>
            </tr>

            <tr>
                <td class="etiqueta">Fecha de consulta:</td>
                <td class="valor">
                    {{ $fechaConsulta->locale('es')->translatedFormat(
                        'l d \d\e F \d\e Y \a \l\a\s H:i'
                    ) }}
                </td>
            </tr>
        </table>
    </div>

    {{-- Documentación completa y faltante --}}
    <table class="tabla-documentos">
        <tr>
            <td>
                <div class="titulo-seccion titulo-completo">
                    DOCUMENTACIÓN COMPLETA
                </div>

                <div class="contenido-documentos">
                    @if($documentosCompletos->isNotEmpty())
                        <ol class="lista-documentos">
                            @foreach($documentosCompletos as $documento)
                                <li>
                                    {{ mb_strtoupper($documento->descripcion) }}
                                </li>
                            @endforeach
                        </ol>
                    @else
                        <div class="sin-documentos">
                            No existen documentos entregados.
                        </div>
                    @endif
                </div>
            </td>

            <td>
                <div class="titulo-seccion titulo-faltante">
                    DOCUMENTACIÓN FALTANTE
                </div>

                <div class="contenido-documentos">
                    @if($documentosFaltantes->isNotEmpty())
                        <ol class="lista-documentos">
                            @foreach($documentosFaltantes as $documento)
                                <li>
                                    {{ mb_strtoupper($documento->descripcion) }}
                                </li>
                            @endforeach
                        </ol>
                    @else
                        <div class="sin-documentos">
                            No existen documentos pendientes.
                        </div>
                    @endif
                </div>
            </td>
        </tr>
    </table>

    {{-- Comentario visible --}}
    <div class="comentario">
        <div class="comentario-titulo">
            Comentario visible en impresión
        </div>

        <div class="comentario-texto">
            {{ $cabecera->comentario_impresion ?: 'Sin comentarios registrados.' }}
        </div>
    </div>

    {{-- Estado general --}}
    <div class="estado-general">
        @if($cabecera->documentacion_completa)
            <span class="estado-completo">
                EXPEDIENTE CON DOCUMENTACIÓN COMPLETA
            </span>
        @else
            <span class="estado-pendiente">
                EXPEDIENTE CON DOCUMENTACIÓN PENDIENTE
            </span>
        @endif
    </div>

    {{-- Firmas --}}
    <table class="firmas">
        <tr>
            <td>
                <div class="linea-firma"></div>
                <div class="nombre-firma">
                    Firma Secretaría
                </div>
            </td>

            <td>
                <div class="linea-firma"></div>
                <div class="nombre-firma">
                    Firma Representante
                </div>
            </td>
        </tr>
    </table>

</div>

</body>
</html>