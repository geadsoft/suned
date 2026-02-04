<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado Valores</title>


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
                        <img src="../public/assets/images/AmericanSchooll.jpg" height="80px">
                    </td>        
                </tr>
            </table>
            <table cellpadding="0" cellspacing="0" class="" width="100%">
                <tr style="font-size:13px">
                    <td width="5%">
                    </td>
                    <td width="90%" class="text-right">
                        <p><br><span style="font-size:13px; text-transform: uppercase;">GUAYAQUIL, {{date('d',strtotime($fecha))}} DE 
                        {{$mes[date('m',strtotime($fecha))]}} DEL {{date('Y',strtotime($fecha))}}</span>
                        </p> 
                    </td>
                    <td width="5%">
                    </td>
                </tr>
            </table>
            <table cellpadding="0" cellspacing="0" class="" style="font-size:12px">
                <tbody>
                    <tr style="font-size:13px">
                        <td width="5%">
                        </td>
                        <td width="90%">
                            <p>A QUIEN PUEDA INTERESAR<br><br></p>
                        </td>
                        <td width="5%">
                        </td>
                    </tr>
                    <tr style="font-size:13px">
                        <td width="5%">
                        </td>
                        <td width="90%" class="text-center">
                            <p><strong>COLECTURÍA</strong><br><br></p>
                        </td>
                        <td width="5%">
                        </td>
                    </tr>
                    <tr style="font-size:13px">
                        <td width="5%">
                        </td>
                        <td width="90%"><span style="horizontal-align: top; padding-top: 10px">
                            <p style="text-indent: 2em; text-align: justify; line-height: 200%;">
                            LA PRESENTE ES PARA INFORMAR QUE EL ALUMNO(A) <strong>{{$data->estudiante->nombres}} {{$data->estudiante->apellidos}}</strong>, 
                            MATRICULADO EN NUESTRA NUESTRA INSTITUCIÓN <strong>"UNIDAD EDUCATIVA AMERICAN SCHOOL"</strong> PARA EL PERIODO LECTIVO
                            {{$data->periodo->descripcion}} EN EL CURSO <span style="text-transform: uppercase;">{{$data->curso->servicio->descripcion}}</span>,
                            SE ENCUENTRA AL DÍA EN VALORES DE PENSIONES, SIN POSEER DEUDA ALGUNA DENTRO DE LA MISMA.
                            <br><br></p>
                        </td>
                        <td width="5%">
                        </td>
                    </tr>
                    <tr style="font-size:13px">
                        <td width="5%">
                        </td>
                        <td width="90%" class="text-center">
                            <p>SIN MAS A QUE HACER REFERENCIA NOS DEPEDIMOS CORDIALMENTE</p>
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
      height: 400px;">
        <section>
            <table cellpadding="0" cellspacing="0" class="" width="100%">
                <tr style="font-size:12px">
                    <td width="15%" class="text-center"></td>
                    <td width="70%" class="text-center">
                        <span><strong>________________________________</strong></span>
                    </td>
                    <td width="15%" class="text-center"></td>
                </tr>
                <tr style="font-size:13px">
                    <td width="15%" class="text-center"></td>
                    <td width="70%" class="text-center">
                        <span><strong>ATENTAMENTE</strong></span>
                    </td>
                    <td width="15%" class="text-center"></td>
                </tr>
                <tr style="font-size:13px">
                    <td width="15%" class="text-center"></td>
                    <td width="70%" class="text-center">
                        <span><strong>COLECTURÍA</strong></span>
                    </td>
                    <td width="15%" class="text-center"></td>
                </tr>
                <tr style="font-size:13px">
                    <td width="15%" class="text-center"></td>
                    <td width="70%" class="text-center">
                        <span><strong>ALLISON BENITEZ</strong></span>
                    </td>
                    <td width="15%" class="text-center"></td>
                </tr>
                <tr style="font-size:13px">
                    <td width="15%" class="text-center"></td>
                    <td width="70%" class="text-center">
                        <span><strong>TELF.: 5018555 EXT. 104</strong></span>
                    </td>
                    <td width="15%" class="text-center"></td>
                </tr>
            </table>
        </section>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
