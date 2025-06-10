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
                                
                                <!--<div class="col-sm-6">
                                    <label for="choices-publish-status-input" class="form-label fw-semibold">Tipo Actividad</label>
                                    <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false wire:model="filters.actividad"  wire:change="consulta()">
                                        <option value="AI">Actividad Individual</option>
                                        <option value="AG">Actividad Grupal</option>
                                    </select>
                                </div>-->
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
                                    <a href="/preview-pdf/detailed-rating/{{$datos}}" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" target="_blank"><i class="ri-printer-fill fs-22"></i></a>
                                    <a href="" wire:click.prevent="exportExcel()" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"><i class="ri-file-excel-2-line align-bottom fs-22"></i></a>
                                </div>
                            </div>
                            </div>
                            <table class="table table-bordered fs-12" id="orderTable">
                                <thead class="table-light">
                                    <tr><th colspan="{{$colspan}}">
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
                                        <th class="text-center" style="width: 900px; margin: 0px;">NOMBRES</th>
                                        @foreach ($tblgrupo as $key => $grupo)
                                            @if ($key=='AI')
                                            <th class="text-center" style="width: 900px; margin: 0px;" colspan="{{count($grupo)+1}}"> ACTIVIDAD INDIVIDUAL</th>
                                            @else
                                            <th class="text-center" style="width: 900px; margin: 0px;" colspan="{{count($grupo)+1}}">ACTIVIDAD GRUPAL</th>
                                            @endif
                                        @endforeach
                                        <th class="text-center">
                                        <span class="text-center" style="width: 50px; margin: 0px;">Promedio</span>
                                        </th>
                                        <th class="text-center">
                                        <span class="text-center" style="width: 50px; margin: 0px;">Cualitativa</span>
                                        </th>
                                    </tr>
                                    <tr class="text-uppercase text-muted">
                                        <th class="align-middle text-center" style="width: 900px;"></th>
                                        @foreach ($tblgrupo as $key => $grupo)
                                            @foreach ($grupo as $data)
                                                <th class="align-middle text-center tr-text" style="margin: 0px; width: 80px;">
                                                <span>{{$data['nombre']}}</span>
                                                </th>
                                            @endforeach
                                            <th class="align-middle text-center tr-text" style="margin: 0px; width: 80px;">
                                            <span><strong>Promedio {{$key}}</strong></span>
                                            </th>
                                        @endforeach
                                        <th colspan="2"></th>
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
                                        @foreach ($grupo as $key2 => $data)
                                        <td class="text-center">
                                        <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Ver más detalle">
                                        <a href="https://americanschool.liranka.com/src/supervisor/viewGradeSummaryDetailedTask.php?Activity=22347&amp;UserId=370" target="_blank" style="color:black" data-toggle="tooltip" data-placement="top">
                                        <span class="note-info"><i class="ri-information-fill fs-15"></i>
                                        </span><span>{{number_format($tblrecords[$fil][$key1.$key2],2)}}</span></a></td>
                                        @endforeach 
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
