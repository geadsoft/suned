<div>
    <form id="createactivity-form" autocomplete="off" wire:submit.prevent="{{ 'createData' }}" class="needs-validation" >
        <div class="row">
            <div class="col-lg-8 d-flex gap-3 align-items-stretch">
                <div class="card flex-fill">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="choices-publish-status-input" class="form-label fw-semibold">Modalidad</label>
                            <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false wire:model="modalidadId" disabled>
                                <option value="">Seleccione Modalidad</option>
                                @foreach ($tblmodalidad as $modalidad) 
                                <option value="{{$modalidad->id}}">{{$modalidad->descripcion}}</option>
                                @endforeach 
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="choices-publish-status-input" class="form-label fw-semibold">Paralelos Asignados</label>
                            <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false wire:model="filters.paralelo" wire:change="add()" disabled>
                                <option value="">Seleccione Paralelo</option>
                                @foreach ($tblparalelo as $paralelo) 
                                <option value="{{$paralelo->id}}">{{$paralelo->descripcion}}</option>
                                @endforeach 
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="choices-publish-status-input" class="form-label fw-semibold">Estudiante</label>
                            <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false wire:model="filters.estudianteId" wire:change="consulta()" disabled>
                                <option value="">Seleccione Estudiante</option>
                                @foreach ($personas as $persona) 
                                <option value="{{$persona->id}}">{{$persona->apellidos}} {{$persona->nombres}}</option>
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
                                    <a href="/preview-pdf/partial-teacher/{{$datos}}" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" target="_blank"><i class="ri-printer-fill fs-22"></i></a>
                                    <!--<a href="" wire:click.prevent="exportExcel()" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"><i class="ri-file-excel-2-line align-bottom fs-22"></i></a>-->
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
                                        <p class="text-center" style="margin: 0px;">INFORME DE APRENDIZAJE POR ESTUDIANTES</p>
                                        <p class="text-center" style="margin: 0px;">{{$periodolectivo}}</p>
                                        <!--<p class="text-center" style="margin: 0px;">{{$docente}}/{{$materia}}</p>
                                        <p class="text-center" style="margin: 0px;">{{$curso}}</p>-->
                                        </th>
                                    </tr>
                                    <tr>
                                        <!--<td class="align-middle fw-semibold" style="font-weight: normal; padding: 0px 10px;">Alumno</td>
                                        <td class="align-middle" colspan="2" style="font-weight: normal; padding: 0px 10px;">{{$docente}}</td>-->
                                        <td class="align-middle fw-semibold" style="font-weight: normal; padding: 0px 10px;"></td>
                                        <td class="align-middle" colspan="2" style="font-weight: normal; padding: 0px 10px;"></td>
                                    </tr>
                                    <tr>
                                        <!--<td class="align-middle fw-semibold" style="font-weight: normal; padding: 0px 10px;">Grado/Curso</td>
                                        <td class="align-middle" colspan="2" style="font-weight: normal; padding: 0px 10px;">{{$curso}}</td>
                                        <td class="align-middle fw-semibold" style="font-weight: normal; padding: 0px 10px;">Trimestre</td>
                                        <td class="align-middle" colspan="2" style="font-weight: normal; padding: 0px 10px;">Primer Trimestre</td>-->
                                    </tr>
                                    <tr>
                                        <td class="align-middle text-center" colspan="2" rowspan="2" style="font-weight: normal; padding: 0px 10px;">ASIGNATURAS</td>
                                        @foreach ($tblgrupo as $grupo)
                                            <td class="align-middle text-center" rowspan="2" style="font-weight: normal; padding: 0px 10px;">{{$this->arrtipo[$grupo->actividad]}}</td>
                                        @endforeach
                                        <td class="align-middle text-center" colspan="2" style="font-weight: normal; padding: 0px 10px;">Primer Parcial</td>
                                        <!--<td class="align-middle text-center" rowspan="2" style="font-weight: normal; padding: 0px 10px;">RECOMENDACIONES</td>
                                        <td class="align-middle text-center" rowspan="2" style="font-weight: normal; padding: 0px 10px;">PLAN DE MEJORA ACADÉMICO</td>-->
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
                                    <!--<td></td>
                                    <td class="text-end">{{$record["nombres"]}}</td>-->
                                    @else
                                    <td>{{$fil+1}}</td>
                                    <td>{{$record["nombres"]}}</td>
                                        @foreach ($tblgrupo as $grupo)
                                            @if (isset($record[$grupo->actividad."-prom"]))
                                                <td class="text-center">{{number_format($record[$grupo->actividad."-prom"],2)}}</td>
                                            @else
                                                <td class="text-center">0.00</td>
                                            @endif
                                        @endforeach
                                    @endif
                                    <td class="text-center">{{number_format($record["promedio"],2)}}</td>   
                                    <td class="text-center">{{$record["cualitativa"]}}</td> 
                                    <!--<td class="text-left">{{$record["recomendacion"]}}</td>
                                    <td class="text-left">{{$record["planmejora"]}}</td>-->                            
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
