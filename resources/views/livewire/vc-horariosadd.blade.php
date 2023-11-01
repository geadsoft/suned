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
                                    <button class="nav-link fs-15 p-3 active" id="pills-bill-info-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-bill-info" type="button" role="tab"
                                        aria-controls="pills-bill-info" aria-selected="true"><i
                                            class=" ri-open-source-line fs-16 p-2 bg-soft-primary text-primary rounded-circle align-middle me-2"></i>
                                            Datos Generales</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fs-15 p-3" id="pills-bill-horarios-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-bill-horarios" type="button" role="tab"
                                        aria-controls="pills-bill-horarios" aria-selected="false" $tabHorario><i
                                            class="ri-bank-card-line fs-16 p-2 bg-soft-primary text-primary rounded-circle align-middle me-2"></i>
                                            Horarios Escolares</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fs-15 p-3" id="pills-bill-docente-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-bill-docente" type="button" role="tab"
                                        aria-controls="pills-bill-docente" aria-selected="false" $tabDocente><i
                                            class=" ri-folder-user-line fs-16 p-2 bg-soft-primary text-primary rounded-circle align-middle me-2"></i>
                                            Asignación Docente</button>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="pills-bill-info" role="tabpanel"
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
                                        <div class="card-body">
                                            <div class="text-end">
                                                <button type="submit" class="btn btn-success w-sm">Grabar</button>
                                                <a class="btn btn-secondary w-sm"><i class="me-1 align-bottom"></i>Cancelar</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-bill-horarios" role="tabpanel"
                                aria-labelledby="pills-bill-horarios-tab">
                                <div class="mb-3">
                                    <br>
                                    <h5 class="mb-1"></h5>
                                    <p class="text-muted mb-4"></p>
                                </div>
                                @livewire('vc-horarios-clase',['horarioId' => $selectId])
                            </div>
                            <div class="tab-pane fade" id="pills-bill-docente" role="tabpanel"
                                aria-labelledby="pills-bill-docente-tab">
                                <div class="mb-3">
                                    <br>
                                    <h5 class="mb-1"></h5>
                                    <p class="text-muted mb-4"></p>
                                </div>
                                @livewire('vc-horarios-docentes')
                            </div>
                        </div>
                    </form>   


                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->

    </div>

</div>
