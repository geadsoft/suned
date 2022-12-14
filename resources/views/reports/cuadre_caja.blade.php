<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuadre de Caja</title>


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <section class="header" style ="top: -287px;">
        <table cellpadding="0" cellspancing="0" width="100%">
            <tr>
                <td colspan="2" class="text-center">
                    <span style="font-size: 18px; font-weight: bold;">Unidad Educativa American Schooll</span>
                </td>
            <tr>
            <tr>
                <td width="30%" style="vertical-align: top; padding-top: 10px; position: relative">
                    <!--<img src="{{ URL::asset('assets/images/companies/American Schooll.png') }}" alt="" class="invoice-logo">-->
                </td>
                <td width="70%" class="text-left" style="vertical-align: top; padding-top: 10px">
                    <span style="font-size: 16px"><strong>Cuadre de Caja</strong></span>
                    <tr>
                        <span class="text-muted" style="font-size: 12px"><strong>Fecha: {{$filter['srv_fecha']}}</strong></span>
                    </tr>
                    <tr>
                        <span class="text-muted" style="font-size: 12px"><strong>Grupo: {{$filter['srv_grupo']}}</strong></span>
                    <tr>
                    <tr>
                        <span class="text-muted" style="font-size: 12px"><strong>Periodo: {{$filter['srv_periodo']}}</strong></span>
                    </tr>
                </td>           
            <tr>
        </table>

    </section>

    <section class="header" style ="top: -287px;">
    </section>

    <section style ="margin-top: -110px;">
        <table cellpadding="0" cellspacing="0" class="table table-nowrap align-middle" style="font-size:10px">
            <thead class="text-muted table-light">
                <tr>
                    <th>Recibo</th>
                    <th>Alumno</th>
                    <th>Curso</th>
                    <th>Concepto</th>
                    <th>F.P.</th>
                    <th>Valor</th>
                    <th>Desc.</th>
                    <th>Canc.</th>
                    <th>Usuario</th>
                </tr>
            <thead>
            <tbody class="list">
            @foreach ($tblrecords as $record)    
                <tr>
                    <td class="">{{$record->documento}}</td>
                    <td>{{$record->apellidos}} {{$record->nombres}}</td> 
                    <td>{{$record->descripcion}} {{$record->paralelo}}</td> 
                    <td>{{$record->detalle}}</td>
                    <td>{{$record->tipopago}}</td>
                    <td>{{number_format($record->saldo + $record->credito,2)}}</td>
                    <td>{{number_format($record->descuento,2)}}</td>
                    <td>{{number_format($record->pago,2)}}</td>
                    <td>{{$record->usuario}}</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td class="text-center">
                        <span><b>TOTALES<b></span>
                    </td> 
                    <td colspan="6"></td>
                    <td colspan="1">
                        <span><strong>${{number_format($tblrecords->sum('pago'),2)}}<strong></span>
                    </td> 
                </tr>
            </tfoot>
        </table>
    </section>

    <section>
        <table cellpadding="0" cellspancing="0" width="100%">
            <tr>
                <td width="40%" style="vertical-align: top; padding-top: 10px; position: relative">
                    <table cellpadding="0" cellspacing="0" class="table table-sm align-middle" style="font-size:10px">
                        <thead class="table-light">
                            <tr>
                                <th colspan="2">Formas de Pagos</th>
                            </tr>
                        <thead>
                        <tbody class="list"> 
                            <tr>
                                <td class="">'Efectivo'</td>
                                <td>{{number_format($record->pago,2)}}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td width="30%" class="text-left" style="vertical-align: top; padding-top: 10px">
                </td> 

                <td width="30%" class="text-left" style="vertical-align: top; padding-top: 10px">
                    <table cellpadding="0" cellspacing="0" class="table table-sm align-middle" style="font-size:10px">
                        <thead class="table-light">
                            <tr>
                                <th colspan="2">Totales</th>
                            </tr>
                        <thead>
                        @foreach ($tblTotal as $data) 
                        <tbody class="list"> 
                            <tr>
                                <td class="">{{$data['detalle']}}</td>
                                <td>{{number_format($data['valor'],2)}}</td>
                            </tr>
                        </tbody>
                        @endforeach
                    </table>
                </td>           
            </tr>
            <tr>
                

            </tr>
        </table>
    </section>


    <section class="footer">
        <table cellpadding="0" cellspacing="0" class="table table-nowrap align-middle" width="100%">
            <tr style="font-size:10px">
                <td width="40%">
                    <span>SAMS | School and Administrative Management System</span>
                </td>
                <td width="40%" class="text-center">
                    usuario:<span> </span>
                </td>
                <td width="20%" class="text-center">
                    p??gina <span class="pagenum"></span>
                </td>
            </tr>
        </table>
    </section>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
