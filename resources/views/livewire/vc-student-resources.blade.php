<div>
    
    <div class="chat-wrapper d-lg-flex gap-1 mx-n4 mt-n4 p-1">
        
        <div class="chat-leftsidebar">
            <div class="chat-room-list" data-simplebar>
                <div class="p-3 d-flex flex-column h-100">
                    <div class="mb-3">
                        <h5 class="mb-0 fw-semibold">Asignaturas</h5>
                    </div>
                    <div class="mt-3 mx-n4 px-4 file-menu-sidebar-scroll simplebar-scrollable-y" data-simplebar="init"><div class="simplebar-wrapper" style="margin: 0px -24px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: 0px; bottom: 0px;"><div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: 100%; overflow: hidden scroll;"><div class="simplebar-content" style="padding: 0px 24px;">
                        <ul class="list-unstyled file-manager-menu">
                            <li>
                                <a href="#" wire:click.prevent ="asignatura('')"><i class=" ri-arrow-right-s-fill align-bottom me-2"></i> <span class="file-list-link">TODAS</span></a>
                            </li>
                            @foreach($materias as $materia)
                            <li>
                                <a href="#" wire:click.prevent="asignatura({{$materia->asignatura_id}})"><i class=" ri-arrow-right-s-fill align-bottom me-2"></i> <span class="file-list-link">{{$materia->asignatura}}</span></a>
                            </li>
                            @endforeach
                        </ul>
                    </div></div></div></div><div class="simplebar-placeholder" style="width: 316px; height: 333px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="width: 0px; display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 170px; display: block; transform: translate3d(0px, 0px, 0px);"></div></div></div>
                </div>
            </div>

        </div>
        <!-- end chat leftsidebar -->
        <!-- Start User chat -->
        <div class="file-manager-content w-100 pb-0">

            <div class="chat-content d-lg-flex">
                <!-- start chat conversation section -->
                <div class="w-100 overflow-hidden position-relative">
                    
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card" id="orderList">
                                <div class="card-header border-0 mb-3">
                                    <div class="d-flex align-items-center">
                                        <h5 class="card-title mb-0 flex-grow-1">Mis Recursos - {{$asignatura}}</h5>
                                        <div class="flex-shrink-0">
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    <div>
                                        

                                        <div class="table-responsive table-card mb-1">
                                            <table class="table table-nowrap align-middle" id="orderTable">
                                                <thead class="text-muted table-light">
                                                    <tr class="text-uppercase">
                                                        <th class="sort" data-sort="id">Nombre</th>
                                                        <th class="sort" data-sort="customer_name">Asignatura</th>
                                                        <th class="sort" data-sort="amount">Estado</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="list form-check-all">
                                                    @foreach($tblrecords as $record)
                                                    <tr>
                                                        <td class="id">
                                                            <a href="#" class="fw-medium link-primary" wire:click.prevent="mostrar({{$record->id}})">
                                                                <span class="badge badge-soft-info text-uppercase"> {{$record->nombre}}
                                                            </a>                                      
                                                        </td>
                                                        <td class="id">
                                                            <div>
                                                            <i class=" ri-honour-line fs-18"></i><a class="text-muted"> {{$record->asignatura}} </a>
                                                            </div>  
                                                            <div>
                                                            <i class="las la-user-check fs-18"></i><a class="text-muted"> {{$record->apellidos}} {{$record->nombres}} </a>
                                                            </div>                                        
                                                        </td>
                                                        <td class="status"><span class="badge badge-soft-success text-uppercase">@lang('status.'.($record->estado))</span></td>
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
            </div>
        </div>
    </div>
    <!-- end chat-wrapper -->

    
</div>
