<div>
    <form autocomplete="off" class="needs-validation" >
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
                        <select class="form-select mb-3" id="choices-publish-status-input" data-choices data-choices-search-false wire:model="periodoId" required>
                            @foreach ($plectivo as $lectivo) 
                            <option value="{{$lectivo->id}}">{{$lectivo->descripcion}}</option>
                            @endforeach
                        </select>  
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <select class="form-select flex-grow-1" id="choices-publish-status-input" wire:model="modalidadId">
                                @foreach ($tblmodalidad as $modalidad) 
                                <option value="{{$modalidad->id}}">{{$modalidad->descripcion}}</option>
                                @endforeach
                            </select>
                            <div class="d-flex gap-2">
                            @if ($this->fieldsetDisabled==false)
                                <button type="button" class="btn btn-outline-dark btn-sm" wire:click="cancel()"  data-bs-toggle="tooltip" data-bs-placement="top" title="Cancelar">
                                    <i class="ri-close-line me-1 fs-18"></i> 
                                </button>
                            @else
                                @if ($this->editRecno)
                                <button type="button" class="btn btn-outline-primary btn-sm" wire:click='edit()' data-bs-toggle="tooltip" data-bs-placement="top" title="Editar">
                                    <i class="ri-edit-2-fill me-1 fs-18"></i> 
                                </button>
                                @else
                                <button type="button" class="btn btn-outline-warning btn-sm" wire:click="abrirModalReplica()"  data-bs-toggle="tooltip" data-bs-placement="top" title="Agregar">
                                    <i class="ri-add-line me-1 fs-18"></i> 
                                </button>
                                @endif
                            @endif
                            <fieldset {{ $fieldsetDisabled ? 'disabled' : '' }}>
                            <button class="btn btn-outline-success btn-sm" wire:click.prevent='createData' data-bs-toggle="tooltip" data-bs-placement="top" title="Grabar">
                                <i class="ri-save-3-fill me-1 fs-18"></i> 
                            </button>
                            </fieldset>
                            </div>
                        </div>
                                              
                        <fieldset {{ $fieldsetDisabled ? 'disabled' : '' }}>
                        <div class="hstack gap-2 justify-content-center">
                            <div class="mb-3">
                                <label for="sumativa" class="form-label">Evaluación Formativa</label>
                                <input type="text" wire:model.defer="eformativa" class="form-control" placeholder="valor" required/>
                            </div>
                            <div class="mb-3">
                                <label for="formativa" class="form-label">Evaluación Sumativa</label>
                                <input type="text" wire:model.defer="esumativa" class="form-control" placeholder="valor" required/>
                            </div>
                        </div>
                        </fieldset>
                    </div>
                </div>
                <!--end card-->
                <div class="card mb-3">
                    <div class="card-body">
                        <fieldset {{ $fieldsetDisabled ? 'disabled' : '' }}>
                        <div class="mb-4">
                            <div class="d-flex align-items-center gap-2">
                                <select class="form-select" id="choices-publish-status-input"
                                        data-choices data-choices-search-false wire:model="metodo">
                                    <option value=""> -- Seleccione Método -- </option>
                                    <option value="T">TRIMESTRE</option>
                                    <option value="Q">QUIMESTRE</option>
                                </select>
                                <!--<button class="btn btn-soft-success btn-sm" wire:click.prevent='grabaTermino'>
                                    <i class="ri-save-2-line me-1 fs-18"></i> 
                                </button>-->
                            </div>
                        </div>
                        <div class="table-card">
                            <table class="table table-sm align-middle table-nowrap" id="orderTable">
                                <thead class="text-muted table-light">
                                    <tr class="text-uppercase">
                                        <th>Linea</th>
                                        <th>Descripción</th>
                                        <th>Cerrar</th>
                                        <th>Mostrar Nota</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($arrmetodo as $key => $metodo) 
                                <tr class="det-{{$metodo['linea']}}">
                                <td>{{$metodo['linea']}}</td>
                                <td>{{$metodo['descripcion']}}</td>
                                <td class="text-center">
                                    <input class="form-check-input" type="checkbox" id="cerrar-{{$metodo['linea']}}-{{$key}}" wire:model.prevent="arrmetodo.{{$key}}.cerrar">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="checkbox" id="ver-{{$metodo['linea']}}-{{$key}}" wire:model.prevent="arrmetodo.{{$key}}.visualizar_nota">
                                </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        </fieldset>
                    </div>
                </div>
                <!--end card-->
                <div class="card mb-3">
                    <div class="card-header">
                        <div class="d-flex">
                            <h6 class="card-title mb-0 flex-grow-1">Horas de Clase</h6>
                            <fieldset {{ $fieldsetDisabled ? 'disabled' : '' }}>
                            <div class="flex-shrink-0">
                                <button type="button" class="btn btn-soft-secondary btn-sm" data-bs-toggle="modal" wire:click='addhora'><i class="ri-time-line me-1 align-bottom"></i>
                                    Asignar Hora</button>
                            </div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="card-body">
                        
                        <!--<select class="form-select mb-3" id="choices-publish-status-input" data-choices data-choices-search-false wire:model="modalidadId">
                            @foreach ($tblmodalidad as $modalidad) 
                            <option value="{{$modalidad->id}}">{{$modalidad->descripcion}}</option>
                            @endforeach
                        </select>-->
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
                        <fieldset {{ $fieldsetDisabled ? 'disabled' : '' }}>
                        <div class="text-muted">
                            <h6 class="mb-3 fw-semibold text-uppercase">Parciales</h6>
                            <table class="table table-sm align-middle table-nowrap" id="orderTable">
                                <thead class="text-muted table-light">
                                    <tr class="text-uppercase text-center">
                                        <th style="width: 80px;">Linea</th>
                                        <th>Descripción</th>
                                        @foreach ($this->arrmetodo as $metodo)
                                        <th style="width: 70px;">{{$metodo['codigo']}}</th>
                                        @endforeach
                                        <th style="width: 90px;">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($arrparcial as $key => $parcial) 
                                <tr class="par-{{$key}}">
                                <td>                                    
                                    <input type="text" id="linea-{{$key}}" wire:model.prevent="arrparcial.{{$key}}.linea" class="form-control form-control-sm" disabled>
                                </td>
                                <td>
                                    <input type="check" id="name-{{$key}}" wire:model.prevent="arrparcial.{{$key}}.descripcion" class="form-control form-control-sm">
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
                        </fieldset>
                    </div>
                </div>
                <!--end card-->
                <div class="row">
                    <div class="col-6">
                        <div class="card">
                            <fieldset {{ $fieldsetDisabled ? 'disabled' : '' }}>
                            <div class="card-header">
                                <div class="d-flex">
                                    <h6 class="flex-grow-1 fw-semibold text-uppercase">Actividades</h6>
                                    <div class="flex-shrink-0">
                                        <button type="button" wire:click.prevent="addline()" class="btn btn-soft-secondary btn-sm" data-bs-toggle="modal" id="create-btn"
                                            data-bs-target=""><i class="ri-add-line align-bottom me-1"></i> Agregar
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-nowrap align-middle table-sm" id="orderTable">
                                    <thead class="text-muted table-light">
                                        <tr class="text-uppercase text-center">
                                            <th style="width: 100px;">Linea</th>
                                            <th style="width: 100px;">Código</th>
                                            <th>Descripción</th>
                                            <th style="width: 30px;">...</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($arractividad as $key => $actividad) 
                                    <tr class="act-{{$actividad['linea']}}">
                                        <td>
                                            <input type="text" id="act-linea-{{$actividad['linea']}}" wire:model.prevent="arractividad.{{$key}}.linea" class="form-control form-control-sm" disabled>
                                        </td>
                                        <td>
                                            <input type="text" id="act-name-{{$actividad['linea']}}" wire:model.prevent="arractividad.{{$key}}.codigo" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <input type="text" id="act-name-{{$actividad['linea']}}" wire:model.prevent="arractividad.{{$key}}.descripcion" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                        <ul class="list-inline hstack gap-2 mb-0">
                                            <li class="list-inline-item" data-bs-toggle="tooltip"
                                                data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                                <a class="text-danger d-inline-block remove-item-btn"
                                                    data-bs-toggle="modal" href="" wire:click.prevent="deleteActivity({{$actividad['linea']}})">
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
                            </fieldset>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card">
                            <fieldset {{ $fieldsetDisabled ? 'disabled' : '' }}>
                            <div class="card-header">
                                <div class="d-flex">
                                    <h6 class="flex-grow-1 fw-semibold text-uppercase">Exámenes</h6>
                                    <div class="flex-shrink-0">
                                        <button type="button" wire:click.prevent="addExamen()" class="btn btn-soft-secondary btn-sm" data-bs-toggle="modal" id="btn-add-exam"
                                            data-bs-target=""><i class="ri-add-line align-bottom me-1"></i> Agregar
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-nowrap align-middle table-sm" id="examenTable">
                                    <thead class="text-muted table-light">
                                        <tr class="text-uppercase text-center">
                                            <th style="width: 100px;">Linea</th>
                                            <th style="width: 100px;">Código</th>
                                            <th>Descripción</th>
                                            <th style="width: 30px;">...</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($arrexamen as $key => $examen) 
                                    <tr class="exa-{{$examen['linea']}}">
                                        <td>
                                            <input type="text" id="exa-linea-{{$examen['linea']}}" wire:model.prevent="arrexamen.{{$key}}.linea" class="form-control form-control-sm" disabled>
                                        </td>
                                        <td>
                                            <input type="text" id="exa-codigo-{{$examen['linea']}}" wire:model.prevent="arrexamen.{{$key}}.codigo" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <input type="text" id="exa-name-{{$examen['linea']}}" wire:model.prevent="arrexamen.{{$key}}.descripcion" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                        <ul class="list-inline hstack gap-2 mb-0">
                                            <li class="list-inline-item" data-bs-toggle="tooltip"
                                                data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                                <a class="text-danger d-inline-block remove-item-btn"
                                                    data-bs-toggle="modal" href="" wire:click.prevent="deleteExamen({{$examen['linea']}})">
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
                            </fieldset>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <fieldset {{ $fieldsetDisabled ? 'disabled' : '' }}>
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
                                <div data-simplebar style="height: 430px;" class="px-3 mx-n3 mb-2">
                                    
                                    <table class="table table-nowrap align-middle table-sm" id="orderTable">
                                        <thead class="text-muted table-light text-center">
                                            <tr class="text-uppercase">
                                                <th style="width: 100px;">Valor</th>
                                                <th style="width: 100px;">Nota</th>
                                                <th>Descripción</th>
                                                <th style="width: 150px;">Equivalencia</th>
                                                <th style="width: 30px;">...</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($arrescala as $key => $escala) 
                                        <tr>
                                            <td>
                                                <input type="text" id="valor-{{$key}}" wire:model.prevent="arrescala.{{$key}}.valor" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <input type="text" id="nota-{{$key}}" wire:model.prevent="arrescala.{{$key}}.nota" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <input type="text" id="detalle-{{$key}}" wire:model.prevent="arrescala.{{$key}}.descripcion" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <input type="text" id="equivale-{{$key}}" wire:model.prevent="arrescala.{{$key}}.equivale" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                            <ul class="list-inline hstack gap-2 mb-0">
                                                <li class="list-inline-item" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                                    <a class="text-danger d-inline-block remove-item-btn"
                                                        data-bs-toggle="modal" href="" wire:click.prevent="deleteEscala({{$escala['linea']}})">
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
                        <!--<div class="text-end mb-3">
                            <button type="submit" class="btn btn-success w-sm">Grabar</button>
                        </div>-->
                    </div>
                    </fieldset>
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

    <!-- Modal Visual de Replica -->
    <div wire:ignore.self class="modal fade" id="replicaModal" tabindex="-1" aria-labelledby="replicaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold text-white" id="replicaModalLabel">
                        <i class="ri-information-line me-2"></i> Replicar datos del periodo anterior
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Seleccione los elementos que desea replicar.</p>
                    <div class="row g-3 mt-2">

                        <!-- Calificaciones -->
                        <div class="col-md-4">
                            <div class="card h-100 border-success shadow-sm">
                                <div class="card-body text-center">
                                    <i class="ri-bar-chart-2-fill text-success fs-2 mb-2"></i>
                                    <h6 class="card-title">Calificaciones</h6>
                                    <div class="form-check form-switch mt-2">
                                        <input class="form-check-input" type="checkbox" wire:model="replica.calificacion" id="replicaCalificacion" checked>
                                        <label class="form-check-label" for="replicaCalificacion">Activar</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Parciales -->
                        <div class="col-md-4">
                            <div class="card h-100 border-primary shadow-sm">
                                <div class="card-body text-center">
                                    <i class="ri-calendar-event-fill text-primary fs-2 mb-2"></i>
                                    <h6 class="card-title">Parciales</h6>
                                    <div class="form-check form-switch mt-2">
                                        <input class="form-check-input" type="checkbox" wire:model="replica.parcial" id="replicaParcial" checked>
                                        <label class="form-check-label" for="replicaParcial">Activar</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Horarios -->
                        <div class="col-md-4">
                            <div class="card h-100 border-primary shadow-sm">
                                <div class="card-body text-center">
                                    <i class="ri-time-line text-primary fs-2 mb-2"></i>
                                    <h6 class="card-title">Horarios</h6>
                                    <div class="form-check form-switch mt-2">
                                        <input class="form-check-input" type="checkbox" wire:model="replica.horario" id="replicaParcial" checked>
                                        <label class="form-check-label" for="replicaParcial">Activar</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actividades -->
                        <div class="col-md-4">
                            <div class="card h-100 border-warning shadow-sm">
                                <div class="card-body text-center">
                                    <i class="ri-task-fill text-warning fs-2 mb-2"></i>
                                    <h6 class="card-title">Actividades</h6>
                                    <div class="form-check form-switch mt-2">
                                        <input class="form-check-input" type="checkbox" wire:model="replica.actividades" id="replicaActividades" checked>
                                        <label class="form-check-label" for="replicaActividades">Activar</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Exámenes -->
                        <div class="col-md-4">
                            <div class="card h-100 border-danger shadow-sm">
                                <div class="card-body text-center">
                                    <i class="ri-book-2-fill text-danger fs-2 mb-2"></i>
                                    <h6 class="card-title">Exámenes</h6>
                                    <div class="form-check form-switch mt-2">
                                        <input class="form-check-input" type="checkbox" wire:model="replica.examenes" id="replicaExamenes" checked>
                                        <label class="form-check-label" for="replicaExamenes">Activar</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Escala Cualitativa -->
                        <div class="col-md-4">
                            <div class="card h-100 border-secondary shadow-sm">
                                <div class="card-body text-center">
                                    <i class="ri-award-fill text-secondary fs-2 mb-2"></i>
                                    <h6 class="card-title">Escala Cualitativa</h6>
                                    <div class="form-check form-switch mt-2">
                                        <input class="form-check-input" type="checkbox" wire:model="replica.escalaCualitativa" id="replicaEscala" checked>
                                        <label class="form-check-label" for="replicaEscala">Activar</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" wire:click="sinReplicar">Cancelar</button>
                    <button type="button" class="btn btn-primary" wire:click="replicarDatos">
                        <i class="ri-check-line me-1"></i> Aceptar
                    </button>
                </div>
            </div>
        </div>
    </div>


</div>

