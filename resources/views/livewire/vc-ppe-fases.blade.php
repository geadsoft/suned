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
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm me-2">
                            <div class="avatar-title bg-light text-secondary rounded fs-24">
                                <i class="ri-video-chat-line"></i>
                            </div>
                        </div>
                        <h5 class="card-title mb-0">Link - Clase Virtual</h5>
                    </div>
                    <div class="vstack gap-2">
                        <div class="border rounded border-dashed p-2">
                            <div class="d-flex align-items-center">
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
                        @switch($fase)
                            @case(1)
                                <h6 class="mb-3 fw-semibold text-uppercase">FASE DE FORMACIÓN</h6>
                                <p>
                                    Implica un proceso de sensibilización sobre la problemática seleccionada a través de recursos como textos, gráficos, datos estadísticos, 
                                    videos, cursos MOOC, entre otros. En esta fase, es importante motivar la búsqueda de información por parte de cada estudiante.
                                </p>
                                @break

                            @case(2)
                                <h6 class="mb-3 fw-semibold text-uppercase">FASE DE EJECUCIÓN</h6>
                                <p>
                                    Implica el desarrollo y participación de los y las estudiantes, en cada una de las actividades planificadas y sugeridas en los programas 
                                    desarrollados por el Nivel Central de la Autoridad Educativa Nacional en coordinación con las instancias competentes.
                                </p>
                                @break

                            @case(3)
                                <h6 class="mb-3 fw-semibold text-uppercase">FASE DE PRESENTACIÓN</h6>
                                <p>
                                    Para esta fase se propone un ejercicio de retroalimentación entre pares que permita identificar aprendizajes, resultados, obstáculos y expectativas. 
                                    A partir de este ejercicio educativo, se organiza una jornada de presentación, tipo casa abierta, para compartir con toda la comunidad educativa el 
                                    trabajo realizado.
                                </p>
                                @break

                            @default
                                <h6 class="mb-3 fw-semibold text-uppercase">SIN FASE DEFINIDA</h6>
                                <p>No se ha definido una fase válida.</p>
                        @endswitch
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
                        <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0 mb-1" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#home-1" role="tab">
                                    Calificación
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#activity" role="tab">
                                    Actividades
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="home-1" role="tabpanel">                       
                            <div class="table-responsive  table-card mb-1">
                                <table class="table table-sm table-nowrap align-middle" id="orderTable">
                                    <thead class="text-muted table-light">
                                        <tr class="text-uppercase">
                                            <th data-sort="id">Identificación</th>
                                            <th data-sort="superior">Nombres</th>
                                            @foreach($this->objdetalle as $key => $detalle)
                                            <th class="text-center" style="width: 130px;">{{$detalle['fecha']}}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody class="list form-check-all">
                                    @foreach ($personas as $person)    
                                        <tr>
                                            <td>{{$tblrecords[$person->id]['nui']}}</td>
                                            <td>{{$tblrecords[$person->id]['nombres']}}</td>
                                            @foreach($this->objdetalle as $key => $detalle)
                                            <td>
                                            <input type="number" class="form-control product-price bg-light border-0 text-end" id="ln-{{$person->id}}-{{$key}}" wire:model="tblrecords.{{$person->id}}.dia{{$key}}"/>
                                            </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="activity" role="tabpanel">
                            <div class="d-flex align-items-center mb-3">
                                <div class="flex-shrink-0 mb-3 ms-auto">
                                    <button type="button" wire:click.prevent="addActivity()" class="btn btn-danger add-btn" id="create-btn">
                                        <i class="ri-add-line align-bottom me-1"></i> Crear
                                    </button>
                                </div>
                            </div>
                            <div class="table-responsive table-card mb-1">
                                <table class="table table-sm table-nowrap align-middle" id="orderTable">
                                    <thead class="text-muted table-light">
                                        <tr class="text-uppercase">
                                            <th data-sort="superior">Actividad</th>
                                            <th data-sort="superior">Descripcion</th>
                                            <th data-sort="superior">Fecha Limite</th>
                                            <th data-sort="superior" class="text-center">Subir Archivo</th>
                                            <th data-sort="superior" class="text-end">Nota</th>
                                            <th data-sort="superior" class="text-center">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list form-check-all">
                                    @foreach ($actividades as $activity) 
                                        <tr>
                                            @if($activity->actividad=='AI')
                                            <td>Individual</td>
                                            @else
                                            <td>Grupal</td>
                                            @endif
                                            <td>{{$activity->nombre}}</td>
                                            <td>{{date('d/m/Y',strtotime($activity->fecha_entrega))}} <small class="text-muted">{{date('H:i',strtotime($activity->fecha_entrega))}}</small> </td>
                                            <td class="text-center">{{$activity->subir_archivo}}</td>
                                            <td class="text-end">0</td>
                                            <td class="text-center">
                                                <ul class="list-inline hstack gap-2 mb-0 justify-content-center">
                                                    <li class="list-inline-item edit" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="Editar">
                                                        <a href="" wire:click.prevent="edit({{ $activity->id }})"
                                                            class="text-secondary d-inline-block edit-item-btn">
                                                            <i class="ri-pencil-fill fs-16"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="Eliminar">
                                                        <a href="" wire:click.prevent="delete({{ $activity->id }})"
                                                            class="text-danger d-inline-block remove-item-btn">
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
                            {{$actividades->links('')}}
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

    <div wire.ignore.self class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" >
            <div class="modal-content">
                
                <div class="modal-header bg-light p-3">
                    <h5 class="modal-title" id="exampleModalLabel">
                        @if($showEditModal)
                            <span>Editar Actividad &nbsp;</span>
                        @else
                            <span>Agregar Actividad &nbsp;</span>
                        @endif
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                </div>
                <form autocomplete="off" wire:submit.prevent="{{ $showEditModal ? 'updateActivity' : 'createActivity' }}">
                    
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="tipo-select" class="form-label fw-semibold">Tipo Actividad</label>
                            <select class="form-select" id="tipo-select" data-choices data-choices-search-false wire:model.defer="tipo">
                                @foreach ($tblactividad as $actividades) 
                                <option value="{{$actividades->codigo}}">{{$actividades->descripcion}}</option>
                                @endforeach 
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Actividad</label>
                            <input type="text" wire:model.defer="descripcion" class="form-control" name="descripcion"
                                placeholder="Enter name" required />
                        </div>
                        <div class="row mb-3"> 
                            <div class="col-sm-3">
                                <label for="fechaMaxima" class="form-label fw-semibold">Fecha Máxima de Entrega</label>
                                <input type="date" class="form-control" id="fechaMaxima" data-provider="flatpickr" data-date-format="d-m-Y" data-time="true" wire:model.defer="fechaentrega"  required> 
                            </div>
                            <!-- Input Time -->
                            <div class="col-sm-3">
                                <label for="horamaxima" class="form-label">Hora Máxima de Entrega</label>
                                <input type="time" class="form-control" id="horamaxima" wire:model.defer="horaentrega" required>
                            </div>
                            <div class="col-sm-3">
                                <label for="archivo-select" class="form-label fw-semibold">Permitir la subida de archivos</label>
                                <select class="form-select" id="archivo-select" data-choices data-choices-search-false wire:model.defer="archivo" >
                                    <option value="SI" selected>SI</option>
                                    <option value="NO">NO</option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label for="puntaje-input" class="form-label fw-semibold">Puntaje</label>
                                <input id="puntaje-input" type="number" min="1" max="10" step="1" class="form-control" value="10" wire:model.defer="puntaje"  required>    
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="puntaje-input" class="form-label fw-semibold">Comentario</label>
                            <textarea id="editor" class="form-control w-100" rows="5" wire:model.defer="comentario"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold" for="product-title-input">Link externo</label>
                            <input type="text" class="form-control" id="product-title-input" placeholder="Ingrese enlace externo" pattern="https://.*" size="30" wire:model.defer="enlace2">
                            <div class="invalid-feedback">Por favor ingrese enlace externo.</div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-success" id="add-btn">Grabar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end modal -->

    <!-- Modal -->
    <div wire.ignore.self class="modal fade flip" id="deleteOrder" tabindex="-1" aria-hidden="true" wire:model='selectId'>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body p-5 text-center">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                        colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px">
                    </lord-icon>
                    <div class="mt-4 text-center">
                        <h4>¿Vas a borrar Actividad en Fase {{$fase}}?</h4>
                        <p class="fs-12 text-center">{{ $nombreActividad }}</p>
                        <p class="text-muted fs-15 mb-4">Eliminar el registro borrará toda su información de nuestra base de datos.</p>
                        <div class="hstack gap-2 justify-content-center remove">
                            <button class="btn btn-link link-success fw-medium text-decoration-none"
                                data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i>
                                Cerrar</button>
                            <button class="btn btn-danger" id="delete-record"  wire:click="deleteActivity()"> Si,
                                Eliminarlo</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end modal -->

</div>
