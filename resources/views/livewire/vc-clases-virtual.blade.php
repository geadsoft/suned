<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="orderList">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Historial Clases Virtuales</h5>
                        <div class="flex-shrink-0">
                            <button type="button" wire:click.prevent="add()" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn"
                                data-bs-target=""><i class="ri-add-line align-bottom me-1"></i> Nueva Clase Virtual
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form>
                        <div class="row g-3 mb-3">
                            <div class="col-xxl-3 col-sm-4">
                                <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false  wire:model="asignaturaId">
                                    <option value="">Seleccione Paralelo</option>
                                   @foreach ($tblasignatura as $materia) 
                                    <option value="{{$materia->id}}">{{$materia->descripcion}}</option>
                                    @endforeach 
                                </select>
                            </div>
                            <div class="col-xxl-3 col-sm-4">
                                <select class="form-select" id="paralelo-select" data-choices data-choices-search-false wire:model="filters.paralelo">
                                   <option value="">Seleccione Paralelo</option>
                                   @foreach ($tblparalelo as $paralelo) 
                                    <option value="{{$paralelo->id}}">{{$paralelo->descripcion}}</option>
                                    @endforeach 
                                </select>
                            </div>                            
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
                                        <th>Asignatura</th>
                                        <th>Curso</th>
                                        <th>Paralelo</th>
                                        <th colspan="2">Enlace</th>
                                        <th>Estado</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                @foreach ($tblrecords as $key => $record)
                                    <tr>
                                        <td>{{$record['asignatura']}}</td>
                                        <td>{{$record['curso']}}</td>
                                        <td>{{$record['aula']}}</td>
                                        <td>{{$record['enlace']}}</td>
                                        <td>
                                            @if ($record['estado']=='A')
                                                <a class="btn btn-secondary btn-sm" id="btn-{{$key}}" href="{{$record['enlace']}}" target="_blank" src="about:blank">Ir a la reunión <i class="fas fa-external-link-alt"></i></a></td>
                                            @endif
                                        <td> 
                                        @if ($record['estado']=='A')
                                            <span class="badge badge-soft-success text-uppercase">@lang('status.'.($record->estado))</span>
                                        @else
                                            <span class="badge badge-soft-warning text-uppercase">@lang('status.'.($record->estado))</span>
                                        @endif                                        
                                        </td>
                                        <td>
                                            <ul class="list-inline hstack gap-2 mb-0">                                        
                                                <li class="list-inline-item edit" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="Editar">
                                                    <a href="" wire:click.prevent="edit({{$record['id']}})" data-bs-toggle="modal"
                                                        class="text-secondary d-inline-block edit-item-btn">
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
                            <div class="noresult" style="{{$display}}">
                                <div class="text-center">
                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                        colors="primary:#405189,secondary:#0ab39c" style="width:75px;height:75px">
                                    </lord-icon>
                                    <h5 class="mt-2">¡Lo sentimos! No se encontraron resultados.</h5>
                                    <p class="text-muted">Hemos buscado según los filtros aplicados. No encontramos ninguno para su búsqueda</p>
                                </div>
                            </div>
                        </div>
                         {{$tblrecords->links('')}}
                        
                    </div>

                    <div wire.ignore.self class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-xl" >
                            <div class="modal-content">
                                
                                <div class="modal-header bg-light p-3">
                                    <h5 class="modal-title" id="exampleModalLabel">
                                        @if($showEditModal)
                                            <span>Editar Enlace &nbsp;</span>
                                        @else
                                            <span>Agregar Enlace &nbsp;</span>
                                        @endif
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                                </div>
                                <form autocomplete="off" wire:submit.prevent="{{ $showEditModal ? 'updateData' : 'createData' }}">
                                    <div class="card-header border-0">
                                        <div class="d-flex align-items-center">
                                            <h6 class="card-title mb-0 flex-grow-1 text-primary fw-semibold"><i
                                                        class="ri-video-chat-line align-middle me-1 text-primary fs-20"></i>Unirse a Clase Virtual</h5>
                                        </div>
                                    </div>
                                    <div class="modal-body card-body border border-dashed border-end-0 border-start-0">
                                        
                                        @livewire('vc-asignatura-cursos') 
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold" for="product-title-input">Enlace</label>
                                            <input type="text" class="form-control" id="product-title-input" value="" placeholder="Ingrese enlace externo" wire:model.defer="record.enlace" required>
                                            <div class="invalid-feedback">Por favor ingrese enlace externo.</div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="hstack gap-2 justify-content-end">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-success" id="add-btn">Grabar</button>
                                        </div>
                                    </div>
                                </form>
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

