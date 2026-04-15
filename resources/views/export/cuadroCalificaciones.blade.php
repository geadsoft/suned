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
            <th colspan="{{$column}}">
                <p class="text-center" style="margin: 0px;">{{$data['nombre']}}</p>
            </th> 
        </tr>
        <tr>
            <th colspan="{{$column}}">
                <p class="text-center" style="margin: 0px;"><strong>Dirección:</strong>{{$data['direccion']}}</p>
            </th> 
        </tr>
        <tr>
            <th colspan="{{$column}}">
                <p class="text-center" style="margin: 0px;"><strong>Teléfono:</strong>{{$data['telefono']}}</p>
            </th> 
        </tr>
        <tr>
            <th colspan="{{$column}}">
                <p class="text-center" style="margin: 0px;">{{$data['periodo']}}</p>
            </th> 
        </tr>
        <tr>
            <th colspan="{{$column}}">
                <p class="text-center" style="margin: 0px;">CUADRO DE CALIFICACIONES</p>
            </th> 
        </tr>
        <tr><th colspan="{{$column}}"></th></tr>
        <tr class="text-uppercase text-center">
            <th>N°</th>
            <th>Nómina</th>
            <th rowspan="2" style="height:120px; width:30px; padding:0;">Comportamiento</th>
            @foreach ($asignaturas as $data)
            <th colspan="5" style="background-color:#222454; color:white; ">{{$data['descripcion']}}</th>
            <th style="background-color:white; color:white;"></th>
            @endforeach
        </tr>
        <tr style="height:100px;">
            <th colspan="3"></th>
            @foreach ($asignaturas as $data)
            <th>I Tr.</th>
            <th>II Tr.</th>
            <th>III Tr.</th>
            <th>Prom.</th>
            <th>Final</th>
            <th></th>
            @endforeach
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
            <td class="text-center">{{ $detalles[$idPersona]['comportamiento'] ?? '' }}</td>
            @foreach ($asignaturas as $asignatura)
                @php
                    $idasignatura = $asignatura['asignatura_id'];
                    $nota = $detalles[$idPersona][$idasignatura] ?? null;
                @endphp
                <td class="text-center">{{ number_format($nota['1T'],2) ?? '' }}</td>
                <td class="text-center">{{ number_format($nota['2T'],2) ?? '' }}</td>
                <td class="text-center">{{ number_format($nota['3T'],2) ?? '' }}</td>
                <td class="text-center">{{ number_format($nota['PR'],2) ?? '' }}</td>
                <td class="text-center">{{ number_format($nota['PF'],2) ?? '' }}</td>
                <td></td>
            @endforeach
        </tr>
        @endforeach
    </tbody>
</table>
