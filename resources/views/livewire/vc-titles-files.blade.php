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

        .panel-documentos {
            top: 80px;
        }

        .panel-documentos .card-header.bg-primary {
            background: linear-gradient(
                135deg,
                #2a1a70 0%,
                #2a1a70 100%
            ) !important;
        }

        .panel-documentos .card {
            border-radius: 6px;
            overflow: hidden;
        }

        .panel-documentos textarea {
            resize: vertical;
        }

        .panel-documentos .form-control:disabled,
        .panel-documentos .form-select:disabled {
            background-color: #f5f6f8;
            opacity: 0.75;
        }

        .table-active-student {
            background-color: rgba(64, 81, 137, 0.08);
        }

        @media (max-width: 991.98px) {
            .panel-documentos {
                position: static !important;
            }
        }
    </style>
    <div class="row g-3">

        {{-- CONTENEDOR DE FILTROS Y TABLA --}}
        <div class="{{ $mostrarPanel ? 'col-xxl-9 col-xl-9 col-lg-8' : 'col-12' }}">
            <div class="card" id="orderList">
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form>
                        <div class="row mb-3">
                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <label class="form-label fw-semibold">Periodo Lectivo</label>
                                    <select class="form-select" name="cmbnivel" wire:model="filters.srv_periodo">
                                        <option value="">Seleccionar Periodo</option>
                                        @foreach ($tblperiodos as $periodo)
                                            <option value="{{$periodo->id}}">{{$periodo->descripcion}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xxl-3 col-sm-4">
                                <label class="form-label fw-semibold">Modalidad</label>
                                <select class="form-select" name="cmbgrupo" wire:model="filters.srv_grupo">
                                    <option value="">Todas</option>
                                    @foreach ($tblgenerals as $general)
                                        @if ($general->superior == 1)
                                        <option value="{{$general->id}}">{{$general->descripcion}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xxl-3 col-sm-4">
                                <label class="form-label fw-semibold">Curso</label>
                                <select class="form-select" name="cmbgrupo" wire:model="filters.srv_curso">
                                    <option value="">Todos</option>
                                </select>
                            </div>
                            <div class="col-xxl-2 col-sm-4">
                                <label class="form-label fw-semibold">Paralelo</label>
                                <select class="form-select" name="cmbgrupo" wire:model="filters.srv_curso">
                                    <option value="">Todos</option>
                                </select>
                            </div>
                            <div class="col-xxl-2 col-sm-4">
                                <label class="form-label fw-semibold">Estado</label>
                                <select class="form-select" name="cmbgrupo" wire:model="filters.srv_curso">
                                    <option value="">Todos</option>
                                    <option value="CO">Completo</option>
                                    <option value="AE">Acta Entregada</option>
                                    <option value="TE">Título Entregada</option>
                                    <option value="PE">Pendiente</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-xxl-8 col-sm-6">
                                <div class="search-box">
                                    <input type="text" class="form-control search"
                                        placeholder="Buscar por nombre o apellidos" wire:model="filters.srv_nombre">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                        </div>
                        <!--end row-->
                    </form>
                </div>
            </div>
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 d-flex align-items-center">
                        <i class="ri-file-list-3-line text-primary fs-20 me-2"></i>
                        Estudiantes de 3ro Bachillerato
                    </h5>
                </div>
                <div class="card-body pt-0">
                    <div>
                        <ul class="nav nav-tabs nav-tabs-custom nav-success mb-3" role="tablist">
                        </ul>

                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle" id="orderTable">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width: 50px;">#</th>
                                        <th class="text-center" style="width: 70px;">Foto</th>
                                        <th>Estudiante</th>
                                        <th>Curso</th>
                                        <th class="text-center">Acta</th>
                                        <th class="text-center">Título</th>
                                        <th>Fecha Acta</th>
                                        <th>Fecha Título</th>
                                        <th class="text-center">Estado</th>
                                        <th>Responsable</th>
                                        <th class="text-center" style="width: 100px;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                @forelse($estudiantes as $index => $estudiante)
                                    <tr wire:key="estudiante-{{ $estudiante->id }}" class="{{ $estudiante->id == $estudianteSeleccionadoId ? 'table-info' : '' }}">
                                        <td class="text-center">
                                            {{ $estudiantes->firstItem() + $index }}
                                        </td>

                                        <td class="text-center">
                                            <div class="avatar-sm mx-auto">
                                                @if(!empty($estudiante->foto))
                                                    <img
                                                        src="@if ($estudiante->foto != '') {{ URL::asset('storage/fotos/'.$estudiante->foto) }}@else{{ URL::asset('assets/images/users/sin-foto.jpg') }} @endif"
                                                        alt=""
                                                        class="rounded-circle avatar-sm object-fit-cover"
                                                    >
                                                @else
                                                    <div
                                                        class="avatar-title rounded-circle bg-soft-primary text-primary fw-semibold">
                                                        {{ strtoupper(substr($estudiante->apellidos, 0, 1)) }}
                                                    </div>
                                                @endif
                                            </div>
                                        </td>

                                        <td>
                                            <span class="fw-semibold text-dark">
                                                {{ $estudiante->apellidos }} {{ $estudiante->nombres }}
                                            </span>

                                            @if(!empty($estudiante->documento))
                                                <small class="d-block text-muted">
                                                    {{ $estudiante->documento }}
                                                </small>
                                            @endif
                                        </td>

                                        <td>
                                            {{ $estudiante->nomgrado }} {{ $estudiante->paralelo }}
                                        </td>

                                        <td class="text-center">
                                            <div class="form-check form-check-success d-inline-block">
                                                @if($estudiante->acta_retirada)
                                                    <i class="ri-checkbox-circle-fill text-success fs-20 me-2"></i>
                                                @else
                                                    <i class=" ri-close-circle-fill text-danger fs-20 me-2"></i>
                                                @endif
                                            </div>
                                        </td>

                                        <td class="text-center">
                                            <div class="form-check form-check-success d-inline-block">
                                                @if($estudiante->titulo_retirado)
                                                    <i class="ri-checkbox-circle-fill text-success fs-20 me-2"></i>
                                                @else
                                                    <i class=" ri-close-circle-fill text-danger fs-20 me-2"></i>
                                                @endif
                                            </div>
                                        </td>

                                        <td>
                                            @if(!empty($estudiante->fecha_acta))
                                                <span class="text-muted">
                                                    <i class="ri-calendar-line me-1"></i>
                                                    {{ \Carbon\Carbon::parse(
                                                        $estudiante->fecha_acta
                                                    )->format('d/m/Y') }}
                                                </span>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>

                                        <td>
                                            @if(!empty($estudiante->fecha_titulo))
                                                <span class="text-muted">
                                                    <i class="ri-calendar-line me-1"></i>
                                                    {{ \Carbon\Carbon::parse(
                                                        $estudiante->fecha_titulo
                                                    )->format('d/m/Y') }}
                                                </span>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>

                                        <td class="text-center">
                                            @php
                                                $acta = $estudiante->acta_retirada ?? false;
                                                $titulo = $estudiante->titulo_retirado ?? false;
                                            @endphp

                                            @if($acta && $titulo)
                                                <span class="badge bg-soft-success text-success fs-12">
                                                    
                                                    Completo
                                                </span>
                                            @endif
                                            @if($acta && $titulo==false)
                                                <span class="badge bg-soft-warning text-warning fs-12">
                                                    
                                                    Acta Entregada
                                                </span>
                                            @endif
                                            @if($titulo && $acta==false)
                                                <span class="badge bg-soft-warning text-info fs-12">
                                                    
                                                    Titulo Entregado
                                                </span>
                                            @endif
                                            @if($titulo==false && $acta==false)
                                                <span class="badge bg-soft-danger text-danger fs-12">
                                                    
                                                    Pendiente
                                                </span>
                                            @endif
                                        </td>

                                        <td>
                                            {{ $estudiante->usuario ?? 'Sin registrar' }}
                                        </td>

                                        <td class="text-center">
                                            <button
                                                type="button"
                                                class="btn btn-sm btn-soft-primary"
                                                wire:click="abrirPanel({{ $estudiante->id }})"
                                                title="Registrar entrega de documentos"
                                            >
                                                <i class="ri-arrow-right-s-line fs-16"></i>
                                            </button>

                                            <!--<button
                                                type="button"
                                                class="btn btn-sm btn-soft-secondary"
                                                wire:click="verDetalle({{ $estudiante->id }})"
                                                title="Ver detalle"
                                            >
                                                <i class="ri-eye-line"></i>
                                            </button>-->
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="ri-user-search-line fs-32 d-block mb-2"></i>
                                                No existen estudiantes registrados.
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                            <div class="noresult" style="display: none">
                                <div class="text-center">
                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                        colors="primary:#405189,secondary:#0ab39c" style="width:75px;height:75px">
                                    </lord-icon>
                                    <h5 class="mt-2">Sorry! No Result Found</h5>
                                    <p class="text-muted">We've searched more than 150+ Orders We did
                                        not find any
                                        orders for you search.</p>
                                </div>
                            </div>
                        </div>
                        {{$estudiantes->links('')}}
                    </div>
                
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 d-flex align-items-center">
                        <i class="ri-calendar-check-line text-primary fs-20 me-2"></i>
                        Estados
                    </h5>
                </div>

                <div class="card-body">
                    <div class="row g-3">

                        {{-- PENDIENTE --}}
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <div class="estado-item h-100">
                                <div class="d-flex align-items-start">
                                    <i class=" ri-close-circle-fill text-danger fs-20 me-2"></i>

                                    <div class="ms-3">
                                        <h6 class="mb-1 fw-semibold">
                                            Pendiente
                                        </h6>

                                        <p class="text-muted mb-0 small">
                                            No ha retirado Acta ni Título.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ACTA ENTREGADA --}}
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <div class="estado-item h-100">
                                <div class="d-flex align-items-start">
                                    <i class="ri-checkbox-circle-fill text-warning fs-20 me-2"></i>
                                    <div class="ms-3">
                                        <h6 class="mb-1 fw-semibold">
                                            Acta entregada
                                        </h6>

                                        <p class="text-muted mb-0 small">
                                            Ha retirado el Acta, pendiente Título.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- TÍTULO ENTREGADO --}}
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <div class="estado-item h-100">
                                <div class="d-flex align-items-start">
                                    <i class="ri-checkbox-circle-fill text-info fs-20 me-2"></i>
                                    <div class="ms-3">
                                        <h6 class="mb-1 fw-semibold">
                                            Título entregado
                                        </h6>

                                        <p class="text-muted mb-0 small">
                                            Ha retirado el Título, pendiente Acta.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- COMPLETO --}}
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <div class="estado-item h-100">
                                <div class="d-flex align-items-start">
                                    <i class="ri-checkbox-circle-fill text-success fs-20 me-2"></i>
                                    <div class="ms-3">
                                        <h6 class="mb-1 fw-semibold">
                                            Completo
                                        </h6>

                                        <p class="text-muted mb-0 small">
                                            Ha retirado Acta y Título.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
        <!--end col-->

               
        {{-- FIN CONTENEDOR DE FILTROS Y TABLA --}}


        {{-- PANEL LATERAL DE ENTREGA --}}
        @if($mostrarPanel)
            <div
                class="col-xxl-3 col-xl-3 col-lg-4 mb-3"
                wire:key="panel-entrega-{{ $estudianteSeleccionadoId }}">
                <div class="panel-documentos sticky-lg-top">
                    <form wire:submit.prevent="guardarEntrega">

                        <div class="card shadow-sm border-0 mb-3">

                            {{-- CABECERA --}}
                            <!--<div class="card-header bg-primary py-3">
                                <div class="d-flex align-items-center justify-content-between">

                                    <h5 class="card-title text-white mb-0">
                                        Entrega de Documentos
                                    </h5>

                                    <button
                                        type="button"
                                        class="btn btn-link text-white p-0"
                                        wire:click="cerrarPanel"
                                        title="Cerrar panel"
                                    >
                                        <i class="ri-close-line fs-24"></i>
                                    </button>

                                </div>
                            </div>-->
                            <div class="card-header bg-primary py-3">
                                <h5 class="card-title mb-0 d-flex align-items-center text-white">
                                    <i class="ri-file-list-3-line text-white fs-20 me-2"></i>
                                    Entrega de Documentos
                                </h5>
                            </div>

                            <div class="card-body">

                                {{-- INFORMACIÓN DEL ESTUDIANTE --}}
                                <div class="d-flex align-items-center mb-3">

                                    <div class="avatar-lg flex-shrink-0 me-3">
                                        @if(!empty($estudianteSeleccionado?->foto))
                                            <img
                                                src="{{ asset(
                                                    'storage/' .
                                                    $estudianteSeleccionado->foto
                                                ) }}"
                                                alt="{{ $estudianteSeleccionado->nombres }}"
                                                class="rounded-circle avatar-lg object-fit-cover"
                                            >
                                        @else
                                            <div
                                                class="avatar-title rounded-circle
                                                    bg-soft-primary subtle text-primary fs-22"
                                            >
                                                {{ strtoupper(substr(
                                                    $estudianteSeleccionado?->nombres ?? 'E',
                                                    0,
                                                    1
                                                )) }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="flex-grow-1">
                                        <h5 class="mb-1">
                                            {{ $estudianteSeleccionado?->apellidos }}
                                            {{ $estudianteSeleccionado?->nombres }}
                                        </h5>

                                        <p class="text-muted mb-1">
                                            {{ $estudianteSeleccionado?->nomgrado }}
                                            {{ $estudianteSeleccionado?->paralelo }}
                                        </p>

                                        <p class="text-muted mb-0">
                                            Período:
                                            {{ $estudianteSeleccionado?->periodo ?? '—' }}
                                        </p>
                                    </div>

                                </div>

                                <hr>


                                {{-- ACTA DE GRADO --}}
                                <div class="mb-4">

                                    <h6 class="text-success fw-bold mb-2">
                                        <i class="ri-file-text-line me-2"></i>
                                        ACTA DE GRADO
                                    </h6>

                                    <div class="form-check form-check-success mb-2">
                                        <input
                                            type="checkbox"
                                            class="form-check-input"
                                            id="actaEntregada"
                                            wire:model="form.acta"
                                        >

                                        <label
                                            class="form-check-label"
                                            for="actaEntregada"
                                        >
                                            Acta entregada
                                        </label>
                                    </div>

                                    <div class="row align-items-center mb-2">
                                        <div class="col-5">
                                            <label class="form-label mb-0">
                                                Fecha de entrega
                                            </label>
                                        </div>

                                        <div class="col-7">
                                            <input
                                                type="date"
                                                class="form-control
                                                    @error('form.fecha_acta')
                                                        is-invalid
                                                    @enderror"
                                                wire:model="form.fecha_acta"
                                                @disabled(!$form['acta'])
                                            >

                                            @error('form.fecha_acta')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row align-items-center mb-2">
                                        <div class="col-5">
                                            <label class="form-label mb-0">
                                                Entregado por
                                            </label>
                                        </div>

                                        <div class="col-7">
                                            <select
                                                class="form-select
                                                    @error('form.entregado_acta_por')
                                                        is-invalid
                                                    @enderror"
                                                wire:model="form.entregado_acta_por"
                                                @disabled(!$form['acta'])
                                            >
                                                <option value="">
                                                    Seleccionar...
                                                </option>

                                                @foreach($responsables as $responsable)
                                                    <option value="{{ $responsable->name }}">
                                                        {{ $responsable->name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            @error('form.entregado_acta_por')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                                                                
                                    </div>

                                    <div class="row align-items-center">
                                        <div class="col-5">
                                            <label class="form-label mb-0">
                                                Recibido por
                                            </label>
                                        </div>

                                        <div class="col-7">
                                            <select
                                                class="form-select
                                                    @error('form.recibido_acta_por')
                                                        is-invalid
                                                    @enderror"
                                                wire:model="form.recibido_acta_por"
                                                @disabled(!$form['acta'])
                                            >
                                                <option value="">
                                                    Seleccionar...
                                                </option>

                                                <option value="Estudiante">
                                                    Estudiante
                                                </option>

                                                <option value="Representante">
                                                    Representante
                                                </option>

                                                <option value="Familiar autorizado">
                                                    Familiar autorizado
                                                </option>
                                            </select>

                                            @error('form.recibido_acta_por')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                    </div>

                                </div>

                                <hr>


                                {{-- TÍTULO DE BACHILLER --}}
                                <div class="mb-4">

                                    <h6 class="text-primary fw-bold mb-2">
                                        <i class="ri-file-list-3-line me-2"></i>
                                        TÍTULO DE BACHILLER
                                    </h6>

                                    <div class="form-check form-check-primary mb-2">
                                        <input
                                            type="checkbox"
                                            class="form-check-input"
                                            id="tituloEntregado"
                                            wire:model="form.titulo"
                                        >

                                        <label
                                            class="form-check-label"
                                            for="tituloEntregado"
                                        >
                                            Título entregado
                                        </label>
                                    </div>

                                    <div class="row align-items-center mb-2">
                                        <div class="col-5">
                                            <label class="form-label mb-0">
                                                Fecha de entrega
                                            </label>
                                        </div>

                                        <div class="col-7">
                                            <input
                                                type="date"
                                                class="form-control
                                                    @error('form.fecha_titulo')
                                                        is-invalid
                                                    @enderror"
                                                wire:model="form.fecha_titulo"
                                                @disabled(!$form['titulo'])
                                            >

                                            @error('form.fecha_titulo')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row align-items-center mb-2">
                                        <div class="col-5">
                                            <label class="form-label mb-0">
                                                Entregado por
                                            </label>
                                        </div>

                                        <div class="col-7">
                                            <select
                                                class="form-select
                                                    @error('form.entregado_titulo_por')
                                                        is-invalid
                                                    @enderror"
                                                wire:model="form.entregado_titulo_por"
                                                @disabled(!$form['titulo'])
                                            >
                                                <option value="">
                                                    Seleccionar...
                                                </option>

                                                @foreach($responsables as $responsable)
                                                    <option value="{{ $responsable->name }}">
                                                        {{ $responsable->name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            @error('form.entregado_titulo_por')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                    </div>

                                    <div class="row align-items-center">
                                        <div class="col-5">
                                            <label class="form-label mb-0">
                                                Recibido por
                                            </label>
                                        </div>

                                        <div class="col-7">
                                            <select
                                                class="form-select
                                                    @error('form.recibido_titulo_por')
                                                        is-invalid
                                                    @enderror"
                                                wire:model="form.recibido_titulo_por"
                                                @disabled(!$form['titulo'])
                                            >
                                                <option value="">
                                                    Seleccionar...
                                                </option>

                                                <option value="Estudiante">
                                                    Estudiante
                                                </option>

                                                <option value="Representante">
                                                    Representante
                                                </option>

                                                <option value="Familiar autorizado">
                                                    Familiar autorizado
                                                </option>
                                            </select>

                                            @error('form.recibido_titulo_por')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        
                                    </div>

                                </div>

                                <hr>


                                {{-- COMENTARIOS --}}
                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-primary">
                                        <i class="ri-chat-1-line me-1"></i>
                                        COMENTARIOS
                                    </label>

                                    <textarea
                                        class="form-control"
                                        rows="3"
                                        wire:model="form.comentario"
                                        placeholder="Ingrese comentarios u observaciones..."
                                    ></textarea>

                                    @error('form.comentario')
                                        <small class="text-danger">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>


                                {{-- ARCHIVO --}}
                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-primary">
                                        <i class="ri-attachment-2 me-1"></i>
                                        ADJUNTAR ARCHIVO

                                        <small class="text-muted fw-normal">
                                            (Opcional)
                                        </small>
                                    </label>
                                    <div class="d-flex align-items-center gap-2">
                                        <label
                                            for="archivo"
                                            class="btn-upload"
                                            title="Seleccionar archivo"
                                        >
                                            <i class="ri-upload-cloud-2-line"></i>
                                        </label>

                                        <input
                                        type="file"
                                        id="archivo"
                                        class="d-none"
                                        wire:model="archivo"
                                        accept=".pdf,.jpg,.jpeg,.png">
                                        
                                        @if (!empty($archivo))

                                            <span class="nombre-archivo">
                                                {{ $archivo->getClientOriginalName() }}
                                            </span>

                                        @else

                                            <span class="nombre-archivo">
                                                Subir archivo
                                            </span>

                                        @endif

                                    </div>

                                    <small class="text-muted d-block mt-1">
                                        Formatos permitidos: PDF, JPG y PNG.
                                        Máximo 10 MB.
                                    </small>

                                    @error('archivo')
                                        <small class="text-danger d-block">
                                            {{ $message }}
                                        </small>
                                    @enderror

                                    <div
                                        class="text-primary small mt-2"
                                        wire:loading
                                        wire:target="archivo"
                                    >
                                        <span
                                            class="spinner-border spinner-border-sm me-1"
                                        ></span>
                                        Cargando archivo...
                                    </div>
                                </div>


                                {{-- BOTONES --}}
                                <div class="row g-2 mt-4">
                                    <div class="col-6">
                                        <button
                                            type="button"
                                            class="btn btn-outline-secondary w-100"
                                            wire:click="cerrarPanel"
                                        >
                                            Cancelar
                                        </button>
                                    </div>

                                    <div class="col-6">
                                        <button
                                            type="submit"
                                            class="btn btn-success w-100"
                                            wire:loading.attr="disabled"
                                            wire:target="guardarEntrega,archivo"
                                        >
                                            <span
                                                wire:loading.remove
                                                wire:target="guardarEntrega"
                                            >
                                                <i class="ri-save-line me-1"></i>
                                                Guardar
                                            </span>

                                            <span
                                                wire:loading
                                                wire:target="guardarEntrega"
                                            >
                                                <span
                                                    class="spinner-border spinner-border-sm me-1"
                                                ></span>
                                                Guardando...
                                            </span>
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>


                        {{-- INFORMACIÓN IMPORTANTE --}}
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <h6 class="text-primary fw-bold">
                                    <i class="ri-information-line me-1"></i>
                                    Información importante
                                </h6>

                                <ul class="ps-3 mb-0 small text-muted">
                                    <li class="mb-1">
                                        Los estudiantes se cargan automáticamente
                                        según la matrícula activa.
                                    </li>

                                    <li class="mb-1">
                                        Registre la entrega del acta y título al
                                        momento de ser retirados.
                                    </li>

                                    <li class="mb-1">
                                        Adjunte documentos de respaldo cuando sea
                                        necesario.
                                    </li>

                                    <li>
                                        Los datos registrados son acumulativos por
                                        período lectivo.
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        @endif
        {{-- FIN PANEL LATERAL --}}

    </div>
</div>


    </div>
    <!--end row-->

</div>

