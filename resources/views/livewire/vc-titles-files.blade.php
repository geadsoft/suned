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
                                            class="ri-delete-bin-2-line me-1 align-bottom"></i>
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
                                                
                                                    @if ($record->titulo==true)
                                                        <span class="badge badge-soft-info text-uppercase">Título</span>
                                                        <!--<input class="form-check-input " type="checkbox" id="chktitulo-{{$record->id}}" checked>
                                                        <input class="form-check-input " type="checkbox" id="chktitulo-{{$record->id}}">-->
                                                    @endif
                                                
                                                
                                                    @if ($record->acta==true)
                                                        <span class="badge badge-soft-info text-uppercase">Acta</span>
                                                        <!--<input class="form-check-input " type="checkbox" id="chktitulo-{{$record->id}}" checked>
                                                        <input class="form-check-input " type="checkbox" id="chktitulo-{{$record->id}}">-->
                                                    @endif
                                                
                                            </ul>
                                        </td>
                                        <td>{{$record->comentario}}</td>
                                        <td>
                                            <ul class="list-inline hstack gap-2 mb-0">
                                                <li class="list-inline-item edit" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                                    <a href="" wire:click.prevent="edit({{ $record->id }})">
                                                        <i class="ri-chat-new-line fs-16"></i>
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
                    
                    <div wire.ignore.self class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" >
                            <div class="modal-content">
                                
                                <div class="modal-header bg-light p-3">
                                    <h5 class="modal-title" id="exampleModalLabel">
                                        <span>Documentos a Retirar &nbsp;</span>
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                                </div>
                                <form autocomplete="off" wire:submit.prevent="createData">
                                    
                                    <div class="modal-body">                                     
                                        <div class="mb-3">
                                            <label for="alumno" class="form-label">Estudiante</label>
                                            <input type="text" wire:model.defer="alumno" class="form-control" name="alumno" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="alumno" class="form-label">Fecha</label>
                                            <input type="date" class="form-control" id="fechaActual" data-provider="flatpickr" data-date-format="d-m-Y" data-time="true" wire:model.defer="fecha"> 
                                        </div>
                                        <div class="mb-3">
                                            <ul class="list-inline hstack gap-2 mb-0">
                                                <label for="documento" class="form-label">Documentos:</label>
                                                <div class="form-check form-check-success">
                                                    <input class="form-check-input " type="checkbox" id="chk1" wire:model.defer="titulo"> 
                                                    <label class="form-check-label" for="chk1">Título</label>
                                                </div>
                                                <div class="form-check form-check-success">
                                                    <input class="form-check-input " type="checkbox" id="chk2" wire:model.defer="acta">
                                                    <label class="form-check-label" for="chk2">Acta</label>
                                                </div>
                                            </ul>
                                        </div>
                                        <div class="mb-3">
                                            <label for="alumno" class="form-label">Comentario</label>
                                        </div>
                                        <div class="mb-3">    
                                            <textarea type="text" class="form-control" rows="3" id="txtcomentario" placeholder="Ingrese Comentario" wire:model.defer="comentario">
                                            </textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="hstack gap-2 justify-content-end">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-success" id="add-btn">Grabar Registro</button>
                                             
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

