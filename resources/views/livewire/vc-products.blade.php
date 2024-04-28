<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="orderList">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Catálogo Productos</h5>
                        <div class="flex-shrink-0">
                            <a class="btn btn-success add-btn" href="/inventary/products-add"><i
                            class="ri-add-line align-bottom me-1"></i>Crear Producto</a>
                        </div>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form autocomplete="off" wire:submit.prevent="{{ 'createData' }}">
                        <div class="row g-3">
                            <div class="col-xxl-2 col-sm-4">
                                <select class="form-select" data-choices data-choices-search-false
                                    name="choices-single-default" id="idtipo" wire:model="filters.tipo">
                                    <option value="B">Bien</option>
                                    <option value="S">Servicio</option>
                                </select>
                            </div>
                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <select class="form-select" data-choices data-choices-search-false
                                        name="choices-single-default" id="idcategoria" wire:model="filters.categoria">
                                        @foreach ($tblcategorias as $categoria)
                                            <option value="{{$categoria['id']}}">{{$categoria['descripcion']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <select class="form-select" id="idStatus" wire:model="filters.estado">
                                        <option value="A" selected>Activo</option>
                                        <option value="I">Inactivo</option>
                                    </select>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-1 col-sm-4">
                                <div>
                                    <button type="button" class="btn btn-primary w-100"> <i
                                            class="ri-equalizer-fill me-1 align-bottom"></i>
                                        Filters
                                    </button>
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </form>
                </div>
                <div class="card-body">
                    <div>
                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle" id="orderTable">
                                <thead class="text-muted table-light">
                                    <tr class="text-uppercase">
                                        <th class="sort" data-sort="id" style="width: 200px;"> Codigo</th>
                                        <th class="sort" data-sort="superior">Nombre</th>
                                        <th class="sort" data-sort="unidad" style="width: 200px;">Unidad</th>
                                        <th class="sort" data-sort="stock" style="width: 200px;">Stock</th>
                                        <th class="sort" data-sort="precio" style="width: 200px;">Precio</th>
                                        <th class="sort" data-sort="iva" style="width: 200px;">Tarifa Iva</th>
                                        <th class="sort" data-sort="accion" style="width: 150px;">Acción</th>                                        
                                    </tr>
                                </thead>
                                
                                <tbody class="list form-check-all">
                                @foreach ($tblrecords as $record)    
                                    <tr>
                                        <td>{{$record->codigo}}</td>
                                        <td>
                                            <div>{{$record->nombre}}</div>
                                            <div>
                                                @if ($record->estado=='A')
                                                <i class="ri-checkbox-circle-fill fs-16"></i><a class="text-muted">Activo</a>
                                                @else
                                                <i class="ri-close-circle-fill fs-16"></i>
                                                @endif
                                            </div>
                                        </td>
                                        <td>{{$unidad[$record->unidad]}}</td>
                                        <td><div>{{$record->stock}}</div><div> Min. {{$record->stock_min}}</div></td>
                                        <td>{{number_format($record->precio,2)}}</td> 
                                        <td>{{$iva[$record->tipo_iva]}}</td>
                                        <td>
                                            <ul class="list-inline hstack gap-2 mb-0">
                                                <li class="list-inline-item edit" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                                    <a href="" wire:click.prevent="edit({{ $record }})">
                                                        <i class="ri-pencil-fill fs-16"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                                    <a class="text-danger d-inline-block remove-item-btn"
                                                        data-bs-toggle="modal" href="" wire:click.prevent="delete({{ $record->id }})">
                                                        <i class="ri-delete-bin-5-fill fs-16"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{$tblrecords->links('')}}
                        </div>

                        

                    </div>

                    <!-- Modal -->
                    <div wire.ignore.self class="modal fade flip" id="deleteOrder" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body p-5 text-center">
                                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                        colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px">
                                    </lord-icon>
                                    <div class="mt-4 text-center">
                                        <h4>¿Seguro de inactivar Producto ?</h4>
                                        <h4>{{ $nombre }}</h4>
                                        <p class="text-muted fs-15 mb-4">Inactivar el registro afectará toda su 
                                        información de nuestra base de datos..</p>
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
                    <!--end modal -->
                </div>
            </div>

        </div>
        <!--end col-->
    </div>
    <!--end row-->

</div>
