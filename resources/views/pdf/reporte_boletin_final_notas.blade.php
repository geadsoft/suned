<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acta de Calificaciones Final</title>
    <style>
        @page {
            margin-left: 10px; /* Quitar margen izquierdo */
            margin-right: 10px; /* Opcional */
            margin-top: 25px;   /* Opcional */
        }
        body{
            margin: 0;
            padding: 0;
            font-size: 8px;
        }

        table {
            border-collapse: collapse; /* Une los bordes */
            width: 100%;
            font-size:8px;
            page-break-inside: avoid;
        }

        table th, table td {
            padding: 4px 6px;
        }

        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        .content {
            transform: scale(0.9);
            transform-origin: top left;
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
                
                <tr>
                    <td colspan="24">
                    <div class="col-4"><img class="img-fluid" style="position: absolute;top: 1%; left: 2%; width: 45%;height:60pt;" 
                    src="../public/assets/images/LogoReport.png" alt=""></div>
                    <p class="text-center" style="margin: 0px; font-size: 10px;"><strong>UNIDAD EDUCATIVA AMERICAN SCHOOL</strong></p>
                    <p class="text-center" style="margin: 0px; font-size: 10px;"><strong>Modalidad: {{$datos['nivel']}} </strong></p>
                    <p class="text-center" style="margin: 0px; font-size: 10px;"><strong>ACTA DE CALIFICACIONES FINAL</strong></p>
                    <p class="text-center" style="margin: 0px; font-size: 10px;"><strong>{{$datos['trimestre']}}</strong></p>
                    <p class="text-center" style="margin: 0px; font-size: 10px;"><strong>{{$datos['subtitulo']}}</strong></p>
                    </td>
                </tr>
                <tr>
                    <td class="align-middle" colspan="3"><strong>NOMBRES DE ESTUDIANTE</strong></td>
                    <td class="align-middle" colspan="19">{{$record['apellidos']}} {{$record['nombres']}}</td>
                    <td class="align-middle"><strong>MATRICULA</strong></td>
                    <td class="align-middle text-right">{{$record['documento']}}</td>
                </tr>
                <tr>
                    <td class="align-middle" colspan="3"><strong>GRADO/CURSO</strong></td>
                    <td class="align-middler" colspan="19">{{$datos['curso']}}</td>
                    <td class="align-middler" colspan="2"></td>
                </tr>
                <tr>
                    <th class="align-middle text-center" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2; background-color: #cedff8ff;" rowspan="2">ASIGNATURA</th>
                    <th class="align-middle text-center" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2; background-color: #d2d3d6ff;" colspan="6" >I TRIMESTRE</th>
                    <th class="align-middle text-center" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2; background-color: #d2d3d6ff;" colspan="6">II TRIMESTRE</th>
                    <th class="align-middle text-center" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2; background-color: #d2d3d6ff;" colspan="6">III TRIMESTRE</th>
                    <th class="align-middle text-center" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2; background-color: #cedff8ff; width:30px;" rowspan="2">PROMEDIO ANUAL</th>
                    <th class="align-middle text-center" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2; background-color: #cedff8ff; width:30px;" rowspan="2">EX. SUPLETORIO</th>
                    <th class="align-middle text-center" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2; background-color: #cedff8ff; width:30px;" rowspan="2">PROMEDIO FINAL</th>
                    <th class="align-middle text-center" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2; background-color: #cedff8ff; width:30px;" rowspan="2">PROM. CUALITATIVO</th>
                    <th class="align-middle text-center" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2; background-color: #cedff8ff; width:40px;" rowspan="2">PROMOCIÓN</th>
                </tr>
                <tr>
                    <th class="align-middle text-center" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2; background-color: #cedff8ff; width:15px;">1P</th>
                    <th class="align-middle text-center" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2; background-color: #cedff8ff; width:30px;">Promedio Paciales</th>
                    <th class="align-middle text-center" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2; background-color: #cedff8ff; width:15px;">{{$notaParcial}}%</th>
                    <th class="align-middle text-center" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2; background-color: #cedff8ff; width:30px;">Evaluación</th>
                    <th class="align-middle text-center" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2; background-color: #cedff8ff; width:15px;">{{$notaExamen}}%</th>
                    <th class="align-middle text-center" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2; background-color: #cedff8ff; width:30px;">Total Trimestre</th>

                    <th class="align-middle text-center" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2; background-color: #cedff8ff; width:15px;">1P</th>
                    <th class="align-middle text-center" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2; background-color: #cedff8ff; width:30px;">Promedio Paciales</th>
                    <th class="align-middle text-center" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2; background-color: #cedff8ff; width:15px;">{{$notaParcial}}%</th>
                    <th class="align-middle text-center" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2; background-color: #cedff8ff; width:30px;">Evaluación</th>
                    <th class="align-middle text-center" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2; background-color: #cedff8ff; width:15px;">{{$notaExamen}}%</th>
                    <th class="align-middle text-center" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2; background-color: #cedff8ff; width:30px;">Total Trimestre</th>

                    <th class="align-middle text-center" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2; background-color: #cedff8ff; width:15px;">1P</th>
                    <th class="align-middle text-center" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2; background-color: #cedff8ff; width:30px;">Promedio Paciales</th>
                    <th class="align-middle text-center" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2; background-color: #cedff8ff; width:15px;">{{$notaParcial}}%</th>
                    <th class="align-middle text-center" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2; background-color: #cedff8ff; width:30px;">Evaluación</th>
                    <th class="align-middle text-center" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2; background-color: #cedff8ff; width:15px;">{{$notaExamen}}%</th>
                    <th class="align-middle text-center" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2; background-color: #cedff8ff; width:30px;">Total Trimestre</th>
                    
                </tr>        
                <tbody>  
                    @foreach ($asignaturas as $col)                   
                    <tr id="{{$record->id}}-{{$col->id}}">
                        <td style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;" class="align-middle">{{$col->descripcion}}</td>
                        <!--@if (isset($tblrecords[$record->id][$col->id]['AI-prom']))
                            <td class="text-center align-middle" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;">{{number_format($tblrecords[$record->id][$col->id]['AI-prom'],2)}}</td>
                        @else
                            <td class="text-center align-middle" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;">0.00</td>
                        @endif
                        @if (isset($tblrecords[$record->id][$col->id]['AG-prom']))
                            <td class="text-center align-middle" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;">{{number_format($tblrecords[$record->id][$col->id]['AG-prom'],2)}}</td>
                        @else
                            <td class="text-center align-middle" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;">0.00</td>
                        @endif-->
                        <td class="text-center align-middle" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;"><strong>{{number_format($tblrecords[$record->id][$col->id]['1T_notaparcial'],2)}}</strong></td>
                        <td class="text-center align-middle" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;">{{number_format($tblrecords[$record->id][$col->id]['1T_notaparcial'],2)}}</td>
                        <td class="text-center align-middle" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;">{{number_format($tblrecords[$record->id][$col->id]['1T_nota70'],2)}}</td>
                        <td class="text-center align-middle" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;">{{number_format($tblrecords[$record->id][$col->id]['1T_evaluacion'],2)}}</td>
                        <td class="text-center align-middle" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;">{{number_format($tblrecords[$record->id][$col->id]['1T_nota30'],2)}}</td>
                        <td class="text-center align-middle" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;"><strong>{{number_format($tblrecords[$record->id][$col->id]['1T_notatrimestre'],2)}}</strong></td>
                        
                        <td class="text-center align-middle" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;"><strong>{{number_format($tblrecords[$record->id][$col->id]['2T_notaparcial'],2)}}</strong></td>
                        <td class="text-center align-middle" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;">{{number_format($tblrecords[$record->id][$col->id]['2T_notaparcial'],2)}}</td>
                        <td class="text-center align-middle" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;">{{number_format($tblrecords[$record->id][$col->id]['2T_nota70'],2)}}</td>
                        <td class="text-center align-middle" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;">{{number_format($tblrecords[$record->id][$col->id]['2T_evaluacion'],2)}}</td>
                        <td class="text-center align-middle" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;">{{number_format($tblrecords[$record->id][$col->id]['2T_nota30'],2)}}</td>
                        <td class="text-center align-middle" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;"><strong>{{number_format($tblrecords[$record->id][$col->id]['2T_notatrimestre'],2)}}</strong></td>

                        <td class="text-center align-middle" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;"><strong>{{number_format($tblrecords[$record->id][$col->id]['3T_notaparcial'],2)}}</strong></td>
                        <td class="text-center align-middle" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;">{{number_format($tblrecords[$record->id][$col->id]['3T_notaparcial'],2)}}</td>
                        <td class="text-center align-middle" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;">{{number_format($tblrecords[$record->id][$col->id]['3T_nota70'],2)}}</td>
                        <td class="text-center align-middle" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;">{{number_format($tblrecords[$record->id][$col->id]['3T_evaluacion'],2)}}</td>
                        <td class="text-center align-middle" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;">{{number_format($tblrecords[$record->id][$col->id]['3T_nota30'],2)}}</td>
                        <td class="text-center align-middle" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;"><strong>{{number_format($tblrecords[$record->id][$col->id]['3T_notatrimestre'],2)}}</strong></td>

                        <td class="text-center align-middle" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;"><strong>{{number_format($tblrecords[$record->id][$col->id]['promedio_anual'],2)}}</strong></td>
                        <td class="text-center align-middle" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;">{{number_format($tblrecords[$record->id][$col->id]['supletorio'],2)}}</td>
                        <td class="text-center align-middle" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;">{{number_format($tblrecords[$record->id][$col->id]['promedio_final'],2)}}</td>
                        <td class="text-center align-middle" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2; font-size: 9px;"><strong>{{$tblrecords[$record->id][$col->id]['promedio_cualitativo']}}</strong></td>
                        <td class="text-center align-middle" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2; font-size: 9px;"><strong>{{$tblrecords[$record->id][$col->id]['promocion']}}</strong></td>
                        
                    </tr>
                    @endforeach
                    
                    <tr id="{{$record->id}}-conduta">
                        <td style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;" class="align-middle"><strong>COMPORTAMIENTO</strong></td>
                        <td class="text-center align-middle" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;"></td>
                        <td class="text-center align-middle" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;"></td>
                        <td></td>
                        <td class="text-center align-middle" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;"></td>
                        <td class="text-center align-middle" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;"></td>
                        <td class="text-center align-middle" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;"><strong>{{$arrconducta[$record->id]['evaluacion']}}</td>
                        <td class="text-center align-middle" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="10" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;">
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
                                    <td style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2; background-color: #cedff8ff;"><strong>Atrasos Justificadas</strong></td>
                                    <td style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;">{{$faltas[$record->id]['ajustificada']}}</td>
                                    <td style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2; background-color: #cedff8ff;"><strong>Atrasos Injustificadas</strong></td>
                                    <td style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;">{{$faltas[$record->id]['atrasos']}}</td>
                                    <td style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2; background-color: #cedff8ff;"><strong>Total Atrasos</strong></td>
                                    <td style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;">{{$faltas[$record->id]['total_a']}}</td>
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
                        <td colspan="14" style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2;">
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
                                    <td style="border: 1px solid #ccc; padding: 2px 5px; line-height: 1.2; width:50px;" class="align-middle">{{$escala['rango2']}}</td>
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
