<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado Matricula</title>


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
                    <td width="100%" style="vertical-align: top; padding-top: 8px">
                        <img src="../public/assets/images/banner-ueas.jpg" height="100px">
                    </td>        
                </tr>
                <div class="mb-3">
                </div>
            </table>
            <table cellpadding="0" cellspacing="0" class="" width="100%">
                <tr style="font-size:13px">
                    <td width="60%" class="text-right">
                        <p><br><span style="font-size:15px"></span>Guayaquil, {{date('d',strtotime($data['fecha']))}} de 
                        {{$mes[date('m',strtotime($data['fecha']))]}} del {{date('Y',strtotime($data['fecha']))}}
                        </p> 
                    </td>
                </tr>
                <tr style="font-size:12px">
                    <td width="60%" class="text-center">
                        <p><br><br><br><span style="font-size:18px"><strong>CERTIFICADO DE MATRÍCULA</strong></p> 
                    </td>
                </tr>
            </table>
            <table cellpadding="0" cellspacing="0" class="" style="font-size:12px">
                <tbody>
                    <tr style="font-size:13px">
                        <td width="5%">
                        </td>
                        <td width="90%"><span style="horizontal-align: top; padding-top: 10px"><p style style="line-height: 200%" class="text-justify"><br><br>
                        El Rectorado y la Secretaría de la Unidad Educativa American School certifica que el (la) alumno 
                        <strong>{{$data['nombres']}}</strong> con C.I. <strong>{{$data['identificacion']}}</strong> del <strong>{{$data['curso']}}</strong>
                        , estuvo matriculado (a) en el periodo <strong>{{$data['periodo']}}</strong>,con código AMIE 09H02249 en la Secretaría de Educación.<br><br>
                        CORREO: info@americanschool.edu.ec - PAGINA WEB: www.americanschool.edu.ec<br><br>
                        Así consta en los registros del plantel a los cuales me remito.
                        <br><br><br><br><br><br><br><br><br><br>
                        Atentamente,
                        </p>
                        </span></td>
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
      height: 150px;">
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
