<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"><title>{{$faccab->autorizacion}}.pdf</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<section class="header" style ="top: -287px;">
        <table cellpadding="0" cellspancing="0" width="100%">
            <tr>
                <td width="80%" style="vertical-align: top; padding-top: 10px">
                    <div class="text-center">
                        <img src="../public/assets/images/companies/Andres Fantoni.png" height="100px">
                    </div>
                    <table width="100%" cellpadding="0" cellspancing="0" style="background-color:#f8f5f5">
                        <tr>
                            <td class="text-left"><span style="font-size: 12px"><strong>&nbsp;&nbsp;Emisor: </strong>{{$emisor->razon_social}}</span></td>
                        </tr>
                        <tr>
                            <td class="text-left"><span style="font-size: 12px"><strong>&nbsp;&nbsp;RUC: </strong>{{$emisor->ruc}}</span></td>
                        </tr>
                        <tr>
                            <td class="text-left"><span style="font-size: 12px"><strong>&nbsp;&nbsp;Matriz: </strong>{{$emisor->direccion}}</span></td>
                        </tr>
                        <tr>
                            <td class="text-left"><span style="font-size: 12px"><strong>&nbsp;&nbsp;Correo: </strong>{{$emisor->email}}</span></td>
                        </tr>
                        <tr>
                            <td class="text-left"><span style="font-size: 12px"><strong>&nbsp;&nbsp;Teléfono: </strong>{{$emisor->telefono}}</span></td>
                        </tr>
                        <tr>
                            @if ($emisor->lleva_contabilidad==0)
                            <td class="text-left"><span style="font-size: 12px"><strong>&nbsp;&nbsp;Obligado a llevar contabilidad:</strong>NO</span></td>
                            @else
                            <td class="text-left"><span style="font-size: 12px"><strong>&nbsp;&nbsp;Obligado a llevar contabilidad:</strong>SI</span></td>
                            @endif 
                        </tr>
                    </table>
                </td>
                <td width="40%" style="vertical-align: top; padding-top: 10px" style="background-color:#f8f5f5">
                    <table width="100%" cellpadding="0" cellspancing="0">
                        <tr>
                            <td class="text-left"><span style="font-size: 12px"><strong>&nbsp;&nbsp;NOTA DE CREDITO:</strong>{{$faccab->establecimiento}}-{{$faccab->puntoemision}}-{{$faccab->documento}} </span></td>
                        </tr>
                        <tr><br></tr>
                        <tr>
                            <td class="text-left"><span style="font-size: 12px"><strong>&nbsp;&nbsp;Número Autorización:</strong></span></td>
                        </tr>
                        <tr>
                            <td class="text-left"><span style="font-size: 12px">&nbsp;&nbsp;{{$faccab->autorizacion}}</span></td>
                        </tr>
                        <tr><br></tr>
                        <tr>
                            <td class="text-left"><span style="font-size: 12px"><strong>&nbsp;&nbsp;Fecha y hora Autorización:</strong></span></td>
                        </tr>
                        <tr>
                            <td class="text-left"><span style="font-size: 12px"></span></td>
                        </tr>
                        <tr><br></tr>
                        <tr>
                            <td class="text-left"><span style="font-size: 12px"><strong>&nbsp;&nbsp;Ambiente:</strong>PRODUCCIÓN</span></td>
                        </tr>
                        <tr>
                            <td class="text-left"><span style="font-size: 12px"><strong>&nbsp;&nbsp;Emisión:</strong>NORMAL</span></td>
                        </tr>
                        <tr>
                            <td class="text-left"><span style="font-size: 12px"><strong>&nbsp;&nbsp;Clave de Acceso:</strong></span></td>
                        </tr>
                    </table>
                </td>       
            </tr>
            <tr style="background-color:#f8f5f5">
                <td width="50%" style="vertical-align: top; padding-top: 10px" >
                    <table width="100%" cellpadding="0" cellspancing="0">
                        <tr>
                            <td class="text-left"><span style="font-size: 12px"><strong>&nbsp;&nbsp;Razón Social: </strong>{{$faccab->persona->apellidos}} {{$faccab->persona->nombres}}</span></td>
                        </tr>
                        <tr>
                            <td class="text-left"><span style="font-size: 12px"><strong>&nbsp;&nbsp;Dirección:</strong> {{$faccab->persona->direccion}} </span></td>
                        </tr>
                        <tr>
                            <td class="text-left"><span style="font-size: 12px"><strong>&nbsp;&nbsp;Fecha Emisión:</strong> {{date('d',strtotime($faccab->fecha))}}/{{date('m',strtotime($faccab->fecha))}}/{{date('Y',strtotime($faccab->fecha))}}</span></td>
                        </tr><br>
                    </table>
                </td>
                <td width="50%" style="vertical-align: top; padding-top: 10px">
                    <table width="100%" cellpadding="0" cellspancing="0">
                        <tr>
                            <td class="text-left"><span style="font-size: 12px"><strong>&nbsp;&nbsp;RUC/CI:</strong>{{$faccab->persona->identificacion}}</span></td>
                        </tr>
                        <tr>
                            <td class="text-left"><span style="font-size: 12px"><strong>&nbsp;&nbsp;Teléfono:</strong>{{$faccab->persona->telefono}}</span></td>
                        </tr>
                        <tr>
                            <td class="text-left"><span style="font-size: 12px"><strong>&nbsp;&nbsp;Correo:</strong>{{$faccab->persona->email}}</span></td>
                        </tr><br>
                    </table>
                </td>       
            <tr>
        </table>
        <br>
    </section>

    <section class="header" style ="top: -287px;">
    </section>

    <section style ="margin-top: -110px;">
        <table cellpadding="0" cellspacing="0" class="table table-borderless table-sm align-middle mb-0">
            <thead class="table-light" style="background-color:#222454; font-size:12px">
                <tr>
                    <th class="text-center" style="width: 95px; color:#FFFFFF">Código Principal</th>
                    <th class="text-center" style="color:#FFFFFF">Cantidad</th>
                    <th class="text-center" style="color:#FFFFFF">Descripción</th>
                    <th class="text-center" style="width: 70px;color:#FFFFFF">Detalles Adicionales</th>
                    <th class="text-center" style="width: 65px; color:#FFFFFF">Precio Unitario</th>
                    <th class="text-center" style="width: 65px; color:#FFFFFF">Descuento</th>
                    <th class="text-center" style="width: 65px; color:#FFFFFF">Total</th>
                </tr>
            <thead>
            <tbody class="list" style="background-color:#f8f5f5; font-size:12px">
            @foreach ($facdet as $record)    
                <tr>
                    <td>{{$record->codigo}}</td>
                    <td class="text-right">{{$record->cantidad}}</td> 
                    <td>{{$record->descripcion}}</td>
                    <td></td>
                    <td class="text-right">${{number_format($record->precio,2)}}</td>
                    <td class="text-right">${{number_format($record->descuento,2)}}</td>
                    <td class="text-right">${{number_format($record->total,2)}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <br><br><br>
    </section>

    <section>
        <table cellpadding="0" cellspancing="0" width="100%" style="font-size:12px">
            <tr>
                <td width="65%" style="vertical-align: top; padding-top: 12px">
                    <table width="100%" cellpadding="0" cellspancing="0" style="background-color:#f8f5f5">
                        <tr>
                            <td class="text-left"><span style="font-size: 12px"><strong>&nbsp;&nbsp;Información Adicional</strong></span></td>
                        </tr>
                        <tr>
                            <table width="100%" cellpadding="0" cellspancing="0">
                    
                                <tr>
                                    <td class="text-left"><span style="font-size: 12px">&nbsp;&nbsp;Descripción</span></td>
                                    <td class="text-left"><span style="font-size: 12px">&nbsp;&nbsp;Estudiante: {{$faccab->estudiante->apellidos}} {{$faccab->estudiante->nombres}}</span></td>
                                </tr>
                            </table>
                        </tr>
                        <tr><br></tr>
                        <tr>
                            <td class="text-left"><span style="font-size: 12px"><strong>&nbsp;&nbsp;Formas de pago</strong></span></td>
                        </tr>
                        <tr>
                            <table width="100%" cellpadding="0" cellspancing="0">
                                <tr>
                                    <td width="60%" class="text-left"><span style="font-size: 12px"></span>&nbsp;&nbsp;{{$fpago[$faccab->formapago]}}</td>
                                    <td width="20%" class="text-left"><span style="font-size: 12px"></span>&nbsp;&nbsp;{{number_format($faccab->neto,2)}}</td>
                                    <td width="20%" class="text-center"><span style="font-size: 12px"></span>&nbsp;&nbsp;{{$faccab->dias}} &nbsp; {{$faccab->plazo}}</td>
                                </tr>
                            </table>
                        </tr>
                        <br>
                    </table>
                </td>
                <td width="5%" style="vertical-align: top; padding-top: 12px">
                </td>
                <td width="30%" style="vertical-align: top; padding-top: 12px">
                    <table width="100%" cellpadding="0" cellspancing="0" style="background-color:#f8f5f5; font-size: 12px" class="table table-borderless table-sm align-middle mb-0">
                        <tr>    
                            <td> Subtotal Sin Impuestos: 
                                
                            </td> 
                            <td class="text-right"> ${{number_format($faccab->subtotal,2)}} </td> 
                        </tr>
                        <tr>    
                            <td> Subtotal 15%: </td> 
                            <td class="text-right"> 0.00 </td> 
                        </tr>
                        <tr>    
                            <td> Subtotal 0%: </td> 
                            <td class="text-right"> ${{number_format($faccab->subtotal,2)}} </td> 
                        </tr>
                        <tr>    
                            <td> Subtotal No Objeto IVA: </td> 
                            <td class="text-right"> $0.00 </td> 
                        </tr>
                        <tr>    
                            <td> Descuentos: </td> 
                            <td class="text-right"> $0.00 </td> 
                        </tr>
                        <tr>    
                            <td> ICE: </td> 
                            <td class="text-right"> $0.00 </td> 
                        </tr>
                        <tr>    
                            <td> IVA 15%: </td> 
                            <td class="text-right"> $0.00 </td> 
                        </tr>
                        <tr>    
                            <td><strong>Valor Total:</strong></td> 
                            <td class="text-right"><strong>${{number_format($faccab->neto,2)}}</strong></td> 
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </section>
  
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>

