<table>
    <thead>
        <tr>
            <td colspan="9"><strong>LISTA DE MATRICULAS</strong></td>
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
            <th><strong>N°</strong></th>
            <th><strong>ESTUDIANTE</strong></th>
            <th><strong>IDENTIFICACIÓN</strong></th>
            <th><strong>NUEVO</strong></th>
            <th><strong>PROPIO</strong></th>
            <th><strong>MASCULINO</strong></th>
            <th><strong>FEMENINO</strong></th>
            <th><strong>DIA</strong></th>
            <th><strong>REGISTRO</strong></th>
        </tr>                
    </thead>
    <tbody>
        @foreach ($tblrecords as $key => $grupo)
            <tr>
                <td colspan="8"><strong> {{$key}} </strong></td>
            </tr> 
                @foreach ($grupo as $key => $curso)
                <tr>
                    <td></td>
                    <td colspan="8"><strong> {{$key}} </strong></td>
                </tr> 
                @foreach ($curso as $key => $persona)  
                    <tr>
                        <td> <strong></strong></td>
                        <td colspan="8"> <strong> Paralelo: {{$key}} </strong></td>
                    </tr>    
                    @foreach ($persona as $key => $recno)               
                    <tr>
                        <td>{{$recno['nromatricula']}} </td>
                        <td>{{$recno['apellidos']}} {{$recno['nombres']}}</td>
                        <td>{{$recno['identificacion']}}</td>
                        @if($recno['tipomatricula']=='N')
                            <td>X</td>
                            <td> </td>
                        @else
                            <td></td>
                            <td>X</td>
                        @endif
                        @if ($recno['genero']=="M")
                            <td><span>X</span></td>
                            <td></td>
                        @else
                            <td></td>
                            <td>X</td>
                        @endif
                        <td>{{$dias[$recno['diamatricula']]}}</td>
                        <td>{{date('d-M-Y',strtotime($recno['fechamatricula']))}}</td>
                    </tr>
                    @endforeach
                @endforeach
            @endforeach
        @endforeach
    </tbody>
    <tr></tr>
    <tr></tr>
    <thead>
        <tr>
            <th><strong></strong></th>
            <th colspan="8"><strong>RESUMEN MATRICULA</strong></th>
        </tr>
    </thead>
    <thead>
        <tr>
            <th></th>
            <th><strong>Mes</strong></th>
            <th><strong>Estudiantes</strong></th>
            <th><strong>Mujeres</strong></th>
            <th><strong>Hombres</strong></th>
            <th><strong>Nuevos</strong></th>
            <th><strong>Propios</strong></th>
        </tr>
    </thead>
    <tbody> 
        @foreach ($resmatricula as $key => $recno)
            <tr>
                <td></td>
                <td>{{$meses[$recno['mes']]}}</td>
                <td>{{$recno['estudiantes']}}</td>
                <td>{{$recno['mujeres']}}</td>
                <td>{{$recno['hombres']}}</td>
                <td>{{$recno['nuevos']}}</td>
                <td>{{$recno['propios']}}</td>
            </tr>
        @endforeach
    </tbody>
    <tr></tr>
    <tr></tr>
    <thead>
        <tr>
            <th></th>
            <th colspan="8"><strong>RESUMEN MATRICULA - NIVEL DE ESTUDIO</strong></th>
        </tr>
    </thead>
    <thead>
        <tr>
            <th></th>
            <th><strong>Mes</strong></th>
            <th><strong>Estudiantes</strong></th>
            @foreach ($nivelestudio as $nivel)
                <th><strong>{{$nivel['descripcion']}}</strong></th>
            @endforeach
        </tr>
    </thead>
    <tbody class="list"> 
        @foreach ($resnivel as $recno)
            <tr>
                <td></td>
                <td>{{$meses[$recno['mes']]}}</td>
                <td>{{$recno['estudiantes']}}</td>
                @foreach ($nivelestudio as $row)
                    @if ($recno[$row['id']] ?? null)
                        <td>{{$recno[$row['id']]}}</td>
                    @else
                        <td>0</td>
                    @endif
                @endforeach
            </tr>
        @endforeach
    </tbody>
    
</table>
