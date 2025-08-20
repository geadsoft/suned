<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acta de Calificaciones Exámenes</title>


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <section class="header" style ="top: -287px;">
        <table cellpadding="0" cellspancing="0" width="100%">
            <tr>
                <td width="100%" style="vertical-align: top; padding-top: 10px">
                    <img src="../public/assets/images/banner-ueas.jpg" height="100px" width="100%">
                </td>        
            </tr>
        </table>
        <br>
    </section>

    <section class="header" style ="top: -287px;">
        <table cellpadding="0" cellspancing="0" width="100%">
            <tr style="font-size:12px">
                <td width="100%">
                   <div class="col-4"><img class="img-fluid" style="position: absolute;top: 30%; left: 2%; width: 15%;height:60pt;" src="{{ URL::asset('assets/images/LogoReport.png')}}" alt=""></div>
                   <p class="text-center" style="margin: 0px;">UNIDAD EDUCATIVA AMERICAN SCHOOL - {{$datos['nivel']}}</p>
                   <p class="text-center" style="margin: 0px;">ACTA DE CALIFICACIONES</p>
                   <p class="text-center" style="margin: 0px;">{{$datos['subtitulo']}}</p>
                   <p class="text-center" style="margin: 0px;">{{$datos['docente']}} / {{$datos['materia']}}</p>
                   <p class="text-center" style="margin: 0px;">{{$datos['curso']}}</p>
                </td> 
            </tr>
        </table>
        <br>
    </section>

    <section class="header" style ="top: -287px;">
    </section>

    <section style ="margin-top: -110px;">
        
        <table cellpadding="0" cellspacing="0" class="table table-bordered table-sm align-middle mb-0" style="font-size:10px">
            <thead class="table-light">
                <tr class="text-uppercase text-muted">
                    <th class="align-middle text-center">NOMBRES</th>
                    @foreach ($tblgrupo as $key => $grupo)
                         @if ($key=='AI')
                        <th class="text-center" style="width: 80px; margin: 0px;" colspan="{{count($grupo)+1}}">ACTIVIDAD INDIVIDUAL</th>
                        @else
                        <th class="text-center" style="width: 80px; margin: 0px;" colspan="{{count($grupo)+1}}">ACTIVIDAD GRUPAL</th>
                        @endif
                    @endforeach
                    <th class="text-center">
                    <span class="text-center" style="width: 50px; margin: 0px;">Promedio</span>
                    </th>
                    <th class="text-center">
                    <span class="text-center" style="width: 50px; margin: 0px;">Cualitativa</span>
                    </th>
                </tr>
                <tr class="text-uppercase text-muted">
                    <th class="align-middle text-center" style="width: 200px;"></th>
                    @foreach ($tblgrupo as $key => $grupo)
                        @foreach ($grupo as $data)
                            <th class="align-middle text-center tr-text" style="margin: 0px; width: 70px;">
                            <span>{{$data->nombre}}</span>
                            </th>
                        @endforeach
                        <th class="align-middle text-center tr-text" style="margin: 0px; width: 70px;">
                        <span><strong>Promedio {{$key}}</strong></span>
                        </th>
                    @endforeach
                    <th colspan="2"></th>
                </tr>
            </thead>
            <tbody>
            @foreach ($tblrecords as $fil => $record)
                <tr id="{{$fil}}" class="detalle">
                    @if ($fil=='ZZ')
                    <td class="text-end">{{$record["nombres"]}}</td>
                    @else
                    <td>{{$record["nombres"]}}</td>
                    @endif
                    @foreach ($tblgrupo as $key1 => $grupo)
                        @foreach ($grupo as $key2 => $data)
                        <td class="text-center">
                        <span>{{number_format($tblrecords[$fil][$key1.$key2],2)}}</span>
                        </td>
                        @endforeach 
                        <td class="text-center"><strong>{{number_format($tblrecords[$fil][$key1."-prom"],2)}}<strong></td>
                    @endforeach 
                    <td class="text-center"><strong>{{number_format($record["promedio"],2)}}</strong></td>   
                    <td class="text-center">{{$record["cualitativa"]}}</td>                              
                </tr>
            @endforeach
            </tbody>
        </table>
        
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
                    <td width="40%" class="text-left">
                        Usuario:<span> {{auth()->user()->name}} </span>
                    </td>
                </tr>
            </table>
        </footer>
    </div>

    <!--<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>-->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script type="text/php">
        if ( isset($pdf) ) {
            $pdf->page_script('
                $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                $pdf->text(510, 797, "Pág $PAGE_NUM de $PAGE_COUNT", $font, 8);
            ');
        }
	</script>

</body>
</html>
