<div>
    <style>
        .btn-upload {
            width: 30px;
            height: 30px;
            border: 1px solid #a8c7ff;
            border-radius: 5px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #0d6efd;
            background-color: #ffffff;
            cursor: pointer;
            font-size: 17px;
            margin: 0;
            transition: all 0.2s ease;
        }

        .btn-upload:hover {
            background-color: #eef5ff;
            border-color: #0d6efd;
            color: #0b5ed7;
        }

        .nombre-archivo {
            font-size: 12px;
            color: #0d6efd;
            text-decoration: none;
            max-width: 180px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .nombre-archivo:hover {
            text-decoration: underline;
        }
    </style>
     <div class="row">
        <div class="col-lg-12">
            <div class="card" id="orderList">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Retiro de Documentación</h5>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form autocomplete="off" wire:submit.prevent="{{ 'createData' }}">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <label for="record.descripcion" class="form-label">Modalidad</label>
                                        <select class="form-select" name="select-modalidad" id="modalidad" wire:model="filters.modalidadId" required>
                                            <option value="">Seleccione</option>
                                            @foreach($modalidades as $data)
                                                <option value="{{$data->id}}">{{$data->descripcion}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="record.descripcion" class="form-label">Curso</label>
                                        <select class="form-select" name="select-cursos" id="cursos" wire:model="filters.cursoId" required>
                                            <option value="">Seleccione</option>
                                            @foreach($cursos as $curso)
                                                <option value="{{$curso->id}}">{{$curso->descripcion}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <label for="record.descripcion" class="form-label">Paralelo</label>
                                        <select class="form-select" name="select-paralelo" id="paralelo" wire:model="filters.paraleloId" wire:change="loadPersonas()" required>
                                            <option value="">Seleccione</option>
                                            @foreach($paralelos as $paralelo)
                                                <option value="{{$paralelo->id}}">{{$paralelo->paralelo}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="record.descripcion" class="form-label">Buscar Estudiante</label>
                                        <select class="form-select" name="select-estudiante" id="estudiante" wire:model="filters.personaId" required>
                                            <option value="">Seleccione</option>
                                            @foreach($personas as $persona)
                                                <option value="{{$persona->id}}">{{$persona->apellidos}} {{$persona->nombres}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h6 class="flex-grow-1 mb-0 text-primary fw-bold">DOCUMENTOS REGISTRADOS PARA EL RETIRO</h6>
                            </div>
                        </div>
                        <div class="card">
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 40px">#</th>
                                            <th>Documento</th>
                                            <th class="text-center" style="width: 100px">Registrado</th>
                                            <th class="text-center" style="width: 100px">Retirado</th>
                                            <th class="text-center" style="width: 100px">Faltante</th>
                                            <th style="width: 200px">Observación</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse($documentos as $expedienteId => $documento)
                                            <tr wire:key="expediente-{{ $expedienteId }}">

                                                <td>
                                                    {{ $loop->iteration }}
                                                </td>

                                                <td>
                                                    {{ $documento['descripcion'] }}
                                                </td>
                                                <td class="text-center">
                                                    {{ $documento['entregado'] }}
                                                </td>
                                                <td class="text-center">
                                                    <div class="form-check form-check-success text-center">
                                                        <input class="form-check-input" type="checkbox" wire:model.live="documentos.{{ $expedienteId }}.retirado"
                                                        wire:change="marcarRetirado({{ $expedienteId }})"  {{ $documento['entregado'] == 'No' ? 'disabled' : '' }}>
                                                    </div>
                                                </td>

                                                <td class="text-center">
                                                    <div class="form-check form-check-danger text-center">
                                                        <input class="form-check-input" type="checkbox"  wire:model.live="documentos.{{ $expedienteId }}.faltante"
                                                        wire:change="marcarFaltante({{ $expedienteId }})" disabled>
                                                    </div>
                                                </td>

                                                <td>
                                                    <input
                                                        type="text"
                                                        class="form-control form-control-sm"
                                                        wire:model.defer="documentos.{{ $expedienteId }}.observacion"
                                                        placeholder="Observación" readonly>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center text-muted">
                                                    No existen documentos requeridos para este curso.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row mt-3">

                            {{-- Documentación completa --}}
                            <div class="col-12 mb-3">

                                <div class="form-check form-check-primary mb-1">
                                    <input class="form-check-input"
                                        type="checkbox"
                                        id="documentacionRetirada"
                                        wire:model="documentacionRetirada">

                                    <label class="form-check-label fw-semibold" for="documentacionRetirada">
                                        Documentación retirada completa
                                    </label>

                                    <i class="ri-information-line text-primary ms-1"
                                    data-bs-toggle="tooltip"
                                    title="Al marcar esta opción, la impresión indicará que la documentación se retiró completamente.">
                                    </i>
                                </div>

                                <small class="text-success">
                                    Al marcar esta opción, la impresión indicará que la documentación se retiró completamente.
                                </small>

                            </div>

                            {{-- Comentario interno --}}
                            <div class="col-md-12">

                                <label class="form-label fw-medium">
                                    Comentario
                                    <small class="text-muted">(se mostrará en documento de retiro)</small>
                                </label>

                                <div class="position-relative">

                                    <textarea
                                        class="form-control"
                                        rows="4"
                                        maxlength="200"
                                        wire:model.live="comentarioRetiro"
                                        placeholder="Ingrese un comentario interno..."></textarea>

                                    <small class="position-absolute bottom-0 end-0 me-2 mb-1 text-muted">
                                        {{ strlen($comentarioRetiro ?? '') }}/200
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4 mb-3">
                            <div class="col-12">
                                <div class="d-flex justify-content-center flex-wrap gap-3">

                                    <button type="submit" class="btn btn-success btn-label" style="min-width:180px;">
                                        <i class="ri-save-line label-icon"></i>
                                        Guardar
                                    </button>

                                    <button
                                        type="button"
                                        class="btn btn-primary btn-label" style="min-width:220px;"
                                        onclick="window.open('{{ route('expedientes-retiro.imprimir', $matriculaId ?? 0) }}', '_blank')"
                                        @disabled(empty($matriculaId))>
                                        <i class="ri-printer-line label-icon"></i>
                                        Imprimir retiro
                                    </button>

                                    <a
                                        href="/download-pdf/retire-documentation/{{$matriculaId}}"
                                        class="btn btn-light border btn-label {{ !$matriculaId ? 'disabled' : '' }}"
                                        style="min-width:190px;"
                                    >
                                        <i class="ri-download-2-line label-icon"></i>
                                        Descargar PDF
                                    </a>
                                    
                                    <button type="button"
                                        class="btn btn-outline-danger btn-label"
                                        style="min-width:180px;"
                                        onclick="location.reload();">
                                        <i class="ri-delete-bin-line label-icon"></i>
                                        Limpiar
                                    </button>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
