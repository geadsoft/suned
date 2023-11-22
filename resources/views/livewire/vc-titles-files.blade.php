<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="orderList">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Listado de Estudiantes</h5>
                        <!--<div class="flex-shrink-0">
                            <a class="btn btn-success add-btn" href="/academic/student-enrollment"><i
                            class="ri-add-line me-1 align-bottom"></i> Agregar Matrícula</a>
                        </div>-->
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form>
                        <div class="row mb-3">
                            <div class="col-xxl-5 col-sm-6">
                                <div class="search-box">
                                    <input type="text" class="form-control search"
                                        placeholder="Buscar por nombre o apellidos" wire:model="filters.srv_nombre">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <select class="form-select" name="cmbgrupo" wire:model="filters.srv_grupo">
                                        <option value="">Seleccionar Grupo</option>
                                        @foreach ($tblgenerals as $general)
                                            @if ($general->superior == 1)
                                            <option value="{{$general->id}}">{{$general->descripcion}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <select class="form-select" name="cmbnivel" wire:model="filters.srv_periodo">
                                        <option value="">Seleccionar Periodo</option>
                                        @foreach ($tblperiodos as $periodo)
                                            <option value="{{$periodo->id}}">{{$periodo->descripcion}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-1 col-sm-4">
                                <div>
                                    <button type="button" class="btn btn-primary w-100" wire:click="deleteFilters()"> <i
                                            class="ri-delete-bin-5-line me-1 align-bottom"></i>
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
                        <ul class="nav nav-tabs nav-tabs-custom nav-success mb-3" role="tablist">
                        </ul>

                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle" id="orderTable">
                                <thead class="text-muted table-light">
                                    <tr class="text-uppercase">
                                        <th class="sort" data-sort="id"> Identificación</th>
                                        <th class="sort" data-sort="description">Nombres</th>
                                        
                                        <!--<th class="sort" data-sort="modality">Documento</th>
                                        <th class="sort" data-sort="level">Fecha</th>
                                        <th class="sort" data-sort="degree">Grupo</th>
                                        <th class="sort" data-sort="">Periodo</th>-->
                                        <th class="sort" data-sort="">Curso</th>
                                        <th class="sort" data-sort="">Paralelo</th>
                                        <th class="sort" data-sort="">Documentos</th>
                                        <th class="sort" data-sort="">Comentario</th>
                                        <th class="sort" data-sort="">Acción</th>
                                        
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                @foreach ($tblrecords as $record)    
                                    <tr>
                                        <td>{{$record->identificacion}}</td>
                                        <td>{{$record->apellidos}} {{$record->nombres}}</td> 
                                        <!--<td>{{$record->documento}}</td> 
                                        <td> {{date('d/m/Y',strtotime($record->fecha))}}</td> 
                                        <td>{{$record->nomgrupo}}</td>
                                        <td>{{$record->nomperiodo}}</td>-->
                                        <td>{{$record->nomgrado}}</td>
                                        <td>{{$record->paralelo}}</td>
                                        <td>
                                            <ul class="list-inline hstack gap-2 mb-0">
                                                <div class="form-check form-check-success">
                                                    <input class="form-check-input " type="checkbox" id="chktitulo">
                                                    <label class="form-check-label" for="chktitulo">Título</label>
                                                </div>
                                                <div class="form-check form-check-success">
                                                    <input class="form-check-input " type="checkbox" id="chkacta">
                                                    <label class="form-check-label" for="chkacta">Acta</label>
                                                </div>
                                            </ul>
                                        </td>
                                        <td></td>
                                        <td>
                                            <ul class="list-inline hstack gap-2 mb-0">
                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ri-more-fill"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="" wire:click.prevent=""><i class="ri-printer-fill align-bottom me-2 text-muted fs-16"></i> Comprobante </a></li>
                                                    <li><a class="dropdown-item" href="/academic/student-enrollment/{{$record->identificacion}}"><i class="ri-add-box-fill align-bottom me-2 text-muted fs-16"></i>Agregar Matrícula</a></li>
                                                    <li><a class="dropdown-item" href="" wire:click.prevent="edit({{ $record }})"><i class="ri-repeat-line align-bottom me-2 text-muted fs-16"></i>Cambiar Curso</a></li>
                                                    <li><a class="dropdown-item" href="/academic/person-edit/{{$record->id}}"><i class="ri-contacts-fill align-bottom me-2 text-muted fs-16"></i> Ficha del Estudiante </a></li>
                                                    <li><a class="dropdown-item" href="" wire:click.prevent="valoresPagar({{ $record }})"><i class="ri-hand-coin-fill align-bottom me-2 text-muted fs-16"></i> Valores a Pagar</a></li>

                                                    <li class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item" href="" data-bs-toggle="modal">
                                                    <i class=" ri-coins-fill align-bottom me-2 text-muted fs-16"></i>Detalle de Cobros</a></li>
                                                </ul>
                                                
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
                    
                    <div wire.ignore.self class="modal fade" id="showModalSection" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" >
                            <div class="modal-content modal-content border-0">
                                
                                <div class="modal-header p-3" style="background-color:#222454">
                                    <h5 class="modal-title" id="exampleModalLabel"  style="color: #D4D4DD">
                                        <span>Edit Section &nbsp;</span>
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                                </div>
                                <form autocomplete="off" wire:submit.prevent="updateData">
                                    
                                    <div class="modal-body">
                                        <div class="card-header">
                                            <h5 class="card-title flex-grow-1 mb-0 text-primary"><i
                                                class="ri-anticlockwise-fill align-middle me-1 text-success"></i>
                                                Current Section</h5>
                                        </div>
                                        <div class="mb-3">
                                            <br>
                                            <input type="text" class="form-control bg-white border-0 fw-semibold" name="txtnombre" value="{{$nomnivel}}" readonly/>
                                            <input type="text" class="form-control bg-white border-0 fw-semibold" name="txtnombre" value="{{$nomcurso}}" readonly/>
                                        </div>
                                        @livewire('vc-modal-sections')
                                    </div>
                                    <div class="modal-footer">
                                        <div class="hstack gap-2 justify-content-end">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-success" id="add-btn">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Valores a Pagar -->
                    <div wire.ignore.self class="modal fade" id="showModalValores" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" >
                            <div class="modal-content modal-content border-0">
                                
                                <div class="modal-header p-3" style="background-color:#222454">
                                    <h5 class="modal-title" id="exampleModalLabel"  style="color: #D4D4DD">
                                        <span>Valores a Pagar de: {{$alumno}} &nbsp;</span>
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" id="close-modal">
                                    
                                </div>
                                @livewire('vc-modal-valores')   
                                    
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div wire.ignore.self class="modal fade flip" id="showDelete" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body p-5 text-center">
                                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                        colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px">
                                    </lord-icon>
                                    <div class="mt-4 text-center">
                                        <h4>¿Seguro de eliminar matricula No.? {{$documento}}</h4>
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
                    <!--end delete modal -->

                </div>
            </div>

        </div>
        <!--end col-->
    </div>
    <!--end row-->

</div>

