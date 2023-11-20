<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calificaciones</title>


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
            <div class="text-center">
                <h5 class="card-title mb-0 flex-grow-1"><strong>Cuadro de Calificaciones de Estudiantes</strong></h5>
                <p style="margin-top:0; margin-bottom:0;"><span style="font-size:11px"><strong>DIRECCION:</strong>{{$data['direccion']}}</p> 
                <p style="margin-top:0; margin-bottom:0;"><span style="font-size:11px"><strong>TELÉFONO:</strong>{{$data['telefono']}}</p>
                <p style="margin-top:0; margin-bottom:0;"><span style="font-size:10px"><strong>Guayaquil-Ecuador</strong></p>
                <p style="margin-top:0; margin-bottom:0;"><span style="font-size:10px">{{$data['email']}}</p>
                <p style="margin-top:0; margin-bottom:0;"><span style="font-size:10px"><strong>{{$data['periodo']}}</strong></p>
                <p style="margin-top:0; margin-bottom:0;"><span style="font-size:10px"><strong>JORNADA MATUTINA</strong></p>
                <p><span style="font-size:10px"><strong>CÓDIGO AMIE: {{$data['codigo']}}</strong></p>
            </div>
            <table cellpadding="0" cellspancing="0" width="100%" style="font-size:10px">
                <thead class="text-muted table-light">
                    <tr class="text-uppercase text-center">
                        <th>N°</th>
                        <th>Nómina</th>
                        <th>Comportamiento</th>
                        @foreach ($materias as $data)
                        <th colspan="5">{{$data['descripcion']}}</th>
                        @endforeach
                        
                    </tr>
                    <tr style="height:100px;">
                        <th colspan="3"></th>
                        @foreach ($materias as $data)
                        <th>I</th>
                        <th>II</th>
                        <th>III</th>
                        <th>PRO</th>
                        <th>PRF</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tblrecords as $key => $record)
                    <tr style="font-size:10px">
                        <td>{{$key+1}}</td>
                        <td>{{$record['nombres']}}</td>
                        <td>{{$record['comportamiento']}}</td>
                        @foreach ($materias as $data)
                        <script>
                            {{$n1 = 'P1_'.$data['asignatura_id'] }}
                            {{$n2 = 'P2_'.$data['asignatura_id'] }}
                            {{$n3 = 'P3_'.$data['asignatura_id'] }}
                            {{$pr = 'PR_'.$data['asignatura_id'] }}
                            {{$nf = 'PF_'.$data['asignatura_id'] }}
                        </script>
                            <td>{{$record[$n1]}}</td>
                            <td>{{$record[$n2]}}</td>
                            <td>{{$record[$n3]}}</td>
                            <td>{{$record[$pr]}}</td>
                            <td>{{$record[$nf]}}</td>
                        @endforeach
                    </tr>
                    @endforeach
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
