<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="paymentList">
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form>
                        <div class="row g-3">
                            <div class="col-xxl-2 col-sm-2">
                                
                                <div class="">
                                        <input type="date" class="form-control" id="fechaActual" data-provider="flatpickr" data-date-format="d-m-Y" data-time="true" wire:model="startDate"> 
                                </div>
                            </div>
                            <div class="col-xxl-2 col-sm-2">
                                
                                <div class="">
                                        <input type="date" class="form-control" id="fechaActual" data-provider="flatpickr" data-date-format="d-m-Y" data-time="true" wire:model="endDate"> 
                                </div>
                            </div>
                            <div class="col-xxl-2 col-sm-2">
                                
                                <button type="button" class="btn btn-primary w-100" wire:click=""><i
                                        class="me-1 align-bottom"></i>Consultar
                                </button>
                            </div>
                            <div class="col-md-auto ms-auto">
                                <!--<div class="hstack text-nowrap gap-2">
                                    <a href="/download-pdf/" class="btn btn-success"><i class="ri-download-2-line align-bottom me-1"></i>Download PDF</a>
                                    <a href="/liveWire-pdf/" class="btn btn-danger" target="_blank"><i class="ri-printer-fill align-bottom me-1"></i> Print</a>
                                </div>-->
                                <div class="hstack text-nowrap gap-2">
                                    <a href="/preview-pdf/report-utilitys/{{$datos}}" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" target="_blank"><i class="ri-printer-fill fs-22 align-bottom fs-22"></i></a>
                                    <a href="/download-pdf/report-utilitys/{{$datos}}" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"><i class="ri-download-2-line fs-22 align-bottom fs-22"></i></a>
                                    <a href="" wire:click.prevent="" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"><i class="ri-file-excel-2-line align-bottom fs-22"></i></a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body pt-0">
                    <!--<div>
                        <ul class="nav nav-tabs nav-tabs-custom nav-success mb-3" role="tablist">
                        </ul>
                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle" id="orderTable">
                                <thead class="text-muted table-light">
                                    <tr class="text-uppercase">
                                        <th class="sort" data-sort="id">Descripción</th>
                                        <th class="sort" data-sort="description">Monto</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                @foreach ($tblrecords as $record)    
                                    <tr>
                                        <td>{{$record->documento}}</td>
                                        <td>{{$record->apellidos}} {{$record->nombres}}</td> 
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>-->
                    <div class="row">
                        <div class="card-header align-items-center d-flex mb-1">
                            <h3 class="card-title mb-0 flex-grow-1 fs-13">Productos más vendidos, ordenado por unidades vendidas</h4>
                        </div>
                        <body onload="">
                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="w-100">
                                            <div class="table-responsive mb-3">
                                                <table class="table table-borderless table-sm align-middle mb-0" id="tbl1">
                                                    <thead class="text-muted table-light">
                                                        <tr class="text-uppercase">
                                                            <th data-sort="id">Producto</th>
                                                            <th data-sort="id">Cantidad Vendida</th>
                                                            <th data-sort="description">Monto Vendido</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="list form-check-all">
                                                    @if ($tblUnd != '')
                                                    @foreach ($tblUnd as $key => $record)    
                                                        <tr>
                                                            <td>{{$record['nombre']}}</td>
                                                            <td>{{$record['cantidad']}}</td>
                                                            <td>{{$record['valor']}}</td> 
                                                        </tr>
                                                    @endforeach
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="w-100">
                                            <figure class="highcharts-figure">
    <div id="container1"></div>
    <p class="highcharts-description">
        Bar chart showing horizontal columns. This chart type is often
        beneficial for smaller screens, as the user can scroll through the data
        vertically, and axis labels are easy to read.
    </p>
</figure>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </body>
                    </div>
                    <div class="row">
                        <div class="card-header align-items-center d-flex mb-1">
                            <h4 class="card-title mb-0 flex-grow-1">Productos más vendidos, ordenado por monto de venta</h4>
                        </div>
                        <body onload="">
                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="w-100">
                                            <div class="table-responsive mb-3">
                                                <table class="table table-borderless table-sm align-middle mb-0" id="tbl1">
                                                    <thead class="text-muted table-light">
                                                        <tr class="text-uppercase">
                                                            <th data-sort="id">Producto</th>
                                                            <th data-sort="id">Cantidad Vendida</th>
                                                            <th data-sort="description">Monto Vendido</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="list form-check-all">
                                                    @if ($tblMonto != '')
                                                    @foreach ($tblMonto as $key => $record)    
                                                        <tr>
                                                            <td>{{$record['nombre']}}</td>
                                                            <td>{{$record['cantidad']}}</td>
                                                            <td>{{$record['valor']}}</td> 
                                                        </tr>
                                                    @endforeach
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="w-100">
                                            <div id="container2"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </body>
                    </div>
                    <div class="row">
                        <div class="card-header align-items-center d-flex mb-1">
                            <h4 class="card-title mb-0 flex-grow-1">Productos más vendidos, ordenado por cantidad de venta</h4>
                        </div>
                        <body onload="">
                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="w-100">
                                            <div class="table-responsive mb-3">
                                                <table class="table table-borderless table-sm align-middle mb-0" id="tbl1">
                                                    <thead class="text-muted table-light">
                                                        <tr class="text-uppercase">
                                                            <th data-sort="id">Producto</th>
                                                            <th data-sort="id">Cantidad Ventas</th>
                                                            <th data-sort="description">Monto Vendido</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="list form-check-all">
                                                    @if ($tblCant != '')
                                                    @foreach ($tblCant as $key => $record)    
                                                        <tr>
                                                            <td>{{$record['nombre']}}</td>
                                                            <td>{{$record['cantidad']}}</td>
                                                            <td>{{$record['valor']}}</td> 
                                                        </tr>
                                                    @endforeach
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="w-100">
                                            <div id="container3"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </body>
                    </div>
                    
                </div>
            </div>

        </div>
        <!--end col-->
    </div>
    <!--end row-->

</div>
