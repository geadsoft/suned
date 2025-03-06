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
                                    <a href="/preview-pdf/calificacion_total" wire:click.prevent="imprimir()" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"><i class="ri-printer-fill fs-22"></i></a>
                                    <!--<a href="" wire:click.prevent="exportExcel()" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"><i class="ri-file-excel-2-line align-bottom fs-22"></i></a>-->
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
                                            <th class="align-middle text-center" style="font-weight: normal; white-space: pre-line; width: 80px;">
                                            <span>{{$data->nombre}} ( {{$data->puntaje}} )</span>
                                            </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($tblrecords as $fil => $data)
                                <tr id="{{$fil}}" class="detalle">
                                    @if ($fil=='ZZ')
                                    <td>
                                        <input type="text" class="form-control bg-white border-0 text-end" id="nombre-{{$fil}}" value="{{$data["nombres"]}}" disabled/>
                                    </td>
                                    @else
                                    <td>
                                        <input type="text" class="form-control bg-white border-0" id="nombre-{{$fil}}" value="{{$data["nombres"]}}" disabled/>
                                    </td>
                                    @endif
                                    @foreach ($tblexamen as $col => $tarea)
                                    <td>
                                        <input type="number" step="0.01" min="" max="10" class="form-control product-price bg-white border-0 text-end"
                                        id="{{$fil}}-{{$col}}" value="{{number_format($tblrecords[$fil][$col],2)}}"  disabled/>
                                    </td>
                                    @endforeach
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
