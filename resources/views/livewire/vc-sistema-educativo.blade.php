<div>
    <form>
        <div class="row">
            <div class="col-xxl-3">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="d-flex mb-3">
                            <h6 class="card-title  mb-3 flex-grow-1 text-start">Periodo Lectivo</h6>
                            <div class="flex-shrink-0">
                                <div class="form-check form-check-success">
                                    <input class="form-check-input" type="checkbox" role="switch" wire:model.defer="aperturado">
                                    <label class="form-check-label" for="aperturado">Aperturado</label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-2">
                            <!--<lord-icon src="https://cdn.lordicon.com/kbtmbyzy.json" trigger="loop"
                                colors="primary:#405189,secondary:#02a8b5" style="width:90px;height:90px">
                            </lord-icon>-->
                        </div>
                        <select class="form-select mb-3" id="choices-publish-status-input" data-choices data-choices-search-false wire:model="periodoId" required>
                            @foreach ($plectivo as $lectivo) 
                            <option value="{{$lectivo->id}}">{{$lectivo->descripcion}}</option>
                            @endforeach
                        </select>
                        
                        <div class="hstack gap-2 justify-content-center">
                            <div class="mb-3">
                                <label for="sumativa" class="form-label">Evaluación Formativa</label>
                                <input type="text" wire:model.defer="eformativa" class="form-control" placeholder="valor" />
                            </div>
                            <div class="mb-3">
                                <label for="formativa" class="form-label">Evaluación Sumativa</label>
                                <input type="text" wire:model.defer="esumativa" class="form-control" placeholder="valor" />
                            </div>
                        </div>
                    </div>
                </div>
                <!--end card-->
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="mb-4">
                            <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false wire:model="metodo">
                                <option value="T" selected>TRIMESTRE</option>
                                <option value="Q">QUIMESTRE</option>
                            </select>
                        </div>
                        <div class="table-card">
                            <table class="table table-sm align-middle table-nowrap" id="orderTable">
                                <thead class="text-muted table-light">
                                    <tr class="text-uppercase">
                                        <th>Linea</th>
                                        <th>Descripción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($arrmetodo as $key => $metodo) 
                                <tr class="det-{{$metodo['linea']}}">
                                <td>{{$metodo['linea']}}</td>
                                <td>{{$metodo['descripcion']}}</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--end card-->
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex mb-3">
                            <h6 class="card-title mb-0 flex-grow-1">Horas de Clase</h6>
                            <div class="flex-shrink-0">
                                <button type="button" class="btn btn-soft-secondary btn-sm" data-bs-toggle="modal" wire:click='addhora'><i class="ri-time-line me-1 align-bottom"></i>
                                    Asignar Hora</button>
                            </div>
                        </div>
                        <select class="form-select mb-3" id="choices-publish-status-input" data-choices data-choices-search-false wire:model="modalidadId">
                            @foreach ($tblmodalidad as $modalidad) 
                            <option value="{{$modalidad->id}}">{{$modalidad->descripcion}}</option>
                            @endforeach
                        </select>
                        <ul class="list-unstyled vstack gap-3 mb-0">
                            @foreach ($arrhora as $hora) 
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <span class="text-muted"><i class="ri-time-line align-bottom"></i> {{$hora->hora_ini}}</span>
                                    <span class="text-muted"> - </span>
                                    <span class="text-muted"><i class="align-bottom"></i> {{$hora->hora_fin}}</span>
                                </div>                                
                                <div class="flex-shrink-0">
                                    <ul class="link-inline mb-0">
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0)" class="text-muted"><i class="ri-eye-line align-bottom"></i></a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0)" class="text-muted"><i class="ri-delete-bin-5-line align-bottom"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!--<li>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <p class="text-muted mb-0">{{$hora->hora_ini}}</p>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="text-muted mb-0">{{$hora->hora_fin}}</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <button class="btn btn-icon btn-sm fs-16 text-muted dropdown" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ri-more-fill"></i>
                                            </button>
                                    </div>
                                </div>
                            </li>-->
                             @endforeach
                        </ul>
                    </div>
                </div>
                <!--end card-->
            </div>
            <!---end col-->
            <div class="col-xxl-9">
                <div class="card">
                    <div class="card-body">
                        <div class="text-muted">
                            <h6 class="mb-3 fw-semibold text-uppercase">Parciales</h6>
                            <table class="table table-sm align-middle table-nowrap" id="orderTable">
                                <thead class="text-muted table-light">
                                    <tr class="text-uppercase text-center">
                                        <th style="width: 80px;">Linea</th>
                                        <th>Descripción</th>
                                        <th style="width: 70px;">1er T.</th>
                                        <th style="width: 70px;">2do T.</th>
                                        <th style="width: 70px;">3er T.</th>
                                        <th style="width: 90px;">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($arrparcial as $key => $parcial) 
                                <tr class="par-{{$key}}">
                                <td>                                    
                                    <input type="text" id="linea-{{$key}}" wire:model.prevent="arrparcial.{{$key}}.linea" class="form-control" disabled>
                                </td>
                                <td>
                                    <input type="check" id="name-{{$key}}" wire:model.prevent="arrparcial.{{$key}}.descripcion" class="form-control">
                                </td>
                                @foreach ($this->arrmetodo as $metodo)
                                    <td class="text-center">
                                        <input class="form-check-input" type="checkbox" name="chkbill" id="{{$metodo['codigo']}}-{{$key}}" wire:model.prevent="arrparcial.{{$key}}.{{$metodo['codigo']}}">
                                    </td>
                                @endforeach

                                <td>
                                    <ul class="list-inline hstack gap-2 mb-0">
                                        <li class="list-inline-item" data-bs-toggle="tooltip"
                                            data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                            <a class="text-danger d-inline-block remove-item-btn"
                                                data-bs-toggle="modal" href="" wire:click.prevent="delete()">
                                                <i class="ri-delete-bin-5-fill fs-16"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </td>

                                </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <div class="pt-3 border-top border-top-dashed mt-4">
                                <div class="d-flex mb-3">
                                    <h6 class="mb-3 flex-grow-1 fw-semibold text-uppercase">Actividades</h6>
                                    <div class="flex-shrink-0">
                                        <button type="button" wire:click.prevent="addline()" class="btn btn-soft-secondary btn-sm" data-bs-toggle="modal" id="create-btn"
                                            data-bs-target=""><i class="ri-add-line align-bottom me-1"></i> Agregar
                                        </button>
                                    </div>
                                </div>
                                <table class="table table-nowrap align-middle table-sm" id="orderTable">
                                <thead class="text-muted table-light">
                                    <tr class="text-uppercase text-center">
                                        <th style="width: 100px;">Linea</th>
                                        <th style="width: 100px;">Código</th>
                                        <th>Descripción</th>
                                        <th style="width: 90px;">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($arractividad as $key => $actividad) 
                                <tr class="act-{{$actividad['linea']}}">
                                    <td>
                                        <input type="text" id="act-linea-{{$actividad['linea']}}" wire:model.prevent="arractividad.{{$key}}.linea" class="form-control" disabled>
                                    </td>
                                    <td>
                                        <input type="text" id="act-name-{{$actividad['linea']}}" wire:model.prevent="arractividad.{{$key}}.codigo" class="form-control">
                                    </td>
                                    <td>
                                        <input type="text" id="act-name-{{$actividad['linea']}}" wire:model.prevent="arractividad.{{$key}}.descripcion" class="form-control">
                                    </td>
                                    <td>
                                    <ul class="list-inline hstack gap-2 mb-0">
                                        <li class="list-inline-item" data-bs-toggle="tooltip"
                                            data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                            <a class="text-danger d-inline-block remove-item-btn"
                                                data-bs-toggle="modal" href="" wire:click.prevent="delete()">
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
                        </div>
                    </div>
                </div>
                <!--end card-->
                <div class="card">
                    
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="home-1" role="tabpanel">
                                <div class="d-flex mb-3">
                                    <h6 class="mb-0 flex-grow-1 mb-3 fw-semibold text-uppercase">Escala de Evaluación Cualitativa</h6>
                                    <div class="flex-shrink-0">
                                        <button type="button" wire:click.prevent="addescala()" class="btn btn-soft-secondary btn-sm" data-bs-toggle="modal" id="create-btn"
                                            data-bs-target=""><i class="ri-add-line align-bottom me-1"></i> Agregar
                                        </button>
                                    </div>
                                </div>
                                <div data-simplebar style="height: 508px;" class="px-3 mx-n3 mb-2">
                                    
                                    <table class="table table-nowrap align-middle table-sm" id="orderTable">
                                        <thead class="text-muted table-light text-center">
                                            <tr class="text-uppercase">
                                                <th style="width: 100px;">Valor</th>
                                                <th style="width: 100px;">Nota</th>
                                                <th>Descripción</th>
                                                <th style="width: 150px;">Equivalencia</th>
                                                <th>...</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($arrescala as $key => $escala) 
                                        <tr>
                                            <td>
                                                <input type="text" id="valor-{{$key}}" wire:model.prevent="arrescala.{{$key}}.valor" class="form-control">
                                            </td>
                                            <td>
                                                <input type="text" id="nota-{{$key}}" wire:model.prevent="arrescala.{{$key}}.nota" class="form-control">
                                            </td>
                                            <td>
                                                <input type="text" id="detalle-{{$key}}" wire:model.prevent="arrescala.{{$key}}.descripcion" class="form-control">
                                            </td>
                                            <td>
                                                <input type="text" id="equivale-{{$key}}" wire:model.prevent="arrescala.{{$key}}.equivale" class="form-control">
                                            </td>
                                            <td>
                                            <ul class="list-inline hstack gap-2 mb-0">
                                                <li class="list-inline-item" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                                    <a class="text-danger d-inline-block remove-item-btn"
                                                        data-bs-toggle="modal" href="" wire:click.prevent="delete()">
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
                                
                            </div>
                            <!--end tab-pane-->
                            
                        </div>
                        <!--end tab-content-->
                    </div>
                </div>
                <!--end card-->
            </div>
            <!--end col-->
        </div>
        <!--end row-->

        <div wire.ignore.self class="modal fade" id="horaModal" tabindex="-1" aria-labelledby="horaModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0">
                    <div class="modal-header p-3 ps-4 bg-soft-success">
                        <h5 class="modal-title" id="horaModalLabel">Agregar Hora</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <select class="form-select mb-3" id="choices-publish-status-input" data-choices data-choices-search-false wire:model.defer="modalidadId">
                                @foreach ($tblmodalidad as $modalidad) 
                                <option value="{{$modalidad->id}}">{{$modalidad->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Input Time -->
                        <div class="mb-3">
                            <label for="exampleInputtime" class="form-label">Hora Inicio</label>
                            <input type="time" class="form-control" id="exampleInputtime" value="08:56 AM" wire:model.defer="hora_ini">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputtime" class="form-label">Hora Finaliza</label>
                            <input type="time" class="form-control" id="exampleInputtime" value="08:56 AM" wire:model.defer="hora_fin">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light w-xs" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-success w-xs" wire:click='grabaHora'>Grabar</button>
                    </div>
                </div>
                <!-- end modal-content -->
            </div>
            <!-- modal-dialog -->
        </div>
        <!-- end modal -->
    </form>


    <!--<form id="createactivity-form" autocomplete="off" wire:submit.prevent="{{ 'createData' }}" class="needs-validation" >
        <div class="row">
            <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header  border-0">
                            <div class="d-flex align-items-center">
                                <h6 class="card-title mb-0 flex-grow-1 text-primary fw-semibold"><i
                                            class="ri-calendar-check-fill align-middle me-1 text-primary fs-20"></i>Registro de Sistema Acádemico</h5>
                            </div>
                        </div>
                        <div class="card-body border border-dashed border-end-0 border-start-0">  
                            <div class="row mb-3">
                                <div class="mb-3 col-sm-8">

                                    <label for="sumativa" class="form-label">Periodo Lectivo</label>
                                    <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false wire:model="periodoId" required>
                                        @foreach ($plectivo as $lectivo) 
                                        <option value="{{$lectivo->id}}">{{$lectivo->descripcion}}</option>
                                        @endforeach
                                    </select>
                                    <div class="d-flex align-items-center">
                                        <label class="form-label flex-grow-1">-</label>
                                        <div class="form-check form-check-success">
                                            <input class="form-check-input" type="checkbox" role="switch" wire:model.defer="aperturado">
                                            <label class="form-check-label" for="aperturado">Aperturado</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 col-sm-2">
                                    <label for="sumativa" class="form-label">Evaluación Formativa</label>
                                    <input type="text" wire:model.defer="eformativa" class="form-control" placeholder="valor" />
                                </div>
                                <div class="mb-3 col-sm-2">
                                    <label for="formativa" class="form-label">Evaluación Sumativa</label>
                                    <input type="text" wire:model.defer="esumativa" class="form-control" placeholder="valor" />
                                </div>
                            </div>


                            <div class="row align-items-start mb-3">

                                <div class="col-sm-6">
                                    <div class="card-header">
                                        <h5 class="card-title flex-grow-1 mb-0 text-primary fs-14"><i
                                            class=" ri-honour-line align-middle me-1 text-success"></i>Evaluación</h5>
                                    </div>
                                    <div class="mb-3">
                                        <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false wire:model="metodo">
                                            <option value="T" selected>TRIMESTRE</option>
                                            <option value="Q">QUIMESTRE</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-start mb-3">

                                <div class="col-sm-6">  
                                    <div class="mb-3">
                                        <table class="table table-sm align-middle table-nowrap" id="orderTable">
                                            <thead class="text-muted table-light">
                                                <tr class="text-uppercase">
                                                    <th>Linea</th>
                                                    <th>Descripción</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($arrmetodo as $key => $metodo) 
                                            <tr class="det-{{$metodo['linea']}}">
                                            <td>{{$metodo['linea']}}</td>
                                            <td>{{$metodo['descripcion']}}</td>
                                            </tr>
                                            @endforeach
                                            </tbody>
                                        </table>  
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="mb-3 col-sm-6">
                                    <div class="card-header">
                                        <h5 class="card-title flex-grow-1 mb-0 text-primary fs-14"><i
                                            class=" ri-honour-line align-middle me-1 text-success"></i>
                                            Parciales</h5>
                                    </div>

                                    <div class="mb-3">
                                        <table class="table table-sm align-middle table-nowrap" id="orderTable">
                                            <thead class="text-muted table-light">
                                                <tr class="text-uppercase text-center">
                                                    <th style="width: 80px;">Linea</th>
                                                    <th>Descripción</th>
                                                    <th style="width: 70px;">1er T.</th>
                                                    <th style="width: 70px;">2do T.</th>
                                                    <th style="width: 70px;">3er T.</th>
                                                    <th style="width: 90px;">Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($arrparcial as $key => $parcial) 
                                            <tr class="par-{{$key}}">
                                            <td>                                    
                                                <input type="text" id="linea-{{$key}}" wire:model.prevent="arrparcial.{{$key}}.linea" class="form-control" disabled>
                                            </td>
                                            <td>
                                                <input type="check" id="name-{{$key}}" wire:model.prevent="arrparcial.{{$key}}.descripcion" class="form-control">
                                            </td>
                                            @foreach ($this->arrmetodo as $metodo)
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" name="chkbill" id="{{$metodo['codigo']}}-{{$key}}" wire:model.prevent="arrparcial.{{$key}}.{{$metodo['codigo']}}">
                                                </td>
                                            @endforeach

                                            <td>
                                                <ul class="list-inline hstack gap-2 mb-0">
                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                                        <a class="text-danger d-inline-block remove-item-btn"
                                                            data-bs-toggle="modal" href="" wire:click.prevent="delete()">
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
                                    
                                    <div class="d-flex align-items-center mb-3">
                                        
                                        <h5 class="card-title flex-grow-1 mb-0 text-primary fs-14"><i
                                            class="ri-stack-fill align-middle me-1 text-success"></i>
                                            Actividades</h5>
                                        <div class="flex-shrink-0">
                                            <button type="button" wire:click.prevent="addline()" class="btn btn-soft-secondary btn-sm" data-bs-toggle="modal" id="create-btn"
                                                data-bs-target=""><i class="ri-add-line align-bottom me-1"></i> Agregar
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <table class="table table-nowrap align-middle table-sm" id="orderTable">
                                            <thead class="text-muted table-light">
                                                <tr class="text-uppercase text-center">
                                                    <th style="width: 100px;">Linea</th>
                                                    <th style="width: 100px;">Código</th>
                                                    <th>Descripción</th>
                                                    <th style="width: 90px;">Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($arractividad as $key => $actividad) 
                                            <tr class="act-{{$actividad['linea']}}">
                                                <td>
                                                    <input type="text" id="act-linea-{{$actividad['linea']}}" wire:model.prevent="arractividad.{{$key}}.linea" class="form-control" disabled>
                                                </td>
                                                <td>
                                                    <input type="text" id="act-name-{{$actividad['linea']}}" wire:model.prevent="arractividad.{{$key}}.codigo" class="form-control">
                                                </td>
                                                <td>
                                                    <input type="text" id="act-name-{{$actividad['linea']}}" wire:model.prevent="arractividad.{{$key}}.descripcion" class="form-control">
                                                </td>
                                                <td>
                                                <ul class="list-inline hstack gap-2 mb-0">
                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                                        <a class="text-danger d-inline-block remove-item-btn"
                                                            data-bs-toggle="modal" href="" wire:click.prevent="delete()">
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
                                </div>
                                <div class="mb-3 col-sm-6"> 
                                    <div class="d-flex align-items-center mb-3">
                                        
                                        <h5 class="card-title flex-grow-1 mb-0 text-primary fs-14"><i
                                            class="ri-medal-line align-middle me-1 text-success fs-14"></i>
                                            Escala de Evaluación Cualitativa</h5>
                                        <div class="flex-shrink-0">
                                            <button type="button" wire:click.prevent="addescala()" class="btn btn-soft-secondary btn-sm" data-bs-toggle="modal" id="create-btn"
                                                data-bs-target=""><i class="ri-add-line align-bottom me-1"></i> Agregar
                                            </button>
                                        </div>
                                    </div>
                                    <table class="table table-nowrap align-middle table-sm" id="orderTable">
                                        <thead class="text-muted table-light">
                                            <tr class="text-uppercase">
                                                <th style="width: 100px;">Valor</th>
                                                <th style="width: 100px;">Nota</th>
                                                <th>Descripción</th>
                                                <th style="width: 150px;">Equivalencia</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($arrescala as $key => $escala) 
                                        <tr>
                                            <td>
                                                <input type="text" id="valor-{{$key}}" wire:model.prevent="arrescala.{{$key}}.valor" class="form-control">
                                            </td>
                                            <td>
                                                <input type="text" id="nota-{{$key}}" wire:model.prevent="arrescala.{{$key}}.nota" class="form-control">
                                            </td>
                                            <td>
                                                <input type="text" id="detalle-{{$key}}" wire:model.prevent="arrescala.{{$key}}.descripcion" class="form-control">
                                            </td>
                                            <td>
                                                <input type="text" id="equivale-{{$key}}" wire:model.prevent="arrescala.{{$key}}.equivale" class="form-control">
                                            </td>
                                            <td>
                                            <ul class="list-inline hstack gap-2 mb-0">
                                                <li class="list-inline-item" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                                    <a class="text-danger d-inline-block remove-item-btn"
                                                        data-bs-toggle="modal" href="" wire:click.prevent="delete()">
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
                            </div> 
                        </div>
                    </div>
                   

                
                                <div class="text-end mb-3">
                                    <button type="submit" class="btn btn-success w-sm">Grabar</button>
                                </div>
                            
            </div>
          

            
        </div>
       
    </form>-->
</div>

