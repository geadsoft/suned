<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="orderList">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Registros Periodos Lectivos</h5>
                        <div class="flex-shrink-0">
                            <button type="button" wire:click.prevent="add()" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn"
                                data-bs-target=""><i class="ri-add-line align-bottom me-1"></i> Crear Periodo
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form autocomplete="off" wire:submit.prevent="{{ 'createData' }}">
                        <div class="row g-3">
                            <div class="col-xxl-5 col-sm-6">
                                <div class="search-box">
                                    <input type="text" class="form-control search"
                                        placeholder="Buscar por descripcion del periodo....">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </form>
                </div>
                <div class="card-body pt-0">
                    <div>
                        <ul class="nav nav-tabs nav-tabs-custom nav-success mb-3" role="tablist">
                        </ul>
                        
                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle" id="orderTable">
                                <thead class="text-muted table-light">
                                    <tr class="text-uppercase">
                                        <th class="sort" data-sort="id"> ID</th>
                                        <th class="sort" data-sort="superior">Periodo</th>
                                        <th class="sort" data-sort="codigo">Descripcion</th>
                                        <th class="sort" data-sort="descripcion">Mes Pensión</th>
                                        <th class="sort" data-sort="descripcion">N° Recibo</th>
                                        <th class="sort" data-sort="descripcion">N° Matricula</th>
                                        <th class="sort" data-sort="estado">Status</th>
                                        <th class="sort" data-sort="accion">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                @foreach ($tblrecords as $record)    
                                    <tr>
                                        <td>{{$record->id}}</td>
                                        <td>{{$record->periodo}}</td>
                                        <td>{{$record->descripcion}}</td> 
                                        <td>{{$meses[$record->mes_pension]}}</td>
                                        <td>{{$record->num_recibo}}</td>
                                        <td>{{$record->num_matricula}}</td>
                                        <td class="status">
                                            @if($record->estado=='A')
                                                <span class="badge badge-soft-success text-uppercase">{{$estado[$record->estado]}}</span>
                                            @else
                                                <span class="badge badge-soft-secondary text-uppercase">{{$estado[$record->estado]}}</span>
                                            @endif
                                        </td>
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
                        </div>

                        {{$tblrecords->links('')}}

                    </div>

                    <div wire.ignore.self class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" >
                            <div class="modal-content">
                                
                                <div class="modal-header bg-light p-3">
                                    <h5 class="modal-title" id="exampleModalLabel">
                                        @if($showEditModal)
                                            <span>Editar Periodo Lectivo &nbsp;</span>
                                        @else
                                            <span>Agregar Periodo Lectivo &nbsp;</span>
                                        @endif
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                                </div>
                                <form autocomplete="off" wire:submit.prevent="{{ $showEditModal ? 'updateData' : 'createData' }}">
                                    
                                    <div class="modal-body">
                                        <fieldset {{$frmcontrol}}>
                                        
                                            <div class="id" id="modal-id">
                                                @if($showEditModal)
                                                    <label for="record.id" class="form-label">ID</label>
                                                    <input type="text" wire:model.defer="record.id" class="form-control" placeholder="ID" readonly />
                                                @endif
                                            </div>                                        
                                            <div class="mb-3">
                                                <label for="record.codigo" class="form-label">Periodo</label>
                                                @if($showEditModal)
                                                    <input type="text" class="form-control" id="periodo" placeholder="Ingrese periodo" wire:model.defer="record.periodo" readonly required>
                                                @else
                                                    <input type="text" class="form-control" id="periodo" placeholder="Ingrese periodo" wire:model.defer="record.periodo" required>
                                                @endif
                                            </div>
                                            <div class="mb-3">
                                                <label for="record.descripcion" class="form-label">Descripcion</label>
                                                <input type="text" wire:model.defer="record.descripcion" class="form-control" name="record.descripcion"
                                                    placeholder="Enter name" required />
                                            </div>
                                            <div class="mb-3">
                                                <label for="record.codigo" class="form-label">Mes Pensión</label>
                                                <select type="select" class="form-select" data-trigger name="record.periodo" wire:model.defer="record.mes_pension" required>
                                                    @for ($x=1; $x<=12 ; $x++)
                                                        <option value="{{$x}}">{{$meses[$x]}}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="date-field" class="form-label">Nº Recibo</label>
                                                <input type="text" class="form-control" id="txtrecibo" placeholder="Enter your Names" wire:model.defer="record.num_recibo" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label for="date-field" class="form-label">Nº Matricula</label>
                                                <input type="text" class="form-control" id="txtrecibo" placeholder="Enter your Names" wire:model.defer="record.num_matricula" readonly>
                                            </div>
                                            <div>
                                                <label for="record.estado" class="form-label">Status</label>
                                                    <select class="form-control" data-trigger name="record.estado" wire:model.defer="record.estado">
                                                    <option value="A">Active</option>
                                                    <option value="C">Cerrado</option>
                                                    <option value="I">Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                    <div class="modal-footer">
                                        <div class="hstack gap-2 justify-content-end">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-success" id="add-btn">Grabar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
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
                                        <h4>¿Seguro de eliminar registro No.? {{ $selectId }}, Periodo: {{$periodo}}</h4>
                                        <p class="text-muted fs-15 mb-4">Eliminar el registro afectará toda su 
                                        información de nuestra base de datos.</p>
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
