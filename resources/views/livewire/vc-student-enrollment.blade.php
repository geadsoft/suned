<div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body checkout-tab">
                    <form autocomplete="off" wire:submit.prevent="{{ 'createData' }}">
                        @csrf
                        <div class="step-arrow-nav mt-n3 mx-n3 mb-3">

                            <ul class="nav nav-pills nav-justified custom-nav nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fs-15 p-3" id="pills-bill-info-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-bill-info" type="button" role="tab"
                                        aria-controls="pills-bill-info" aria-selected="false"><i
                                            class=" ri-open-source-line fs-16 p-2 bg-soft-primary text-primary rounded-circle align-middle me-2"></i>
                                            Student ID</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fs-15 p-3 active" id="pills-bill-student-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-bill-students" type="button" role="tab"
                                        aria-controls="pills-bill-students" aria-selected="true"><i
                                            class="ri-user-2-line fs-16 p-2 bg-soft-primary text-primary rounded-circle align-middle me-2"></i>
                                            Student</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fs-15 p-3" id="pills-bill-responsible-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-bill-responsible" type="button" role="tab"
                                        aria-controls="pills-bill-responsible" aria-selected="false"><i
                                            class="ri-bank-card-line fs-16 p-2 bg-soft-primary text-primary rounded-circle align-middle me-2"></i>
                                            Representative</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fs-15 p-3" id="pills-bill-family-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-bill-family" type="button" role="tab"
                                        aria-controls="pills-bill-family" aria-selected="false"><i
                                            class="ri-parent-fill fs-16 p-2 bg-soft-primary text-primary rounded-circle align-middle me-2"></i>
                                            Family Data</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fs-15 p-3" id="pills-bill-registration-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-bill-registration" type="button" role="tab"
                                        aria-controls="pills-bill-registration" aria-selected="false"><i
                                            class="ri-file-user-line fs-16 p-2 bg-soft-primary text-primary rounded-circle align-middle me-2"></i>
                                            Registration</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fs-15 p-3" id="pills-bill-finish-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-bill-finish" type="button" role="tab" aria-controls="pills-finish"
                                        aria-selected="false"><i
                                            class="ri-checkbox-circle-line fs-16 p-2 bg-soft-primary text-primary rounded-circle align-middle me-2"></i>Confirmation</button>
                                </li>
                            </ul>
                        </div>

                        <div class="tab-content">
                            <div class="tab-pane fade" id="pills-bill-info" role="tabpanel"
                                aria-labelledby="pills-bill-info-tab">
                                <div class="mb-3">
                                    <br>
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
                                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="WithoutinlineRadio1" wire:model="">
                                                    <label for="inlineRadioOptions" class="form-label">SI</label>
                                                </div>
                                                <div class="form-check form-check-inline fs-15 mt-2">
                                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="WithoutinlineRadio2" wire:model="">
                                                    <label for="inlineRadioOptions" class="form-label">NO</label>
                                                </div>
                                                <input type="number" class="form-control" placeholder="Enter your Numers" wire:model="search_nur">
                                                <a id="btnstudents" class ="input-group-text btn btn-soft-info" wire:click="searchPerson(1)"><i class="ri-search-line me-1"></i>Search</a>
                                            </div>
                                            <div class="input-group mb-3">
                                                <label for="" class="form-label fs-15 mt-2  me-5">NUI</label>
                                                
                                                <div class="form-check form-check-inline fs-15 mt-2">
                                                    <input class="form-check-input" type="radio" id="chkstudent" wire:model="chkoptnui" value="si">
                                                    <label for="inlineRadioOptions" class="form-label">SI</label>
                                                </div>
                                                <div class="form-check form-check-inline fs-15 mt-2">
                                                    <input class="form-check-input" type="radio" id="chkstudent" wire:model="chkoptnui" value="no">
                                                    <label for="inlineRadioOptions" class="form-label">NO</label>
                                                </div>
                                                <input type="number" class="form-control" placeholder="Enter your Numers" wire:model="search_nui">
                                                <a id="btnstudents" class ="input-group-text btn btn-soft-info" wire:click="searchPerson(2)"><i class="ri-search-line me-1"></i>Search</a>
                                            </div>
                                        </div>
                                       
                                    </div> 
                                    <div class="d-flex align-items-start gap-3 mt-3">
                                        <button type="button" class="btn btn-primary btn-label right ms-auto nexttab"
                                            data-nexttab="pills-bill-students" onclick="selecTab('pills-bill-students')"> <i
                                                class="ri-user-shared-line label-icon align-middle fs-16 ms-2"></i>Continue to Student</button>
                                    </div>
                                </div>
                                
                                

                            </div>
                            <!-- end tab pane -->

                            <div class="tab-pane fade show active" id="pills-bill-students" role="tabpanel"
                                aria-labelledby="pills-bill-address-tab">
                                <div>
                                    <br>
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
                                                    placeholder="Enter your Names" wire:model.defer="nombres" required {{$eControl}}>
                                                @error('nombres') <span class="error">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="txtapellidos" class="form-label">Surnames</label>
                                                <input type="text" class="form-control" id="txtapellidos"
                                                    placeholder="Enter your Surnames" wire:model.defer="apellidos" required {{$eControl}}>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="mb-3">
                                                <label for="cmbtipoident" class="form-label">Type of identification</label>
                                                <select class="form-select" data-choices data-choices-search-false id="cmbtipoident" wire:model.defer="tipoident" required {{$eControl}}>
                                                    <option value="C">Cédula</option>
                                                    <option value="P">Pasaporte</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="txtidentificacion" class="form-label">
                                                Identification</label>
                                                <input type="text" class="form-control" id="txtnui"
                                                    placeholder="Enter your firstname" wire:model.defer="identificacion" required {{$eControl}} wire:focusout='validaNui()'>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="cmbgenero" class="form-label">Gender</label>
                                                <select class="form-select" data-choices data-choices-search-false id="cmbgenero" wire:model.defer="genero" required {{$eControl}}>
                                                    <option value="M">Male</option>
                                                    <option value="F">Female</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="txtfechanace" class="form-label">Date of Birth</label>
                                                <input type="date" class="form-control" id="txtfechanace" wire:model.defer="fechanace" required {{$eControl}}> 
                                            </div>
                                        </div>
                                        <!--end col-->

                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="cmbnacionalidad" class="form-label">Nationality</label>
                                                <select class="form-select" data-choices data-choices-search-false id="cmbnacionalidad" wire:model.defer="nacionalidad" required {{$eControl}}>
                                                    <option value="">Select Nationality</option>
                                                    @foreach ($tblgenerals as $general)
                                                        @if ($general->superior == 7)
                                                        <option value="{{$general->id}}">{{$general->descripcion}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="txttelefono" class="form-label">Phone
                                                    Number</label>
                                                <input type="text" class="form-control" id="txttelefono"
                                                    placeholder="Enter your phone number" wire:model.defer="telefono" {{$eControl}}>
                                            </div>
                                        </div>
                                        
                                        <!--end col-->

                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="cmbetnia" class="form-label">Ethnic group</label>
                                                <select class="form-select data-choices data-choices-search-false" id="cmbetnia" wire:model.defer="etnia" {{$eControl}}>
                                                    <option value="NN">Selecione Grupo Etnico</option>
                                                    <option value="ME">Mestizo</option>
                                                    <option value="AF">Afroecuatoriano</option>
                                                    <option value="BL">Blanco</option>
                                                    <option value="MO">Montubio</option>
                                                    <option value="IN">Indigena</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!--<div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="cmbetnia" class="form-label">Do you have a disability?</label>
                                                <div class="form-control">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="WithoutinlineRadio1" value="option1" {{$eControl}}>
                                                        <label for="inlineRadioOptions" class="form-label">SI</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="WithoutinlineRadio2" value="option2" {{$eControl}}>
                                                        <label for="inlineRadioOptions" class="form-label">NO</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="txtdiscapacidad" class="form-label">Disability</label>
                                                <input type="email" class="form-control" id="txtdiscapacidad"
                                                    placeholder="Enter Disability" wire:model.defer="" {{$eControl}}>
                                            </div>
                                        </div>-->

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
                                                    placeholder="Enter your email" wire:model.defer="email" {{$eControl}}>
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
                                <div class="row" style="display:none">
                                    <div class="card-header">
                                        <h5 class="card-title flex-grow-1 mb-0 text-primary"><i
                                            class="mdi mdi-map-marker-radius-outline align-middle me-1 text-success"></i>
                                            Residence</h5>
                                    </div>
                                    <div class="card-body row">
                                        <div class="col-xl-3">
                                        </div> 
                                        <div class="col-xl-6">
                                            <div class="mb-3">
                                                <label class="label" for="txtdireccion">Address</label>
                                                <input type="text" class="form-control" id="txtdireccion"
                                                    placeholder="Enter your adress" {{$eControl}}>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-start gap-3 mt-4">
                                    <button type="button" class="btn btn-light btn-label previestab"
                                        data-previous="pills-bill-students-tab" onclick="backTab('pills-bill-students')"><i
                                            class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>Back Student ID</button>
                                    <button type="button" class="btn btn-primary btn-label right ms-auto nexttab"
                                        data-nexttab="pills-responsible-tab" onclick="selecTab('pills-bill-responsible')"><i
                                            class="ri-bank-card-line label-icon align-middle fs-16 ms-2"></i>Continue to Representative</button>
                                </div>    
                            </div>

                            <!-- end tab pane -->

                            <div class="tab-pane fade" id="pills-bill-responsible" role="tabpanel"
                                aria-labelledby="pills-bill-address-tab">
                                <div>
                                    <br>
                                    <h5 class="mb-1">Information of the Responsible</h5>
                                    <p class="text-muted mb-4">Please fill all information below</p>
                                </div>
                                
                                @livewire('vc-person-enrollment',['estudianteId' => $estudiante_id])

                                <div class="d-flex align-items-start gap-3 mt-4">
                                    <button type="button" class="btn btn-light btn-label previestab"
                                        data-previous="pills-bill-info-tab" onclick="backTab('pills-bill-students')"><i
                                            class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>Back Student</button>
                                    <button type="button" class="btn btn-primary btn-label right ms-auto nexttab"
                                        data-nexttab="pills-bill-registration-tab" onclick="selecTab('pills-bill-family')"><i
                                            class="ri-file-user-line label-icon align-middle fs-16 ms-2"></i>Continue to FamilyData</button>
                                </div>    
                            </div>
                            <!-- end tab pane -->

                            <div class="tab-pane fade" id="pills-bill-family" role="tabpanel" aria-labelledby="pills-bill-family-tab">
                                <div class="row">
                                    <div class="card-header">
                                        <h5 class="card-title flex-grow-1 mb-0 text-primary"><i
                                            class="mdi mdi-account-tie align-middle me-1 text-success"></i>
                                            Familiares</h5>
                                    </div>
                                </div>
                                <div class="card-body row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="pernombres" class="form-label">
                                            Names</label>
                                            <input type="text" class="form-control" id="familiarid" wire:model.defer="persona_id" style="display:none">
                                            <input type="text" class="form-control" id="nomfamiliar" placeholder="Enter your Names" wire:model.defer="familiar.nombres" {{$fControl}}>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="perapellidos" class="form-label">Surnames</label>
                                            <input type="text" class="form-control" id="apefamiliar" placeholder="Enter your Surnames" wire:model.defer="familiar.apellidos" {{$fControl}}>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="mb-3">
                                            <label for="pertipoident" class="form-label">Type of identification</label>
                                            <select class="form-select" data-choices data-choices-search-false id="tipfamiliar" wire:model.defer="familiar.tipoidentificacion" {{$fControl}}>
                                                <option value="C">Cédula</option>
                                                <option value="P">Pasaporte</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="perident" class="form-label">
                                            Identification</label>
                                            <input type="text" class="form-control" id="idefamiliar"
                                                placeholder="Enter your firstname" wire:model.defer="familiar.identificacion" {{$fControl}}>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="pergenero" class="form-label">Gender</label>
                                            <select class="form-select" data-choices data-choices-search-false id="genfamiliar" wire:model.defer="familiar.genero" {{$fControl}}>
                                                <option value="M">Male</option>
                                                <option value="F">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="pernacionalidad" class="form-label">Nationality</label>
                                            <select class="form-select" data-choices data-choices-search-false id="nacfamiliar" wire:model.defer="familiar.nacionalidad_id" {{$fControl}}>
                                                <option value="">Select Nationality</option>
                                                @foreach ($tblgenerals as $general)
                                                    <option value="{{$general->id}}">{{$general->descripcion}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="pertelefono" class="form-label">Phone
                                                Number</label>
                                            <input type="text" class="form-control" id="telfamiliar"
                                                placeholder="Enter your phone number" wire:model.defer="familiar.telefono" {{$fControl}}>
                                        </div>
                                    </div>                                   
                                    <!--end col-->

                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="perrelacion" class="form-label">Relation</label>
                                            <select class="form-select" data-choices data-choices-search-false id="relfamiliar" wire:model.defer="familiar.parentesco" {{$fControl}}>
                                                <option value="NN">Selecione Relacion</option>
                                                <option value="MA">Madre</option>
                                                <option value="PA">Padre</option>
                                                <option value="AP">Apoderado</option>
                                                <option value="OT">Otro</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-xxl-4">
                                            <div class="mb-3">
                                                <label for="peremail" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="emafamiliar"
                                                    placeholder="Enter Email" wire:model.defer="familiar.email" {{$fControl}}>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6">
                                            <div class="mb-3">
                                                <label for="perdireccion" class="form-label">Direction</label>
                                                <input type="text" class="form-control" id="dirfamiliar"
                                                    placeholder="Enter Direction" wire:model.defer="familiar.direccion" {{$fControl}}>
                                            </div>
                                        </div>
                                        <div class="col-xxl-1">
                                            <div class="mb-3 text-center">
                                                <label for="" class="form-label">-</label>
                                                <div class="flex-shrink-0">
                                                   <button type="button" wire:click="activeControl()" class="btn btn-soft-success" id="newfamily-btn"
                                                        data-bs-target=""><i class="ri-add-fill me-1"></i> New
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-1">
                                            <div class="mb-3 text-center">
                                                <label for="" class="form-label">-</label>
                                                <div class="flex-shrink-0">
                                                   <button type="button" wire:click="addFamiliar('A')" class="btn btn-soft-secondary" id="addfamily-btn"
                                                        data-bs-target="" {{$fControl}}><i class="ri-add-fill me-1"></i> Add
                                                    </button>
                                                    <button type="button" wire:click="addFamiliar('U')" class="btn btn-soft-secondary" id="editfamily-btn" style="display:none"
                                                        data-bs-target="" {{$fControl}}><i class="ri-add-fill me-1"></i> Update
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    

                                </div>
                                <div class="card-body row">
                                    <div class="table-responsive table-card mb-3">
                                        <table class="table align-middle table-nowrap mb-0" id="customerTable">
                                            <thead class="table-light">
                                                <tr>
                                                    <th scope="col">Identification</th>
                                                    <th scope="col">Surname</th>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Relation</th>
                                                    <th scope="col">Email</th>
                                                    <th scope="col">Telephone</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="newlink">

                                                @foreach ($familiares as $recno)  
                                                <tr>
                                                    <td>{{$recno['identificacion']}}</td>
                                                    <td>{{$recno['apellidos']}}</td>
                                                    <td>{{$recno['nombres']}}</td>
                                                    <td>{{$relacion[$recno['parentesco']]}}</td>
                                                    <td>{{$recno['email']}}</td>
                                                    <td>{{$recno['telefono']}}</td>
                                                    <td>
                                                        <ul class="list-inline hstack gap-2 mb-0">
                                                            <li class="list-inline-item edit" data-bs-toggle="tooltip"
                                                                data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                                                <a href="javascript:editFamiliar({{$recno['id']}},{{$recno['persona_id']}},'{{$recno['nombres']}}','{{$recno['apellidos']}}','{{$recno['tipoidentificacion']}}','{{$recno['identificacion']}}','{{$recno['genero']}}',{{$recno['nacionalidad_id']}},'{{$recno['telefono']}}','{{$recno['parentesco']}}','{{$recno['email']}}','{{$recno['direccion']}}')">
                                                                    <i class="ri-pencil-fill fs-16"></i>
                                                                </a>
                                                            </li>
                                                            
                                                            <li class="list-inline-item" data-bs-toggle="tooltip"
                                                                data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                                                <a class="text-danger d-inline-block remove-item-btn"
                                                                    data-bs-toggle="modal" href="">
                                                                    <i class="ri-delete-bin-5-fill fs-16"></i>
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
                                <div class="d-flex align-items-start gap-3 mt-4">
                                    <button type="button" class="btn btn-light btn-label previestab"
                                        data-previous="pills-bill-info-tab" onclick="backTab('pills-bill-responsible')"><i
                                            class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>Back Representative</button>
                                    <button type="button" class="btn btn-primary btn-label right ms-auto nexttab"
                                        data-nexttab="pills-bill-registration-tab" onclick="selecTab('pills-bill-registration')"><i
                                            class="ri-file-user-line label-icon align-middle fs-16 ms-2"></i>Continue to Registration</button>
                                </div>
                            </div>
                            
                            <div class="tab-pane fade" id="pills-bill-registration" role="tabpanel" aria-labelledby="pills-payment-tab">
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
                                                <input type="text" style="font-weight: bold;" class="form-control fs-16 bg-white border-0 text-center"  wire:model.defer="nombrecompleto" readonly>
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
                                                        <label for="cmbperiodo" class="form-label mt-2 me-5">Teaching Period</label>
                                                    </div>
                                                    <div class="mb-3">    
                                                        <label for="cmbmodalidad" class="form-label mt-2 me-5">Group</label>
                                                    </div>
                                                    <div class="mb-3">    
                                                        <label for="cmbnivel" class="form-label mt-2 me-5">Level</label>
                                                    </div>
                                                    <div class="mb-3">    
                                                        <label for="cmbgrado" class="form-label mt-2 me-5">Course</label>
                                                    </div>
                                                    <div class="mb-3">    
                                                        <label for="cmbseccion" class="form-label mt-2 me-5">Section</label>
                                                    </div>
                                                    <div class="mb-3">    
                                                        <label for="txtcomentario" class="form-label mt-2 me-5">Comentario</label>
                                                    </div>
                                                </div>
                                                <div class="col-xl-9">
                                                    <div class="mb-3"> 
                                                        <input type="date" class="form-control" id="fechaActual" data-provider="flatpickr" data-date-format="d-m-Y" data-time="true" wire:model.defer="fecha">
                                                    </div> 
                                                    @livewire('vc-selected-course')
                                                    <div class="mb-3">    
                                                        <textarea type="text" class="form-control" id="txtcomentario" placeholder="Enter your Comment" wire:model.defer="comentario" {{$eControl}}>
                                                        </textarea>
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
                                        data-previous="pills-bill-registration-tab" onclick="backTab('pills-bill-family')"><i
                                            class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>Back to Family Data</button>
                                    <button type="button" class="btn btn-primary btn-label right ms-auto nexttab"
                                        data-nexttab="pills-finish-tab" onclick="selecTab('pills-bill-finish')"><i
                                            class="ri-contacts-book-line label-icon align-middle fs-16 ms-2"></i>Complete Registration</button>
                                </div>
                            </div>
                            <!-- end tab pane -->

                            <!-- Confirmation -->
                            <div class="tab-pane fade" id="pills-bill-finish" role="tabpanel"
                                aria-labelledby="pills-finish-tab">
                                <div class="row justify-content-center">
                                    <div class="col-xxl-9">
                                        <div class="card" id="demo">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="card-header border-bottom-dashed p-4">
                                                        <div class="d-flex">
                                                            <div class="flex-grow-1">
                                                                <img src="{{ URL::asset('assets/images/American Schooll.png') }}" class="card-logo card-logo-dark" alt="logo dark" height="60">
                                                                <div class="mt-sm-5 mt-4">
                                                                    <h6 class="text-muted text-uppercase fw-semibold">Address</h6>
                                                                    <p class="text-muted mb-1" id="address-details">{{$sede->direccion_sede}}</p>
                                                                    <p class="text-muted mb-0" id="zip-code">Guayaquil-Ecuador</p>
                                                                </div>
                                                            </div>
                                                            <div class="flex-shrink-0 mt-sm-0 mt-3">
                                                                <h6><span class="text-muted fw-normal">Legal Registration No:</span><span id="legal-register-no">{{$sede->codigo}}</span></h6>
                                                                <h6><span class="text-muted fw-normal">Email:</span><span id="email">{{$sede->email_sede}}</span></h6>
                                                                <h6><span class="text-muted fw-normal">Website:</span>{{$sede->website}}
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
                                                                <h5 class="fs-14 mb-0"><span id="invoice-date">{{$fecha}}</span> <small class="text-muted" id="invoice-time"></small></h5>
                                                            </div>
                                                            <!--end col-->
                                                            <div class="col-lg-3 col-6">
                                                                <p class="text-muted mb-2 text-uppercase fw-semibold">full name</p>
                                                                <input class="bg-white border-0 fs-14 mb-0" id="infofullname" />
                                                            </div>
                                                            <!--end col-->
                                                            <div class="col-lg-3 col-6">
                                                                <p class="text-muted mb-2 text-uppercase fw-semibold">NUI</p>
                                                                <h5 class="fs-14 mb-0"><input class="bg-white border-0 fs-14 mb-0" id="infonui" /></h5>
                                                            </div>
                                                            <!--end col-->
                                                            <div class="col-lg-3 col-6">
                                                                <p class="text-muted mb-2 text-uppercase fw-semibold">NUR</p>
                                                                <h5 class="fs-14 mb-0"><span id="total-amount">{{$codigo}}</span></h5>
                                                            </div>
                                                            <!--end col-->
                                                        </div>
                                                        <div class="row g-3">
                                                            <div class="col-lg-3 col-6 mb-3">
                                                                <p class="text-muted mb-2 text-uppercase fw-semibold">Home Address</p>
                                                                <h5 class="fs-14 mb-0"><input class="bg-white border-0 fs-14 mb-0" id="infoaddress" /></h5>
                                                            </div>
                                                        </div>
                                                        <!--end row-->
                                                    </div>
                                                    <!--end card-body-->
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="card-body p-4">
                                                        <div class="row g-3">
                                                            <div class="col-6">
                                                                <h6 class="text-muted text-uppercase fw-semibold mb-3">Representative</h6>
                                                                <input type="text" class="bg-white border-0 fw-medium mb-2" id="infoname" disabled />
                                                                <p class="text-muted mb-1">
                                                                <input type="text" class="bg-white border-0" id="inforelacion" disabled /></p>
                                                                <p class="text-muted mb-1">
                                                                <input type="text" class="bg-white border-0" id="infodireccion" disabled /></p>
                                                                <p class="text-muted mb-1"><span>Phone: +</span><span>(593)
                                                                <input type="text" class="bg-white border-0" id="infotelefono" disabled /></span></p>
                                                            </div>
                                                            <!--end col-->
                                                            <div class="col-6">
                                                                <h6 class="text-muted text-uppercase fw-semibold mb-3">Section</h6>
                                                                <input type="text" class="bg-white border-0 fw-medium mb-2" id="infogrupo" disabled />
                                                                <p class="text-muted mb-1"><span>Nivel: 
                                                                    <input type="text" class="bg-white border-0" id="infonivel" disabled />
                                                                </span></p>                                                                
                                                                <input type="text" class="form-control bg-white border-0" id="infogrado" disabled />
                                                                <input type="text" class="form-control bg-white border-0" id="infocurso" disabled />
                                                                
                                                                
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
                                                            <a href="javascript:window.print()" class="btn btn-danger"><i class="ri-printer-line align-bottom me-1"></i> Print</a>
                                                            <!--<a href="javascript:void(0);" class="btn btn-primary"><i class="ri-download-2-line align-bottom me-1"></i> Download</a>-->
                                                            <button type="submit" class="btn btn-success"><i class="ri-printer-line align-bottom me-1"></i> Save Tuition</button>
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
    <div wire.ignore.self id="messageModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-confirm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mt-2 text-center">
                        
                        <!--<lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                            colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>-->
                        
                        <lord-icon
                            src="https://cdn.lordicon.com/dnmvmpfk.json"
                            trigger="loop"
                            colors="primary:#f7b84b,secondary:#f06548"
                            style="width:100px;height:100px">
                        </lord-icon>
                        <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                            <h4>Record not found</h4>
                            <p class="text-muted mx-4 mb-0">Verify the data entered.</p>
                        </div>
                    </div>
                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                        <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">OK</button>
                    </div>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

</div>
