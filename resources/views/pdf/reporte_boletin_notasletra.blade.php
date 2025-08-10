<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acta de Calificaciones</title>
    <style>
        table {
            border-collapse: collapse; /* Une los bordes */
            width: 100%;
            font-size:10px;
        }

        table th, table td {
            padding: 4px 6px;
        }
    </style>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    
    <section class="header" style ="top: -287px;">
        <table cellpadding="0" cellspancing="0" width="100%">
        </table>
        <br>
    </section>
    
    @foreach ($tblpersons as $index => $record)

        <section style ="margin-top: -110px;">
            <table cellpadding="0" cellspancing="0" class="table table-sm table-bordered">
                
                <tr><td colspan="10">
                    <!--<p class="text-end" style="margin: 0px;">Fecha: {{$fechaActual}}</p>
                    <p class="text-end" style="margin: 0px;">Hora: {{$horaActual}}</p>-->
                    <p class="text-center" style="margin: 0px; font-size: 12px;"><strong>UNIDAD EDUCATIVA AMERICAN SCHOOL - {{$datos['nivel']}}</strong></p>
                    <p class="text-center" style="margin: 0px; font-size: 12px;"><strong>ACTA DE CALIFICACIONES</strong></p>
                    <p class="text-center" style="margin: 0px; font-size: 12px;"><strong>{{$datos['subtitulo']}}</strong></p>
                    </td>
                </tr>
                <tr>
                    <td class="align-middle"><strong>NOMBRES DE ESTUDIANTE</strong></td>
                    <td class="align-middle" colspan="7">{{$record['apellidos']}} {{$record['nombres']}}</td>
                    <td class="align-middle"><strong>MATRICULA</strong></td>
                    <td class="align-middle text-right">{{$record['documento']}}</td>
                </tr>
                <tr>
                    <td class="align-middle"><strong>GRADO/CURSO</strong></td>
                    <td class="align-middler" colspan="7">{{$datos['curso']}}</td>
                    <td class="align-middler" colspan="2"></td>
                </tr>
                <tr>
                    <th class="align-middle text-center" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2; background-color: #cedff8ff;" rowspan="2">ASIGNATURA</th>
                    <th class="align-middle text-center" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2; background-color: #cedff8ff;" colspan="3">PARCIAL</th>
                    <th class="align-middle text-center" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2; background-color: #cedff8ff;" rowspan="2">PROMEDIO PARCIALES</th>
                    <th class="align-middle text-center" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2; background-color: #cedff8ff;" rowspan="2">{{$notaParcial}}%</th>
                    <th class="align-middle text-center" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2; background-color: #cedff8ff;" rowspan="2">EVALUACIÓN</th>
                    <th class="align-middle text-center" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2; background-color: #cedff8ff;" rowspan="2">{{$notaExamen}}%</th>
                    <th class="align-middle text-center" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2; background-color: #cedff8ff; width:180px;" rowspan="2">PROMEDIO CUANTITATIVO</th>
                    <th class="align-middle text-center" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2; background-color: #cedff8ff; width:180px;" rowspan="2">PROMEDIO CUALITATIVO</th>
                </tr>
                <tr>
                    <th class="align-middle text-center" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2; background-color: #cedff8ff;">Actividad Individual</th>
                    <th class="align-middle text-center" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2; background-color: #cedff8ff;">Actividad Grupal</th>
                    <th class="align-middle text-center" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2; background-color: #cedff8ff;">Promedio</th>
                </tr>        
                <tbody>  
                    @foreach ($asignaturas as $col)                   
                    <tr id="{{$record->id}}-{{$col->id}}">
                        <td style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;" class="align-middle">{{$tblrecords[$record->id][$col->id]['nombres']}}</td>
                        @if (isset($tblrecords[$record->id][$col->id]['AI-prom']))
                            <td class="text-center align-middle" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;">{{$tblrecords[$record->id][$col->id]['AI-prom']}}</td>
                        @else
                            <td class="text-center align-middle" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;"></td>
                        @endif
                        @if (isset($tblrecords[$record->id][$col->id]['AG-prom']))
                            <td class="text-center align-middle" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;">{{$tblrecords[$record->id][$col->id]['AG-prom']}}</td>
                        @else
                            <td class="text-center align-middle" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;"></td>
                        @endif
                        <td class="text-center align-middle" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;"><strong>{{$tblrecords[$record->id][$col->id]['promedio']}}</strong></td>
                        <td class="text-center align-middle" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;">{{$tblrecords[$record->id][$col->id]['promedio']}}</td>
                        <td class="text-center align-middle" style="width:50px; border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;">{{number_format($tblrecords[$record->id][$col->id]['nota70'],2)}}</td>
                        <td class="text-center align-middle" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;">{{$tblrecords[$record->id][$col->id]['examen']}}</td>
                        <td class="text-center align-middle" style="width:50px; border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;">{{number_format($tblrecords[$record->id][$col->id]['nota30'],2)}}</td>
                        <td class="text-center align-middle" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;"><strong>{{$tblrecords[$record->id][$col->id]['cuantitativo']}}</strong></td>
                        <td class="text-center align-middle" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;"><strong>{{$tblrecords[$record->id][$col->id]['cualitativo']}}</strong></td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="5" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;">
                            <table cellpadding="0" cellspancing="0" class="table table-sm table-bordered">
                                <tr>
                                    <td style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2; background-color: #cedff8ff;"><strong>Faltas Justificadas</strong></td>
                                    <td style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;">{{$faltas[$record->id]['fjustificada']}}</td>
                                    <td style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2; background-color: #cedff8ff;"><strong>Faltas Injustificadas</strong></td>
                                    <td style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;">{{$faltas[$record->id]['faltas']}}</td>
                                    <td style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2; background-color: #cedff8ff;"><strong>Total Faltas</strong></td>
                                    <td style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;">{{$faltas[$record->id]['total']}}</td>
                                </tr>
                                <tr>
                                    <td colspan="6" class="text-center" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2; background-color: #cedff8ff;"><strong>Observaciones</strong></td>
                                </tr>
                                <tr>
                                    @if(isset($arrComentario[$record->id]['comentario']))
                                    <td colspan="6" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;">{{$arrComentario[$record->id]['comentario']}}</td>
                                    @else
                                    <td colspan="6" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;"></td>
                                    @endif 
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-center" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2; background-color: #cedff8ff;"><strong>Firma de Profesor Tutor</strong></td>
                                    <td colspan="3" class="text-center" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2; background-color: #cedff8ff;"><strong>Firma de Secretaria General</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;"><br></td>
                                    <td colspan="3" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;"><br></td>
                                </tr>
                            </table>
                        </td>
                        <td colspan="5" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;">
                            <table cellpadding="0" cellspancing="0" class="table table-sm table-bordered">
                                <tr>
                                    <td colspan="6" class="text-center" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2; background-color: #cedff8ff;"> <strong>ESCALA DE CALIFICACIONES</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-center" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;"> <strong>BÁSICAS</strong></td>
                                    <td colspan="3" class="text-center" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;"> <strong>EXTRACURRICULAR</strong></td>
                                </tr>
                                @foreach ($arrescala as $escala) 
                                <tr>
                                    <td class="text-center align-middle" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2; width:50px;">{{$escala['rango']}}</td>
                                    <td class="text-center align-middle" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;"><strong>{{$escala['codigo']}}</strong></td>
                                    <td style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;" class="align-middle">{{$escala['desc']}}</td>
                                    <td style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2; width:50px;" class="align-middle" >{{$escala['rango2']}}</td>
                                    <td style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;" class="align-middle"><strong>{{$escala['codigo2']}}</td>
                                    <td style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;" class="align-middle">{{$escala['desc2']}}</td>
                                </tr>
                                @endforeach
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        
        </section>

        @if($index !== count($tblpersons) - 1)
            <div style="page-break-before: always;"></div>
        @endif

    @endforeach

    <!--<div style="position: absolute;
      display: inline-block;
      bottom: 0;
      width: 100%;
      height: 30px;">
        <footer>
            <table cellpadding="0" cellspacing="0" class="table table-nowrap align-middle" width="100%">
                <tr style="font-size:10px">
                    <td width="40%">
                        <span>SAMS | School and Administrative Management System</span>
                    </td>
                    <td width="40%" class="text-left">
                        Usuario:<span> {{auth()->user()->name}} </span>
                    </td>
                </tr>
            </table>
        </footer>
    </div>-->

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script type="text/php">
        if ( isset($pdf) ) {
            $pdf->page_script('
                $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                $pdf->text(510, 797, "Pág $PAGE_NUM de $PAGE_COUNT", $font, 8);
            ');
        }
	</script>

</body>
</html>
