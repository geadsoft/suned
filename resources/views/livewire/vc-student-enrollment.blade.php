<div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body checkout-tab">

                    <form action="#">
                        <div class="step-arrow-nav mt-n3 mx-n3 mb-3">

                            <ul class="nav nav-pills nav-justified custom-nav" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fs-15 p-3 active" id="pills-bill-info-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-bill-info" type="button" role="tab"
                                        aria-controls="pills-bill-info" aria-selected="true"><i
                                            class=" ri-open-source-line fs-16 p-2 bg-soft-primary text-primary rounded-circle align-middle me-2"></i>
                                            Student ID</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fs-15 p-3" id="pills-bill-student-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-bill-students" type="button" role="tab"
                                        aria-controls="pills-bill-students" aria-selected="false"><i
                                            class="ri-user-2-line fs-16 p-2 bg-soft-primary text-primary rounded-circle align-middle me-2"></i>
                                            Student</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fs-15 p-3" id="pills-responsible-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-responsible" type="button" role="tab"
                                        aria-controls="pills-responsible" aria-selected="false"><i
                                            class="ri-bank-card-line fs-16 p-2 bg-soft-primary text-primary rounded-circle align-middle me-2"></i>
                                            Representative</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fs-15 p-3" id="pills-bill-registration-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-registration" type="button" role="tab"
                                        aria-controls="pills-registration" aria-selected="false"><i
                                            class="ri-file-user-line fs-16 p-2 bg-soft-primary text-primary rounded-circle align-middle me-2"></i>
                                            Registration</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fs-15 p-3" id="pills-finish-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-finish" type="button" role="tab" aria-controls="pills-finish"
                                        aria-selected="false"><i
                                            class="ri-checkbox-circle-line fs-16 p-2 bg-soft-primary text-primary rounded-circle align-middle me-2"></i>Confirmation</button>
                                </li>
                            </ul>
                        </div>

                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="pills-bill-info" role="tabpanel"
                                aria-labelledby="pills-bill-info-tab">
                                <div>
                                    <h5 class="mb-1">Identification</h5>
                                    <p class="text-muted mb-4">Please fill all information below</p>
                                </div>

                                <div class="row">
                                    <div class="card-header">
                                        <h5 class="card-title flex-grow-1 mb-0 text-primary"><i
                                            class="mdi mdi-search-web align-middle me-1 text-success"></i>
                                            ¿Has identification?</h5>
                                    </div>
                                    <div class="card-body row">
                                        <div class="col-xl-3">
                                        </div> 
                                        <div class="col-xl-6">
                                            <div class="input-group mb-3">
                                                <label for="" class="form-label fs-15 mt-2  me-5">NUR</label>
                                                
                                                <div class="form-check form-check-inline fs-15 mt-2">
                                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="WithoutinlineRadio1" value="option1">
                                                    <label for="inlineRadioOptions" class="form-label">SI</label>
                                                </div>
                                                <div class="form-check form-check-inline fs-15 mt-2">
                                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="WithoutinlineRadio2" value="option2">
                                                    <label for="inlineRadioOptions" class="form-label">NO</label>
                                                </div>
                                                <input type="text" class="form-control" id="txtnombres" placeholder="Enter your Numers" wire:model.defer="">
                                                <button type="button" class="btn-soft-info btn-sm" data-bs-toggle="modal" id="create-btn"
                                                data-bs-target=""><i class="ri-search-line align-bottom me-1"></i> Search
                                                </button>
                                            </div>
                                            <div class="input-group mb-3">
                                                <label for="" class="form-label fs-15 mt-2  me-5">NUI</label>
                                                
                                                <div class="form-check form-check-inline fs-15 mt-2">
                                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="WithoutinlineRadio1" value="option1">
                                                    <label for="inlineRadioOptions" class="form-label">SI</label>
                                                </div>
                                                <div class="form-check form-check-inline fs-15 mt-2">
                                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="WithoutinlineRadio2" value="option2">
                                                    <label for="inlineRadioOptions" class="form-label">NO</label>
                                                </div>
                                                <input type="text" class="form-control" id="txtnombres" placeholder="Enter your Numers" wire:model.defer="">
                                                <button type="button" class="btn-soft-info btn-sm" data-bs-toggle="modal" id="create-btn"
                                                data-bs-target=""><i class="ri-search-line align-bottom me-1"></i> Search
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-xl-3">
                                        </div> 
                                    </div> 
                                    <div class="d-flex align-items-start gap-3 mt-3">
                                        <button type="button" class="btn btn-primary btn-label right ms-auto nexttab"
                                            data-nexttab="pills-bill-students"><i
                                                class="ri-user-shared-line label-icon align-middle fs-16 ms-2"></i>Continue to Student</button>
                                    </div>
                                </div>
                                
                                

                            </div>
                            <!-- end tab pane -->

                            <div class="tab-pane fade" id="pills-bill-students" role="tabpanel"
                                aria-labelledby="pills-bill-address-tab">
                                <div>
                                    <h5 class="mb-1">Students Information</h5>
                                    <p class="text-muted mb-4">Please fill all information below</p>
                                </div>
                                
                                <div class="row">
                                    <div class="card-header">
                                        <h5 class="card-title flex-grow-1 mb-0 text-primary"><i
                                            class="mdi mdi-account-tie align-middle me-1 text-success"></i>
                                            Personal Data</h5>
                                    </div>
                                    <div class="card-body row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="txtnombres" class="form-label">
                                                Names</label>
                                                <input type="text" class="form-control" id="txtnombres"
                                                    placeholder="Enter your Names" wire:model.defer="record.nombres" require>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="txtapellidos" class="form-label">Surnames</label>
                                                <input type="text" class="form-control" id="txtapellidos"
                                                    placeholder="Enter your Surnames" wire:model.defer="record.apellidos" require>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="mb-3">
                                                <label for="cmbtipoident" class="form-label">Type of identification</label>
                                                <select class="form-select" data-choices data-choices-search-false id="cmbtipoident" wire:model.defer="record.tipoidentificacion" require>
                                                    <option value="H">Cédula</option>
                                                    <option value="M">Pasaporte</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="txtidentificacion" class="form-label">
                                                Identification</label>
                                                <input type="text" class="form-control" id="txtidentificacion"
                                                    placeholder="Enter your firstname" wire:model.defer="record.identificacion" require>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="cmbgenero" class="form-label">Gender</label>
                                                <select class="form-select" data-choices data-choices-search-false id="cmbgenero" wire:model.defer="record.genero" require>
                                                    <option value="H">Male</option>
                                                    <option value="M">Female</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="txtfechanace" class="form-label">Date of Birth</label>
                                                <input type="date" class="form-control" id="txtfechanace" wire:model.defer="record.fechanacimiento" require> 
                                            </div>
                                        </div>
                                        <!--end col-->

                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="cmbnacionalidad" class="form-label">Nationality</label>
                                                <select class="form-select" data-choices data-choices-search-false id="cmbnacionalidad" wire:model.defer="record.nacionalidad" require>
                                                    <option value="1">Ecuatoriana</option>
                                                    <option value="2">Venezolana</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="txttelefono" class="form-label">Phone
                                                    Number</label>
                                                <input type="text" class="form-control" id="txttelefono"
                                                    placeholder="Enter your phone number" wire:model.defer="record.telefono">
                                            </div>
                                        </div>
                                        
                                        <!--end col-->

                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="cmbetnia" class="form-label">Ethnic group</label>
                                                <select class="form-select" data-choices data-choices-search-false id="cmbetnia" wire:model.defer="record.etnia">
                                                    <option value="NN">Selecione Grupo Etnico</option>
                                                    <option value="ME">Mestizo</option>
                                                    <option value="AF">Afroecuatoriano</option>
                                                    <option value="BL">Blanco</option>
                                                    <option value="MO">Montubio</option>
                                                    <option value="IN">Indigena</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="cmbetnia" class="form-label">Do you have a disability?</label>
                                                <div class="form-control">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="WithoutinlineRadio1" value="option1">
                                                        <label for="inlineRadioOptions" class="form-label">SI</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="WithoutinlineRadio2" value="option2">
                                                        <label for="inlineRadioOptions" class="form-label">NO</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="txtdiscapacidad" class="form-label">Disability</label>
                                                <input type="email" class="form-control" id="txtdiscapacidad"
                                                    placeholder="Enter your email" wire:model.defer="">
                                            </div>
                                        </div>

                                    </div>    

                                </div>
                                <div class="row">
                                    <div class="card-header">
                                        <h5 class="card-title flex-grow-1 mb-0 text-primary"><i
                                            class="mdi mdi-phone-sync align-middle me-1 text-success"></i>
                                            Contact Details</h5>
                                    </div>
                                    <div class="card-body row">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="txtemail" class="form-label">Email
                                                    Address</label>
                                                <input type="email" class="form-control" id="txtemail"
                                                    placeholder="Enter your email" wire:model.defer="record.email">
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header">
                                                <div class="d-sm-flex align-items-center">
                                                    <h5 class="card-title flex-grow-1 mb-0">Phones</h5>
                                                    <div class="flex-shrink-0 mt-2 mt-sm-0">
                                                        <a href="#addPhoneModal"
                                                            class="btn btn-soft-info btn-sm mt-2 mt-sm-0"><i
                                                                class="ri-phone-fill align-bottom me-1"></i>Add Phones</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive table-card">
                                                    <table class="table table-nowrap align-middle table-borderless mb-0">
                                                        <thead class="table-light text-muted">
                                                            <tr>
                                                                <th scope="col">Referencia</th>
                                                                <th scope="col">Type</th>
                                                                <th scope="col">Phone</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Residencia-->
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
                                            <div class="input-group mb-3">
                                                <label class="input-group-text" for="inputGroupSelect01">Zone</label>
                                                <select class="form-select" id="inputGroupSelect01">
                                                    <option selected>Choose...</option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                </select>
                                            </div>
                                            <div class="input-group mb-3">
                                                <label class="input-group-text" for="inputGroupSelect01">Parish</label>
                                                <select class="form-select" id="inputGroupSelect01">
                                                    <option selected>Choose...</option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                </select>
                                            </div>
                                            <div class="input-group mb-3">
                                                <label class="input-group-text" for="inputGroupSelect01">Province</label>
                                                <select class="form-select" id="inputGroupSelect01">
                                                    <option selected>Choose...</option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                </select>
                                            </div>
                                            <div class="input-group mb-3">
                                                <label class="input-group-text" for="inputGroupSelect01">City</label>
                                                <select class="form-select" id="inputGroupSelect01">
                                                    <option selected>Choose...</option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="label" for="txtdireccion">Address</label>
                                                <input type="text" class="form-control" id="txtdireccion"
                                                    placeholder="Enter your adress" wire:model.defer="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-start gap-3 mt-4">
                                    <button type="button" class="btn btn-light btn-label previestab"
                                        data-previous="pills-bill-info-tab"><i
                                            class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>Back Student ID</button>
                                    <button type="button" class="btn btn-primary btn-label right ms-auto nexttab"
                                        data-nexttab="pills-payment-tab"><i
                                            class="ri-bank-card-line label-icon align-middle fs-16 ms-2"></i>Continue to Responsible Identification</button>
                                </div>    
                            </div>

                            <!-- end tab pane -->

                            <div class="tab-pane fade" id="pills-responsible" role="tabpanel"
                                aria-labelledby="pills-bill-address-tab">
                                <div>
                                    <h5 class="mb-1">Information of the Responsible</h5>
                                    <p class="text-muted mb-4">Please fill all information below</p>
                                </div>
                                
                                <div class="row">
                                    <div class="card-header">
                                        <h5 class="card-title flex-grow-1 mb-0 text-primary"><i
                                            class="mdi mdi-search-web align-middle me-1 text-success"></i>
                                            Identification</h5>
                                    </div>
                                    <div class="card-body row">
                                        <div class="col-xl-3">
                                        </div> 
                                        <div class="col-xl-6">
                                            <div class="input-group mb-3">
                                                <label for="" class="form-label fs-15 mt-2  me-5">NUI</label>
                                                
                                                <div class="form-check form-check-inline fs-15 mt-2">
                                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="WithoutinlineRadio1" value="option1">
                                                    <label for="inlineRadioOptions" class="form-label">SI</label>
                                                </div>
                                                <div class="form-check form-check-inline fs-15 mt-2">
                                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="WithoutinlineRadio2" value="option2">
                                                    <label for="inlineRadioOptions" class="form-label">NO</label>
                                                </div>
                                                <input type="text" class="form-control" id="txtnombres" placeholder="Enter your Numers" wire:model.defer="">
                                                <button type="button" class="btn-soft-info btn-sm" data-bs-toggle="modal" id="create-btn"
                                                data-bs-target=""><i class="ri-search-line align-bottom me-1"></i> Search
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-xl-3">
                                        </div> 
                                    </div> 

                                    <div class="card-header">
                                        <h5 class="card-title flex-grow-1 mb-0 text-primary"><i
                                            class="mdi mdi-account-tie align-middle me-1 text-success"></i>
                                            Personal Data</h5>
                                    </div>
                                    <div class="card-body row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="txtnombres" class="form-label">
                                                Names</label>
                                                <input type="text" class="form-control" id="txtnombres"
                                                    placeholder="Enter your Names" wire:model.defer="record.nombres" require>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="txtapellidos" class="form-label">Surnames</label>
                                                <input type="text" class="form-control" id="txtapellidos"
                                                    placeholder="Enter your Surnames" wire:model.defer="record.apellidos" require>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="mb-3">
                                                <label for="cmbtipoident" class="form-label">Type of identification</label>
                                                <select class="form-select" data-choices data-choices-search-false id="cmbtipoident" wire:model.defer="record.tipoidentificacion" require>
                                                    <option value="H">Cédula</option>
                                                    <option value="M">Pasaporte</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="txtidentificacion" class="form-label">
                                                Identification</label>
                                                <input type="text" class="form-control" id="txtidentificacion"
                                                    placeholder="Enter your firstname" wire:model.defer="record.identificacion" require>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="cmbgenero" class="form-label">Gender</label>
                                                <select class="form-select" data-choices data-choices-search-false id="cmbgenero" wire:model.defer="record.genero" require>
                                                    <option value="H">Male</option>
                                                    <option value="M">Female</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="txtfechanace" class="form-label">Date of Birth</label>
                                                <input type="date" class="form-control" id="txtfechanace" wire:model.defer="record.fechanacimiento" require> 
                                            </div>
                                        </div>
                                        <!--end col-->

                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="cmbnacionalidad" class="form-label">Nationality</label>
                                                <select class="form-select" data-choices data-choices-search-false id="cmbnacionalidad" wire:model.defer="record.nacionalidad" require>
                                                    <option value="1">Ecuatoriana</option>
                                                    <option value="2">Venezolana</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="txttelefono" class="form-label">Phone
                                                    Number</label>
                                                <input type="text" class="form-control" id="txttelefono"
                                                    placeholder="Enter your phone number" wire:model.defer="record.telefono">
                                            </div>
                                        </div>
                                        
                                        <!--end col-->

                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="cmbetnia" class="form-label">Ethnic group</label>
                                                <select class="form-select" data-choices data-choices-search-false id="cmbetnia" wire:model.defer="record.etnia">
                                                    <option value="NN">Selecione Grupo Etnico</option>
                                                    <option value="ME">Mestizo</option>
                                                    <option value="AF">Afroecuatoriano</option>
                                                    <option value="BL">Blanco</option>
                                                    <option value="MO">Montubio</option>
                                                    <option value="IN">Indigena</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="cmbetnia" class="form-label">Do you have a disability?</label>
                                                <div class="form-control">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="WithoutinlineRadio1" value="option1">
                                                        <label for="inlineRadioOptions" class="form-label">SI</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="WithoutinlineRadio2" value="option2">
                                                        <label for="inlineRadioOptions" class="form-label">NO</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="txtdiscapacidad" class="form-label">Disability</label>
                                                <input type="email" class="form-control" id="txtdiscapacidad"
                                                    placeholder="Enter your email" wire:model.defer="">
                                            </div>
                                        </div>

                                    </div>    

                                </div>
                                <div class="row">
                                    <div class="card-header">
                                        <h5 class="card-title flex-grow-1 mb-0 text-primary"><i
                                            class="mdi mdi-phone-sync align-middle me-1 text-success"></i>
                                            Contact Details</h5>
                                    </div>
                                    <div class="card-body row">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="txtemail" class="form-label">Email
                                                    Address</label>
                                                <input type="email" class="form-control" id="txtemail"
                                                    placeholder="Enter your email" wire:model.defer="record.email">
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header">
                                                <div class="d-sm-flex align-items-center">
                                                    <h5 class="card-title flex-grow-1 mb-0">Phones</h5>
                                                    <div class="flex-shrink-0 mt-2 mt-sm-0">
                                                        <a href="#addPhoneModal"
                                                            class="btn btn-soft-info btn-sm mt-2 mt-sm-0"><i
                                                                class="ri-phone-fill align-bottom me-1"></i>Add Phones</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive table-card">
                                                    <table class="table table-nowrap align-middle table-borderless mb-0">
                                                        <thead class="table-light text-muted">
                                                            <tr>
                                                                <th scope="col">Referencia</th>
                                                                <th scope="col">Type</th>
                                                                <th scope="col">Phone</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Residencia-->
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
                                            <div class="input-group mb-3">
                                                <label class="input-group-text" for="cmbzone">Zone</label>
                                                <select class="form-select" id="cmbzone">
                                                    <option selected>Choose...</option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                </select>
                                            </div>
                                            <div class="input-group mb-3">
                                                <label class="input-group-text" for="cmbparish">Parish</label>
                                                <select class="form-select" id="cmbparish">
                                                    <option selected>Choose...</option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                </select>
                                            </div>
                                            <div class="input-group mb-3">
                                                <label class="input-group-text" for="cmbprovince">Province</label>
                                                <select class="form-select" id="cmbprovince">
                                                    <option selected>Choose...</option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                </select>
                                            </div>
                                            <div class="input-group mb-3">
                                                <label class="input-group-text" for="cmbcity">City</label>
                                                <select class="form-select" id="cmbcity">
                                                    <option selected>Choose...</option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="label" for="txtdireccion">Address</label>
                                                <input type="text" class="form-control" id="txtdireccion"
                                                    placeholder="Enter your adress" wire:model.defer="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Otros Datos-->
                                <div class="row">
                                    <div class="card-header">
                                    <h5 class="card-title flex-grow-1 mb-0 text-primary"><i
                                            class="mdi mdi-map-marker-radius-outline align-middle me-1 text-success"></i>
                                            Additional Data</h5>
                                    </div>
                                    <div class="card-body row">
                                        <div class="col-xl-3">
                                        </div> 
                                        <div class="col-xl-6">
                                            <div class="input-group mb-3">
                                                <label class="input-group-text" for="cmbzone">Profession or Trade</label>
                                                <select class="form-select" id="cmbzone">
                                                    <option selected>Choose...</option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                </select>
                                            </div>
                                            <div class="input-group mb-3">
                                                <label class="input-group-text" for="cmbparish">Schooling</label>
                                                <select class="form-select" id="cmbparish">
                                                    <option selected>Choose...</option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                </select>
                                            </div>
                                            <div class="input-group mb-3">
                                                <label class="input-group-text" for="cmbprovince">Occupation</label>
                                                <select class="form-select" id="cmbprovince">
                                                    <option selected>Choose...</option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-start gap-3 mt-4">
                                    <button type="button" class="btn btn-light btn-label previestab"
                                        data-previous="pills-bill-info-tab"><i
                                            class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>Back Student ID</button>
                                    <button type="button" class="btn btn-primary btn-label right ms-auto nexttab"
                                        data-nexttab="pills-payment-tab"><i
                                            class="ri-file-user-line label-icon align-middle fs-16 ms-2"></i>Continue to Responsible Identification</button>
                                </div>    
                            </div>
                            <!-- end tab pane -->
                            
                            <div class="tab-pane fade" id="pills-registration" role="tabpanel" aria-labelledby="pills-payment-tab">
                                <div class="row">
                                    <div class="card-header">
                                        <h5 class="card-title flex-grow-1 mb-0 text-primary"><i
                                            class="mdi mdi-account-check-outline align-middle me-1 text-success"></i>
                                            Student Data</h5>
                                    </div>
                                    <div class="card-body row">
                                        <div class="col-xl-3">
                                        </div> 
                                        <div class="col-xl-6 text-center">
                                            <div class="text-center">
                                                <label for="" class="form-label fs-15 mt-2 me-5">Nombre</label>
                                            </div>
                                        </div>
                                        <div class="col-xl-3">
                                        </div> 
                                    </div>
                                </div>    

                                <div class="row">
                                    <div class="card-header">
                                        <h5 class="card-title flex-grow-1 mb-0 text-primary"><i
                                            class="mdi mdi-archive-plus-outline align-middle me-1 text-success"></i>
                                            Login Data</h5>
                                    </div>
                                    <div class="card-body row">
                                        <div class="col-xl-3">
                                        </div> 
                                        <div class="col-xl-6">
                                            <div class="row mb-3">
                                                <div class="col-xl-3">
                                                    <div class="mb-3">
                                                        <label for="txtfecha" class="form-label mt-2 me-5">Fecha Registro</label>
                                                    </div>
                                                    <div class="mb-3">    
                                                        <label for="cmbnivel" class="form-label mt-2 me-5">Nivel</label>
                                                    </div>
                                                    <div class="mb-3">    
                                                        <label for="cmbmodalidad" class="form-label mt-2 me-5">Modalidad</label>
                                                    </div>
                                                    <div class="mb-3">    
                                                        <label for="cmbgrado" class="form-label mt-2 me-5">Grado</label>
                                                    </div>
                                                    <div class="mb-3">    
                                                        <label for="cmbperiodo" class="form-label mt-2 me-5">Periodo Lectivo</label>
                                                    </div>
                                                    <div class="mb-3">    
                                                        <label for="cmbseccion" class="form-label mt-2 me-5">Sección</label>
                                                    </div>
                                                </div>
                                                <div class="col-xl-9">
                                                    <div class="mb-3"> 
                                                        <input type="date" class="form-control" id="txtfecha"
                                                            placeholder="" wire:model.defer="">
                                                    </div> 
                                                    <div class="mb-3"> 
                                                        <select class="form-select" id="cmbnivel">
                                                            <option selected>Choose...</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3"> 
                                                        <select class="form-select" id="cmbmodalidad">
                                                            <option selected>Choose...</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3"> 
                                                        <select class="form-select" id="cmbgrado">
                                                            <option selected>Choose...</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3"> 
                                                        <select class="form-select" id="cmbperiodo">
                                                            <option selected>Choose...</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3"> 
                                                        <select class="form-select" id="cmbseccion">
                                                            <option selected>Choose...</option>
                                                        </select>
                                                    </div>       
                                                </div>
                                            </div>                                          
                                        </div>
                                        <div class="col-xl-3">
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex align-items-start gap-3 mt-4">
                                    <button type="button" class="btn btn-light btn-label previestab"
                                        data-previous="pills-bill-address-tab"><i
                                            class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>Back
                                        to Registration</button>
                                    <button type="button" class="btn btn-primary btn-label right ms-auto nexttab"
                                        data-nexttab="pills-finish-tab"><i
                                            class="ri-contacts-book-line label-icon align-middle fs-16 ms-2"></i>Complete Registration</button>
                                </div>
                            </div>
                            <!-- end tab pane -->

                            <!-- Confirmation -->
                            <div class="tab-pane fade" id="pills-finish" role="tabpanel"
                                aria-labelledby="pills-finish-tab">
                                <div class="row justify-content-center">
                                    <div class="col-xxl-9">
                                        <div class="card" id="demo">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="card-header border-bottom-dashed p-4">
                                                        <div class="d-flex">
                                                            <div class="flex-grow-1">
                                                                <img src="{{ URL::asset('assets/images/American-School.png') }}" class="card-logo card-logo-dark" alt="logo dark" height="60">
                                                                <img src="{{ URL::asset('assets/images/American-School.png') }}" class="card-logo card-logo-light" alt="logo light" height="17">
                                                                <div class="mt-sm-5 mt-4">
                                                                    <h6 class="text-muted text-uppercase fw-semibold">Address</h6>
                                                                    <p class="text-muted mb-1" id="address-details">Cdla. Vernaza Norte Mz. 21 Villa 2, 6, 7 y 8</p>
                                                                    <p class="text-muted mb-0" id="zip-code">Guayaquil-Ecuador</p>
                                                                </div>
                                                            </div>
                                                            <div class="flex-shrink-0 mt-sm-0 mt-3">
                                                                <h6><span class="text-muted fw-normal">Legal Registration No:</span><span id="legal-register-no">987654</span></h6>
                                                                <h6><span class="text-muted fw-normal">Email:</span><span id="email">secretaria@americanschool.edu.ec</span></h6>
                                                                <h6><span class="text-muted fw-normal">Website:</span> <a href="https://themesbrand.com/" class="link-primary" target="_blank" id="website">www.americanschool.edu.eC
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--end card-header-->
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-12">
                                                    <div class="card-body p-4">
                                                        <div class="row g-3 mb-3">
                                                            <div class="col-lg-3 col-6">
                                                                <p class="text-muted mb-2 text-uppercase fw-semibold">Date</p>
                                                                <h5 class="fs-14 mb-0"><span id="invoice-date">23 Nov, 2021</span> <small class="text-muted" id="invoice-time">02:36PM</small></h5>
                                                            </div>
                                                            <!--end col-->
                                                            <div class="col-lg-3 col-6">
                                                                <p class="text-muted mb-2 text-uppercase fw-semibold">full name</p>
                                                                <span class="fs-14 mb-0" id="payment-status">Juan Jose Vera Cortez</span>
                                                            </div>
                                                            <!--end col-->
                                                            <div class="col-lg-3 col-6">
                                                                <p class="text-muted mb-2 text-uppercase fw-semibold">NUI</p>
                                                                <h5 class="fs-14 mb-0"><span id="total-amount">0925027489</span></h5>
                                                            </div>
                                                            <!--end col-->
                                                            <div class="col-lg-3 col-6">
                                                                <p class="text-muted mb-2 text-uppercase fw-semibold">NUR</p>
                                                                <h5 class="fs-14 mb-0"><span id="total-amount">UEAS-00001</span></h5>
                                                            </div>
                                                            <!--end col-->
                                                        </div>
                                                        <div class="row g-3">
                                                            <div class="col-lg-3 col-6 mb-3">
                                                                <p class="text-muted mb-2 text-uppercase fw-semibold">Home Address</p>
                                                                <h5 class="fs-14 mb-0"><span id="invoice-date">Guayaquil, Mapasignue Este</span></h5>
                                                            </div>
                                                        </div>
                                                        <!--end row-->
                                                    </div>
                                                    <!--end card-body-->
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="card-body p-4 border-top border-top-dashed">
                                                        <div class="row g-3">
                                                            <div class="col-6">
                                                                <h6 class="text-muted text-uppercase fw-semibold mb-3">Representative</h6>
                                                                <p class="fw-medium mb-2" id="billing-name">David Nichols</p>
                                                                <p class="text-muted mb-1" id="billing-address-line-1">Madre</p>
                                                                <p class="text-muted mb-1" id="billing-address-line-1">305 S San Gabriel Blvd</p>
                                                                <p class="text-muted mb-1"><span>Phone: +</span><span id="billing-phone-no">(123)
                                                                        456-7890</span></p>
                                                                <p class="text-muted mb-0"><span>Tax: </span><span id="billing-tax-no">12-3456789</span> </p>
                                                            </div>
                                                            <!--end col-->
                                                            <div class="col-6">
                                                                <h6 class="text-muted text-uppercase fw-semibold mb-3">Section</h6>
                                                                <p class="fw-medium mb-2" id="shipping-name">Bachillerato</p>
                                                                <p class="text-muted mb-1"><span>Modalidad: </span><span id="shipping-phone-no">Presencial</span></p>
                                                                <p class="text-muted mb-1" id="billing-address-line-1">3ERO Bachillerato General Unificado</p>
                                                                <p class="text-muted mb-1"><span>Sección: </span><span id="shipping-phone-no">3ERO-A</span></p>
                                                            </div>
                                                            <!--end col-->
                                                        </div>
                                                        <!--end row-->
                                                    </div>
                                                    <!--end card-body-->
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="card-body p-4">
                                                        <div class="hstack gap-2 justify-content-end d-print-none mt-4">
                                                            <a href="javascript:window.print()" class="btn btn-success"><i class="ri-printer-line align-bottom me-1"></i> Print</a>
                                                            <a href="javascript:void(0);" class="btn btn-primary"><i class="ri-download-2-line align-bottom me-1"></i> Download</a>
                                                        </div>
                                                    </div>
                                                </div>        
                                                <!--end col-->
                                                </div>
                                            </div>
                                            <!--end row-->
                                        </div>
                                        <!--end card-->
                                    </div>
                                    <!--end col-->
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

    <!-- editItemModal -->
    <div id="addAddressModal" class="modal fade zoomIn" tabindex="-1" aria-labelledby="addAddressModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAddressModalLabel">Address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <div class="mb-3">
                            <label for="addaddress-Name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="addaddress-Name" placeholder="Enter name">
                        </div>

                        <div class="mb-3">
                            <label for="addaddress-textarea" class="form-label">Address</label>
                            <textarea class="form-control" id="addaddress-textarea" placeholder="Enter address" rows="2"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="addaddress-Name" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="addaddress-Name" placeholder="Enter phone no.">
                        </div>

                        <div class="mb-3">
                            <label for="state" class="form-label">Address Type</label>
                            <select class="form-select" id="state" data-choices data-choices-search-false>
                                <option value="homeAddress">Home (7am to 10pm)</option>
                                <option value="officeAddress">Office (11am to 7pm)</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success">Save</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
