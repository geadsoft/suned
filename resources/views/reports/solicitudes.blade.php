<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud</title>


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
            <table cellpadding="0" cellspancing="0" width="100%" style="font-size:13px">
                <tr>
                    <td width="100%" style="vertical-align: top; padding-top: 8px">
                        <img src="../public/assets/images/AmericanSchooll.jpg" height="80px">
                    </td>        
                </tr>
                <div class="mb-3">
                </div>
                <td width="70%" class="text-center" style="vertical-align: top; padding-top: 10px">
                    <span style="font-size: 12px" class="text-primary"><strong>Cdla Vernza</strong></span>
                    <div class="mb-3">
                    </div>
                </td>
            </table>
            <table cellpadding="0" cellspacing="0" class="" width="100%">
                <tr style="font-size:12px">
                    <td width="5%">
                    </td>
                    <td width="90%">
                        <table>
                            <tr>
                                <td>Fecha:</td>
                            </tr>
                            <tr>
                                <td>Señores:</td>
                            </tr>
                            <tr>
                                <td><strong>Consejo Ejecutivo</strong></td>
                            </tr>
                            <tr>
                                <td>Presente.-</td>
                            </tr>
                            <tr>
                                <td>De mi consideración:</td>
                            </tr>
                            <tr>
                                <td><p style="line-height: 200%" class="text-justify"><br><br>
                                        Yo, {{$data['nombres']}} C.I. {{$data['identificacion']}}. Me dirijo a ustedes señores del Consejo Ejecutivo con la
                                        finalidad de solicitar:
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td width="5%">
                    </td> 
                </tr>               
            </table>
    </section>
    <section>
        <table cellpadding="0" cellspancing="0" width="100%">
        <tbody>                
            <tr style="font-size:13px">  
                <td width="5%">
                </td>
                <td width="90%">               
                    <table width="100%" style="font-size:10px;" border="1">
                        <thead>
                            <tr style="font-size:13px">
                                <th width="5%" class="text-center">Categoria</th>
                                <th width="20%" class="text-center">Subcategoria</th>
                                <th width="20%" class="text-center">Periodo Lectivo</th>
                                <th width="30%" class="text-center">Curso</th>
                                <th width="25%" class="text-center">Tiempo de Entrega</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr style="font-size:13px">
                                <td rowspan=8>
                                    <p  style="transform: rotate(270deg);">CERTIFICADOS
                                    </p>
                                </td>
                                <td>Matricula</td>
                                <td></td>
                                <td></td>
                                <td>2 dias laborales</td>
                            </tr>
                            <tr style="font-size:13px">
                                <td>Conducta</td>
                                <td></td>
                                <td></td>
                                <td>2 dias laborales</td>
                            </tr>
                            <tr style="font-size:13px">
                                <td>Asistencia</td>
                                <td></td>
                                <td></td>
                                <td>2 dias laborales</td>
                            </tr>
                            <tr style="font-size:13px">
                                <td>Aprovechamiento</td>
                                <td></td>
                                <td></td>
                                <td>2 dias laborales</td>
                            </tr>
                            <tr style="font-size:13px">
                                <td>Libreta Escolar</td>
                                <td></td>
                                <td></td>
                                <td>2 dias laborales</td>
                            </tr>
                            <tr style="font-size:13px">
                                <td>Promoción</td>
                                <td></td>
                                <td></td>
                                <td>2 dias laborales</td>
                            </tr>
                            <tr style="font-size:13px">
                                <td>Pase Reglamentario</td>
                                <td></td>
                                <td></td>
                                <td>2 dias laborales</td>
                            </tr>
                            <tr style="font-size:13px">
                                <td>Retiro de Expediente</td>
                                <td></td>
                                <td></td>
                                <td>2 dias laborales</td>
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
