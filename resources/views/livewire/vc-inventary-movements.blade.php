<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="orderList">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Movimientos de Inventario</h5>
                        <div class="flex-shrink-0">
                            <a class="btn btn-success add-btn" href="/inventary/register"><i
                            class="ri-add-line align-bottom me-1"></i>Nuevo Registro</a>
                        </div>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form>
                        <div class="row g-3 mb-3">
                            <div class="col-xxl-5 col-sm-6">
                                <div class="search-box">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control" id="producto" wire:model="filter.producto">
                                        <a id="btnstudents" class ="input-group-text btn btn-info" wire:click="search()"><i class="ri-search-line me-1"></i>Buscar</a>
                                    </div>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <select class="form-control" data-choices data-choices-search-false
                                        name="choices-single-default" id="idStatus">
                                        <option value="">Seleccione Movimiento</option>
                                        @if ($filters['tipo']=='ING')
                                            <option value="II">Inventario Inicial</option>
                                            <option value="CL">Compras Locales</option>
                                            <option value="IA">Ingreso por Ajuste</option>
                                            <option value="DE">Devolucion</option>
                                        @endif
                                        @if ($filters['tipo']=='EGR')
                                            <option value="VE">Ventas</option>
                                            <option value="EA">Egreso por Ajuste</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <select class="form-control" data-choices data-choices-search-false
                                        name="choices-single-default" id="idPayment">
                                        <option value="">Seleccione Estado</option>
                                        <option value="G">Grabado</option>
                                        <option value="P">Procesado</option>
                                        <option value="A">Anulado</option>
                                    </select>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-1 col-sm-4">
                                <div>
                                    <button type="button" class="btn btn-primary w-100" onclick="SearchData();"> <i
                                            class="ri-equalizer-fill me-1 align-bottom"></i>
                                        Filters
                                    </button>
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                        <div class="row g-3">
                            <div class="col-xxl-2 col-sm-4">
                                <div class="">
                                        <input type="date" class="form-control" id="fechaini" data-provider="flatpickr" data-date-format="d-m-Y" data-time="true" wire:model="filters.fechaini"> 
                                </div>
                            </div>
                            <div class="col-xxl-2 col-sm-4">
                                <div class="">
                                        <input type="date" class="form-control" id="fechafin" data-provider="flatpickr" data-date-format="d-m-Y" data-time="true" wire:model="filters.fechafin"> 
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body pt-0">
                    <div>
                        <ul class="nav nav-tabs nav-tabs-custom nav-success mb-3" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active All py-3" data-bs-toggle="tab" id="All" href="" wire:click="filterTab('')" role="tab"
                                    aria-selected="true">
                                    <i class="ri-store-2-fill me-1 align-bottom"></i> Todos
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link py-3 Delivered" data-bs-toggle="tab" id="Delivered" href="" wire:click="filterTab('ING')"
                                    role="tab" aria-selected="false">
                                    <i class="bx bx-log-out me-1 align-bottom fs-17"></i> Ingresos
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link py-3 Delivered" data-bs-toggle="tab" id="Delivered" href="" wire:click="filterTab('EGR')"
                                    role="tab" aria-selected="false">
                                    <i class="bx bx-log-in me-1 align-bottom fs-17"></i> Egresos
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link py-3 Pickups" data-bs-toggle="tab" id="Pickups" href="" wire:click="filterTab('G')"
                                    role="tab" aria-selected="false">
                                    <i class="bx bx-rotate-left me-1 align-bottom fs-17"></i> Por Procesar <span
                                        class="badge bg-danger align-middle ms-1">{{$registro}}</span>
                                </a>
                            </li>
                        </ul>

                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle" id="orderTable">
                                <thead class="text-muted table-light">
                                    <tr class="text-uppercase">
                                        <th class="sort" data-sort="fecha" style="width: 150px;">Fecha</th>
                                        <th class="sort" data-sort="documento" style="width: 250px;">Documento</th>
                                        <th class="sort" data-sort="referencia" style="width: 400px;">Referencia</th>
                                        <th class="sort" data-sort="descripcion">Descripcion</th>
                                        <th class="sort" data-sort="pago" style="width: 200px;">Pago</th>
                                        <th class="sort" data-sort="total" style="width: 150px;">Total</th>
                                        <th style="width: 180px;">Acción</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                @foreach ($tblrecords as $record)
                                    <tr>
                                        <td>{{date('d/m/Y',strtotime($record['fecha']))}}</td>
                                        <td>
                                            <div><a href="/inventary/register-edit/{{$record['id']}}"
                                                class="fw-medium link-primary">{{$record['tipo']}} {{$record['documento']}}</a><div>
                                            <div>
                                                @if($record['tipo']=='ING')
                                                <i class="bx bx-log-out fs-18"></i><a class="text-muted"> {{$tipo[$record['tipo']]}} - {{$movimiento[$record['movimiento']]}}</a>
                                                @else
                                                <i class="bx bx-log-in fs-18"></i><a class="text-muted"> {{$tipo[$record['tipo']]}} - {{$movimiento[$record['movimiento']]}}</a>
                                                @endif
                                            <div>
                                        </td>
                                        <td>{{$record['referencia']}}</td>
                                        <td>{{$record['descripcion']}}</td>
                                        <td>{{$fpago[$record['tipopago']]}}</td>
                                        <td>{{number_format($record['neto'],2)}}</td>
                                        
                                        <td>
                                            <ul class="list-inline hstack gap-2 mb-0">
                                                <li class="list-inline-item" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="Visualizar">
                                                    <a href="/inventary/register-edit/{{$record['id']}}"
                                                        class="text-warning d-inline-block">
                                                        <i class="ri-eye-fill fs-16"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item edit" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="Editar">
                                                    <a href="" wire:click.prevent="edit({{$record['id']}})" data-bs-toggle="modal"
                                                        class="text-secondary d-inline-block edit-item-btn">
                                                        <i class="ri-pencil-fill fs-16"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="Eliminar">
                                                    <a class="text-danger d-inline-block remove-item-btn"
                                                        data-bs-toggle="modal" href="" wire:click.prevent="delete({{ $record->id }})">
                                                        <i class="ri-delete-bin-5-fill fs-16"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="Procesar">
                                                    <a class="text-success d-inline-block remove-item-btn"
                                                        data-bs-toggle="modal" href="" wire:click.prevent="procesar({{$record['id']}})">
                                                        <i class="ri-checkbox-circle-fill fs-16"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="Imprimir">
                                                    <a class="text-primary" href="/preview-pdf/record-inv/{{$record['id']}}" target="_blank">
                                                        <i class="ri-printer-fill fs-16"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="noresult" style="display: none">
                                <div class="text-center">
                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                        colors="primary:#405189,secondary:#0ab39c" style="width:75px;height:75px">
                                    </lord-icon>
                                    <h5 class="mt-2">Sorry! No Result Found</h5>
                                    <p class="text-muted">We've searched more than 150+ Orders We did
                                        not find any
                                        orders for you search.</p>
                                </div>
                            </div>
                        </div>
                         {{$tblrecords->links('')}}
                        
                    </div>

                </div>
                <!-- Modal -->
                <div wire.ignore.self class="modal fade flip" id="deleteOrder" tabindex="-1" aria-hidden="true" wire:model='selectId'>
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body p-5 text-center">
                                <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                    colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px">
                                </lord-icon>
                                <div class="mt-4 text-center">
                                    <h4>Estás a punto de eliminar el registro ? {{ $documento }}</h4>
                                    <p class="text-muted fs-15 mb-4">Al eliminar el registro afectara al stock de productos y 
                                        se eliminará toda su información de nuestra base de datos. y</p>
                                    <div class="hstack gap-2 justify-content-center remove">
                                        <button class="btn btn-link link-success fw-medium text-decoration-none"
                                            data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i>
                                            Cerrar</button>
                                        <button class="btn btn-danger" id="delete-record"  wire:click="deleteData()"> Si,
                                            Eliminar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!--end col-->
        
    </div>
    <!--end row-->
</div>
