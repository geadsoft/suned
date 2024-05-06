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
                                    <div class="col-lg-3 col-sm-6">
                                    </div>    
                                    <div class="col-lg-3 col-sm-6">
                                        <label for="cmbestab">Establecimiento</label>
                                        <select type="select" class="form-select bg-light border-0" id="cmbestab"  wire:model.defer="establecimiento" required>
                                            
                                                <option value="{{$tblsedes->establecimiento}}">{{$tblsedes->establecimiento}}</option>
                                        
                                        </select>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <label for="cmbptoemision">Punto de Emisión</label>
                                        <select type="select" class="form-select bg-light border-0" id="cmbptoemision" wire:model.defer="ptoemision" required>
                                        
                                                <option value="{{$tblsedes->punto_emision}}">{{$tblsedes->punto_emision}}</option>
                                        
                                        </select>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <label for="txtsecuencia">Secuencial</label>
                                        <input type="text" class="form-control bg-light border-0" id="invoicenoInput" placeholder="Invoice No"  wire:model.defer="documento" readonly="readonly" required/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--<div class="row">
                            <div class="col-lg-6 col-sm-6">
                            </div>
                            <div class="col-lg-2 col-sm-6">
                                <label for="cmbestab">Establecimiento</label>
                                <select type="select" class="form-select bg-light border-0" id="cmbestab"  wire:model.defer="establecimiento">
                                    
                                        <option value="{{$tblsedes->establecimiento}}">{{$tblsedes->establecimiento}}</option>
                                   
                                </select>
                            </div>
                            <div class="col-lg-2 col-sm-6">
                                <label for="cmbptoemision">Punto de Emisión</label>
                                <select type="select" class="form-select bg-light border-0" id="cmbptoemision" wire:model.defer="ptoemision">
                                   
                                        <option value="{{$tblsedes->punto_emision}}">{{$tblsedes->punto_emision}}</option>
                                   
                                </select>
                            </div>
                            <div class="col-lg-2 col-sm-6">
                                <label for="txtsecuencia">Invoice No</label>
                                <input type="text" class="form-control bg-light border-0" id="invoicenoInput" placeholder="Invoice No"  wire:model.defer="record.documento" readonly="readonly" />
                            </div>
                        </div>-->
                        <!--end row-->
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
                                        Please enter a tax number
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
        <!--end col-->
    </div>
    <div wire.ignore.self class="modal fade" id="showCliente" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" >
                <div class="modal-content modal-content border-0">
                    
                    <div class="modal-header p-3 bg-light">
                        <h5 class="modal-title" id="exampleModalLabel">
                            <span> Estudiante &nbsp;</span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                    </div>
                    
                    <form autocomplete="off" wire:submit.prevent="">
                        <div class="modal-body">                                        
                                @livewire('vc-modal-personas',['tipo' => 'R'])                                       
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
