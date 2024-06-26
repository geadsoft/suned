<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Detalle de Productos</title>
        
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
                <td class="text-left text-muted"><span style="font-family: Tahoma; font-size: 12px"><strong>Fecha: {{date('d/m/Y',strtotime($info['fechaini']))}} - {{date('d/m/Y',strtotime($info['fechafin']))}}</strong></span></td>
            </tr>
            <tr>
                <td class="text-left text-muted"><span style="font-family: Tahoma; font-size: 12px"><strong>{{$filtros}}</strong></span></td>
            </tr>                
        </table>
        <br>
        <p class="text-left text-muted"><span style="font-family: Tahoma; font-size: 12px">
        II - Inventario Inicial | CL - Compra Local | IA - Ingreso por Ajuste | DC - Devolución en Compra <br>
        VE - Ventas | EA - Egresos por Ajuste | DV - Devolución en Venta
        </span>
        </p>
    </head>
    <body>
        <hr>
        <div class="contenido">
            <!--<p id="primero">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore nihil illo odit aperiam alias rem voluptatem odio maiores doloribus facere recusandae suscipit animi quod voluptatibus, laudantium obcaecati quisquam minus modi.</p>
            <p id="segundo">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore nihil illo odit aperiam alias rem voluptatem odio maiores doloribus facere recusandae suscipit animi quod voluptatibus, laudantium obcaecati quisquam minus modi.</p>
            <p id="tercero">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore nihil illo odit aperiam alias rem voluptatem odio maiores doloribus facere recusandae suscipit animi quod voluptatibus, laudantium obcaecati quisquam minus modi.</p>
            -->
            

            <table cellpadding="0" cellspacing="0" class="table table-condensed table-bordered table-hover" style="font-size:10px">
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
                    <td>{{$record->fpago}}</td>
                    <td>{{number_format($record->total,2)}}</td>
                    <td>{{$record->usuario}}</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
                <tr> 
                    <td colspan="3"></td>
                    <td class="text-center">
                        <span><b>TOTALES<b></span>
                    </td>
                    <td></td>
                    <td>
                        <span><strong>{{number_format($invtra->where('estado','P')->sum('cantidad'),2)}}<strong></span>
                    <td>
                    <td colspan="1">
                        <span><strong>${{number_format($invtra->where('estado','P')->sum('total'),2)}}<strong></span>
                    </td> 
                </tr>
            </tfoot>
        </table>
        </div>
    </body>
</html>