<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estado de Cuenta</title>


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <section class="header" style ="top: -287px;">
        <table cellpadding="0" cellspancing="0" width="100%">
            <!--<tr>
                <td colspan="2" class="text-center">
                    <span style="font-size: 18px; font-weight: bold;">Unidad Educativa American Schooll</span>
                </td>
            <tr>-->
            <tr>
                <td width="30%" style="vertical-align: top; padding-top: 10px; position: relative">
                    <img src="../public/assets/images/AmericanSchooll.jpg" width="200px" height="60px">                  
                </td>
                <td width="70%" class="text-center" style="vertical-align: top; padding-top: 10px">
                    <span style="font-size: 16px"><strong>Estado de Cuenta</strong></span>
                    <div class="mb-3">
                    </div>
                    <table width="100%" cellpadding="0" cellspancing="0">
                        <tr>
                            <td class="text-left text-muted"><span style="font-size: 12px"><strong>Fecha: {{date('d/m/Y',strtotime($data['fecha']))}}</strong></span></td>
                        </tr>
                        <tr>
                            <td class="text-left text-muted"><span style="font-size: 12px"><strong>Estudiante: {{$data['nombre']}}</strong></span></td>
                        </tr>
                        <tr>
                            <td class="text-left text-muted"><span style="font-size: 12px"><strong>Curso: {{$data['curso']}}</strong></span></td>
                        </tr>
                        <tr>
                            <td class="text-left text-muted"><span style="font-size: 12px"><strong>Grupo: {{$data['grupo']}}/{{$data['periodo']}}</strong></span></td>
                        </tr>
                        
                    </table>
                </td>           
            <tr>
        </table>
        <br>
    </section>

    <section class="header" style ="top: -287px;">
    </section>

    <section style ="margin-top: -110px;">
        <table cellpadding="0" cellspacing="0" class="table table-sm" style="font-size:10px">
            <thead class="table-light" style="background-color:#222454">
                <tr>
                    <th style="color:#FFFFFF">Fecha</th>
                    <th style="color:#FFFFFF">Concepto</th>
                    <th style="color:#FFFFFF">Tipo/Documento</th>
                    <th class="text-right" style="color:#FFFFFF" >Neto</th>
                    <th class="text-right" style="color:#FFFFFF">Debe</th>
                    <th class="text-right" style="color:#FFFFFF">Haber</th>
                    <th class="text-right" style="color:#FFFFFF">Saldo</th>
                </tr>
            <thead>
            <tbody class="list">
            @foreach ($tblrecords as $record)    
                <tr>
                    <td> {{$record['fecha']}} </td>
                    <td> {{$record['concepto']}} </td>
                    <td> {{$record['tipo']}} {{$record['documento']}}</td>
                    <td class="text-right"> {{number_format($record['neto'],2)}} </td>
                    <td class="text-right"> {{number_format($record['debe'],2)}} </td>
                    <td class="text-right"> {{number_format($record['haber'],2)}} </td>
                    <td class="text-right"> {{number_format($record['saldo'],2)}} </td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2"></td>
                    <td class="text-center">
                        <span><b>TOTALES<b></span>
                    </td> 
                    <td class="text-right">
                        <span><b>{{number_format($arrtotal['totneto'],2)}}<b></span>
                    </td>
                    <td class="text-right">
                        <span><b>{{number_format($arrtotal['totaldb'],2)}}<b></span>
                    </td>
                    <td class="text-right">
                        <span><b>{{number_format($arrtotal['totalcr'],2)}}<b></span>
                    </td> 
                    <td class="text-right">
                        <span><b>{{number_format($arrtotal['totalsa'],2)}}<b></span>
                    </td>                     
                </tr>
            </tfoot>
        </table>
    </section>
    <div style="position: absolute;
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
                    <td width="30%" class="text-center">
                        Usuario:<span> {{auth()->user()->name}} </span>
                    </td>
                    <td width="30%" class="text-center">
                        Página <span class="pagenum"></span>
                    </td>
                </tr>
            </table>
        </footer>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
