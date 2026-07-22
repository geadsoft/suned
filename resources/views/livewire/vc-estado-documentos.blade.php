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
                        <h5 class="card-title mb-0 flex-grow-1">Estado de Documentación</h5>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form autocomplete="off" wire:submit.prevent="{{ 'createData' }}">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="row mb-3">
                                    <div class="col-sm-2">
                                        <label for="record.descripcion" class="form-label">Periodo Lectivo</label>
                                        <select class="form-control" name="select-periodo" id="periodo" wire:model="filters.periodoId">
                                            <option value="">Seleccione</option>
                                            @foreach($periodos as $periodo)
                                                <option value="{{$periodo->id}}">{{$periodo->descripcion}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="record.descripcion" class="form-label">Modalidad</label>
                                        <select class="form-select" name="select-modalidad" id="modalidad" wire:model="filters.modalidadId" required>
                                            <option value="">Seleccione</option>
                                            @foreach($modalidades as $data)
                                                <option value="{{$data->id}}">{{$data->descripcion}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-5">
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
                                        <select class="form-select" name="select-paralelo" id="paralelo" wire:model="filters.paraleloId" required>
                                            <option value="">Seleccione</option>
                                            @foreach($paralelos as $paralelo)
                                                <option value="{{$paralelo->id}}">{{$paralelo->paralelo}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-xl-3 col-md-6">
                                <div class="card border shadow-none h-100">
                                    <div class="card-body text-center py-3">
                                        <div class="text-muted fw-semibold mb-2">
                                            Estudiantes
                                        </div>

                                        <div class="fs-4 fw-bold text-dark">
                                            {{ $totalEstudiantes ?? 0 }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="card border shadow-none h-100">
                                    <div class="card-body text-center py-3">
                                        <div class="fw-semibold text-success mb-2">
                                            Documentación completa
                                        </div>

                                        <div class="fs-4 fw-bold text-success">
                                            {{ $totalCompletos ?? 0 }}
                                            <span class="fs-6">
                                                ({{ $porcentajeCompletos ?? 0 }}%)
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="card border shadow-none h-100">
                                    <div class="card-body text-center py-3">
                                        <div class="fw-semibold text-danger mb-2">
                                            Documentación incompleta
                                        </div>

                                        <div class="fs-4 fw-bold text-danger">
                                            {{ $totalIncompletos ?? 0 }}
                                            <span class="fs-6">
                                                ({{ $porcentajeIncompletos ?? 0 }}%)
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="card border shadow-none h-100">
                                    <div class="card-body text-center py-3">
                                        <div class="text-muted fw-semibold mb-2">
                                            Total faltantes
                                        </div>

                                        <div class="fs-4 fw-bold text-dark">
                                            {{ $totalFaltantes ?? 0 }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 40px">#</th>
                                            <th>Estudiante</th>
                                            <th>Curso</th>
                                            <th class="text-center" style="width: 100px">Doc. Completa</th>
                                            <th class="text-center" style="width: 100px">N° Doc. Faltantes</th>
                                            <th class="text-center" style="width: 150px">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($listadoDocumentos as $index => $item)
                                            <tr wire:key="matricula-{{ $item['matricula_id'] }}">
                                                <td class="text-center">
                                                    {{ $index + 1 }}
                                                </td>

                                                <td>
                                                    {{ mb_strtoupper($item['estudiante']) }}
                                                </td>

                                                <td>
                                                    {{ mb_strtoupper($item['curso']) }}
                                                </td>

                                                <td class="text-center">
                                                    @if($item['documentacion_completa'])
                                                        <span class="text-success fw-semibold">
                                                            Sí
                                                        </span>
                                                    @else
                                                        <span class="text-danger fw-semibold">
                                                            No
                                                        </span>
                                                    @endif
                                                </td>

                                                <td class="text-center fw-semibold">
                                                    {{ $item['total_faltantes'] }}
                                                </td>

                                                <td class="text-center">
                                                    @if($item['total_cargados']>0)
                                                        <button type="button"
                                                            class="btn btn-sm btn-outline-primary"
                                                            wire:click="verArchivos({{ $item['persona_id']}},{{ $item['matricula_id']}})">

                                                            <span>
                                                                {{ $estudianteSeleccionado == $item['persona_id'] ? 'Ocultar PDF' : 'Ver PDF' }}
                                                            </span>

                                                            <i class="{{ $estudianteSeleccionado == $item['persona_id']
                                                                ? 'ri-arrow-up-s-line'
                                                                : 'las la-file-pdf' }} ms-1 fs-18">
                                                            </i>
                                                        </button>
                                                    @else
                                                        <button
                                                            type="button"
                                                            class="btn btn-sm btn-outline-secondary"
                                                            disabled>
                                                            Ver PDF
                                                            <i class=" las la-file-pdf ms-1 fs-18"></i>
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                            {{-- Fila desplegable --}}
                                            @if($estudianteSeleccionado == $item['persona_id'])
                                                <tr>
                                                    <td colspan="6" class="bg-light p-0">
                                                        <div class="p-3">

                                                            <h6 class="fw-semibold mb-3">
                                                                <i class="ri-attachment-2 me-1"></i>
                                                                Archivos cargados de {{ mb_strtoupper($item['estudiante']) }}
                                                            </h6>

                                                            @forelse($archivosEstudiante as $archivo)

                                                                <div class="d-flex align-items-center justify-content-between
                                                                            border rounded bg-white p-2 mb-2">

                                                                    <div class="d-flex align-items-center gap-2">
                                                                        <!--<div class="avatar-sm">
                                                                            <span class="avatar-title bg-danger-subtle
                                                                                        text-danger rounded">
                                                                                <i class="las la-file-pdf fs-20"></i>
                                                                            </span>
                                                                        </div>-->
                                                                        <img src="{{ URL::asset('assets/images/Pdf.png') }}"
                                                                        alt="PDF"
                                                                        width="40"
                                                                        height="40">

                                                                        <div>
                                                                            <p class="mb-0 fw-medium">
                                                                                {{ $archivo['nombre'] ?? 'Documento' }}
                                                                            </p>

                                                                            <small class="text-muted">
                                                                                {{ $archivo['observacion'] ?? 'Sin observación' }}
                                                                            </small>
                                                                        </div>
                                                                    </div>

                                                                    <div class="d-flex gap-2">
                                                                        <a href="https://drive.google.com/file/d/{{ $archivo['drive_id'] }}/view"
                                                                        target="_blank"
                                                                        class="btn btn-sm btn-soft-primary">
                                                                            <i class="ri-eye-line me-1"></i>
                                                                            Ver PDF
                                                                        </a>

                                                                        <a href="https://drive.google.com/uc?export=download&id={{ $archivo['drive_id'] }}"
                                                                        class="btn btn-sm btn-outline-secondary">
                                                                            <i class="ri-download-2-line"></i>
                                                                        </a>
                                                                    </div>

                                                                </div>

                                                            @empty
                                                                <div class="alert alert-warning mb-0">
                                                                    <i class="ri-information-line me-1"></i>
                                                                    El estudiante no tiene archivos cargados.
                                                                </div>
                                                            @endforelse

                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-muted py-4">
                                                    No existen estudiantes en el paralelo seleccionado.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                    <!--<tbody>
                                        
                                        @forelse($documentos as $expedienteId => $documento)
                                            <tr wire:key="expediente-{{ $expedienteId }}">

                                                <td>
                                                    {{ $loop->iteration }}
                                                </td>

                                                <td>
                                                    {{ $documento['descripcion'] }}
                                                </td>
                                                <td>
                                                    {{ $documento['desde'] }}
                                                </td>
                                                <td>
                                                    {{ $documento['hasta'] }}
                                                </td>

                                                <td class="text-center">
                                                    <input
                                                        type="checkbox"
                                                        class="form-check-input"
                                                        wire:model.live="documentos.{{ $expedienteId }}.entregado"
                                                        wire:change="marcarEntregado({{ $expedienteId }})"
                                                    >
                                                    <div class="form-check form-check-success text-center">
                                                        <input class="form-check-input" type="checkbox" wire:model.live="documentos.{{ $expedienteId }}.entregado"
                                                        wire:change="marcarEntregado({{ $expedienteId }})">
                                                    </div>
                                                </td>

                                                <td class="text-center">
                                                   
                                                    <div class="form-check form-check-outline form-check-danger ">
                                                        <input class="form-check-input" type="checkbox"  wire:model.live="documentos.{{ $expedienteId }}.faltante"
                                                        wire:change="marcarFaltante({{ $expedienteId }})">
                                                    </div>
                                                </td>

                                                <td>
                                                    <input
                                                        type="text"
                                                        class="form-control form-control-sm"
                                                        wire:model.defer="documentos.{{ $expedienteId }}.observacion"
                                                        placeholder="Observación"
                                                    >
                                                </td>

                                                <td>
                                                    @if($documento['archivo_actual'])
                                                        <div class="d-flex align-items-center gap-2">
                                                            <a
                                                                href="{{ Storage::url($documento['archivo_actual']) }}"
                                                                target="_blank"
                                                                class="btn btn-sm btn-outline-primary"
                                                            >
                                                                <i class="ri-download-cloud-2-line"></i>
                                                            </a>

                                                            <a
                                                                href="{{ Storage::url($documento['archivo_actual']) }}"
                                                                target="_blank"
                                                            >
                                                                {{ basename($documento['archivo_actual']) }}
                                                            </a>
                                                        </div>
                                                    @else
                                                        <input
                                                            type="file"
                                                            class="form-control form-control-sm"
                                                            wire:model="documentos.{{ $expedienteId }}.archivo_nuevo"
                                                        >

                                                        <div wire:loading wire:target="documentos.{{ $expedienteId }}.archivo_nuevo">
                                                            Cargando archivo...
                                                        </div>
                                                    @endif

                                                    @error("documentos.$expedienteId.archivo_nuevo")
                                                        <small class="text-danger">
                                                            {{ $message }}
                                                        </small>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">

                                                        {{-- Botón para seleccionar archivo --}}
                                                        <label
                                                            for="archivo-{{ $expedienteId }}"
                                                            class="btn-upload"
                                                            title="Seleccionar archivo"
                                                        >
                                                            <i class="ri-upload-cloud-2-line"></i>
                                                        </label>

                                                        {{-- Input oculto --}}
                                                        <input
                                                            type="file"
                                                            id="archivo-{{ $expedienteId }}"
                                                            class="d-none"
                                                            wire:model="documentos.{{ $expedienteId }}.archivo_nuevo"
                                                            accept=".pdf,.jpg,.jpeg,.png" @disabled($documentacionCompleta)>

                                                        {{-- Nombre del archivo nuevo --}}
                                                        @if (!empty($documento['archivo_nuevo']))

                                                            <span class="nombre-archivo">
                                                                {{ $documento['archivo_nuevo']->getClientOriginalName() }}
                                                            </span>

                                                        {{-- Archivo existente --}}
                                                        @elseif (!empty($documento['archivo_actual']))

                                                            <a
                                                                href="{{ Storage::url($documento['archivo_actual']) }}"
                                                                target="_blank"
                                                                class="nombre-archivo"
                                                            >
                                                                {{ basename($documento['archivo_actual']) }}
                                                            </a>

                                                        @else

                                                            <span class="nombre-archivo">
                                                                Subir archivo
                                                            </span>

                                                        @endif

                                                        {{-- Indicador de carga --}}
                                                        <span
                                                            wire:loading
                                                            wire:target="documentos.{{ $expedienteId }}.archivo_nuevo"
                                                            class="text-primary"
                                                        >
                                                            Cargando...
                                                        </span>

                                                    </div>

                                                    @error("documentos.$expedienteId.archivo_nuevo")
                                                        <small class="text-danger d-block mt-1">
                                                            {{ $message }}
                                                        </small>
                                                    @enderror
                                                </td>

                                                <td class="text-center">
                                                    <ul class="list-inline hstack gap-2 mb-0">
                                                        @if($documento['archivo_nuevo'])
                                                        <li class="list-inline-item edit" data-bs-toggle="tooltip"
                                                            data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                                            <a class="text-success">
                                                                <i class="ri-checkbox-circle-line fs-18"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item" data-bs-toggle="tooltip"
                                                            data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                                            <a class="text-danger d-inline-block remove-item-btn"
                                                                data-bs-toggle="modal" href="" wire:click.prevent="eliminarArchivo({{ $expedienteId }})">
                                                                <i class="ri-delete-bin-5-fill fs-16"></i>
                                                            </a>
                                                        </li>
                                                        @endif
                                                        @if($documento['archivo_actual'])
                                                        <li class="list-inline-item" data-bs-toggle="tooltip"
                                                            data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                                            <a class="text-danger d-inline-block remove-item-btn"
                                                                data-bs-toggle="modal" href="" wire:click.prevent="eliminarArchivo({{ $expedienteId }})">
                                                                <i class="ri-delete-bin-5-fill fs-16"></i>
                                                            </a>
                                                        </li>
                                                        @endif
                                                    </ul>
                                                    <button
                                                        type="button"
                                                        class="btn btn-sm btn-success"
                                                        wire:click="guardarDocumento({{ $expedienteId }})"
                                                    >
                                                        <i class="ri-check-line"></i>
                                                    </button>

                                                    @if($documento['archivo_actual'])
                                                        <button
                                                            type="button"
                                                            class="btn btn-sm btn-danger"
                                                            wire:click="eliminarArchivo({{ $expedienteId }})"
                                                        >
                                                            <i class="ri-delete-bin-line"></i>
                                                        </button>
                                                    @endif
                                                    
                                                </td>

                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center text-muted">
                                                    No existen documentos requeridos para este curso.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>-->
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
