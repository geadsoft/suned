<div>
    <form id="fase-form" autocomplete="off" wire:submit.prevent="{{ 'createData' }}" class="needs-validation">
    <div class="row">
        <div class="col-xxl-3">
            <div class="card mb-3">
                <div class="card-body">
                    
                    <div class="input-group mb-3">
                        <span class="input-group-text">Días de Clases</span>

                        <input type="number" 
                            class="form-control product-price text-end" 
                            wire:model="filas"
                            aria-label="Número de días">

                        <button type="button" 
                                id="btnstudents" 
                                class="btn btn-soft-success btn-sm d-flex align-items-center justify-content-center"
                                wire:click="newdetalle">
                            <i class="ri-add-line fs-5"></i>
                        </button>
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
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar-sm me-2">
                            <div class="avatar-title bg-light text-secondary rounded fs-24">
                                <i class="ri-video-chat-line"></i>
                            </div>
                        </div>
                        <h5 class="card-title mb-0">Link - Clase Virtual</h5>
                        <div class="ms-auto">
                            <button type="button" 
                                    id="btnstudents" 
                                    class="btn btn-soft-danger btn-sm"
                                    wire:click="newlink">
                                <i class="ri-share-line me-1 align-bottom"></i>Asignar Clases
                            </button>
                        </div>
                    </div>
                    @foreach($detallelink as $key => $link)
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class=" ri-external-link-line me-1 align-bottom"></i>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <h6 class="mb-1"><a href="pages-profile.html">{{$link['modalidad']}} - {{$link['grado']}}</a></h6>
                            <p class="text-muted mb-0 text-wrap text-break">
                                {{ $link['enlace'] }}
                            </p>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="dropdown">
                                <button class="btn btn-icon btn-sm fs-16 text-muted dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ri-more-fill"></i>
                                </button>
                                <ul class="dropdown-menu" style="">
                                    <li><a class="dropdown-item" href="javascript:void(0);" wire:click=""><i class="ri-eye-fill text-muted me-2 align-bottom"></i>Visualizar</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0);" wire:click="dellink({{$key}})"><i class="ri-delete-bin-5-fill text-muted me-2 align-bottom"></i>Eliminar</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!--<div class="vstack gap-2">
                        <div class="border rounded border-dashed p-2">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 overflow-hidden">
                                    <textarea id="editor-{{$key}}" class="form-control w-100" rows="3">{{ $link['enlace'] }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>-->
                    @endforeach

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
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <!-- Pestañas a la izquierda -->
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                            <a class="nav-link {{$selTab[1]}}" data-bs-toggle="tab" href="#asistencia" wire:click="filterTab(1)">Asistencia</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link {{$selTab[2]}}"  data-bs-toggle="tab" href="#activity" wire:click="filterTab(2)">Actividades</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link {{$selTab[3]}}"  data-bs-toggle="tab" href="#home-1" wire:click="filterTab(3)">Calificación</a>
                            </li>
                        </ul>

                        <!-- Combos a la derecha en línea -->
                        <div class="d-flex gap-2">
                            <select id="cmbmodalidad" type="select" class="form-select" data-trigger wire:model="filters.modalidadId">    
                            @foreach ($tblmodalidad as $general)
                                <option value="{{$general->id}}">{{$general->descripcion}}</option>
                            @endforeach
                            </select>

                            <select type="select" class="form-select" data-trigger id="cmdperiodo" style="width: 250px;" wire:model="filters.gradoId" wire:change ="consultar">
                            <option value="">Seleccione Grado</option>
                            @foreach ($filtrargrados as $grado)
                                <option value="{{$grado->id}}">{{$grado->descripcion}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>

                    <!--<div>
                        <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0 mb-1" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#asistencia-1" role="tab">
                                    Asistencia
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#activity" role="tab">
                                    Actividades
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#home-1" role="tab">
                                    Calificación
                                </a>
                            </li>
                        </ul>
                    </div>
                    
                        <div class="row g-2">
                            <div class="col-lg-3" >
                                <div>
                                    <select id="cmbmodalidad" type="select" class="form-select form-select-sm" data-trigger wire:model="filters.modalidadId">    
                                    @foreach ($tblmodalidad as $general)
                                        <option value="{{$general->id}}">{{$general->descripcion}}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3" >
                                <div>
                                    <select type="select" class="form-select form-select-sm" data-trigger id="cmdperiodo" wire:model="filters.gradoId">
                                    <option value="">Seleccione Grado</option>
                                    @foreach ($filtrargrados as $grado)
                                        <option value="{{$grado->id}}">{{$grado->descripcion}}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>-->
                    
                </div>
                <div class="card-body">
                    
                    <div class="tab-content">
                        <div class="tab-pane {{$selTab[1]}}" id="asistencia" role="tabpanel">
                            <div class="card mb-3">
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    Digitar <b>F</b> solamente si el estudiante ha <b>faltado a clases</b>, <b>FJ</b> -> Falta Justificada, <b>A</b> -> Atraso, <b>AH</b> -> Atraso Justificado
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div> 
                            </div> 
                            <div class="card-body">                   
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
                                        @if($this->tblasistencia)   
                                        <tr>
                                            <td>{{$tblasistencia[$person->id]['nui']}}</td>
                                            <td>{{$tblasistencia[$person->id]['nombres']}}</td>
                                            @foreach($this->objdetalle as $key => $detalle)
                                            <td>
                                            <input list="asistencias-{{$person->id}}-{{$key}}" class="form-control form-control-sm" type="text" id="ln-{{$person->id}}-{{$key}}" wire:model="tblasistencia.{{$person->id}}.{{date('md',strtotime($detalle['fecha']))}}">
                                            <datalist id="asistencias-{{$person->id}}-{{$key}}">
                                            <option value="F">
                                            <option value="FJ">
                                            <option value="A">
                                            <option value="AH">
                                            </datalist>
                                            </td>
                                            @endforeach
                                        </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            </div>
                        </div>
                        <div class="tab-pane {{$selTab[3]}}" id="home-1" role="tabpanel">                     
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
                                        @if($this->tblrecords)   
                                        <tr>
                                            <td>{{$tblrecords[$person->id]['nui']}}</td>
                                            <td>{{$tblrecords[$person->id]['nombres']}}</td>
                                            @foreach($this->objdetalle as $key => $detalle)
                                            <td>
                                            <input type="number" class="form-control product-price bg-light border-0 text-end" id="ln-{{$person->id}}-{{$key}}" wire:model="tblrecords.{{$person->id}}.dia{{$key}}"/>
                                            </td>
                                            @endforeach
                                        </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane {{$selTab[2]}}" id="activity" role="tabpanel">
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

    
    <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
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
                        <div class="row">
                            <div class="col-lg-3 mb-3">
                                <label for="cmbmodalidad" class="form-label">Clase</label>
                                <select id="cmbmodalidad" class="form-select" wire:model="fechaentrega">
                                <option value="">-- Seleccione --</option>
                                @foreach ($objdetalle as $detalle)
                                    <option value="{{ $detalle['fecha'] }}">{{ $detalle['fecha'] }}</option>
                                @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3 mb-3">
                                <label for="cmbmodalidad" class="form-label">Modalidad</label>
                                <select id="cmbmodalidad" class="form-select" wire:model="modalidadId">
                                <option value="">-- Seleccione --</option>
                                @foreach ($tblmodalidad as $general)
                                    <option value="{{ $general->id }}">{{ $general->descripcion }}</option>
                                @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label for="cmdgrado" class="form-label">Grado</label>
                                <select id="cmdgrado" class="form-select" wire:model.defer="gradoId">
                                <option value="">-- Seleccione --</option>
                                @foreach ($tblgrados as $grado)
                                    <option value="{{ $grado->id }}">{{ $grado->descripcion }}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 mb-3">
                                <label for="tipo-select" class="form-label fw-semibold">Tipo Actividad</label>
                                <select class="form-select" id="tipo-select" data-choices data-choices-search-false wire:model.defer="tipo">
                                    @foreach ($tblactividad as $actividades) 
                                    <option value="{{$actividades->codigo}}">{{$actividades->descripcion}}</option>
                                    @endforeach 
                                </select>
                            </div>
                            <div class="col-lg-9 mb-3">
                                <label for="descripcion" class="form-label">Actividad</label>
                                <input type="text" wire:model.defer="descripcion" class="form-control" name="descripcion"
                                    placeholder="Enter name" required />
                            </div>
                        </div>
                        <!--<div class="row mb-3"> 
                            <div class="col-sm-3">
                                <label for="fechaMaxima" class="form-label fw-semibold">Fecha Máxima de Entrega</label>
                                <input type="date" class="form-control" id="fechaMaxima" data-provider="flatpickr" data-date-format="d-m-Y" data-time="true" wire:model.defer="fechaentrega"  required> 
                            </div>
                            
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
                        </div>-->
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

    <div class="modal fade" id="showClass" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-xs">
            <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title" id="exampleModalLabel">
                <span>Agregar Link</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>

            <form autocomplete="off" onsubmit="return false;">
                <div class="modal-body">
                <div class="mb-3">
                    <label for="cmbmodalidad" class="form-label">Modalidad</label>
                    <select id="cmbmodalidad" class="form-select" wire:model="modalidadId" required>
                    <option value="">-- Seleccione --</option>
                    @foreach ($tblmodalidad as $general)
                        <option value="{{ $general->id }}">{{ $general->descripcion }}</option>
                    @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="cmdgrado" class="form-label">Grado</label>
                    <select id="cmdgrado" class="form-select" wire:model="gradoId" required>
                    <option value="">-- Seleccione --</option>
                    @foreach ($tblgrados as $grado)
                        <option value="{{ $grado->id }}">{{ $grado->descripcion }}</option>
                    @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <div class="flex-grow-1 overflow-hidden">
                    <textarea id="editor" class="form-control w-100" rows="3" wire:model.defer="enlace" required></textarea>
                    </div>
                </div>
                </div>

                <div class="modal-footer">
                <div class="hstack gap-2 justify-content-end">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" wire:click="addlink">Grabar</button>
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
