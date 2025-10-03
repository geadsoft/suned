<div>
    <div class="row">
        <div class="col-xxl-3 col-sm-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="fw-medium text-muted mb-0">Faltas</p>
                            <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value" data-target="">{{$faltas}}</span>
                            </h2>
                            <!--<p class="mb-0 text-muted"><span class="badge bg-light text-success mb-0">
                                    <i class="ri-arrow-up-line align-middle"></i> 17.32 %
                                </span> vs. previous month</p>-->
                        </div>
                        <div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-soft-info text-info rounded-circle fs-4">
                                    <i class="ri-user-unfollow-line"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div> <!-- end card-->
        </div>
        <!--end col-->
        <div class="col-xxl-3 col-sm-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="fw-medium text-muted mb-0">Faltas Justificadas</p>
                            <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value"
                                    data-target="">{{$faltasJus}}</span></h2>
                            <!--<p class="mb-0 text-muted"><span class="badge bg-light text-danger mb-0">
                                    <i class="ri-arrow-down-line align-middle"></i> 0.96 %
                                </span> vs. previous month</p>-->
                        </div>
                        <div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-soft-info text-info rounded-circle fs-4">
                                    <i class=" ri-user-follow-line"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div>
        </div>
        <!--end col-->
        <div class="col-xxl-3 col-sm-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="fw-medium text-muted mb-0">Atrasos</p>
                            <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value"
                                    data-target="">{{$atraso}}</span></h2>
                            <!--<p class="mb-0 text-muted"><span class="badge bg-light text-danger mb-0">
                                    <i class="ri-arrow-down-line align-middle"></i> 3.87 %
                                </span> vs. previous month</p>-->
                        </div>
                        <div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-soft-info text-info rounded-circle fs-4">
                                    <i class="ri-alarm-line"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div>
        </div>
        <!--end col-->
        <div class="col-xxl-3 col-sm-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="fw-medium text-muted mb-0">Atrasos Justificados</p>
                            <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value"
                                    data-target="">{{$atrasoJus}}</span></h2>
                            <!--<p class="mb-0 text-muted"><span class="badge bg-light text-success mb-0">
                                    <i class="ri-arrow-up-line align-middle"></i> 1.09 %
                                </span> vs. previous month</p>-->
                        </div>
                        <div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-soft-info text-info rounded-circle fs-4">
                                    <i class="ri-timer-flash-line"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div>
        </div>
        <!--end col-->
    </div>
    <!--end row-->
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="orderList">
                <ul class="nav nav-tabs nav-tabs-custom nav-success mb-3" role="tablist">
                    @foreach ($tbltermino as $termino)
                    <li class="nav-item">
                        <a class="nav-link All py-3 {{ $this->tabactive == $termino->codigo ? 'active' : '' }}" 
                        data-bs-toggle="tab" 
                        role="tab"
                        aria-selected="{{ $this->tabactive == $termino->codigo ? 'true' : 'false' }}"
                        wire:click="filtrar('{{ $termino->codigo }}')"> {{ $termino->descripcion }}
                        </a>
                    </li>
                    @endforeach
                </ul>
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Faltas y Atrasos</h5>
                        <!--<div class="flex-shrink-0">
                            <a class="btn btn-success add-btn" href="/activities/activity-add"><i
                            class="ri-add-line align-bottom me-1"></i>Crear Actividad</a>
                        </div>-->
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form>
                    </form>
                </div>
                <div class="card-body pt-0">
                    <div>
                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle" id="orderTable">
                                <thead class="text-muted table-light">
                                    <tr class="text-uppercase">
                                        <th>Mes</th>
                                        <th>Fecha</th>
                                        <th class="text-center">Falta</th>
                                        <th class="text-center">Atraso</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                @foreach ($tblrecords as $record)
                                    <tr>
                                        <td>@lang('months.'.(date('m',strtotime($record['fecha'])))) </td>
                                        <td>@lang('translation.'.(date('l',strtotime($record['fecha'])))) {{date('d/m/Y',strtotime($record['fecha']))}}</td>
                                        <td class="text-center">
                                            @if ($record['valor'] == "F")
                                                <i class="ri-close-circle-fill fs-18 text-danger"></i> 
                                            @endif
                                            @if ($record['valor'] == "FJ")
                                                <i class="ri-checkbox-circle-fill fs-18 text-success"></i> 
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($record['valor'] == "A")
                                                <i class="ri-close-circle-fill fs-18 text-danger"></i> 
                                            @endif
                                            @if ($record['valor'] == "AJ")
                                                <i class="ri-checkbox-circle-fill fs-18 text-success"></i> 
                                            @endif
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

