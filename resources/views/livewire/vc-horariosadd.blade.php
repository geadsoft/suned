<div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body checkout-tab">
                    <form autocomplete="off" wire:submit.prevent="{{ 'createData' }}">
                        @csrf
                        <div class="step-arrow-nav mt-n3 mx-n3 mb-3">
                            <ul class="nav nav-pills nav-justified custom-nav nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fs-15 p-3 {{$tab1}}" id="pills-bill-info-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-bill-info" type="button" role="tab"
                                        aria-controls="pills-bill-info" aria-selected="true"><i
                                            class=" ri-open-source-line fs-16 p-2 bg-soft-primary text-primary rounded-circle align-middle me-2"></i>
                                            Datos Generales</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fs-15 p-3 {{$tab2}}" id="pills-bill-horarios-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-bill-horarios" type="button" role="tab"
                                        aria-controls="pills-bill-horarios" aria-selected="false" $tabHorario><i
                                            class="ri-bank-card-line fs-16 p-2 bg-soft-primary text-primary rounded-circle align-middle me-2"></i>
                                            Asignaturas</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fs-15 p-3 {{$tab3}}" id="pills-bill-docente-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-bill-docente" type="button" role="tab"
                                        aria-controls="pills-bill-docente" aria-selected="false" $tabDocente><i
                                            class=" ri-folder-user-line fs-16 p-2 bg-soft-primary text-primary rounded-circle align-middle me-2"></i>
                                            Docentes</button>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div class="{{$clasTab1}}" id="pills-bill-info" role="tabpanel"
                                aria-labelledby="pills-bill-info-tab">
                                <div class="mb-3">
                                    <br>
                                    <h5 class="mb-1">Información de Horario</h5>
                                    <p class="text-muted mb-4">Por favor complete toda la información a continuación</p>
                                </div>
                                <div class="row">
                                    <div class="card-body row">
                                        <div class="col-lg-4">
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="cmbgrupo" class="form-label">Grupo</label>
                                                <select class="form-select" data-choices data-choices-search-false id="cmbgrupo" wire:model="grupoId" required>
                                                    <option value="">Seleccione Grupo</option>
                                                    @foreach ($tblgenerals as $general)
                                                        @if ($general->superior == 1)
                                                        <option value="{{$general->id}}">{{$general->descripcion}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="cmbgrupo" class="form-label">Servicio</label>
                                                <select class="form-select" data-choices data-choices-search-false id="cmbgrupo" wire:model="servicioId" required>
                                                    <option value="">Seleccione Servicio</option>
                                                    @if ($tblservicios != null)
                                                    @foreach ($tblservicios as $servicio)
                                                        <option value="{{$servicio->id}}">{{$servicio->descripcion}}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="cmbgrupo" class="form-label">Nivel</label>
                                                <select class="form-select" data-choices data-choices-search-false id="cmbgrupo" wire:model="nivelId" disabled>
                                                    <option value="">Seleccione Nivel</option>
                                                    @foreach ($tblgenerals as $general)
                                                        @if ($general->superior == 2)
                                                        <option value="{{$general->id}}">{{$general->descripcion}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="cmbgrupo" class="form-label">Grado</label>
                                                <select class="form-select" data-choices data-choices-search-false id="cmbgrupo" wire:model="gradoId" disabled>
                                                    <option value="">Seleccione Grado</option>
                                                    @foreach ($tblgenerals as $general)
                                                        @if ($general->superior == 3)
                                                        <option value="{{$general->id}}">{{$general->descripcion}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="cmbgrupo" class="form-label">Especialización</label>
                                                <select class="form-select" data-choices data-choices-search-false id="cmbgrupo" wire:model="especialidadId" disabled>
                                                    <option value="">Seleccione Grado</option>
                                                    @foreach ($tblgenerals as $general)
                                                        @if ($general->superior == 4)
                                                        <option value="{{$general->id}}">{{$general->descripcion}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="cmbgrupo" class="form-label">Periodo</label>
                                                <select class="form-select" data-choices data-choices-search-false id="cmbgrupo" wire:model="periodoId" required>
                                                    <option value="">Seleccione Periodo</option>
                                                    @foreach ($tblperiodos as $periodo)
                                                        <option value="{{$periodo->id}}">{{$periodo->descripcion}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="cmbgrupo" class="form-label">Sección</label>
                                                <select class="form-select" data-choices data-choices-search-false id="cmbgrupo" wire:model="cursoId" required>
                                                    <option value="">Seleccione Sección</option>
                                                    @if ($tblcursos != null)
                                                    @foreach ($tblcursos as $curso)
                                                        <option value="{{$curso->id}}">{{$curso->paralelo}}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                        </div>                                        
                                        <div class="d-flex align-items-start gap-3 mt-4">
                                            <a type="button" href="/headquarters/schedules" class="btn btn-light btn-label previestab"
                                                data-previous="pills-bill-registration-tab"><i
                                                    class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>Volver Horario de Clases</a>
                                            <button type="submit" class="btn btn-success w-sm right ms-auto"><i class="ri-save-3-fill label-icon align-middle fs-16 me-2"></i>Grabar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="{{$clasTab2}}" id="pills-bill-horarios" role="tabpanel"
                                aria-labelledby="pills-bill-horarios-tab">
                                <div class="mb-3">
                                    <br>
                                    <h5 class="mb-1"> {{$nombreCurso}}  </h5>
                                    <p class="text-muted mb-4">{{$nombreGrupo}}</p>
                                </div>
                                @livewire('vc-horarios-clase',['horarioId' => $selectId])
                            </div>
                            <div class="{{$clasTab3}}" id="pills-bill-docente" role="tabpanel"
                                aria-labelledby="pills-bill-docente-tab">
                                <div class="mb-3">
                                    <br>
                                    <h5 class="mb-1"> {{$nombreCurso}} </h5>
                                    <p class="text-muted mb-4">{{$nombreGrupo}}</p>
                                </div>
                                @livewire('vc-horarios-docentes',['horarioId' => $selectId])
                            </div>
                        </div>
                    </form>   


                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->

            <div wire.ignore.self class="modal fade flip" id="deleteOrder" tabindex="-1" aria-hidden="true" wire:model='asignaturaDocenteId'>
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body p-5 text-center">
                            <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px">
                            </lord-icon>
                            <div class="mt-4 text-center">
                                <h4>¿Estas a punto de eliminar el registro? {{ $asignaturaDocenteId }}</h4>
                                <p class="text-muted fs-15 mb-4">Eliminar el registro eliminará toda su información de nuestra base de datos..</p>
                                <div class="hstack gap-2 justify-content-center remove">
                                    <button class="btn btn-link link-success fw-medium text-decoration-none"
                                        data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i>
                                        Cerrar</button>
                                    <button class="btn btn-danger" id="delete-record"  wire:click="deleteData({{$asignaturaDocenteId}})"> Si, Eliminarlo</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->

    </div>

</div>
