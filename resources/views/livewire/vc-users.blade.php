<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="orderList">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Registro de Usuario</h5>
                        <div class="flex-shrink-0">
                            <button type="button" wire:click.prevent="add()" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn"
                                data-bs-target=""><i class="ri-add-line align-bottom me-1"></i> Crear Usuario
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    
                </div>
                <div class="card-body pt-0">
                    <div>
                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle" id="orderTable">
                                <thead class="text-muted table-light">
                                    <tr class="text-uppercase">
                                        <th data-sort="id"> ID</th>
                                        <th data-sort="descripcion" style="width: 200px;">Nombre</th>
                                        <th data-sort="descripcion" style="width: 300px;">Email</th>
                                        <th data-sort="descripcion">Accesos</th>
                                        <th data-sort="descripcion">Estado</th>
                                        <th data-sort="accion" class="text-center">Acción</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                @foreach ($tblusers as $users)    
                                    <tr>
                                        <td><span>{{$users->id}}</span></td>
                                        <!--<td><span>{{$users->name}}</span></td>-->
                                        <td>
                                            <div class="d-flex gap-2 align-items-center">
                                                <div class="flex-shrink-0">
                                                    <img src="assets/images/users/avatar-3.jpg" alt="" class="avatar-xs rounded-circle" />
                                                </div>
                                                <div class="flex-grow-1">
                                                    {{$users->name}}
                                                </div>
                                            </div>
                                        </td>      
                                        <td><span>{{$users->email}}</span></td>
                                        <td>
                                            <div>
                                            <i class="las la-user-check fs-18"></i><a class="text-muted"> Rol =></a> {{$users->roles->pluck('name')->implode(', ')}}
                                            <div>
                                            @if (count($users->permissions)>0)
                                            <div>
                                            <i class="las la-user-tag fs-18"></i><a class="text-muted"> Permisos =></a>
                                             {{$users->permissions->pluck('name')->implode(', ')}}
                                            <div> 
                                            @endif                                       
                                        </td> 

                                        <td class="status">
                                            <span class="badge badge-soft-success text-uppercase">Activo</span>
                                        </td>                                   
                                        <td>
                                            <ul class="text-center list-inline mb-0">
                                                <li class="list-inline-item edit" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="Editar Roles">
                                                    <a class="text-success btn btn-icon btn-ghost-secondary rounded-circle" href="" wire:click.prevent="editRol({{ $users }})">
                                                        <i class="mdi mdi-checkbox-marked-circle-plus-outline fs-18"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item edit" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="Editar Permisos">
                                                    <a class="text-secondary btn btn-icon btn-ghost-secondary rounded-circle" wire:click.prevent="editPermiso({{ $users }})">
                                                        <i class="mdi mdi-tag-plus-outline fs-18"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                                    <a class="text-danger remove-item-btn btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                                                        data-bs-toggle="modal" href="" wire:click.prevent="delete({{ $users->id }})">
                                                        <i class="las la-user-times fs-18"></i>
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

                        {{$tblusers->links('')}}

                    </div>


                    <div wire.ignore.self class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable" >
                            <div class="modal-content">
                                
                                <div class="modal-header bg-light p-3">
                                    <h5 class="modal-title" id="exampleModalLabel">
                                        @if($showEditModal)
                                            <span>Editar Rol &nbsp;</span>
                                        @else
                                            <span>Agregar Rol &nbsp;</span>
                                        @endif
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                                </div>
                                <form autocomplete="off" wire:submit.prevent="{{ $showEditModal ? 'updateData' : 'createData' }}">
                                    
                                    <div class="modal-body">
                                        <!--<input type="hidden" id="id-field" />-->

                                        <div class="mb-3" id="modal-id">
                                            @if($showEditModal)
                                                <label for="record.id" class="form-label">ID</label>
                                                <input type="text" wire:model.defer="record.id" class="form-control" placeholder="ID" readonly />
                                            @endif
                                        </div>
                                        <div class="mb-3">
                                            <label for="record.user" class="form-label">Usuario</label>
                                            <input type="text" wire:model.defer="record.name" class="form-control" name="record.name"
                                                placeholder="Ingrese nombre" required />
                                        </div>
                                        @if($showEditModal==false)
                                        <div class="mb-3">
                                            <label for="record.email" class="form-label">Email</label>
                                            <input type="email" wire:model.defer="record.email" class="form-control" name="record.email"
                                                placeholder="Ingrese correo electronico" required />
                                        </div>
                                        <div class="mb-3">
                                            <label for="record.clave" class="form-label">Contraseña</label>
                                            <input type="text" wire:model.defer="record.clave" class="form-control" name="record.clave"
                                                placeholder="Ingrese contraseña" required />
                                        </div>
                                        @endif
                                        <h5 class="modal-title mb-3">Asignar Rol</h5>
                                        @livewire('vc-view-rol-permissions')
                                    </div>
                                    <div class="modal-footer">
                                        <div class="hstack gap-2 justify-content-end">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-success" id="add-btn">Grabar Registro</button>
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
                                        <h4>¿Está a punto de eliminar el registro? {{ $selectId }}</h4>
                                        <p class="text-muted fs-15 mb-4">Al eliminar el registro, se eliminará toda su información de nuestra base de datos.</p>
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

