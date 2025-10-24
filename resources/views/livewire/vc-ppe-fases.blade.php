<div>
    <form id="fase-form" autocomplete="off" wire:submit.prevent="{{ 'createData' }}" class="needs-validation">
    <div class="row">
        <div class="col-xxl-3">
            <div class="card mb-3">
                <div class="card-body">
                    
                    <div class="input-group mb-3">
                        <span class="input-group-text">Dias de Clases</span>
                        <input type="number" aria-label="First name" class="form-control product-price text-end" wire:model="filas">
                        
                        <a id="btnstudents" class ="btn btn-success btn-sm" wire:click="newdetalle()"><i class="ri-add-fill align-bottom me-1"></i></a>
                            
                    </div>
                    
                    <div class="card">
                        <table class="table mb-3">
                            <thead class="text-muted table-light">
                                <tr class="text-uppercase">
                                    <th class="sort" data-sort="id" style="width: 90px;">Linea</th>
                                    <th class="sort">Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($this->objdetalle as $key => $detalle)
                                <tr>
                                    <td class="fw-medium">
                                        <input type="number" step="0.01" class="form-control form-control-sm bg-light border-0 product-price"
                                        id="linea-{{$key}}" value="{{$detalle['linea']}}"/>
                                    </td>
                                    <td><input type="date" class="form-control form-control-sm bg-light border-0" id="fechaActual-{{$key}}" 
                                            data-provider="flatpickr" data-date-format="d-m-Y" data-time="true" wire:model="objdetalle.{{$key}}.fecha"></td>
                                </tr>
                                @endforeach                               
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Link - Clase Virtual</h5>
                    <div class="vstack gap-2">
                        <div class="border rounded border-dashed p-2">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-sm">
                                        <div class="avatar-title bg-light text-secondary rounded fs-24">
                                            <i class="ri-video-chat-line"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <textarea id="editor" class="form-control w-100" rows="3" wire:model.defer="enlace" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!--end card-->
        </div>
        <!---end col-->
        <div class="col-xxl-9">
            <div class="card">
                <div class="card-body">
                    <div class="text-muted">
                        @if ($fase==1)
                        <h6 class="mb-3 fw-semibold text-uppercase">FASE DE FORMACIÓN</h6>
                        <p>Implica un proceso de sensibilización sobre la problemática seleccionada a través de recursos como textos, gráficos, datos estadísticos, 
                        videos, cursos MOOC, entre otros. En esta fase, es importante motivar la búsqueda de información por parte de cada estudiante.</p>
                        @endif
                        @if ($fase==2)
                        <h6 class="mb-3 fw-semibold text-uppercase">FASE DE EJECUCIÓN</h6>
                        <p>Implica el desarrollo y participación de los y las estudiantes, en cada una de las actividades planificadas y sugeridas en los programas 
                        desarrollados por el Nivel Central de la Autoridad Educativa Nacional en coordinación con las instancias competentes.</p>
                        @endif
                        @if ($fase==2)
                        <h6 class="mb-3 fw-semibold text-uppercase">FASE DE PRESENTACIÓN</h6>
                        <p>Para esta fase se propone un ejercicio de retroalimentación entre pares que permita identificar aprendizajes, resultados, obstáculos y expectativas. 
                        A partir de este ejercicio educativo, se organiza una jornada de presentación, tipo casa abierta, para compartir con todas la comunidad educativa el 
                        trabajo realizado.</p>
                        @endif
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-success w-sm">Grabar</button>
                        <a class="btn btn-secondary w-sm" href="/academic/ppe"><i class="me-1 align-bottom"></i>Cancelar</a>
                    </div>
                </div>
            </div>
            <!--end card-->
            <div class="card">
                <div class="card-header">
                    <div>
                        <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#home-1" role="tab">
                                    Estudiantes
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#messages-1" role="tab">
                                    Actividades
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="home-1" role="tabpanel">
                            <h5 class="card-title mb-4">Calificación</h5>
                        </div>
                        <div class="table-responsive table-card mb-1">
                                <table class="table table-nowrap align-middle" id="orderTable">
                                    <thead class="text-muted table-light">
                                        <tr class="text-uppercase">
                                            <th class="sort" data-sort="id">Identificación</th>
                                            <th class="sort" data-sort="superior">Nombres</th>
                                            @foreach($this->objdetalle as $key => $detalle)
                                            <th class="sort" data-sort="codigo">{{$detalle['fecha']}}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody class="list form-check-all">
                                    @foreach ($personas as $person)    
                                        <tr>
                                            <td>{{$person->identificacion}}</td>
                                            <td>{{$person->apellidos}} {{$person->nombres}}</td>
                                            @foreach($this->objdetalle as $key => $detalle)
                                            <td>
                                            <input type="number" class="form-control product-price bg-light border-0" id="ln-{{$person->id}}-{{$key}}" value=""/>
                                            </td>
                                            @endforeach
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

                            

                        </div>


                    </div>
                    <!--end tab-content-->
                </div>
            </div>
            <!--end card-->
        </div>
        <!--end col-->
    </div>
    <!--end row-->
    </form>

    <div class="modal fade" id="inviteMembersModal" tabindex="-1" aria-labelledby="inviteMembersModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-header p-3 ps-4 bg-soft-success">
                    <h5 class="modal-title" id="inviteMembersModalLabel">Team Members</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="search-box mb-3">
                        <input type="text" class="form-control bg-light border-light" placeholder="Search here...">
                        <i class="ri-search-line search-icon"></i>
                    </div>

                    <div class="mb-4 d-flex align-items-center">
                        <div class="me-2">
                            <h5 class="mb-0 fs-13">Members :</h5>
                        </div>
                        <div class="avatar-group justify-content-center">
                            <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip"
                                data-bs-trigger="hover" data-bs-placement="top" title="Tonya Noble">
                                <div class="avatar-xs">
                                    <img src="{{ URL::asset('assets/images/users/avatar-10.jpg') }}" alt="" class="rounded-circle img-fluid">
                                </div>
                            </a>
                            <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip"
                                data-bs-trigger="hover" data-bs-placement="top" title="Thomas Taylor">
                                <div class="avatar-xs">
                                    <img src="{{ URL::asset('assets/images/users/avatar-8.jpg') }}" alt="" class="rounded-circle img-fluid">
                                </div>
                            </a>
                            <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip"
                                data-bs-trigger="hover" data-bs-placement="top" title="Nancy Martino">
                                <div class="avatar-xs">
                                    <img src="{{ URL::asset('assets/images/users/avatar-2.jpg') }}" alt="" class="rounded-circle img-fluid">
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="mx-n4 px-4" data-simplebar style="max-height: 225px;">
                        <div class="vstack gap-3">
                            <div class="d-flex align-items-center">
                                <div class="avatar-xs flex-shrink-0 me-3">
                                    <img src="{{ URL::asset('assets/images/users/avatar-2.jpg') }}" alt="" class="img-fluid rounded-circle">
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="fs-13 mb-0"><a href="javascript:void(0);"
                                            class="text-body d-block">Nancy Martino</a></h5>
                                </div>
                                <div class="flex-shrink-0">
                                    <button type="button" class="btn btn-light btn-sm">Add</button>
                                </div>
                            </div>
                            <!-- end member item -->
                            <div class="d-flex align-items-center">
                                <div class="avatar-xs flex-shrink-0 me-3">
                                    <div class="avatar-title bg-soft-danger text-danger rounded-circle">
                                        HB
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="fs-13 mb-0"><a href="javascript:void(0);"
                                            class="text-body d-block">Henry Baird</a></h5>
                                </div>
                                <div class="flex-shrink-0">
                                    <button type="button" class="btn btn-light btn-sm">Add</button>
                                </div>
                            </div>
                            <!-- end member item -->
                            <div class="d-flex align-items-center">
                                <div class="avatar-xs flex-shrink-0 me-3">
                                    <img src="{{ URL::asset('assets/images/users/avatar-3.jpg') }}" alt="" class="img-fluid rounded-circle">
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="fs-13 mb-0"><a href="javascript:void(0);"
                                            class="text-body d-block">Frank Hook</a></h5>
                                </div>
                                <div class="flex-shrink-0">
                                    <button type="button" class="btn btn-light btn-sm">Add</button>
                                </div>
                            </div>
                            <!-- end member item -->
                            <div class="d-flex align-items-center">
                                <div class="avatar-xs flex-shrink-0 me-3">
                                    <img src="{{ URL::asset('assets/images/users/avatar-4.jpg') }}" alt="" class="img-fluid rounded-circle">
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="fs-13 mb-0"><a href="javascript:void(0);"
                                            class="text-body d-block">Jennifer Carter</a></h5>
                                </div>
                                <div class="flex-shrink-0">
                                    <button type="button" class="btn btn-light btn-sm">Add</button>
                                </div>
                            </div>
                            <!-- end member item -->
                            <div class="d-flex align-items-center">
                                <div class="avatar-xs flex-shrink-0 me-3">
                                    <div class="avatar-title bg-soft-success text-success rounded-circle">
                                        AC
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="fs-13 mb-0"><a href="javascript:void(0);"
                                            class="text-body d-block">Alexis Clarke</a></h5>
                                </div>
                                <div class="flex-shrink-0">
                                    <button type="button" class="btn btn-light btn-sm">Add</button>
                                </div>
                            </div>
                            <!-- end member item -->
                            <div class="d-flex align-items-center">
                                <div class="avatar-xs flex-shrink-0 me-3">
                                    <img src="{{ URL::asset('assets/images/users/avatar-7.jpg') }}" alt="" class="img-fluid rounded-circle">
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="fs-13 mb-0"><a href="javascript:void(0);"
                                            class="text-body d-block">Joseph Parker</a></h5>
                                </div>
                                <div class="flex-shrink-0">
                                    <button type="button" class="btn btn-light btn-sm">Add</button>
                                </div>
                            </div>
                            <!-- end member item -->
                        </div>
                        <!-- end list -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light w-xs" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success w-xs">Assigned</button>
                </div>
            </div>
            <!-- end modal-content -->
        </div>
        <!-- modal-dialog -->
    </div>
    <!-- end modal -->
</div>
