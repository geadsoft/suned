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
                        <h5 class="card-title mb-0 flex-grow-1">Registro de Documentación</h5>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form autocomplete="off" wire:submit.prevent="{{ 'createData' }}">
                        <div class="row">
                            <div class="col-sm-7">
                                <div class="row mb-3">
                                    <!--<div class="col-sm-2">
                                        <label for="record.descripcion" class="form-label">Periodo Lectivo</label>
                                        <select class="form-control" data-choices data-choices-search-false
                                            name="choices-single-default" id="idStatus">
                                            <option value="">Status</option>
                                            <option value="all" selected>All</option>
                                            <option value="Pending">Pending</option>
                                        </select>
                                    </div>-->
                                    <div class="col-sm-3">
                                        <label for="record.descripcion" class="form-label">Modalidad</label>
                                        <select class="form-select" name="select-modalidad" id="modalidad" wire:model="filters.modalidadId">
                                            <option value="">Seleccione</option>
                                            @foreach($modalidades as $data)
                                                <option value="{{$data->id}}">{{$data->descripcion}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-5">
                                        <label for="record.descripcion" class="form-label">Curso</label>
                                        <select class="form-select" name="select-cursos" id="cursos" wire:model="filters.cursoId">
                                            <option value="">Seleccione</option>
                                            @foreach($cursos as $curso)
                                                <option value="{{$curso->id}}">{{$curso->descripcion}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <label for="record.descripcion" class="form-label">Paralelo</label>
                                        <select class="form-select" name="select-paralelo" id="paralelo" wire:model="filters.paraleloId" wire:change="loadPersonas()">
                                            <option value="">Seleccione</option>
                                            @foreach($paralelos as $paralelo)
                                                <option value="{{$paralelo->id}}">{{$paralelo->paralelo}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                    <label for="record.descripcion" class="form-label">Buscar Estudiante</label>
                                    <!--<div class="search-box">
                                        <input type="text" class="form-control search"
                                            placeholder="Search for order ID, customer, order status or something...">
                                        <i class="ri-search-line search-icon"></i>
                                    </div>-->
                                    <select class="form-select" name="select-estudiante" id="estudiante" wire:model="filters.personaId" wire:change="consulta()">
                                        <option value="">Seleccione</option>
                                        @foreach($personas as $persona)
                                            <option value="{{$persona->id}}">{{$persona->apellidos}} {{$persona->nombres}}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="card border shadow-none mb-3">
                                    <div class="card-body">
                                        <div class="row align-items-center gy-3">

                                            {{-- Icono --}}
                                            <!--<div class="col-auto">
                                                <div class="avatar-lg">
                                                    <div class="avatar-title bg-primary-subtle text-primary rounded-circle fs-32">
                                                        <i class="ri-user-fill"></i>
                                                    </div>
                                                </div>
                                            </div>-->
                                            <div class="col-auto">
                                                <div class="profile-user position-relative d-inline-block mx-auto mb-4">
                                                    @if ($fileimg)
                                                        <img src="{{ $fileimg->temporaryURL() }}"
                                                            class="rounded-circle avatar-lg img-thumbnail user-profile-image"
                                                            alt="user-profile-image">
                                                    @else
                                                        <img src="@if ($foto != '') {{ URL::asset('storage/fotos/'.$foto) }}@else{{ URL::asset('assets/images/users/sin-foto.jpg') }} @endif"
                                                            class="rounded-circle avatar-lg img-thumbnail user-profile-image"
                                                            alt="user-profile-image">
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- Datos del estudiante --}}
                                            <div class="col-md">
                                                <div class="mb-3 mb-md-0">
                                                    <p class="text-muted mb-1 fs-12">Estudiante</p>

                                                    <h6 class="mb-3 fw-semibold text-uppercase">
                                                        {{ $record->estudiante ?? '-' }}
                                                    </h6>

                                                    <p class="text-muted mb-1 fs-12">Representante</p>

                                                    <h6 class="mb-0 fw-semibold text-uppercase">
                                                        {{ $record->representante?? '-' }}
                                                    </h6>
                                                </div>
                                            </div>

                                            {{-- Curso y fecha --}}
                                            <div class="col-md-4">
                                                <div class="row gy-3">

                                                    <div class="col-12">
                                                        <p class="text-muted mb-1 fs-12">Curso</p>

                                                        <h6 class="mb-0 fw-medium">
                                                            {{ $estudiante->curso ?? '-' }}
                                                        </h6>
                                                    </div>

                                                    <div class="col-12">
                                                        <p class="text-muted mb-1 fs-12">Fecha de registro</p>

                                                        <div class="d-flex align-items-center gap-2">
                                                            <h6 class="mb-0 fw-medium">
                                                                {{ isset($record->fecha)
                                                                    ? \Carbon\Carbon::parse($record->fecha)->format('d/m/Y')
                                                                    : now()->format('d/m/Y') }}
                                                            </h6>

                                                            <i class="ri-calendar-line fs-18 text-primary"></i>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        

                        

                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h6 class="flex-grow-1 mb-0 text-primary fw-bold">DOCUMENTOS REQUERIDOS SEGUN EL CURSO</h6>
                            </div>
                        </div>
                        <div class="card">
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 40px">#</th>
                                            <th>Documento</th>
                                            <th>Desde</th>
                                            <th>Hasta</th>
                                            <th class="text-center" style="width: 100px">Entregado</th>
                                            <th class="text-center" style="width: 100px">Faltante</th>
                                            <th style="width: 200px">Observación</th>
                                            <th style="width: 250px">Archivo</th>
                                            <th class="text-center" style="width: 80px"></th>
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
                                                <td>
                                                    {{ $documento['desde'] }}
                                                </td>
                                                <td>
                                                    {{ $documento['hasta'] }}
                                                </td>

                                                <td class="text-center">
                                                    <!--<input
                                                        type="checkbox"
                                                        class="form-check-input"
                                                        wire:model.live="documentos.{{ $expedienteId }}.entregado"
                                                        wire:change="marcarEntregado({{ $expedienteId }})"
                                                    >-->
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

                                                <!--<td>
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
                                                </td>-->
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
                                                            accept=".pdf,.jpg,.jpeg,.png"
                                                        >

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
                                                        @endif
                                                        <li class="list-inline-item" data-bs-toggle="tooltip"
                                                            data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                                            <a class="text-danger d-inline-block remove-item-btn"
                                                                data-bs-toggle="modal" href="" wire:click.prevent="eliminarArchivo({{ $expedienteId }})">
                                                                <i class="ri-delete-bin-5-fill fs-16"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                    <!--<button
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
                                                    -->
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
                        <div class="mb-3">
                                <button type="button" wire:click.prevent="" class="btn btn-soft-secondary w-sm">Agregar documentos Extras</button>
                        </div>
                        <div class="row mt-3">

                            {{-- Documentación completa --}}
                            <div class="col-12 mb-3">

                                <div class="form-check form-check-primary mb-1">
                                    <input class="form-check-input"
                                        type="checkbox"
                                        id="documentacionCompleta"
                                        wire:model="record.documentacion_completa">

                                    <label class="form-check-label fw-semibold" for="documentacionCompleta">
                                        Documentación completa
                                    </label>

                                    <i class="ri-information-line text-primary ms-1"
                                    data-bs-toggle="tooltip"
                                    title="Al marcar esta opción, la impresión indicará que la documentación está completa.">
                                    </i>
                                </div>

                                <small class="text-success">
                                    Al marcar esta opción, se indicará en la impresión que la documentación está completa.
                                </small>

                            </div>

                            {{-- Comentario impresión --}}
                            <div class="col-md-6">

                                <label class="form-label fw-medium">
                                    Comentario para impresión
                                    <small class="text-muted">(se mostrará en la recepción)</small>
                                </label>

                                <div class="position-relative">

                                    <textarea
                                        class="form-control"
                                        rows="4"
                                        maxlength="200"
                                        wire:model.live="record.comentario_impresion"
                                        placeholder="Ingrese un comentario..."></textarea>

                                    <small class="position-absolute bottom-0 end-0 me-2 mb-1 text-muted">
                                        {{ strlen($record['comentario_impresion'] ?? '') }}/200
                                    </small>

                                </div>

                            </div>

                            {{-- Comentario interno --}}
                            <div class="col-md-6">

                                <label class="form-label fw-medium">
                                    Comentario interno para Secretaría
                                    <small class="text-muted">(no se imprimirá)</small>
                                </label>

                                <div class="position-relative">

                                    <textarea
                                        class="form-control"
                                        rows="4"
                                        maxlength="200"
                                        wire:model.live="record.comentario_interno"
                                        placeholder="Ingrese un comentario interno..."></textarea>

                                    <small class="position-absolute bottom-0 end-0 me-2 mb-1 text-muted">
                                        {{ strlen($record['comentario_interno'] ?? '') }}/200
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4 mb-3">
                            <div class="col-12">
                                <div class="d-flex justify-content-center flex-wrap gap-3">

                                    <button class="btn btn-success btn-label" style="min-width:180px;">
                                        <i class="ri-save-line label-icon"></i>
                                        Guardar
                                    </button>

                                    <button class="btn btn-primary btn-label" style="min-width:220px;">
                                        <i class="ri-printer-line label-icon"></i>
                                        Imprimir recepción
                                    </button>

                                    <button class="btn btn-light border btn-label" style="min-width:190px;">
                                        <i class="ri-download-2-line label-icon"></i>
                                        Descargar PDF
                                    </button>

                                    <button class="btn btn-outline-danger btn-label" style="min-width:180px;">
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
