<div>
    <form id="createactivity-form" autocomplete="off" wire:submit.prevent="{{ 'createData' }}" class="needs-validation" >
        <div class="row">
            <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="choices-publish-status-input" class="form-label fw-semibold">Asignatura</label>
                                <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false wire:model="asignaturaId" {{$control}}>
                                   <option value="">Seleccione Asignatura</option>
                                   @foreach ($tblasignatura as $asignatura) 
                                    <option value="{{$asignatura->id}}">{{$asignatura->descripcion}}</option>
                                    @endforeach 
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="choices-publish-status-input" class="form-label fw-semibold">Paralelos Asignados</label>
                                <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false wire:model.defer="paralelo" required {{$control}}>
                                   <option value="">Seleccione Paralelo</option>
                                   @foreach ($tblparalelo as $paralelo) 
                                    <option value="{{$paralelo->id}}">{{$paralelo->descripcion}}</option>
                                    @endforeach 
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="choices-publish-status-input" class="form-label fw-semibold">Término</label>
                                <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false wire:model.defer="termino" required {{$control}}>
                                    @foreach ($tbltermino as $terminos) 
                                    <option value="{{$terminos->codigo}}">{{$terminos->descripcion}}</option>
                                    @endforeach 
                                    <!--<option value="1T" selected>Primer Trimestre</option>
                                    <option value="2T">Segundo Trimestre</option>
                                    <option value="3T">Tercer Trimestre</option>-->
                                </select>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <label for="choices-publish-status-input" class="form-label fw-semibold">Bloque</label>
                                    <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false wire:model.defer="bloque" {{$control}}>
                                        @foreach ($tblbloque as $bloques) 
                                        <option value="{{$bloques->codigo}}">{{$bloques->descripcion}}</option>
                                        @endforeach 
                                        <!--<option value="1P" selected>Primer Parcial</option>-->
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label for="choices-publish-status-input" class="form-label fw-semibold">Tipo Actividad</label>
                                    <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false wire:model.defer="tipo">
                                        @foreach ($tblactividad as $actividades) 
                                        <option value="{{$actividades->codigo}}">{{$actividades->descripcion}}</option>
                                        @endforeach 
                                        <!--<option value="AI">Actividad Individual</option>
                                        <option value="AG">Actividad Grupal</option>-->
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold" for="product-title-input">Nombre Actividad</label>
                                    <input type="text" class="form-control" id="product-title-input" value="" placeholder="Ingrese nombre de actividad" wire:model.defer="nombre" required>
                                    <div class="invalid-feedback">Por favor ingrese un nombre de actividad.</div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <!-- end card -->

                    <!--<div class="text-end mb-3">
                        <button type="submit" class="btn btn-success w-sm">Submit</button>
                    </div>-->
            </div>
            <!-- end col -->

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Información Adicional</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="txtfecha" class="form-label fw-semibold">Fecha Máxima de Entrega</label>
                            <input type="date" class="form-control" id="fechaActual" data-provider="flatpickr" data-date-format="d-m-Y" data-time="true" wire:model.defer="fecha" required> 
                        </div>

                        <div class="mb-3">
                            <label for="choices-publish-status-input" class="form-label fw-semibold">Permitir la subida de archivos</label>
                            <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false wire:model.defer="archivo">
                                <option value="SI" selected>SI</option>
                                <option value="NO">NO</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="choices-publish-visibility-input" class="form-label fw-semibold">Puntaje</label>
                            <input id="calificacion-insumo" type="number" min="1" max="10" step="1" class="form-control" value="10" wire:model.defer="puntaje" required>    
                        </div>
                        <br>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>
        </div>
        <!-- end row -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Descripción de Actividad</label>
                            <div id="ckeditor-classic">
                                <p></p>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Adjuntos</label>
                            <table class="table table-nowrap align-middle" id="orderTable">
                                <tbody>
                                @foreach ($array_attach as $key => $recno) 
                                <tr class="det-{{$recno['linea']}}">
                                <td>
                                    <div class="input-group">
                                    <input type="file" id="file-{{$recno['linea']}}" wire:model.prevent="array_attach.{{$key}}.adjunto" class="form-control">
                                    <a id="btnadd-{{$recno['linea']}}" class ="btn" wire:click="attach_add()"><i class="text-secondaryimary ri-add-fill fs-16"></i></a>
                                    <a id="btndel-{{$recno['linea']}}" class ="btn" wire:click="attach_del({{$recno['linea']}})"><i class="text-danger ri-subtract-line fs-16"></i></a>
                                    </div>
                                </td>
                                </tr>
                                 @endforeach
                                </tbody>
                            </table>                            
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold" for="product-title-input">Link externo</label>
                            <input type="text" class="form-control" id="product-title-input" value="" placeholder="Ingrese enlace externo" wire:model.defer="enlace">
                            <div class="invalid-feedback">Por favor ingrese enlace externo.</div>
                        </div>
                        @if ($this->actividadId>0)
                        <div class="mb-3">
                            <label for="choices-publish-status-input" class="form-label fw-semibold">Estado Actividad</label>
                            <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false wire:model.defer="tipo">
                                <option value="A">Activo</option>
                                <option value="I">Inactivo</option>
                            </select>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="text-end mb-3">
            @if ($this->actividadId==0)
            <button type="submit" class="btn btn-success w-sm">Grabar</button>
            @else
            <button type="submit" class="btn btn-success w-sm">Actualizar</button>
            @endif
            <a class="btn btn-secondary w-sm" href="/activities/activity"><i class="me-1 align-bottom"></i>Cancelar</a>
        </div>
    </form>
</div>
