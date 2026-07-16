<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="orderList">
                <div class="card-header border-0 mb-3">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Configuración de Documentos</h5>
                        <div class="flex-shrink-0">
                            <button type="button" wire:click.prevent="add()" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn"
                                data-bs-target=""><i class="ri-add-line align-bottom me-1"></i> Nuevo Documento
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div>
                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle" id="orderTable">
                                <thead class="text-muted table-light">
                                    <tr class="text-uppercase">
                                        <th class="sort" data-sort="id"> ID</th>
                                        <th class="sort" data-sort="superior">Documento</th>
                                        <th class="sort" data-sort="codigo">Aplica desde</th>
                                        <th class="sort" data-sort="descripcion">Aplica hasta</th>
                                        <th class="sort" data-sort="estado">Estado</th>
                                        <th class="text-center" data-sort="accion">Acción</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @foreach($tblrecords as $record)
                                        <tr>
                                            <td>{{$record->id}}</td>
                                            <td>{{$record->descripcion}}</td>
                                            <td>{{  $record->primer_servicio ?? '-' }}</td>
                                            <td>{{ $record->ultimo_servicio ?? '-' }}</td>
                                            <td class="status">
                                                <span class="badge badge-soft-success text-uppercase">@lang('status.'.($record->estado))</span>
                                            </td>
                                            <td>
                                                <ul class="list-inline d-flex justify-content-center gap-2 mb-0">
                                                    <li class="list-inline-item">
                                                        <a href="" wire:click.prevent="edit({{ $record->id }})">
                                                            <i class="ri-pencil-fill fs-16"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a class="text-danger"
                                                        href=""
                                                        wire:click.prevent="delete({{ $record->id }})">
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

                    <div wire:ignore.self class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-xl" >
                            <div class="modal-content">
                                
                                <div class="modal-header bg-light p-3">
                                    <h5 class="modal-title" id="exampleModalLabel">
                                        @if($showEditModal)
                                            <span>Editar Documento &nbsp;</span>
                                        @else
                                            <span>Agregar Documento &nbsp;</span>
                                        @endif
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                                </div>
                                <form autocomplete="off" wire:submit.prevent="{{ $showEditModal ? 'updateData' : 'createData' }}">
                                    
                                    <div class="modal-body">
                                        <div class="id" id="modal-id">
                                            @if($showEditModal)
                                                <label for="record.id" class="form-label">ID</label>
                                                <input type="text" wire:model.defer="record.id" class="form-control" placeholder="ID" readonly />
                                            @endif
                                        </div>                                        
                                        <div class="mb-3">
                                            <label for="record.descripcion" class="form-label">Descripción</label>
                                            <input type="text" wire:model.defer="record.descripcion" class="form-control" name="record.descripcion"
                                                placeholder="Enter name" required />
                                        </div>
                                        <div class="card">
                                            <div class="card-body">

                                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                                                    <p class="text-muted mb-0">
                                                        <i class="ri-checkbox-circle-line text-success"></i>
                                                        Seleccione los servicios que aplican
                                                    </p>

                                                    <span class="badge bg-primary-subtle text-primary">
                                                        {{ count($serviciosSeleccionados) }} seleccionados
                                                    </span>
                                                </div>

                                                {{-- Buscador --}}
                                                <!--<div class="position-relative mb-3">
                                                    <input
                                                        type="text"
                                                        class="form-control ps-5"
                                                        placeholder="Buscar por servicio o nivel..."
                                                        wire:model.live.debounce.400ms="buscarServicio">

                                                    <i class="ri-search-line position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                                                </div>-->

                                                {{-- Modalidades --}}
                                                <ul class="nav nav-tabs nav-border-top nav-border-top-primary mb-3"
                                                    role="tablist">

                                                    @foreach($modalidades as $modalidad)
                                                        <li class="nav-item" role="presentation">
                                                            <button
                                                                type="button"
                                                                class="nav-link {{ $loop->first ? 'active' : '' }}"
                                                                data-bs-toggle="tab"
                                                                data-bs-target="#modalidad-{{ $modalidad->id }}"
                                                                role="tab"
                                                                aria-controls="modalidad-{{ $modalidad->id }}"
                                                                aria-selected="{{ $loop->first ? 'true' : 'false' }}">

                                                                {{ $modalidad->descripcion }}

                                                                <span class="badge bg-light text-dark ms-1">
                                                                    {{ $servicios->where('modalidad', $modalidad->descripcion)->count() }}
                                                                </span>
                                                            </button>
                                                        </li>
                                                    @endforeach

                                                </ul>

                                                {{-- Contenido --}}
                                                <div class="tab-content">

                                                    @foreach($modalidades as $modalidad)

                                                        @php
                                                            $serviciosModalidad = $servicios
                                                                ->where('modalidad', $modalidad->descripcion);
                                                        @endphp

                                                        <div
                                                            class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                                            id="modalidad-{{ $modalidad->id }}"
                                                            role="tabpanel">

                                                            <div class="d-flex justify-content-between align-items-center mb-3">

                                                                <small class="text-muted">
                                                                    {{ $serviciosModalidad->count() }} servicios disponibles
                                                                </small>

                                                                @if($serviciosModalidad->isNotEmpty())
                                                                    <button
                                                                        type="button"
                                                                        class="btn btn-sm btn-outline-primary"
                                                                        wire:click="seleccionarModalidad('{{ $modalidad->descripcion }}')">

                                                                        <i class="ri-checkbox-multiple-line me-1"></i>
                                                                        Seleccionar todos
                                                                    </button>
                                                                @endif

                                                            </div>

                                                            <div
                                                                class="row g-3 overflow-auto"
                                                                style="max-height: 400px;">

                                                                @forelse($serviciosModalidad as $servicio)

                                                                    <div
                                                                        class="col-12 col-md-6"
                                                                        wire:key="servicio-{{ $servicio->id }}">

                                                                        <label
                                                                            for="servicio-{{ $servicio->id }}"
                                                                            class="card border shadow-none h-100 mb-0 cursor-pointer
                                                                            {{ in_array($servicio->id, $serviciosSeleccionados) ? 'border-primary bg-primary-subtle' : '' }}">

                                                                            <div class="card-body p-3">
                                                                                <div class="d-flex align-items-start gap-3">

                                                                                    <input
                                                                                        type="checkbox"
                                                                                        class="form-check-input mt-1"
                                                                                        id="servicio-{{ $servicio->id }}"
                                                                                        value="{{ $servicio->id }}"
                                                                                        wire:model.live="serviciosSeleccionados">

                                                                                    <div class="flex-grow-1">

                                                                                        <div class="fw-semibold text-dark">
                                                                                            {{ $servicio->descripcion }}
                                                                                        </div>

                                                                                        <div class="d-flex flex-wrap gap-2 mt-2">

                                                                                            <span class="badge bg-info-subtle text-info">
                                                                                                <i class="ri-graduation-cap-line me-1"></i>
                                                                                                {{ $servicio->nivel }}
                                                                                            </span>

                                                                                            @if(!empty($servicio->modalidad))
                                                                                                <span class="badge bg-secondary-subtle text-secondary">
                                                                                                    {{ $servicio->modalidad }}
                                                                                                </span>
                                                                                            @endif

                                                                                        </div>

                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </label>
                                                                    </div>

                                                                @empty

                                                                    <div class="col-12">
                                                                        <div class="alert alert-info text-center mb-0">
                                                                            <i class="ri-information-line me-1"></i>
                                                                            No existen servicios para esta modalidad.
                                                                        </div>
                                                                    </div>

                                                                @endforelse

                                                            </div>
                                                        </div>

                                                    @endforeach

                                                </div>
                                            </div>
                                        </div>
                                        <!--<div>
                                            <label for="record.estado" class="form-label">Estado</label>
                                                <select class="form-control" data-trigger name="record.estado" wire:model.defer="record.estado" readonly>
                                                <option value="A">Activo</option>
                                                <option value="I">Inactivo</option>
                                            </select>
                                        </div>-->
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
                                        <h4>You are about to delete the record ? {{ $selectId }}</h4>
                                        <p class="text-muted fs-15 mb-4">DDeleting the record will remove
                                            all of
                                            your information from our database.</p>
                                        <div class="hstack gap-2 justify-content-center remove">
                                            <button class="btn btn-link link-success fw-medium text-decoration-none"
                                                data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i>
                                                Close</button>
                                            <button class="btn btn-danger" id="delete-record"  wire:click="deleteData()"> Yes,
                                                Delete It</button>
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
