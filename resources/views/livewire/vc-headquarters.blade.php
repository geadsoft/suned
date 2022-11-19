<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <div class="flex-grow-1">
                             @if($existsrecord)
                                <button wire:click.prevent="edit()" class="btn btn-info add-btn" data-bs-toggle="modal" data-bs-target="">
                                <i class="ri-add-fill me-1 align-bottom"></i> Edit Headquarters </button>
                            @else
                                 <button wire:click.prevent="add()" class="btn btn-info add-btn" data-bs-toggle="modal" data-bs-target="">
                                <i class="ri-add-fill me-1 align-bottom"></i> Add Headquarters </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form id="create-form" autocomplete="off" wire:submit.prevent="createData">
    <fieldset {{$formestado}}>
        <div class="row"> 
            <div class="col-lg-12">
                    <div class="card">
                    
                        <div class="card-header">
                            <ul class="nav nav-tabs-custom card-header-tabs border-bottom-0" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active fs-15" data-bs-toggle="tab" href="#general-info"
                                        role="tab">
                                        Campus
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link fs-15" data-bs-toggle="tab" href="#addservices"
                                        role="tab">
                                        Services
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link fs-15" data-bs-toggle="tab" href="#addsection"
                                        role="tab">
                                        Sections
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link fs-15" data-bs-toggle="tab" href="#addOtherData"
                                        role="tab">
                                        Other Data
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link fs-15" data-bs-toggle="tab" href="#addBilling"
                                        role="tab">
                                        Electronic Billing
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- end card header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="general-info" role="tabpanel">
                                    <div class="row">
                                    <div class="col-lg-8">

                                        <div class="row">
                                            <div class="col-lg-3 col-sm-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="txtcodigo">Código</label>
                                                    <input type="text" class="form-control text-primary" id="txtcodigo" placeholder="Enter the code" wire:model.defer="record.codigo" required>
                                                    
                                                </div>
                                            </div>
                                        </div>   
                                        <div class="mb-3">
                                            <label class="form-label" for="txtnombre">Name</label>
                                            <input type="text" class="form-control" id="txtnombre" placeholder="Enter the name" wire:model.defer="record.nombre" required>
                                            
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 col-sm-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="cmbdenomina">Denomination</label>
                                                    <select type="select" class="form-select" id="cmbdenomina" wire:model.defer="record.denominacion" required>
                                                        <option value="EEI">Centro de Educación Inicial</option>
                                                        <option value="EEB">Escuela de Educación Básica</option>
                                                        <option value="COB">Colegio de Bachillerato</option>
                                                        <option value="UNE">Unidad Educativa</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-sm-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="txtiniciactividad">Year start of activity</label>
                                                    <input type="number" class="form-control" id="txtiniciactividad" 
                                                    placeholder="Enter Year start of activity" wire:model.defer="record.inicia_actividad" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-sm-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="txttelefono">Phone</label>
                                                    <input type="number" class="form-control" id="txttelefono" 
                                                    placeholder="Enter phone number" wire:model.defer="record.telefono_sede" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 col-sm-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="txtemail">Email</label>
                                                    <input type="text" class="form-control" id="txtemail" 
                                                    placeholder="Enter Email" wire:model.defer="record.email_sede" required>
                                                    
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="txtweb">Site Web</label>
                                                    <input type="text" class="form-control" id="txtweb" placeholder="Enter Website" wire:model.defer="record.website" required>
                                                    
                                                </div>
                                            </div>
                                            <!-- end col -->
                                        </div>
                                        <!-- end row -->
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-4">
                                            <h5 class="fs-14 mb-1">Logo</h5>
                                            <div class="text-center">
                                                <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                                    <img src="@if (Auth::user()->avatar != '') {{ URL::asset('images/' . Auth::user()->avatar) }}@else{{ URL::asset('assets/images/users/avatar-1.jpg') }} @endif"
                                                        class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="user-profile-image">
                                                    <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                                        <input id="profile-img-file-input" type="file" class="profile-img-file-input">
                                                        <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                                            <span class="avatar-title rounded-circle bg-light text-body">
                                                                <i class="ri-camera-fill"></i>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="txtrepresentante">Representative</label>
                                            <input type="text" class="form-control" id="txtrepresentante" placeholder="Enter representative name" wire:model.defer="record.representante">
                                            
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="txtidentidad">Identity</label>
                                            <input type="number" class="form-control" id="txtidentidad" placeholder="Enter representative ID" wire:model.defer="record.identificacion">
                                            
                                        </div>

                                    </div>    
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5 class="form-label mb-0">Working day</h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-check form-check-secondary form-check-inline">
                                                        <input class="form-check-input" type="checkbox" id="chkfinsemana" wire:model.defer="record.fin_semana">
                                                        <label class="form-check-label" for="chkfinsemana">
                                                            Weekend
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-secondary form-check-inline">
                                                        <input class="form-check-input" type="checkbox" id="chkjornada" wire:model.defer="record.jornada_completa">
                                                        <label class="form-check-label" for="chkjornada">
                                                            Full-time
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-secondary form-check-inline">
                                                        <input class="form-check-input" type="checkbox" id="chkmatutino" wire:model.defer="record.matutino" checked>
                                                        <label class="form-check-label" for="chkmatutino">
                                                            Morning
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-secondary form-check-inline">
                                                        <input class="form-check-input" type="checkbox" id="chkvespertino" wire:model.defer="record.vespertino">
                                                        <label class="form-check-label" for="chkvespertino">
                                                            Afternoon
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-secondary form-check-inline">
                                                        <input class="form-check-input" type="checkbox" id="chknocturno" wire:model.defer="record.nocturno">
                                                        <label class="form-check-label" for="chknocturno">
                                                            Night
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                    <div class="card-header">
                                    <h5 class="card-title flex-grow-1 mb-0 text-primary"><i
                                            class="mdi mdi-map-marker-radius-outline align-middle me-1 text-success"></i>
                                            Residence</h5>
                                    </div>
                                    <div class="card-body row">
                                        <div class="col-xl-3">
                                        </div> 
                                        <div class="col-xl-6">

                                            <!-- Componente Selected Zonas -->
                                            @livewire('vc-selected-zones', [
                                                'selectedProvincia' => $provinciaid,
                                                'selectedCanton' => $cantonid,
                                                'selectedParroquia' => $parroquiaid,
                                            ])  
                                            
                                            <div class="mb-3">
                                                <label class="label" for="txtdireccion">Address</label>
                                                <input type="text" class="form-control" id="txtdireccion" placeholder="Enter address of the instituto" wire:model.defer="record.direccion_sede" required>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <!-- end tab-pane -->

                                <div class="tab-pane" id="addproduct-metadata" role="tabpanel">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="meta-title-input">Meta title</label>
                                                <input type="text" class="form-control" placeholder="Enter meta title" id="meta-title-input">
                                            </div>
                                        </div>
                                        <!-- end col -->

                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="meta-keywords-input">Meta Keywords</label>
                                                <input type="text" class="form-control" placeholder="Enter meta keywords" id="meta-keywords-input">
                                            </div>
                                        </div>
                                        <!-- end col -->
                                    </div>
                                    <!-- end row -->

                                    <div>
                                        <label class="form-label" for="meta-description-input">Meta Description</label>
                                        <textarea class="form-control" id="meta-description-input" placeholder="Enter meta description" rows="3"></textarea>
                                    </div>
                                </div>
                                <!-- end tab pane -->

                                <div class="tab-pane" id="addBilling" role="tabpanel">
                                    <div class="mb-3">
                                    <div class="card-header">
                                    <h5 class="card-title flex-grow-1 mb-0 text-primary"><i
                                            class="align-middle me-1 text-success"></i>
                                            Configuración del Emisor</h5>
                                    </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">

                                            <div class="mb-3">
                                                <h5 class="fs-14 mb-1">Logo</h5>
                                                <div class="text-center">
                                                    <div class="profile-wid-bg profile-setting-img">
                                                        <img src="{{ URL::asset('assets/images/companies/American Schooll.jpeg') }}" class="profile-wid-img" alt="">
                                                        <div class="overlay-content">
                                                            <div class="text-end p-3">
                                                                <div class="p-0 ms-auto rounded-circle profile-photo-edit">
                                                                    <input id="profile-foreground-img-file-input" type="file" class="profile-foreground-img-file-input">
                                                                    <label for="profile-foreground-img-file-input" class="profile-photo-edit btn btn-light">
                                                                        <i class="ri-image-edit-line align-bottom me-1"></i> Change Cover
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3 col-lg-4">
                                                <label class="form-label" for="txtruc">RUC</label>
                                                <input type="number" class="form-control" id="txtruc" placeholder="Enter RUC" wire:model.defer="record.ruc" required>
                                                
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="txtrazonsocial">Razon Social</label>
                                                <input type="text" class="form-control" id="txtrazonsocial" placeholder="Enter Razon Social"  wire:model.defer="record.razon_social" required>
                                                
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="txtcomercial">Nombre Comercial</label>
                                                <input type="text" class="form-control" id="txtcomercial" placeholder="Enter Nombre Comercial"  wire:model.defer="record.nombre_comercial" required>
                                                
                                            </div>
                                            <div class="mb-3 row">
                                                <div class="col-lg-4">
                                                    <label class="form-label" for="txtphone">Phone</label>
                                                    <input type="number" class="form-control" id="txtphone" placeholder="Enter Phone"  wire:model.defer="record.telefono" required>
                                                    
                                                </div>
                                                <div class="col-lg-8">
                                                    <label class="form-label" for="txtemail">Email</label>
                                                    <input type="text" class="form-control" id="txtemail" placeholder="Enter Email"  wire:model.defer="record.email" required>
                                                    
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="txtdireccion">Main Address</label>
                                                <input type="text" class="form-control" id="txtdireccion" placeholder="Enter Main Address"  wire:model.defer="record.direccion" required>
                                                
                                            </div>
                                            
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="step-arrow-nav">
                                                <ul class="nav nav-pills  custom-nav" role="tablist">
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link fs-15 p-3 active" id="infotributaria-tab" data-bs-toggle="pill"
                                                            data-bs-target="#infotributaria" type="button" role="tab"
                                                            aria-controls="infotributaria" aria-selected="false"><i
                                                                class="ri-user-2-line fs-16 p-2 bg-soft-primary text-primary rounded-circle align-middle me-2"></i>
                                                                Informacion Tributaria</button>
                                                    </li>
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link fs-15 p-3" id="pills-establecimiento-tab" data-bs-toggle="pill"
                                                            data-bs-target="#pills-establecimiento" type="button" role="tab"
                                                            aria-controls="pills-establecimiento" aria-selected="false"><i
                                                                class="ri-bank-card-line fs-16 p-2 bg-soft-primary text-primary rounded-circle align-middle me-2"></i>
                                                                Establecimiento</button>
                                                    </li>
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link fs-15 p-3" id="pills-firma-tab" data-bs-toggle="pill"
                                                            data-bs-target="#pills-firma" type="button" role="tab"
                                                            aria-controls="pills-firma" aria-selected="false"><i
                                                                class="ri-file-user-line fs-16 p-2 bg-soft-primary text-primary rounded-circle align-middle me-2"></i>
                                                                Firma Electronica</button>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="tab-content">
                                                <div class="tab-pane fade show active" id="infotributaria" role="tabpanel"aria-labelledby="infotributaria-tab">
                                                    <div class="card-body">
                                                        <div class="form-check form-check-secondary sm-3 p-3">
                                                            <input class="form-check-input" type="checkbox" id="chkllevacontabilidad" wire:model.defer="record.lleva_contabilidad">
                                                            <label class="form-check-label" for="chkllevacontabilidad">
                                                                Obligado a llevar contabilidad
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-secondary sm-3 p-3">
                                                            <input class="form-check-input" type="checkbox" id="chkregimenrimpe" wire:model.defer="record.regimen_rimpe">
                                                            <label class="form-check-label" for="chkregimenrimpe">
                                                                Contribuyente Régimen RIMPE
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-secondary sm-3 p-3">
                                                            <input class="form-check-input" type="checkbox" id="chkcontribuyenteespecial" wire:model.defer="record.contribuyente_especial">
                                                            <label class="form-check-label" for="chkcontribuyenteespecial">
                                                                Contribuyente Especial
                                                            </label>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="txtresolucion_esp">Resolución No.</label>
                                                                    <input type="number" class="form-control" id="txtresolucion_esp" 
                                                                    placeholder="Enter Resolution Number" wire:model.defer="record.resolucion_ce">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-check form-check-secondary sm-3 p-3">
                                                            <input class="form-check-input" type="checkbox" id="chkagenteretencion" wire:model.defer="record.agente_retencion">
                                                            <label class="form-check-label" for="chkagenteretencion">
                                                                Agente de Retención
                                                            </label>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="txtagenteretencion">Resolución No.</label>
                                                                    <input type="number" class="form-control" id="txtagenteretencion" 
                                                                    placeholder="Enter Resolution Number" wire:model.defer="record.resolucion_ar">
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="pills-establecimiento" role="tabpanel"aria-labelledby="pills-establecimiento-tab">
                                                    <div class="row p-3">
                                                        <div class="col-lg-2">
                                                            <label class="form-label" for="txtestablecimiento">Establecimiento</label>
                                                            <input type="number" class="form-control" id="txtestablecimiento" placeholder="001" wire:model.defer="record.establecimiento" required>
                                                            
                                                        </div>
                                                        <div class="col-lg-10">
                                                            <label class="form-label" for="txtestabcomercial">Nombre Comercial</label>
                                                            <input type="text" class="form-control" id="txtestabcomercial" placeholder="Enter Trade Name" wire:model.defer="record.nombre_establecimiento" required>
                                                        </div>
                                                    </div>
                                                    <div class="row p-3">
                                                        <div class="col-lg-2">
                                                        </div>
                                                        <div class="col-lg-10">
                                                            <label class="form-label" for="txtestabdireccion">Dirección</label>
                                                            <input type="text" class="form-control" id="txtestabdireccion" placeholder="Enter Address" wire:model.defer="record.direccion_establecimiento" required>
                                                        </div>
                                                    </div>
                                                    <div class="row p-3">
                                                        <div class="col-lg-2">
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <label class="form-label" for="txtptoemision">Punto de Emisión</label>
                                                            <input type="number" class="form-control" id="txtptoemision" placeholder="001" wire:model.defer="record.punto_emision" required>
                                                        </div>
                                                        <div class="col-lg-6">
                                                        </div>
                                                    </div>
                                                    <div class="row p-3">
                                                        <div class="col-lg-2">
                                                        </div>
                                                        <div class="col-lg-4">
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <label class="form-label" for="txtdocumento">Nombre</label>
                                                                    <div class="mb-3">
                                                                        <input type="text" class="form-control" id="txtdocfactura" value= "Factura" disabled>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <input type="text" class="form-control" id="txtdocnotacredito" value= "Nota de Crédito" disabled>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <label class="form-label" for="txtcodigodoc">Código</label>
                                                                    <div class="mb-3">
                                                                        <input type="text" class="form-control" id="txtdocfe" placeholder="FE" disabled>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <input type="text" class="form-control" id="txtdocnce" placeholder="NCE" disabled>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <label class="form-label" for="txtsecuencia">Secuencia</label>
                                                                    <div class="mb-3">
                                                                        <input type="number" class="form-control" id="txtsec1" wire:model.defer="record.secuencia_factura" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <input type="number" class="form-control" id="txtsec2" wire:model.defer="record.secuencia_ncredito" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="pills-firma" role="tabpanel"aria-labelledby="pills-firma-tab">
                                                    <div class="mb-3 p-3">
                                                        <label class="form-label" for="txtfirma">Firma Electronica</label>
                                                        <input type="file" class="form-control" aria-label="file example" wire:model.defer="record.fe_archivo_firma">
                                                        
                                                    </div>
                                                    <div class="mb-3 p-3">
                                                        <label class="form-label" for="txtclave">Clave de la Firma</label>
                                                        <input type="text" class="form-control" id="txtclave" placeholder="Enter Clave de la Firma"
                                                        wire:model.defer="record.fe_clave_firma">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                </div>
                                <!-- end tab pane -->



                            </div>
                            <!-- end tab content -->
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->
                     
                    <div class="text-end mb-3 p-3">
                        <button type="submit" class="btn btn-primary" wire:click="createData()">Save Record</button>
                        <button type="button" class="btn btn-soft-success">Cancel</button>
                    </div>
            </div>
            <!-- end col -->

            <!--<div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Publish</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="choices-publish-status-input" class="form-label">Status</label>

                            <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false>
                                <option value="Published" selected>Published</option>
                                <option value="Scheduled">Scheduled</option>
                                <option value="Draft">Draft</option>
                            </select>
                        </div>

                        <div>
                            <label for="choices-publish-visibility-input" class="form-label">Visibility</label>
                            <select class="form-select" id="choices-publish-visibility-input" data-choices data-choices-search-false>
                                <option value="Public" selected>Public</option>
                                <option value="Hidden">Hidden</option>
                            </select>
                        </div>
                    </div>
                    
                </div>
                

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Publish Schedule</h5>
                    </div>
                   
                    <div class="card-body">
                        <div>
                            <label for="datepicker-publish-input" class="form-label">Publish Date & Time</label>
                            <input type="text" id="datepicker-publish-input" class="form-control"
                                placeholder="Enter publish date" data-provider="flatpickr" data-date-format="d.m.y"
                                data-enable-time>
                        </div>
                    </div>
                </div>
               

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Product Categories</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-2"> <a href="#" class="float-end text-decoration-underline">Add
                            New</a>Select product category</p>
                            <select class="form-select" id="choices-category-input" name="choices-category-input" data-choices data-choices-search-false>
                                <option value="Appliances">Appliances</option>
                                <option value="Automotive Accessories">Automotive Accessories</option>
                                <option value="Electronics">Electronics</option>
                                <option value="Fashion">Fashion</option>
                                <option value="Furniture">Furniture</option>
                                <option value="Grocery">Grocery</option>
                                <option value="Kids">Kids</option>
                                <option value="Watches">Watches</option>
                            </select>
                    </div>
                    
                </div>
                
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Product Tags</h5>
                    </div>
                    <div class="card-body">
                        <div class="hstack gap-3 align-items-start">
                            <div class="flex-grow-1">
                                <input class="form-control" data-choices data-choices-multiple-remove="true" placeholder="Enter tags" type="text"
                            value="Cotton" />
                            </div>
                        </div>
                    </div>
                    
                </div>
                

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Product Short Description</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-2">Add short description for product</p>
                        <textarea class="form-control" placeholder="Must enter minimum of a 100 characters" rows="3"></textarea>
                    </div>
                    
                </div>
                

            </div>-->
        </div>
        <!-- end row -->
    </form>
</div>
