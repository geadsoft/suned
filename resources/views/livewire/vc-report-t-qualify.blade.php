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
                                <option value="1T" selected>Primer Trimestre</option>
                                <option value="2T">Segundo Trimestre</option>
                                <option value="3T">Tercer Trimestre</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="choices-publish-status-input" class="form-label fw-semibold">Bloque</label>
                            <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false wire:model="filters.bloque"  wire:change="consulta()">
                                <option value="1P" selected>Primer Parcial</option>
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
                                    <a href="/preview-pdf/total-rating/{{$datos}}" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" target="_blank"><i class="ri-printer-fill fs-22"></i></a>
                                    <a href="" wire:click.prevent="exportExcel()" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"><i class="ri-file-excel-2-line align-bottom fs-22"></i></a>
                                </div>
                            </div>
                            </div>
                            <table class="table table-bordered table-sm fs-12" id="orderTable">
                                <thead class="table-light">
                                    <tr><th colspan="{{count($tblgrupo)+3}}">
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
                                        <th class="align-middle text-center" style="width: 800px;">NOMBRES</th>
                                        @foreach ($tblgrupo as $key => $grupo)
                                            @if ($key=='AI')
                                            <th class="text-center" style="width: 80px; margin: 0px;">ACTIVIDAD INDIVIDUAL</th>
                                            @else
                                            <th class="text-center" style="width: 80px; margin: 0px;">ACTIVIDAD GRUPAL</th>
                                            @endif
                                        @endforeach
                                        <th class="text-center" style="width: 80px; margin: 0px;">
                                        <span style="writing-mode: vertical-rl; transform: rotate(180deg);">Promedio</span>
                                        </th>
                                        <th class="text-center" style="width: 80px; margin: 0px;">
                                        <span style="writing-mode: vertical-rl; transform: rotate(180deg);">Cualitativa</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($tblrecords as $fil => $record)
                                <tr id="{{$fil}}" class="detalle">
                                    @if ($fil=='ZZ')
                                    <td class="text-end">
                                        {{$record["nombres"]}}
                                        
                                    </td>
                                    @else
                                    <td>
                                        {{$record["nombres"]}}
                                    </td>
                                    @endif
                                   @foreach ($tblgrupo as $key1 => $grupo)
                                        <td class="text-center">{{number_format($tblrecords[$fil][$key1."-prom"],2)}}</td>
                                    @endforeach 
                                    <td class="text-center">{{number_format($record["promedio"],2)}}</td>   
                                    <td class="text-center">{{$record["cualitativa"]}}</td>                              
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
