<table>
    <thead>
        <tr>
            <td colspan="9"><strong>LISTA DE REPRESENTANTES</strong></td>
        </tr>
        <tr>
            <td><strong>Periodo:</strong></td>
            <td>{{$data['periodo']}}</td>
        </tr>
        <tr>
            <td><strong>Curso:</strong></td>
            <td>{{$data['curso']}}</td>
        </tr>
        <tr>
            <td><strong>Grupo:</strong></td>
            <td>{{$data['grupo']}}</td>
        </tr>
    </thead>
    <tr></tr>
    <tr></tr>
    <thead>
        <tr>
            <th>IDENTIFICACIÓN</th>
            <th>NOMBRES</th>
            <th>NACIONALIDAD</th>
            <th>TELÉFONO</th>
            <th>EMAIL</th>
            <th>ESTUDIANTE</th>
            <th>CURSO</th>
            <th>PERIODO LECTIVO</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($tblrecords as $record)
        <tr>                                       
            <td>{{$record->identificacion}}</td>
            <td>{{$record->apellidos}} {{$record->nombres}}</td>
            <td>{{$record->nacionalidad}}</td>
            <td>{{$record->telefono}}</td>
            <td>{{$record->email}}</td>
            <td>{{$record->apeestudiante}} {{$record->nomestudiante}}</td>
            <td>{{$record->descripcion}}</td>
            <td>{{$record->periodo}}</td>
        </tr>
    @endforeach    
    </tbody>    
</table>
