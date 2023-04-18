<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <div class="flex-grow-1">
                            <button wire:click.prevent="add()" class="btn btn-info add-btn" data-bs-toggle="modal" data-bs-target=""><i
                                    class="ri-add-fill me-1 align-bottom"></i> Add Services Charges </button>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="hstack text-nowrap gap-2">
                                <button class="btn btn-soft-danger" onClick="deleteMultiple()"><i
                                        class="ri-delete-bin-2-line"></i></button>
                                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#addmembers"><i
                                        class="ri-filter-2-line me-1 align-bottom" enabled></i> Filters</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end col-->
        <div class="col-xxl-12">
            <div class="card" id="pensionlist">
                <div class="card-header">
                    <div class="row g-2">
                        <div class="col-md-auto ms-auto">
                            <!--<div class="d-flex align-items-center">
                                <span class="text-muted">Sort by: </span>
                                <select class="form-control mb-0" data-choices data-choices-search-false
                                    id="choices-single-default">
                                    <option value="Owner">Representante</option>
                                    <option value="Company">Compañia</option>
                                    <option value="location">Ubicación</option>
                                </select>
                            </div>-->
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div>
                        <div class="table-responsive table-card mb-3">
                            <table class="table align-middle table-nowrap mb-0" id="customerTable">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" style="width: 50px;">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="checkAll"
                                                    value="option">
                                            </div>
                                        </th>
                                        <th class="sort" data-sort="id" scope="col">ID</th>
                                        <th class="sort" data-sort="Descripcion" scope="col">Description</th>
                                        <th class="sort" data-sort="Descripcion" scope="col">Fecha</th>
                                        <th class="sort" data-sort="modalidad" scope="col">Modality</th>
                                        <th class="sort" data-sort="periodo" scope="col">Teaching Period</th>
                                        <th class="sort" data-sort="estado" scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @foreach ($tblrecords as $record) 
                                    <tr>
                                        <th scope="row">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="chk_child"
                                                    value="option1">
                                            </div>
                                        </th>
                                                                                          
                                        <td>{{$record->id}}</td>
                                        <td>{{$record->descripcion}}</td>
                                        <td>{{date('d/m/Y', strtotime($record->fecha))}}</td>  
                                        <td>{{$record->modalidad->descripcion}}</td> 
                                        <td>{{$record->periodo->periodo}}</td>
                                        <td class="status">
                                            <span class="badge badge-soft-success text-uppercase">@lang('status.'.($record->estado))</span></td>
                                        <td>
                                            <ul class="list-inline hstack gap-2 mb-0">
                                                
                                                <li class="list-inline-item" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="View">
                                                    <a href="" wire:click.prevent="view({{$record}})" class="view-item-btn"><i
                                                            class="ri-eye-fill align-bottom text-muted"></i></a>
                                                </li>
                                                <li class="list-inline-item" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                                    <a class="edit-item-btn" href="" wire:click.prevent="edit({{ $record }})" data-bs-toggle="modal"><i
                                                            class="ri-pencil-fill align-bottom text-muted"></i></a>
                                                </li>
                                                <li class="list-inline-item" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="Delete">
                                                    <a class="remove-item-btn" data-bs-toggle="modal"
                                                        href="" wire:click.prevent="delete({{ $record->id }})">
                                                        <i class="ri-delete-bin-fill align-bottom text-muted"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="noresult" style="display: none">
                                <div class="text-center">
                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                        colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px">
                                    </lord-icon>
                                    <h5 class="mt-2">Sorry! No Result Found</h5>
                                    <p class="text-muted mb-0">We've searched more than 150+ companies
                                        We did not find any
                                        companies for you search.</p>
                                </div>
                            </div>
                        </div>
                        {{$tblrecords->links('')}}
                    </div>
                    <div wire.ignore.self class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-xl">
                            <div class="modal-content border-0">
                                <div class="modal-header p-3" style="background-color:#222454">
                                    <h5 class="modal-title" style="color: #D4D4DD" id="exampleModalLabel" >
                                        @if($showEditModal)
                                            <span>Edit Services Charges  &nbsp;</span>
                                        @else
                                            <span>Add Services Charges  &nbsp;</span>
                                        @endif                                    
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                        id="close-modal"></button>
                                </div>
                                <form autocomplete="off" wire:submit.prevent="{{ $showEditModal ? 'updateData' : 'createData' }}">
                                    <div class="modal-body">
                                        <input type="hidden" id="id-field" />
                                        <div class="row g-3">
                                            <div class="col-lg-8" style="{{$visible}}">
                                                <div>
                                                    <label for="txtnombre"
                                                        class="form-label">Description</label>
                                                    <input type="text" wire:model.defer="record.descripcion" class="form-control"
                                                        placeholder="Enter your Description" required />
                                                </div>
                                            </div>
                                            <div class="col-lg-4" style="{{$visible}}">
                                                <div>
                                                    <label for="txtfecha"
                                                        class="form-label">Fecha</label>
                                                    <input type="date" id="fecha" class="form-control" wire:model.defer="record.fecha"
                                                        placeholder="Enter your Date" required />
                                                </div>
                                            </div>
                                            <div class="col-lg-4" style="{{$visible}}">
                                                <div>
                                                    <label for="cmbmodalidad" class="form-label">Modality of Study</label>
                                                    <select id="cmbmodalidad" type="select" class="form-select" data-trigger wire:model.defer="record.modalidad_id" required>    
                                                    <option value=""></option>
                                                    @foreach ($tblgenerals as $general)
                                                        @if ($general->superior == 1)
                                                        <option value="{{$general->id}}">{{$general->descripcion}}</option>
                                                        @endif
                                                    @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4" style="{{$visible}}">
                                                <div>
                                                    <label for="cmdperiodo" class="form-label">Lective Period</label>
                                                    <select type="select" class="form-select" data-trigger id="cmdperiodo" wire:model.defer="record.periodo_id" required>
                                                    <option value=""></option>
                                                    @foreach ($tblperiodos as $periodo)
                                                    <option value="{{$periodo->id}}">{{$periodo->periodo}}</option>
                                                    @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4" style="{{$visible}}">
                                                <div>
                                                    <label for="record.estado" class="form-label">Status</label>
                                                        <select class="form-control" data-trigger name="record.estado" wire:model.defer="record.estado">
                                                        <option value="A">Active</option>
                                                        <option value="I">Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div>
                                                    <table class="invoice-table table table-borderless table-nowrap mb-0" id="tblpension">
                                                        <thead class="align-middle">
                                                            <tr class="table-active">
                                                                <th scope="col" style="width: 65px;">ID</th>
                                                                <th scope="col">Nivel</th>
                                                                <th scope="col" class="text-center" colspan="2">Matrícula</th>
                                                                <th scope="col" class="text-end" style="width: 120px;">Pension</th>
                                                                <th scope="col" class="text-center" colspan="2">Plataforma</th>
                                                                <th scope="col" class="text-end" style="width: 120px;">Dcho. Grado</th>
                                                            </tr>
                                                            <tr class="table-active">
                                                                <th scope="col" class="text-end"></th>
                                                                <th scope="col" class="text-end"></th>
                                                                <th scope="col" class="text-end" style="width: 120px;">Antiguos</th>
                                                                <th scope="col" class="text-end" style="width: 120px;">Recientes</th>
                                                                <th scope="col" class="text-end"></th>
                                                                <th scope="col" class="text-end" style="width: 120px;">Español</th>
                                                                <th scope="col" class="text-end" style="width: 120px;">Ingles</th>
                                                                <th scope="col" class="text-end"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach ($tblvalores as $index => $valor)
                                            
                                                        <tr id="{{$count}}" class="product">
                                                            <td> 
                                                                <input type="text" class="form-control bg-light border-0 " id="nivel-{{$count}}" value = "{{$valor['nivel_id']}}"/>
                                                            </td>
                                                            <td> 
                                                                <input type="text" class="form-control bg-light border-0 " id="nombre-{{$count}}" value = "{{$valor['descripcion']}}"/>
                                                            </td>
                                                            <td> 
                                                                <input type="number" class="form-control product-price bg-light border-0 text-end" id="matricula-{{$count}}" step="0.01" placeholder="0.00" value="{{$valor['matricula']}}" />
                                                            </td>
                                                            <td> 
                                                                <input type="number" class="form-control product-price bg-light border-0 text-end" id="matricula-{{$count}}" step="0.01" placeholder="0.00" value="{{$valor['matricula2']}}" />
                                                            </td>
                                                            <td> 
                                                                <input type="number" class="form-control product-price bg-light border-0 text-end" id="pension-{{$count}}" step="0.01" placeholder="0.00" value="{{$valor['pension']}}" />
                                                            </td>
                                                            <td> 
                                                                <input type="number" class="form-control product-price bg-light border-0 text-end" id="eplataforma-{{$count}}" step="0.01" placeholder="0.00" value="{{$valor['eplataforma']}}" />
                                                            </td>
                                                            <td> 
                                                                <input type="number" class="form-control product-price bg-light border-0 text-end" id="iplataforma-{{$count}}" step="0.01" placeholder="0.00" value="{{$valor['iplataforma']}}" />
                                                            </td>
                                                            <td> 
                                                                <input type="number" class="form-control product-price bg-light border-0 text-end" id="dgrado-{{$count}}" step="0.01" placeholder="0.00" value="{{$valor['grado']}}" />
                                                            </td>
                                                            <!--<td> 
                                                                <ul class="list-inline hstack gap-2 mb-0 ">
                                                                    <li class="list-inline-item edit text-end" data-bs-toggle="tooltip"
                                                                        data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                                                        <a href="">
                                                                            <i class="ri-pencil-fill fs-16"></i>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </td>-->
                                                        </tr>
                                                        <script>
                                                            {{$count++}}
                                                        </script>
                                                       
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="hstack gap-2 justify-content-end">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-success" id="add-btn">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--end add modal-->

                    <div class="modal fade zoomIn" id="deleteData" tabindex="-1" aria-labelledby="deleteRecordLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                        id="btn-close"></button>
                                </div>
                                <div class="modal-body p-5 text-center">
                                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                        colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px">
                                    </lord-icon>
                                    <div class="mt-4 text-center">
                                        <h4 class="fs-semibold">You are about to delete of record ? {{ $selectId }} </h4>
                                        <p class="text-muted fs-14 mb-4 pt-1">Deleting the record, 
                                            removes all your information from our database..</p>
                                        <div class="hstack gap-2 justify-content-center remove">
                                            <button class="btn btn-link link-success fw-medium text-decoration-none"
                                                data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i>
                                                Close</button>
                                            <button class="btn btn-danger" id="delete-record" wire:click="deleteData()">Yes,
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
            <!--end card-->
        </div>
        <!--end col-->
    </div>
</div>

