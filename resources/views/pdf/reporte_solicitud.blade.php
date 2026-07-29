<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <title>
        Solicitud N.º {{ str_pad($solicitud->documento, 6, '0', STR_PAD_LEFT) }}
    </title>

    <style>
        @page {
            margin: 20px 28px;
            size: A4 portrait;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            color: #173873;
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 10px;
        }

        .header-table {
            width: 100%;
            margin-bottom: 8px;
            border-collapse: collapse;
        }

        .header-table td {
            border: none;
            vertical-align: top;
        }

        .logo {
            width: 390px;
            max-height: 85px;
            object-fit: contain;
        }

        .institution-data {
            text-align: right;
            font-size: 8px;
            line-height: 1.45;
        }

        .request-number {
            margin-top: 12px;
            color: #d9364f;
            font-size: 17px;
            font-weight: bold;
            text-align: right;
        }

        .line-field {
            display: inline-block;
            min-width: 210px;
            height: 16px;
            border-bottom: 1px solid #8390a5;
            vertical-align: bottom;
        }

        .line-field.large {
            min-width: 470px;
        }

        .line-field.medium {
            min-width: 290px;
        }

        .letter-data {
            margin-top: 5px;
            margin-bottom: 15px;
            line-height: 1.55;
        }

        .letter-data p {
            margin: 2px 0;
        }

        .recipient {
            font-size: 12px;
            font-weight: bold;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .details-table th,
        .details-table td {
            padding: 4px 3px;
            border: 1px solid #7789a8;
            color: #173873;
            font-size: 8px;
            vertical-align: middle;
        }

        .details-table th {
            background-color: #f4f6fa;
            font-weight: bold;
            text-align: center;
        }

        .category-cell {
            position: relative;
            width: 42px;
            padding: 0 !important;
            overflow: hidden;
            text-align: center;
        }

        .category-text {
            display: inline-block;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            writing-mode: vertical-rl;
            transform: rotate(270deg);
        }

        .text-center {
            text-align: center;
        }

        .observations {
            margin-top: 18px;
        }

        .observations-title {
            margin-bottom: 5px;
            font-weight: bold;
        }

        .observation-line {
            width: 100%;
            min-height: 20px;
            padding-bottom: 3px;
            border-bottom: 1px solid #8390a5;
        }

        .footer-table {
            width: 100%;
            margin-top: 18px;
            border-collapse: collapse;
        }

        .footer-table td {
            border: none;
            vertical-align: top;
        }

        .signature-box {
            width: 53%;
            padding-right: 20px;
        }

        .delivery-box-container {
            width: 47%;
        }

        .signature-line {
            width: 220px;
            margin-top: 55px;
            border-top: 1px solid #8390a5;
        }

        .delivery-box {
            width: 94%;
            padding: 12px;
            border: 1px solid #7789a8;
        }

        .delivery-row {
            margin-bottom: 16px;
        }

        .contact-table {
            width: 100%;
            margin-top: 12px;
            border-collapse: collapse;
        }

        .contact-table td {
            height: 23px;
            padding: 4px;
            border: 1px solid #7789a8;
        }

        .request-type-title {
            margin-bottom: 5px;
            font-weight: bold;
            text-align: center;
        }

        .circle {
            display: inline-block;
            width: 10px;
            height: 10px;
            margin-right: 4px;
            border: 1px solid #173873;
            border-radius: 50%;
            vertical-align: middle;
        }

        .circle.selected {
            position: relative;
            background-color: #173873;
             box-shadow: inset 0 0 0 1px #ffffff;
        }

        .circle.selected::after {
            position: absolute;
            top: 2px;
            left: 2px;
            width: 4px;
            height: 4px;
            content: "";
            background-color: #173873;
            border-radius: 50%;
        }

        .no-print {
            margin-bottom: 15px;
            text-align: right;
        }

        .btn-print {
            padding: 8px 18px;
            color: #ffffff;
            cursor: pointer;
            background-color: #405189;
            border: none;
            border-radius: 4px;
        }

        @media print {
            .no-print {
                display: none;
            }

            body {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</head>

<body>

    {{-- ENCABEZADO --}}
    <table class="header-table">
        <tr>
            <td style="width: 58%;">
                <img
                    src="{{ URL::asset('assets/images/logo_solicitud.png')}}"
                    class="logo"
                    alt="American School"
                >
            </td>

            <td style="width: 42%;">
                <div class="institution-data">
                    Cdla. Venecia Norte, Mz. 21, Villa 2, 4, 7 y 9<br>
                    Tel.: 04 5018665 / 04 5019829<br>
                    secretaria@americanschool.edu.ec<br>
                    www.americanschool.edu.ec
                </div>

                <div class="request-number">
                    {{ str_pad($solicitud->documento, 7, '0', STR_PAD_LEFT) }}
                </div>
            </td>
        </tr>
    </table>

    {{-- DATOS DE LA CARTA --}}
    <div class="letter-data">
        <p>
            Fecha:
            <span class="line-field">
                {{ \Carbon\Carbon::parse($solicitud->fecha)->format('d/m/Y') }}
            </span>
        </p>

        <p>Señores</p>

        <p class="recipient">
            Consejo Ejecutivo
        </p>

        <p>Presente.-</p>

        <p>De mi consideración:</p>

        <br>

        <p>
            Yo, <span class="line-field large"> {{ $solicitud->solicitante ?? '' }} </span> C.I. <span class="line-field"> {{ $solicitud->nui ?? '' }} </span>
        </p>

        <p>
            Me dirijo a ustedes, señores del Consejo Ejecutivo, con la finalidad de solicitar:
        </p>
    </div>

    {{-- TABLA DE SUBCATEGORÍAS --}}
    <table class="details-table">
        <thead>
            <tr>
                <th style="width: 11%;">Categoría</th>
                <th style="width: 28%;">Subcategoría</th>
                <th style="width: 20%;">Periodo lectivo</th>
                <th style="width: 23%;">Curso / Especialidad</th>
                <th style="width: 18%;">Tiempo de entrega</th>
            </tr>
        </thead>

       <tbody>

    @foreach($detallesAgrupados as $categoria => $detalles)

        @foreach($detalles as $detalle)
            <tr>

                @if($loop->first)
                    <td
                        class="category-cell"
                        rowspan="{{ $detalles->count() }}"
                    >
                        <span class="category-text">
                            {{ $categoria }}
                        </span>
                    </td>
                @endif

                <td>
                    {{ $detalle['subcategoria'] }}
                </td>

                <td class="text-center">
                    {{ $detalle['periodo'] }}
                </td>

                <td class="text-center">
                    {{ $detalle['curso'] }}
                </td>

                <td class="text-center">
                    {{ $detalle['tiempo_entrega'] }}
                </td>

            </tr>
        @endforeach

    @endforeach

</tbody>
    </table>

    {{-- OBSERVACIONES --}}
    <div class="observations">
        <div class="student-row">
            <strong>Estudiante:</strong>

            <span class="line-field large">
                {{ trim(
                    ($solicitud->persona?->apellidos ?? '') . ' ' .
                    ($solicitud->persona?->nombres ?? '')
                ) }}
            </span>
        </div>

        <div class="observations-title">
            Observaciones:
        </div>

        <div class="observation-line">
            {{ $solicitud->observacion ?? '' }}
        </div>

        <div class="observation-line"></div>
    </div>

    {{-- FIRMA Y ENTREGA --}}
    <table class="footer-table">
        <tr>
            <td class="signature-box">
                <p>Atentamente,</p>

                <div class="signature-line"></div>

                <p>Firma</p>
            </td>

            <td class="delivery-box-container">
                <div class="delivery-box">
                    <div class="delivery-row">
                        Fecha de entrega:
                        <span class="line-field">
                            
                            {{ \Carbon\Carbon::parse($solicitud->fecha_entrega)->format('d/m/Y') }}
                        </span>
                    </div>

                    <div>
                        Nombre del servidor:
                        <span class="line-field">
                            {{ $servidor[$solicitud->servidor] ?? '' }}
                        </span>
                    </div>
                </div>
            </td>
        </tr>
    </table>

    {{-- CONTACTOS Y FORMA DE SOLICITUD --}}
    <table class="contact-table">
        <tr>
            <td style="width: 66%;">
                Celular: {{ $solicitud->celular ?? '' }}
            </td>

            <td rowspan="3" style="width: 34%;">
                <div class="request-type-title">
                    Solicitado de forma:
                </div>

                <div>
                    <span class="circle {{ $solicitud->forma_solicitud === 'P' ? 'selected' : '' }}"></span>
                    Presencial
                </div>

                <div>
                    <span class="circle {{ $solicitud->forma_solicitud === 'C' ? 'selected' : '' }}"></span>
                    Correo
                </div>

                <div>
                    <span class="circle {{ $solicitud->forma_solicitud === 'T' ? 'selected' : '' }}"></span>
                    Telefónicamente
                </div>
            </td>
        </tr>

        <tr>
            <td>
                Teléfono: {{ $solicitud->telefono ?? '' }}
            </td>
        </tr>

        <tr>
            <td>
                E-mail: {{ $solicitud->email ?? '' }}
            </td>
        </tr>
    </table>

</body>
</html>