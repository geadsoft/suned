<div>
    <div class="row">
        <div class="col-xxl-12">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs-custom rounded card-header-tabs card-header-tabs border-bottom-0" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                                <i class="fas fa-home"></i>
                                Personal Details
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#changePassword" role="tab">
                                <i class="far fa-user"></i>
                                Family Data 
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#experience" role="tab">
                                <i class="far fa-envelope"></i>
                                Medical Data
                            </a>
                        </li>
                        <!--<li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#privacy" role="tab">
                                <i class="far fa-envelope"></i>
                                Privacy Policy
                            </a>
                        </li>-->
                    </ul>
                </div>
                <div class="card-body p-4" wire.ignore.self>
                    <div class="tab-content">
                        <div class="tab-pane active" id="personalDetails" role="tabpanel">
                            <form autocomplete="off" wire:submit.prevent="createData()">
                                <div class="row">
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
                                                    placeholder="Enter your firstname" wire:model.defer="identificacion" required {{$eControl}}>
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
                                                    placeholder="Enter your phone number" wire:model.defer="telefono" required {{$eControl}}>
                                            </div>
                                        </div>
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
                                        <div class="col-lg-4">
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
                                        </div>                                
                                </div>
                                    <div class="card">
                                        <div class="mb-3">
                                            
                                        </div>
                                        <div class="card-header">
                                            <ul class="nav nav-tabs-custom card-header-tabs border-bottom-0" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-bs-toggle="tab" href="#add-direction"
                                                        role="tab">
                                                        Domicilio
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="card-body">

                                            
                                            <div class="tab-pane active" id="#add-direction" role="tabpanel">
                                                <div class="row mb-3">
                                                    <div class="mb-3 col-lg-4">
                                                        <input type="text" class="form-control" wire:model.defer="direction.direccion">
                                                    </div>
                                                    <div class="mb-3 col-sm-1">
                                                        <select class="form-select" data-choices data-choices-search-false id="cmbdomingo" wire:model.defer="direction.domingo">
                                                            <option value=0>Libre</option>
                                                            <option value=1>Va</option>
                                                            <option value=2>Viene</option>
                                                            <option value=3>Va / Viene</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-sm-1">
                                                        <select class="form-select" data-choices data-choices-search-false id="cmblunes" wire:model.defer="direction.lunes">
                                                            <option value=0>Libre</option>
                                                            <option value=1>Va</option>
                                                            <option value=2>Viene</option>
                                                            <option value=3>Va / Viene</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-sm-1">
                                                        <select class="form-select" data-choices data-choices-search-false id="cmbmartes" wire:model.defer="direction.martes">
                                                            <option value=0>Libre</option>
                                                            <option value=1>Va</option>
                                                            <option value=2>Viene</option>
                                                            <option value=3>Va / Viene</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-sm-1">
                                                        <select class="form-select" data-choices data-choices-search-false id="cmbmiercoles" wire:model.defer="direction.miercoles">
                                                            <option value=0>Libre</option>
                                                            <option value=1>Va</option>
                                                            <option value=2>Viene</option>
                                                            <option value=3>Va / Viene</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-sm-1">
                                                        <select class="form-select" data-choices data-choices-search-false id="cmbjueves" wire:model.defer="direction.jueves">
                                                            <option value=0>Libre</option>
                                                            <option value=1>Va</option>
                                                            <option value=2>Viene</option>
                                                            <option value=3>Va / Viene</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-sm-1">
                                                        <select class="form-select" data-choices data-choices-search-false id="cmbviernes" wire:model.defer="viernes">
                                                            <option value=0>Libre</option>
                                                            <option value=1>Va</option>
                                                            <option value=2>Viene</option>
                                                            <option value=3>Va / Viene</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-sm-1">
                                                        <select class="form-select" data-choices data-choices-search-false id="cmbsabado" wire:model.defer="direction.sabado">
                                                            <option value=0>Libre</option>
                                                            <option value=1>Va</option>
                                                            <option value=2>Viene</option>
                                                            <option value=3>Va / Viene</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-sm-1">
                                                        <button type="button" wire:click="addDirections()" class="btn btn-soft-secondary" id="create-btn"
                                                            data-bs-target=""><i class="ri-add-fill me-1"></i> Agregar
                                                            </button>
                                                    </div>
                                                </div>
                                                <div class="table-responsive table-card mb-3">
                                                    <table class="table align-middle table-nowrap mb-0" id="customerTable">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th scope="col" style="width: 500px;">Direction</th>
                                                                <th scope="col">Sunday</th>
                                                                <th scope="col">Monday</th>
                                                                <th scope="col">Tuesday</th>
                                                                <th scope="col">Wednesday</th>
                                                                <th scope="col">Thursday</th>
                                                                <th scope="col">Friday</th>
                                                                <th scope="col">Saturday</th>
                                                                <th scope="col">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="newlink">

                                                            @foreach ($directions as $record)  
                                                            <tr>
                                                                <td>{{$record['direccion']}}</td>
                                                                <td>{{$record['domingo']}}</td>
                                                                <td>{{$record['lunes']}}</td>
                                                                <td>{{$record['martes']}}</td>
                                                                <td>{{$record['miercoles']}}</td>
                                                                <td>{{$record['jueves']}}</td>
                                                                <td>{{$record['viernes']}}</td>
                                                                <td>{{$record['sabado']}}</td>
                                                                <td>
                                                                    <!--<ul class="list-inline hstack gap-2 mb-0">
                                                                        <li class="list-inline-item edit" data-bs-toggle="tooltip"
                                                                            data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                                                            <a href="" wire:click.prevent="edit()">
                                                                                <i class="ri-pencil-fill fs-16"></i>
                                                                            </a>
                                                                        </li>
                                                                        <li class="list-inline-item" data-bs-toggle="tooltip"
                                                                            data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                                                            <a class="text-danger d-inline-block remove-item-btn"
                                                                                data-bs-toggle="modal" href="" wire:click.prevent="delete()">
                                                                                <i class="ri-delete-bin-5-fill fs-16"></i>
                                                                            </a>
                                                                        </li>
                                                                    </ul>-->
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>    
                                                    </table>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        
                                    </div>
                                    
                                    <!--end col-->
                                    
                                    <div class="col-lg-12">
                                        <div class="hstack gap-2 justify-content-end">
                                            <button type="submit" class="btn btn-primary" wire:click="createData()">Save Record</button>
                                            <button type="button" class="btn btn-soft-success">Cancel</button>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </form>
                        </div>
                        <!--end tab-pane-->
                        
                        <div class="tab-pane" id="changePassword" role="tabpanel">
                            <!--<form action="javascript:void(0);">
                                <div class="row g-2">
                                    <div class="col-lg-4">
                                        <div>
                                            <label for="oldpasswordInput" class="form-label">Old
                                                Password*</label>
                                            <input type="password" class="form-control" id="oldpasswordInput"
                                                placeholder="Enter current password">
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-4">
                                        <div>
                                            <label for="newpasswordInput" class="form-label">New
                                                Password*</label>
                                            <input type="password" class="form-control" id="newpasswordInput"
                                                placeholder="Enter new password">
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-4">
                                        <div>
                                            <label for="confirmpasswordInput" class="form-label">Confirm
                                                Password*</label>
                                            <input type="password" class="form-control" id="confirmpasswordInput"
                                                placeholder="Confirm password">
                                        </div>
                                    </div>
                                   
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <a href="javascript:void(0);"
                                                class="link-primary text-decoration-underline">Forgot
                                                Password ?</a>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-12">
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-success">Change
                                                Password</button>
                                        </div>
                                    </div>
                                    
                                </div>
                               
                            </form>-->
                            <!--<div class="mt-4 mb-3 border-bottom pb-2">
                                <div class="float-end">
                                    <a href="javascript:void(0);" class="link-primary">All Logout</a>
                                </div>
                                <h5 class="card-title">Login History</h5>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <div class="flex-shrink-0 avatar-sm">
                                    <div class="avatar-title bg-light text-primary rounded-3 fs-18">
                                        <i class="ri-smartphone-line"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6>iPhone 12 Pro</h6>
                                    <p class="text-muted mb-0">Los Angeles, United States - March 16 at
                                        2:47PM</p>
                                </div>
                                <div>
                                    <a href="javascript:void(0);">Logout</a>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <div class="flex-shrink-0 avatar-sm">
                                    <div class="avatar-title bg-light text-primary rounded-3 fs-18">
                                        <i class="ri-tablet-line"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6>Apple iPad Pro</h6>
                                    <p class="text-muted mb-0">Washington, United States - November 06
                                        at 10:43AM</p>
                                </div>
                                <div>
                                    <a href="javascript:void(0);">Logout</a>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <div class="flex-shrink-0 avatar-sm">
                                    <div class="avatar-title bg-light text-primary rounded-3 fs-18">
                                        <i class="ri-smartphone-line"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6>Galaxy S21 Ultra 5G</h6>
                                    <p class="text-muted mb-0">Conneticut, United States - June 12 at
                                        3:24PM</p>
                                </div>
                                <div>
                                    <a href="javascript:void(0);">Logout</a>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 avatar-sm">
                                    <div class="avatar-title bg-light text-primary rounded-3 fs-18">
                                        <i class="ri-macbook-line"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6>Dell Inspiron 14</h6>
                                    <p class="text-muted mb-0">Phoenix, United States - July 26 at
                                        8:10AM</p>
                                </div>
                                <div>
                                    <a href="javascript:void(0);">Logout</a>
                                </div>
                            </div>-->
                        </div>
                        <!--end tab-pane-->
                        <div class="tab-pane" id="experience" role="tabpanel">
                            <!--<form>
                                <div id="newlink">
                                    <div id="1">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <label for="jobTitle" class="form-label">Job
                                                        Title</label>
                                                    <input type="text" class="form-control" id="jobTitle"
                                                        placeholder="Job title" value="Lead Designer / Developer">
                                                </div>
                                            </div>
                                            
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="companyName" class="form-label">Company
                                                        Name</label>
                                                    <input type="text" class="form-control" id="companyName"
                                                        placeholder="Company name" value="Themesbrand">
                                                </div>
                                            </div>
                                            
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="experienceYear" class="form-label">Experience
                                                        Years</label>
                                                    <div class="row">
                                                        <div class="col-lg-5">
                                                            <select class="form-control" data-choices
                                                                data-choices-search-false name="experienceYear"
                                                                id="experienceYear">
                                                                <option value="">Select years</option>
                                                                <option value="Choice 1">2001</option>
                                                                <option value="Choice 2">2002</option>
                                                                <option value="Choice 3">2003</option>
                                                                <option value="Choice 4">2004</option>
                                                                <option value="Choice 5">2005</option>
                                                                <option value="Choice 6">2006</option>
                                                                <option value="Choice 7">2007</option>
                                                                <option value="Choice 8">2008</option>
                                                                <option value="Choice 9">2009</option>
                                                                <option value="Choice 10">2010</option>
                                                                <option value="Choice 11">2011</option>
                                                                <option value="Choice 12">2012</option>
                                                                <option value="Choice 13">2013</option>
                                                                <option value="Choice 14">2014</option>
                                                                <option value="Choice 15">2015</option>
                                                                <option value="Choice 16">2016</option>
                                                                <option value="Choice 17" selected>2017
                                                                </option>
                                                                <option value="Choice 18">2018</option>
                                                                <option value="Choice 19">2019</option>
                                                                <option value="Choice 20">2020</option>
                                                                <option value="Choice 21">2021</option>
                                                                <option value="Choice 22">2022</option>
                                                            </select>
                                                        </div>
                                                        
                                                        <div class="col-auto align-self-center">
                                                            to
                                                        </div>
                                                        
                                                        <div class="col-lg-5">
                                                            <select class="form-control" data-choices
                                                                data-choices-search-false name="choices-single-default2">
                                                                <option value="">Select years</option>
                                                                <option value="Choice 1">2001</option>
                                                                <option value="Choice 2">2002</option>
                                                                <option value="Choice 3">2003</option>
                                                                <option value="Choice 4">2004</option>
                                                                <option value="Choice 5">2005</option>
                                                                <option value="Choice 6">2006</option>
                                                                <option value="Choice 7">2007</option>
                                                                <option value="Choice 8">2008</option>
                                                                <option value="Choice 9">2009</option>
                                                                <option value="Choice 10">2010</option>
                                                                <option value="Choice 11">2011</option>
                                                                <option value="Choice 12">2012</option>
                                                                <option value="Choice 13">2013</option>
                                                                <option value="Choice 14">2014</option>
                                                                <option value="Choice 15">2015</option>
                                                                <option value="Choice 16">2016</option>
                                                                <option value="Choice 17">2017</option>
                                                                <option value="Choice 18">2018</option>
                                                                <option value="Choice 19">2019</option>
                                                                <option value="Choice 20" selected>2020
                                                                </option>
                                                                <option value="Choice 21">2021</option>
                                                                <option value="Choice 22">2022</option>
                                                            </select>
                                                        </div>
                                                        
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <label for="jobDescription" class="form-label">Job
                                                        Description</label>
                                                    <textarea class="form-control" id="jobDescription" rows="3"
                                                        placeholder="Enter description">You always want to make sure that your fonts work well together and try to limit the number of fonts you use to three or less. Experiment and play around with the fonts that you already have in the software you're working with reputable font websites. </textarea>
                                                </div>
                                            </div>
                                            
                                            <div class="hstack gap-2 justify-content-end">
                                                <a class="btn btn-success" href="javascript:deleteEl(1)">Delete</a>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div id="newForm" style="display: none;">

                                </div>
                                <div class="col-lg-12">
                                    <div class="hstack gap-2">
                                        <button type="submit" class="btn btn-success">Update</button>
                                        <a href="javascript:new_link()" class="btn btn-primary">Add
                                            New</a>
                                    </div>
                                </div>
                                
                            </form>-->
                        </div>
                        <!--end tab-pane-->
                        
                    </div>
                </div>
            </div>
        </div>
        <!--end col-->
    </div>
    <!--end row-->
</div>
