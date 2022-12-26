<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel 8 PDF</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <div class="row">
        <div class="col-xxl-12">
            <div class="card">
                <div class="card-body p-4" wire.ignore.self>
                    <div class="tab-content">
                        <div class="row">
                            <div class="col-md-8">
                                <h2>Cuadre de caja</h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="flex-shrink-0 mt-sm-0 mt-3">
                                <h6><span class="text-muted fw-normal">Fecha:</span><span>{{$filter['srv_fecha']}}</span></h6>
                                <h6><span class="text-muted fw-normal">Grupo:</span><span>{{$filter['srv_grupo']}}</span></h6>
                                <h6><span class="text-muted fw-normal">Periodo:</span><span>{{$filter['srv_periodo']}}</span></h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-nowrap align-middle" style="font-size:10px">
                                    <thead class="text-muted table-light">
                                        <tr>
                                            <th>Recibo</th>
                                            <th>Alumno</th>
                                            <th>Curso</th>
                                            <th>Concepto</th>
                                            <th>F.P.</th>
                                            <th>Valor</th>
                                            <th>Desc.</th>
                                            <th>Canc.</th>
                                            <th>Usuario</th>
                                        </tr>
                                    <thead>
                                    <tbody class="list">
                                    @foreach ($tblrecords as $record)    
                                        <tr>
                                            <td class="">{{$record->documento}}</td>
                                            <td>{{$record->apellidos}} {{$record->nombres}}</td> 
                                            <td>{{$record->descripcion}} {{$record->paralelo}}</td> 
                                            <td>{{$record->detalle}}</td>
                                            <td>{{$record->tipopago}}</td>
                                            <td>{{$record->saldo + $record->credito}}</td>
                                            <td>{{$record->descuento}}</td>
                                            <td>{{$record->pago}}</td>
                                            <td>{{$record->usuario}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                            
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <h6>Totales</h6>
                                </div>
                                <table class="table table-nowrap align-middle" style="font-size:10px">
                                     <tbody class="list">
                                        @foreach ($total as $record)
                                        <tr>
                                            <td> {{$record['detalle']}} </td>
                                            <td>{{$record['valor']}}</td>
                                        </tr>
                                         @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>



                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
