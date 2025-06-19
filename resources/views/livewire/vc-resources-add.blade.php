<div>
    <form id="createactivity-form" autocomplete="off" wire:submit.prevent="{{ 'createData' }}" class="needs-validation">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="asignatura-select" class="form-label fw-semibold">Asignatura</label>
                            <select class="form-select" id="asignatura-select" data-choices data-choices-search-false wire:model="asignaturaId" {{$control}} required>
                                <option value="">Seleccione Asignatura</option>
                                @foreach ($tblasignatura as $asignatura) 
                                <option value="{{$asignatura->id}}">{{$asignatura->descripcion}}</option>
                                @endforeach 
                            </select>
                        </div>
                        <div class="mb-3">
                            <div class="mb-3">
                                <label class="actividad" for="product-title-input">Nombre Actividad</label>
                                <input type="text" class="form-control" id="actividad-input" value="" placeholder="Ingrese nombre de actividad" wire:model.defer="nombre" required>
                                <div class="invalid-feedback">Por favor ingrese un nombre para el recurso.</div>
                            </div>
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
                                    <input type="file" id="file-{{$recno['linea']}}" wire:model="array_attach.{{$key}}.adjunto" accept=".doc,.docx,.xls,.xlsx,.ppt,.pptx,.pdf,.html,.jpg,.png" class="form-control">
                                    {{-- Indicador de carga --}}
                                    <a id="btnadd-{{$recno['linea']}}" class ="btn" wire:click="attach_add()"><i class="text-secondaryimary ri-add-fill fs-16"></i></a>
                                    <a id="btndel-{{$recno['linea']}}" class ="btn" wire:click="attach_del({{$recno['linea']}})"><i class="text-danger ri-subtract-line fs-16"></i></a>
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
                            <input type="text" class="form-control" id="product-title-input" placeholder="Ingrese enlace externo" pattern="https://.*" size="30" wire:model="enlace">
                            <div class="invalid-feedback">Por favor ingrese enlace externo.</div>
                        </div>
                        @if ($this->recursoId>0)
                        <div class="mb-3">
                            <label for="choices-publish-status-input" class="form-label fw-semibold">Estado Actividad</label>
                            <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false wire:model.defer="estado">
                                <option value="A">Activo</option>
                                <option value="F">Finalizado</option>
                            </select>
                        </div>
                        @endif
                        <div class="card-header mb-3">
                            <div class="d-flex">
                                <h5 class="card-title flex-grow-1 mb-0"><i class="mdi mdi-check-underline align-middle me-1 text-muted"></i>Aplicar Recurso</h5>
                                <div class="flex-shrink-0">
                                    <a href="javascript:void(0);" class="badge bg-primary-subtle text-primary fs-11">Todos</a>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            @foreach ($tblparalelo as $modalidad => $niveles)
                                <strong>{{ $modalidad }}</strong>
                                <ul>
                                    @foreach ($niveles as $nivel => $cursos)
                                        <li>
                                            <em>{{ $nivel }}</em>
                                            <ul>
                                                @foreach ($cursos as $curso)
                                                    <li>
                                                        <label>
                                                            <input type="checkbox" wire:model="selectedCursos" value="{{ $curso->id }}">
                                                            {{ $curso->curso }} - {{$curso->paralelo}}
                                                        </label>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endforeach
                                </ul>
                            @endforeach
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->

        <!--<div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div style="display: none">{{$texteditor}}</div>
                        <div class="mb-3" wire:ignore>
                            <label class="form-label fw-semibold">Descripción de Actividad</label>
                            <textarea id="editor" wire:model="texteditor" disabled>
                                
                            </textarea>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>-->
        <div class="text-end mb-3">
            @if ($this->recursoId==0)
            <button type="submit" class="btn btn-success w-sm">Grabar</button>
            @else
            <button type="submit" class="btn btn-success w-sm">Actualizar</button>
            @endif
            <a class="btn btn-secondary w-sm" href="/subject/resources"><i class="me-1 align-bottom"></i>Cancelar</a>
        </div>
    </form>
</div>
