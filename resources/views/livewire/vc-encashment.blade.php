<div>   
    <div class="row">
        <div class="col-xl-7">
            <div class="card">
                <div class="card-body checkout-tab">

                    <form action="#">
                        <div class="step-arrow-nav mt-n3 mx-n3 mb-3">

                            <ul class="nav nav-pills nav-justified custom-nav" id="tabencashment" role="tablist">
                                
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fs-15 p-3 active" id="pills-bill-address-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-bill-address" type="button" role="tab"
                                        aria-controls="pills-bill-address" aria-selected="true"><i
                                            class=" ri-hand-coin-fill fs-16 p-2 bg-soft-primary text-primary rounded-circle align-middle me-2"></i>
                                            Información del Recibo</button>
                                </li>
                                <li class="nav-item" role="presentation" > 
                                    <button class="nav-link fs-15 p-3" id="pills-bill-info-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-bill-info" type="button" role="tab"
                                        aria-controls="pills-bill-info" aria-selected="false"><i
                                            class="ri-user-2-line fs-16 p-2 bg-soft-primary text-primary rounded-circle align-middle me-2"></i>
                                            Facturación</button>
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
                                            <h5 class="badge bg-primary text-wrap fs-14">Recibo No. {{$documento}}</h5>
                                            @if ($estado=='A')
                                                <p class="text-danger mb-4 ">{{$concepto}} - ANULADO
                                                </p>
                                            @else
                                                <p class="text-success mb-4 ">{{$concepto}} 
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    
                                </div>
                                        
                                <div class="mb-3">
                                    <div class="card-header">
                                        <div class="d-flex align-items-center">
                                        <h5 class="card-title flex-grow-1 mb-0 text-primary"><i
                                            class="mdi mdi-account-tie align-middle me-1 text-success"></i>
                                            Datos Personales</h5>
                                            <div class="flex-shrink-0">
                                                <a class="btn btn-info add-btn" wire:click="add()"><i
                                                class="ri-add-fill me-1 align-bottom"></i> Nuevo </a>
                                                <button class="btn btn-secondary dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ri-align-justify me-1 align-bottom"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item"  data-bs-toggle="modal" href="" wire:click.prevent="anular({{ $selectId }})">
                                                    <i class="ri-close-circle-line align-bottom me-2 text-muted fs-16"></i>Anular/Recuperar Recibo</a></li>
                                                    <li class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item remove-item-btn" data-bs-toggle="modal" href="" wire:click.prevent="delete({{ $selectId }})">
                                                    <i class="ri-delete-bin-fill align-bottom me-2 text-muted fs-16"></i>Eliminar</a></li>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <div class="d-flex align-items-center">
                                        <div class="">
                                            <div class="mb-3">
                                                <label for="txtfecha" class="form-label">Date Emisión</label>
                                                <input type="date" class="form-control border-0" id="txtfecha"
                                                    placeholder="Enter first name" value="{{$fecha}}" disabled>
                                            </div>
                                        </div>
                                        <div class="">
                                            <div class="mb-3 p-2">
                                                <label for="cmbperiodo" class="form-label">Identificación</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control border-0" id="billinginfo-firstName" placeholder="Enter ID" value="{{$identificacion}}" disabled>
                                                    <a id="btnstudents" class ="input-group-text btn btn-soft-secondary disabled" wire:click="search(1)"><i class="ri-user-search-fill me-1"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="mb-3 p-2">
                                                <label for="cmbperiodo" class="form-label">Estudents</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control border-0" id="billinginfo-lastName" placeholder="Enter names" value="{{$estudiante}}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row gy-3">
                                        <div class="col-lg-12 col-sm-6">
                                            <div class="form-check card-radio">
                                                
                                                    <label class="form-check-label" for="shippingAddress01">
                                                    <span class="fw-semibold  text-muted text-uppercase">Tuition</span>
                                                    <span class="fs-15  d-block">Modalidad: {{$grupo}}</span>
                                                    <span class="text-muted fw-normal text-wrap mb-1 d-block">{{$curso}}</span>
                                                    <span class="text-muted fw-normal d-block">{{$comentario}}</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="mb-3 sm-3">
                                        <div class="card-header">
                                            <h5 class="card-title flex-grow-1 mb-0 text-primary"><i
                                                class="mdi mdi-cash-multiple align-middle me-1 text-success"></i>
                                                Método de Pago</h5>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="tab-content">                                              
                                                <div class="tab-pane active" id="addproduct-metadata" role="tabpanel">
                                                    
                                                        <ul class="nav nav-tabs nav-tabs-custom nav-success mb-3">
                                                        </ul>
                                                        <div class="table-responsive table-card">
                                                            <table class="table table-nowrap align-middle" id="orderTable">
                                                                <thead class="text-muted table-light">
                                                                    <tr class="text-uppercase">
                                                                        <th style="width: 180px;">Tipo Pago</th>
                                                                        <th style="width: 180px;">Entidad</th>
                                                                        <th style="width: 80px;">Numero</th>
                                                                        <th>Referencia</th>
                                                                        <th style="width: 120px;">Valor</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                @if(!is_null($tblcobrodet))
                                                                    @foreach ($tblcobrodet as $cobrodet)
                                                                    <tr>   
                                                                        <td>
                                                                            <select type="select" class="form-select-sm border-0" id="cmbtipopago" disabled>
                                                                            @switch($cobrodet->tipopago)
                                                                                @case('EFE')
                                                                                <option value="EFE">Efectivo</option>
                                                                                @case('CHQ')
                                                                                <option value="CHQ">Cheque</option>
                                                                                @case('TAR')
                                                                                <option value="TCR">Tarjeta</option>
                                                                                @case('DEP')
                                                                                <option value="DEP">Depósito</option>
                                                                                @case('TRA')
                                                                                <option value="TRA">Transferencia</option>
                                                                                @case('CON')
                                                                                <option value="CON">Convenio</option>
                                                                                @case('OTR')
                                                                                <option value="OTR">Otros</option>
                                                                            @endswitch
                                                                            </select>
                                                                        </td> 
                                                                        <td>
                                                                            <select type="select" class="form-select-sm border-0" disabled>
                                                                                <option value="{{$cobrodet->entidadId}}">{{$cobrodet->entidad->descripcion}}</option>
                                                                            </select>
                                                                        </td>
                                                                        <td class="text-end">
                                                                            <input type="number" class="form-control-sm product-price bg-light border-0 text-end" id="desc" step="0.01" 
                                                                            placeholder="0.00" value="{{$cobrodet->numero}}" disabled/>
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" class="form-control-sm bg-light border-0 text-end" value="{{$cobrodet->referencia}}" disabled/>
                                                                        </td> 
                                                                        <td>
                                                                            <input type="text" class="form-control-sm bg-light border-0 text-end" value="{{number_format($cobrodet->valor,2)}}" disabled/>
                                                                        </td>
                                                                    </tr>
                                                                    @endforeach
                                                                 @endif
                                                                </tbody>    
                                                            </table>
                                                            <br>
                                                            <br>
                                                            <br>
                                                        </div>
                                                </div>

                                            </div>
                                            <!-- end tab content -->
                                        </div>
                                        <!-- end card body -->
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
                            <h5 class="card-title mb-0">Concepto de Cobros</h5>
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
                        <table class="table table-borderless align-middle mb-0">
                            <thead class="table-light text-muted">
                                <tr>
                                    <th scope="col" style="width: 50px;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="checkAll"
                                                value="option">
                                        </div>
                                    </th>
                                    <th style="width: 60px; display:none;" scope="col">id</th>
                                    <th style="width: 180px;" scope="col">Referencia</th>
                                    <th style="width: 120px;" scope="col" class="text-end">Valor</th>
                                    <th style="width: 120px;" scope="col" class="text-end">Descuento</th>
                                    <th style="width: 120px;" scope="col" class="text-end">Cancelado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!is_null($tbldeudas))
                                    @foreach ($tbldeudas as $record)  
                                    <tr class="deudas">
                                        <th scope="row">
                                            <div class="form-check form-check-success">
                                                <input class="form-check-input" type="checkbox" id="chkpago" checked>
                                            </div>
                                        </th>
                                        <td class="text-dark">{{$record->deudacab->referencia}}</td>
                                        <td class="text-end">
                                            <input type="number" class="form-control product-price bg-white border-0 text-end" id="saldo" step="0.01" 
                                                placeholder="0.00" value="{{number_format($record->deudacab->saldo+$record->valor+$record->deudacab->descuento,2)}}" readonly/>
                                        </td>
                                        <td class="text-end">
                                            <input type="number" class="form-control product-price bg-light border-0 text-end" id="desc" step="0.01" 
                                            placeholder="0.00" value="{{number_format($record->deudacab->descuento,2)}}" />
                                        </td>
                                        <td class="text-end">
                                            <input type="number" class="form-control product-price bg-white border-0 text-end" id="saldo" step="0.01" 
                                                placeholder="0.00" value="{{number_format($record->valor,2)}}" readonly/>
                                        </td>
                                    </tr>
                                    <script>
                                        $this->subtotal += $record->deudacab->saldo+$record->valor
                                    </script>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        <hr/>
                        <div class="card-body">
                            <div class="d-flex">
                                <label for="cart-subtotal" class="form-label fw-semibold p-1">Subtotal:</label>
                                <input type="text" class="form-control bg-white border-0 text-end fw-semibold mb-0" id="cart-subtotal" placeholder="$0.00" value="${{number_format($subtotal,2)}}" readonly />
                            </div>
                            <div class="d-flex">
                                <label for="cart-descuento" class="form-label p-1">Discount:</label>
                                <input type="text" class="form-control bg-white border-0 text-end" id="cart-descuento" placeholder="$0.00" value="${{number_format($descuento,2)}}" readonly />
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
                                    <input type="text" class="form-control bg-light border-0 text-end fw-semibold" id="cart-total" value="${{number_format($total,2)}}" placeholder="$0.00" readonly />
                                </div>
                            </div>
                            <hr/>
                            <div class="d-flex">
                                <div class="input-group">
                                    <label for="cart-impuesto" class="form-label fw-semibold p-1">TOTAL TO CANCEL:</label>
                                    <input type="text" class="form-control bg-white border-0 text-end fw-semibold fs-15" id="cart-pago" placeholder="$0.00" value="${{number_format($totalpago,2)}}" readonly />
                                </div>
                            </div>

                        </div>
                           

                        <div class="card-body">
                            <div class="justify-content-end">
                                <a href="/preview-pdf/comprobante/{{$selectId}}" class="btn btn-danger"><i class="ri-printer-line align-bottom me-1"></i> Print</a>
                                <a href="/download-pdf/comprobante/{{$selectId}}" class="btn btn-success"><i class="ri-download-2-line align-bottom me-1"></i>Download PDF</a>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->

    <!-- Modal -->
    <div wire.ignore.self class="modal fade flip" id="deleteCobro" tabindex="-1" aria-hidden="true" wire:model='selectId'>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body p-5 text-center">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                        colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px">
                    </lord-icon>
                    <div class="mt-4 text-center">
                        <h4>¿Seguro de eliminar el Recibo? {{$documento}}</h4>
                        <p class="text-muted fs-15 mb-4">Esta opción eliminará el registro del ingreso financiero. 
                        Esta acción es irreversible</p>
                        <div class="hstack gap-2 justify-content-center remove">
                            <button class="btn btn-link link-success fw-medium text-decoration-none"
                                data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i>
                                Cerrar</button>
                            <button class="btn btn-danger" id="delete-record"  wire:click="deleteData()"> Si,
                                Eliminar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end delete modal -->

    <!-- Modal -->
    <div wire.ignore.self class="modal fade flip" id="anulaCobro" tabindex="-1" aria-hidden="true" wire:model='selectId'>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body p-5 text-center">
                    <lord-icon src="https://cdn.lordicon.com/tvyxmjyo.json" trigger="loop"
                        colors="primary:#405189,secondary:#f06548" style="width:150px;height:150px">
                    </lord-icon>
                    @if($estado!='A')
                    <div class="mt-4 text-center">
                        <h4>¿Seguro de anular el Recibo? {{$documento}}</h4>
                        <p class="text-muted fs-15 mb-4">Esta opción cambiará el estado del registro del ingreso financiero 
                        (recibo anulado o no), esta acción es reversible</p>
                    @else
                        <h4>¿Seguro de recuperar el Recibo? {{$documento}}</h4>
                        <p class="text-muted fs-15 mb-4">Esta opción cambiará el estado del registro del ingreso financiero 
                        (recibo anulado o no), esta acción es reversible</p>
                    @endif
                        <div class="hstack gap-2 justify-content-center remove">
                            <button class="btn btn-link link-success fw-medium text-decoration-none"
                                data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i>
                                Cerrar</button>
                            
                            <button class="btn btn-danger" id="delete-record"  wire:click="anularData()"> Si,
                                @if($estado!='A') Anular @else Recuperar @endif
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end delete modal -->

    <div wire.ignore.self class="modal fade" id="showModalBuscar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" >
            <div class="modal-content modal-content border-0">
                
                <div class="modal-header p-3 bg-light">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <span> Registrar Cobro &nbsp;</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                </div>
                
                <form autocomplete="off" wire:submit.prevent="">
                    <div class="modal-body">                                        
                            @livewire('vc-modal-search')                                       
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
