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
                                    <button class="nav-link fs-15 p-3 active" id="pills-bill-info-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-bill-info" type="button" role="tab"
                                        aria-controls="pills-bill-info" aria-selected="true"><i
                                            class=" ri-open-source-line fs-16 p-2 bg-soft-primary text-primary rounded-circle align-middle me-2"></i>
                                            Data Person</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fs-15 p-3" id="pills-bill-family-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-bill-family" type="button" role="tab"
                                        aria-controls="pills-bill-family" aria-selected="false"><i
                                            class="ri-user-2-line fs-16 p-2 bg-soft-primary text-primary rounded-circle align-middle me-2"></i>
                                            Data Family</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fs-15 p-3" id="pills-bill-responsible-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-bill-responsible" type="button" role="tab"
                                        aria-controls="pills-bill-responsible" aria-selected="false"><i
                                            class="ri-bank-card-line fs-16 p-2 bg-soft-primary text-primary rounded-circle align-middle me-2"></i>
                                            Datos Medical</button>
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
                                            Personal Data</h5>
                                    </div>
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
                                            <label for="txtemail" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="txtemail"
                                                placeholder="Enter Email" wire:model.defer="email" {{$eControl}}>
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
                                <div class="col-lg-12">
                                    <div class="hstack gap-2 justify-content-end">
                                        @if ($personaId==0)
                                            <button type="submit" class="btn btn-primary" wire:click="createData()">Save Record</button>
                                        @else 
                                            <button class="btn btn-primary" wire:click="updateData()">Update Record</button>
                                        @endif
                                        <a class="btn btn-secondary w-sm" href="/academic/person"><i class="me-1 align-bottom"></i>Cancel</a>
                                    </div>
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
                                            <input type="text" class="form-control" id="txtpersonaid" wire:model.defer="persona_id" style="display:none">
                                            <input type="text" class="form-control" id="pernombres" placeholder="Enter your Names" wire:model.defer="familiar.nombres" {{$eControl2}}>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="perapellidos" class="form-label">Surnames</label>
                                            <input type="text" class="form-control" id="perapellidos" placeholder="Enter your Surnames" wire:model.defer="familiar.apellidos" {{$eControl2}}>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="mb-3">
                                            <label for="pertipoident" class="form-label">Type of identification</label>
                                            <select class="form-select" data-choices data-choices-search-false id="pertipoident" wire:model.defer="familiar.tipoidentificacion" {{$eControl2}}>
                                                <option value="C">Cédula</option>
                                                <option value="P">Pasaporte</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="perident" class="form-label">
                                            Identification</label>
                                            <input type="text" class="form-control" id="perident"
                                                placeholder="Enter your firstname" wire:model.defer="familiar.identificacion" {{$eControl2}}>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="pergenero" class="form-label">Gender</label>
                                            <select class="form-select" data-choices data-choices-search-false id="pergenero" wire:model.defer="familiar.genero" {{$eControl2}}>
                                                <option value="M">Male</option>
                                                <option value="F">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="pernacionalidad" class="form-label">Nationality</label>
                                            <select class="form-select" data-choices data-choices-search-false id="pernacionalidad" wire:model.defer="familiar.nacionalidad_id" {{$eControl2}}>
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
                                            <input type="text" class="form-control" id="pertelefono"
                                                placeholder="Enter your phone number" wire:model.defer="familiar.telefono" {{$eControl2}}>
                                        </div>
                                    </div>                                   
                                    <!--end col-->

                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="perrelacion" class="form-label">Relation</label>
                                            <select class="form-select" data-choices data-choices-search-false id="perrelacion" wire:model.defer="familiar.parentesco" {{$eControl2}}>
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
                                                <label for="txtemail" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="txtemail"
                                                    placeholder="Enter Email" wire:model.defer="familiar.email" {{$eControl2}}>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6">
                                            <div class="mb-3">
                                                <label for="txtemail" class="form-label">Direction</label>
                                                <input type="email" class="form-control" id="txtemail"
                                                    placeholder="Enter Email" wire:model.defer="familiar.direccion" {{$eControl2}}>
                                            </div>
                                        </div>
                                        <div class="col-xxl-1">
                                            <div class="mb-3 text-center">
                                                <label for="" class="form-label">-</label>
                                                <div class="flex-shrink-0">
                                                   <button type="button" wire:click="activeControl()" class="btn btn-soft-success" id="create-btn"
                                                        data-bs-target=""><i class="ri-add-fill me-1"></i> New
                                                        </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-1">
                                            <div class="mb-3 text-center">
                                                <label for="" class="form-label">-</label>
                                                <div class="flex-shrink-0">
                                                   <button type="button" wire:click="addFamiliar()" class="btn btn-soft-secondary" id="create-btn"
                                                        data-bs-target="" {{$eControl2}}><i class="ri-add-fill me-1"></i> Agregar
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
                                <div class="col-lg-12">
                                    <div class="hstack gap-2 justify-content-end">
                                        @if ($personaId==0)
                                            <button type="submit" class="btn btn-primary" wire:click="createData()">Save Record</button>
                                        @else 
                                            <button class="btn btn-primary" wire:click="updateData()">Update Record</button>
                                        @endif
                                        <!--<button type="button" class="btn btn-secondary">Cancel</button>-->
                                        <a class="btn btn-secondary w-sm" href="/academic/person"><i class="me-1 align-bottom"></i>Cancel</a>
                                    </div>
                                </div>

                            </div>
                            <!-- end tab pane -->

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
