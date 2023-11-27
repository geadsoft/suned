<div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body checkout-tab">
                    <form autocomplete="off" wire:submit.prevent="{{ 'createData' }}">
                        <div class="row justify-content-center">
                                    <div class="col-xxl-9">
                                        <div class="card" id="demo">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="card-header border-bottom-dashed p-4">
                                                        <div class="d-flex">
                                                            <div class="flex-grow-1">
                                                                <img src="{{ URL::asset('assets/images/American Schooll.png') }}" class="card-logo card-logo-dark" alt="logo dark" height="60">
                                                            </div>
                                                            <div class="flex-shrink-0 mt-sm-0 mt-3">
                                                                <h6><span class="text-muted fw-normal">Legal Registration No:</span><span id="legal-register-no"></span></h6>
                                                                <h6><span class="text-muted fw-normal">Email:</span><span id="email"></span></h6>
                                                                <h6><span class="text-muted fw-normal">Website:</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--end card-header-->
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-12">
                                                    <div class="card-body p-4">
                                                        <div class="row g-3 mb-3">
                                                            <div class="col-lg-3 col-6">
                                                                <p class="text-muted mb-2 text-uppercase fw-semibold">DOCUMENTO</p>
                                                                <input type="text" class="form-control form-control-sm bg-white border-0" id="documento-input" wire:model="nui" required>
                                                            </div>
                                                            <div class="col-lg-3 col-6">
                                                                <p class="text-muted mb-2 text-uppercase fw-semibold">Emisión</p>
                                                                <input type="date" class="form-control form-control-sm bg-white border-0" id="fechaActual" data-provider="flatpickr" data-date-format="d-m-Y" data-time="true" wire:model.defer="fecha"> 
                                                            </div>
                                                            <div class="col-lg-3 col-6">
                                                            </div>
                                                            <div class="col-lg-3 col-6">
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row g-3">
                                                            <div class="row">
                                                                <div class="col-xxl-6">
                                                                    <ul class="list-inline hstack gap-2 mb-0">
                                                                    <p>Yo, </p><input type="text" class="form-control bg-light border-0" id="estudiante-input" wire:model="nombres" required>
                                                                    </ul>
                                                                </div>
                                                                <div class="col-xxl-6">
                                                                    <ul class="list-inline hstack gap-2 mb-0">
                                                                    <p>CI</p> <input type="text" class="form-control bg-light border-0" id="estudiante-input" wire:model="nui" required>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                    <div class="col-xxl-12">
                                                                        <p><br>Me dirijo a ustedes señores del Consejo Ejecutivo con la finalidad de solicitar:</p>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                        <div class="row g-3">
                                                            <div class="col-lg-6 col-6 mb-3">
                                                                <p class="text-muted mb-2 text-uppercase fw-semibold">Observaciones</p>
                                                                <textarea type="text" class="form-control bg-light border-0" rows="5" id="txtcomentario" wire:model.defer="comentario">
                                                                </textarea>
                                                            </div>
                                                            <div class="col-lg-6 col-6 mb-3">
                                                                <br>
                                                                <table class="table table-borderless table-sm align-middle mb-0">
                                                                    <tr>
                                                                        <td><p class="text-muted mb-2 text-uppercase fw-semibold">Fecha de Entrega</p></td>
                                                                        <td><input type="date" class="form-control form-control-sm bg-light border-0" id="fechaEntrega" data-provider="flatpickr" data-date-format="d-m-Y" data-time="true" wire:model.defer="fentrega"> </td>
                                                                    <tr>
                                                                    <tr>
                                                                        <td><p class="text-muted mb-2 text-uppercase fw-semibold">Nombre del Servidor</p></td>
                                                                        <td>
                                                                            <select class="form-select form-select-sm bg-light border-0" name="cmbnivel" wire:model="filters.srv_periodo">
                                                                            <option value="">Seleccionar Servidor</option>
                                                                            <option value="">Secretaria 1</option>
                                                                            <option value="">Secretaria 2</option>
                                                                            </select>
                                                                        </td>
                                                                    <tr>
                                                                    <tr>
                                                                        <td><p class="text-muted mb-2 text-uppercase fw-semibold">ESTADO</p></td>
                                                                        <td>
                                                                            <select class="form-select form-select-sm bg-light border-0" name="cmbnivel" wire:model="filters.srv_periodo">
                                                                            <option value="P">Pendiente</option>
                                                                            <option value="L">Listo</option>
                                                                            <option value="R">Realizado</option>
                                                                            <option value="E">Entregado</option>
                                                                            </select>
                                                                        </td>
                                                                    <tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <!--end row-->
                                                    </div>
                                                    <!--end card-body-->
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="card-body p-4">
                                                        <div class="row g-3">
                                                            <div class="col-6">
                                                                <h6 class="text-muted text-uppercase fw-semibold mb-3">Información</h6>
                                                                <ul class="list-inline hstack gap-2 mb-0">
                                                                <p class="text-muted mb-1">Celular:</p>
                                                                <input type="text" class="form-control form-control-sm bg-light border-0" id="infotelefono" /></span>
                                                                </ul>
                                                                <br>
                                                                <ul class="list-inline hstack gap-2 mb-0">
                                                                <p class="text-muted mb-1">Teléfono:</p>
                                                                <input type="text" class="form-control form-control-sm bg-light border-0" id="infotelefono" /></span>
                                                                </ul>
                                                                <br>
                                                                <ul class="list-inline hstack gap-2 mb-0">
                                                                <p class="text-muted mb-1">Email:</p>
                                                                <input type="text" class="form-control form-control-sm bg-light border-0" id="infotelefono" /></span>
                                                                </ul>
                                                            </div>
                                                            <!--end col-->
                                                            <div class="col-6">
                                                                <h6 class="text-muted text-uppercase fw-semibold mb-3">Solicitado de Forma</h6>
                                                                <div class="form-check mb-2">
                                                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                                                    <label class="form-check-label text-muted" for="flexRadioDefault1">
                                                                        Presencial
                                                                    </label>
                                                                </div>
                                                                <div class="form-check mb-2">
                                                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                                                                    <label class="form-check-label text-muted" for="flexRadioDefault2">
                                                                        Correo
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault3">
                                                                    <label class="form-check-label text-muted" for="flexRadioDefault3">
                                                                        Telefonicamente
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <!--end col-->
                                                        </div>
                                                        <!--end row-->
                                                    </div>
                                                    <!--end card-body-->
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="card-body p-4">
                                                        <div class="hstack gap-2 justify-content-end d-print-none mt-4">
                                                            <button type="button" class="btn btn-danger w-sm" wire:click='print()'><i class="ri-printer-line align-bottom me-1"></i>Print</button>
                                                            <!--<a href="javascript:window.print()" class="btn btn-danger"><i class="ri-printer-line align-bottom me-1"></i> Print</a>-->
                                                            <!--<a href="javascript:void(0);" class="btn btn-primary"><i class="ri-download-2-line align-bottom me-1"></i> Download</a>-->
                                                            <button type="submit" class="btn btn-success"><i class="ri-printer-line align-bottom me-1"></i> Save Tuition</button>
                                                        </div>
                                                    </div>
                                                </div>        
                                                <!--end col-->
                                                </div>
                                            </div>
                                            <!--end row-->
                                        </div>
                                        <!--end card-->
                                    </div>
                                    <!--end col-->
                                </div>
                            </form>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->

    </div>
   
</div>
