<div>
    <div class="d-flex align-items-center">
        <h5 class="card-title mb-0 flex-grow-1"><strong>Gestion Calificaciones de Estudiantes</strong></h5>
        <div class="flex-shrink-0">
            <a class="btn btn-success add-btn" href="/academic/ratings-add"><i
            class="ri-add-line me-1 align-bottom"></i> Agregar Calificaciones Estudiantes</a>
        </div>
    </div>
    <hr style="color: #0056b2;" />
    <div class="mb-3">
        <label for="cmbgrupo" class="form-label">Búsqueda</label>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="orderList">
                <div class="card-body border border-dashed border-end-0 border-start-0 ">
                    <form>
                    <label for="cmbgrupo" class="form-label">Filtros</label>
                        <div class="row mb-3">
                            <div class="col-xxl-6 col-sm-6">
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label class="form-label mt-2 me-5" for="cmbprovince">Periodo Lectivo</label>
                                    </div>
                                    <div class="col-lg-9">
                                        <select class="form-select" id="cmbprovince" wire:model="" required> 
                                            <option value="0" selected>Seleccionar</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label class="form-label mt-2 me-5" for="cmbprovince">Nivel</label>
                                    </div>
                                    <div class="col-lg-9">
                                        <select class="form-select" id="cmbprovince" wire:model="" required> 
                                            <option value="0" selected>Seleccionar</option>
                                        </select>
                                    </div>
                                </div> 
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label class="form-label mt-2 me-5" for="cmbprovince">Especialización</label>
                                    </div>
                                    <div class="col-lg-9">
                                        <select class="form-select" id="cmbprovince" wire:model="" required> 
                                            <option value="0" selected>Seleccionar</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label class="form-label mt-2 me-5" for="cmbprovince">Componente Plan de Estudio</label>
                                    </div>
                                    <div class="col-lg-9">
                                        <select class="form-select" id="cmbprovince" wire:model="" required> 
                                            <option value="0" selected>Seleccionar</option>
                                        </select>
                                    </div>
                                </div>                   
                            </div>
                            <div class="col-xxl-6 col-sm-6">
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label class="form-label mt-2 me-5" for="cmbprovince">Grupo</label>
                                    </div>
                                    <div class="col-lg-9">
                                        <select class="form-select" id="cmbprovince" wire:model="" required> 
                                            <option value="0" selected>Seleccionar</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label class="form-label mt-2 me-5" for="cmbprovince">Grado</label>
                                    </div>
                                    <div class="col-lg-9">
                                        <select class="form-select" id="cmbprovince" wire:model="" required> 
                                            <option value="0" selected>Seleccionar</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label class="form-label mt-2 me-5" for="cmbprovince">Sección</label>
                                    </div>
                                    <div class="col-lg-9">
                                        <select class="form-select" id="cmbprovince" wire:model="" required> 
                                            <option value="0" selected>Seleccionar</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label class="form-label mt-2 me-5" for="cmbprovince">Tipo de Periodo</label>
                                    </div>
                                    <div class="col-lg-9">
                                        <select class="form-select" id="cmbprovince" wire:model="" required> 
                                            <option value="0" selected>Seleccionar</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-12 text-end">
                                        <a wire:click="" id="btnlimpiar" class ="btn btn-soft-secondary w-sm"><i class="ri-search-line me-1"></i>Buscar</a>
                                        <a wire:click="" id="btnlimpiar" class ="btn btn-soft-primary w-sm">Limpiar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--end col-->
    </div>
</div>
