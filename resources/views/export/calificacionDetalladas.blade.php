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
                    <th colspan="{{count($grupo)+1}}">ACTIVIDAD INDIVIDUAL</th>
                @else
                    <th colspan="{{count($grupo)+1}}">ACTIVIDAD GRUPAL</th>
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
    <thead>
        <tr>
            <th></th>
            @foreach ($tblgrupo as $key => $grupo)
                @foreach ($grupo as $data)
                    <th>
                    <span class="text-center" style="margin: 0px;">{{$data->nombre}}</span>
                    </th>
                @endforeach
                <th>
                <span><strong>Promedio {{$key}}</strong></span>
                </th>
            @endforeach
            <th colspan="2"></th>
        </tr>
    </thead>
    <tbody>
    @foreach ($tblrecords as $fil => $record)
        <tr>
        <td>{{$record["nombres"]}}</td>
        @foreach ($tblgrupo as $key1 => $grupo)
            @foreach ($grupo as $key2 => $data)
            <?php
            $col = $key1.$key2;
            $colprom = $key1."prom";
            ?>
            <td>{{number_format($tblrecords[$fil][$col],2)}}</td>
            @endforeach 
            <td>{{number_format($tblrecords[$fil][$colprom],2)}}</td>
        @endforeach 
        <td><strong>{{number_format($record["promedio"],2)}}</strong></td>   
        <td>{{$record["cualitativa"]}}</td> 
        </tr> 
    @endforeach
    </tbody>

</table>
