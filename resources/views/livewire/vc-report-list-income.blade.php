<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="paymentList">
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form>
                        <div class="row g-3">
                            <div class="col-xxl-3 col-sm-4">
                                <div class="search-box">
                                    <input type="text" class="form-control search"
                                        placeholder="Buscar por Recibo" wire:model="filters.srv_nombre">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <select class="form-select" name="cmbperiodo" wire:model="filters.srv_periodo" id="cmbperiodo">
                                        <option value="">Select Period</option>
                                        @foreach ($tblperiodos as $periodo)
                                            <option value="{{$periodo->id}}">{{$periodo->descripcion}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                           <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <select class="form-select" name="cmbgrupo" wire:model="filters.srv_grupo" id="cmbgrupo">
                                        <option value="">Todos</option>
                                        @foreach ($tblgenerals as $general)
                                            @if ($general->superior == 1)
                                            <option value="{{$general->id}}">{{$general->descripcion}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xxl-3 col-sm-4">
                                <div>
                                    <select class="form-select" name="cmbcurso" wire:model="filters.srv_curso" id="cmbcurso">
                                        <option value="">Todos</option>
                                        @foreach ($tblcursos as $curso)
                                            <option value="{{$curso->id}}">{{$curso->servicio->descripcion}} {{$curso->paralelo}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-auto ms-auto">
                                <div class="form-check form-switch hstack text-nowrap gap-2">
                                    <input class="form-check-input" type="checkbox" role="switch" wire:model="estado">
                                    <label class="form-check-label" for="estado">Recibos anulados</label>
                                </div>
                            </div>
                            <div class="col-xxl-2 col-sm-4">
                                <div class="">
                                        <input type="date" class="form-control" id="fechaini" data-provider="flatpickr" data-date-format="d-m-Y" data-time="true" wire:model="filters.srv_fechaini"> 
                                </div>
                            </div>
                            <div class="col-xxl-2 col-sm-4">
                                <div class="">
                                        <input type="date" class="form-control" id="fechafin" data-provider="flatpickr" data-date-format="d-m-Y" data-time="true" wire:model="filters.srv_fechafin"> 
                                </div>
                            </div>
                            <div class="col-xxl-1 col-sm-4">
                                <div>
                                    <button type="button" class="btn btn-primary w-100" wire:click="deleteFilters()"> <i
                                            class="ri-delete-bin-5-line me-1 align-bottom"></i>
                                        Filters
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-auto ms-auto">
                                <div class="hstack text-nowrap gap-2">
                                    <!--<a href="/download-pdf/cobros/{{$datos}}" class="btn btn-success"><i class="ri-download-2-line align-bottom me-1"></i>Download PDF</a>
                                    <a href="/preview-pdf/cobros/{{$datos}}" class="btn btn-danger" target="_blank"><i class="ri-printer-fill align-bottom me-1"></i> Print</a>
                                    <a class="btn btn-info add-btn" href="/financial/encashment-add"><i class="ri-add-fill me-1 align-bottom"></i> New Record</a>-->
                                </div>
                            </div>
                            
                            
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
                                        <th class="sort" data-sort="">Receipt</th>
                                        <th class="sort" data-sort="">Date</th>
                                        <th class="sort" data-sort="">Student</th>
                                        <th class="sort" data-sort="">Description</th>
                                        <th class="sort" data-sort="">Amount</th>
                                        <th class="sort" data-sort="">Estatus</th>
                                        <th class="sort" data-sort="">User</th>
                                        <th class="sort" data-sort="">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                @foreach ($tblrecords as $record)    
                                    <tr>
                                        <td>{{$record->documento}}</td>
                                        <td>{{date('d/m/Y',strtotime($record->fecha))}}</td>
                                        <td>{{$record->apellidos}} {{$record->nombres}}</td> 
                                        <td>{{$record->descripcion}} {{$record->paralelo}}</td> 
                                        <td>{{number_format($record->monto,2)}}</td>
                                        <td>
                                            @if($record->estado = 'P')
                                                <span class="badge badge-soft-success text-uppercase">Procesado</span>
                                            @else
                                                <span class="badge badge-soft-danger text-uppercase">Anulado</span>
                                            @endif
                                        </td>
                                        <td>{{$record->usuario}}</td>
                                        <td>
                                            <ul class="list-inline hstack gap-2 mb-0">
                                                <li class="list-inline-item" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="View">
                                                    <a href="/financial/encashment/{{$record->id}}" class="view-item-btn"><i
                                                            class="ri-eye-fill align-bottom text-muted"></i></a>
                                                </li>
                                                <li class="list-inline-item" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="Print">
                                                    <a class="edit-item-btn" href="/preview-pdf/comprobante/{{$record->id}}"><i
                                                            class="ri-printer-fill align-bottom text-muted"></i></a>
                                                </li>
                                                <li class="list-inline-item" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="Download">
                                                    <a class="edit-item-btn" href="/download-pdf/comprobante/{{$record->id}}"><i
                                                            class="ri-file-download-fill align-bottom text-muted"></i></a>
                                                </li>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item view-item-btn"
                                                            href=""><i
                                                                class="ri-todo-line align-bottom me-2 text-muted fs-16"></i>
                                                            Informe Estudiantil</a></li>
                                                    <li><a class="dropdown-item edit-item-btn"
                                                            href=""
                                                            data-bs-toggle="modal"><i
                                                                class=" ri-star-half-line align-bottom me-2 text-muted fs-16"></i>
                                                            Libreta Calificaciones</a></li>
                                                    <li>
                                                        <a class="dropdown-item remove-item-btn"
                                                            data-bs-toggle="modal"
                                                            href="" wire:click.prevent="delete({{ $record->estudiante_id }})">
                                                            <i class="ri-user-unfollow-line align-bottom me-2 text-muted fs-16"></i>
                                                            Retirar Estudiante
                                                        </a>
                                                    </li>
                                                </ul>
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
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
