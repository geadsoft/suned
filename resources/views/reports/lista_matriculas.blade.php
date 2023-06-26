<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte Matriculación</title>


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <section class="header" style ="top: -287px;">
        <table cellpadding="0" cellspancing="0" width="100%" style="font-size:13px">
            <tr>
                <td width="100%" style="vertical-align: top; padding-top: 10px">
                    <img src="../public/assets/images/banner-ueas.jpg" height="126px">
                    <div class="text-center" style="position: absolute;top: 12%; left: 70%; transform: translate(-12%, -70%); font-size:15px;">
                    <strong>Reporte de Matriculación</strong>
                    </div>
                </td>        
            </tr>
            <tr>
                <td width="100%" class="text-center">
                   <strong> Grupo : </strong> {{$data['grupo']}}
                </td> 
            </tr>
            <tr>
                <td width="100%" class="text-center">
                   <strong> Periodo Lectivo : </strong> {{$data['periodo']}}
                </td> 
            </tr>
            <tr>
                <td width="100%" class="text-center">
                   <strong> Curso : </strong> {{$data['curso']}}
                </td> 
            </tr>
            <div class="mb-3">
            </div>
        </table>
    </section>

    <section class="header" style ="top: -287px;">
    </section>

    <section style ="margin-top: -110px;">
        <table cellpadding="0" cellspacing="0" class="table table-sm align-middle" style="font-size:10px">
                <thead class="table-light" style="background-color:#222454">
                <tr>
                    <th style="color:#FFFFFF">Nro. Matrícula</th>
                    <th style="color:#FFFFFF">Estudiante</th>
                    <th style="color:#FFFFFF">Identificación</th>
                    <th style="color:#FFFFFF">Nuevo</th>
                    <th style="color:#FFFFFF">Propio</th>
                    <th style="color:#FFFFFF">Masculino</th>
                    <th style="color:#FFFFFF">Femenino</th>
                    <th style="color:#FFFFFF">Fecha de registro</th>
                </tr>
            <thead>
            <tbody class="list"> 
                @foreach ($tblrecords as $key => $grupo)
                    <tr>
                        <td class="text-left text-uppercase" colspan="7"><strong> {{$key}} </strong></td>
                    </tr> 
                     @foreach ($grupo as $key => $curso)
                        <tr>
                            <td class="text-left"></td>
                            <td class="text-left" colspan="7"><strong> {{$key}} </strong></td>
                        </tr> 
                        @foreach ($curso as $key => $persona)  
                            <tr>
                                <td class="text-left"> <strong></strong></td>
                                <td class="text-left" colspan="7"> <strong> Paralelo: {{$key}} </strong></td>
                            </tr>    
                            @foreach ($persona as $key => $recno)               
                            <tr>
                                <td class="text-left">{{$recno['nromatricula']}} </td>
                                <td class="text-left">{{$recno['apellidos']}} {{$recno['nombres']}}</td>
                                <td class="text-left">{{$recno['identificacion']}}</td>
                                @if(date('d-M-Y',strtotime($recno['created_at']))==date('d-M-Y',strtotime($recno['creado'])))
                                    <td class="text-center">X</td>
                                    <td class="text-center"> </td>
                                @else
                                    <td class="text-center"></td>
                                    <td class="text-center">X</td>
                                @endif
                                @if ($recno['genero']=="M")
                                    <td class="text-center"><span>X</span></td>
                                    <td class="text-center"></td>
                                @else
                                    <td class="text-center"></td>
                                    <td class="text-center">X</td>
                                @endif
                                <td class="text-left">{{$dias[$recno['diamatricula']]}},{{date('d-M-Y',strtotime($recno['creado']))}}</td>
                            </tr>
                            @endforeach
                            <!--<tr>
                                <td class="text-left"> <strong> Total: </strong></td>
                            </tr>--> 
                        @endforeach
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </section>
        <table cellpadding="0" cellspacing="0" class="table table-sm align-middle" style="font-size:10px">
            <thead class="table-light">
                <tr>
                    <th>RESUMEN MATRICULA</th>
                </tr>
            </thead>
            <thead class="table-light" style="background-color:#222454">
                <tr>
                    <th style="color:#FFFFFF">Mes</th>
                    <th style="color:#FFFFFF">Estudiantes</th>
                    <th style="color:#FFFFFF">Mujeres</th>
                    <th style="color:#FFFFFF">Hombres</th>
                    <th style="color:#FFFFFF">Nuevos</th>
                    <th style="color:#FFFFFF">Propios</th>
                </tr>
            </thead>
            <tbody class="list"> 
                @foreach ($resmatricula as $key => $recno)
                    <tr>
                        <td class="text-left">{{$meses[$recno['mes']]}}</td>
                        <td class="text-left">{{$recno['estudiantes']}}</td>
                        <td class="text-left">{{$recno['mujeres']}}</td>
                        <td class="text-left">{{$recno['hombres']}}</td>
                        <td class="text-left">{{$recno['nuevos']}}</td>
                        <td class="text-left">{{$recno['propios']}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>            
    <section>

    </section>
    
    <div style="position: absolute;
      display: inline-block;
      bottom: 0;
      width: 100%;
      height: 30px;">
        <footer>
            <table cellpadding="0" cellspacing="0" class="table table-nowrap align-middle" width="100%">
                <tr style="font-size:10px">
                    <td width="40%">
                        <span>SAMS | School and Administrative Management System</span>
                    </td>
                    <td width="30%" class="text-center">
                        Usuario:<span> {{auth()->user()->name}} </span>
                    </td>
                    <td width="30%" class="text-center">
                        Página <span class="pagenum"></span>
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
