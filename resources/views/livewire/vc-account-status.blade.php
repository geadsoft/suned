<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="orderList">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Registros de Matrículas</h5>
                        
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
                            <!--end col-->
                            <div class="col-xxl-1 col-sm-4">
                                <div>
                                    <button type="button" class="btn btn-primary w-100" wire:click="deleteFilters()"> <i
                                            class="ri-equalizer-fill me-1 align-bottom"></i>
                                        Todos
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
                                        <th class="sort" data-sort="modality">Document</th>
                                        <th class="sort" data-sort="level">Date Incripction</th>
                                        <th class="sort" data-sort="degree">Group</th>
                                        <th class="sort" data-sort="">Period</th>
                                        <th class="sort" data-sort="">Course</th>
                                        <th class="sort" data-sort="">Paralel</th>
                                        <th class="sort" data-sort="">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                @foreach ($tblrecords as $record)    
                                    <tr>
                                        <td>{{$record->identificacion}}</td>
                                        <td>{{$record->apellidos}} {{$record->nombres}}</td> 
                                        <td>{{$record->documento}}</td> 
                                        <td> {{date('d/m/Y',strtotime($record->fecha))}}</td> 
                                        <td>{{$record->nomgrupo}}</td>
                                        <td>{{$record->nomperiodo}}</td>
                                        <td>{{$record->nomgrado}}</td>
                                        <td>{{$record->paralelo}}</td>
                                        <td>
                                            <ul class="list-inline hstack gap-2 mb-0">
                                                <li class="list-inline-item" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="Imprimir">
                                                <a href="/preview-pdf/account-status/{{$record->id}}" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle dropdown" target="_blank"><i class="ri-printer-fill align-bottom me-1 fs-16"></i></a>
                                                </li>
                                                <li class="list-inline-item" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="Descargar">
                                                    <a class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle dropdown"
                                                        data-bs-toggle="modal" href="">
                                                        <i class="ri-download-2-line fs-16"></i>
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
                    
                </div>
            </div>

        </div>
        <!--end col-->
    </div>
    <!--end row-->

</div>
