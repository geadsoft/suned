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
                                <select class="form-select" name="cmbgrupo" wire:model="categoria">
                                    @foreach ($tblcategoria as $data)
                                        <option value="{{$data['id']}}">{{$data['descripcion']}}</option>
                                    @endforeach
                                    <option value="0">Seleccione Categoria</option>
                                </select>
                            </div>
                            <div class="col-xxl-2 col-sm-2">
                                <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false wire:model="talla">
                                    @foreach ($arrtalla as $key)
                                        <option value="{{$key}}">{{$key}}</option>
                                    @endforeach
                                    <option value="0">Seleccione Talla</option>
                                </select>
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
                            <h4 class="card-title mb-0 flex-grow-1">Las 5 Categoría mas vendidas</h4>
                        </div>
                        <body onload="loadGraphs_Utilidad({{$catMonto, $catCantidad, $catUtilidad, $prdMonto, $prdCantidad, $prdUtilidad}}">
                            <div class="col-xl-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="w-100">
                                            <label class="form-label">Por Monto</label>
                                            <div class="table-responsive mb-3">
                                                <table class="table table-borderless table-sm align-middle mb-0" id="tbl1">
                                                    <thead class="text-muted table-light">
                                                        <tr class="text-uppercase">
                                                            <th data-sort="id">Linea</th>
                                                            <th data-sort="id">Categoría</th>
                                                            <th data-sort="description">Monto</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="list form-check-all">
                                                    @if ($catMonto != '')
                                                    @foreach ($tblcatMonto as $key => $record)    
                                                        <tr>
                                                            <td>{{$key+1}}</td>
                                                            <td>{{$record['descripcion']}}</td>
                                                            <td>{{$record['valor']}}</td> 
                                                        </tr>
                                                    @endforeach
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div id="container1"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="w-100">
                                            <label class="form-label">Por Cantidad</label>
                                            <div class="table-responsive mb-3">
                                                <table class="table table-borderless table-sm align-middle mb-0" id="tbl1">
                                                    <thead class="text-muted table-light">
                                                        <tr class="text-uppercase">
                                                            <th data-sort="id">Linea</th>
                                                            <th data-sort="id">Categoría</th>
                                                            <th data-sort="description">Cantidad</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="list form-check-all">
                                                    @if ($catMonto != '')
                                                    @foreach ($tblcatCantidad as $key => $record)    
                                                        <tr>
                                                            <td>{{$key+1}}</td>
                                                            <td>{{$record['descripcion']}}</td>
                                                            <td>{{$record['valor']}}</td> 
                                                        </tr>
                                                    @endforeach
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div id="container2"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="w-100">
                                            <label class="form-label">Por Utilidad</label>
                                            <div class="table-responsive mb-3">
                                                <table class="table table-borderless table-sm align-middle mb-0" id="tbl1">
                                                    <thead class="text-muted table-light">
                                                        <tr class="text-uppercase">
                                                            <th data-sort="id">Linea</th>
                                                            <th data-sort="id">Categoría</th>
                                                            <th data-sort="description">Monto</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="list form-check-all">
                                                    @if ($catUtilidad != '')
                                                    @foreach ($tblcatUtilidad as $key => $record)    
                                                        <tr>
                                                            <td>{{$key+1}}</td>
                                                            <td>{{$record['descripcion']}}</td>
                                                            <td>{{$record['valor']}}</td> 
                                                        </tr>
                                                    @endforeach
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div id="container3"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </body>
                    </div>
                    <div class="row">
                        <div class="card-header align-items-center d-flex mb-1">
                            <h4 class="card-title mb-0 flex-grow-1">Los 5 Productos mas vendidos</h4>
                        </div>
                        <body onload="loadGraphs_Utilidad({{$catMonto, $catCantidad, $catUtilidad, $prdMonto, $prdCantidad, $prdUtilidad}}">
                            <div class="col-xl-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="w-100">
                                            <label class="form-label">Por Monto</label>
                                            <div class="table-responsive mb-3">
                                                <table class="table table-borderless table-sm align-middle mb-0" id="tbl1">
                                                    <thead class="text-muted table-light">
                                                        <tr class="text-uppercase">
                                                            <th data-sort="id">Linea</th>
                                                            <th data-sort="id">Categoría</th>
                                                            <th data-sort="description">Monto</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="list form-check-all">
                                                    @if ($prdMonto != '')
                                                    @foreach ($tblprdMonto as $key => $record)    
                                                        <tr>
                                                            <td>{{$key+1}}</td>
                                                            <td>{{$record['nombre']}}</td>
                                                            <td>{{$record['valor']}}</td> 
                                                        </tr>
                                                    @endforeach
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div id="container4"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="w-100">
                                            <label class="form-label">Por Cantidad</label>
                                            <div class="table-responsive mb-3">
                                                <table class="table table-borderless table-sm align-middle mb-0" id="tbl1">
                                                    <thead class="text-muted table-light">
                                                        <tr class="text-uppercase">
                                                            <th data-sort="id">Linea</th>
                                                            <th data-sort="id">Categoría</th>
                                                            <th data-sort="description">Cantidad</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="list form-check-all">
                                                    @if ($prdCantidad != '')
                                                    @foreach ($tblprdCantidad as $key => $record)    
                                                        <tr>
                                                            <td>{{$key+1}}</td>
                                                            <td>{{$record['nombre']}}</td>
                                                            <td>{{$record['valor']}}</td> 
                                                        </tr>
                                                    @endforeach
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div id="container5"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="w-100">
                                            <label class="form-label">Por Utilidad</label>
                                            <div class="table-responsive mb-3">
                                                <table class="table table-borderless table-sm align-middle mb-0" id="tbl1">
                                                    <thead class="text-muted table-light">
                                                        <tr class="text-uppercase">
                                                            <th data-sort="id">Linea</th>
                                                            <th data-sort="id">Categoría</th>
                                                            <th data-sort="description">Monto</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="list form-check-all">
                                                    @if ($prdUtilidad != '')
                                                    @foreach ($tblprdUtilidad as $key => $record)    
                                                        <tr>
                                                            <td>{{$key+1}}</td>
                                                            <td>{{$record['nombre']}}</td>
                                                            <td>{{$record['valor']}}</td> 
                                                        </tr>
                                                    @endforeach
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div id="container6"></div>
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
