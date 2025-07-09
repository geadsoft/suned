<div>
    <form id="createactivity-form" autocomplete="off" wire:submit.prevent="{{ 'createData' }}" class="needs-validation" >
        <div class="row">
            <div class="col-lg-8">
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
                        </div>
                    </div>
            </div>
            <!-- end col -->
            <div class="col-lg-4">
                    <div class="card">
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
                            <div class="mb-3"> 
                                
                                    <label for="choices-publish-status-input" class="form-label fw-semibold">Tipo Actividad</label>
                                    <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false wire:model="filters.actividad"  wire:change="consulta()">
                                        @foreach ($tblactividades as $actividades) 
                                        <option value="{{$actividades->codigo}}">{{$actividades->descripcion}}</option>
                                        @endforeach 
                                    </select>
                               
                            </div>
                        </div>
                    </div>
                    <!-- end card -->

                    <!--<div class="text-end mb-3">
                        <button type="submit" class="btn btn-success w-sm">Submit</button>
                    </div>-->
            </div>

        </div>
        <!-- end row -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div style="max-height: 600px; overflow-y: auto;">
                            <table class="table table-bordered table-sm align-middle mb-0" id="orderTable">
                                <thead class="text-muted table-light" style="position: sticky; top: 0; z-index: 10;">
                                    <tr class="text-uppercase">
                                        <th style="width: 150px;">Estudiante</th>
                                        @foreach ($tbltarea as $data)
                                            <th style="width: 60px;">{{$data['nombre']}} ( {{$data['puntaje']}} )</th>
                                        @endforeach
                                        <th style="width: 60px;" class="text-center">Promedio</th>
                                    </tr>
                                </thead>
                                <tbody id="tbl-notas">
                                @foreach ($personas as $fil => $persona)
                                <tr id="{{$fil}}" class="detalle">
                                    <td> {{$tblrecords[$persona->id]['nombres']}} </td>                                    
                                    @foreach ($tbltarea as $col => $tarea)
                                    <td>
                                        <input type="number" step="0.01" min="0" max="10" value="0" class="form-control product-price bg-white border-0"
                                        id="{{$fil}}-{{$col}}" wire:model="tblrecords.{{$persona->id}}.{{$tarea['id']}}" />
                                    </td>
                                    @endforeach
                                    <td>
                                        <input type="text" class="form-control bg-light border-0" id="promedio-{{$fil}}" value="{{$tblrecords[$persona->id]["promedio"]}}" disabled/>
                                    </td>
                                </tr>
                                 @endforeach
                                 @if(!empty($tblrecords))
                                 <tr id="ZZ" class="detalle">
                                    <td> {{$tblrecords['ZZ']['nombres']}} </td>                                    
                                    @foreach ($tbltarea as $col => $tarea)
                                    <td>
                                        <input type="number" step="0.01" min="0" max="10" value="0" class="form-control product-price bg-light border-0"
                                        id="ZZ-Prom" value="{{$tblrecords['ZZ'][$tarea['id']]}}" disabled/>
                                    </td>
                                    @endforeach
                                    <td>
                                        <input type="text" class="form-control bg-light border-0" id="promedio-ZZ" value="{{$tblrecords['ZZ']["promedio"]}}" disabled/>
                                    </td>
                                </tr>
                                @endif
                                </tbody>
                            </table>                            
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        @if(!empty($tblrecords))
            <div class="text-end mb-3">
                <button type="submit" class="btn btn-success w-sm me-2">Grabar</button>
                <a class="btn btn-secondary w-sm" href="/activities/activity">Cancelar</a>
            </div>
        @else
            <div class="text-end mb-3">
                <a class="btn btn-secondary w-sm" href="/activities/activity">Cancelar</a>
            </div>
        @endif
    </form>
</div>
