<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="orderList">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Registro de Examenes</h5>
                        <div class="flex-shrink-0">
                            <a class="btn btn-success add-btn" href="/activities/exam-add"><i
                            class="ri-add-line align-bottom me-1"></i>Crear Exámen</a>
                        </div>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form>
                        <div class="row g-3 mb-3">
                            <div class="col-xxl-2 col-sm-6">
                                <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false  wire:model="filters.modalidadId">
                                    @foreach ($tblmodalidad as $modalidad) 
                                    <option value="{{$modalidad->id}}">{{$modalidad->descripcion}}</option>
                                    @endforeach 
                                </select>
                            </div>
                            <div class="col-xxl-3 col-sm-6">
                                <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false  wire:model="filters.paralelo">
                                    <option value="">Seleccione Curso</option>
                                   @foreach ($tblparalelo as $paralelo) 
                                    <option value="{{$paralelo->id}}">{{$paralelo->descripcion}}</option>
                                    @endforeach 
                                </select>
                            </div>
                            
                            <div class="col-xxl-2 col-sm-6">
                                <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false  wire:model="filters.asignaturaId">
                                    <option value="">Seleccione Asignatura</option>
                                   @foreach ($tblasignaturas as $asignatura) 
                                    <option value="{{$asignatura->id}}">{{$asignatura->descripcion}}</option>
                                    @endforeach 
                                </select>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false wire:model="filters.termino">
                                        <option value="">Seleccione Termino</option>
                                        <option value="1T">Primer Trimestre</option>
                                        <option value="2T">Segundo Trimestre</option>
                                        <option value="3T">Tercer Trimestre</option>
                                    </select>
                                </div>
                            </div>
                            <!--end col-->
                            <!--<div class="col-xxl-2 col-sm-4">
                                <div>
                                    <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false wire:model="filters.bloque">
                                        <option value="">Seleccione Bloque</option>
                                        <option value="1P" selected>Primer Parcial</option>
                                    </select>
                                </div>
                            </div>-->
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
                        
                    </form>
                </div>
                <div class="card-body pt-0">
                    <div>
                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle" id="orderTable">
                                <thead class="text-muted table-light">
                                    <tr class="text-uppercase">
                                        <th>Curso</th>
                                        <th>Paralelo</th>
                                        <th>Asignatura</th>
                                        <th>Termino</th>
                                        <th>Exámen</th>
                                        <th>Fecha Creación</th>
                                        <th>Fecha Límite</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                @foreach ($tblrecords as $record)
                                    <tr>
                                        <td>{{$record['curso']}}</td>
                                        <td>{{$record['aula']}}</td>
                                        <td>{{$record['asignatura']}}</td>
                                        <td> {{$arrtermino[$record['termino']]}}</td>
                                        <td>{{$record['nombre']}}</td>
                                        <td>{{$record['fecha']}}</td>
                                        <td>{{$record['created_at']}}</td>
                                        <td>
                                            <ul class="list-inline hstack gap-2 mb-0">
                                                <li class="list-inline-item" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="Visualizar">
                                                    <a href="/activities/exam-view/{{$record['id']}}"
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
                                    <h4>Estás a punto de eliminar el registro ?</h4>
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

