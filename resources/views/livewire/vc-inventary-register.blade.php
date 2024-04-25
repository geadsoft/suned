<div>
    <form id="createproduct-form" autocomplete="off" wire:submit.prevent="{{ 'createData' }}" class="needs-validation">
        <div class="row">
            <div class="col-lg-12">                    
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h5 class="card-title flex-grow-1 mb-0 text-primary"><i
                                class="ri-shopping-bag-line me-1 text-success"></i>
                                Registrar Movimientos de Inventario</h5>
                                <div class="flex-shrink-0">
                                    <a class="btn btn-success add-btn" wire:click="add()"><i
                                    class="ri-add-fill me-1 align-bottom"></i></a>
                                    <button type="button" class="btn btn-info"><i
                                            class="ri-printer-fill align-bottom me-1"></i></button>
                                    <button class="btn btn-danger" onClick="deleteMultiple()"><i
                                            class="ri-delete-bin-2-line"></i></button>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="table-responsive mb-1 ">
                                        <table class="table table-borderless table-sm align-middle mb-0" id="orderTable">
                                            <tbody class="list form-check-all">
                                            <tr>
                                                <td>
                                                    <label class="form-label p-1" for="product-title-input">Documento</label>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" id="product-title-input" value="" placeholder="Ingrese cóidgo de producto" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="form-label p-1" for="product-title-input">Fecha</label>
                                                </td>
                                                <td>
                                                    <input type="date" class="form-control" id="txtfecha" placeholder="">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="form-label p-1" for="product-title-input">Tipo</label>
                                                </td>
                                                <td>
                                                    <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false required>
                                                        <option value="ING" selected>Ingresos</option>
                                                        <option value="EGR">Egresos</option>
                                                    </select>
                                                </td>
                                                <td><label class="form-label p-1" for="product-title-input">Movimiento</label></td>
                                                <td><select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false required>
                                                    <option value="II">Inventario Inicial</option>
                                                    <option value="CL">Compras Locales</option>
                                                    <option value="IA">Ingreso por Ajuste</option>
                                                    <option value="DE">Devolucion por Egreso</option>
                                                    <option value="VE">Ventas</option>
                                                    <option value="EA">Egreso por Ajuste</option>
                                                </select></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="product-title-input">Razon Social</label>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="identidad" id="billinginfo-firstName" placeholder="Razon Social" wire:model="cliente" required>
                                    <a id="btnstudents" class ="input-group-text btn btn-soft-secondary" wire:click="buscar()"><i class="ri-user-add-line me-1"></i></a>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="product-title-input">Descripción</label>
                                <textarea class="form-control" id="billingAddress" rows="2" placeholder="Descripción de producto"></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- end card -->

                    <div class="card">
                        <div class="card-body">
                            
                            <div class="table-responsive">
                                 @livewire('vc-inventary-registerdet')
                            </div>
                        </div>

                    </div>
                    <!-- end card -->
                    <div class="text-end mb-3">
                        <button type="submit" class="btn btn-success w-sm">Grabar</button>
                    </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
        <div wire.ignore.self class="modal fade" id="showProducto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" >
                <div class="modal-content modal-content border-0">
                    
                    <div class="modal-header p-3 bg-light">
                        <h5 class="modal-title" id="exampleModalLabel">
                            <span> Busqueda de Productos &nbsp;</span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                    </div>
                    
                    <form autocomplete="off" wire:submit.prevent="">
                        <div class="modal-body">                                        
                                                                     
                        </div>
                        <div class="modal-footer">
                            <div class="hstack gap-2 justify-content-end">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <!--<button type="button" wire:click.prevent="add()" class="btn btn-success" id="add-btn">Continuar</button>-->
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </form>
</div>
