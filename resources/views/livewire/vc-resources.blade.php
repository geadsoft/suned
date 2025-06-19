<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="orderList">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Mis Recursos</h5>
                        <div class="flex-shrink-0">
                            <a class="btn btn-success add-btn" href="/subject/resource-add"><i
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
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($selectedId === $record->id)
                                                <a href="#" wire:click="verDetalles({{ $record->id }})" class="text-warning d-inline-block me-2">
                                                    <i class="ri-indeterminate-circle-fill fs-16"></i>
                                                </a>
                                                @else
                                                <a href="#" wire:click="verDetalles({{ $record->id }})" class="text-primary d-inline-block me-2">
                                                    <i class="ri-add-circle-fill fs-16"></i>
                                                </a>
                                                @endif
                                                <span class="job-type">{{ $record['nombre'] }}</span>
                                            </div>                                            
                                        </td>
                                        <td>
                                           @if ($record['enlace'] != "")
                                           
                                           @if (strpos($record['enlace'],"youtube") !== false) 
                                                <div>
                                                <i class="ri-youtube-line fs-18"></i><a class="text-muted">  </a>
                                                </div> 
                                            @else
                                                <div>
                                                <i class="ri-attachment-2 fs-18"></i><a class="text-muted"> </a>
                                                </div>
                                            @endif

                                            @endif

                                            @foreach ($files as $file)
                                            @if ($file->actividad_id == $record->id)
                                            <div  class="d-flex align-items-center">
                                                <i class="{{$arrdoc[$file->extension]}} fs-20 "></i> {{$file->extension}}
                                            </div>
                                            @endif
                                            @endforeach
                                        </td>
                                        <td>{{$record['descripcion']}}</td>
                                        <td>
                                            <ul class="list-inline hstack gap-2 mb-0">
                                                <li class="list-inline-item" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="Visualizar">
                                                    <a href="/subject/resource-view/{{$record['id']}}"
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
                                                <li class="list-inline-item" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="Eliminar">
                                                    <a class="text-danger d-inline-block remove-item-btn"
                                                        data-bs-toggle="modal" href="" wire:click.prevent="delete({{ $record->id }})">
                                                        <i class="ri-delete-bin-5-fill fs-16"></i>
                                                    </a>
                                                </li>                                                
                                            </ul>
                                        </td>
                                    </tr>
                                    @if($selectedId === $record->id)
                                    <tr>
                                        <td colspan="3">
                                            <strong>Cursos Asignados:</strong>
                                            <ul>
                                                @forelse($detalles as $detalle)
                                                    <li>{{ $detalle->modalidad }} - {{ $detalle->curso }}</li>
                                                @empty
                                                    <li>No hay entregas registradas.</li>
                                                @endforelse
                                            </ul>
                                        </td>
                                    </tr>
                                    @endif
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
                                    <p class="text-muted fs-15 mb-4">Al eliminar el registro se eliminará toda su información de nuestra base de datos. </p>
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

