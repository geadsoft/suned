<div>   
    <div class="row">
        <div class="col-xl-7">
            <div class="card">
                <div class="card-body checkout-tab">

                    <form autocomplete="off" wire:submit.prevent="{{ 'createData' }}">
                        <div class="step-arrow-nav mt-n3 mx-n3 mb-3">

                            <ul class="nav nav-pills nav-justified custom-nav" id="tabencashment" role="tablist">
                                
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fs-15 p-3 active" id="pills-bill-address-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-bill-address" type="button" role="tab"
                                        aria-controls="pills-bill-address" aria-selected="true"><i
                                            class=" ri-hand-coin-fill fs-16 p-2 bg-soft-primary text-primary rounded-circle align-middle me-2"></i>
                                            Cobro Information</button>
                                </li>
                                <li class="nav-item" role="presentation" > 
                                    <button class="nav-link fs-15 p-3" id="pills-bill-info-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-bill-info" type="button" role="tab"
                                        aria-controls="pills-bill-info" aria-selected="false"><i
                                            class="ri-user-2-line fs-16 p-2 bg-soft-primary text-primary rounded-circle align-middle me-2"></i>
                                            Billing</button>
                                </li>
                                <!--<li class="nav-item" role="presentation">
                                    <button class="nav-link fs-15 p-3" id="pills-payment-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-payment" type="button" role="tab"
                                        aria-controls="pills-payment" aria-selected="false"><i
                                            class="ri-bank-card-line fs-16 p-2 bg-soft-primary text-primary rounded-circle align-middle me-2"></i>
                                        Payment Info</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fs-15 p-3" id="pills-finish-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-finish" type="button" role="tab" aria-controls="pills-finish"
                                        aria-selected="false"><i
                                            class="ri-checkbox-circle-line fs-16 p-2 bg-soft-primary text-primary rounded-circle align-middle me-2"></i>Finish</button>
                                </li>-->
                            </ul>
                        </div>

                        <div class="tab-content">
                            
                            <div class="tab-pane fade show active" id="pills-bill-address" role="tabpanel" aria-labelledby="pills-bill-address-tab">
                                
                                <div class="d-flex align-items-center flex-wrap gap-2">
                                    <div class="flex-grow-1">
                                        <div>
                                            <h5 class="mb-1">Generality Information</h5>
                                            <p class="text-muted mb-4">Please fill all information below</p>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <div class="input-group">

                                            <!--<div class="dropdown mb-3 p-2">
                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ri-more-fill"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="apps-ecommerce-add-product.html"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i>Void/Retrieve Receipt</a></li>
                                                    <li><a class="dropdown-item" href="apps-ecommerce-product-details.html"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> See invoice </a></li>
                                                    <li class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item remove-list" href="" data-bs-toggle="modal" data-bs-target="#removeItemModal"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete</a></li></ul>
                                            </div>
                                            <div class="mb-3 p-2">
                                                <button href="/financial/encashment-add" class="btn btn-info add-btn btn-sm" data-bs-toggle="modal" data-bs-target=""><i
                                                class="ri-add-fill me-1 align-bottom"></i> New Register </button>
                                            </div>-->    
                                        </div>
                                    </div>
                                </div>
                                        

                                <div class="mt-4">
                                    <div class="d-flex align-items-center">
                                        <div class="">
                                            <div class="mb-3">
                                                <label for="txtfecha" class="form-label">Date Emisión</label>
                                                <input type="date" class="form-control" id="fechaActual" data-provider="flatpickr" data-date-format="d-m-Y" data-time="true" wire:model.defer="record.fecha" required> 
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="mb-3 p-2">
                                                <label for="cmbperiodo" class="form-label">Periodo Lectivo</label>
                                                <select type="select" class="form-select" data-trigger name="cmbnivel" wire:model.defer="record.periodo_id" required>
                                                    @foreach ($tblperiodos as $periodo) 
                                                    <option value="{{$periodo->id}}">{{$periodo->periodo}}</option>
                                                    @endforeach 
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="mb-3">
                                            <div class="card-header">
                                                <h5 class="card-title flex-grow-1 mb-0 text-primary"><i
                                                    class="mdi mdi-account-tie align-middle me-1 text-success"></i>
                                                    Personal Data</h5>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="mb-3">
                                                <!--<input type="text" class="form-control" id="billinginfo-firstName"
                                                    placeholder="Enter Identification" value="">-->
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="billinginfo-firstName" placeholder="Enter ID" wire:model="idbuscar">
                                                    <a id="btnstudents" class ="input-group-text btn btn-soft-secondary" wire:click="search(1)"><i class="ri-user-search-fill me-1"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="mb-3">
                                                <input type="text" class="form-control" id="billinginfo-lastName" placeholder="Enter names" wire:model="nombre">
                                            </div>
                                        </div>
                                        
                                    </div>

                                    <div class="row gy-3">
                                        <div class="col-lg-12 col-sm-6">
                                            <div class="form-check card-radio">
                                                
                                                    <label class="form-check-label" for="shippingAddress01">
                                                    <span class="fw-semibold  text-muted text-uppercase">Tuition</span>
                                                    <span class="fs-15  d-block">Modalidad: Presencial</span>
                                                    <span class="text-muted fw-normal text-wrap mb-1 d-block">Segundo Bach. C</span>
                                                    <span class="text-muted fw-normal d-block">PAGO MATRICULA Y MAYO EN OTRO COLEGIO ACEPTADO POR MR ANDRES MATRICULAR SIN PAGO DE MAYO
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header">
                                            <ul class="nav nav-tabs-custom card-header-tabs border-bottom-0" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-bs-toggle="tab" href="#addpagos" role="tab">
                                                        <h5 class="card-title flex-grow-1 mb-0 text-primary fs-14">
                                                            <i class="mdi mdi-account-cash align-middle me-1 text-success"></i>
                                                                Payment Method</h5>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-bs-toggle="tab" href="#addproduct-metadata" role="tab">
                                                        <h5 class="card-title flex-grow-1 mb-0 text-primary fs-14">
                                                            <i class="mdi mdi-cash-multiple align-middle me-1 text-success"></i>
                                                                Payments</h5>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- end card header -->
                                        <div class="card-body">
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="addpagos" role="tabpanel">
                                                    <div class="row">
                                                        <div class="col-lg-3 col-sm-6">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="stocks-input">Payment Method</label>
                                                                <select type="select" class="form-select" id="cmbtipopago">
                                                                <option value="EFE">Efectivo</option>
                                                                <option value="CHQ">Cheque</option>
                                                                <option value="TCR">Tarjeta</option>
                                                                <option value="DEP">Depósito</option>
                                                                <option value="TRA">Transferencia</option>
                                                                <option value="CON">Convenio</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-5 col-sm-6">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="txtentidad">Entidad</label>
                                                                <!--<input type="text" class="form-control  product-price" id="txtentidad" placeholder="">-->
                                                                <select type="select" class="form-select" data-trigger id="cmbentidad">
                                                                <option value="0"></option>
                                                                @foreach ($tblentidads as $entidad) 
                                                                <option value="{{$entidad->id}}">{{$entidad->descripcion}}</option>
                                                                @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2 col-sm-6">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="txtvalor">Value</label>
                                                                <input type="number" class="form-control  product-price" id="txtvalor" step="0.01" placeholder="0.00">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2 col-sm-6 text-center">
                                                            <div class="mb-3">
                                                            <label class="form-label">-</label>                                     
                                                                <a href="javascript:new_link()" id="add-pago" class ="form-control btn btn-soft-secondary"><i class="ri-add-fill me-1"></i> Agregar</a>
                                                                <!--<a href="javascript:new_link()" id="add-item" class="btn btn-soft-secondary fw-medium"><i class="ri-add-fill me-1 align-bottom"></i> Add Item</a>-->
                                                            </div>
                                                        </div>
                                                        <!-- end col -->
                                                        
                                                    </div>
                                                    <div class="row align-items-center sm-3">
                                                        <div class="col-lg-12 col-sm-6">
                                                            <label class="form-label" for="txtreferencia">Reference</label>
                                                            <input type="text" class="form-control  product-price" id="txtreferencia" placeholder="">
                                                        </div>
                                                    </div>   
                                                    <!-- end row -->
                                                </div>
                                                <!-- end tab-pane -->
                                                
                                                <div class="tab-pane" id="addproduct-metadata" role="tabpanel">
                                                    
                                                        <ul class="nav nav-tabs nav-tabs-custom nav-success mb-3">
                                                        </ul>
                                                        <div class="table-responsive table-card">
                                                            <table class="table table-nowrap align-middle" id="orderTable">
                                                                <thead class="text-muted table-light">
                                                                    <tr class="text-uppercase">
                                                                        <th>Id</th>
                                                                        <th style="width: 180px;">Tipo Pago</th>
                                                                        <th>Referencia</th>
                                                                        <th style="display:none;">Entidad</th>
                                                                        <th style="width: 150px;">Valor</th>
                                                                        <th>Acción</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="newlink">

                                                                </tbody>    
                                                                <tbody>
                                                                    <tr id="newForm" style="display: none;">
                                                                        <td class="d-none" colspan="5">
                                                                            <p>Add New Form</p>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                </div>

                                            </div>
                                            <!-- end tab content -->
                                        </div>
                                        
                                        <!-- end card body -->
                                    </div>
                                    <div class="card-body">
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-success w-sm">Grabar</button>
                                            <a class="btn btn-secondary w-sm" href="/financial/encashment"><i class="me-1 align-bottom"></i>Cancelar</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- end tab pane -->
                        
                            <div class="tab-pane fade" id="pills-bill-info" role="tabpanel" aria-labelledby="pills-bill-info-tab">
                                <div>
                                    <h5 class="mb-1">Billing Information</h5>
                                    <p class="text-muted mb-4">Please fill all information below</p>
                                </div>

                                <div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="mb-3">
                                                 <label for="billinginfo-firstName" class="form-label">ID</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="billinginfo-firstName" placeholder="Enter ID" value="">
                                                    
                                                    <a id="btnbuscar" class ="input-group-text btn btn-soft-secondary"><i class="ri-user-search-fill me-1"></i></a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-8">
                                            <div class="mb-3">
                                                <label for="billinginfo-lastName" class="form-label">Customer</label>
                                                <input type="text" class="form-control" id="billinginfo-lastName"
                                                    placeholder="Enter last name" value="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="billinginfo-email" class="form-label">Email
                                                    <span class="text-muted">(Optional)</span></label>
                                                <input type="email" class="form-control" id="billinginfo-email"
                                                    placeholder="Enter email">
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="billinginfo-phone" class="form-label">Phone</label>
                                                <input type="text" class="form-control" id="billinginfo-phone"
                                                    placeholder="Enter phone no.">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="billinginfo-address" class="form-label">Address</label>
                                        <textarea class="form-control" id="billinginfo-address" placeholder="Enter address" rows="3"></textarea>
                                    </div>

                                    <div class="mt-4">
                                        <div class="row g-4">
                                            <div class="col-lg-6">
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-check card-radio">
                                                    <input id="shippingMethod02" name="shippingMethod" type="radio"
                                                        class="form-check-input" checked>
                                                    <label class="form-check-label" for="shippingMethod02">
                                                        <!--<span class="fs-21 float-end mt-2 text-wrap d-block fw-semibold">$24.99</span>-->
                                                        <input type="text" class="form-control bg-white border-0 text-end fs-21 float-end mt-2 text-wrap d-block fw-semibold" id="cart-totalfact" placeholder="$0.00" readonly />
                                                        <span class="fs-15 mb-1 text-wrap d-block">Total</span>
                                                        <span class="text-muted fw-normal text-wrap d-block">Fact. No. 001-001-000001234</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div> 
                                    </div>
                                </div>

                            </div>
                            <!-- end tab pane -->

                            <div class="tab-pane fade" id="pills-finish" role="tabpanel"
                                aria-labelledby="pills-finish-tab">
                                <div class="text-center py-5">

                                    <div class="mb-4">
                                        <lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop"
                                            colors="primary:#0ab39c,secondary:#405189" style="width:120px;height:120px">
                                        </lord-icon>
                                    </div>
                                    <h5>Thank you ! Your Order is Completed !</h5>
                                    <p class="text-muted">You will receive an order confirmation email
                                        with
                                        details of your order.</p>

                                    <h3 class="fw-semibold">Order ID: <a href="{{URL::asset('/apps-ecommerce-order-details')}}"
                                            class="text-decoration-underline">VZ2451</a></h3>
                                </div>
                            </div>
                            <!-- end tab pane -->
                        </div>
                        <!-- end tab content -->
                    </form>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->

        <div class="col-xl-5">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex ">
                        <div class="flex-grow-1">
                            <h5 class="card-title mb-0">Debts Summary</h5>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="form-check form-check-success" >
                                <input class="form-check-input" type="checkbox" name="chkbill" id="chkbill" onchange="chkbill()">
                                <label class="form-check-label fs-15" for="chkbill">Bill</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-card">
                        <!--Deudas-->
                         @livewire('vc-encashment-debts')       
                            
                        <hr/>
                        <div class="card-body">
                            <div class="d-flex">
                                <label for="cart-subtotal" class="form-label fw-semibold p-1">Subtotal:</label>
                                <input type="text" class="form-control bg-white border-0 text-end fw-semibold mb-0" id="cart-subtotal" placeholder="$0.00" readonly />
                            </div>
                            <div class="d-flex">
                                <label for="cart-descuento" class="form-label p-1">Discount:</label>
                                <input type="text" class="form-control bg-white border-0 text-end" id="cart-descuento" placeholder="$0.00" readonly />
                            </div>
                            <div class="d-flex">
                                <div class="input-group">
                                    <label for="cart-impuesto" class="form-label p-1">Tax (12%):</label>
                                    <input type="text" class="form-control bg-white border-0 text-end" id="cart-impuesto" placeholder="$0.00" readonly />
                                </div>
                            </div>
                            <div class="table-active bg-light">
                                <div class="input-group">
                                    <label for="cart-impuesto" class="form-label fw-semibold p-2">Total (USD):</label>
                                    <input type="text" class="form-control bg-light border-0 text-end fw-semibold" id="cart-total" placeholder="$0.00" readonly />
                                </div>
                            </div>
                            <hr/>
                            <div class="d-flex">
                                <div class="input-group">
                                    <label for="cart-impuesto" class="form-label fw-semibold p-1">TOTAL TO CANCEL:</label>
                                    <input type="text" class="form-control bg-white border-0 text-end" id="cart-pago" placeholder="$0.00"  wire:model.defer="record.monto"  required />
                                </div>
                            </div>

                        </div>
                           

                        <!--<div class="card-body">
                            <div class="justify-content-end">
                                <button type="submit" class="btn btn-success w-sm">Grabar</button>
                                <a class="btn btn-secondary w-sm" href="/financial/encashment"><i class="me-1 align-bottom"></i>Cancelar</a>
                            </div>
                        </div>-->
                    </div>
                    
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->

    <!-- removeItemModal -->
    <div id="removeItemModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mt-2 text-center">
                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                            colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                        <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                            <h4>Are you sure ?</h4>
                            <p class="text-muted mx-4 mb-0">Are you sure you want to remove this Address ?</p>
                        </div>
                    </div>
                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                        <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn w-sm btn-danger ">Yes, Delete It!</button>
                    </div>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

</div>
