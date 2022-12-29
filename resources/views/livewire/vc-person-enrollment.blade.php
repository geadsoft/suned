<div>
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
                    <select class="form-select" wire:model="search_nui" wire:change="searchPerson('R')">
                        <option value="">Select Representative</option>
                        @foreach ($tblfamilys as $family)
                            <option value="{{$family->identificacion}}">{{$family->apellidos}} {{$family->nombres}}</option>
                        @endforeach
                    </select>
                    <!--<label for="" class="form-label fs-15 mt-2  me-5">NUI</label>
                    
                    <div class="form-check form-check-inline fs-15 mt-2">
                        <input class="form-check-input" type="radio" id="chkperson" wire:model="chkoption" value="si">
                        <script>
                            $chkoption="si";
                        </script>
                        <label for="inlineRadioOptions" class="form-label">SI</label>
                    </div>
                    <div class="form-check form-check-inline fs-15 mt-2">
                        <input class="form-check-input" type="radio" id="chkperson" wire:model="chkoption" value="no">
                        <script>
                            $chkoption="no";
                        </script>
                        <label for="inlineRadioOptions" class="form-label">NO</label>
                    </div>
                    <input type="text" class="form-control" id="txtnombres" placeholder="Enter your Numers" wire:model="search_nui">
                    <a id="btnstudents" class ="input-group-text btn btn-soft-info" wire:click="searchPerson('R')"><i class="ri-search-line me-1"></i>Search</a>-->
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
        <div class="card-body row" wire:model.defer="">
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="pernombres" class="form-label">
                    Names</label>
                    <input type="text" class="form-control" id="txtpersonaid" wire:model.defer="persona_id" style="display:none">
                    <input type="text" class="form-control" id="pernombres" placeholder="Enter your Names" wire:model.defer="nombres" required {{$eControl}}>
                </div>
            </div>
            <!--end col-->
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="perapellidos" class="form-label">Surnames</label>
                    <input type="text" class="form-control" id="perapellidos" placeholder="Enter your Surnames" wire:model.defer="apellidos" required {{$eControl}}>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="mb-3">
                    <label for="pertipoident" class="form-label">Type of identification</label>
                    <select class="form-select" data-choices data-choices-search-false id="pertipoident" wire:model.defer="tipoident" required {{$eControl}}>
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
                        placeholder="Enter your identificacion" wire:model.defer="identificacion" required {{$eControl}}>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="mb-3">
                    <label for="pergenero" class="form-label">Gender</label>
                    <select class="form-select" data-choices data-choices-search-false id="pergenero" wire:model.defer="genero" required {{$eControl}}>
                        <option value="M">Male</option>
                        <option value="F">Feminine</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="mb-3">
                    <label for="pernacionalidad" class="form-label">Nationality</label>
                    <select class="form-select" data-choices data-choices-search-false id="pernacionalidad" wire:model.defer="nacionalidad" require {{$eControl}}>
                        <option value="0">Select Nationality</option>
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
                        placeholder="Enter your phone number" wire:model.defer="telefono" required {{$eControl}}>
                </div>
            </div>
            
            <!--end col-->

            <div class="col-lg-4">
                <div class="mb-3">
                    <label for="perrelacion" class="form-label">Relation</label>
                    <select class="form-select" data-choices data-choices-search-false id="perrelacion" wire:model.defer="parentesco" required {{$eControl}}>
                        <option value="NN">Select Relation</option>
                        <option value="MA">Mother</option>
                        <option value="PA">Parent</option>
                        <option value="AP">Proxy</option>
                        <option value="OT">Other</option>
                    </select>
                </div>
            </div>
        </div>    

    </div>
    <div class="row">
        <!--<div class="card-header">
            <h5 class="card-title flex-grow-1 mb-0 text-primary"><i
                class="mdi mdi-phone-sync align-middle me-1 text-success"></i>
                Contact Details</h5>
        </div>-->
        <div class="card-body row">
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="peremail" class="form-label">Email
                        Address</label>
                    <input type="email" class="form-control" id="peremail"
                        placeholder="Enter your email" wire:model.defer="email" required {{$eControl}}>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="label" for="perdireccion">Address</label>
                    <input type="text" class="form-control" id="perdireccion"
                        placeholder="Enter your adress" wire:model.defer="direccion" required {{$eControl}}>
                </div>
            </div>
        </div>
    </div>
    <!--Residencia-->
    <!--<div class="row">
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
                    <label class="label" for="perdireccion">Address</label>
                    <input type="text" class="form-control" id="perdireccion"
                        placeholder="Enter your adress" wire:model.defer="direccion" required {{$eControl}}>
                </div>
            </div>
        </div>
    </div>-->
</div>
