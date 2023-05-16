<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ficha Estudiantes</title>


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <section class="header" style ="top: -287px;">
        <table cellpadding="0" cellspancing="0" width="100%">
        </table>
        <br>
    </section>

    <!--<section class="header" style ="top: -287px;">
    </section>-->

    @foreach ($tblrecords as $fil => $record)
        
        <section style ="margin-top: -110px;">
            <table cellpadding="0" cellspancing="0" width="100%" style="font-size:14px">
                <tr>
                    <td width="100%" style="vertical-align: top; padding-top: 10px">
                        <img src="../public/assets/images/banner-ueas.jpg" height="126px">
                    </td>        
                </tr>
                <tr>
                    <td width="100%" class="text-center">
                        <strong>Periodo Lectivo : </strong> {{$data['periodo']}}
                    </td> 
                </tr>
                <div class="mb-3">
                </div>
            </table>
            <table cellpadding="0" cellspacing="0" class="table table-borderless" style="font-size:12px">
                <tbody>                      
                    <tr>
                        <td width="60%" class="text-left">
                            <table width="100%" cellpadding="0" cellspancing="0" class="table-borderless">
                                <tr>
                                    <td class="text-left"><strong> Curso: </strong></td>
                                    <td class="text-left"> {{$record->curso}} - {{$record->paralelo}} </td>
                                </tr>
                                <tr>
                                    <td class="text-left"><strong> Apellidos: </strong></td>
                                    <td class="text-left"> {{$record->apellidos}} </td>
                                </tr>
                                <tr>
                                    <td class="text-left"><strong> Nombres: </strong></td>
                                    <td class="text-left"> {{$record->nombres}} </td>
                                </tr>
                                <tr>
                                    <td class="text-left"><strong> Cédula de Identidad:</strong></td>
                                    <td class="text-left"> {{$record->identificacion}} </td>
                                </tr>
                                <tr>
                                    <td class="text-left"><strong> Fecha Matricula: </strong></td>
                                    <td class="text-left">  {{date('d/m/Y',strtotime($record['fechamatricula']))}} </td>
                                </tr>
                                <tr>
                                    <td class="text-left"><strong> Fecha Nacimiento: </strong></td>
                                    <td class="text-left"> {{date('d/m/Y',strtotime($record['fechanacimiento']))}} </td>
                                </tr>
                                <tr>
                                    <td class="text-left"><strong> Nacionalidad: </strong></td>
                                    <td class="text-left"> {{$record->nacionalidad}} </td>
                                </tr>
                            </table>
                        </td>
                        <td width="40%" class="text-center">
                            <img src="../public/assets/images/foto-ueas.jpg">
                        </td>
                    </tr>
                </tbody>
            </table>
            <table cellpadding="0" cellspacing="0" class="table table-borderless" style="font-size:12px">
                <tbody> 
                    <tr>
                        <h6>Datos del Representante</h6>
                    </tr>                     
                    <tr>
                        <td width="60%" class="text-left">
                            <table width="100%" cellpadding="0" cellspancing="0" class="table-sm">
                                <tr>
                                    <td class="text-left"><strong> Apellidos: </strong></td>
                                    <td class="text-left"> {{$record->aperepre}} </td>
                                </tr>
                                <tr>
                                    <td class="text-left"><strong> Nombres: </strong></td>
                                    <td class="text-left"> {{$record->nomrepre}} </td>
                                </tr>
                                <tr>
                                    <td class="text-left"><strong> Cédula de Identidad:</strong></td>
                                    <td class="text-left"> {{$record->idenrepre}} </td>
                                </tr>
                                <tr>
                                    <td class="text-left"><strong> Parentesco: </strong></td>
                                    <td class="text-left"> {{$record->parenrepre}} </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>

            <table cellpadding="0" cellspacing="0" class="table table-borderless" style="font-size:10px">
                <tr>
                    <h6>Datos Familiares</h6>
                </tr>
                <tr class="text-uppercase">
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Identificación</th>
                    <th>Relación</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                </tr>
                <tbody> 
                    

                </tbody>
            </table>



        </section>
        <section>
            <table cellpadding="0" cellspacing="0" class="table-sm" width="100%">
            </table>
        </section>
        <div style="page-break-before: always;">
        </div>
    @endforeach

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
