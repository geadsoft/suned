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
                <p class="text-center" style="margin: 0px;">UNIDAD EDUCATIVA AMERICAN SCHOOL - {{$datos['nivel']}}</p>
            </th> 
        </tr>
        <tr>
            <th colspan="{{$column}}">
                <p class="text-center" style="margin: 0px;">ACTA DE CALIFICACIONES</p>
            </th> 
        </tr>
        <tr>
            <th colspan="{{$column}}">
                <p class="text-center" style="margin: 0px;">{{$datos['subtitulo']}}</p>
            </th> 
        </tr>
        <tr>
            <th colspan="{{$column}}">
                <p class="text-center" style="margin: 0px;">{{$datos['docente']}} / {{$datos['materia']}}</p>
            </th> 
        </tr> 
        <tr>
            <th colspan="{{$column}}">
                <p class="text-center" style="margin: 0px;">{{$datos['curso']}}</p>
            </th> 
        </tr>
        <tr>
            <th>NOMBRES</th>
            @foreach ($tblgrupo as $key => $grupo)
                @if ($key=='AI')
                    <th>ACTIVIDAD INDIVIDUAL</th>
                @else
                    <th>ACTIVIDAD GRUPAL</th>
                @endif 
            @endforeach
            <th>
            <span>Promedio</span>
            </th>
            <th>
            <span>Cualitativa</span>
            </th>
        </tr>
    </thead>
    <tbody>
    @foreach ($tblrecords as $fil => $record)
        <tr>
        <td>{{$record["nombres"]}}</td>
        @foreach ($tblgrupo as $key1 => $grupo)
            <?php
            $colprom = $key1."prom";
            ?>
            <td>{{number_format($tblrecords[$fil][$colprom],2)}}</td>
        @endforeach 
        <td><strong>{{number_format($record["promedio"],2)}}</strong></td>   
        <td>{{$record["cualitativa"]}}</td> 
        </tr> 
    @endforeach
    </tbody>

</table>
