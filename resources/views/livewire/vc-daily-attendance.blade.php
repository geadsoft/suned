<div>
    <form id="createactivity-form" autocomplete="off" wire:submit.prevent="{{ 'createData' }}" class="needs-validation" >
        <div class="row">
            <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="choices-publish-status-input" class="form-label fw-semibold">Asignatura</label>
                                <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false wire:model="asignaturaId">
                                   <option value="">Seleccione Asignatura</option>
                                   @foreach ($tblasignatura as $asignatura) 
                                    <option value="{{$asignatura->id}}">{{$asignatura->descripcion}}</option>
                                    @endforeach 
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="choices-publish-status-input" class="form-label fw-semibold">Paralelos Asignados</label>
                                <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false wire:model="filters.cursoId"  wire:change="consulta()">
                                   <option value="">Seleccione Paralelo</option>
                                   @foreach ($tblparalelo as $paralelo) 
                                    <option value="{{$paralelo->id}}">{{$paralelo->descripcion}}</option>
                                    @endforeach 
                                </select>
                            </div>
                            
                        </div>
                    </div>
            </div>
            <div class="col-lg-12">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                     Activar el check solamente si el estudiante ha <b>faltado a clases.</b>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
        <!-- end row -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-lg-8">
                                <div class="search-box">
                                    <input type="text" class="form-control search"
                                        placeholder="Buscar por nombre o apellidos" wire:model="filters.buscar" wire:keydown="consulta()">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <input type="date" class="form-control" id="fechaIni" data-provider="flatpickr" data-date-format="d-m-Y" data-time="true" wire:model="filters.fecha">
                            </div>
                        </div>
                        <div class="mb-3">
                            <table class="table table-bordered table-sm" id="orderTable">
                                <thead class="text-muted table-light">
                                    <tr class="text-uppercase">
                                        <th style="width: 500px;">Estudiante</th>
                                        <th style="width: 90px;" class="text-center">Falta</th>
                                    </tr>
                                </thead>
                                <tbody id="tbl-notas">
                                @foreach ($tblrecords as $fil => $record)
                                <tr id="{{$fil}}" class="detalle">
                                    <td>{{$record["nombres"]}}</td> 
                                    <td> 
                                        <div class="custom-control custom-checkbox">
                                            <div class="form-check text-center" >
                                            <input class="form-check-input" type="checkbox" role="switch" wire:model="tblrecords.{{$fil}}.falta">
                                             </div>
                                        </div>
                                    </td>
                                </tr>
                                 @endforeach
                            </table>                            
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="text-end mb-3">
           
            <button type="submit" class="btn btn-success w-sm">Grabar</button>
            <a class="btn btn-secondary w-sm" href="/activities/activity"><i class="me-1 align-bottom"></i>Cancelar</a>
        </div>
    </form>
</div>
