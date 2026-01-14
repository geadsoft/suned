<?php
$impact = 0;
$negativeChanges = 0;
$positiveChanges = 0;
?>
<style>
    .strikethroughCell{
        text-decoration: line-through !important;
    }
    .table-text-center th,
    .table-text-center td{
        text-align: center !important;
    }
</style>
<table class="table-text-center">
    <thead>
        <tr>
            <th colspan="12">
                <p class="text-center" style="margin: 0px;">UNIDAD EDUCATIVA AMERICAN SCHOOL</p>
            </th> 
        </tr>
        <tr>
            <th colspan="12">
                <p class="text-center" style="margin: 0px;">CONCILIACIÓN DE INGRESOS / COBROS</p>
            </th> 
        </tr> 
        <tr>
            <th>FECHA EMISIÓN</th>
            <th>FECHA PAGO</th>
            <th>Nº RECIBO</th>
            <th>Nº MONTO</th>
            <th>ESTUDIANTE</th>
            <th>CURSO</th>
            <th>FORMA DE PAGO</th>
            <th>REFERENCIA</th>
            <th>ENTIDAD</th>
            <th>VALOR</th>
            <th>DETALLE</th>
            <th>PAGO</th>
            <th>USUARIO</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($tblrecords as $fil => $record)
        <tr>
            <td>{{date('d/m/Y',strtotime($record["fecha"]))}}</td>
            <td>{{date('d/m/Y',strtotime($record["fechapago"]))}}</td>
            <td>{{$record["documento"]}}</td>
            <td>{{number_format($record["monto"],2)}}</td>
            <td>{{$record["apellidos"]}} {{$record["nombres"]}}</td>
            <td>{{$record["descripcion"]}} {{$record["paralelo"]}}</td>
            <td>{{$record["tipopago"]}}</td>
            <td>{{$record["referencia"]}}</td>
            <td>{{$record["entidad"]}}</td>

            <td>{{$record["detalle"]}}</td>
            <td>{{number_format($record["pago"],2)}}</td>
            <td>{{$record["usuario"]}}</td>
        </tr> 
    @endforeach
    </tbody>

</table>
