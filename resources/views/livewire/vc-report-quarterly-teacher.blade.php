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
                                    <!--<a href="/preview-pdf/quarterly-teacher/{{$datos}}" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" target="_blank"><i class="ri-printer-fill fs-22"></i></a>-->
                                    <!--<a href="" wire:click.prevent="exportExcel()" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"><i class="ri-file-excel-2-line align-bottom fs-22"></i></a>-->
                                    <a href="{{ route('pdf.informe_docente_trimestral', ['data' => base64_encode(json_encode($datos))]) }}" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" target="_blank"><i class="ri-printer-fill fs-22"></i></a>
                                </div>
                            </div>
                            </div>
                            <table class="table table-bordered table-sm fs-12" id="orderTable">
                                <thead class="table-light">
                                    <tr><th colspan="8">
                                        <p class="text-end" style="margin: 0px;">Fecha: {{$fechaActual}}</p>
                                        <p class="text-end" style="margin: 0px;">Hora: {{$horaActual}}</p>
                                        @if (count($tblrecords)==0)
                                            <div class="col-4"><img class="img-fluid" style="position: absolute;top: 30%; left: 2%; width: 15%;height:60pt;" src="{{ URL::asset('assets/images/LogoReport.png')}}" alt=""></div>
                                        @else
                                            <div class="col-4"><img class="img-fluid" style="position: absolute;top: 13%; left: 2%; width: 15%;height:60pt;" src="{{ URL::asset('assets/images/LogoReport.png')}}" alt=""></div>
                                        @endif
                                        <p class="text-center text-uppercase" style="margin: 0px;">UNIDAD EDUCATIVA AMERICAN SCHOOL - {{$nivel}}</p>
                                        <p class="text-center" style="margin: 0px;">INFORME DE APRENDIZAJE POR DOCENTE</p>
                                        <p class="text-center" style="margin: 0px;">{{$periodolectivo}}</p>
                                        <!--<p class="text-center" style="margin: 0px;">{{$docente}}/{{$materia}}</p>
                                        <p class="text-center" style="margin: 0px;">{{$curso}}</p>-->
                                        </th>
                                    </tr>
                                    <tr>
                                        <td class="align-middle fw-semibold" style="font-weight: normal; padding: 0px 10px;">Profesor</td>
                                        <td class="align-middle" colspan="3" style="font-weight: normal; padding: 0px 10px;">{{$docente}}</td>
                                        <td class="align-middle fw-semibold" style="font-weight: normal; padding: 0px 10px;">Asignatura</td>
                                        <td class="align-middle" colspan="3" style="font-weight: normal; padding: 0px 10px;">{{$materia}}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-middle fw-semibold" style="font-weight: normal; padding: 0px 10px;">Grado/Curso</td>
                                        <td class="align-middle" colspan="3" style="font-weight: normal; padding: 0px 10px;">{{$curso}}</td>
                                        <td class="align-middle fw-semibold" style="font-weight: normal; padding: 0px 10px;">Quimestre</td>
                                        <td class="align-middle" colspan="3" style="font-weight: normal; padding: 0px 10px;">Primer Trimestre</td>
                                    </tr>
                                    <tr>
                                        <td class="align-middle text-center" colspan="2" rowspan="2" style="font-weight: normal; padding: 0px 10px;">NÓMINA</td>
                                        <td class="align-middle text-center" rowspan="2" style="font-weight: normal; padding: 0px 10px;">Primer Parcial</td>
                                        <td class="align-middle text-center" rowspan="2" style="font-weight: normal; padding: 0px 10px;">Promedio Parcial (70%)</td>
                                        <td class="align-middle text-center" rowspan="2" style="font-weight: normal; padding: 0px 10px;">Examen</td>
                                        <td class="align-middle text-center" rowspan="2" style="font-weight: normal; padding: 0px 10px;">Examen (30%)</td>
                                        <td class="align-middle text-center" colspan="2" style="font-weight: normal; padding: 0px 10px;">NOTA DEL TRIMESTRE</td>
                                    </tr>
                                    <tr>
                                        <td class="align-middle text-center" style="font-weight: normal; padding: 0px 10px;">Cuanti.</td>
                                        <td class="align-middle text-center" style="font-weight: normal; padding: 0px 10px;">Cuali.</td>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($tblrecords as $fil => $record)
                                <tr id="{{$fil}}" class="detalle">
                                    @if ($fil=='ZZ')
                                    <td></td>
                                    <td class="text-end">{{$record["nombres"]}}</td>
                                    @else
                                    <td>{{$fil+1}}</td>
                                    <td>{{$record["nombres"]}}</td>
                                    @endif
                                    <td class="text-center">{{number_format($record["promedio"],2)}}</td> 
                                    <td class="text-center">{{$record["prom70"]}}</td>
                                    <td class="text-center">{{$record["promExamen"]}}</td>
                                    <td class="text-center">{{$record["prom30"]}}</td>

                                    <td class="text-center">{{$record["cuanti"]}}</td> 
                                    <td class="text-center">{{$record["cuali"]}}</td>                          
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