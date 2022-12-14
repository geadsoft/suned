<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="orderList">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Registration of Enrollments</h5>
                        <div class="flex-shrink-0">
                            <a class="btn btn-success add-btn" href="/academic/student-enrollment"><i
                            class="ri-add-line me-1 align-bottom"></i> Add Tuition</a>
                        </div>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form>
                        <div class="row g-3">
                            <div class="col-xxl-5 col-sm-6">
                                <div class="search-box">
                                    <input type="text" class="form-control search"
                                        placeholder="Search for name or surnames" wire:model="filters.srv_nombre">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <select class="form-select" name="cmbgrupo" wire:model="filters.srv_grupo">
                                        <option value="">Select Group</option>
                                        @foreach ($tblgenerals as $general)
                                            @if ($general->superior == 1)
                                            <option value="{{$general->id}}">{{$general->descripcion}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <select class="form-select" name="cmbnivel" wire:model="filters.srv_periodo">
                                        <option value="">Select Period</option>
                                        @foreach ($tblperiodos as $periodo)
                                            <option value="{{$periodo->id}}">{{$periodo->descripcion}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xxl-2 col-sm-4">
                                 <select class="form-select" name="cmbdato" wire:model="filterdata">
                                    <option value="M">Tuition</option>
                                    <option value="E">Student</option>
                                </select>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-1 col-sm-4">
                                <div>
                                    <button type="button" class="btn btn-primary w-100" wire:click="deleteFilters()"> <i
                                            class="ri-delete-bin-5-line me-1 align-bottom"></i>
                                        Filters
                                    </button>
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </form>
                </div>
                <div class="card-body pt-0">
                    <div>
                        <ul class="nav nav-tabs nav-tabs-custom nav-success mb-3" role="tablist">
                        </ul>

                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle" id="orderTable">
                                <thead class="text-muted table-light">
                                    <tr class="text-uppercase">
                                        <th class="sort" data-sort="id"> Identification</th>
                                        <th class="sort" data-sort="description">Nombres</th>
                                        @if ($filterdata=='M')
                                            <th class="sort" data-sort="modality">Document</th>
                                            <th class="sort" data-sort="level">Date Incripction</th>
                                            <th class="sort" data-sort="degree">Group</th>
                                            <th class="sort" data-sort="">Course</th>
                                            <th class="sort" data-sort="">Paralel</th>
                                        @endif
                                        <th class="sort" data-sort="">Action</th>
                                        
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                @foreach ($tblrecords as $record)    
                                    <tr>
                                        <td>{{$record->identificacion}}</td>
                                        <td>{{$record->apellidos}} {{$record->nombres}}</td> 
                                         @if ($filterdata=='M')
                                        <td>{{$record->documento}}</td> 
                                        <td> {{date('d/m/Y',strtotime($record->fecha))}}</td> 
                                        <td>{{$record->nomgrupo}}</td>
                                        <td>{{$record->nomgrado}}</td>
                                        <td>{{$record->paralelo}}</td>
                                        @endif
                                        <td>
                                            <ul class="list-inline hstack gap-2 mb-0">
                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ri-more-fill"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="/academic/student-enrollment/{{$record->identificacion}}"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i>Add Tuition</a></li>
                                                    <li><a class="dropdown-item" href="/academic/person-edit/{{$record->identificacion}}"><i class="ri-contacts-fill align-bottom me-2 text-muted"></i> Student Record </a></li>
                                                    <li><a class="dropdown-item" href=""><i class="ri-hand-coin-fill align-bottom me-2 text-muted"></i> Amounts Owed </a></li>

                                                    <li class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item remove-list" href="" data-bs-toggle="modal" data-bs-target="#removeItemModal">
                                                    <i class=" ri-coins-fill align-bottom me-2 text-muted"></i> Payment Details</a></li>
                                                </ul>
                                                <li class="list-inline-item" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                                    <a class="text-danger d-inline-block remove-item-btn"
                                                        data-bs-toggle="modal" href="">
                                                        <i class="ri-delete-bin-5-fill fs-16"></i>
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
                                        colors="primary:#405189,secondary:#0ab39c" style="width:75px;height:75px">
                                    </lord-icon>
                                    <h5 class="mt-2">Sorry! No Result Found</h5>
                                    <p class="text-muted">We've searched more than 150+ Orders We did
                                        not find any
                                        orders for you search.</p>
                                </div>
                            </div>
                        </div>
                        {{$tblrecords->links('')}}
                    </div>

                    <!--<div wire.ignore.self class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" >
                            <div class="modal-content modal-content border-0">
                                
                                <div class="modal-header p-3" style="background-color:#222454">
                                    <h5 class="modal-title" id="exampleModalLabel"  style="color: #D4D4DD">
                                        @if($showEditModal)
                                            <span>Edit Course &nbsp;</span>

                                            <span>Add Course  &nbsp;</span>
                                        @endif
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                                </div>
                                <form autocomplete="off" wire:submit.prevent="{{ $showEditModal ? 'updateData' : 'createData' }}">
                                    
                                    <div class="modal-body">
                                        <div class="id" id="modal-id">
                                            @if($showEditModal)
                                                <label for="record.id" class="form-label">ID</label>
                                                <input type="text" wire:model.defer="record.id" class="form-control" placeholder="ID" readonly />
                                            @endif
                                        </div>
                                        <div class="mb-3">
                                            <label for="txtnombre" class="form-label">Description</label>
                                            <input type="text" wire:model.defer="record.descripcion" class="form-control" name="txtnombre"
                                                placeholder="Enter name" required />
                                        </div>
                                        <div class="mb-3">
                                            <label for="cmbmodalidad" class="form-label">Cluster</label>
                                            <select type="select" class="form-select" data-trigger name="cmbmodalidad" wire:model.defer="record.modalidad_id" required>
                                            <option value=""></option>
                                            @foreach ($tblgenerals as $general)
                                                @if ($general->superior == 1)
                                                <option value="{{$general->id}}">{{$general->descripcion}}</option>
                                                @endif
                                            @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="cmbnivel" class="form-label">Level</label>
                                            <select type="select" class="form-select" data-trigger name="cmbnivel" wire:model.defer="record.nivel_id" required>
                                            <option value=""></option>
                                            @foreach ($tblgenerals as $general)
                                                @if ($general->superior == 2)
                                                <option value="{{$general->id}}">{{$general->descripcion}}</option>
                                                @endif
                                            @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="cmbgrado" class="form-label">Course</label>
                                            <select type="select" class="form-select" data-trigger name="cmbgrado" wire:model.defer="record.grado_id" required>
                                            <option value=""></option>
                                            @foreach ($tblgenerals as $general)
                                                @if ($general->superior == 3)
                                                <option value="{{$general->id}}">{{$general->descripcion}}</option>
                                                @endif
                                            @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="cmbespecialidad" class="form-label">Specialization</label>
                                            <select type="select" class="form-select" data-trigger name="cmbcmbespecialidad" wire:model.defer="record.especializacion_id" required>
                                            <option value=""></option>
                                            @foreach ($tblgenerals as $general)
                                                @if ($general->superior == 4)
                                                <option value="{{$general->id}}">{{$general->descripcion}}</option>
                                                @endif
                                            @endforeach
                                            </select>
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
                    </div>-->

                    <!-- Modal -->
                    <div wire.ignore.self class="modal fade flip" id="deleteOrder" tabindex="-1" aria-hidden="true" wire:model='selectId'>
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body p-5 text-center">
                                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                        colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px">
                                    </lord-icon>
                                    <div class="mt-4 text-center">
                                        <h4>You are about to delete the record ?</h4>
                                        <p class="text-muted fs-15 mb-4">Deleting the record will remove
                                            all of
                                            your information from our database.</p>
                                        <div class="hstack gap-2 justify-content-center remove">
                                            <button class="btn btn-link link-success fw-medium text-decoration-none"
                                                data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i>
                                                Close</button>
                                            <button class="btn btn-danger" id="delete-record"  wire:click="deleteData()"> Yes,
                                                Delete It</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--end modal -->
                </div>
            </div>

        </div>
        <!--end col-->
    </div>
    <!--end row-->

</div>

