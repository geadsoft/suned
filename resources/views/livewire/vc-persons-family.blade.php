<div>
    <div class="card-body row">
        <div class="col-lg-6">
            <div class="mb-3">
                <label for="pernombres" class="form-label">
                Nombre</label>
                <input type="text" class="form-control" id="txtpersonaid" wire:model.defer="persona_id" style="display:none">
                <input type="text" class="form-control" id="pernombres" placeholder="Enter your Names" wire:model.defer="familiar.nombres" {{$eControl2}}>
            </div>
        </div>
        
        <div class="col-lg-6">
            <div class="mb-3">
                <label for="perapellidos" class="form-label">Apellidos</label>
                <input type="text" class="form-control" id="perapellidos" placeholder="Enter your Surnames" wire:model.defer="familiar.apellidos" {{$eControl2}}>
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
        <div class="col-lg-6">
            <div class="mb-3">
                <label for="perident" class="form-label">
                Identificación</label>
                <input type="text" class="form-control" id="perident"
                    placeholder="Enter your firstname" wire:model.defer="familiar.identificacion" {{$eControl2}}>
            </div>
        </div>
        <div class="col-lg-4">
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
        </div>

        <div class="col-lg-4">
            <div class="mb-3">
                <label for="pertelefono" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="pertelefono"
                    placeholder="Enter your phone number" wire:model.defer="familiar.telefono" {{$eControl2}}>
            </div>
        </div>                                   
        

        <div class="col-lg-4">
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
        </div>
        <div class="row g-3">
            <div class="col-xxl-4">
                <div class="mb-3">
                    <label for="peremail" class="form-label">Email</label>
                    <input type="email" class="form-control" id="peremail"
                        placeholder="Enter Email" wire:model.defer="familiar.email" {{$eControl2}}>
                </div>
            </div>
            <div class="col-xxl-7">
                <div class="mb-3">
                    <label for="perdireccion" class="form-label">Dirección</label>
                    <input type="text" class="form-control" id="perdireccion"
                        placeholder="Enter Direction" wire:model.defer="familiar.direccion" {{$eControl2}}>
                </div>
            </div>
            <!--<div class="col-xxl-1">
                <div class="mb-3 text-center">
                    <label for="" class="form-label">-</label>
                    <div class="flex-shrink-0">
                        <button type="button" wire:click="activeControl()" class="btn btn-soft-success" id="newfamily-btn"
                            data-bs-target=""><i class="ri-add-fill me-1"></i> Nuevo
                            </button>
                    </div>
                </div>
            </div>
            <div class="col-xxl-1">
                <div class="mb-3 text-center">
                    <label for="" class="form-label">-</label>
                    <div class="flex-shrink-0">
                        <button type="button" wire:click="addFamiliar('A')" class="btn btn-soft-secondary" id="addfamily-btn"
                            data-bs-target="" {{$eControl2}}><i class="ri-add-fill me-1"></i> Agregar
                        </button>
                        <button type="button" wire:click="addFamiliar('U')" class="btn btn-soft-secondary" id="editfamily-btn" style="display:none"
                            data-bs-target="" {{$eControl2}}><i class="ri-add-fill me-1"></i> Editar
                        </button>
                    </div>
                </div>
            </div>-->
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
                        <th scope="col">Relación</th>
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
                        <td>{{$relacion[$recno['parentesco']]}}</td>
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
        <div class="hstack gap-2 justify-content-end">
            <button type="button" wire:click="newData()" class="btn btn-soft-success" id="newfamily-btn" data-bs-target=""><i class="ri-add-fill me-1"></i>Nuevo</button>       
            @if ($familiarId==0)
                <button type="submit" class="btn btn-soft-primary" wire:click="createData()">Grabar</button>
            @else 
                <button class="btn btn-soft-primary" wire:click="updateData()">Grabar</button>
            @endif
        </div>
    </div>
</div>
