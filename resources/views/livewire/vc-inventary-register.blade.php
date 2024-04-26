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
                                    @if($status=='disabled' & $inventarioId>0)
                                    <button type="button" class="btn btn-info"><i
                                            class="ri-printer-fill align-bottom me-1"></i></button>
                                    <button class="btn btn-danger" onClick="deleteMultiple()"><i
                                            class="ri-delete-bin-2-line"></i></button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <fieldset {{$status}}>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="table-responsive mb-1 ">
                                        <table class="table table-borderless table-sm align-middle mb-0" id="orderTable">
                                            <tbody class="list form-check-all">
                                            <tr>
                                                <td>
                                                <h5 class="badge bg-primary text-wrap fs-14">Documento No. {{$record['documento']}}</h5>
                                                </td>
                                                <td>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="form-label p-1" for="product-title-input">Fecha</label>
                                                </td>
                                                <td>
                                                    <input type="date" class="form-control" id="txtfecha" placeholder="" wire:model="record.fecha" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="form-label p-1" for="product-title-input">Tipo</label>
                                                </td>
                                                <td>
                                                    <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false wire:model="tipo" required> 
                                                        <option value="ING">Ingresos</option>
                                                        <option value="EGR">Egresos</option>
                                                    </select>
                                                </td>
                                                <td><label class="form-label p-1" for="product-title-input">Movimiento</label></td>
                                                
                                                <td>
                                                    @if ($tipo=='ING')
                                                    <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false wire:model="record.movimiento" required>
                                                        <option value="II">Inventario Inicial</option>
                                                        <option value="CL">Compras Locales</option>
                                                        <option value="IA">Ingreso por Ajuste</option>
                                                        <option value="DE">Devolucion</option>
                                                    </select>
                                                    @else
                                                    <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false wire:model="record.movimiento" required>
                                                        <option value="VE">Ventas</option>
                                                        <option value="EA">Egreso por Ajuste</option>
                                                    </select>
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-8">
                                @if ($record['movimiento']=='VE')
                                <label class="form-label" for="product-title-input">Razon Social</label>
                                @else
                                <label class="form-label" for="product-title-input">Referencia</label>
                                @endif
                                <div class="input-group mb-2">
                                    @if ($record['movimiento']=='VE')
                                    <input type="text" class="form-control" name="identidad" id="billinginfo-firstName" placeholder="Razon Social" wire:model="record.referencia" required readonly>
                                    @else
                                    <input type="text" class="form-control" name="identidad" id="billinginfo-firstName" placeholder="Razon Social" wire:model="record.referencia" required>
                                    @endif
                                    @if ($record['movimiento']=='VE')
                                    <a id="btnstudents" class ="input-group-text btn btn-soft-secondary" wire:click="buscar()"><i class="ri-user-add-line me-1"></i></a>
                                    @endif
                                </div>
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-label" for="product-title-input">Forma de Pago</label>
                                    <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false wire:model="record.tipopago" required>
                                        <option value="NN">Ninguno</option>
                                        <option value="EFE">Efectivo</option>
                                        <option value="CHQ">Cheque</option>
                                        <option value="TAR">Tarjeta</option>
                                        <option value="DEP">Depósito</option>
                                        <option value="TRA">Transferencia</option>
                                        <option value="APP">App Movil</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="product-title-input">Observación</label>
                                <textarea class="form-control" id="billingAddress" rows="2" placeholder="Descripción de producto" wire:model="record.observacion"></textarea>
                            </div>
                        </div>
                        
                    </div>
                    <!-- end card -->
                    <fieldset {{$status}}>
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                 @livewire('vc-inventary-registerdet',['id' => $inventarioId])
                            </div>
                        </div>
                    </div>
                    <!-- end card -->
            </div>
            <div class="text-end mb-3">
                @if ($inventarioId>0)
                
                <button type="button" wire:click.prevent="procesar()"  class="btn btn-success w-sm">Procesar</button>
            
                @else
                <button type="submit" class="btn btn-success w-sm">Grabar</button>
                @endif
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </form>

    <div wire.ignore.self class="modal fade" id="showModalBuscar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" >
            <div class="modal-content modal-content border-0">
                
                <div class="modal-header p-3 bg-light">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <span> Busqueda de Estudiante &nbsp;</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                </div>
                
                <form autocomplete="off" wire:submit.prevent="">
                    <div class="modal-body">                                        
                            @livewire('vc-modal-search',['opcion' => 'null'])                                       
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
                        @livewire('vc-search-product')                                    
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
</div>
