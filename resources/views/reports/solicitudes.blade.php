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
                    <td width="70%" style="vertical-align: top; padding-top: 8px">
                        <img src="../public/assets/images/AmericanSchooll.jpg" height="60px">
                    </td>
                    <td width="30%" class="text-center">
                        <p style="line-height: 200%" class="text-justify" style="font-size:8px; margin-top:0; margin-bottom:0; color:#0A385A;">
                            {{$sede['direccion']}}<br>
                            Telf.:{{$sede['telefono']}}<br>
                            {{$sede['email']}}
                            {{$sede['website']}}
                        </p>
                    </td>
                </tr>
            </table>
            <br>
            <table cellpadding="0" cellspacing="0" class="" width="100%">
                <tr style="font-size:12px; color:#0A385A">
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
                                <td><p style="line-height: 200%" class="text-justify">
                                        Yo, {{$data['nombres']}} C.I. {{$data['identificacion']}}. Me dirijo a ustedes señores del Consejo Ejecutivo con la
                                        finalidad de solicitar:
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td width="5%"></td> 
                </tr>               
            </table>
    </section>
    <section>
        <table cellpadding="0" cellspancing="0" width="100%">
        <tbody>                
            <tr style="font-size:11px; color:#0A385A">  
                <td width="5%">
                </td>
                <td width="90%">               
                    <table width="100%" style="font-size:10px;" border="1">
                        <thead>
                            <tr style="font-size:11px">
                                <th width="5%" class="text-center">Categoria</th>
                                <th width="20%" class="text-center">Subcategoria</th>
                                <th width="20%" class="text-center">Periodo Lectivo</th>
                                <th width="30%" class="text-center">Curso</th>
                                <th width="25%" class="text-center">Tiempo de Entrega</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($solicitud as $key => $recno)
                                @if ($recno['categoria']=='C')
                                <tr style="font-size:11px">
                                    @if ($key==0)
                                    <td rowspan=8>
                                        <p  style="transform: rotate(270deg);">CERTIFICADOS
                                        </p>
                                    </td>
                                    @endif
                                    <td>{{$recno['subcategoria']}}</td>
                                    <td>{{$recno['periodo']}}</td>
                                    <td>{{$recno['curso']}}</td>
                                    <td>{{$recno['tiempo']}}</td>
                                </tr>
                                @endif
                                @if ($recno['categoria']=='E')
                                @if ($key==8)
                                <tr style="font-size:11px">
                                    <td class="text-center"><strong>Categoría</strong></td>
                                    <td class="text-center"><strong>Subcategoría</strong></td>
                                    <td class="text-center"><strong>Periodo Lectivo</strong></td>
                                    <td class="text-center"><strong>Especialidad</strong></td>
                                    <td class="text-center"><strong>Tiempo de Entrega</strong></td>
                                </tr>
                                @endif
                                <tr style="font-size:11px">
                                    @if ($key==8)
                                    <td rowspan=4>
                                        <p style="transform: rotate(270deg);">EXTRAS
                                        </p>
                                    </td>
                                    @endif
                                    <td>{{$recno['subcategoria']}}</td>
                                    <td>{{$recno['periodo']}}</td>
                                    <td>{{$recno['curso']}}</td>
                                    <td>{{$recno['tiempo']}}</td>
                                </tr>
                                @endif
                                @if ($recno['categoria']=='G')
                                @if ($key==12)
                                <tr style="font-size:11px">
                                    <td class="text-center"><strong>Categoría</strong></td>
                                    <td class="text-center"><strong>Subcategoría</strong></td>
                                    <td class="text-center"><strong>Periodo Lectivo</strong></td>
                                    <td class="text-center"><strong>Especialidad</strong></td>
                                    <td class="text-center"><strong>Tiempo de Entrega</strong></td>
                                </tr>
                                @endif
                                <tr style="font-size:11px">
                                    @if ($key==12)
                                    <td rowspan=6>
                                        <p style="transform: rotate(270deg);">GRADUADOS
                                        </p>
                                    </td>
                                    @endif
                                    <td>{{$recno['subcategoria']}}</td>
                                    <td>{{$recno['periodo']}}</td>
                                    <td>{{$recno['curso']}}</td>
                                    <td>{{$recno['tiempo']}}</td>
                                </tr>
                                @endif
                            @endforeach
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
        <table cellpadding="0" cellspacing="0" class="" width="100%">
            <tr style="font-size:12px; color:#0A385A">
                <td width="5%">
                </td>
                <td width="90%">
                    <table width="100%">
                        <tr>
                            <td><p style="line-height: 200%" class="text-justify">
                                    <strong>Observaciones:</strong>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td width="40%"><p style="line-height: 200%" class="text-justify">
                                    <strong>Atentamente,</strong>
                            </td>
                            <td width="60%" style="border: 1px solid;">
                                <p style="line-height: 200%" class="text-justify">
                                    Fecha de Entrega: <br>
                                    Nombre del Servidor: 
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

    <div style="position: absolute;
      display: inline-block;
      bottom: 0;
      width: 100%;
      height: 150px;">
        <section>
        <table cellpadding="0" cellspacing="0" class="" width="100%">
            <tr>
            <td width="5%">
            </td>
            <td width="90%">
            
            <table>
                <tr style="font-size:12px; color:#0A385A">
                    <td width="50%" class="text-center">
                        <span><strong>________________________________</strong></span>
                    </td>
                    <td width="50%" class="text-center">
                       
                    </td>
                </tr>
                <tr style="font-size:12px; color:#0A385A">
                    <td width="50%">
                        <span><strong>Firma</strong></span>
                    </td>
                    <td width="50%" class="text-center">
                        
                    </td>
                </tr>
            </table>
            </td>
            <td width="5%">
            </td>
            </tr>
        </table>
        </section>
    </div>
    <section>
        <br>
        <table cellpadding="0" cellspacing="0" class="" width="100%">
            <tr style="font-size:12px; color:#0A385A">
                <td width="5%">
                </td>
                <td width="90%">
                    <table width="100%">
                        <tr>
                            <td colspan=2>
                            </td>
                            <td width="20%">Solicitado de Forma: 
                            </td>
                        </tr>
                        <tr>
                            <td width="10%" style="border: 1px solid;">Celular:
                            </td>
                            <td width="70%" style="border: 1px solid;">
                            </td>
                            <td width="20%" style="border: 1px solid;">Presencial 
                            </td>
                        </tr>
                        <tr>
                            <td width="10%" style="border: 1px solid;">Teléfono:
                            </td>
                            <td width="70%" style="border: 1px solid;">
                            </td>
                            <td width="20%" style="border: 1px solid;">Correo 
                            </td>
                        </tr>
                        <tr>
                            <td width="10%" style="border: 1px solid;">E-mail:
                            </td>
                            <td width="70%" style="border: 1px solid;">
                            </td>
                            <td width="20%" style="border: 1px solid;">Telefononicamente 
                            </td>
                        </tr>
                    </table>
                </td>
                <td width="5%">
                </td>
            </tr>              
        </table>
    </section>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
