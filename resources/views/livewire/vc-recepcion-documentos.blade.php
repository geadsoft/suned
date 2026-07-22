<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="orderList">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Recepción de Documentación</h5>
                        <div class="flex-shrink-0">
                            <a class="btn btn-success add-btn" href="/secretary/register-documentation" target="_blank"><i
                            class="ri-add-line me-1 align-bottom"></i> Registrar Expedientes</a>
                        </div>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form>
                        <div class="row mb-3">
                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <select class="form-select" name="cmbnivel" wire:model="filters.periodoId">
                                        <option value="">Seleccionar Periodo</option>
                                        @foreach ($tblperiodos as $periodo)
                                            <option value="{{$periodo->id}}">{{$periodo->descripcion}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <select class="form-select" name="cmbgrupo" wire:model="filters.modalidadId">
                                        <option value="">Seleccionar Modalidad</option>
                                        @foreach ($modalidades as $modalidad)
                                            <option value="{{$modalidad->id}}">{{$modalidad->descripcion}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xxl-5 col-sm-6">
                                <div class="search-box">
                                    <input type="text" class="form-control search"
                                        placeholder="Buscar por nombre o apellidos" wire:model="filters.srv_nombre">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                        </div>
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
                                        <th class="sort" data-sort="description">Nombres</th>
                                        <th class="sort" data-sort="modality">Matricula</th>
                                        <th class="sort" data-sort="level">Fecha</th>
                                        <th class="sort" data-sort="degree">Curso</th>
                                        <th class="text-center" >N° Documentos</th>
                                        <th class="text-center">Doc. Completa</th>
                                        <th class="text-center">Doc. Retirada</th>
                                        <th class="text-center">Acción</th>                                      
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                @foreach ($tblrecords as $record)    
                                    <tr>
                                        <td>{{$record->estudiante}}</td>
                                        <td>{{$record->documento}}</td>
                                        <td>{{$record->fecha}}</td>
                                        <td>{{$record->curso}}</td>
                                        <td class="text-center">{{$record->detalles_count}}</td>
                                        <td class="text-center">
                                            @if($record->documentacion_completa) 
                                            <span class="badge badge-soft-success text-uppercase">Si</span>
                                            @else
                                            <span class="badge badge-soft-danger text-uppercase">No</span>
                                            @endif
                                        </td> 
                                        <td class="text-center">
                                            <span class="badge badge-soft-danger text-uppercase">No</span>
                                        </td> 
                                        <td class="text-center">
                                            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Eliminar">
                                                <a href="" class="text-danger"  wire:click.prevent="delete({{ $record->id }})">
                                                    <i class="ri-delete-bin-5-fill fs-16"></i>
                                                </a>
                                            </li>
                                            @if($record->detalles_count>0)
                                            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Imprimir">    
                                                <a href="javascript:void(0);" class="text-secondary"
                                                onclick="window.open('{{ route('expedientes.imprimir', $record->matricula_id) }}', '_blank')">
                                                    <i class="ri-printer-fill fs-16"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Retirar Documentos">    
                                                <a href="/secretary/documentation-deliver/{{$record->id}}" class="text-primary">
                                                    <i class="ri-stack-fill fs-16"></i>
                                                </a>
                                            </li>
                                            @endif
                                        <td>                                                                     
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

