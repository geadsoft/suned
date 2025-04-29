<div>
    <div class="position-relative mx-n4 mt-n4">
        <div class="">
            <!--<img src="{{ URL::asset('assets/images/profile-bg.jpg') }}" class="profile-wid-img" alt="">-->
            <div class="overlay-content">
                <div class="text-end p-3">
                    <div class="p-0 ms-auto rounded-circle profile-photo-edit">
                        <!--<input id="profile-foreground-img-file-input" type="file" class="profile-foreground-img-file-input">-->
                        <label for="profile-foreground-img-file-input" class="profile-photo-edit btn btn-light">
                            
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xxl-3">
            <div class="card mt-n5">
                <div class="card-body p-4">
                    <div class="text-center">
                        <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
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
                        <h5 class="fs-17 mb-1">{{auth()->user()->name}}</h5>
                        <p class="text-muted mb-0">{{$tipopersona[$personas['tipopersona']]}}</p>
                    </div>
                </div>
            </div>
            <!--end card-->
            
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="flex-grow-1">
                            <h5 class="card-title mb-0">Portfolio</h5>
                        </div>
                        <div class="flex-shrink-0">
                            <a href="javascript:void(0);" class="badge bg-light text-primary fs-12"><i
                                    class="ri-add-fill align-bottom me-1"></i> Add</a>
                        </div>
                    </div>
                    <div class="mb-3 d-flex">
                        <div class="avatar-xs d-block flex-shrink-0 me-3">
                            <span class="avatar-title rounded-circle fs-16 bg-dark text-light">
                                <i class="ri-github-fill"></i>
                            </span>
                        </div>
                        <input type="email" class="form-control" id="gitUsername" placeholder="Username"
                            value="@daveadame">
                    </div>
                    <div class="mb-3 d-flex">
                        <div class="avatar-xs d-block flex-shrink-0 me-3">
                            <span class="avatar-title rounded-circle fs-16 bg-primary">
                                <i class="ri-global-fill"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control" id="websiteInput" placeholder="www.example.com"
                            value="www.velzon.com">
                    </div>
                    <div class="mb-3 d-flex">
                        <div class="avatar-xs d-block flex-shrink-0 me-3">
                            <span class="avatar-title rounded-circle fs-16 bg-success">
                                <i class="ri-dribbble-fill"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control" id="dribbleName" placeholder="Username"
                            value="@dave_adame">
                    </div>
                    <div class="d-flex">
                        <div class="avatar-xs d-block flex-shrink-0 me-3">
                            <span class="avatar-title rounded-circle fs-16 bg-danger">
                                <i class="ri-pinterest-fill"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control" id="pinterestName" placeholder="Username"
                            value="Advance Dave">
                    </div>
                </div>
            </div>
            <!--end card-->
        </div>
        <!--end col-->
        <div class="col-xxl-9">
            <div class="card mt-xxl-n5">
                <div class="card-header">
                    <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                                <i class="fas fa-home"></i>
                                Datos Personales
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#changePassword" role="tab">
                                <i class="far fa-user"></i>
                                Cambiar Contraseña
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body p-4">
                    <div class="tab-content">
                        <div class="tab-pane active" id="personalDetails" role="tabpanel">
                            <form autocomplete="off" wire:submit.prevent="updateData">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="firstnameInput" class="form-label">Nombres</label>
                                            <input type="text" class="form-control" id="firstnameInput"
                                                placeholder="Enter your firstname" wire:model.defer="personas.nombres">
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-6">
                                        <div class="mb-3"> 
                                            <label for="lastnameInput" class="form-label">Apellidos</label>
                                            <input type="text" class="form-control" id="lastnameInput"
                                                placeholder="Enter your lastname" value="Adame" wire:model.defer="personas.apellidos">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="lastnameInput" class="form-label">Identificación</label>
                                            <input type="text" class="form-control" id="lastnameInput"
                                                placeholder="Enter your lastname" wire:model.defer="personas.identificacion">
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="phonenumberInput" class="form-label">Teléfono
                                                Number</label>
                                            <input type="text" class="form-control" id="phonenumberInput"
                                                placeholder="Enter your phone number" wire:model.defer="personas.telefono">
                                        </div>
                                    </div>
                                    <!--end col-->
                                    
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="JoiningdatInput" class="form-label">Dirección</label>
                                            <input type="text" class="form-control" id="phonenumberInput"
                                                placeholder="Enter your phone number" wire:model.defer="personas.direccion">
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="designationInput" class="form-label">Usuario</label>
                                            <input type="text" class="form-control" id="designationInput"
                                                placeholder="Designation" wire:model.defer="usuario">
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="emailInput" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="emailInput"
                                                placeholder="Enter your email" wire:model.defer="personas.email" disabled>
                                        </div>
                                    </div>
                                    <!--end col-->                                    
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="designationInput" class="form-label">Fecha Registro</label>
                                            <input type="text" class="form-control" id="designationInput"
                                                placeholder="Designation" value = "{{date('d/m/Y',strtotime($personas['created_at']))}}" disabled>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="websiteInput1" class="form-label">Website</label>
                                            <input type="text" class="form-control" id="websiteInput1"
                                                placeholder="www.example.com" value="www.americanschool.edu.ec" disabled/>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-12">
                                        <div class="mb-3 pb-2">
                                            <label for="exampleFormControlTextarea"
                                                class="form-label">Perfil</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea" placeholder="Enter your description"
                                                rows="3"></textarea>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-12">
                                        <div class="hstack gap-2 justify-content-end">
                                            <button type="submit" class="btn btn-primary">Actualizar</button>
                                            <button type="button" class="btn btn-soft-success">Cancelar</button>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </form>
                        </div>
                        <!--end tab-pane-->
                        <div class="tab-pane" id="changePassword" role="tabpanel">
                            <form action="javascript:void(0);">
                                <div class="row g-2">
                                    <div class="col-lg-4">
                                        <div>
                                            <label for="oldpasswordInput" class="form-label">Contraseña Anterior</label>
                                            <input type="password" class="form-control" id="oldpasswordInput"
                                                placeholder="Enter current password" wire:model.defer="passwordOld">
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-4">
                                        <div>
                                            <label for="newpasswordInput" class="form-label">Nueva Contraseña</label>
                                            <input type="password" class="form-control" id="newpasswordInput"
                                                placeholder="Enter new password" wire:model.defer="passwordNew">
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-4">
                                        <div>
                                            <label for="confirmpasswordInput" class="form-label">Confirmar Contraseña</label>
                                            <input type="password" class="form-control" id="confirmpasswordInput"
                                                placeholder="Confirm password" wire:model.defer="passwordConfirmar">
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <a href="javascript:void(0);"
                                                class="link-primary text-decoration-underline">Has olvidado tu contraseña ?</a>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-12">
                                        <div class="text-end">
                                            <button class="btn btn-success" wire:click='updatePassword'>Cambiar Contraseña</button>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </form>
                            
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
