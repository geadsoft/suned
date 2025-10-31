<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1"><i class="ri-team-fill align-middle me-2"></i> {{$registros}} Registros de Estudiantes</h5>
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
                        <div class="col-xxl-2 col-sm-4">
                            <div>
                                <select class="form-select" name="cmbnivel" wire:model="filters.srv_periodo">
                                    <option value="">Seleccione Periodo</option>
                                    @foreach ($tblperiodos as $periodo)
                                        <option value="{{$periodo->id}}">{{$periodo->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xxl-2 col-sm-4">
                            <div>
                                <select class="form-select" name="cmbgrupo" wire:model="filters.srv_grupo">
                                    <option value="">Todos Grupos</option>
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
                                    <select class="form-select" name="cmbgrupo" wire:model="filters.srv_curso">
                                        <option value="">Todos Cursos</option>
                                        @foreach ($tblcursos as $curso)
                                            <option value="{{$curso->id}}">{{$curso->servicio->descripcion}} {{$curso->paralelo}} {{$curso->grupo->descripcion}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        <div class="col-md-auto ms-auto">
                            <div class="hstack text-nowrap gap-2">
                                <button type="button" data-bs-toggle="dropdown" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle dropdown">
                                <i class="ri-printer-fill fs-22"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="/preview-pdf/list-student/LE,{{$datos}}" target="_blank"><i class="ri-article-line align-bottom me-2 text-muted"></i> Listado de Estudiantes </a></li>
                                    <li><a class="dropdown-item" href="/preview-pdf/report-tuitions/RM,{{$datos}}" target="_blank"><i class="ri-stack-line align-bottom me-2 text-muted"></i> Reporte Matriculación </a></li>
                                    <li><a class="dropdown-item" href="/preview-pdf/list-familys/{{$datos}}" target="_blank"><i class="ri-article-line align-bottom me-2 text-muted"></i> Listado de Representantes </a></li>
                                    <li><a class="dropdown-item" href="/preview-pdf/student-file/{{$datos}}" target="_blank"><i class="ri-account-pin-circle-fill align-bottom me-2 text-muted"></i> Ficha de Estudiantes </a></li>
                                </ul>

                                <button type="button" data-bs-toggle="dropdown" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle dropdown">
                                <i class="ri-download-2-line fs-22"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="/download-pdf/list-student/LE,{{$datos}}"><i class="ri-article-line align-bottom me-2 text-muted"></i> Listado de Estudiantes </a></li>
                                    <li><a class="dropdown-item" href="/download-pdf/report-tuitions/RM,{{$datos}}"><i class="ri-stack-line align-bottom me-2 text-muted"></i> Reporte Matriculación </a></li>
                                    <li><a class="dropdown-item" href="/download-pdf/list-familys/{{$datos}}"><i class="ri-article-line align-bottom me-2 text-muted"></i> Listado de Representantes </a></li>
                                    <li><a class="dropdown-item" href="/download-pdf/student-file/{{$datos}}"><i class="ri-account-pin-circle-fill align-bottom me-2 text-muted"></i> Ficha de Estudiantes </a></li>
                                </ul>
                                <button type="button" data-bs-toggle="dropdown" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle dropdown">
                                <i class="ri-file-excel-2-line align-bottom fs-22"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="" wire:click.prevent="exportExcel()"><i class="ri-contacts-fill align-bottom me-2 text-muted"></i>Todos</a></li>
                                    <li><a class="dropdown-item" href="" wire:click.prevent="excelActivos()"><i class="ri-user-follow-fill align-bottom me-2 text-muted"></i>Activos</a></li>
                                </ul>
                                </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" wire:model="estado">
                            <label class="form-check-label" for="estado">Estudiantes retirados</label>
                        </div>
                    </div>
                    
                </div>
                <div class="card-body">
                    <div>
                        <div class="table-responsive table-card mb-3">
                            <table class="table align-middle table-nowrap mb-0" id="customerTable">
                                <thead class="text-muted table-light">
                                    <tr class="text-uppercase">
                                        <th scope="col" style="width: 50px;">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    id="checkAll" value="option">
                                            </div>
                                        </th>
                                        <!--<th class="sort" data-sort="id" scope="col">ID</th>-->
                                        <th class="sort" data-sort="name" scope="col">Identificación</th>
                                        <th class="sort" data-sort="company_name" scope="col">Nombres</th>
                                        <th class="sort" data-sort="email_id" scope="col">Apellidos</th>
                                        <th class="sort" data-sort="phone" scope="col">Fecha Nacimiento</th>
                                        <th class="sort" data-sort="lead_score" scope="col">Nacionalidad</th>
                                        <th class="sort" data-sort="tags" scope="col">Teléfono</th>
                                        <th class="sort" data-sort="tags" scope="col">Curso</th>
                                        <th scope="col">Acción</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                @foreach ($tblrecords as $record)
                                    <tr>
                                        <th scope="row">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="chk_child" value="option1">
                                            </div>
                                        </th>
                                        <td>{{$record->identificacion}}</td>
                                        <td>{{$record->nombres}}</td>
                                        <td>{{$record->apellidos}}</td>
                                        <td>{{date('d/m/Y',strtotime($record->fechanacimiento))}}</td>
                                        <td>{{$record->nacionalidad->descripcion}}</td>
                                        <td>{{$record->telefono}}</td>
                                        <td>{{$record->descripcion}}-{{$record->paralelo}}</td>
                                        <td>
                                            @php
                                                $existe = collect($users)->contains(fn($user) => $user['personaId'] == $record->id);
                                            @endphp
                                            <ul class="list-inline hstack gap-2 mb-0">
                                                @if($existe)
                                                <li class="list-inline-item" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="Resetear">
                                                    <a class="edit-item-btn" href="" wire:click.prevent="resetPassword({{$record->estudiante_id}})"><i
                                                            class="las la-key text-info fs-18"></i></a>
                                                </li>
                                                @else
                                                 <li class="list-inline-item" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="Sin Usuario">
                                                    <a class="edit-item-btn" href=""><i
                                                            class="las la-user-slash  text-warning fs-18"></i></a>
                                                </li>
                                                @endif
                                                <li class="list-inline-item" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="Editar">
                                                    <a class="edit-item-btn" href="/academic/person-edit/{{$record->matriculaId}}"><i
                                                            class="ri-pencil-fill fs-16"></i></a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <div class="dropdown">
                                                        <button
                                                            class="btn btn-soft-secondary btn-sm dropdown"
                                                            type="button" data-bs-toggle="dropdown"
                                                            aria-expanded="false">
                                                            <i class="ri-align-justify align-middle"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li><a class="dropdown-item view-item-btn"
                                                                    href=""><i
                                                                        class="ri-todo-line align-bottom me-2 text-muted fs-16"></i>
                                                                    Informe Estudiantil</a></li>
                                                            <li><a class="dropdown-item edit-item-btn"
                                                                    href="" wire:click.prevent="generarBoletin({{ $record->matriculaId}})"
                                                                    data-bs-toggle="modal"><i
                                                                        class=" ri-star-half-line align-bottom me-2 text-muted fs-16"></i>
                                                                    Libreta Calificaciones</a></li>
                                                            <li>
                                                                @if ($filters['srv_estado']=='A')
                                                                    <a class="dropdown-item remove-item-btn"
                                                                        data-bs-toggle="modal"
                                                                        href="" wire:click.prevent="delete({{$record->estudiante_id}},{{$record->matriculaId}})">
                                                                        <i class="ri-user-unfollow-line align-bottom me-2 text-muted fs-16"></i>
                                                                        Retirar Estudiante
                                                                    </a>
                                                                @else
                                                                    <a class="dropdown-item remove-item-btn"
                                                                        data-bs-toggle="modal"
                                                                        href="" wire:click.prevent="reintegrar({{ $record->estudiante_id}},{{$record->matriculaId}})">
                                                                        <i class="ri-user-received-2-line me-2 text-muted fs-16"></i>
                                                                        Reintegrar Estudiante
                                                                    </a>
                                                                @endif
                                                            </li>
                                                        </ul>
                                                    </div>
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
                    <div wire.ignore.self class="modal fade flip" id="deleteOrder" tabindex="-1" aria-hidden="true" wire:model='selectId'>
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body p-5 text-center">
                                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                        colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px">
                                    </lord-icon>
                                    <div class="mt-4 text-center">
                                        <h4>¿Está a punto de retirar al estudiante? {{ $estudiante }}</h4>
                                        <p class="text-muted fs-15 mb-4">Retirarlo cambiará el estado (activo a retirado), 
                                        esta opción es reversible.
                                        </p>
                                        <div class="hstack gap-2 justify-content-center remove">
                                            <button class="btn btn-link link-success fw-medium text-decoration-none"
                                                data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i>
                                                Cerrar</button>
                                            <button class="btn btn-danger" id="delete-record"  wire:click="deleteData()"> Si,
                                                Retirar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end delete modal -->

                    <!-- Modal -->
                    <div wire.ignore.self class="modal fade flip" id="reintegrar" tabindex="-1" aria-hidden="true" wire:model='selectId'>
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body p-5 text-center">
                                    <lord-icon src="https://cdn.lordicon.com/ghhwiltn.json" trigger="loop"
                                        colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px">
                                    </lord-icon>
                                    <div class="mt-4 text-center">
                                        <h4>{{ $estudiante }}</h4>
                                        <p class="text-muted fs-15 mb-4">Reintegrarlo cambiará el estado (retirado a activo), 
                                        esta opción es reversible.
                                        </p>
                                        <div class="hstack gap-2 justify-content-center remove">
                                            <button class="btn btn-link link-success fw-medium text-decoration-none"
                                                data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i>
                                                Cerrar</button>
                                            <button class="btn btn-danger" id="delete-record"  wire:click="reintegrarData()"> Si,
                                                Reintegrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end delete modal -->

                </div>
            <!--</div>-->
            <!--end card-->
            </div>
        </div>
                <!--end col-->
    </div>
    <!--end row-->
</div>
