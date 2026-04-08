<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado de Promoción</title>

    <style>
        body {
            font-family: "Times New Roman", serif;
            color: #000;
        }

        .contenido {
            font-size: 13px;
            line-height: 1.8;
            text-align: justify;
        }

        .firma {
            font-size: 13px;
            text-align: center;
            margin-top: 40px;
        }

        .linea-firma {
            margin-top: 60px;
        }
    </style>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <section class="header">
            <table cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td style="width: 60%; text-align: left;">
                        <!--<img src="../public/assets/images/Gob_Ecuador.png" height="170px">-->
                        <img src="../public/assets/images/Republica del Ecuador.jpg" height="110px">
                    </td>   
                    <td style="width: 30%; text-align: right;">
                        <img src="../public/assets/images/American Schooll.png" height="50px">
                    </td>
                    <td width="5%">
                    </td>     
                </tr>
            </table>
            <table cellpadding="0" cellspacing="0" width="100%" style ="margin-top: -40px;">
                <tr style="font-size:10px">
                    <td width="100%" class="text-center">
                        <p style="margin-top:0; margin-bottom:0;"><span style="font-size:14px; color:#827F7F"><strong>{{$sede['nombre']}}</strong></p>
                        <p style="margin-top:0; margin-bottom:0;"><span style="font-size:14px; color:#827F7F"><strong>CERTIFICADO DE PROMOCIÓN</strong></p> 
                        <p style="margin-top:0; margin-bottom:0;"><span style="font-size:14px; color:#827F7F"><strong>AÑO LECTIVO {{$data['periodo']}}</strong></p>
                    </td>
                </tr>
            </table>
            <table cellpadding="0" cellspacing="0" class="" style="font-size:12px">
                <tbody>
                    <tr style="font-size:13px">
                        <td width="5%">
                        </td>
                        <td width="90%"><span style="horizontal-align: top; padding-top: 10px">
                            <p style="margin-top:0 line-height: 200%" class="contenido"><br>
                            De conformidad con lo prescrito en el Art. 187 del Reglamento General a la Ley Orgánica 
                            de Educación Intercultural y en concordancia con el articulo 33 del ACUERDO Nro. MINEDUC 2023-00063-A, certifica que el (la) estudiante
                            <strong>{{$data['nombres']}}</strong>, del <strong>{{$data['curso']}} </strong> obtuvo las
                            siguientes calificaciones durante el presente año lectivo:
                        </td>
                        <td width="5%">
                        </td>
                    </tr>
                </tbody>
            </table>
    </section>
    <section>
        <table cellpadding="0" cellspacing="0" width="100%" style="font-size:12px">
        <tbody>                
            <tr style="font-size:13px">  
                <td width="5%">
                </td>
                <td width="90%">               
                    <table width="100%" style="font-size:10px; border: 1px solid black;">
                        <thead>
                            <tr style="border: 1px solid black;">
                                <th width="30%" class="text-center">ÁREA</th>
                                <th width="30%" class="text-center" style="border: 1px solid black;">ASIGNATURAS</th>
                                <th colspan="2" class="text-center">CALIFICACIONES</th>
                            </tr>
                            <tr>
                                <th colspan="2"></th>
                                <th width="10%" class="text-center" style="border: 1px solid black;">NÚMERO</th>
                                <th width="30%" class="text-center">LETRAS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($notas as $key => $record)
                                @if ($record['area']!='')
                                    <tr>
                                        <td style="border: 1px solid black;" class="text-left">{{$record['area']}}</td>
                                        <td style="border: 1px solid black;" class="text-left">{{$record['materia']}}</td>
                                        <td style="border: 1px solid black;" class="text-center">{{$record['nota']}}</td>
                                        <td style="border: 1px solid black;">{{$record['letra']}}</td>
                                    </tr>
                                @else
                                    <tr>
                                        <td colspan="2" style="border: 1px solid black;" class="text-left"><strong>{{$record['materia']}}</strong></td>
                                        <td style="border: 1px solid black;" class="text-center">{{$record['nota']}}</td>
                                        <td style="border: 1px solid black;">{{$record['letra']}}</td>
                                    </tr>
                                @endif
                            @endforeach
                            <tr>
                                <td colspan="2" style="border: 1px solid black;" class="text-left"><strong>EVALUACIÓN DEL COMPORTAMIENTO</strong></td>
                                <td style="border: 1px solid black;" class="text-center"></td>
                                <td style="border: 1px solid black;"></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td width="5%">
                </td>
            </tr>
        </tbody>
        </table>
    </section>
    <section>
        <table cellpadding="0" cellspacing="0" width="100%" style="font-size:12px">
            <tbody>
                <tr style="font-size:13px">
                    <td width="5%">
                    </td>
                    <td width="90%"><span style="horizontal-align: top; padding-top: 10px">
                        <p style="margin-top:0; line-height: 200%" class="text-justify"><br>
                        @if(!($data['graduado'] ?? false))
                            Por lo tanto es promovido/a al <strong>{{$data['curso_promovido']}}.</strong><br>
                        @else
                            Por lo tanto, ha culminado sus estudios.<br>
                        @endif

                        Para certificar suscribe la <strong>{{$data['rector']}}</strong> como <strong>RECTORA</strong> de la institución quien certifica.<br><br>
                        Dado y firmado en:<br><br>
                        Guayaquil, {{date('d',strtotime($data['emision']))}} de 
                        {{$mes[date('m',strtotime($data['emision']))]}} de {{date('Y',strtotime($data['emision']))}}
                        </p>
                    </td>
                    <td width="5%">
                    </td>
                </tr>
            </tbody>
        </table>
    </section>
    <section style="position: absolute;
      display: inline-block;
      bottom: 0;
      width: 100%;
      height: 200px;">
            <table cellpadding="0" cellspacing="0" class="" width="100%">
                <tr style="font-size:12px">
                    <td width="50%" class="text-center">
                        <div class="firma">
                            <div class="linea-firma">______________________________</div>
                            <div>{{$data['rector']}}</div>
                            <div><strong>RECTOR(A)</strong></div>
                        </div>
                    </td>
                </tr>
            </table>
        </section>
    <div style="position: absolute;
      display: inline-block;
      bottom: 0;
      width: 100%;
      height: 60px;">
        <footer>
            <table cellpadding="0" cellspacing="0" width="100%" style="font-size:12px; color:#B0ACAC" >
                <tr>
                    <td style="width: 60%; text-align: left;">
                        <p style="margin-top:0;" class="text-justify"><br>
                            <strong>Dirección:</strong> Av. Amazonas n34-451 y Av. Atahualpa <br>
                            <strong>Codigo postal:</strong> 170507 / Quito Ecuador<br>
                            <strong>Teléfono:</strong> +593-2-396-1300
                        </p>
                    </td>   
                    <td style="width: 30%; text-align: right;">
                        <img src="../public/assets/images/Gob_Ecuador.png" height="50px">
                    </td>
                    <td width="5%">
                    </td>     
                </tr>
            </table>
        </footer>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
