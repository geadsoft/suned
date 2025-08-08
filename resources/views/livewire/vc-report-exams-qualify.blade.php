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
                                    @foreach ($tbltermino as $terminos) 
                                        <option value="{{$terminos->codigo}}">{{$terminos->descripcion}}</option>
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
            <!-- end col -->
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
                                    <a href="/preview-pdf/calificacion_examen/{{$datos}}" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" target="_blank"><i class="ri-printer-fill fs-22"></i></a>
                                </div>
                            </div>
                            </div>
                            <table class="table table-condensed table-bordered table-hover table-sm fs-12" id="orderTable">
                                <thead class="table-light">
                                    <tr><th colspan="5">
                                        <p class="text-end" style="margin: 0px;">Fecha: {{$fechaActual}}</p>
                                        <p class="text-end" style="margin: 0px;">Hora: {{$horaActual}}</p>
                                        @if (count($tblrecords)==0)
                                            <div class="col-4"><img class="img-fluid" style="position: absolute;top: 35%; left: 2%; width: 15%;height:60pt;" src="{{ URL::asset('assets/images/LogoReport.png')}}" alt=""></div>
                                        @else
                                            <div class="col-4"><img class="img-fluid" style="position: absolute;top: 13%; left: 2%; width: 15%;height:60pt;" src="{{ URL::asset('assets/images/LogoReport.png')}}" alt=""></div>
                                        @endif
                                        <p class="text-center" style="margin: 0px;">UNIDAD EDUCATIVA AMERICAN SCHOOL - {{$nivel}}</p>
                                        <p class="text-center" style="margin: 0px;">ACTA DE CALIFICACIONES</p>
                                        <p class="text-center" style="margin: 0px;">{{$subtitulo}}</p>
                                        <p class="text-center" style="margin: 0px;">{{$docente}}/{{$materia}}</p>
                                        <p class="text-center" style="margin: 0px;">{{$curso}}</p>
                                        </th>
                                    </tr>
                                    <tr class="text-uppercase text-muted">
                                        <th class="align-middle text-center" style="width: 900px;">NOMBRES</th>
                                        @foreach ($tblexamen as $data)
                                            <th class="align-middle text-center" style="font-weight: normal; white-space: pre-line;">
                                            
                                            <span>{{$data->nombre}} ( {{$data->puntaje}} )</span>
                                            </th>
                                        @endforeach
                                        <th class="text-center" style="width: 90px; margin: 0px;">
                                        <span style="writing-mode: vertical-rl; transform: rotate(180deg);">Promedio</span>
                                        </th>
                                        <th class="text-center" style="width: 90px; margin: 0px;">
                                        <span style="writing-mode: vertical-rl; transform: rotate(180deg);">Cualitativa</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($personas as $fil => $persona)
                                <tr id="{{$fil}}" class="detalle">
                                    <td>{{$tblrecords[$persona->id]['nombres']}}</td>
                                    @foreach ($tblexamen as $col => $tarea)
                                    <td class="text-center" id="{{$fil}}-{{$tarea->id}}">{{number_format($tblrecords[$persona->id][$tarea->id],2)}}</td>
                                    @endforeach
                                    <td class="text-center fw-semibold" id="{{$fil}}-promedio">{{number_format($tblrecords[$persona->id]["promedio"],2)}}</td>   
                                    <td class="text-center" id="{{$fil}}-cualitativa">{{$tblrecords[$persona->id]["cualitativa"]}}</td>
                                </tr>
                                @endforeach
                                @if(!empty($tblrecords))
                                    <tr id="ZZ" class="detalle">
                                        <td class="text-end align-middle"> {{$tblrecords['ZZ']['nombres']}} </td>                                    
                                        @foreach ($tblexamen as $col => $tarea)
                                        <td class="text-center">
                                            <input type="number" step="0.01" min="0" max="10" class="form-control product-price bg-light border-0 text-center"
                                            id="ZZ-Prom-{{$tarea->id}}" value="{{number_format($tblrecords['ZZ'][$tarea['id']],2)}}" disabled/>
                                        </td>
                                        @endforeach
                                        <td class="text-center">
                                            <input type="text" class="form-control bg-light border-0 text-center fw-semibold" id="promedio-ZZ" value="{{$tblrecords['ZZ']["promedio"]}}" disabled/>
                                        </td>
                                        <td class="text-center">
                                            <input type="text" class="form-control bg-light border-0 text-center" id="cualitativa-ZZ" value="{{$tblrecords['ZZ']["cualitativa"]}}" disabled/>
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
    </form>
</div>
