<div>
    <form id="createproduct-form" autocomplete="off" wire:submit.prevent="{{ 'createData' }}">
        <div class="row">
            <div class="col-lg-12">                    
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h5 class="card-title flex-grow-1 mb-0 text-primary"><i
                                class="ri-shopping-bag-line me-1 text-success"></i>
                                Registrar Movimientos de Inventario</h5>
                                <div class="flex-shrink-0">
                                    <a class="btn btn-icon btn-success" wire:click="add()"><i
                                    class="ri-add-fill fs-22"></i></a>
                                    @if($status=='disabled' & $inventarioId>0)
                                        @if ($record['estado'] =='P')
                                        <a class="btn btn-icon btn-info" href="/preview-pdf/record-inv/{{$inventarioId}}" target="_blank"><i
                                        class="ri-printer-fill fs-22"></i></a>
                                        @else
                                        <button type="button" wire:click="edit()" class="btn btn-icon btn-info"><i
                                                class="ri-edit-2-fill fs-22"></i></button>
                                        @endif
                                        @if ($record['estado'] =='G')
                                        <button class="btn btn-icon btn-danger" wire:click="delete()"><i
                                                class="ri-delete-bin-line fs-22"></i></button>
                                        @endif
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
                                                        <option value="EA">Egreso por Ajuste</option>
                                                        <option value="DC">Devolucion por Compra</option>
                                                    </select>
                                                    @else
                                                    <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false wire:model="record.movimiento" required>
                                                        <option value="VE">Ventas</option>
                                                        <option value="DV">Devolucion por Venta</option>
                                                    </select>
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-7">
                                    <div class="col-lg-12">
                                        @if ($record['movimiento']=='VE')
                                        <label class="form-label" for="product-title-input">Razon Social</label>
                                        @else
                                        <label class="form-label" for="product-title-input">Referencia</label>
                                        @endif
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control" name="identidad" id="billinginfo-firstName" placeholder="Razon Social" wire:model="record.referencia" required>
                                            @if ($record['movimiento']=='VE')
                                            <a id="btnstudents" class ="input-group-text btn btn-soft-secondary" wire:click="buscar()"><i class="ri-user-add-line me-1"></i></a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="product-title-input">Observación</label>
                                        <textarea class="form-control" id="billingAddress" rows="2" placeholder="Descripción de producto" wire:model="record.observacion"></textarea>
                                    </div>
                                </div>
                                <div class="col-xl-5">
                                    <label class="form-label" for="product-title-input">Forma de Pago</label>
                                    <table class="table table-nowrap table-sm" id="orderTable">
                                        <thead class="text-muted table-light">
                                            <tr class="text-uppercase">
                                                <th>Linea</th>
                                                <th>Tipo Pago</th>
                                                <th>Valor</th>
                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($objPago as $key => $row)
                                        <tr class="">
                                            <td>{{$row['linea']}}</td>
                                            <td style="width: 250px;">
                                                <select type="select" class="form-select-sm bg-white border-0" name="cmbtipopago" id="cmbtipopago-{{$key+1}}" wire:model.prevent="objPago.{{$key}}.tipopago">
                                                    <option value="EFE">Efectivo</option>
                                                    <option value="CHQ">Cheque</option>
                                                    <option value="TAR">Tarjeta</option>
                                                    <option value="DEP">Depósito</option>
                                                    <option value="TRA">Transferencia</option>
                                                    <option value="CON">Convenio</option>
                                                    <option value="APP">App Movil</option>
                                                    <option value="RET">Retención</option>
                                                    <option value="OTR">Convenio</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control-sm bg-white border-0" style="width: 90px;"  id="txtvalor-{{$key+1}}" step="0.01" wire:model.prevent="objPago.{{$key}}.valor"/>
                                            </td>
                                            <td class="pagos-removal">
                                                <ul class="list-inline hstack gap-2 mb-0">
                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="Agregar">
                                                        <a href="" wire:click="addpago" class="text-success d-inline-block remove-item-btn"
                                                            data-bs-toggle="modal" >
                                                            <i class="ri-add-circle-line fs-16"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="Remover">
                                                        <a href="" wire:click="delpago({{$row['linea']}})" class="text-danger d-inline-block remove-item-btn"
                                                            data-bs-toggle="modal" >
                                                            <i class="ri-close-circle-line fs-16"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
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
                @if ($inventarioId==0 || $action=='E')
                <button type="submit" class="btn btn-success w-sm">Grabar</button>
                @endif
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
        <div class="text-end mb-3">
            @if ($inventarioId>0 & $record['estado']=="G" & $action!='E')
                <button type="button" wire:click="procesar()"  class="btn btn-secondary w-sm">Procesar</button>
            @endif
            </div>
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
                            @livewire('vc-modal-search',['opcion' => 'INV'])                                       
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
                
                <form autocomplete="off">
                    
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
