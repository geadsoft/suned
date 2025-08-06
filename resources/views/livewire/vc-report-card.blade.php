<div>
    <form id="createactivity-form" autocomplete="off" wire:submit.prevent="{{ 'createData' }}" class="needs-validation" >
        <div class="row">
            <div class="col-lg-8 d-flex gap-3 align-items-stretch">
                <div class="card flex-fill">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="choices-publish-status-input" class="form-label fw-semibold">Modalidad</label>
                            <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false wire:model="modalidadId">
                                <option value="">Seleccione Modalidad</option>
                                @foreach ($tblmodalidad as $modalidad) 
                                <option value="{{$modalidad->id}}">{{$modalidad->descripcion}}</option>
                                @endforeach 
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="choices-publish-status-input" class="form-label fw-semibold">Paralelos Asignados</label>
                            <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false wire:model="filters.paralelo" wire:change="add()">
                                <option value="">Seleccione Paralelo</option>
                                @foreach ($tblparalelo as $paralelo) 
                                <option value="{{$paralelo->id}}">{{$paralelo->descripcion}}</option>
                                @endforeach 
                            </select>
                        </div>
                        
                    </div>
                </div>
            </div>
            <!-- end col -->
            <div class="col-lg-4 d-flex gap-3 align-items-stretch">
                <div class="card flex-fill">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="choices-publish-status-input" class="form-label fw-semibold">Término</label>
                            <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false wire:model="filters.termino"  wire:change="consulta()">
                                @foreach ($tbltermino as $terminos) 
                                <option value="{{$terminos->codigo}}">{{$terminos->descripcion}}</option>
                                @endforeach 
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="choices-publish-status-input" class="form-label fw-semibold">Bloque</label>
                            <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false wire:model="filters.bloque"  wire:change="consulta()">
                                @foreach ($tblbloque as $bloques) 
                                <option value="{{$bloques->codigo}}">{{$bloques->descripcion}}</option>
                                @endforeach 
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        
                        <div class="mb-3">
                            <div class="row g-3 mb-3">
                            <div class="col-md-auto ms-auto text-end">
                                <div class="hstack text-nowrap gap-2">
                                    <a href="/preview-pdf/report-card/{{$datos}}" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" target="_blank"><i class="ri-printer-fill fs-22"></i></a>
                                    <!--<a href="" wire:click.prevent="exportExcel()" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"><i class="ri-file-excel-2-line align-bottom fs-22"></i></a>-->
                                </div>
                            </div>
                            </div>
                            <table class="table table-bordered table-sm fs-12" id="orderTable">
                                <thead class="table-light">
                                    <tr>
                                        <td class="align-middle text-center" style="font-weight: normal; padding: 0px 10px;">Matricula</td>
                                        <td class="align-middle text-center" style="font-weight: normal; padding: 0px 10px;">Identificación</td>
                                        <td class="align-middle text-center" style="font-weight: normal; padding: 0px 10px;">Nombres</td>
                                        <td class="align-middle text-center" style="font-weight: normal; padding: 0px 10px;">Observación</td>
                                        <td class="align-middle text-center" style="font-weight: normal; padding: 0px 10px;">Acción</td>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($tblpersonas as $fil => $record)
                                <tr id="{{$fil}}" class="detalle">
                                    <td>{{$record["documento"]}}</td>
                                    <td>{{$record["identificacion"]}}</td>
                                    <td>{{$record["apellidos"]}} {{$record["nombres"]}}</td>
                                    <td>
                                    
                                    </td>
                                    <td class="text-center">
                                        <li class="list-inline-item" data-bs-toggle="tooltip"
                                            data-bs-trigger="hover" data-bs-placement="top" title="Ver Calificaciones">
                                            <a class="text-primary d-inline-block"
                                                data-bs-toggle="modal" href="" wire:click.prevent="imprimir({{ $record->id }})">
                                                <i class="ri-eye-line fs-16"></i>
                                            </a>
                                        </li>
                                    </td>                       
                                </tr>
                                @endforeach
                                
                                </tbody>
                            </table>                            
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

