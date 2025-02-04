<div>
    <form id="createactivity-form" autocomplete="off" wire:submit.prevent="{{ 'createData' }}" class="needs-validation" >
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
                            <div class="row align-items-start mb-3">
                                <div class="col-sm-2">
                                    <div class="mb-3">
                                        <label for="asignatura-input" class="form-label form-control border-0 fw-semibold fs-14">Periodo Lectivo</label>
                                    </div>
                                    <div class="mb-3">
                                        <label for="asignatura-input" class="form-label form-control border-0 fw-semibold fs-14">Evaluación Academica</label>
                                    </div>
                                </div>
                                <div class="col-sm-10"> 
                                    <div class="mb-3">
                                        <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false wire:model.defer="$periodo" required>
                                             @foreach ($plectivo as $lectivo) 
                                            <option value="{{$lectivo->id}}">{{$lectivo->descripcion}}</option>
                                            @endforeach
                                        </select>
                                    </div> 
                                    <div class="mb-3">
                                        <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false wire:model.defer="$periodo" required>
                                            <option value="T" selected>TRIMESTRE</option>
                                            <option value="Q">QUIMESTRE</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-start mb-3">
                                <div class="col-sm-2">
                                    <div class="mb-3">
                                        
                                    </div>
                                </div>
                                <div class="col-sm-10">  
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

                           <div class="mb-3">
                                <label class="form-label form-control border-0 fw-semibold fs-14">Parciales</label>
                            </div>
                            <div class="mb-3">
                                <table class="table table-nowrap align-middle table-sm" id="orderTable">
                                    <thead class="text-muted table-light">
                                        <tr class="text-uppercase">
                                            <th style="width: 150px;">Linea</th>
                                            <th>Descripción</th>
                                            <th style="width: 150px;">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($arrparcial as $key => $parcial) 
                                    <tr class="par-{{$key}}">
                                    <td>                                    
                                        <input type="text" id="linea-{{$key}}" wire:model.prevent="arrparcial.{{$key}}.linea" class="form-control" disabled>
                                    </td>
                                    <td>
                                        <input type="text" id="name-{{$key}}" wire:model.prevent="arrparcial.{{$key}}.descripcion" class="form-control">
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
                            <div class="d-flex align-items-center mb-3">
                                <label class="form-label form-control border-0 fw-semibold fs-14">Actividades</label>
                                <div class="flex-shrink-0">
                                    <button type="button" wire:click.prevent="addline()" class="btn btn-soft-success add-btn" data-bs-toggle="modal" id="create-btn"
                                        data-bs-target=""><i class="ri-add-line align-bottom me-1"></i> Create
                                    </button>
                                </div>
                            </div>
                            <div class="mb-3">
                                <table class="table table-nowrap align-middle table-sm" id="orderTable">
                                    <thead class="text-muted table-light">
                                        <tr class="text-uppercase">
                                            <th style="width: 150px;">Linea</th>
                                            <th>Descripción</th>
                                            <th style="width: 150px;">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($arractividad as $key => $actividad) 
                                    <tr class="act-{{$actividad['linea']}}">
                                        <td>
                                            <input type="text" id="act-linea-{{$actividad['linea']}}" wire:model.prevent="arractividad.{{$key}}.linea" class="form-control" disabled>
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
                    <!-- end card -->

                
                                <div class="text-end mb-3">
                                    <button type="submit" class="btn btn-success w-sm">Grabar</button>
                                </div>
                            
            </div>
            <!-- end col -->

            
        </div>
        <!-- end row -->
    </form>
</div>

