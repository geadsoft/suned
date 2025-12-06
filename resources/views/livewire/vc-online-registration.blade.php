<div>
    <div class="row justify-content-center">
        <div class="col-xxl-10">
            <div class="card">
                <form autocomplete="off" wire:submit.prevent="{{ 'createData' }}" id="invoice_form">
                    <div class="col-xl-12">
                        <div class="card overflow-hidden">
                            <div class="card-body bg-marketplace d-flex">
                                <div class="flex-grow-1">
                                    <h4 class="fs-18 lh-base mb-0">Inscripción de matricula <br> para el periodo lectivo <span class="text-success">2026-2027</span> </h4>
                                    <p class="mb-0 mt-2 pt-1 text-muted">Verifica que los datos en el formulario estén correctos y actualizados. Si necesitas actualizar alguna información, hazlo antes de enviar el formulario para ahorrar tiempo en tu proceso de matrícula</p>
                                </div>
                                <img src="assets/images/bg-d.png" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="card-header">
                            <h5 class="card-title flex-grow-1 mb-0 text-primary"><i
                                class="mdi mdi-account-tie align-middle me-1 text-success"></i>
                                Datos del Estudiante</h5>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <label for="invoicenoInput">Nombres</label>
                                <input type="text" class="form-control bg-light border-0" name="identidad" id="billinginfo-firstName" placeholder="Nombres" wire:model="persona.nombres">
                            </div>
                            <div class="col-lg-4">
                                <label for="invoicenoInput">Apellidos</label>
                                <input type="text" class="form-control bg-light border-0" name="identidad" id="billinginfo-firstName" placeholder="Apellidos" wire:model="persona.apellidos">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-2">
                                <label for="cmbtipoident" class="form-label">Documento</label>
                                <select class="form-select bg-light border-0" data-choices data-choices-search-false id="cmbtipoident" wire:model.defer="persona.tipoidentificacion">
                                    <option value="C">Cédula</option>
                                    <option value="P">Pasaporte</option>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label for="cmbtipoident" class="form-label">Identificación</label>
                                <input type="text" class="form-control bg-light border-0" id="txtnui" placeholder="Enter your firstname" wire:model.defer="persona.identificacion">
                            </div>
                            <div class="col-lg-2">
                                <label for="txtfechanace" class="form-label">Fecha Nacimiento</label>
                                <input type="date" class="form-control bg-light border-0" id="txtfechanace" wire:model.defer="persona.fechanacimiento"> 
                            </div>
                            <div class="col-lg-2">
                                <label for="genero" class="form-label">Genero</label>
                                <select class="form-select bg-light border-0" data-choices data-choices-search-false id="cmbgenero" wire:model.defer="persona.genero">
                                    <option value="M">Masculino</option>
                                    <option value="F">Femenino</option>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label for="cmbnacionalidad" class="form-label">Nacionalidad</label>
                                <select class="form-select bg-light border-0" data-choices data-choices-search-false id="cmbnacionalidad" wire:model.defer="persona.nacionalidad_id">
                                    <option value="">Seleccione Nacionalidad</option>
                                    @foreach ($tblgenerals as $general)
                                        @if ($general->superior == 7)
                                        <option value="{{$general->id}}">{{$general->descripcion}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>                                
                        </div>
                        <div class="row mb-3">
                            
                            <div class="col-lg-3">
                                <label for="cmbetnia" class="form-label">Etnia</label>
                                <select class="form-select bg-light border-0" id="cmbetnia" wire:model.defer="persona.etnia">
                                    <option value="NN">Selecione Grupo Etnico</option>
                                    <option value="ME">Mestizo</option>
                                    <option value="AF">Afroecuatoriano</option>
                                    <option value="BL">Blanco</option>
                                    <option value="MO">Montubio</option>
                                    <option value="IN">Indigena</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-header">
                            <h5 class="card-title flex-grow-1 mb-0 text-primary"><i
                                class="mdi mdi-account-tie align-middle me-1 text-success"></i>
                                Información Académica</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        
                            
                                <div class="card-body">
                                    
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="nav nav-pills flex-column nav-pills-tab custom-verti-nav-pills text-center" role="tablist" aria-orientation="vertical">
                                                <a class="nav-link active" id="custom-v-pills-home-tab" data-bs-toggle="pill" href="#custom-v-pills-home" role="tab" aria-controls="custom-v-pills-home" aria-selected="true" tabindex="-1">
                                                    <i class="las la-graduation-cap d-block fs-20 mb-1"></i> Matricula
                                                </a>
                                                <a class="nav-link" id="custom-v-pills-profile-tab" data-bs-toggle="pill" href="#custom-v-pills-profile" role="tab" aria-controls="custom-v-pills-profile" aria-selected="false" tabindex="-1">
                                                    <i class="ri-user-heart-line d-block fs-20 mb-1"></i> Representante
                                                </a>
                                                <a class="nav-link" id="custom-v-pills-messages-tab" data-bs-toggle="pill" href="#custom-v-pills-messages" role="tab" aria-controls="custom-v-pills-messages" aria-selected="false">
                                                    <i class="ri-group-line d-block fs-20 mb-1"></i> Familiares
                                                </a>
                                                <a class="nav-link" id="custom-v-pills-factura-tab" data-bs-toggle="pill" href="#custom-v-pills-factura" role="tab" aria-controls="custom-v-pills-messages" aria-selected="false">
                                                    <i class="ri-price-tag-3-line d-block fs-20 mb-1"></i> Facturación
                                                </a>
                                                <a class="nav-link" id="custom-v-pills-documento-tab" data-bs-toggle="pill" href="#custom-v-pills-documento" role="tab" aria-controls="custom-v-pills-messages" aria-selected="false">
                                                    <i class="ri-folder-open-line d-block fs-20 mb-1"></i> Documentación
                                                </a>
                                            </div>
                                        </div> <!-- end col-->
                                        <div class="col-lg-9">
                                            <div class="tab-content mt-3 mt-lg-0">
                                                <div class="tab-pane fade active show" id="custom-v-pills-home" role="tabpanel" aria-labelledby="custom-v-pills-home-tab">
                                                    <div class="d-flex">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-xl-2">
                                                                </div>
                                                                <div class="col-xl-8">
                                                                    <div class="row mb-3">
                                                                        <div class="col-lg-4 col-sm-4">
                                                                            <div data-bs-toggle="collapse" data-bs-target="#paymentmethodCollapse.show" aria-expanded="false" aria-controls="paymentmethodCollapse">
                                                                                <div class="form-check card-radio">
                                                                                    <input id="paymentMethod01" name="paymentMethod" type="radio" class="form-check-input" value="2" wire:model="modalidad" required>
                                                                                    <label class="form-check-label" for="paymentMethod01">
                                                                                        <span class="fs-16 text-muted me-2"><i class="ri-home-3-line align-bottom"></i></span>
                                                                                        <span class="fs-14 fw-bold">Presencial</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4 col-sm-4">
                                                                            <div data-bs-toggle="collapse" data-bs-target="#paymentmethodCollapse.show" aria-expanded="false" aria-controls="paymentmethodCollapse">
                                                                                <div class="form-check card-radio">
                                                                                    <input id="paymentMethod02" name="paymentMethod" type="radio" class="form-check-input" value="3" wire:model="modalidad" required>
                                                                                    <label class="form-check-label" for="paymentMethod02">
                                                                                        <span class="fs-16 text-muted me-2"><i class="ri-arrow-left-right-line align-bottom"></i></span>
                                                                                        <span class="fs-14 fw-bold">Distancia</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4 col-sm-4">
                                                                            <div data-bs-toggle="collapse" data-bs-target="#paymentmethodCollapse.show" aria-expanded="false" aria-controls="paymentmethodCollapse">
                                                                                <div class="form-check card-radio">
                                                                                    <input id="paymentMethod03" name="paymentMethod" type="radio" class="form-check-input" value="4" wire:model="modalidad" required>
                                                                                    <label class="form-check-label" for="paymentMethod03">
                                                                                        <span class="fs-16 text-muted me-2"><i class=" ri-video-chat-line align-bottom"></i></span>
                                                                                        <span class="fs-14 fw-bold">Virtual</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-2">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                            <div class="col-xl-3">
                                                            </div> 
                                                            <div class="col-xl-6">
                                                                <div class="row">
                                                                    <div class="col-xl-3">
                                                                        <div class="mb-3">    
                                                                            <label for="cmbperiodo" class="form-label mt-2 me-5">Periodo</label>
                                                                        </div>
                                                                        <div class="mb-3">    
                                                                            <label for="cmbperiodo" class="form-label mt-2 me-5">Nivel</label>
                                                                        </div>
                                                                        <div class="mb-3">    
                                                                            <label for="cmbperiodo" class="form-label mt-2 me-5">Curso</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-9">
                                                                        <div class="mb-3">    
                                                                            <select class="form-select bg-light border-0" data-choices data-choices-search-false id="pernacionalidad" wire:model.defer="matricula.periodo" require>
                                                                                <option value="0">Seleccione Periodo</option>
                                                                                @foreach ($periodos as $periodo)
                                                                                    <option value="{{$periodo->id}}">{{$periodo->descripcion}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <select class="form-select bg-light border-0" data-choices data-choices-search-false id="pernacionalidad" wire:model.defer="matricula.nivel" require>
                                                                                <option value="0">Seleccione Nivel</option>
                                                                                @foreach ($nivel as $rnivel)
                                                                                    <option value="{{$rnivel->id}}">{{$rnivel->descripcion}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <select class="form-select bg-light border-0" data-choices data-choices-search-false id="pernacionalidad" wire:model.defer="matricula.grado" require>
                                                                                <option value="0">Seleccione Curso</option>
                                                                                @foreach ($cursos as $rcurso)
                                                                                    <option value="{{$rcurso->servicio_id}}">{{$rcurso->servicio_descripcion}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-3">
                                                            </div> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end tab-pane-->
                                                <div class="tab-pane fade" id="custom-v-pills-profile" role="tabpanel" aria-labelledby="custom-v-pills-profile-tab">
                                                    <div class="d-flex">
                                                        <div class="card-body row">
                                                            <div class="col-xl-3">
                                                            </div>
                                                            <div class="col-xl-6">
                                                            <select class="form-select bg-light border-0" wire:model="search_nui" wire:change="loadPersonas('R')">
                                                                <option value="">Seleccione Representante</option>
                                                                @foreach ($tblfamilys as $family)
                                                                    <option value="{{$family->identificacion}}">{{$family->apellidos}} {{$family->nombres}}</option>
                                                                @endforeach
                                                            </select>
                                                             </div>
                                                            <div class="col-xl-3">

                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="d-flex">
                                                        <div class="card-body">
                                                            <div class="row mb-2 align-items-center">
                                                                <div class="col-xl-2"></div>

                                                                <!-- Label -->
                                                                <div class="col-xl-2">
                                                                    <label for="pernombres" class="form-label mb-0">Nombres</label>
                                                                </div>

                                                                <!-- Input -->
                                                                <div class="col-xl-6">
                                                                    <input type="text" class="form-control bg-light border-0" id="pernombres"
                                                                        placeholder="Enter your Names" wire:model.defer="personr.nombres" required>
                                                                </div>

                                                                <div class="col-xl-2"></div>
                                                            </div>

                                                            <div class="row mb-2 align-items-center">
                                                                <div class="col-xl-2"></div>

                                                                <div class="col-xl-2">
                                                                    <label for="perapellidos" class="form-label mb-0">Apellidos</label>
                                                                </div>

                                                                <div class="col-xl-6">
                                                                    <input type="text" class="form-control bg-light border-0" id="perapellidos"
                                                                        placeholder="Enter your Lastname" wire:model.defer="personr.apellidos" required>
                                                                </div>

                                                                <div class="col-xl-2"></div>
                                                            </div>

                                                            <div class="row mb-2 align-items-center">
                                                                <div class="col-xl-2"></div>

                                                                <div class="col-xl-2">
                                                                    <label for="perident" class="form-label mb-0">Identificación</label>
                                                                </div>

                                                                <div class="col-xl-6">
                                                                    <div class="row g-2">
                                                                        <div class="col-xl-5">
                                                                            <select class="form-select bg-light border-0" id="pertipoident" wire:model.defer="personr.tipoidentificacion" required>
                                                                                <option value="C">Cédula</option>
                                                                                <option value="R">Ruc</option>
                                                                                <option value="P">Pasaporte</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-xl-7">
                                                                            <input type="text" class="form-control bg-light border-0" id="perident"
                                                                                placeholder="Enter your identification" 
                                                                                wire:model.defer="personr.identificacion"
                                                                                required wire:focusout="validaNui()">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-xl-2"></div>
                                                            </div>
                                                            <div class="row mb-2 align-items-center">
                                                                <div class="col-xl-2"></div>

                                                                <!-- Label -->
                                                                <div class="col-xl-2">
                                                                    <label for="pernombres" class="form-label mb-0">Genero</label>
                                                                </div>

                                                                <!-- Input -->
                                                                <div class="col-xl-6">
                                                                    <select class="form-select bg-light border-0" data-choices data-choices-search-false id="pergenero" wire:model.defer="personr.genero" required>
                                                                        <option value="M">Masculino</option>
                                                                        <option value="F">Femenino</option>
                                                                    </select>
                                                                </div>

                                                                <div class="col-xl-2"></div>
                                                            </div>
                                                            <div class="row mb-2 align-items-center">
                                                                <div class="col-xl-2"></div>

                                                                <!-- Label -->
                                                                <div class="col-xl-2">
                                                                    <label for="pernombres" class="form-label mb-0">Nacionalidad</label>
                                                                </div>

                                                                <!-- Input -->
                                                                <div class="col-xl-6">
                                                                    <select class="form-select bg-light border-0" data-choices data-choices-search-false id="pernacionalidad" wire:model.defer="personr.nacionalidad_id" require>
                                                                        <option value="0">Select Nationality</option>
                                                                        @foreach ($tblgenerals as $general)
                                                                            <option value="{{$general->id}}">{{$general->descripcion}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="col-xl-2"></div>
                                                            </div>
                                                            <div class="row mb-2 align-items-center">
                                                                <div class="col-xl-2"></div>

                                                                <!-- Label -->
                                                                <div class="col-xl-2">
                                                                    <label for="pernombres" class="form-label mb-0">Parentesco</label>
                                                                </div>

                                                                <!-- Input -->
                                                                <div class="col-xl-6">
                                                                    <select class="form-select bg-light border-0" data-choices data-choices-search-false id="perrelacion" wire:model.defer="personr.parentesco" required>
                                                                        <option value="NN">Seleccione Parentesco</option>
                                                                        <option value="MA">Madre</option>
                                                                        <option value="PA">Padre</option>
                                                                        <option value="AP">Apoderado</option>
                                                                        <option value="OT">Otro</option>
                                                                    </select>
                                                                </div>

                                                                <div class="col-xl-2"></div>
                                                            </div>
                                                            <div class="row mb-2 align-items-center">
                                                                <div class="col-xl-2"></div>

                                                                <!-- Label -->
                                                                <div class="col-xl-2">
                                                                    <label for="pernombres" class="form-label mb-0">Dirección</label>
                                                                </div>

                                                                <!-- Input -->
                                                                <div class="col-xl-6">
                                                                    <input type="text" class="form-control bg-light border-0" id="perdireccion"
                                                                    placeholder="Enter your adress" wire:model.defer="personr.direccion" required>
                                                                </div>

                                                                <div class="col-xl-2"></div>
                                                            </div>
                                                            <div class="row mb-2 align-items-center">
                                                                <div class="col-xl-2"></div>

                                                                <!-- Label -->
                                                                <div class="col-xl-2">
                                                                    <label for="peremail" class="form-label mb-0">Email</label>
                                                                </div>

                                                                <!-- Input -->
                                                                <div class="col-xl-6">
                                                                    <input type="email" class="form-control bg-light border-0" id="peremail"
                                                                            placeholder="Enter your email" wire:model.defer="personr.email" required>
                                                                </div>

                                                                <div class="col-xl-2"></div>
                                                            </div>
                                                            <div class="row mb-2 align-items-center">
                                                                <div class="col-xl-2"></div>

                                                                <!-- Label -->
                                                                <div class="col-xl-2">
                                                                    <label for="pertelefono" class="form-label mb-0">Telefono</label>
                                                                </div>

                                                                <!-- Input -->
                                                                <div class="col-xl-6">
                                                                    <input type="text" class="form-control bg-light border-0" id="pertelefono"
                                                                            placeholder="Enter your phone number" wire:model.defer="personr.telefono" required>
                                                                </div>

                                                                <div class="col-xl-2"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end tab-pane-->
                                                <div class="tab-pane fade" id="custom-v-pills-messages" role="tabpanel" aria-labelledby="custom-v-pills-messages-tab">
                                                    <div class="d-flex">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-xxl-6">
                                                                    <div class="card-body">
                                                                         <table class="table align-middle table-nowrap table-sm mb-0" id="customerTable">
                                                                            <thead class="table-light">
                                                                                <tr>
                                                                                    <th scope="col" width="50px">
                                                                                        <a href="javascript:void(0);"
                                                                                        class="avatar-title bg-soft-primary text-primary fs-15 rounded">
                                                                                        <i class="ri-add-line"></i>
                                                                                        </a>
                                                                                    </th>
                                                                                    <th scope="col">Familiar</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @foreach($tblfamilys as $key => $familiar)
                                                                                <tr>
                                                                                <td colspan="2">{{$familiar->apellidos}}{{$familiar->nombres}}<td>
                                                                                </tr>
                                                                                @endforeach
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xxl-6">
                                                                    <div class="card" id="contact-view-detail">
                                                                        <div class="card-body text-center">
                                                                            <h5 class="mt-4 mb-1">Tonya Noble</h5>
                                                                            <p class="text-muted">Nesta Technologies</p>
                                                                            <ul class="list-inline mb-0">
                                                                                <li class="list-inline-item avatar-xs">
                                                                                    <a href="javascript:void(0);"
                                                                                        class="avatar-title bg-soft-success text-success fs-15 rounded">
                                                                                        <i class="ri-phone-line"></i>
                                                                                    </a>
                                                                                </li>
                                                                                <li class="list-inline-item avatar-xs">
                                                                                    <a href="javascript:void(0);"
                                                                                        class="avatar-title bg-soft-danger text-danger fs-15 rounded">
                                                                                        <i class="ri-mail-line"></i>
                                                                                    </a>
                                                                                </li>
                                                                                <li class="list-inline-item avatar-xs">
                                                                                    <a href="javascript:void(0);"
                                                                                        class="avatar-title bg-soft-info text-info fs-15 rounded">
                                                                                        <i class="ri-edit-2-fill"></i>
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            
                                                                            <div class="table-responsive table-card">
                                                                                <table class="table table-borderless mb-0">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td class="fw-medium" scope="row">Genero</td>
                                                                                            <td>Lead Designer / Developer</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td class="fw-medium" scope="row">Nacionalidad</td>
                                                                                            <td>tonyanoble@velzon.com</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td class="fw-medium" scope="row">Phone No</td>
                                                                                            <td>414-453-5725</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td class="fw-medium" scope="row">Direccion</td>
                                                                                            <td>154</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td class="fw-medium" scope="row">Email</td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end tab-pane-->

                                                <div class="tab-pane fade" id="custom-v-pills-factura" role="tabpanel" aria-labelledby="custom-v-pills-messages-tab">
                                                    <div class="d-flex">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-xxl-6">
                                                                    <div class="card-body">
                                                                         <table class="table align-middle table-nowrap table-sm mb-0" id="customerTable">
                                                                            <thead class="table-light">
                                                                                <tr>
                                                                                    <th scope="col" width="50px">
                                                                                        <a href="javascript:void(0);"
                                                                                        class="avatar-title bg-soft-primary text-primary fs-15 rounded">
                                                                                        <i class="ri-add-line"></i>
                                                                                        </a>
                                                                                    </th>
                                                                                    <th scope="col">Razón Social</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @foreach($tblfamilys as $key => $familiar)
                                                                                <tr>
                                                                                <td colspan="2">{{$familiar->apellidos}}{{$familiar->nombres}}<td>
                                                                                </tr>
                                                                                @endforeach
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xxl-6">
                                                                    <div class="card" id="contact-view-detail">
                                                                        <div class="card-body text-center">
                                                                            <h5 class="mt-4 mb-1">Tonya Noble</h5>
                                                                            <p class="text-muted">Nesta Technologies</p>
                                                                            <ul class="list-inline mb-0">
                                                                                <li class="list-inline-item avatar-xs">
                                                                                    <a href="javascript:void(0);"
                                                                                        class="avatar-title bg-soft-success text-success fs-15 rounded">
                                                                                        <i class="ri-phone-line"></i>
                                                                                    </a>
                                                                                </li>
                                                                                <li class="list-inline-item avatar-xs">
                                                                                    <a href="javascript:void(0);"
                                                                                        class="avatar-title bg-soft-danger text-danger fs-15 rounded">
                                                                                        <i class="ri-mail-line"></i>
                                                                                    </a>
                                                                                </li>
                                                                                <li class="list-inline-item avatar-xs">
                                                                                    <a href="javascript:void(0);"
                                                                                        class="avatar-title bg-soft-info text-info fs-15 rounded">
                                                                                        <i class="ri-edit-2-fill"></i>
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            
                                                                            <div class="table-responsive table-card">
                                                                                <table class="table table-borderless mb-0">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td class="fw-medium" scope="row">Genero</td>
                                                                                            <td>Lead Designer / Developer</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td class="fw-medium" scope="row">Nacionalidad</td>
                                                                                            <td>tonyanoble@velzon.com</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td class="fw-medium" scope="row">Phone No</td>
                                                                                            <td>414-453-5725</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td class="fw-medium" scope="row">Direccion</td>
                                                                                            <td>154</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td class="fw-medium" scope="row">Email</td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>







                                            </div>
                                        </div> <!-- end col-->
                                    </div> <!-- end row-->
                                </div><!-- end card-body -->
                            
                            <!--end card-->
                           
                    </div>
                    <div class="card-body p-4">
                        <div class="hstack gap-2 justify-content-end d-print-none mt-4">
                            
                            
                            <button type="submit" class="btn btn-success"><i class="mdi mdi-*-* mdi-content-save fs-16 me-1"></i> Grabar </button>
                            
                            
                            <a href="/sri/create-invoice" class="btn btn-success"><i class="ri-file-line align-bottom me-1"></i> Nuevo</a>
                                
                                    <a href="" wire:click.prevent="" class="btn btn-danger"><i class="ri-send-plane-fill align-bottom me-1"></i> Firmar y Enviar</a>
                            
                            <a href="" class="btn btn-primary" target="_blank"><i class="mdi mdi-*-* mdi-printer fs-16 me-1"></i>Imprimir</a>
                            
                        </div>
                    </div>
                </form>
            </div>
        </div>

    <!--end col-->
    </div>
    
</div>
