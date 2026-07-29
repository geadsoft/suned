<div>
    <style>

    .estado-illustration {
        background: linear-gradient(
            145deg,
            rgba(64, 81, 137, 0.08),
            rgba(41, 156, 219, 0.06)
        );
        border-radius: 16px;
        padding: 32px 24px;
        border: 1px solid rgba(64, 81, 137, 0.10);
    }

    .illustration-icon {
        width: 82px;
        height: 82px;
        border-radius: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #405189, #299cdb);
        color: #fff;
        font-size: 38px;
        box-shadow: 0 14px 30px rgba(64, 81, 137, 0.22);
    }

    .status-line {
        position: relative;
    }

    .status-item {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        margin-bottom: 24px;
        position: relative;
    }

    .status-item:not(:last-child)::after {
        content: "";
        position: absolute;
        left: 20px;
        top: 44px;
        width: 2px;
        height: 34px;
        background: #dfe4ec;
    }

    .status-icon,
    .option-icon {
        min-width: 42px;
        width: 42px;
        height: 42px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .status-pending,
    .option-icon.pending {
        background: rgba(247, 184, 75, 0.16);
        color: #f7b84b;
    }

    .status-ready,
    .option-icon.ready {
        background: rgba(41, 156, 219, 0.14);
        color: #299cdb;
    }

    .status-delivered,
    .option-icon.delivered {
        background: rgba(10, 179, 156, 0.14);
        color: #0ab39c;
    }

    .estado-option {
        display: flex;
        align-items: center;
        gap: 14px;
        width: 100%;
        padding: 14px 16px;
        border: 1px solid #e5e8eb;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.2s ease;
        background: #fff;
    }

    .estado-option:hover {
        transform: translateY(-1px);
        border-color: rgba(64, 81, 137, 0.35);
        box-shadow: 0 6px 18px rgba(30, 32, 37, 0.06);
    }

    .estado-option.active.pending {
        border-color: #f7b84b;
        background: rgba(247, 184, 75, 0.06);
    }

    .estado-option.active.ready {
        border-color: #299cdb;
        background: rgba(41, 156, 219, 0.06);
    }

    .estado-option.active.delivered {
        border-color: #0ab39c;
        background: rgba(10, 179, 156, 0.06);
    }

    .modal-content {
        border-radius: 18px;
    }

    @media (max-width: 991.98px) {
        .estado-illustration {
            display: none;
        }
    }
    
    .resumen-card {
        border-radius: 7px;
        box-shadow: none;
        transition: all 0.2s ease-in-out;
    }

    .resumen-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.06);
    }

    .resumen-card .card-body {
        min-height: 50px;
        padding: 14px 18px;
    }

    .resumen-pendiente {
        border: 1px solid #f5d99d;
        background: linear-gradient(
            90deg,
            #fffaf0 0%,
            #ffffff 100%
        );
    }

    .resumen-listo {
        border: 1px solid #bfe3ce;
        background: linear-gradient(
            90deg,
            #f1fbf5 0%,
            #ffffff 100%
        );
    }

    .resumen-entregado {
        border: 1px solid #bfd4fb;
        background: linear-gradient(
            90deg,
            #f2f7ff 0%,
            #ffffff 100%
        );
    }

    .resumen-total {
        border: 1px solid #d9dee8;
        background: linear-gradient(
            90deg,
            #f7f8fa 0%,
            #ffffff 100%
        );
    }

    .resumen-icon {
        width: 42px;
        height: 42px;
        min-width: 42px;
        border-radius: 7px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 23px;
    }

    .icon-pendiente {
        color: #f5a800;
        background-color: #fff1c9;
    }

    .icon-listo {
        color: #16a34a;
        background-color: #dff5e7;
    }

    .icon-entregado {
        color: #2563d9;
        background-color: #dfeaff;
    }

    .icon-total {
        color: #172033;
        background-color: #e9edf3;
    }

    .resumen-titulo {
        display: block;
        margin-bottom: 2px;
        color: #343a40;
        font-size: 12px;
        font-weight: 500;
        line-height: 1.2;
    }

    .resumen-valor {
        color: #172033;
        font-size: 23px;
        font-weight: 700;
        line-height: 1;
    }

    @media (max-width: 767.98px) {
        .resumen-card .card-body {
            min-height: 78px;
        }
    }

    .alert-categoria {
        min-height: 74px;
        padding: 14px 16px;
        border: 1px solid #a9c8ff;
        border-radius: 5px;
        background: linear-gradient(
            90deg,
            #f4f8ff 0%,
            #eef5ff 100%
        );
        color: #1554c0;
        font-size: 13px;
    }

    .alert-categoria i {
        font-size: 19px;
        line-height: 1;
    }

    .alert-categoria .categoria-nombre {
        margin-top: 5px;
        font-weight: 700;
        text-transform: uppercase;
    }

</style>
    <div class="row g-3">

        {{-- CONTENEDOR DE FILTROS Y TABLA --}}
        <div class="{{ $mostrarPanel ? 'col-xxl-9 col-xl-9 col-lg-8' : 'col-12' }}">
            <div class="row g-3 mb-4">

                {{-- Pendientes --}}
                <div class="col-xl-3 col-md-6">
                    <div class="card resumen-card resumen-pendiente h-100">
                        <div class="card-body d-flex align-items-center">

                            <div class="resumen-icon icon-pendiente me-3">
                                <i class="ri-file-list-3-fill"></i>
                            </div>

                            <div>
                                <span class="resumen-titulo">Pendientes</span>

                                <h4 class="resumen-valor mb-0">
                                    {{ $resumen['pendientes'] ?? 0 }}
                                </h4>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Listos --}}
                <div class="col-xl-3 col-md-6">
                    <div class="card resumen-card resumen-listo h-100">
                        <div class="card-body d-flex align-items-center">

                            <div class="resumen-icon icon-listo me-3">
                                <i class="ri-checkbox-circle-fill"></i>
                            </div>

                            <div>
                                <span class="resumen-titulo">Listos</span>

                                <h4 class="resumen-valor mb-0">
                                    {{ $resumen['listos'] ?? 0 }}
                                </h4>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Realizados y entregados --}}
                <div class="col-xl-3 col-md-6">
                    <div class="card resumen-card resumen-entregado h-100">
                        <div class="card-body d-flex align-items-center">

                            <div class="resumen-icon icon-entregado me-3">
                                <i class="ri-clipboard-fill"></i>
                            </div>

                            <div>
                                <span class="resumen-titulo text-primary">
                                    Realizados y Entregados
                                </span>

                                <h4 class="resumen-valor mb-0">
                                    {{ $resumen['entregados'] ?? 0 }}
                                </h4>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Total solicitudes --}}
                <div class="col-xl-3 col-md-6">
                    <div class="card resumen-card resumen-total h-100">
                        <div class="card-body d-flex align-items-center">

                            <div class="resumen-icon icon-total me-3">
                                <i class="ri-file-word-2-line"></i>
                            </div>

                            <div>
                                <span class="resumen-titulo">Total Solicitudes</span>

                                <h4 class="resumen-valor mb-0">
                                    {{ $resumen['total'] ?? 0 }}
                                </h4>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <div class="row g-2 align-items-center">

                        <!-- Buscador -->
                        <div class="col-12 col-md-8">
                            <div class="search-box">
                                <input
                                    type="text"
                                    class="form-control search"
                                    placeholder="Buscar por solicitante o estudiante"
                                    wire:model.live.debounce.500ms="filters.buscar"
                                >

                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                        <!--<div class="col-12 col-md-2">
                            <input type="date" class="form-control" id="startdate" data-provider="flatpickr" data-date-format="d-m-Y" data-time="true" wire:model="startDate"> 
                        </div>
                        <div class="col-12 col-md-2">
                            <input type="date" class="form-control" id="enddate" data-provider="flatpickr" data-date-format="d-m-Y" data-time="true" wire:model="endDate"> 
                        </div>-->
                        <div class="col-12 col-sm-2 text-end">
                            <a class="btn btn-outline-success" href="/secretary/requests-add"><i class="ri-add-line me-1"></i>Nueva Solicitud</a>
                        </div>
                        <!-- Gestión de subcategorías -->
                        <div class="col-12 col-sm-2">
                            <div class="dropdown">
                                <button
                                    type="button"
                                    class="btn btn-outline-primary dropdown-toggle w-100"
                                    id="dropdownSubcategorias"
                                    data-bs-toggle="dropdown"
                                    data-bs-auto-close="outside"
                                    aria-expanded="false"
                                >
                                    <i class="ri-settings-3-line me-1"></i>
                                    Gestionar Subcategorías
                                </button>

                                <ul
                                    class="dropdown-menu dropdown-menu-end p-2"
                                    aria-labelledby="dropdownSubcategorias"
                                    style="min-width: 220px;"
                                >
                                    <li>
                                        <button
                                            type="button"
                                            class="dropdown-item categoria d-flex align-items-center"
                                            data-id="1" wire:click="abrirPanel('Certificados')">
                                            <i class="ri-file-list-3-line me-2"></i>

                                            <span class="flex-grow-1">
                                                Certificados
                                            </span>

                                            <i class="ri-arrow-right-s-line"></i>
                                        </button>
                                    </li>

                                    <li>
                                        <button
                                            type="button"
                                            class="dropdown-item categoria d-flex align-items-center"
                                            data-id="2" wire:click="abrirPanel('Extras')">
                                            <i class="ri-file-add-line me-2"></i>

                                            <span class="flex-grow-1">
                                                Extras
                                            </span>

                                            <i class="ri-arrow-right-s-line"></i>
                                        </button>
                                    </li>

                                    <li>
                                        <button
                                            type="button"
                                            class="dropdown-item categoria d-flex align-items-center"
                                            data-id="3" wire:click="abrirPanel('Graduados')">
                                            <i class="las la-graduation-cap me-2 fs-15"></i>

                                            <span class="flex-grow-1">
                                                Graduados
                                            </span>

                                            <i class="ri-arrow-right-s-line"></i>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div>
                        <ul class="nav nav-tabs nav-tabs-custom nav-success mb-3" role="tablist">
                        </ul>

                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle" id="orderTable">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width: 50px;">N° de Trámite</th>
                                        <th class="text-center" style="width: 70px;">Fecha</th>
                                        <th>Solicitante</th>
                                        <th>Estudiante</th>
                                        <th class="text-center">Categoria</th>
                                        <th class="text-center">Subcategoria</th>
                                        <th>Estado</th>
                                        <th>Fecha de Entrega</th>
                                        <th class="text-center">Servidor</th>
                                        <th class="text-center" style="width: 100px;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                @forelse($solicitudes as $index => $data)
                                    <tr>  
                                        <td>{{$data->documento}}</td>
                                        <td> {{date('d/m/Y',strtotime($data->fecha))}}</td>
                                        <td>{{$data->solicitante}}</td>
                                        <td>{{$data->persona->nombres}} {{$data->persona->apellidos}}</td>
                                        <td> {{ $data->detalles
                                        ->pluck('subcategoria.categoria')
                                        ->filter()
                                        ->unique()
                                        ->implode(', ') }}
                                        </td>
                                        <td>
                                            {{ $data->detalles
                                                ->pluck('subcategoria.subcategoria')
                                                ->filter()
                                                ->unique()
                                                ->implode(', ') }}
                                        </td>
                                        <td>
                                            <span class="badge {{$estado[$data->estado]['color']}} text-uppercase">{{$estado[$data->estado]['valor']}}</span>
                                        </td>
                                        <td> {{date('d/m/Y',strtotime($data->fecha_entrega))}}</td>
                                        <td>{{$servidores[$data->servidor]}}</td>
                                        <td>
                                            <ul class="list-inline hstack gap-2 mb-0">
                                                <button
                                                    type="button"
                                                    class="btn btn-sm btn-soft-primary"
                                                    wire:click="abrirCambioEstado({{ $data->id }})"
                                                    @disabled($data->estado === 'R')
                                                >
                                                    <i class="ri-edit-2-line"></i>
                                                    Cambiar estado
                                                </button>
                                                <li class="list-inline-item" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                                    <a class="text-danger d-inline-block remove-item-btn"
                                                        data-bs-toggle="modal" href="" wire:click.prevent="delete({{ $data->id }})">
                                                        <i class="ri-delete-bin-5-fill fs-16"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center py-5">
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
                        {{$solicitudes->links('')}}
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
                wire:key="panel-subcategoria-{{ $this->record['categoria'] }}">
                <div class="panel-documentos sticky-lg-top">
                    <form>
                        <div class="card shadow-sm border-0 mb-3">

                            <div class="card-header d-flex justify-content-between align-items-center">

                                <h5 class="mb-0">
                                    <i class="ri-folder-open-line text-primary me-1"></i>
                                    Subcategoría - {{ $this->record['categoria'] }}
                                </h5>

                                <button
                                    type="button"
                                    class="btn btn-sm btn-soft-danger"
                                    wire:click="cerrarPanel"
                                    title="Cerrar">
                                    <i class="ri-close-line fs-5"></i>
                                </button>

                            </div>

                            <div class="card-body">

                                <div class="alert alert-info-subtle border border-info d-flex align-items-start mb-3" role="alert">

                                    <i class="ri-information-line text-primary fs-18 me-2 mt-1"></i>

                                    <div class="text-primary fs-11">
                                        <span>
                                            Administra las subcategorías disponibles para la categoría
                                        </span>

                                        <div class="fw-bold mt-1">
                                            {{ strtoupper($this->record['categoria'] ?? 'CERTIFICADOS') }}.
                                        </div>
                                    </div>

                                </div>

                                <div class="d-flex align-items-end gap-2 mb-3">

                                    <div class="flex-grow-1">
                                        <label class="form-label fs-10 mb-1">Subcategoría</label>
                                        <input type="text"
                                            class="form-control form-control-sm"
                                            wire:model.defer="record.subcategoria">
                                    </div>

                                    <div style="width:170px;">
                                        <label class="form-label fs-10 mb-1">Tiempo</label>
                                        <div class="input-group input-group-sm">
                                            <input type="text"
                                                class="form-control form-control-sm"
                                                wire:model.defer="record.tiempo_entrega">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="form-label mb-1">&nbsp;</label>
                                        <button type="button"
                                            class="btn btn-success btn-sm d-block"
                                            wire:click="createData">
                                            <i class="ri-save-line me-1 fs-18"></i>
                                        </button>
                                    </div>

                                </div>

                                
                                <div class="table-responsive fs-10">
                                    <table class="table table-bordered align-middle mb-0">

                                        <thead class="table-light text-center">
                                            <tr>
                                                <th style="width:70px">N°</th>
                                                <th>Subcategoría</th>
                                                <th style="width:180px">Tiempo de Entrega</th>
                                                <th style="width:120px">Acciones</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @forelse($categorias as $index => $data)
                                                <tr>
                                                <td>{{$index+1}}</td>
                                                <td>{{$data->subcategoria}}</td>
                                                <td>{{$data->tiempo_entrega}}</td>
                                                </tr>
                                            @empty
                                            {{-- Sin datos --}}
                                            <tr>
                                                <td colspan="4" class="text-center py-5">

                                                    <div class="d-flex flex-column align-items-center">

                                                        <i class="ri-inbox-2-line text-muted"
                                                            style="font-size:45px"></i>

                                                        <h6 class="mt-3 mb-1 text-muted">
                                                            No existen subcategorías registradas
                                                        </h6>

                                                        <small class="text-muted">
                                                            Presione <strong>Nueva Subcategoría</strong> para agregar un registro.
                                                        </small>

                                                    </div>

                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>

                                    </table>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endif
        {{-- FIN PANEL LATERAL --}}

    </div>
    <!--end row-->
    <div
    wire:ignore.self
    class="modal fade"
    id="modalCambioEstado"
    tabindex="-1"
    aria-labelledby="modalCambioEstadoLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg overflow-hidden">

            <div class="modal-header border-0 pb-0">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar-sm">
                        <div class="avatar-title rounded-circle bg-primary-subtle text-primary fs-22">
                            <i class="ri-file-list-3-line"></i>
                        </div>
                    </div>

                    <div>
                        <h5 class="modal-title mb-1" id="modalCambioEstadoLabel">
                            Cambiar estado de solicitud
                        </h5>
                        <p class="text-muted mb-0">
                            Actualice el estado actual de la solicitud seleccionada.
                        </p>
                    </div>
                </div>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Cerrar"
                ></button>
            </div>

            <form wire:submit.prevent="cambiarEstado">
                <div class="modal-body pt-4">
                    <div class="row g-4">

                        {{-- Ilustración --}}
                        <div class="col-lg-5">
                            <div class="estado-illustration h-100">
                                <div class="text-center mb-4">
                                    <div class="illustration-icon mx-auto mb-3">
                                        <i class="ri-file-list-3-line"></i>
                                    </div>

                                    <h5 class="mb-1">Estado de solicitud</h5>
                                    <p class="text-muted mb-0">
                                        Seleccione la etapa actual del trámite.
                                    </p>
                                </div>

                                <div class="status-line">
                                    <div class="status-item">
                                        <div class="status-icon status-pending">
                                            <i class="ri-time-line"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">Pendiente</h6>
                                            <p class="text-muted mb-0">
                                                La solicitud está en espera.
                                            </p>
                                        </div>
                                    </div>

                                    <div class="status-item">
                                        <div class="status-icon status-ready">
                                            <i class="ri-checkbox-circle-line"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">Listo</h6>
                                            <p class="text-muted mb-0">
                                                La solicitud está preparada.
                                            </p>
                                        </div>
                                    </div>

                                    <div class="status-item mb-0">
                                        <div class="status-icon status-delivered">
                                            <i class="ri-check-double-line"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">Realizado y entregado</h6>
                                            <p class="text-muted mb-0">
                                                El trámite fue entregado al solicitante.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Formulario --}}
                        <div class="col-lg-7">

                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    Nuevo estado
                                    <span class="text-danger">*</span>
                                </label>

                                <select
                                    wire:model="estadoSolicitud"
                                    class="form-select form-select-lg
                                        @error('estadoSolicitud') is-invalid @enderror"
                                >
                                    <option value="">Seleccione un estado</option>
                                    <option value="P">Pendiente</option>
                                    <option value="L">Listo</option>
                                    <option value="R">Realizado y entregado</option>
                                </select>

                                @error('estadoSolicitud')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-12">
                                    <label
                                        class="estado-option
                                            {{ $estadoSolicitud === 'P' ? 'active pending' : '' }}"
                                    >
                                        <input
                                            type="radio"
                                            value="P"
                                            wire:model="estadoSolicitud"
                                            class="d-none"
                                        >

                                        <span class="option-icon pending">
                                            <i class="ri-time-line"></i>
                                        </span>

                                        <span>
                                            <strong class="d-block">
                                                Pendiente
                                            </strong>
                                            <small class="text-muted">
                                                La solicitud continúa en espera de atención.
                                            </small>
                                        </span>
                                    </label>
                                </div>

                                <div class="col-12">
                                    <label
                                        class="estado-option
                                            {{ $estadoSolicitud === 'L' ? 'active ready' : '' }}"
                                    >
                                        <input
                                            type="radio"
                                            value="L"
                                            wire:model="estadoSolicitud"
                                            class="d-none"
                                        >

                                        <span class="option-icon ready">
                                            <i class="ri-checkbox-circle-line"></i>
                                        </span>

                                        <span>
                                            <strong class="d-block">
                                                Listo
                                            </strong>
                                            <small class="text-muted">
                                                La solicitud ya fue procesada y está lista.
                                            </small>
                                        </span>
                                    </label>
                                </div>

                                <div class="col-12">
                                    <label
                                        class="estado-option
                                            {{ $estadoSolicitud === 'R' ? 'active delivered' : '' }}"
                                    >
                                        <input
                                            type="radio"
                                            value="R"
                                            wire:model="estadoSolicitud"
                                            class="d-none"
                                        >

                                        <span class="option-icon delivered">
                                            <i class="ri-check-double-line"></i>
                                        </span>

                                        <span>
                                            <strong class="d-block">
                                                Realizado y entregado
                                            </strong>
                                            <small class="text-muted">
                                                La solicitud fue finalizada y entregada.
                                            </small>
                                        </span>
                                    </label>
                                </div>
                            </div>

                            <div>
                                <label class="form-label fw-semibold">
                                    Observación
                                </label>

                                <textarea
                                    wire:model.defer="observacionEstado"
                                    class="form-control"
                                    rows="4"
                                    placeholder="Ingrese una observación opcional"
                                ></textarea>

                                <small class="text-muted">
                                    Agregue información adicional sobre el cambio de estado.
                                </small>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0 pt-0">
                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal"
                    >
                        <i class="ri-close-line me-1"></i>
                        Cancelar
                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary"
                        wire:loading.attr="disabled"
                        wire:target="cambiarEstado"
                    >
                        <span
                            wire:loading.remove
                            wire:target="cambiarEstado"
                        >
                            <i class="ri-save-line me-1"></i>
                            Guardar cambios
                        </span>

                        <span
                            wire:loading
                            wire:target="cambiarEstado"
                        >
                            <span class="spinner-border spinner-border-sm me-1"></span>
                            Guardando...
                        </span>
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

</div>

