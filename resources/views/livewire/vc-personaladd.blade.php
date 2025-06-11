<div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body checkout-tab">
                    <form autocomplete="off" wire:submit.prevent="{{ $editar ? 'updateData' : 'createData' }}">
                        @csrf
                        <div class="step-arrow-nav mt-n3 mx-n3 mb-3">

                            <ul class="nav nav-pills nav-justified custom-nav nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fs-12 p-3 active" id="pills-bill-personal-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-bill-personal" type="button" role="tab"
                                        aria-controls="pills-bill-personal" aria-selected="true"><i
                                            class="ri-user-2-line fs-16 p-2 bg-soft-primary text-primary rounded-circle align-middle me-2"></i>
                                            Personal</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fs-12 p-3" id="pills-bill-contrato-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-bill-contrato" type="button" role="tab"
                                        aria-controls="pills-bill-contrato" aria-selected="false"><i
                                            class="ri-parent-fill fs-16 p-2 bg-soft-primary text-primary rounded-circle align-middle me-2"></i>
                                            Nombramiento y Contrato</button>
                                </li>
                                <!--<li class="nav-item" role="presentation">
                                    <button class="nav-link fs-12 p-3" id="pills-bill-experiencia-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-bill-experiencia" type="button" role="tab"
                                        aria-controls="pills-bill-experiencia" aria-selected="false"><i
                                            class="ri-file-user-line fs-16 p-2 bg-soft-primary text-primary rounded-circle align-middle me-2"></i>
                                            Experiencia Laboral</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fs-12 p-3" id="pills-bill-estudios-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-bill-estudios" type="button" role="tab" aria-controls="pills-estudios"
                                        aria-selected="false"><i
                                            class="ri-checkbox-circle-line fs-16 p-2 bg-soft-primary text-primary rounded-circle align-middle me-2"></i>
                                            Estudios Realizados</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fs-12 p-3" id="pills-bill-formacion-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-bill-formacion" type="button" role="tab" aria-controls="pills-formacion"
                                        aria-selected="false"><i
                                            class="ri-checkbox-circle-line fs-16 p-2 bg-soft-primary text-primary rounded-circle align-middle me-2"></i>
                                            Formación Docente</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fs-12 p-3" id="pills-bill-familiares-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-bill-familiares" type="button" role="tab" aria-controls="pills-familiares"
                                        aria-selected="false"><i
                                            class="ri-checkbox-circle-line fs-16 p-2 bg-soft-primary text-primary rounded-circle align-middle me-2"></i>
                                           Familiares</button>
                                </li>-->
                            </ul>
                        </div>

                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="pills-bill-personal" role="tabpanel"
                                aria-labelledby="pills-bill-address-tab">
                                <div class="row">
                                    <div class="card-header">
                                        <h5 class="card-title flex-grow-1 mb-0 text-primary fs-14"><i
                                            class="mdi mdi-account-tie align-middle me-1 text-success"></i>
                                            Datos Personales</h5>
                                    </div>
                                    <fieldset @disabled($formDisabled)>
                                    <div class="card-body row">
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="txtapellidos" class="form-label">Apellidos</label>
                                                        <input type="text" class="form-control" id="txtapellidos"
                                                            placeholder="Ingrese sus apellidos" wire:model.defer="record.apellidos" required {{$eControl}}>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="txtnombres" class="form-label">
                                                        Nombres</label>
                                                        <input type="text" class="form-control" id="txtnombres"
                                                            placeholder="Ingrese sus nombres" wire:model.defer="record.nombres" required {{$eControl}}>
                                                        @error('nombres') <span class="error">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="mb-3">
                                                        <label for="cmbtipoident" class="form-label">Tipo Identificación</label>
                                                        <select class="form-select" data-choices data-choices-search-false id="cmbtipoident" wire:model.defer="record.tipoidentificacion" required {{$eControl}}>
                                                            <option value="C">Cédula</option>
                                                            <option value="P">Pasaporte</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="mb-3">
                                                        <label for="txtidentificacion" class="form-label">
                                                        Identificación</label>
                                                        <input type="text" class="form-control" id="txtnui"
                                                            placeholder="Ingrese su identificación" wire:model.defer="record.identificacion" required {{$eControl}} wire:focusout='validaNui()'>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="mb-3">
                                                        <label for="txtfechanace" class="form-label">Fecha de Nacimiento</label>
                                                        <input type="date" class="form-control" id="txtfechanace" wire:model.defer="record.fechanacimiento" required {{$eControl}}> 
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="mb-3">
                                                        <label for="cmbgenero" class="form-label">Genero</label>
                                                        <select class="form-select" data-choices data-choices-search-false id="cmbgenero" wire:model.defer="record.genero" required {{$eControl}}>
                                                            <option value="M">Masculino</option>
                                                            <option value="F">Femenino</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="row">
                                                <div class="card-body text-center mb-3">
                                                    
                                                    <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                                        <!--<img src="@if (Auth::user()->avatar != '') {{ URL::asset('images/' . Auth::user()->avatar) }}@else{{ URL::asset('assets/images/users/avatar-1.jpg') }} @endif"
                                                            class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="user-profile-image">-->   
                                                        @if ($fileimg)
                                                            <img src="{{ $fileimg->temporaryURL() }}"
                                                                class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="user-profile-image">
                                                        @else
                                                            <img src="@if ($foto != '') {{ URL::asset('storage/fotos/'.$foto) }}@else{{ URL::asset('assets/images/users/sin-foto.jpg') }} @endif"
                                                                class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="user-profile-image">
                                                        @endif
                                                        <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                                            <input id="profile-img-file-input" type="file" class="profile-img-file-input" wire:model="fileimg">
                                                            <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                                                <span class="avatar-title rounded-circle bg-light text-body">
                                                                    <i class="ri-camera-fill"></i>
                                                                </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-2">
                                            <div class="mb-3">
                                                <label for="cmbnacionalidad" class="form-label">Nacionalidad</label>
                                                <select class="form-select" data-choices data-choices-search-false id="cmbnacionalidad" wire:model.defer="record.nacionalidad_id" required {{$eControl}}>
                                                    <option value="">Seleccione Nacionalidad</option>
                                                    @foreach ($tblgenerals as $general)
                                                        @if ($general->superior == 7)
                                                        <option value="{{$general->id}}">{{$general->descripcion}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="mb-3">
                                                <label for="txttelefono" class="form-label">Teléfono</label>
                                                <input type="text" class="form-control" id="txttelefono"
                                                    placeholder="Ingrese su número de telefono" wire:model.defer="record.telefono" {{$eControl}}>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="cmbetnia" class="form-label">Dirección</label>
                                                <input type="text" class="form-control" id="txtdireccion"
                                                    placeholder="Ingrese su dirección domiciliaria" wire:model.defer="record.direccion" {{$eControl}}>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="txtemail" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="txtemail"
                                                    placeholder="Enter your email" wire:model.defer="record.email" {{$eControl}}>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="cmbetnia" class="form-label">Tipo Personal</label>
                                                <select class="form-select data-choices data-choices-search-false" id="cmbtipopersona" wire:model.defer="record.tipopersona" {{$eControl}}>
                                                    <option value="A">Administrativo</option>
                                                    <option value="D">Docente</option>
                                                    <option value="P">Apoyo Profesional</option>
                                                    <option value="M">Mantenimiento y Operaciones</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="mb-3">
                                                <label for="cmbetnia" class="form-label">Estado</label>
                                                <select class="form-select data-choices data-choices-search-false" id="cmbestado" wire:model.defer="record.estado" {{$eControl}}>
                                                    <option value="A">Activo</option>
                                                    <option value="I">Inactivo</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>    
                                    </fieldset>
                                </div>
                                <!--<div class="row">
                                    <div class="card-header">
                                        <h5 class="card-title flex-grow-1 mb-0 text-primary fs-14"><i
                                            class="mdi mdi-phone-sync align-middle me-1 text-success"></i>
                                            Contactos</h5>
                                    </div>
                                    <div class="card-body row">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="txtemail" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="txtemail"
                                                    placeholder="Enter your email" wire:model.defer="record.email" {{$eControl}}>
                                            </div>
                                            <div class="mb-3">
                                                <label for="txttelefono" class="form-label">Teléfono</label>
                                                <input type="text" class="form-control" id="txttelefono"
                                                    placeholder="Ingrese su número de telefono" wire:model.defer="record.telefono" {{$eControl}}>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>-->
                                <div class="card-body p-4">
                                    <div class="hstack gap-2 justify-content-end d-print-none mt-4">    
                                        @if ($formDisabled==false)
                                        @if($editar==true)
                                            <button type="submit" class="btn btn-success"><i class="ri-save-line align-bottom me-1"></i> Actualizar </button>
                                        @else
                                            <button type="submit" class="btn btn-success"><i class="ri-save-line align-bottom me-1"></i> Grabar </button>
                                        @endif
                                        @endif
                                        <a class="btn btn-secondary w-sm" href="/headquarters/staff"><i class="me-1 align-bottom"></i>Cancelar</a>
                                    </div>
                                </div>    
                            </div>

                            <!-- end tab pane -->
                            <div class="tab-pane fade" id="pills-bill-contrato" role="tabpanel" aria-labelledby="pills-bill-contrato-tab">
                                <div class="card-body row">
                                    <div class="row">
                                        <div class="card-header">
                                            <h5 class="card-title flex-grow-1 mb-0 text-primary"><i
                                                class="mdi mdi-chart-box-plus-outline align-middle me-1 text-success"></i>
                                                Contratos</h5>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-header border-0">
                                                    <div class="d-flex align-items-center">
                                                        <h5 class="card-title mb-0 flex-grow-1"></h5>
                                                        <div class="flex-shrink-0">
                                                            <a class="btn btn-success add-btn" href="/headquarters/staff-add"><i
                                                            class="ri-add-line me-1 align-bottom"></i>Agregar Contratos</a>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-12">
                                        <div class="card" id="contactList">
                                            <div class="card-body">
                                                <div>
                                                    <div class="table-responsive table-card mb-3">
                                                        <table class="table align-middle table-nowrap mb-0" id="customerTable">
                                                            <thead class="text-muted table-light">
                                                                <tr class="text-uppercase">
                                                                    <th class="sort" data-sort="name" scope="col">Desde</th>
                                                                    <th class="sort" data-sort="company_name" scope="col">Hasta</th>
                                                                    <th class="sort" data-sort="lead_score" scope="col">Tipo Empleado</th>
                                                                    <th class="sort" data-sort="tags" scope="col">Cargo</th>
                                                                    <th class="sort" data-sort="tags" scope="col">Jornada</th>
                                                                    <th class="sort" data-sort="tags" scope="col">Tipo Contrato</th>
                                                                    <th scope="col">Acción</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="list form-check-all">
                                                            
                                                                <tr>                                       
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td>
                                                                        <ul class="list-inline hstack gap-2 mb-0">
                                                                            <li class="list-inline-item" data-bs-toggle="tooltip"
                                                                                data-bs-trigger="hover" data-bs-placement="top" title="View">
                                                                                <a href="" class="view-item-btn"><i
                                                                                        class="ri-eye-fill align-bottom text-muted"></i></a>
                                                                            </li>
                                                                            <li class="list-inline-item" data-bs-toggle="tooltip"
                                                                                data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                                                                <a class="edit-item-btn" ><i
                                                                                        class="ri-pencil-fill align-bottom text-muted"></i></a>
                                                                            </li>
                                                                        </ul>
                                                                    </td>
                                                                </tr>
                                                              
                                                            </tbody>
                                                        </table>
                                                        
                                                        <div class="noresult" style="display: none">
                                                            <div class="text-center">
                                                                <lord-icon src="https://cdn.lordicon.com/msoeawqm.json"
                                                                    trigger="loop" colors="primary:#121331,secondary:#08a88a"
                                                                    style="width:75px;height:75px">
                                                                </lord-icon>
                                                                <h5 class="mt-2">Sorry! No Result Found</h5>
                                                                <p class="text-muted mb-0">We've searched more than 150+ contacts We
                                                                    did not find any
                                                                    contacts for you search.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                <!--modal-->
                                                <div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                    aria-label="Close" id="btn-close"></button>
                                                            </div>
                                                            <div class="modal-body p-5 text-center">
                                                                <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json"
                                                                    trigger="loop" colors="primary:#405189,secondary:#f06548"
                                                                    style="width:90px;height:90px"></lord-icon>
                                                                <div class="mt-4 text-center">
                                                                    <h4 class="fs-semibold">You are about to delete a contact ?</h4>
                                                                    <p class="text-muted fs-14 mb-4 pt-1">Deleting your contact will
                                                                        remove all of your information from our database.</p>
                                                                    <div class="hstack gap-2 justify-content-center remove">
                                                                        <button
                                                                            class="btn btn-link link-success fw-medium text-decoration-none"
                                                                            data-bs-dismiss="modal"><i
                                                                                class="ri-close-line me-1 align-middle"></i>
                                                                            Close</button>
                                                                        <button class="btn btn-danger" id="delete-record">Yes,
                                                                            Delete It!!</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end delete modal -->

                                            </div>

                                        </div>
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
                            
                            <!-- Experiencias -->
                            <div class="tab-pane fade" id="pills-bill-experiencia" role="tabpanel"  aria-labelledby="pills-finish-tab">
                                <div class="card-body row">
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-header border-0">
                                                    <div class="d-flex align-items-center">
                                                        <h6 class="mb-0 flex-grow-1">Experiencias Laborales</h6>
                                                        <div class="flex-shrink-0">
                                                            <a class="btn btn-success add-btn"><i
                                                            class="ri-add-line me-1 align-bottom"></i>Agregar Experiencia</a>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end tab pane -->

                            <!-- Estudios -->
                            <div class="tab-pane fade" id="pills-bill-estudios" role="tabpanel"  aria-labelledby="pills-finish-tab">
                                <div class="card-body row">
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-header border-0">
                                                    <div class="d-flex align-items-center">
                                                        <h6 class="mb-0 flex-grow-1">Estudios Realizados</h6>
                                                        <div class="flex-shrink-0">
                                                            <a class="btn btn-success add-btn"><i
                                                            class="ri-add-line me-1 align-bottom"></i>Agregar Estudios</a>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end tab pane -->

                             <!-- Formacion -->
                            <div class="tab-pane fade" id="pills-bill-estudios" role="tabpanel"  aria-labelledby="pills-finish-tab">
                                <div class="card-body row">
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-header border-0">
                                                    <div class="d-flex align-items-center">
                                                        <h6 class="mb-0 flex-grow-1">Estudios Realizados</h6>
                                                        <div class="flex-shrink-0">
                                                            <a class="btn btn-success add-btn"><i
                                                            class="ri-add-line me-1 align-bottom"></i>Agregar Estudios</a>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
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
