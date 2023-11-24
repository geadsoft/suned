<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado de Promoción</title>


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <section class="header" style ="top: -287px;">
        <table cellpadding="0" cellspancing="0" width="100%">
        </table>
        <br>
    </section>

    <section style ="margin-top: -110px;">
            <table cellpadding="0" cellspancing="0" width="100%" style="font-size:14px">
                <tr>
                    <td style="vertical-align: top; padding-top: 8px">
                        <img src="../public/assets/images/Gob_Ecuador.png" height="100px">
                    </td>        
                </tr>
            </table>
            <table cellpadding="0" cellspacing="0" class="" width="100%">
                <tr style="font-size:10px">
                    <td width="60%" class="text-center">
                        <p style="margin-top:0; margin-bottom:0;"><span style="font-size:14px"><strong>{{$sede['nombre']}}</strong></p> 
                        <p style="margin-top:0; margin-bottom:0;"><span style="font-size:14px"><strong>CERTIFICADO DE PROMOCIÓN</strong></p> 
                        <p style="margin-top:0; margin-bottom:0;"><span style="font-size:14px"><strong>AÑO LECTIVO {{$data['periodo']}}</strong></p>
                    </td>
                </tr>
            </table>
            <table cellpadding="0" cellspacing="0" class="" style="font-size:12px">
                <tbody>
                    <tr style="font-size:13px">
                        <td width="10%">
                        </td>
                        <td width="90%"><span style="horizontal-align: top; padding-top: 10px">
                            <p style style="line-height: 200%" class="text-justify"><br>
                            De conformidad con lo prescrito en el Art. 197 del Reglamento General a la Ley Orgánica 
                            de Educación Intercultural y demás normativas vigentes, certifica que el/la estudiante
                            <strong>{{$data['nombres']}}</strong>, del <strong>{{$data['curso']}}: </strong> obtuvo las
                            siguientes calificaciones en el presente año lectivo:
                        </td>
                        <td width="5%">
                        </td>
                    </tr>
                </tbody>
            </table>
    </section>
    <section>
        <table cellpadding="0" cellspancing="0" width="100%" style="font-size:12px">
        <tbody>                
            <tr style="font-size:13px">  
                <td width="10%">
                </td>
                <td width="86%">               
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
                                <td style="border: 1px solid black;" class="text-center">{{$record['area']}}</td>
                                <td style="border: 1px solid black;" class="text-center">{{$record['materia']}}</td>
                                <td style="border: 1px solid black;" class="text-center">{{$record['nota']}}</td>
                                <td style="border: 1px solid black;">{{$record['letra']}}</td>
                            </tr>
                            @else
                            <tr>
                                <td colspan="2" style="border: 1px solid black;" class="text-center"><strong>PROMEDIO GENERAL</strong></td>
                                <td style="border: 1px solid black;" class="text-center">{{$record['nota']}}</td>
                                <td style="border: 1px solid black;">{{$record['letra']}}</td>
                            </tr>
                            @endif
                            @endforeach
                            <tr>
                                <td colspan="2" style="border: 1px solid black;" class="text-center"><strong>EVALUACIÓN DEL COMPORTAMIENTO</strong></td>
                                <td style="border: 1px solid black;" class="text-center"></td>
                                <td style="border: 1px solid black;"></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td width="4%">
                </td>
            </tr>
                            </tbody>
        </table>
    </section>
    <section>
            <table cellpadding="0" cellspacing="0" width="100%" style="font-size:12px">
                <tbody>
                    <tr style="font-size:13px">
                        <td width="10%">
                        </td>
                        <td width="90%"><span style="horizontal-align: top; padding-top: 10px">
                            <p style="line-height: 200%" class="text-justify"><br>
                            Por lo tanto es promovido/a al <strong>{{$data['curso_promovido']}}.</strong><br>
                            Para constancia suscriben en unidad de acto <strong>{{$data['rector']}}</strong><br>
                            Dado y firmado en:<br>
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
    <div style="position: absolute;
      display: inline-block;
      bottom: 0;
      width: 100%;
      height: 100px;">
        <section>

            <table cellpadding="0" cellspacing="0" class="" width="100%">
                <tr style="font-size:12px">
                    <td width="50%" class="text-center">
                        <span><strong>________________________________</strong></span>
                    </td>
                    <td width="50%" class="text-center">
                        <span><strong>________________________________</strong></span>
                    </td>
                </tr>
                <tr style="font-size:13px">
                    <td width="50%" class="text-center">
                        <span>{{$data['rector']}}</span>
                    </td>
                    <td width="50%" class="text-center">
                        <span>{{$data['secretaria']}}</span>
                    </td>
                </tr>
                <tr style="font-size:13px">
                    <td width="50%" class="text-center">
                        <span><strong>RECTOR</strong></span>
                    </td>
                    <td width="50%" class="text-center">
                        <span><strong>SECRETARIA</strong></span>
                    </td>
                </tr>
            </table>
        </section>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
