<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Curso de Laravel</title>

        <style>
table {
   width: 100%;
   font-size: 0.6em;
}
th, td {
   width: 25%;
   text-align: left;
   vertical-align: top;
   padding: 0.3em;
}
caption {
   padding: 0.3em;
}
        </style>

    </head>
    <body>
        <h2>Reporte Movimiento</h2>
        <br>
        <table>
            <thead class="table-light" style="background-color:#222454">
                <tr>
                    <th style="width: 50px; color:#FFFFFF">Fecha</th>
                    <th style="width: 40px; color:#FFFFFF">Mov.</th>
                    <th style="width: 150px; color:#FFFFFF">Referencia</th>
                    <th style="width: 100px; color:#FFFFFF">Producto</th>
                    <th style="width: 30px; color:#FFFFFF">Talla</th>
                    <th style="width: 40px; color:#FFFFFF">Precio</th>
                    <th style="width: 40px; color:#FFFFFF">Cantidad</th>
                    <th style="width: 50px; color:#FFFFFF">F. Pago</th>
                    <th style="width: 40px; color:#FFFFFF">Monto</th>
                    <th style="color:#FFFFFF">Usuario</th>
                </tr>
            <thead>
            @foreach ($invtra as $record)  
                <tr>
                    <td>{{date('d/m/Y',strtotime($record->fecha))}}</td>
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
        </table>
    </body>
</html>