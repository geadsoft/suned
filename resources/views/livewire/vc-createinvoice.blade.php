<div>
    <div class="row justify-content-center">
        <div class="col-xxl-9">
            <div class="card">
                <form class="needs-validation" novalidate id="invoice_form">
                    <div class="card-body border-bottom border-bottom-dashed p-4">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="profile-user mx-auto  mb-3">
                                    <input id="profile-img-file-input" type="file" class="profile-img-file-input" />
                                    <label for="profile-img-file-input" class="d-block" tabindex="0">
                                        <span class="overflow-hidden border border-dashed d-flex align-items-center justify-content-center rounded" style="height: 60px; width: 256px;">
                                            <img src="{{ URL::asset('assets/images/companies/American Schooll.png') }}" class="card-logo card-logo-dark user-profile-image img-fluid" alt="logo dark">
                                            
                                        </span>
                                    </label>
                                </div>
                                
                            </div>
                            <!--end col-->
                            <div class="col-lg-4 ms-auto">
                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-sm-6">
                            </div>
                            <div class="col-lg-2 col-sm-6">
                                <label for="cmbestab">Establecimiento</label>
                                <select type="select" class="form-select bg-light border-0" id="cmbestab"  wire:model.defer="establecimiento">
                                    @foreach ($tblsedes as $tblsede) 
                                        <option value="{{$tblsede->establecimiento}}">{{$tblsede->establecimiento}}</option>
                                    @endforeach 
                                </select>
                            </div>
                            <div class="col-lg-2 col-sm-6">
                                <label for="cmbptoemision">Punto de Emisión</label>
                                <select type="select" class="form-select bg-light border-0" id="cmbptoemision" wire:model.defer="ptoemision">
                                    @foreach ($tblsedes as $tblsede) 
                                        <option value="{{$tblsede->punto_emision}}">{{$tblsede->punto_emision}}</option>
                                    @endforeach 
                                </select>
                            </div>
                            <div class="col-lg-2 col-sm-6">
                                <label for="txtsecuencia">Invoice No</label>
                                <input type="text" class="form-control bg-light border-0" id="invoicenoInput" placeholder="Invoice No"  wire:model.defer="record.documento" readonly="readonly" />
                            </div>
                        </div>
                        <!--end row-->
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-lg-8 col-sm-6">
                                <label for="invoicenoInput">Cliente</label>
                                <select type="select" class="form-select bg-light border-0" id="invoicenoInput" wire:model="selectPersona">
                                    <option value="">Selected Cliente</option>
                                     @foreach ($tblpersonas as $tblpersona) 
                                        <option value="{{$tblpersona->id}}">{{$tblpersona->apellidos}} {{$tblpersona->nombres}}</option>
                                    @endforeach 
                                </select>
                            </div>
                            <div class="col-lg-2 col-sm-6">
                                <div>
                                <label for="date-field">Date</label>
                                <input type="date" class="form-control bg-light border-0" id="fechaActual" data-provider="flatpickr" data-date-format="d-m-Y" data-time="true" wire:model.defer="record.fecha" required>
                            </div>
                            </div>
                        </div>
                        <!--end row-->
                    </div>
                    <div class="card-body p-4 border-top border-top-dashed">
                        <div class="row g-3">
                            <div class="col-lg-6 col-sm-6">
                                <div class="mb-2">
                                    <textarea class="form-control bg-light border-0" id="billingAddress" rows="3" placeholder="Address" wire:model="direccion" readonly></textarea>
                                    <div class="invalid-feedback">
                                        Please enter a address
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6">
                                <div class="mb-2">
                                    <input type="text" class="form-control bg-light border-0" data-plugin="cleave-phone" id="billingPhoneno" placeholder="+593-" wire:model="telefono" readonly/>
                                    <div class="invalid-feedback">
                                        Please enter a phone number
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <input type="text" class="form-control bg-light border-0" id="billingTaxno" placeholder="Email" wire:model="email" readonly/>
                                    <div class="invalid-feedback">
                                        Please enter a tax number
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <hr style="border-style:double">
                            <div class="col-md-6 col-sm-5" wire:ignore>
                                <select type="text" class="form-select bg-light border-0" id="productName-1" placeholder="Product Name" wire:model="producto_id" wire:change="selectItem" required>
                                    <option value="">Selected Product</option>
                                    @foreach ($tbldeudas as $deuda) 
                                        <option value="{{$deuda->id}}">{{$deuda->glosa}}</option>
                                    @endforeach 
                                </select>
                            </div>
                            <div class="col-md-1 col-sm-2">
                                <input type="number" class="form-control bg-light border-0" placeholder="Cantidad" wire:model="cantidadDig" readonly/>
                            </div>
                            <div class="col-sm-2">
                                <input type="number" class="form-control product-price bg-light border-0" step="0.01" placeholder="Precio" wire:model="precioventa" required />
                            </div>
                            <div class="col-sm-2">
                                <input type="number" class="form-control bg-light border-0" step="0.01" placeholder="Descuento" wire:model="descuento" required />
                            </div>
                            <div class="col-sm-1">
                                 <a href="javascript:new_link()" id="add-item" class="btn btn-soft-secondary fw-medium border-0" wire:click.prevent="addProduct()"><i class="ri-add-fill me-1 align-bottom"></i></a>                            </div>
                        </div>
                    </div>


                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="invoice-table table table-borderless table-nowrap mb-0">
                                <thead class="align-middle">
                                    <tr class="table-active">
                                        <th scope="col" style="width: 50px;">#</th>
                                        <th scope="col">
                                            Product Details
                                        </th>
                                        <th scope="col" style="width: 120px;">Quantity</th>
                                        <th scope="col" style="width: 120px;">
                                            <div class="d-flex currency-select input-light align-items-center">
                                                Price
                                            </div>
                                        </th>
                                        <th scope="col" style="width: 120px;">
                                            <div class="d-flex currency-select input-light align-items-center">
                                                Discount
                                            </div>
                                        </th>
                                        <th scope="col" class="text-end" style="width: 120px;">Subtotal</th>
                                        <th scope="col" class="text-end" style="width: 50px;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($detalleVtas as $key => $product) 
                                        <tr class="text-center" wire:key="{{$key}}">
                                            <td scope="row" class="product-id"> {{$key+1}}</td>
                                            <td class="text-start">  
                                                <input type="text" class="form-control bg-light border-0" value="{{$product['nombre']}}" readonly>
                                            </td>
                                            <td> 
                                                <input type="number" class="form-control product-price bg-light border-0" value="{{$product['cantidad']}}" readonly>
                                            </td>
                                            <td> 
                                                <input type="number" class="form-control product-price bg-light border-0" value="{{$product['precio']}}" readonly/>
                                            </td>
                                            <td>  
                                                <input type="number" class="form-control product-price bg-light border-0" value="{{$product['descuento']}}" readonly/>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control product-price bg-light border-0" value="{{$product['total']}}" readonly/>
                                            </td>
                                            <td>  
                                                <button class="btn btn-danger btn-sm" wire:click.prevent="removeItem{{$key}}">X</button>
                                            </td>
                                        </tr>
                                    @endforeach 
                                </tbody>
                               

                            </table>
                            <!--end table-->
                            <table class="invoice-table table table-borderless table-nowrap mb-0">
                                
                            </table>
                            
                        </div>
                        <div class="class-container-fluid mt-5 d-flex justify-content-center w-100">
                            <div class="table-responsive">
                                <table class="invoice-table table table-borderless table-nowrap mb-0">
                                    
                                </table>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-lg-7">
                                <div class="mb-3 sm-3">
                                    <div class="card-header">
                                        <h5 class="card-title flex-grow-1 mb-0"><i
                                            class="align-middle me-1"></i>
                                            Payment Method</h5>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <div class="mb-3 p-2">
                                        <label for="billinginfo-firstName" class="form-label">Plazo</label>
                                    </div>
                                    <div class="mb-3 p-2">
                                        <input class="form-control bg-light border-0" type="text" id="cardholderName" placeholder="Plazo" wire:model="plazo">
                                    </div>
                                    <div class="mb-3 p-2">
                                        <select class="form-select bg-light border-0" data-choices data-choices-search-false id="choices-payment-status">
                                            <option value="Dias">Dias</option>
                                            <option value="Semana">Semana</option>
                                            <option value="Meses">Meses</option>
                                        </select>
                                    </div>

                                </div>
                                <div class="table-responsive">
                                    <table class="invoice-table table table-borderless table-nowrap mb-0">
                                        <tbody id="newlink">
                                            <tr id="1" class="product">
                                                <th scope="row" class="product-id">1</th>
                                                <td class="text-start">
                                                    <div class="mb-2">
                                                        <select type="select" class="form-select bg-light border-0" id="selfpago-1" required>
                                                            <option value="01">SIN UTILIZACION DEL SISTEMA FINANCIERO</option>
                                                            <option value="15">COMPENSACIÓN DE DEUDAS</option>
                                                            <option value="16">TARJETA DE DÉBITO</option>
                                                            <option value="17">DINERO ELECTRÓNICO</option>
                                                            <option value="18">TARJETA PREPAGO</option>
                                                            <option value="19">TARJETA DE CRÉDITO</option>
                                                            <option value="20">OTROS CON UTILIZACION DEL SISTEMA FINANCIERO</option>
                                                            <option value="21">ENDOSO DE TÍTULOS</option>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control product-price bg-light border-0" id="productprice-1" step="0.01" placeholder="0.00" wire:model="montopago"/>
                                                </td>
                                                <td>
                                                    <li class="list-inline-item " data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                                        <a class="text-danger d-inline-block remove-item-btn"
                                                            data-bs-toggle="modal" href="">
                                                            <i class="ri-delete-bin-5-fill fs-16"></i>
                                                        </a>
                                                    </li>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody>
                                            <tr id="newForm" style="display: none;">
                                                <td class="d-none" colspan="5">
                                                    <p>Add New Form</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="5">
                                                    <a href="javascript:new_link()" id="add-item" class="btn btn-soft-secondary fw-medium"><i class="ri-add-fill me-1 align-bottom"></i> Add </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mb-3 sm-3">
                                    <div class="card-header">
                                        <h5 class="card-title flex-grow-1 mb-0"><i
                                            class="align-middle me-1"></i>
                                            Additional Information</h5>
                                    </div>
                                </div>
                                <!--<div class="table-responsive">
                                    <table class="invoice-table table table-borderless table-nowrap mb-0">
                                        <tbody id="newfpago">
                                            <tr id="1" class="infoadicional">
                                                <th scope="row" class="infoadicional-id">1</th>
                                                <td>
                                                    <input type="text" class="form-control bg-light border-0" data-plugin="cleave-phone" id="billingPhoneno" placeholder="Nombre" value="Dirección" required />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control bg-light border-0" data-plugin="cleave-phone" id="billingPhoneno" placeholder="Detalle" required />
                                                </td>
                                                <td>
                                                    <li class="list-inline-item " data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                                        <a class="text-danger d-inline-block remove-item-btn"
                                                            data-bs-toggle="modal" href="">
                                                            <i class="ri-delete-bin-5-fill fs-16"></i>
                                                        </a>
                                                    </li>
                                                </td>
                                            </tr>
                                            <tr id="2" class="infoadicional">
                                                <th scope="row" class="infoadicional-id">2</th>
                                                <td>
                                                    <input type="text" class="form-control bg-light border-0" data-plugin="cleave-phone" id="billingPhoneno" placeholder="Nombre" value="Telefono" required />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control bg-light border-0" data-plugin="cleave-phone" id="billingPhoneno" placeholder="Detalle" required />
                                                </td>
                                                <td>
                                                    <li class="list-inline-item " data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                                        <a class="text-danger d-inline-block remove-item-btn"
                                                            data-bs-toggle="modal" href="">
                                                            <i class="ri-delete-bin-5-fill fs-16"></i>
                                                        </a>
                                                    </li>
                                                </td>
                                            </tr>
                                            <tr id="3" class="infoadicional">
                                                <th scope="row" class="infoadicional-id">3</th>
                                                <td>
                                                    <input type="text" class="form-control bg-light border-0" data-plugin="cleave-phone" id="billingPhoneno" placeholder="Nombre" value="Email" required />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control bg-light border-0" data-plugin="cleave-phone" id="billingPhoneno" placeholder="Detalle" required />
                                                </td>
                                                <td>
                                                    <li class="list-inline-item " data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                                        <a class="text-danger d-inline-block remove-item-btn"
                                                            data-bs-toggle="modal" href="">
                                                            <i class="ri-delete-bin-5-fill fs-16"></i>
                                                        </a>
                                                    </li>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody>
                                            <tr id="newForm" style="display: none;">
                                                <td class="d-none" colspan="5">
                                                    <p>Add New Form</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="5">
                                                    <a href="javascript:new_link()" id="add-item" class="btn btn-soft-secondary fw-medium"><i class="ri-add-fill me-1 align-bottom"></i> Add </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>-->

                            </div>
                            <div class="col-lg-5">
                                <div class="input-group mb-3">
                                    <label for="cart-subtotal" class="form-label p-1">Subtotal Base 0%:</label>
                                    <input type="text" class="form-control bg-white border-0 text-end" id="cart-base0" placeholder="$0.00"  wire:model="subtotal" readonly />
                                </div>
                                <div class="input-group mb-3">
                                    <label for="cart-descuento" class="form-label p-1">Subtotal Base IVA:</label>
                                    <input type="text" class="form-control bg-white border-0 text-end" id="cart-baseiva" placeholder="$0.00" value="0.00" readonly />
                                </div>
                                <div class="input-group mb-3">
                                    <label for="cart-descuento" class="form-label p-1">Subtotal no sujeto:</label>
                                    <input type="text" class="form-control bg-white border-0 text-end" id="cart-nosujeto" placeholder="$0.00" value="0.00" readonly />
                                </div>
                                <div class="input-group mb-3">
                                    <label for="cart-descuento" class="form-label p-1">Subtotal Exento:</label>
                                    <input type="text" class="form-control bg-white border-0 text-end" id="cart-excento" placeholder="$0.00" value="0.00" readonly />
                                </div>
                                <hr style="height:2px;background:#000">
                                <div class="input-group mb-3">
                                    <label for="cart-subtotal" class="form-label  fw-semibold p-1">Subtotal:</label>
                                    <input type="text" class="form-control bg-white border-0 text-end" id="cart-subtotal" placeholder="$0.00" wire:model="subtotal" readonly />
                                </div>
                                <div class="input-group mb-3">
                                    <label for="cart-descuento" class="form-label p-1">IVA:</label>
                                    <input type="text" class="form-control bg-white border-0 text-end" id="cart-impuesto" placeholder="$0.00" value="0.00" readonly />
                                </div>
                                <hr style="border-style:double">
                                <div class="input-group mb-3 fs-16">
                                    <label for="cart-descuento" class="form-label p-1">TOTAL A PAGAR:</label>
                                    <input type="text" class="form-control bg-white border-0 text-end  fs-16" id="cart-total" placeholder="$0.00" wire:model="subtotal" readonly />
                                </div>
                                


                            </div>

                            <!--end col-->
                        </div>
                        <!--end row-->
                        <div class="hstack gap-2 justify-content-end d-print-none mt-4">
                            <button type="submit" class="btn btn-success"><i class="ri-printer-line align-bottom me-1"></i> Save</button>
                            <a href="javascript:void(0);" class="btn btn-primary"><i class="ri-download-2-line align-bottom me-1"></i> Download Invoice</a>
                            <a href="javascript:void(0);" class="btn btn-danger"><i class="ri-send-plane-fill align-bottom me-1"></i> Send Invoice</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!--end col-->
    </div>
</div>
