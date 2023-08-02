<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estado de Cuenta</title>


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <section class="header" style ="top: -287px;">
        <table cellpadding="0" cellspancing="0" width="100%" style="font-size:13px">
            <tr>
                <td width="100%" style="vertical-align: top; padding-top: 10px">
                    <img src="../public/assets/images/banner-ueas.jpg" height="100px">
                    <div class="text-center" style="position: absolute;top: 8%; left: 70%; transform: translate(-12%, -70%); font-size:15px;">
                    <strong>Estado de Cuenta</strong>
                    </div>
                </td>        
            </tr>
            <tr>
                <td class="text-right text-muted"><span style="font-size: 12px"><strong> {{date('d-M-Y H:i:s',strtotime($data['fecha']))}} </strong></span></td>
            </tr>
            <tr>
                <td class="text-left text-muted"><span style="font-size: 12px"><strong>Estudiante: {{$data['nombre']}}</strong></span></td>
            </tr>
            <tr>
                <td class="text-left text-muted"><span style="font-size: 12px"><strong>Curso: {{$data['curso']}}</strong></span></td>
            </tr>
            <tr>
                <td class="text-left text-muted"><span style="font-size: 12px"><strong>Grupo: {{$data['grupo']}} / {{$data['periodo']}}</strong></span></td>
            </tr>
            <tr>
                @if($data['estado']=='R')
                    <td class="text-left text-muted"><span style="font-size: 12px"><strong>RETIRADO</strong></span></td>
                @endif
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
                    <th style="color:#FFFFFF">Concepto</th>
                    <th class="text-right" style="color:#FFFFFF">Valor</th>
                    <th class="text-right" style="color:#FFFFFF">Saldo</th>
                    <th class="text-right" style="color:#FFFFFF" >Haber</th>
                    <th class="text-right" style="color:#FFFFFF">Desc</th>
                    <th style="color:#FFFFFF">Fecha</th>
                    <th style="color:#FFFFFF">Recibo</th>
                    <th style="color:#FFFFFF">F.P</th>
                    <th style="color:#FFFFFF">Usuario</th>
                </tr>
            <thead>
            <tbody class="list">
            @foreach ($tblrecords as $record)    
                <tr>
                    <td> {{$record['detalle']}} </td>
                    @if($record['tipovalor']=='DB')
                        <td class="text-right"> {{number_format($record['valor'],2)}} </td>
                        <td class="text-right"> {{number_format($record['saldo'],2)}} </td>
                    @else
                        <td> </td>
                        <td> </td>
                        <td class="text-right"> {{number_format($record['valor'],2)}} </td>
                        <td class="text-right"> {{number_format($record['descuento'],2)}} </td>
                        <td> {{$dias[date('N', strtotime($record->fecha))];}}, {{date('d-M-Y',strtotime($record->fecha))}}</td>
                        <td> {{$record['referencia']}} 
                            @if($record->estado=='A') 
                                <span style="color:#FF0000">ANULADO</span> 
                            @endif
                        </td>
                        <td> {{$record['tipopago']}}</td>
                        <td> {{$record['usuario']}}</td>
                    @endif                    
                </tr>
            @endforeach
            </tbody>
        </table>
    </section>
    <section>
        <table cellpadding="0" cellspancing="0" width="100%">
            <tr>
                <td width="50%" style="vertical-align: top; padding-top: 10px; position: relative">
                </td>
                <td width="50%" style="vertical-align: top; padding-top: 10px; position: relative">
                    <table cellpadding="0" cellspacing="0" class="table table-sm align-middle" style="font-size:10px">
                        <thead class="table-light">
                            <tr>
                                <th colspan="2">Totales</th>
                            </tr>
                        <thead>
                        <tbody class="list"> 
                                <tr>
                                    <td>Valor</td>
                                    <td class="text-right">{{number_format($tblrecords->where('tipovalor','DB')->sum('valor'),2)}}</td>
                                </tr>
                                <tr>
                                    <td>Haber</td>
                                    <td class="text-right">{{number_format($tblrecords->where('tipovalor','CR')->sum('valor'),2)}}</td>
                                </tr>
                                <tr>
                                    <td>Descuento</td>
                                    <td class="text-right">{{number_format($tblrecords->where('tipovalor','DB')->sum('descuento'),2)}}</td>
                                </tr>
                                <tr>
                                    <td>Saldo</td>
                                    <td class="text-right">{{number_format($tblrecords->sum('saldo'),2)}}</td>
                                </tr>
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
                        @foreach ($tbldetalle as $resumen) 
                            @if($resumen['tipopago']=='DEP')
                                <tr>
                                    <td class="">{{$resumen['documento']}}</td>
                                    <td class="">{{$resumen['referencia']}}</td>
                                    <td class="">{{$resumen['descripcion']}}</td>
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
                                <th colspan="4">Resumen de Transferencia</th>
                            </tr>
                            <tr style="background-color:#222454">
                                <th style="color:#FFFFFF">Recibo</th>
                                <th style="color:#FFFFFF">Referencia</th>
                                <th style="color:#FFFFFF">Entidad</th>
                                <th style="color:#FFFFFF">Valor</th>
                            </tr>
                        <thead>
                        <tbody class="list"> 
                        @foreach ($tbldetalle as $resumen) 
                            @if($resumen['tipopago']=='TRA')
                                <tr>
                                    <td class="">{{$resumen['documento']}}</td>
                                    <td class="">{{$resumen['referencia']}}</td>
                                    <td class="">{{$resumen['descripcion']}}</td>
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
                        @foreach ($tbldetalle as $resumen) 
                            @if($resumen['tipopago']=='TAR')
                                <tr>
                                    <td class="">{{$resumen['documento']}}</td>
                                    <td class="">{{$resumen['referencia']}}</td>
                                    <td class="">{{$resumen['descripcion']}}</td>
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
