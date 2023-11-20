<div>
    <div class="d-flex align-items-center">
        <h5 class="card-title mb-0 flex-grow-1"><strong>Gestion Calificaciones de Estudiantes</strong></h5>
        <div class="flex-shrink-0">
            <a class="btn btn-success add-btn" href="/academic/ratings-add"><i
            class="ri-add-line me-1 align-bottom"></i> Agregar Calificaciones Estudiantes</a>
        </div>
    </div>
    <hr style="color: #0056b2;" />
    <div class="mb-3">
        <label for="cmbgrupo" class="form-label">Búsqueda</label>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="orderList">
                <div class="card-body border border-dashed border-end-0 border-start-0 ">
                    <form>
                    <label for="cmbgrupo" class="form-label">Filtros</label>
                        <div class="row mb-3">
                            <div class="col-xxl-6 col-sm-6">
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label class="form-label mt-2 me-5" for="selperiodo">Periodo Lectivo</label>
                                    </div>
                                    <div class="col-lg-9">
                                        <select class="form-select" id="selperiodo" wire:model="periodoId" required> 
                                            @foreach ($tblperiodos as $periodo)
                                                <option value="{{$periodo->id}}">{{$periodo->descripcion}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label class="form-label mt-2 me-5" for="selnivel">Nivel</label>
                                    </div>
                                    <div class="col-lg-9">
                                        <select class="form-select" id="selnivel" wire:model="nivelId" required> 
                                            <option value="" selected>Seleccionar</option>
                                            @foreach ($tblgenerals as $general)
                                                @if ($general->superior == 2)
                                                <option value="{{$general->id}}">{{$general->descripcion}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div> 
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label class="form-label mt-2 me-5" for="selespecialidad">Especialización</label>
                                    </div>
                                    <div class="col-lg-9">
                                        <select class="form-select" id="selespecialidad" wire:model="especialidadId" required> 
                                            @foreach ($tblgenerals as $general)
                                                @if ($general->superior == 4)
                                                <option value="{{$general->id}}">{{$general->descripcion}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label class="form-label mt-2 me-5" for="selasignatura">Componente Plan de Estudio</label>
                                    </div>
                                    <div class="col-lg-9">
                                        <select class="form-select" id="selasignatura" wire:model="asignaturaId" required> 
                                            <option value="0" selected>Seleccionar</option>
                                            @foreach ($asignaturas as $data)
                                                <option value="{{$data->id}}">{{$data->descripcion}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>                   
                            </div>
                            <div class="col-xxl-6 col-sm-6">
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label class="form-label mt-2 me-5" for="selgrupo">Grupo</label>
                                    </div>
                                    <div class="col-lg-9">
                                        <select class="form-select" id="selgrupo" wire:model="grupoId" required> 
                                            @foreach ($tblgenerals as $general)
                                                @if ($general->superior == 1)
                                                <option value="{{$general->id}}">{{$general->descripcion}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label class="form-label mt-2 me-5" for="selgradoId">Grado</label>
                                    </div>
                                    <div class="col-lg-9">
                                        <select class="form-select" id="selgradoId" wire:model="gradoId" required> 
                                            <option value="0" selected>Seleccionar</option>
                                            @foreach ($tblgrados as $general)
                                                <option value="{{$general->grado_id}}">{{$general->descripcion}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label class="form-label mt-2 me-5" for="selcurso">Sección</label>
                                    </div>
                                    <div class="col-lg-9">
                                        <select class="form-select" id="selcurso" wire:model="cursoId" required> 
                                            <option value="0" selected>Seleccionar</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label class="form-label mt-2 me-5" for="selparcial">Parcial</label>
                                    </div>
                                    <div class="col-lg-9">
                                        <select class="form-select" id="selparcial" wire:model="parcial" required> 
                                            <option value="P1">P1 - Primer Periodo</option>
                                            <option value="P2">P2 - Segundo Periodo</option>
                                            <option value="P3">P3 - Tercer Periodo</option>
                                            <option value="P4">P4 - Cuarto Periodo</option>
                                            <option value="P5">P5 - Quinto Periodo</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-12 text-end">
                                        <a wire:click="loadData()" id="btnload" class ="btn btn-soft-secondary w-sm"><i class="ri-search-line me-1"></i>Buscar</a>
                                        <a wire:click="" id="btnlimpiar" class ="btn btn-soft-primary w-sm">Limpiar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card" id="orderList">
                            <div class="card-body pt-0">
                                <div>
                                    <div class="table-responsive table-card mb-1">
                                        <table class="table table-nowrap align-middle" id="orderTable">
                                            @if ($tblrecords != null) 
                                            <thead class="text-muted table-light">
                                                <tr class="text-uppercase">
                                                    <th class="sort" data-sort="id">Fecha Registro</th>
                                                    <th class="sort" data-sort="id">Oferta Educativa</th>
                                                    <th class="sort">Especialización</th>
                                                    <th class="sort" data-sort="nota">Componente</th>
                                                    <th class="sort">Seccion</th>
                                                    <th class="sort">Parcial</th>
                                                    <th class="sort">Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody class="list form-check-all">
                                                
                                                @foreach ($tblrecords as $key => $record)
                                                <tr>
                                                    <td>{{$record['fecha']}}</td>
                                                    <td>{{$record->servicio->descripcion}}</td>
                                                    <td>{{$record->servicio->especializacion->descripcion}}</td>
                                                    <td>{{$record->asignatura->descripcion}}</td>
                                                    <td>{{$record->curso->paralelo}}</td>
                                                    <td>{{$record->parcial}}</td>
                                                    <td>
                                                        <ul class="list-inline hstack gap-2 mb-0">
                                                            <li class="list-inline-item edit" data-bs-toggle="tooltip"
                                                                data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                                                <a href="" wire:click.prevent="edit({{ $record }})">
                                                                    <i class="ri-pencil-fill fs-16"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            
                                            </tbody>
                                            @endif 
                                        </table>
                                    </div>
                                </div>
                            </div>        
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--end col-->
    </div>
</div>
