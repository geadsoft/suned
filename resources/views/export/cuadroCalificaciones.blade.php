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
            <th>{{$data['nombre']}}</th> 
        </tr>
        <tr>
            <th></th> 
        </tr>
        <tr>
            <th>INFORME FINAL DE CALIFICACIONES</th> 
        </tr>
        <tr>
            <th>
                <p class="text-center" style="margin: 0px;">{{$data['curso']}}</p>
            </th> 
        </tr>
        <tr>
            <th>
                <p class="text-center" style="margin: 0px;">{{$data['periodo']}}</p>
            </th> 
        </tr>
        <tr><th></th></tr>
        <tr class="text-uppercase text-center">
            <th rowspan="2">N°</th>
            <th rowspan="2">Nómina</th>
            @foreach ($asignaturas as $data)
            <th colspan="4" style="background-color:#222454; color:white; ">{{$data['descripcion']}}</th>
            @endforeach
            <th rowspan="2" style="background-color:#222454; color:white; ">SUMA TOTAL</th>
            <th rowspan="2" style="background-color:#222454; color:white; ">PROMEDIO FINAL</th>
            <th colspan="4" style="background-color:#222454; color:white; ">COMPORTAMIENTO</th>
            <th rowspan="2" style="background-color:#222454; color:white; ">OBSERVACIONES</th>
        </tr>
        <tr style="height:100px;">
            @foreach ($asignaturas as $data)
            <th>I Tr.</th>
            <th>II Tr.</th>
            <th>III Tr.</th>
            <th>Prom.</th>
            @endforeach
            <th>I Tr.</th>
            <th>II Tr.</th>
            <th>III Tr.</th>
            <th>Prom.</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($alumnos as $key => $alumno)
        @php
            $idPersona = $alumno['persona_id'];
        @endphp
        <tr>
            <td>{{ $detalles[$idPersona]['linea'] ?? '' }}</td>
            <td>{{ $detalles[$idPersona]['nombres'] ?? '' }}</td>
            @foreach ($asignaturas as $asignatura)
                @php
                    $idasignatura = $asignatura['asignatura_id'];
                    $nota = $detalles[$idPersona][$idasignatura] ?? null;
                @endphp
                <td class="text-center">{{ number_format($nota['1T'],2) ?? '' }}</td>
                <td class="text-center">{{ number_format($nota['2T'],2) ?? '' }}</td>
                <td class="text-center">{{ number_format($nota['3T'],2) ?? '' }}</td>
                <td class="text-center">{{ number_format($nota['PR'],2) ?? '' }}</td>
            @endforeach
            <td>0</td>
            <td>0</td>
            <td>{{$detalles[$idPersona]['conducta']['1T'] ?? '' }}</td>
            <td>{{$detalles[$idPersona]['conducta']['2T'] ?? '' }}</td>
            <td>{{$detalles[$idPersona]['conducta']['3T'] ?? '' }}</td>
            <td class="text-center">{{ $detalles[$idPersona]['comportamiento'] ?? '' }}</td>
            <td class="text-center">{{ $detalles[$idPersona]['promocion'] ?? '' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
