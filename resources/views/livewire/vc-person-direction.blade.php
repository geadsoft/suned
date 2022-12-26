<div>
    <div class="tab-pane active" id="#add-direction" role="tabpanel">
        <div class="row mb-3">
            <div class="mb-3 col-lg-4">
                <input type="text" class="form-control" wire:model.defer="direction">
            </div>
             <div class="mb-3 col-sm-1">
                <select class="form-select" data-choices data-choices-search-false id="cmbdomingo" wire:model.defer="tipoident">
                    <option value=0>Libre</option>
                    <option value=1>Va</option>
                    <option value=2>Viene</option>
                    <option value=3>Va / Viene</option>
                </select>
            </div>
            <div class="mb-3 col-sm-1">
                <select class="form-select" data-choices data-choices-search-false id="cmblunes" wire:model.defer="tipoident">
                    <option value=0>Libre</option>
                    <option value=1>Va</option>
                    <option value=2>Viene</option>
                    <option value=3>Va / Viene</option>
                </select>
            </div>
            <div class="mb-3 col-sm-1">
                <select class="form-select" data-choices data-choices-search-false id="cmbmartes" wire:model.defer="tipoident">
                    <option value=0>Libre</option>
                    <option value=1>Va</option>
                    <option value=2>Viene</option>
                    <option value=3>Va / Viene</option>
                </select>
            </div>
            <div class="mb-3 col-sm-1">
                <select class="form-select" data-choices data-choices-search-false id="cmbmiercoles" wire:model.defer="tipoident">
                    <option value=0>Libre</option>
                    <option value=1>Va</option>
                    <option value=2>Viene</option>
                    <option value=3>Va / Viene</option>
                </select>
            </div>
            <div class="mb-3 col-sm-1">
                <select class="form-select" data-choices data-choices-search-false id="cmbjueves" wire:model.defer="tipoident">
                    <option value=0>Libre</option>
                    <option value=1>Va</option>
                    <option value=2>Viene</option>
                    <option value=3>Va / Viene</option>
                </select>
            </div>
            <div class="mb-3 col-sm-1">
                <select class="form-select" data-choices data-choices-search-false id="cmbviernes" wire:model.defer="tipoident">
                    <option value=0>Libre</option>
                    <option value=1>Va</option>
                    <option value=2>Viene</option>
                    <option value=3>Va / Viene</option>
                </select>
            </div>
            <div class="mb-3 col-sm-1">
                <select class="form-select" data-choices data-choices-search-false id="cmbsabado" wire:model.defer="tipoident">
                    <option value=0>Libre</option>
                    <option value=1>Va</option>
                    <option value=2>Viene</option>
                    <option value=3>Va / Viene</option>
                </select>
            </div>
            <div class="flex-shrink-0">
                <button type="button" wire:click="addDirections()" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn"
                    data-bs-target=""><i class="ri-add-line align-bottom me-1"></i> Create
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
                    @foreach ($tblrecords as $record)  
                    <tr>
                        <td>{{$record->direccion}}</td>
                        <td>{{$record->domingo}}</td>
                        <td>{{$record->lunes}}</td>
                        <td>{{$record->martes}}</td>
                        <td>{{$record->miercoles}}</td>
                        <td>{{$record->jueves}}</td>
                        <td>{{$record->viernes}}</td>
                        <td>
                            <ul class="list-inline hstack gap-2 mb-0">
                                <li class="list-inline-item edit" data-bs-toggle="tooltip"
                                    data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                    <a href="" wire:click.prevent="edit({{ $record }})">
                                        <i class="ri-pencil-fill fs-16"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item" data-bs-toggle="tooltip"
                                    data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                    <a class="text-danger d-inline-block remove-item-btn"
                                        data-bs-toggle="modal" href="" wire:click.prevent="delete({{ $record->id }})">
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
