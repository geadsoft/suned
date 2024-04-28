<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprobante: {{$invcab['documento']}}</title>


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
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
                    <div class="text-center" style="position: absolute;top: 8%; left: 68%; transform: translate(-12%, -70%); font-size:15px;">
                    <strong>Documento No. {{$invcab['documento']}}</strong>
                    @if ($invcab->estado=='A')
                        <strong>ANULADO</strong>
                    @endif
                    </div>
                </td>        
            </tr>
            <tr>
                <td width="70%" class="text-center" style="vertical-align: top; padding-top: 10px">
                    
                    <table width="100%" cellpadding="0" cellspancing="0">
                        <tr>
                            <td class="text-left text-muted"><span style="font-size: 12px"><strong>Fecha de Emision: {{date('d/m/Y',strtotime($invcab['fecha']))}} </strong></span></td>
                        </tr>
                        <tr>
                            <td class="text-left text-muted"><span style="font-size: 12px"><strong>Transacción: {{$tpmov[$invcab['movimiento']]}} </strong></span></td>
                        </tr>
                        @if($invcab['estudiante_id']>0)
                        <tr>
                            <td class="text-left text-muted"><span style="font-size: 12px"><strong>Estudiante: {{$invcab['referencia']}}</strong></span></td>
                        </tr>
                        @else
                            <td class="text-left text-muted"><span style="font-size: 12px"><strong>Referencia: {{$invcab['referencia']}}</strong></span></td>
                        @endif
                        <tr>
                            <td class="text-left text-muted"><span style="font-size: 12px"><strong>Observación: {{$invcab['observacion']}} </strong></span></td>
                        </tr>
                         <tr>
                            <td class="text-left text-muted"><span style="font-size: 12px"><strong>Pago: {{$fpago[$invcab['tipopago']]}} </strong></span></td>
                        </tr>
                    </table>
                </td>           
            <tr>
        </table>
        <br>
    </section>

    <section class="header" style ="top: -287px;">
    </section>

    <section style ="margin-top: -110px;">
        <table cellpadding="0" cellspacing="0" class="table table-nowrap align-middle" style="font-size:10px">
            <thead class="table-light" style="background-color:#222454">
                <tr>
                    <th style="color:#FFFFFF">Linea</th>
                    <th style="color:#FFFFFF">Producto</th>
                    <th style="color:#FFFFFF">Unidad</th>
                    <th style="color:#FFFFFF; text-align:right">Cantidad</th>
                    <th style="color:#FFFFFF; text-align:right">Precio</th>
                    <th style="color:#FFFFFF; text-align:right">Total</th>
                </tr>
            <thead>
            <tbody class="list">
            @foreach ($invdet as $record)    
                <tr>
                    <td>{{$record->linea}}</td>
                    <td>{{$record->producto->nombre}}</td> 
                    <td>{{$record->unidad}}</td>
                    <td style='text-align:right'>{{number_format($record->cantidad,2)}}</td>
                    <td style='text-align:right'>{{number_format($record->precio,2)}}</td>
                    <td style='text-align:right'>{{number_format($record->total,2)}}</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2"></td>
                    <td class="text-left">
                        <span><b>TOTAL<b></span>
                    </td> 
                    <td colspan="2"></td>
                    <td colspan="1" style='text-align:right'>
                        <span><strong>${{number_format($invdet->sum('total'),2)}}<strong></span>
                    </td> 
                </tr>
            </tfoot>
        </table>
        
    </section>

    <section class="footer">
        <table cellpadding="0" cellspacing="0" class="table table-nowrap align-middle" width="100%">
            <tr style="font-size:10px">
                <td width="50%">
                    <span>SAMS | School and Administrative Management System</span>
                </td>
                <td width="50%" class="text-right">
                    Usuario:<span> {{auth()->user()->name}} </span>
                </td>
            </tr>
        </table>
    </section>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
