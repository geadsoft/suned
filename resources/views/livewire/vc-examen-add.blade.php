<div>
    <form id="createactivity-form" autocomplete="off" wire:submit.prevent="{{ 'createData' }}" class="needs-validation" >
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="choices-publish-status-input" class="form-label fw-semibold">Modalidad</label>
                            <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false wire:model="modalidadId" {{$control}}>
                                <option value="">Seleccione Modalidad</option>
                                @foreach ($tblmodalidad as $modalidad) 
                                <option value="{{$modalidad->id}}">{{$modalidad->descripcion}}</option>
                                @endforeach 
                            </select>
                        </div>
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
                        <div class="row mb-3">
                            <div class="col-sm-6">
                                    <label for="choices-publish-status-input" class="form-label fw-semibold">Trimestre</label>
                                <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false wire:model="termino" required {{$control}}>
                                    @foreach ($tbltermino as $terminos) 
                                    <option value="{{$terminos->codigo}}">{{$terminos->descripcion}}</option>
                                    @endforeach 
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label for="choices-publish-status-input" class="form-label fw-semibold">Exámen</label>
                                <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false wire:model.defer="bloque" {{$control}}>
                                    @foreach ($tblbloque as $bloques) 
                                    <option value="{{$bloques['codigo']}}">{{$bloques['descripcion']}}</option>
                                    @endforeach 
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="mb-3">
                                <label class="form-label fw-semibold" for="product-title-input">Nombre de Exámen</label>
                                <input type="text" class="form-control" id="product-title-input" value="" placeholder="Ingrese nombre de actividad" wire:model.defer="nombre" required>
                                <div class="invalid-feedback">Por favor ingrese un nombre de actividad.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>                        
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Información Adicional</h5>
                    </div>
                    <div class="card-body">    
                        <!--<div class="mb-3">
                        <label class="form-label fw-semibold">Descripción de Actividad</label>
                        <div id="ckeditor-classic">
                            <p></p>
                        </div>
                    </div>-->
                        <div class="mb-3">
                            <label for="txtfecha" class="form-label fw-semibold">Fecha Máxima de Entrega</label>
                            <input type="date" class="form-control" id="fechaActual" data-provider="flatpickr" data-date-format="d-m-Y" data-time="true" wire:model.defer="fecha" required> 
                        </div>
                        <div class="mb-3">
                            <label for="horamaxima" class="form-label">Hora Máxima de Entrega</label>
                            <input type="time" class="form-control" id="horamaxima" wire:model.defer="hora" required>
                        </div>
                        <div class="mb-3">
                            <label for="choices-publish-status-input" class="form-label fw-semibold">Permitir la subida de archivos</label>
                            <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false wire:model.defer="archivo">
                                <option value="SI" selected>SI</option>
                                <option value="NO">NO</option>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label for="choices-publish-visibility-input" class="form-label fw-semibold">Puntaje</label>
                            <input id="calificacion-insumo" type="number" min="1" max="10" step="1" class="form-control" value="10" wire:model.defer="puntaje" required> 
                        </div>
                    </div>
                </div>
            </div>
        </div>    


        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div style="display: none">{{$texteditor}}</div>
                        <div class="mb-3" wire:ignore>
                            <label class="form-label fw-semibold">Descripción de Actividad</label>
                            <textarea id="editor" wire:model="texteditor" disabled>
                                
                            </textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Adjuntos</label>
                            <table class="table table-nowrap align-middle" id="orderTable">
                                <tbody>
                                @foreach ($array_attach as $key => $recno) 
                                <tr class="det-{{$recno['linea']}}">
                                @if ($recno['drive_id']!="")
                                <td>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon3">Archivo</span>
                                        <input type="text" id="file-{{$recno['linea']}}" wire:model.prevent="array_attach.{{$key}}.adjunto" class="form-control">
                                        <a href="#" id="drive-{{$recno['linea']}}" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" wire:click.prevent='download_drive({{$recno['id']}})'><i class="ri-download-2-line fs-18"></i></a>
                                        <a id="btnadd-{{$recno['linea']}}" class ="btn btn-icon btn-topbar btn-ghost-success rounded-circle" wire:click="attach_add()"><i class="text-secondaryimary ri-add-fill fs-18"></i></a>
                                        <a id="btndel-{{$recno['linea']}}" class ="btn btn-icon btn-topbar btn-ghost-danger rounded-circle" wire:click="attach_del({{$recno['linea']}})"><i class="text-danger ri-subtract-line fs-18"></i></a>
                                    </div>
                                </td>
                                @else
                                <td>
                                    <div class="input-group">
                                    <input type="file" id="file-{{$recno['linea']}}" wire:model="array_attach.{{$key}}.adjunto"  accept=".doc,.docx,.xls,.xlsx,.ppt,.pptx,.pdf,.html,.jpg,.png" class="form-control">
                                    {{-- Indicador de carga --}}
                                    <a id="btnadd-{{$recno['linea']}}" class ="btn" wire:click="attach_add()"><i class="text-secondaryimary ri-add-fill fs-16"></i></a>
                                    <a id="btndel-{{$recno['linea']}}" class ="btn" wire:click="attach_del({{$recno['linea']}})" onclick="document.getElementById('file-{{$recno['linea']}}').value='';"><i class="text-danger ri-subtract-line fs-16"></i></a>
                                    </div>
                                    <div wire:loading wire:target="array_attach.{{$key}}.adjunto" class="text-danger">
                                        Cargando archivo...
                                    </div>
                                </td>
                                @endif
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
        
        <!-- end row -->
        <div class="text-end mb-3">
            @if ($this->actividadId==0)
            <button type="submit" class="btn btn-success w-sm">Grabar</button>
            @else
            <button type="submit" class="btn btn-success w-sm">Actualizar</button>
            @endif
            <a class="btn btn-secondary w-sm" href="/activities/exams"><i class="me-1 align-bottom"></i>Cancelar</a>
        </div>
    </form>
</div>
