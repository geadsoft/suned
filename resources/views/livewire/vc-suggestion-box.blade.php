<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card rounded-0 bg-soft-success mx-n4 mt-n4 border-top">
                <div class="px-4">
                    <div class="row">
                        <div class="col-xxl-5 align-self-center">
                            <div class="py-4">
                                <h4 class="display-6 coming-soon-text">Buzón de Sugerencias, Quejas</h4>
                                <p class="text-muted fs-15 mt-3">Si tienes sugerencias, comentarios o necesitas asistencia, no dudes en escribirnos. Puedes contactarnos o enviarnos un correo electrónico.</p>
                                <div class="hstack flex-wrap gap-2">
                                    <button type="button" class="btn btn-primary btn-label rounded-pill"><i
                                        class="ri-send-plane-fill label-icon align-middle rounded-pill fs-16 me-2"></i> Enviar Email
                                    </button>
                                    <!--<button type="button" class="btn btn-info btn-label rounded-pill"><i
                                            class="ri-twitter-line label-icon align-middle rounded-pill fs-16 me-2"></i>
                                        Send Us Tweet</button>-->
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 ms-auto">
                            <div class="mb-n5 pb-1 faq-img d-none d-xxl-block">
                                <img src="{{ URL::asset('assets/images/guia-de-pqrds.png') }}" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->

            <div class="row justify-content-evenly">
                <div class="col-lg-4">
                    <div class="mt-3">
                        <div class="d-flex align-items-center mb-2">
                            <div class="flex-shrink-0 me-1">
                                <i class="ri-contacts-line fs-24 align-middle text-success me-1"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="fs-17 mb-0 fw-semibold">Datos Generales</h5>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="choices-publish-status-input" class="form-label fw-semibold"></label>
                            <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false wire:model="proceso">
                            <option value="S">SUGERENCIA</option>
                            <option value="Q">QUEJA</option>
                            </select>
                        </div>
                        <div class="row g-3">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="asignatura-select" class="form-label fw-semibold">Tipo Identificación</label>
                                    <select class="form-select" id="asignatura-select" data-choices data-choices-search-false wire:model.defer="tipo" required>
                                    <option value="">Seleccione</option>
                                    <option value="C">Cédula</option>
                                    <option value="C">Ruc</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="asignatura-select" class="form-label fw-semibold">Identificación</label>
                                    <input type="number" class="form-control" id="nui-input" value="" placeholder="Ingrese número de identificacion" wire:model.defer="identificacion" required>
                                    <div class="invalid-feedback">Por favor ingrese un nombre de actividad.</div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="actividad" for="product-title-input">Nombre y Apellidos</label>
                            <input type="text" class="form-control" id="actividad-input" value="" placeholder="Ingrese nombres completos" wire:model.defer="nombres" required>
                            <div class="invalid-feedback">Por favor ingrese un nombres completos</div>
                        </div>
                        <div class="mb-3">
                            <label for="txtemail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="txtemail"
                                placeholder="ingrese correo electrónico" wire:model.defer="email">
                        </div>
                        <div class="mb-3">
                            <label for="txttelefono" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="txttelefono"
                                placeholder="Ingrese numero de teléfono" wire:model.defer="telefono" required>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="mt-3">
                        <div class="d-flex align-items-center mb-2">
                            <div class="flex-shrink-0 me-1">
                                <i class="ri-mail-line fs-24 align-middle text-success me-1"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="fs-17 mb-0 fw-semibold">Asunto</h5>
                            </div>
                        </div>
                        <div style="display: none">{{$texteditor}}</div>
                        <div class="mb-3" wire:ignore>
                            <label class="form-label fw-semibold"></label>
                            <textarea id="editor" wire:model="texteditor" disabled>
                                
                            </textarea>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!--end col-->
    </div>    
</div>

