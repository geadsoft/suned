<div>
    <form id="createactivity-form" autocomplete="off" wire:submit.prevent="{{ 'createData' }}" class="needs-validation" >
        <div class="row">
            <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="choices-publish-status-input" class="form-label fw-semibold">Asignatura</label>
                                <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false wire:model="asignaturaId" {{$control}}>
                                   <option value="">Seleccione Asignatura</option>
                                   @foreach ($tblasignatura as $asignatura) 
                                    <option value="{{$asignatura->id}}">{{$asignatura->descripcion}}</option>
                                    @endforeach 
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="choices-publish-status-input" class="form-label fw-semibold">Paralelos Asignados</label>
                                <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false wire:model="filters.paralelo"  wire:change="consulta()">
                                   <option value="">Seleccione Paralelo</option>
                                   @foreach ($tblparalelo as $paralelo) 
                                    <option value="{{$paralelo->id}}">{{$paralelo->descripcion}}</option>
                                    @endforeach 
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="choices-publish-status-input" class="form-label fw-semibold">Término</label>
                                <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false wire:model="filters.termino"  wire:change="consulta()">
                                    <option value="1T" selected>Primer Trimestre</option>
                                    <option value="2T">Segundo Trimestre</option>
                                    <option value="3T">Tercer Trimestre</option>
                                </select>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <label for="choices-publish-status-input" class="form-label fw-semibold">Exámen</label>
                                    <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false wire:model="filters.bloque"  wire:change="consulta()">
                                        <option value="3E" selected>Exámen Tercer Trimestre</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end card -->

                    <!--<div class="text-end mb-3">
                        <button type="submit" class="btn btn-success w-sm">Submit</button>
                    </div>-->
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        
                        <div class="mb-3">
                            <table class="table table-bordered table-sm" id="orderTable">
                                <thead class="text-muted table-light">
                                    <tr class="text-uppercase">
                                        <th style="width: 100px;">Estudiante</th>
                                        @foreach ($tblactividad as $data)
                                            <th style="width: 90px;">{{$data->nombre}} ( {{$data->puntaje}} )</th>
                                        @endforeach
                                        <th style="width: 90px;" class="text-center">Promedio</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($tblrecords as $fil => $data)
                                <tr id="{{$fil}}" class="detalle">
                                    <td>
                                        <input type="text" class="form-control product-price bg-white border-0" id="nombre-{{$fil}}" value="{{$data["nombres"]}}" disabled/>
                                    </td>
                                    @foreach ($tblactividad as $actividad)
                                        <td>
                                            <input type="number" step="0.01" class="form-control product-price bg-white border-0"
                                            id="col-{{$fil}}" wire:model="tblrecords.{{$fil}}.{{$actividad['id']}}" />
                                        </td>
                                    @endforeach
                                    <td>   
                                        <input type="number" step="0.01" class="form-control product-price border-0 bg-white fw-semibold text-center"
                                            id="promedio-{{$fil}}" value="{{$data["promedio"]}}" disabled/>
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
        <div class="text-end mb-3">
            @if ($this->actividadId==0)
            <button type="submit" class="btn btn-success w-sm">Grabar</button>
            @else
            <button type="submit" class="btn btn-success w-sm">Actualizar</button>
            @endif
            <a class="btn btn-secondary w-sm" href="/activities/activity"><i class="me-1 align-bottom"></i>Cancelar</a>
        </div>
    </form>
</div>
