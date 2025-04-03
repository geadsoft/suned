<div>
    <div class="row">
        <div class="card-header">
            <h5 class="card-title flex-grow-1 mb-0 text-primary">
                ¿Tiene Identificación?</h5>
        </div>
        <div class="card-body row">
            <div class="col-xl-3">
            </div> 
            <div class="col-xl-6">
                <div class="input-group mb-3">
                    <label for="" class="form-label fs-15 mt-2  me-5">NUI</label>
                    <input type="number" class="form-control" placeholder="Ingrese identificación.." wire:model.defer="search_nui" {{$eControl2}}>
                    <a id="btnstudents" class ="input-group-text btn btn-soft-info" wire:click="loadNui()"><i class="ri-search-line me-1"></i>Buscar</a>
                </div>
            </div>
            
        </div> 
    </div>
    <div class="card-body row">
        <div class="col-lg-6">
            <div class="mb-3">
                <label for="pernombres" class="form-label">
                Nombre</label>
                <input type="text" class="form-control" id="txtpersonaid" wire:model.defer="persona_id" style="display:none">
                <input type="text" class="form-control" id="pernombres" placeholder="Ingrese los nombres" wire:model.defer="familiar.nombres" {{$eControl2}}>
            </div>
        </div>
        
        <div class="col-lg-6">
            <div class="mb-3">
                <label for="perapellidos" class="form-label">Apellidos</label>
                <input type="text" class="form-control" id="perapellidos" placeholder="Ingrese los apellidos" wire:model.defer="familiar.apellidos" {{$eControl2}}>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="mb-3">
                <label for="pertipoident" class="form-label">Tipo de Identificación</label>
                <select class="form-select" data-choices data-choices-search-false id="pertipoident" wire:model.defer="familiar.tipoidentificacion" {{$eControl2}}>
                    <option value="C">Cédula</option>
                    <option value="R">Ruc</option>
                    <option value="P">Pasaporte</option>
                </select>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="mb-3">
                <label for="perident" class="form-label">
                Identificación</label>
                <input type="text" class="form-control" id="perident"
                    placeholder="Ingrese cédula o ruc" wire:model.defer="familiar.identificacion" {{$eControl2}}>
            </div>
        </div>
        <!--<div class="col-lg-4">
            <div class="mb-3">
                <label for="pergenero" class="form-label">Genero</label>
                <select class="form-select" data-choices data-choices-search-false id="pergenero" wire:model.defer="familiar.genero" {{$eControl2}}>
                    <option value="M">Masculino</option>
                    <option value="F">Femenino</option>
                </select>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="mb-3">
                <label for="pernacionalidad" class="form-label">Nacionalidad</label>
                <select class="form-select" data-choices data-choices-search-false id="pernacionalidad" wire:model.defer="familiar.nacionalidad_id" {{$eControl2}}>
                    <option value="">Seleccione Nacionalidad</option>
                    @foreach ($tblgenerals as $general)
                        <option value="{{$general->id}}">{{$general->descripcion}}</option>
                    @endforeach
                </select>
            </div>
        </div>-->

        <div class="col-lg-2">
            <div class="mb-3">
                <label for="pertelefono" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="pertelefono"
                    placeholder="Ingrese número de teléfono" wire:model.defer="familiar.telefono" {{$eControl2}}>
            </div>
        </div>                                   
        

        <!--<div class="col-lg-4">
            <div class="mb-3">
                <label for="perrelacion" class="form-label">Relación</label>
                <select class="form-select" data-choices data-choices-search-false id="perrelacion" wire:model.defer="familiar.parentesco" {{$eControl2}}>
                    <option value="NN">Selecione Relacion</option>
                    <option value="MA">Madre</option>
                    <option value="PA">Padre</option>
                    <option value="AP">Apoderado</option>
                    <option value="OT">Otro</option>
                </select>
            </div>
        </div>-->
        <div class="col-xxl-6">
            <div class="mb-3">
                <label for="peremail" class="form-label">Email</label>
                <input type="email" class="form-control" id="peremail"
                    placeholder="Ingrese correo electrónico" wire:model.defer="familiar.email" {{$eControl2}}>
            </div>
        </div>
        <div class="col-xxl-7">
            <div class="mb-3">
                <label for="perdireccion" class="form-label">Dirección</label>
                <input type="text" class="form-control" id="perdireccion"
                    placeholder="Ingrese dirección" wire:model.defer="familiar.direccion" {{$eControl2}}>
            </div>
        </div>
    </div>
    <div class="card-body row">
        <div class="table-responsive table-card mb-3">
            <table class="table align-middle table-nowrap mb-0" id="customerTable">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Identificación</th>
                        <th scope="col">Apellidos</th>
                        <th scope="col">Nombres</th>
                        
                        <th scope="col">Email</th>
                        <th scope="col">Teléfono</th>
                        <th scope="col">Acción</th>
                    </tr>
                </thead>
                <tbody id="newlink">

                    @foreach ($familiares as $recno)  
                    <tr>
                        <td>{{$recno['identificacion']}}</td>
                        <td>{{$recno['apellidos']}}</td>
                        <td>{{$recno['nombres']}}</td>
                        <td>{{$recno['email']}}</td>
                        <td>{{$recno['telefono']}}</td>
                        <td>
                            <ul class="list-inline hstack gap-2 mb-0">
                                <li class="list-inline-item edit" data-bs-toggle="tooltip"
                                    data-bs-trigger="hover" data-bs-placement="top" title="Editar">
                                    <a href="" wire:click.prevent="editData({{$recno['id']}})">
                                        <i class="ri-pencil-fill fs-16"></i>
                                    </a>
                                </li>                                
                                <li class="list-inline-item" data-bs-toggle="tooltip"
                                    data-bs-trigger="hover" data-bs-placement="top" title="Eliminar">
                                    <a class="text-danger d-inline-block remove-item-btn"
                                        data-bs-toggle="modal" href="" wire:click.prevent="deleteData({{$recno['id']}})">
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
        @if ($this->error>0)
        <div class="alert alert-danger alert-dismissible alert-label-icon rounded-label fade show" role="alert">
            <i class="ri-error-warning-line label-icon"></i><strong>Error!</strong> - Existen Campo Vacios
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <div class="hstack gap-2 justify-content-end">
            <button type="button" wire:click="newData()" class="btn btn-soft-success" id="newfamily-btn" data-bs-target=""><i class="ri-add-fill me-1"></i>Nuevo</button>       
            <button type="button" class="btn btn-soft-primary" wire:click="createData()">Agregar</button>
            <!--@if ( $this->exists==false)
                <button type="submit" class="btn btn-soft-primary" wire:click="createData()">Grabar</button>
            @else 
                <button class="btn btn-soft-primary" wire:click="updateData()">Actualizar</button>
            @endif-->
        </div>
    </div>
</div>
