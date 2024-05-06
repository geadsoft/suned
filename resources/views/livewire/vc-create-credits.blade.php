<div>
    <div class="row justify-content-center">
        <div class="col-xxl-10">
            <div class="card">
                <form autocomplete="off" wire:submit.prevent="{{ 'createData' }}" id="invoice_form">
                    <div class="card-body border-bottom border-bottom-dashed p-4">
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="profile-user mx-auto  mb-3">
                                    <input id="profile-img-file-input" type="file" class="profile-img-file-input" />
                                    <label for="profile-img-file-input" class="d-block" tabindex="0">
                                        <span class="overflow-hidden border border-dashed d-flex align-items-center justify-content-center rounded" style="height: 100px; width: 256px;">
                                            <img src="{{ URL::asset('assets/images/companies/Andres Fantoni.png') }}" class="card-logo card-logo-dark user-profile-image img-fluid" alt="logo dark">
                                        </span>
                                    </label>
                                    <div class="flex-shrink-0 mt-sm-0 mt-3">
                                        <h6 class="mb-0"><span class="text-muted fw-normal">Emisor:</span><span>{{$tblsedes->razon_social}}</span></h6>
                                        <h6 class="mb-0"><span class="text-muted fw-normal">Ruc:</span><span id="email">{{$tblsedes->ruc}}</span></h6>
                                        <h6 class="mb-0"><span class="text-muted fw-normal">Matriz:</span><span id="email">{{$tblsedes->direccion}}</span></h6>
                                        <h6 class="mb-0"><span class="text-muted fw-normal">Email:</span><span id="email">{{$tblsedes->email}}</span></h6>
                                        <h6 class="mb-0"><span class="text-muted fw-normal">Teléfono: </span><span id="contact-no"> +(593) {{$tblsedes->telefono}}</span></h6>
                                        <h6><span class="text-muted fw-normal">Website:</span> <a href="https://www.americanschool.edu.ec/" class="link-primary" target="_blank" id="website">{{$tblsedes->website}}</a></h6>
                                    </div>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-sm-7">
                                <div class="row">
                                    <div class="col-lg-3">
                                    </div>
                                    <div class="col-lg-9">
                                        <div class="table-responsive">
                                            <table class="invoice-table table table-borderless table-nowrap mb-0">
                                            <tbody>
                                                <tr>
                                                    <td colspan="3" class="text-center text-primary fs-14">
                                                    <strong>NOTA DE CRÉDITO</strong></td>
                                                <tr>
                                                <tr class="text-left">
                                                    <td><strong>Establecimiento</strong></td>
                                                    <td><strong>Punto Emision</strong></td>
                                                    <td style="width: 180px;"><strong>Secuencial</strong></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                    <select type="select" class="form-select bg-light border-0" id="cmbestab"  wire:model.defer="establecimiento" required>
                                                        <option value="{{$tblsedes->establecimiento}}">{{$tblsedes->establecimiento}}</option>
                                                    </select>
                                                    </td>
                                                    <td>
                                                    <select type="select" class="form-select bg-light border-0" id="cmbptoemision" wire:model.defer="ptoemision" required>
                                                    <option value="{{$tblsedes->punto_emision}}">{{$tblsedes->punto_emision}}</option>
                                                    </select>
                                                    </td>
                                                    <td>    
                                                    <input type="text" class="form-control bg-light border-0" id="invoicenoInput" placeholder="Invoice No"  wire:model.defer="documento" readonly="readonly" required/>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-lg-8 col-sm-6">
                                <label for="invoicenoInput">Cliente</label>
                                <div class="input-group bg-light border-0 mb-2">
                                    <input type="text" class="form-control bg-light border-0" name="identidad" id="billinginfo-firstName" placeholder="Cliente" wire:model="cliente" required readonly>
                                    <a id="btnstudents" class ="input-group-text btn btn-soft-secondary" wire:click="buscar()"><i class="ri-user-add-line me-1"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-6">
                                <label for="date-field">Fecha</label>
                                <input type="date" class="form-control bg-light border-0" id="fechaActual" data-provider="flatpickr" data-date-format="d-m-Y" data-time="true" wire:model.defer="fecha" required>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-lg-6 col-sm-6">    
                                <input type="text" class="form-control bg-light border-0" data-plugin="nui" id="nui" placeholder="Ruc" wire:model="ruc" readonly/>
                            </div>
                        </div>   
                        <!--end row-->
                    </div>
                    <div class="card-body p-4 border-top border-top-dashed">
                        <div class="row g-3">
                            <div class="col-lg-6 col-sm-6">
                                <div class="mb-2">
                                    <textarea class="form-control bg-light border-0" id="billingAddress" rows="3" placeholder="Dirección" wire:model="direccion" ></textarea>
                                    <div class="invalid-feedback">
                                        Dirección
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6">
                                <div class="mb-2">
                                    <input type="text" class="form-control bg-light border-0" data-plugin="cleave-phone" id="billingPhoneno" placeholder="+593-" wire:model="telefono" readonly/>
                                    <div class="invalid-feedback">
                                        Telefono
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <input type="text" class="form-control bg-light border-0" id="billingTaxno" placeholder="Email" wire:model="email" />
                                    <div class="invalid-feedback">
                                        Email
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-lg-6 col-sm-6">
                                <div class="mb-2 input-group">
                                <label for="date-field">Factura Aplica &nbsp;</label>
                                <input type="text" class="form-control bg-light border-0" id="billingTaxno" placeholder="Factura" wire:model="factura" readonly/>
                                </div>
                                <div class="mb-2 input-group">
                                    <label for="date-field">Fecha Factura &nbsp;</label>
                                    <input type="date" class="form-control bg-light border-0" id="fechaActual" data-provider="flatpickr" data-date-format="d-m-Y" data-time="true" wire:model.defer="fecha_factura" required readonly/>
                                    <div class="invalid-feedback">
                                        Fecha
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6">
                                
                                <div class="mb-3 input-group">
                                    <textarea class="form-control bg-light border-0" id="billingAddress" rows="2" placeholder="Motivo" wire:model="motivo" required></textarea>
                                    <div class="invalid-feedback">
                                        Motivo
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">

                        @livewire('vc-detail-credits',['facturaId' => $facturaId])

                        <div class="row mt-3">
                            <div class="col-lg-7">
                                <div class="mb-3 sm-3">
                                    <div class="card">
                                        <h5 class="card-title flex-grow-1 mb-0"><i
                                            class="align-middle me-1"></i>
                                            Información Adicional</h5>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-1">
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="mb-3">
                                            <label for="periodoinput" class="form-label">Estudiante</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="mb-3">
                                                <select type="select" class="form-select bg-light border-0" id="estudianteInput" wire:model="estudianteId" required>
                                                    <option value="">Seleccione Estudiante</option>
                                                    @foreach ($tblstudent as $recno) 
                                                        <option value="{{$recno->id}}">{{$recno->apellidos}} {{$recno->nombres}}</option>
                                                    @endforeach 
                                                </select>
                                            </div>
                                        </div> 
                                    </div>                                   
                                </div>
                                <div class="mb-3 sm-3">
                                    <div class="card">
                                        <h5 class="card-title flex-grow-1 mb-0"><i
                                            class="align-middle me-1"></i>
                                            Forma de Pago</h5>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-1"> 
                                    </div>
                                    <div class="col-sm-3"> 
                                        <label for="billinginfo-firstName" class="form-label">Forma de Pago</label>
                                    </div>
                                    <div class="col-sm-8">
                                    <select type="select" class="form-select bg-light border-0" id="selfpago-1" wire:model="formapago" required>
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
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-1"> 
                                    </div>
                                    <div class="col-sm-3">                                        
                                        <label for="billinginfo-firstName" class="form-label">Plazo</label>
                                    </div>
                                    <div class="col-sm-3">                                        
                                            <input class="form-control bg-light border-0 p-2" type="text" id="cardholderName" placeholder="Plazo" wire:model="dias" required>
                                    </div>
                                    <div class="col-sm-5">
                                        <select class="form-select bg-light border-0" data-choices data-choices-search-false id="choices-payment-status" wire:model="plazo" required>
                                            <option value="Dias">Dias</option>
                                            <option value="Semana">Semana</option>
                                            <option value="Meses">Meses</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-1"> 
                                    </div>
                                    <div class="col-sm-3">                                        
                                        <label for="billinginfo-firstName" class="form-label">Valor</label>
                                    </div>
                                    <div class="col-sm-8">
                                    <input type="number" class="form-control product-price bg-light border-0" id="productprice-1" step="0.01" placeholder="0.00" wire:model="montopago" required/>
                                    </div>
                                </div>  
                            </div>
                            <div class="col-lg-5">
                                <div class="input-group mb-1">
                                    <label for="cart-subtotal" class="form-label p-1">Subtotal sin Impuesto:</label>
                                    <input type="text" class="form-control bg-white border-0 text-end" id="cart-base0" placeholder="$0.00"  value="{{number_format($totales['subtotalsinImpto'],2)}}" readonly />
                                </div>
                                <div class="input-group mb-1">
                                    <label for="cart-descuento" class="form-label p-1">Subtotal IVA:</label>
                                    <input type="text" class="form-control bg-white border-0 text-end" id="cart-baseiva" placeholder="$0.00" value="{{number_format($totales['subtotalIVA'],2)}}" readonly />
                                </div>
                                <div class="input-group mb-1">
                                    <label for="cart-descuento" class="form-label p-1">Subtotal 0%:</label>
                                    <input type="text" class="form-control bg-white border-0 text-end" id="cart-baseiva0" placeholder="$0.00" value="{{number_format($totales['subtotal0'],2)}}" readonly />
                                </div>
                                <div class="input-group mb-1">
                                    <label for="cart-descuento" class="form-label p-1">Subtotal no Objeto IVA:</label>
                                    <input type="text" class="form-control bg-white border-0 text-end" id="cart-nosujeto" placeholder="$0.00" value="{{number_format($totales['subtotalIVA'],2)}}" readonly />
                                </div>
                                <div class="input-group mb-1">
                                    <label for="cart-descuento" class="form-label p-1">Subtotal Exento de IVA:</label>
                                    <input type="text" class="form-control bg-white border-0 text-end" id="cart-excento" placeholder="$0.00" value="{{number_format($totales['subtotalExcento'],2)}}" readonly />
                                </div>
                                <div class="input-group mb-1">
                                    <label for="cart-descuento" class="form-label p-1">Descuentos:</label>
                                    <input type="text" class="form-control bg-white border-0 text-end" id="cart-descuento" placeholder="$0.00" value="{{number_format($totales['descuentos'],2)}}" readonly />
                                </div>
                                <div class="input-group mb-1">
                                    <label for="cart-descuento" class="form-label p-1">IVA:</label>
                                    <input type="text" class="form-control bg-white border-0 text-end" id="cart-impuesto" placeholder="$0.00" value="{{number_format($totales['Iva'],2)}}" readonly />
                                </div>
                                <hr style="border-style:double">
                                <div class="input-group mb-1 fs-16">
                                    <label for="cart-descuento" class="form-label p-1">VALOR TOTAL:</label>
                                    <input type="text" class="form-control bg-white border-0 text-end  fs-16" id="cart-total" placeholder="$0.00" value="{{number_format($totales['valortotal'],2)}}" readonly />
                                </div>
                                
                            </div>

                            <!--end col-->
                        </div>
                        <!--end row-->
                        <div class="hstack gap-2 justify-content-end d-print-none mt-4">
                        
                            @if($facturaId==0)
                            <button type="submit" class="btn btn-success"><i class="mdi mdi-*-* mdi-content-save fs-16 me-1"></i> Grabar </button>
                            @endif
                            @if($facturaId>0)
                            <a href="/sri/create-invoice" class="btn btn-success"><i class="ri-file-line align-bottom me-1"></i> Nuevo</a>
                            <a href="" wire:click.prevent="enviaRIDE({{$facturaId}})" class="btn btn-danger"><i class="ri-send-plane-fill align-bottom me-1"></i> Firmar y Enviar</a>
                            <a href="/invoice/genera/{{$facturaId}}" class="btn btn-primary" target="_blank"><i class="mdi mdi-*-* mdi-printer fs-16 me-1"></i>Imprimir</a>
                            @endif
                         </div>
                    </div>
                </form>
            </div>
        </div>
        <!--end col-->
    </div>
    <div wire.ignore.self class="modal fade" id="showFacturas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" >
            <div class="modal-content modal-content border-0">
                
                <div class="modal-header p-3 bg-light">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <span> Razón Social &nbsp;</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                </div>
                
                <form autocomplete="off" wire:submit.prevent="">
                    <div class="modal-body">                                        
                            @livewire('vc-modal-facturas')                                       
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
