<div>
    <form id="createactivity-form" autocomplete="off" wire:submit.prevent="{{ 'createData' }}" class="needs-validation" >
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
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
                            <label for="choices-publish-status-input" class="form-label fw-semibold">Término</label>
                            <select class="form-select" id="termino" data-choices data-choices-search-false wire:model.defer="termino" wire:change="consulta()" required>
                                @foreach ($tbltermino as $terminos) 
                                <option value="{{$terminos->codigo}}">{{$terminos->descripcion}}</option>
                                @endforeach 
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="choices-publish-status-input" class="form-label fw-semibold">Paralelos Asignados</label>
                            <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false wire:model.defer="cursoId"  wire:change="consulta()" required>
                                <option value="">Seleccione Paralelo</option>
                                @foreach ($tblparalelo as $paralelo) 
                                <option value="{{$paralelo->id}}">{{$paralelo->descripcion}}-{{$paralelo->paralelo}}</option>
                                @endforeach 
                            </select>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <b>A</b> -> MUY SASTIFACTORIO, <b>B</b> -> SATISFACTORIO, <b>C</b> -> POCO SATISFACTORIO, <b>D</b> -> MEJORABLE, <b>E</b> -> INSACTIFACTORIO
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
        <!-- end row -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div style="max-height: 600px; overflow-y: auto;">
                            <table class="table table-bordered table-sm" id="orderTable">
                                <thead class="text-muted table-light" style="position: sticky; top: 0; z-index: 10;">
                                    <tr class="text-uppercase ">
                                        <th style="width: 500px;" rowspan="2">Estudiante</th>
                                        <th style="width: 90px;" class="text-center">Evaluación</th>
                                    </tr>
                                </thead>
                                <tbody id="tbl-notas">
                                @foreach($personas as $personaId => $record)
                                <tr wire:key="persona-{{ $record->id }}">
                                    <td style="vertical-align: middle;">{{ $record['apellidos'] }} {{ $record['nombres'] }}</td> 
                                    <td>
                                        <input list="asistencias" name="asistencia" class="form-control form-control-sm" type="text" wire:model="tblrecords.{{$record->id}}.evaluacion">
                                        <datalist id="asistencias">
                                        <option value="A">
                                        <option value="B">
                                        <option value="C">
                                        <option value="D">
                                        <option value="E">
                                        </datalist>
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
