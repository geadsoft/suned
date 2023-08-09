<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Listado de Estudiantes</h5>
                        <div class="flex-shrink-0">
                        </div>
                    </div>
                </div>
            
        <!--end col-->
        <!--<div class="col-xxl-12">
            <div class="card" id="contactList">-->
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <div class="search-box">
                                <input type="text" class="form-control search"
                                    placeholder="Search for contact..." wire:model="filters.srv_nombre">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div>
                        <div class="table-responsive table-card mb-3">
                            <table class="table align-middle table-nowrap mb-0" id="customerTable">
                                <thead class="text-muted table-light">
                                    <tr class="text-uppercase">
                                        <th class="sort" data-sort="name" scope="col">Identificación</th>
                                        <th class="sort" data-sort="nombre" scope="col">Nombres</th>
                                        <th class="sort" data-sort="nace" scope="col">Fecha Nacimiento</th>
                                        <th class="sort" data-sort="telefono" scope="col">Telefono</th>
                                        <th class="sort" data-sort="email" scope="col">Email</th>
                                        <th class="sort" scope="col">Documentación</th>
                                        <th scope="col">Acción</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                @foreach ($tblrecords as $record)
                                    <tr>                                        
                                        <td>{{$record->identificacion}}</td>
                                        <td>{{$record->apellidos}} {{$record->nombres}}</td>
                                        <td>{{$record->fechanacimiento}}</td>
                                        <td>{{$record->telefono}}</td>
                                        <td>{{$record->email}}</td>
                                        <td><i class="me-1 align-bottom"></i> Registrada <span class="badge bg-success align-middle ms-1"> 0</span>
                                            <!--<i class="me-1 align-bottom"></i> Por Registrar <span class="badge bg-secondary align-middle ms-1">10</span>-->
                                        </td>
                                        <td>
                                            <ul class="list-inline hstack gap-2 mb-0">
                                                <li class="list-inline-item" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="Registrar Documentación">
                                                    <a href="" class="edit-item-btn" wire:click.prevent="add({{$record->id}})"><i
                                                            class="ri-folder-open-fill fs-18"></i></a>
                                                </li>
                                                <li class="list-inline-item" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="Retirar Documentación">
                                                    <a class="text-danger d-inline-block remove-item-btn" href=""><i
                                                            class="ri-folder-shared-fill fs-18"></i>
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
                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json"
                                        trigger="loop" colors="primary:#121331,secondary:#08a88a"
                                        style="width:75px;height:75px">
                                    </lord-icon>
                                    <h5 class="mt-2">Sorry! No Result Found</h5>
                                    <p class="text-muted mb-0">We've searched more than 150+ contacts We
                                        did not find any
                                        contacts for you search.</p>
                                </div>
                            </div>
                        </div>
                        {{$tblrecords->links('')}}
                    </div>
                    
                    <!-- Modal -->
                    <div wire.ignore.self class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-xl">
                            <div class="modal-content border-0">
                                <div class="modal-header p-3" style="background-color:#222454">
                                    <h5 class="modal-title" style="color: #D4D4DD" id="exampleModalLabel" >
                                        <span> Registrar Documentos &nbsp;</span>
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                                </div>
                                
                                <form autocomplete="off" wire:submit.prevent="">
                                    <div class="modal-body">                                        
                                        @livewire('vc-modal-upload')                                          
                                    </div>
                                    <div class="modal-footer">
                                        <div class="hstack gap-2 justify-content-end">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <!--<button type="button" wire:click.prevent="add()" class="btn btn-success" id="add-btn">Continuar</button>-->
                                        </div>
                                    </div>
                                </form>
                                
                            </div>
                        </div>
                    </div>
                    <!--end Modal -->

                </div>
            <!--</div>-->
            <!--end card-->
            </div>
        </div>
                <!--end col-->
    </div>
    <!--end row-->
</div>
