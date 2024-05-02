
<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="orderList">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Movimientos por Transacción</h5>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form>
                        <div class="row g-3">
                            <div class="col-xxl-4 col-sm-4">
                                <div class="search-box">
                                    <input type="text" class="form-control search"
                                        placeholder="Buscar por nombre o apellidos" wire:model="filters.referencia">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-2 col-sm-2">
                                <div>
                                    <select class="form-select" name="cmbgrupo" wire:model="filters.movimiento">
                                        @foreach ($movimiento as $data)
                                            <option value="{{$data['codigo']}}">{{$data['nombre']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xxl-2 col-sm-2">
                                <div class="">
                                        <input type="date" class="form-control" id="fechaini" data-provider="flatpickr" data-date-format="d-m-Y" data-time="true" wire:model="filters.fechaini"> 
                                </div>
                            </div>
                            <div class="col-xxl-2 col-sm-2">
                                <div class="">
                                        <input type="date" class="form-control" id="fechafin" data-provider="flatpickr" data-date-format="d-m-Y" data-time="true" wire:model="filters.fechafin"> 
                                </div>
                            </div>
                            <div class="col-md-auto ms-auto">
                                <div class="hstack text-nowrap gap-2">
                                    <a href="/preview-pdf/detail-products/{{$datos}}" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" target="_blank"><i class="ri-printer-fill fs-22 align-bottom fs-22"></i></a>
                                    <a href="/download-pdf/detail-products/{{$datos}}" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"><i class="ri-download-2-line fs-22 align-bottom fs-22"></i></a>
                                    <a href="" wire:click.prevent="" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"><i class="ri-file-excel-2-line align-bottom fs-22"></i></a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-card mb-1">
                        <table class="table table-nowrap align-middle" id="orderTable">
                            <thead class="text-muted table-light">
                                <tr class="text-uppercase">
                                    <th style="width: 150px;">Fecha</th>
                                    <th>Referencia</th>
                                    <th style="width: 400px;">Producto</th>
                                    <th class="text-end" style="width: 150px;">Talla</th>
                                    <th class="text-end" style="width: 200px;">Precio</th>
                                    <th class="text-end" style="width: 150px;">Cantidad</th>
                                    <th style="width: 200px;">Forma Pago</th>
                                    <th class="text-end" style="width: 150px;">Monto</th>
                                </tr>
                            </thead>
                            <tbody class="list form-check-all">
                            @foreach ($invtra as $record)
                                <tr>
                                    <td>{{date('d/m/Y',strtotime($record['fecha']))}}</td>
                                    <td>{{$record['referencia']}}</td>
                                    <td>{{$record['nombre']}}</td>
                                    <td class="text-end">{{$record['talla']}}</td>
                                    <td class="text-end">{{number_format($record['precio'],2)}}</td>
                                    <td class="text-end">{{number_format($record['cantidad'],2)}}</td>
                                    <td>{{$fpago[$record['tipopago']]}}</td>
                                    <td class="text-end">{{number_format($record['total'],2)}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{$invtra->links('')}}
                        
                </div>
            </div>

        </div>
        <!--end col-->
    </div>
    <!--end row-->
</div>
