<div>
    <form id="createactivity-form" autocomplete="off" wire:submit.prevent="{{ 'createData' }}" class="needs-validation" >
        <div class="row">
            <div class="col-lg-8">
                <div class="card-header">
                    <h5 class="card-title mb-0">Registro de Solicitud</h5>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-2">
                                <label class="fw-semibold text-primary" for="product-title-input">N° de Solicitud</label>
                                <input type="text" class="form-control bg-light border-0" id="product-title-input" value="" placeholder="Documento" wire:model.defer="record.documento" disabled>
                                <div class="invalid-feedback">Por favor ingrese un nombre de actividad.</div>
                            </div>
                            <div class="col-sm-2">
                                <label class="fw-semibold text-primary" for="product-title-input">Fecha</label>
                                <input type="date" class="form-control" id="startdate" data-provider="flatpickr" data-date-format="d-m-Y" data-time="true" wire:model="record.fecha" required> 
                                @error('record.fecha')
                                    <span class="text-danger small">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="col-sm-6">
                                <label class="fw-semibold text-primary" for="product-title-input">Solicitante</label>
                                <input type="text" class="form-control" id="product-title-input" value="" placeholder="Apellidos y Nombres" wire:model.defer="record.solicitante" required>
                                @error('record.solicitante')
                                    <span class="text-danger small">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="col-sm-2">
                                <label class="fw-semibold text-primary" for="product-title-input">Cédula</label>
                                <input type="text" class="form-control" id="product-title-input" value="" placeholder="Identificación" wire:model.defer="record.cedula" required>
                                @error('record.cedula')
                                    <span class="text-danger small">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="card">
                            <div class="card-body">

                                <p class="text-muted mb-3">
                                    Me dirijo a usted señores del Consejo Ejecutivo con la finalidad de solicitar
                                </p>

                                {{-- Tabs de categorías --}}
                                <ul class="nav nav-tabs nav-border-top nav-border-top-success nav-justified"
                                    role="tablist">

                                    @foreach($detalle as $claveCategoria => $grupo)
                                        <li class="nav-item" role="presentation">

                                            <button
                                                type="button"
                                                class="nav-link {{ $tabActivo == $claveCategoria ? 'active' : '' }}"
                                                wire:click="seleccionarTab('{{ $claveCategoria }}')"
                                                id="tab-{{ $claveCategoria }}"
                                                data-bs-toggle="tab"
                                                data-bs-target="#contenido-{{ $claveCategoria }}"
                                                role="tab"
                                                aria-controls="contenido-{{ $claveCategoria }}"
                                                aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                                            >
                                                @if($claveCategoria === 'certificados')
                                                    <i class="ri-file-list-3-line me-1"></i>
                                                @elseif($claveCategoria === 'extras')
                                                    <i class="ri-stack-line me-1"></i>
                                                @elseif($claveCategoria === 'graduados')
                                                    <i class="las la-graduation-cap fs-16 me-1"></i>
                                                @endif

                                                {{ $grupo['categoria'] }}
                                            </button>

                                        </li>
                                    @endforeach

                                </ul>

                                {{-- Contenido de cada tab --}}
                                <div class="tab-content pt-3">

                                    @foreach($detalle as $claveCategoria => $grupo)

                                        <div
                                            class="tab-pane fade {{ $tabActivo == $claveCategoria ? 'show active' : '' }}"
                                            id="contenido-{{ $claveCategoria }}"
                                            role="tabpanel"
                                            aria-labelledby="tab-{{ $claveCategoria }}"
                                        >

                                            <div class="table-responsive">
                                                <table class="table table-sm table-bordered table-hover align-middle mb-0">

                                                    <thead class="table-light">
                                                        <tr>
                                                            <th class="text-center" style="width: 60px;">
                                                                N.º
                                                            </th>

                                                            <th>
                                                                Subcategoría
                                                            </th>

                                                            <th style="width: 230px;">
                                                                Periodo lectivo
                                                            </th>

                                                            <th style="width: 300px;">
                                                                Curso
                                                            </th>

                                                            <th style="width: 170px;">
                                                                Tiempo de entrega
                                                            </th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>

                                                        @forelse($grupo['subcategorias'] as $index => $item)

                                                            <tr wire:key="subcategoria-{{ $item['id'] }}">

                                                                <td class="text-center">
                                                                    {{ $loop->iteration }}
                                                                </td>

                                                                <td>
                                                                    <span class="fw-medium">
                                                                        {{ $item['subcategoria'] }}
                                                                    </span>
                                                                </td>

                                                                <td>
                                                                    <select
                                                                        class="form-select"
                                                                        wire:model="detalle.{{ $claveCategoria }}.subcategorias.{{ $index }}.periodo"
                                                                    >
                                                                        <option value="0">
                                                                            Seleccione
                                                                        </option>

                                                                        @foreach($periodos as $periodo)
                                                                            <option value="{{ $periodo->id }}">
                                                                                {{ $periodo->descripcion }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>

                                                                <td>
                                                                    <select
                                                                        class="form-select"
                                                                        wire:model="detalle.{{ $claveCategoria }}.subcategorias.{{ $index }}.curso"
                                                                    >
                                                                        <option value="0">
                                                                            Seleccione
                                                                        </option>

                                                                        @foreach($cursos as $curso)
                                                                            <option value="{{ $curso->id }}">
                                                                                {{ $curso->descripcion }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>

                                                                <td>
                                                                    <i class="ri-time-line me-1 text-muted"></i>
                                                                    {{ $item['entrega'] }}
                                                                </td>

                                                                

                                                            </tr>

                                                        @empty

                                                            <tr>
                                                                <td colspan="6" class="text-center text-muted py-4">
                                                                    No existen subcategorías registradas.
                                                                </td>
                                                            </tr>

                                                        @endforelse

                                                    </tbody>

                                                </table>
                                            </div>

                                        </div>

                                    @endforeach

                                </div>

                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>                        
            <div class="col-lg-4">
                <div class="card">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">

                            {{-- DATOS DEL ESTUDIANTE --}}
                            <div class="border border-soft-primary rounded-3 p-3 mb-3 bg-primary-subtle bg-opacity-20">

                                <h6 class="fw-semibold text-primary mb-3">
                                    Datos del Estudiante
                                </h6>

                                <div class="mb-0">
                                    <label class="form-label fw-medium">
                                        Estudiante <span class="text-danger">*</span>
                                    </label>

                                    <select
                                        class="form-select"
                                        wire:model.live="record.estudiante_id"
                                    >
                                        <option value="">
                                            Buscar estudiante...
                                        </option>

                                        @foreach($estudiantes as $estudiante)
                                            <option value="{{ $estudiante->id }}">
                                                {{ $estudiante->apellidos }}
                                                {{ $estudiante->nombres }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('record.estudiante_id')
                                        <span class="text-danger small">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                            </div>

                            {{-- ENTREGA Y SERVIDOR --}}
                            <div class="border border-primary-subtle rounded-3 p-3 mb-3 bg-primary-subtle bg-opacity-10">

                                <h6 class="fw-semibold text-primary mb-3">
                                    Entrega y Servidor
                                </h6>

                                <div class="row g-3">

                                    <div class="col-12 col-md-6">
                                        <label class="form-label fw-medium">
                                            Fecha de Entrega
                                            <span class="text-danger">*</span>
                                        </label>

                                        <input
                                            type="date"
                                            class="form-control"
                                            wire:model="record.fecha_entrega"
                                        >

                                        @error('record.fecha_entrega')
                                            <span class="text-danger small">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label class="form-label fw-medium">
                                            Servidor
                                            <span class="text-danger">*</span>
                                        </label>

                                        <select class="form-select" wire:model="record.servidor">
                                            <option value="">Seleccione</option>

                                            @foreach($servidores as $id => $nombre)
                                                <option value="{{ $id }}">
                                                    {{ $nombre }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('record.servidor')
                                            <span class="text-danger small">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-medium d-block">
                                            Solicitado de forma
                                            <span class="text-danger">*</span>
                                        </label>

                                        <div class="form-check mb-2">
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                id="formaPresencial"
                                                value="P"
                                                wire:model="record.forma_solicitud"
                                            >

                                            <label
                                                class="form-check-label"
                                                for="formaPresencial"
                                            >
                                                Presencial
                                            </label>
                                        </div>

                                        <div class="form-check mb-2">
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                id="formaCorreo"
                                                value="C"
                                                wire:model="record.forma_solicitud"
                                            >

                                            <label
                                                class="form-check-label"
                                                for="formaCorreo"
                                            >
                                                Correo
                                            </label>
                                        </div>

                                        <div class="form-check">
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                id="formaTelefonica"
                                                value="T"
                                                wire:model="record.forma_solicitud"
                                            >

                                            <label
                                                class="form-check-label"
                                                for="formaTelefonica"
                                            >
                                                Telefónicamente
                                            </label>
                                        </div>

                                        @error('record.forma_solicitud')
                                            <span class="text-danger small d-block mt-1">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>

                                </div>
                            </div>

                            <div class="border border-primary-subtle rounded-3 p-3 bg-primary-subtle bg-opacity-10">

                                <h6 class="fw-semibold text-primary mb-3">
                                    Observaciones
                                </h6>
                                
                                <div class="position-relative">

                                    <textarea
                                        class="form-control"
                                        rows="4"
                                        maxlength="200"
                                        wire:model.defer="record.comentario"
                                        placeholder="Ingrese un comentario interno..."></textarea>

                                    <small class="position-absolute bottom-0 end-0 me-2 mb-1 text-muted">
                                        {{ strlen($record['comentario'] ?? '') }}/200
                                    </small>
                                </div>

                            </div>
                            
                            {{-- BOTONES --}}
                            <div class="d-flex justify-content-end gap-2 mt-4">
                                @if($solicitudId>0)
                                <a
                                    href="{{ route('solicitudes.imprimir',$solicitudId) }}"
                                    target="_blank"
                                    class="btn btn-soft-danger"
                                >
                                    <i class=" ri-printer-fill me-1"></i>
                                    Imprimir PDF
                                </a>
                                @endif

                                <button
                                    type="button"
                                    class="btn btn-light px-4"
                                    wire:click="limpiarFormulario"
                                >
                                    Limpiar
                                </button>

                                <button
                                    type="button"
                                    class="btn btn-primary px-4"
                                    wire:click="guardarSolicitud"
                                    wire:loading.attr="disabled"
                                    wire:target="guardarSolicitud"
                                >
                                    <span wire:loading.remove wire:target="guardarSolicitud">
                                        Guardar Solicitud
                                    </span>

                                    <span wire:loading wire:target="guardarSolicitud">
                                        <span class="spinner-border spinner-border-sm me-1"></span>
                                        Guardando...
                                    </span>
                                </button>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
