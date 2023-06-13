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
                <td width="100%" style="vertical-align: top; padding-top: 10px">
                    <img src="../public/assets/images/banner-ueas.jpg" height="126px">
                    <div class="text-center" style="position: absolute;top: 12%; left: 68%; transform: translate(-12%, -70%); font-size:15px;">
                    <strong>Recibo de Cobro No. {{$tblrecords['documento']}}</strong>
                    </div>
                </td>        
            </tr>
            <tr>
                <td width="70%" class="text-center" style="vertical-align: top; padding-top: 10px">
                    
                    <table width="100%" cellpadding="0" cellspancing="0">
                        <tr>
                            <td class="text-left text-muted"><span style="font-size: 12px"><strong>Fecha: {{date('d/m/Y',strtotime($tblrecords['fecha']))}} </strong></span></td>
                        </tr>
                        <tr>
                            <td class="text-left text-muted"><span style="font-size: 12px"><strong>Estudiante: {{$tblrecords->estudiante->apellidos}} {{$tblrecords->estudiante->nombres}}</strong></span></td>
                        </tr>
                        <tr>
                            <td class="text-left text-muted"><span style="font-size: 12px"><strong>Matricula: {{$tblrecords->matricula->documento}} - {{$tblrecords->matricula->modalidad->descripcion}}</strong></span></td>
                        </tr>
                         <tr>
                            <td class="text-left text-muted"><span style="font-size: 12px"><strong>Curso: {{$tblrecords->matricula->curso->servicio->descripcion}} - {{$tblrecords->matricula->curso->paralelo}}</strong></span></td>
                        </tr>
                        <tr>
                            <td class="text-left text-muted"><span style="font-size: 12px"><strong>Recaudador: {{$tblrecords->usuario}} </strong></span></td>
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
                    <th style="color:#FFFFFF">Fecha</th>
                    <th style="color:#FFFFFF">Glosa</th>
                    <th style="color:#FFFFFF">Referencia</th>
                    <th style="color:#FFFFFF">Bruto</th>
                    <th style="color:#FFFFFF">Desc.</th>
                    <th style="color:#FFFFFF">Neto.</th>
                    <th style="color:#FFFFFF">Cancela</th>
                    <th style="color:#FFFFFF">Saldo</th>
                </tr>
            <thead>
            <tbody class="list">
            @foreach ($tbldeudas as $record)    
                <tr>
                    <td>{{date('d/m/Y',strtotime($record->fecha))}}</td>
                    <td>{{$record->detalle}}</td> 
                    <td>{{$record->referencia}}</td>
                    <td>{{number_format($record->debito,2)}}</td>
                    <td>{{number_format($record->descuento,2)}}</td>
                    <td>{{number_format($record->saldo+$record->valor+$record->descuento,2)}}</td>
                    <td>{{number_format($record->valor,2)}}</td>
                    <td>{{number_format($record->saldo,2)}}</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2"></td>
                    <td class="text-left">
                        <span><b>SUBTOTAL<b></span>
                    </td> 
                    <td colspan="4"></td>
                    <td colspan="1">
                        <span><strong>${{number_format($tbldeudas->sum('saldo')+$tbldeudas->sum('valor')+$tbldeudas->sum('descuento'),2)}}<strong></span>
                    </td> 
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td class="text-left">
                        <span><b>DESCUENTO<b></span>
                    </td> 
                    <td colspan="4"></td>
                    <td colspan="1">
                        <span><strong>${{number_format($tbldeudas->sum('descuento'),2)}}<strong></span>
                    </td> 
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td class="text-left">
                        <span><b>TOTAL<b></span>
                    </td> 
                    <td colspan="4"></td>
                    <td colspan="1">
                        <span><strong>${{number_format($tbldeudas->sum('valor'),2)}}<strong></span>
                    </td> 
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td class="text-left">
                        <span><b>CANCELA<b></span>
                    </td> 
                    <td colspan="4"></td>
                    <td colspan="1">
                        <span><strong>${{number_format($tbldeudas->sum('valor'),2)}}<strong></span>
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
                                <th colspan="4">Formas de Pagos</th>
                            </tr>
                        <thead>
                        <tbody class="list"> 
                            @foreach ($tblcobros as $record)    
                            <tr>
                                <td>{{$fpago[$record->tipopago]}}</td>
                                @if ($record->tipopago="EFE"){
                                    <td></td>
                                }@else{
                                <td>{{$record->entidad->descripcion}}</td>
                                }
                                @endif
                                <td>{{$record->referencia}}</td>
                                <td>{{number_format($record->valor,2)}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </td>
                <td width="30%" class="text-left" style="vertical-align: top; padding-top: 10px">
                </td> 

                         
            </tr>
            <tr>
                

            </tr>
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
