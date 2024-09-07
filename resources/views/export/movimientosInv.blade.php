<table>
    <thead>
        <tr>
            <td colspan="9"><strong>Detalle de Movimiento de Inventario</strong></td>
        </tr>
        <tr>
            <td><strong>Fecha:</strong></td>
            <td>{{$data['fechaini']}} al {{$data['fechafin']}}</td>
        </tr>
        <tr>
            <td><strong>Tipo:</strong></td>
            <td>{{$data['tipo']}}</td>
        </tr>
        <tr>
            <td><strong>Movimiento:</strong></td>
            <td>{{$data['movimiento']}}</td>
        </tr>
        <tr>
            <td><strong>Categoria:</strong></td>
            <td>{{$data['categoria']}}</td>
        </tr>
        <tr>
            <td><strong>Talla:</strong></td>
            <td>{{$data['talla']}}</td>
        </tr>
    </thead>
    <tr></tr>
    <tr></tr>
    <thead>
        <tr>
            <th><strong>FECHA</strong></th>
            <th><strong>MOVIMIENTO</strong></th>
            <th><strong>REFERENCIA</strong></th>
            <th><strong>PRODUCTO</strong></th>
            <th><strong>TALLA</strong></th>
            <th><strong>PRECIO</strong>/th>
            <th><strong>CANTIDAD</strong></th>
            <th><strong>F. PAGO</strong></th>
            <th><strong>MONTO</strong></th>
            <th><strong>USUARIO</strong></th>
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
    <tr></tr>
    <tr></tr>
    <tr><td><strong>Formas de Pago</strong></td></tr>
    @foreach ($formapago as $key => $fpago) 
        @if($fpago['total']>0)
            <tr>
                <td class="">{{$fpago[$fpago['tipopago']]}}</td>
                <td>{{number_format($fpago['total'],2)}}</td>
            </tr>
        @endif
        {{ $totalres = $totalres + $fpago['total'] }}
    @endforeach
    <tr>
        <td class=""></td>
        <td><strong>{{number_format($totalres,2)}}</strong></td>
    </tr>
    <tr></tr>
    <tr></tr>
    @foreach ($resumen as $key => $data)
    <tr>
        <th>Resumen de {{$fpago[$key]}}</th>
    </tr>
    <tr>
        <th>Fecha</th>
        <th>Documento</th>
        <th>Valor</th>
    </tr>
    {{ $totalres = 0}} 
        @foreach ($data as $data) 
            <tr>
                <td class="">{{date('d/m/Y',strtotime($data['fecha']))}}</td>
                <td class="">{{$data['documento']}}</td>
                <td>{{number_format($data['valor'],2)}}</td>
            </tr>
            {{ $totalres = $totalres + $data['valor'] }}
        @endforeach
        <tr>
            <td></td>
            <td>TOTAL:</td>
            <td>{{number_format($totalres,2)}}</td>
        </tr>
    @endforeach

</table>