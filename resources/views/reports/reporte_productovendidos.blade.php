<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos mas Vendidos</title>


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script type="text/javascript">

    </script>
</head>
<body>
    <section class="header" style ="top: -287px;">
        <table cellpadding="0" cellspancing="0" width="100%">
            <!--<tr>
                <td colspan="2" class="text-center">
                    <span style="font-size: 18px; font-weight: bold;">Unidad Educativa American Schooll</span>
                </td>
            <tr>-->
            <tr>
                <td width="100%" style="vertical-align: top; padding-top: 10px">
                    <img src="../public/assets/images/banner-ueas.jpg" height="100px">
                    <div class="text-center" style="position: absolute;top: 8%; left: 70%; transform: translate(-12%, -70%); font-size:15px;">
                    <strong>Productos mas Vendidos</strong>
                    </div>
                </td>     
            <tr>
            <tr style="font-size:12px">
                <td width="100%"><br></td> 
            </tr>
            <tr style="font-size:12px">
                <td width="100%">
                   <strong> Fecha : </strong> del {{date('d M Y',strtotime($data->start_date))}} al {{date('d M Y',strtotime($data->end_date))}}
                </td> 
            </tr>
        </table>
        <br>
    </section>

    <section class="header" style ="top: -287px;">
    </section>

    <section style ="margin-top: -110px;">
        <span style="font-size: 12px"><strong>Productos más vendidos, ordenado por unidades vendidas</strong></span>
        <table cellpadding="0" cellspancing="0" width="100%"  class="tabletable table-borderless table-sm align-middle mb-0" style="font-size:10px">
            <tbody class="list">
                <tr>
                    <td width="25%">
                        <table cellpadding="0" cellspacing="0" class="table table-borderless table-sm align-middle mb-0" style="font-size:10px">
                            <thead class="table-light" style="background-color:#222454">
                                <tr>
                                    <th style="color:#FFFFFF">Producto</th>
                                </tr>
                            <thead>
                            <tbody class="list">
                            @foreach ($tblgraph1 as $key => $record)    
                                <tr>
                                    <td>{{$record['nombre']}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </td>
                    <td width="45%">
                        <img src="{{$urlgraph1}}" height="250px" width="310px">
                    </td>
                    <td width="30%">
                        <table cellpadding="0" cellspacing="0" class="table table-borderless table-sm align-middle mb-0" style="font-size:10px">
                            <thead class="table-light" style="background-color:#222454">
                                <tr>
                                    <th style="color:#FFFFFF">Cantidad Vendida</th>
                                    <th class="text-right" style="color:#FFFFFF">Monto Vendido</th>
                                </tr>
                            <thead>
                            <tbody class="list">
                            @foreach ($tblgraph1 as $key => $record)    
                                <tr>
                                    <td class="text-right">{{number_format($record['cantidad'],2)}}</td> 
                                    <td class="text-right">{{number_format($record['valor'],2)}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </section>
    <section>
        <span style="font-size: 12px"><strong>Productos más vendidos, ordenado por monto de venta</strong></span>
        <table cellpadding="0" cellspancing="0" width="100%"  class="tabletable table-borderless table-sm align-middle mb-0" style="font-size:10px">
            <tbody class="list">
                <tr>
                    <td width="25%">
                        <table cellpadding="0" cellspacing="0" class="table table-borderless table-sm align-middle mb-0" style="font-size:10px">
                            <thead class="table-light" style="background-color:#222454">
                                <tr>
                                    <th style="color:#FFFFFF">Producto</th>
                                </tr>
                            <thead>
                            <tbody class="list">
                            @foreach ($tblgraph2 as $key => $record)    
                                <tr>
                                    <td>{{$record['nombre']}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </td>
                    <td width="45%">
                        <img src="{{$urlgraph2}}" height="250px" width="310px">
                    </td>
                    <td width="30%">
                        <table cellpadding="0" cellspacing="0" class="table table-borderless table-sm align-middle mb-0" style="font-size:10px">
                            <thead class="table-light" style="background-color:#222454">
                                <tr>
                                    <th style="color:#FFFFFF">Cantidad Vendida</th>
                                    <th class="text-right" style="color:#FFFFFF">Monto Vendido</th>
                                </tr>
                            <thead>
                            <tbody class="list">
                            @foreach ($tblgraph2 as $key => $record)    
                                <tr>
                                    <td class="text-right">{{number_format($record['cantidad'],2)}}</td> 
                                    <td class="text-right">{{number_format($record['valor'],2)}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </section>
    <section>
        <span style="font-size: 12px"><strong>Productos más vendidos, ordenado por cantidad de venta</strong></span>
        <table cellpadding="0" cellspancing="0" width="100%"  class="tabletable table-borderless table-sm align-middle mb-0" style="font-size:10px">
            <tbody class="list">
                <tr>
                    <td width="25%">
                        <table cellpadding="0" cellspacing="0" class="table table-borderless table-sm align-middle mb-0" style="font-size:10px">
                            <thead class="table-light" style="background-color:#222454">
                                <tr>
                                    <th style="color:#FFFFFF">Producto</th>
                                </tr>
                            <thead>
                            <tbody class="list">
                            @foreach ($tblgraph3 as $key => $record)    
                                <tr>
                                    <td>{{$record['nombre']}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </td>
                    <td width="45%">
                        <img src="{{$urlgraph3}}" height="250px" width="310px">
                    </td>
                    <td width="30%">
                        <table cellpadding="0" cellspacing="0" class="table table-borderless table-sm align-middle mb-0" style="font-size:10px">
                            <thead class="table-light" style="background-color:#222454">
                                <tr>
                                    <th style="color:#FFFFFF">Cantidad Vendida</th>
                                    <th class="text-right" style="color:#FFFFFF">Monto Vendido</th>
                                </tr>
                            <thead>
                            <tbody class="list">
                            @foreach ($tblgraph3 as $key => $record)    
                                <tr>
                                    <td class="text-right">{{number_format($record['cantidad'],2)}}</td> 
                                    <td class="text-right">{{number_format($record['valor'],2)}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>
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
    <script type="text/php">
        if ( isset($pdf) ) {
            $pdf->page_script('
                $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                $pdf->text(510, 797, "$PAGE_NUM de $PAGE_COUNT", $font, 8);
            ');
        }
	</script>

</body>
</html>
