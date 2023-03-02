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
            <!--<tr>
                <td colspan="2" class="text-center">
                    <span style="font-size: 18px; font-weight: bold;">Unidad Educativa American Schooll</span>
                </td>
            <tr>-->
            <tr>
                <td width="30%" style="vertical-align: top; padding-top: 10px; position: relative">
                    <img src="../public/assets/images/AmericanSchooll.jpg" width="200px" height="60px">                  
                </td>
                <td width="70%" class="text-center" style="vertical-align: top; padding-top: 10px">
                    <span style="font-size: 16px"><strong>Cuadre de Caja</strong></span>
                    <table width="100%" cellpadding="0" cellspancing="0">
                        <tr>
                            <td class="text-left text-muted"><span style="font-size: 12px"><strong>Fecha: {{$filter['fecha']}}</strong></span></td>
                        </tr>
                        <tr>
                            <td class="text-left text-muted"><span style="font-size: 12px"><strong>Grupo: {{$filter['grupo']}}</strong></span></td>
                        </tr>
                        <tr>
                            <td class="text-left text-muted"><span style="font-size: 12px"><strong>Periodo: {{$filter['periodo']}}</strong></span></td>
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
                    <th style="color:#FFFFFF">Recibo</th>
                    <th style="color:#FFFFFF">Alumno</th>
                    <th style="color:#FFFFFF">Curso</th>
                    <th style="color:#FFFFFF">Concepto</th>
                    <th style="color:#FFFFFF">F.P.</th>
                    <th style="color:#FFFFFF">Valor</th>
                    <th style="color:#FFFFFF">Desc.</th>
                    <th style="color:#FFFFFF">Canc.</th>
                    <th style="color:#FFFFFF">Usuario</th>
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
                        @foreach ($tblfpago as $fpago) 
                            @if($fpago['valor']>0)
                                <tr>
                                    <td class="">{{$fpago['nombre']}}</td>
                                    <td>{{number_format($fpago['valor'],2)}}</td>
                                </tr>
                            @endif
                         @endforeach
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
        </table>
    </section>
    <section>
        <table cellpadding="0" cellspancing="0" width="100%">
            <tr>
                <td width="40%" style="vertical-align: top; padding-top: 10px; position: relative">
                    <table cellpadding="0" cellspacing="0" class="table table-sm align-middle" style="font-size:10px">
                        <thead class="table-light">
                            <tr>
                                <th colspan="4">Resumen de Depósitos</th>
                            </tr>
                            <tr style="background-color:#222454">
                                <th style="color:#FFFFFF">Recibo</th>
                                <th style="color:#FFFFFF">Referencia</th>
                                <th style="color:#FFFFFF">Entidad</th>
                                <th style="color:#FFFFFF">Valor</th>
                            </tr>
                        <thead>
                        <tbody class="list"> 
                        @foreach ($resumenpago as $resumen) 
                            @if($resumen['tipo']=='DEP')
                                <tr>
                                    <td class="">{{$resumen['recibo']}}</td>
                                    <td class="">{{$resumen['referencia']}}</td>
                                    <td class="">{{$resumen['entidad']}}</td>
                                    <td>{{number_format($resumen['valor'],2)}}</td>
                                </tr>
                            @endif
                         @endforeach
                        </tbody>
                    </table>
                </td>           
            </tr>
        </table>
    </section>
    <section>
        <table cellpadding="0" cellspancing="0" width="100%">
            <tr>
                <td width="40%" style="vertical-align: top; padding-top: 10px; position: relative">
                    <table cellpadding="0" cellspacing="0" class="table table-sm align-middle" style="font-size:10px">
                        <thead class="table-light">
                            <tr>
                                <th colspan="4">Resumen de Transferencias</th>
                            </tr>
                            <tr style="background-color:#222454">
                                <th style="color:#FFFFFF">Recibo</th>
                                <th style="color:#FFFFFF">Referencia</th>
                                <th style="color:#FFFFFF">Entidad</th>
                                <th style="color:#FFFFFF">Valor</th>
                            </tr>
                        <thead>
                        <tbody class="list"> 
                        @foreach ($resumenpago as $resumen) 
                            @if($resumen['tipo']=='TRA')
                                <tr>
                                    <td class="">{{$resumen['recibo']}}</td>
                                    <td class="">{{$resumen['referencia']}}</td>
                                    <td class="">{{$resumen['entidad']}}</td>
                                    <td>{{number_format($resumen['valor'],2)}}</td>
                                </tr>
                            @endif
                         @endforeach
                        </tbody>
                    </table>
                </td>           
            </tr>
        </table>
    </section>
    <section>
        <table cellpadding="0" cellspancing="0" width="100%">
            <tr>
                <td width="40%" style="vertical-align: top; padding-top: 10px; position: relative">
                    <table cellpadding="0" cellspacing="0" class="table table-sm align-middle" style="font-size:10px">
                        <thead class="table-light">
                            <tr>
                                <th colspan="4">Resumen de Tarjeta de Crédito</th>
                            </tr>
                            <tr style="background-color:#222454">
                                <th style="color:#FFFFFF">Recibo</th>
                                <th style="color:#FFFFFF">Referencia</th>
                                <th style="color:#FFFFFF">Entidad</th>
                                <th style="color:#FFFFFF">Valor</th>
                            </tr>
                        <thead>
                        <tbody class="list"> 
                        @foreach ($resumenpago as $resumen) 
                            @if($resumen['tipo']=='TAR')
                                <tr>
                                    <td class="">{{$resumen['recibo']}}</td>
                                    <td class="">{{$resumen['referencia']}}</td>
                                    <td class="">{{$resumen['entidad']}}</td>
                                    <td>{{number_format($resumen['valor'],2)}}</td>
                                </tr>
                            @endif
                         @endforeach
                        </tbody>
                    </table>
                </td>           
            </tr>
        </table>
    </section>

    <section class="footer">
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
    </section>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
