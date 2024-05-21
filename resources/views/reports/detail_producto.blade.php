<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Productos</title>


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <section class="header" style ="top: -287px;">
        <table cellpadding="0" cellspancing="0" width="100%">
            <tr>
                <td width="100%" style="vertical-align: top; padding-top: 10px">
                    <img src="../public/assets/images/banner-ueas.jpg" height="100px">
                    <div class="text-center" style="position: absolute;top: 8%; left: 70%; transform: translate(-12%, -70%); font-size:15px;">
                    <strong>Detalle de Productos</strong>
                    </div>
                </td>        
            </tr>
            <br>         
            <tr>
                <td class="text-left text-muted"><span style="font-size: 12px"><strong>Fecha: {{date('d/m/Y',strtotime($info['fechaini']))}} - {{date('d/m/Y',strtotime($info['fechafin']))}}</strong></span></td>
            </tr>
            <tr>
                <td class="text-left text-muted"><span style="font-size: 12px"><strong>{{$filtros}}</strong></span></td>
            </tr>
            
                    
        </table>
        <br>
    </section>

    <section class="header" style ="top: -287px;">
    </section>

    <section style ="margin-top: -110px;">
        <table cellpadding="0" cellspacing="0" class="table table-borderless table-sm align-middle mb-0" style="font-size:10px">
            <thead class="table-light" style="background-color:#222454">
                <tr>
                    <th style="color:#FFFFFF">Fecha</th>
                    <th style="color:#FFFFFF">Mov.</th>
                    <th style="color:#FFFFFF">Referencia</th>
                    <th style="color:#FFFFFF">Producto</th>
                    <th style="color:#FFFFFF">Talla</th>
                    <th style="color:#FFFFFF">Precio</th>
                    <th style="color:#FFFFFF">Cantidad</th>
                    <th style="color:#FFFFFF">F. Pago</th>
                    <th style="color:#FFFFFF">Monto</th>
                    <th style="color:#FFFFFF">Usuario</th>
                </tr>
            <thead>
            <tbody class="list">
            @foreach ($invtra as $record)    
                <tr>
                    <td>{{date('d/m/Y',strtotime($record['fecha']))}}</td>
                    <td>{{$record->movimiento}}</td>
                    <td>{{$record->referencia}}</td> 
                    <td>{{$record->nombre}}</td> 
                    <td>{{$record->talla}}</td>
                    <td>{{number_format($record->precio,2)}}</td>
                    <td>{{number_format($record->cantidad,2)}}</td>
                    <td>{{$record->tipopago}}</td>
                    <td>{{number_format($record->total,2)}}</td>
                    <td>{{$record->usuario}}</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td class="text-center">
                        <span><b>TOTALES<b></span>
                    </td> 
                    <td colspan="5"></td>
                    <td>
                        <span><strong>{{number_format($invtra->where('estado','P')->sum('cantidad'),2)}}<strong></span>
                    <td>
                    <td colspan="1">
                        <span><strong>${{number_format($invtra->where('estado','P')->sum('total'),2)}}<strong></span>
                    </td> 
                </tr>
            </tfoot>
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

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
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
