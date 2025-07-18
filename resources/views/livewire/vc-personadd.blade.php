<div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <!-- Danger Alert -->
                @if ($estado=='R')
                <div class="alert alert-danger alert-dismissible alert-label-icon rounded-label fade show" role="alert">
                    <i class="ri-emotion-unhappy-line label-icon"></i><strong>Retirado</strong>
                    
                </div>
                @else
                <div class="mb-3"></div>
                @endif
                <div class="card-body checkout-tab">
                    
                    <form autocomplete="off" wire:submit.prevent="{{ 'createData' }}">
                        @csrf

                        <div class="step-arrow-nav mt-n3 mb-3">

                            <ul class="nav nav-pills nav-justified custom-nav nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fs-15 p-3 active" id="pills-bill-info-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-bill-info" type="button" role="tab"
                                        aria-controls="pills-bill-info" aria-selected="true"><i
                                            class=" ri-open-source-line fs-16 p-2 bg-soft-primary text-primary rounded-circle align-middle me-2"></i>
                                            Estudiante</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fs-15 p-3" id="pills-bill-responsible-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-bill-responsible" type="button" role="tab"
                                        aria-controls="pills-bill-responsible" aria-selected="false"><i
                                            class="ri-bank-card-line fs-16 p-2 bg-soft-primary text-primary rounded-circle align-middle me-2"></i>
                                            Representante</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fs-15 p-3" id="pills-bill-family-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-bill-family" type="button" role="tab"
                                        aria-controls="pills-bill-family" aria-selected="false"><i
                                            class="ri-user-2-line fs-16 p-2 bg-soft-primary text-primary rounded-circle align-middle me-2"></i>
                                            Datos Familiar</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fs-15 p-3" id="pills-bill-medical-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-bill-factura" type="button" role="tab"
                                        aria-controls="pills-bill-factura" aria-selected="false"><i
                                            class="ri-bank-card-line fs-16 p-2 bg-soft-primary text-primary rounded-circle align-middle me-2"></i>
                                            Datos Facturacion</button>
                                </li>
                            </ul>
                        </div>

                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="pills-bill-info" role="tabpanel"
                                aria-labelledby="pills-bill-info-tab">
                                                                
                                <div class="row">
                                    <div class="card-header">
                                        <h5 class="card-title flex-grow-1 mb-0 text-primary"><i
                                            class="mdi mdi-account-tie align-middle me-1 text-success"></i>
                                            Datos Personales</h5>
                                    </div>
                                </div>
                                <div class="card-body row">
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="txtnombres" class="form-label">
                                                    Nombres</label>
                                                    <input type="text" class="form-control" id="txtnombres"
                                                        placeholder="Enter your Names" wire:model.defer="nombres" required {{$eControl}}>
                                                    @error('nombres') <span class="error">{{ $message }}</span> @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="txtapellidos" class="form-label">Apellidos</label>
                                                    <input type="text" class="form-control" id="txtapellidos"
                                                        placeholder="Enter your Surnames" wire:model.defer="apellidos" required {{$eControl}}>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label for="cmbtipoident" class="form-label">Tipo de Identificación</label>
                                                    <select class="form-select" data-choices data-choices-search-false id="cmbtipoident" wire:model.defer="tipoident" required {{$eControl}}>
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
                                                        placeholder="Enter your firstname" wire:model.defer="identificacion" required {{$eControl}}>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label for="txtfechanace" class="form-label">Fecha de Nacimiento</label>
                                                    <input type="date" class="form-control" id="txtfechanace" wire:model.defer="fechanace" required {{$eControl}}> 
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label for="cmbgenero" class="form-label">Genero</label>
                                                    <select class="form-select" data-choices data-choices-search-false id="cmbgenero" wire:model.defer="genero" required {{$eControl}}>
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
                                            <select class="form-select" data-choices data-choices-search-false id="cmbnacionalidad" wire:model.defer="nacionalidad" required {{$eControl}}>
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
                                            <label for="cmbetnia" class="form-label">Grupo Etnico</label>
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
                                            <label for="txtemail" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="txtemail"
                                                placeholder="Enter Email" wire:model.defer="email" {{$eControl}}>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="txttelefono" class="form-label">Teléfono</label>
                                            <input type="text" class="form-control" id="txttelefono"
                                                placeholder="Enter your phone number" wire:model.defer="telefono" required {{$eControl}}>
                                        </div>
                                    </div>

                                    
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <ul class="nav nav-tabs-custom card-header-tabs border-bottom-0" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-bs-toggle="tab" href="#info-matricula"
                                                    role="tab">
                                                    Matrícula
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-bs-toggle="tab" href="#add-direction"
                                                    role="tab">
                                                    Domicilio
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-body">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="info-matricula" role="tabpanel">
                                                <div class="mb-3">
                                                    <div class="input-group">
                                                         <span class="badge bg-info text-wrap fs-12"> Nro. Registro: {{$matricula['documento']}}</span>
                                                        
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                        <label class="form-label">Fecha: 
                                                         <span class="text-muted fw-normal">{{date('d/m/Y',strtotime($matricula['fecha']))}}</span>
                                                        </label>
                                                </div>
                                                 <div class="mb-3">
                                                    <label class="form-label">Comentario</label>
                                                    <textarea type="text" class="form-control" id="txtcomentario" placeholder="Enter your Comment" wire:model.defer="comentario">
                                                    </textarea>
                                                </div>
                                            </div>                                       
                                            <div class="tab-pane" id="add-direction" role="tabpanel">
                                                <div class="row mb-3">
                                                    <div class="mb-3 col-lg-4">
                                                        <input type="text" class="form-control" wire:model.defer="direction.direccion">
                                                    </div>
                                                    <div class="mb-3 col-sm-1">
                                                        <select class="form-select" data-choices data-choices-search-false id="cmbdomingo" wire:model.defer="direction.domingo">
                                                            <option value=0>Libre</option>
                                                            <option value=1>Va</option>
                                                            <option value=2>Viene</option>
                                                            <option value=3>Viene/Va</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-sm-1">
                                                        <select class="form-select" data-choices data-choices-search-false id="cmblunes" wire:model.defer="direction.lunes">
                                                            <option value=0>Libre</option>
                                                            <option value=1>Va</option>
                                                            <option value=2>Viene</option>
                                                            <option value=3>Viene/Va</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-sm-1">
                                                        <select class="form-select" data-choices data-choices-search-false id="cmbmartes" wire:model.defer="direction.martes">
                                                            <option value=0>Libre</option>
                                                            <option value=1>Va</option>
                                                            <option value=2>Viene</option>
                                                            <option value=3>Viene/Va</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-sm-1">
                                                        <select class="form-select" data-choices data-choices-search-false id="cmbmiercoles" wire:model.defer="direction.miercoles">
                                                            <option value=0>Libre</option>
                                                            <option value=1>Va</option>
                                                            <option value=2>Viene</option>
                                                            <option value=3>Viene/Va</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-sm-1">
                                                        <select class="form-select" data-choices data-choices-search-false id="cmbjueves" wire:model.defer="direction.jueves">
                                                            <option value=0>Libre</option>
                                                            <option value=1>Va</option>
                                                            <option value=2>Viene</option>
                                                            <option value=3>Viene/Va</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-sm-1">
                                                        <select class="form-select" data-choices data-choices-search-false id="cmbviernes" wire:model.defer="direction.viernes">
                                                            <option value=0>Libre</option>
                                                            <option value=1>Va</option>
                                                            <option value=2>Viene</option>
                                                            <option value=3>Viene/Va</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-sm-1">
                                                        <select class="form-select" data-choices data-choices-search-false id="cmbsabado" wire:model.defer="direction.sabado">
                                                            <option value=0>Libre</option>
                                                            <option value=1>Va</option>
                                                            <option value=2>Viene</option>
                                                            <option value=3>Viene/Va</option>
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

                                                            @foreach ($directions as $data)  
                                                            <tr>
                                                                <td>{{$data['direccion']}}</td>
                                                                <td>{{$dia[$data['domingo']]}}</td>
                                                                <td>{{$dia[$data['lunes']]}}</td>
                                                                <td>{{$dia[$data['martes']]}}</td>
                                                                <td>{{$dia[$data['miercoles']]}}</td>
                                                                <td>{{$dia[$data['jueves']]}}</td>
                                                                <td>{{$dia[$data['viernes']]}}</td>
                                                                <td>{{$dia[$data['sabado']]}}</td>
                                                                <td>
                                                                    <ul class="list-inline hstack gap-2 mb-0">
                                                                        <li class="list-inline-item edit" data-bs-toggle="tooltip"
                                                                            data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                                                            <a href="" wire:click.prevent="">
                                                                                <i class="ri-pencil-fill fs-16"></i>
                                                                            </a>
                                                                        </li>
                                                                        <li class="list-inline-item" data-bs-toggle="tooltip"
                                                                            data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                                                            <a class="text-danger d-inline-block remove-item-btn"
                                                                                data-bs-toggle="modal" href="" wire:click.prevent="">
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
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="hstack gap-2 justify-content-end">
                                        @if ($personaId==0)
                                            <button type="submit" class="btn btn-primary" wire:click="createData()">Grabar</button>
                                        @else 
                                            <button class="btn btn-primary" wire:click="updateData()">Actualizar</button>
                                        @endif
                                        <a class="btn btn-secondary w-sm" href="/academic/students"><i class="me-1 align-bottom"></i>Cancel</a>
                                    </div>
                                </div>
                                   
                            </div>
                            <!-- end tab pane -->

                            <div class="tab-pane fade" id="pills-bill-responsible" role="tabpanel"
                                aria-labelledby="pills-bill-address-tab">
                                
                                <div class="card-header">
                                    <h5 class="card-title flex-grow-1 mb-0 text-primary"><i
                                        class="mdi mdi-account-tie align-middle me-1 text-success"></i>
                                        Datos Personales</h5>
                                </div>
                                <div class="card-body row" wire:model.defer="">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="pernombres" class="form-label">
                                            Nombres</label>
                                            <input type="text" class="form-control" id="pernombres" placeholder="Enter your Names" wire:model.defer="representante.nombres" required {{$eControl}}>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="perapellidos" class="form-label">Apellidos</label>
                                            <input type="text" class="form-control" id="perapellidos" placeholder="Enter your Surnames" wire:model.defer="representante.apellidos" required {{$eControl}}>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="mb-3">
                                            <label for="pertipoident" class="form-label">Tipo de Identificación</label>
                                            <select class="form-select" data-choices data-choices-search-false id="pertipoident" wire:model.defer="representante.tipoidentificacion" required {{$eControl}}>
                                                <option value="C">Cédula</option>
                                                <option value="R">Ruc</option>
                                                <option value="P">Pasaporte</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="perident" class="form-label">
                                            Identificación</label>
                                            <input type="text" class="form-control" id="perident"
                                                placeholder="Enter your identificacion" wire:model.defer="representante.identificacion" required {{$eControl}}>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="pergenero" class="form-label">Genero</label>
                                            <select class="form-select" data-choices data-choices-search-false id="pergenero" wire:model.defer="representante.genero" required {{$eControl}}>
                                                <option value="M">Masculino</option>
                                                <option value="F">Femenino</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="pernacionalidad" class="form-label">Nacionalidad</label>
                                            <select class="form-select" data-choices data-choices-search-false id="pernacionalidad" wire:model.defer="representante.nacionalidad_id" require {{$eControl}}>
                                                <option value="0">Seleccione Nacionalidad</option>
                                                @foreach ($tblgenerals as $general)
                                                    <option value="{{$general->id}}">{{$general->descripcion}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="pertelefono" class="form-label">Teléfono</label>
                                            <input type="text" class="form-control" id="pertelefono"
                                                placeholder="Enter your phone number" wire:model.defer="representante.telefono" required {{$eControl}}>
                                        </div>
                                    </div>
                                    
                                   

                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="perrelacion" class="form-label">Relación</label>
                                            <select class="form-select" data-choices data-choices-search-false id="perrelacion" wire:model.defer="representante.parentesco" required {{$eControl}}>
                                                <option value="NN">Seleccione Relación</option>
                                                <option value="MA">Madre</option>
                                                <option value="PA">Padre</option>
                                                <option value="AP">Apoderado</option>
                                                <option value="OT">Otro</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="card-body row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="peremail" class="form-label">Email
                                                    Address</label>
                                                <input type="email" class="form-control" id="peremail"
                                                    placeholder="Enter your email" wire:model.defer="representante.email" required {{$eControl}}>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="label" for="perdireccion">Dirección</label>
                                                <input type="text" class="form-control" id="perdireccion"
                                                    placeholder="Enter your adress" wire:model.defer="representante.direccion" required {{$eControl}}>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="hstack gap-2 justify-content-end">
                                        @if ($personaId==0)
                                            <button type="submit" class="btn btn-primary" wire:click="createData()">Grabar</button>
                                        @else 
                                            <button class="btn btn-primary" wire:click="updateData()">Actualizar</button>
                                        @endif
                                        <a class="btn btn-secondary w-sm" href="/academic/students"><i class="me-1 align-bottom"></i>Cancelar</a>
                                    </div>
                                </div>

                            </div>

                            <div class="tab-pane fade" id="pills-bill-family" role="tabpanel" aria-labelledby="pills-bill-family-tab">
                                <div class="row">
                                    <div class="card-header">
                                        <h5 class="card-title flex-grow-1 mb-0 text-primary"><i
                                            class="mdi mdi-account-tie align-middle me-1 text-success"></i>
                                            Familiares</h5>
                                    </div>
                                </div>
                                
                                @livewire('vc-persons-family',['personaId' => $personaId])

                            </div>
                            <!-- end tab pane -->

                            <div class="tab-pane fade" id="pills-bill-factura" role="tabpanel" aria-labelledby="pills-bill-factura-tab">
                                <div class="row">
                                    <div class="card-header">
                                        <h5 class="card-title flex-grow-1 mb-0 text-primary"><i
                                            class="mdi mdi-account-tie align-middle me-1 text-success"></i>
                                            Datos de Facturación</h5>
                                    </div>
                                </div>
                                
                                @livewire('vc-persons-billing',['personaId' => $personaId])

                            </div>

                            <div class="tab-pane fade" id="pills-bill-responsible" role="tabpanel"
                                aria-labelledby="pills-bill-responsible-tab">
                                    
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

</div>
