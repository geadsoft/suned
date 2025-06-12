<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="orderList">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Recursos</h5>
                        <div class="flex-shrink-0">
                            <a class="btn btn-success add-btn" href="/subject/resources-add"><i
                            class="ri-add-line align-bottom me-1"></i>Crear Recurso</a>
                        </div>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form>
                        <div class="row g-3 mb-3">
                            
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
                                        <th>Nombre</th>
                                        <th>Tipo</th>
                                        <th>Asignatura</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                @foreach ($tblrecords as $record)
                                    <tr>
                                        <td>{{$record['nombre']}}</td>
                                        <td>
                                            <div>
                                                            <i class="ri-youtube-line fs-18"></i><a class="text-muted">  </a>
                                                            </div>  
                                                            <div>
                                                            <i class="ri-attachment-2 fs-18"></i><a class="text-muted"> </a>
                                                            </div> 
                                        </td>
                                        <td>{{$record['descripcion']}}</td>
                                        <td>
                                            <ul class="list-inline hstack gap-2 mb-0">
                                                <li class="list-inline-item" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="Visualizar">
                                                    <a href="/activities/activity-view/{{$record['id']}}"
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
                
            </div>

        </div>
        <!--end col-->
        
    </div>
    <!--end row-->


</div>

