<div>
    <div class="row">
        <div class="col-lg-12">
            @csrf
            <form autocomplete="off" wire:submit.prevent="{{ 'createData' }}">
            <div class="card" id="orderList">
                <div class="card-body border border-dashed border-end-0 border-start-0 ">
                    
                        <div class="row">
                            <div class="card-body row">
                                <div class="col-xxl-3 col-sm-3">
                                </div>
                                <div class="col-xxl-6 col-sm-6">
                                    <div class="row mb-3">
                                        <div class="col-lg-3">
                                            <label class="form-label mt-2 me-5" for="cmbgrupo">Grupo</label>
                                        </div>
                                        <div class="col-lg-9">
                                            <select class="form-select" data-choices data-choices-search-false id="cmbgrupo" wire:model="grupoId" required>
                                                <option value="">Seleccionar</option>
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
                                            <label class="form-label mt-2 me-5" for="cmboferta">Oferta Acádemica</label>
                                        </div>
                                        <div class="col-lg-9">
                                            <select class="form-select" id="cmboferta" wire:model="servicioId" required> 
                                                <option value="" selected>Seleccionar</option>
                                                @if ($tblservicios != null)
                                                    @foreach ($tblservicios as $servicio)
                                                        <option value="{{$servicio->id}}">{{$servicio->descripcion}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-lg-3">
                                            <label class="form-label mt-2 me-5" for="cmbnivel">Nivel</label>
                                        </div>
                                        <div class="col-lg-9">
                                            <select class="form-select" id="cmbnivel" wire:model="nivelId" disabled> 
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
                                            <label class="form-label mt-2 me-5" for="cmbgrado">Grado</label>
                                        </div>
                                        <div class="col-lg-9">
                                            <select class="form-select" id="cmbgrado" wire:model="gradoId" disabled> 
                                                <option value="" selected>Seleccionar</option>
                                                @foreach ($tblgenerals as $general)
                                                    @if ($general->superior == 3)
                                                    <option value="{{$general->id}}">{{$general->descripcion}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-lg-3">
                                            <label class="form-label mt-2 me-5" for="cmbespecialidad">Especialización</label>
                                        </div>
                                        <div class="col-lg-9">
                                            <select class="form-select" id="cmbespecialidad" wire:model="especialidadId" disabled> 
                                                <option value="" selected>Seleccionar</option>
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
                                            <label class="form-label mt-2 me-5" for="cmbplectivo">Periodo Lectivo</label>
                                        </div>
                                        <div class="col-lg-9">
                                            <select class="form-select" id="cmbplectivo" wire:model="periodoId" required> 
                                                <option value="" selected>Seleccionar</option>
                                                @foreach ($tblperiodos as $periodo)
                                                    <option value="{{$periodo->id}}">{{$periodo->descripcion}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-lg-3">
                                            <label class="form-label mt-2 me-5" for="cmbseccion">Sección</label>
                                        </div>
                                        <div class="col-lg-9">
                                            <select class="form-select" id="cmbseccion" wire:model="cursoId" required> 
                                                <option value="" selected>Seleccionar</option>
                                                @if ($tblcursos != null)
                                                    @foreach ($tblcursos as $curso)
                                                        <option value="{{$curso->id}}">{{$curso->paralelo}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-lg-3">
                                            <label class="form-label mt-2 me-5" for="cmbestudio">Componente Plan de Estudio</label>
                                        </div>
                                        <div class="col-lg-9">
                                            <select class="form-select" id="cmbestudio" wire:model="componenteId" required> 
                                                <option value="" selected>Seleccionar</option>
                                                @if ($tblmaterias != null)
                                                    @foreach ($tblmaterias as $materia)
                                                        <option value="{{$materia->asignatura_id}}">{{$materia->asignatura->descripcion}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-lg-3">
                                            <label class="form-label mt-2 me-5" for="">Ciclo Acádemico</label>
                                        </div>
                                        <div class="col-lg-9">
                                            <div class="input-group">
                                            <!-- Base Radios -->
                                            <div class="form-check form-radio-success mb-2 mt-2 me-5">
                                                <input class="form-check-input" value="T" type="radio" name="flexRadioDefault" id="flexRadioDefault1" wire:model="ciclo" checked>
                                                <label class="form-check-label" for="flexRadioDefault1">
                                                    Trimestre
                                                </label>
                                            </div>
                                            <div class="form-check form-radio-warning mb-2 mt-2 me-5">
                                                <input class="form-check-input" value="Q" type="radio" name="flexRadioDefault" id="flexRadioDefault2" wire:model="ciclo" >
                                                <label class="form-check-label" for="flexRadioDefault2">
                                                    Quimestre
                                                </label>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-lg-3">
                                            <label class="form-label mt-2 me-5" for="cmbpacademico">Evaluación</label>
                                        </div>
                                        <div class="col-lg-9">
                                            <select class="form-select" id="cmbpacademico" wire:model="evaluacion" required> 
                                                <option value="N">Cuantitativa</option>    
                                                <option value="L">Cualitativa</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-lg-3">
                                            <label class="form-label mt-2 me-5" for="cmbpacademico">Parcial</label>
                                        </div>
                                        <div class="col-lg-9">
                                            <select class="form-select" id="cmbpacademico" wire:model="parcial" required> 
                                                <option value="" selected>Seleccionar</option>    
                                                <option value="P1">P1 - Primer Periodo</option>
                                                <option value="P2">P2 - Segundo Periodo</option>
                                                <option value="P3">P3 - Tercer Periodo</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-lg-3">
                                            <label class="form-label mt-2 me-5" for="cmbfecha">Fecha</label>
                                        </div>
                                        <div class="col-lg-3">
                                            <input type="date" class="form-control" id="cmbfecha" data-provider="flatpickr" data-date-format="d-m-Y" data-time="true" wire:model.defer="fecha" required> 
                                        </div>
                                    </div>                
                                </div>
                                <div class="col-xxl-3 col-sm-3">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="card-body row">
                            </div>
                        </div>
                </div>
            </div>
            <div class="card" id="orderList">
                <div class="card-body pt-0">
                    <div>
                        @if ($tbldetalle != null)
                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle" id="orderTable">
                                <thead class="text-muted table-light">
                                    <tr class="text-uppercase">
                                        <th class="sort" data-sort="id">Identificación</th>
                                        <th class="sort" data-sort="apellidos">Apellidos</th>
                                        <th class="sort" data-sort="nombres">Nombres</th>
                                        <th class="sort">Fecha</th>
                                        <th class="sort" data-sort="nota">Calificación</th>
                                        <th class="sort">Observación</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                
                                    @foreach ($tbldetalle as $key => $data)
                                    <tr>
                                        <td>{{$data['nui']}}</td>
                                        <td>{{$data['apellidos']}}</td>
                                        <td>{{$data['nombres']}}</td>
                                        <td><input type="date" class="form-control form-control-sm bg-light border-0" id="fechaActual-{{$key}}" 
                                            data-provider="flatpickr" data-date-format="d-m-Y" data-time="true" wire:model="tbldetalle.{{$key}}.fecha">
                                        </td>
                                        <td>
                                            @if ($evaluacion=='N')
                                            <input type="number" step="0.01" class="form-control form-control-sm bg-light border-0 product-price"
                                                     id="nota-{{$key}}" wire:model="tbldetalle.{{$key}}.nota"/>
                                            @else
                                            
                                            <select class="form-select form-select-sm bg-light border-0" id="nota-{{$key}}" wire:model="tbldetalle.{{$key}}.escala" required> 
                                                <option value="" selected>Seleccionar</option>    
                                                <option value="EX">EX - Excelente</option>
                                                <option value="MB">MB - Muy Bueno</option>
                                                <option value="B">B - Bueno</option>
                                                <option value="R">R - Regular</option>
                                            </select>
                                            @endif
                                        </td>
                                        <td><input type="text" class="form-control form-control-sm bg-light border-0"
                                                     id="obs-{{$key}}" wire:model="tbldetalle.{{$key}}.observacion" /></td>
                                    </tr>
                                    @endforeach
                                
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="text-end">
                        <button type="submit" class="btn btn-success w-sm">Grabar</button>
                        <a class="btn btn-secondary w-sm" href=""><i class="me-1 align-bottom"></i>Cancelar</a>
                    </div>
                </div>            
            </div>
            </form>
        </div>
        <!--end col-->
    </div>
</div>

