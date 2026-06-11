<div>
    <div class="email-wrapper d-lg-flex gap-1 mx-n4 mt-n4 p-1">
        <div class="email-content">
            <div class="p-4 pb-0">
                <div class="border-bottom border-bottom-dashed">
                
                    <div class="row align-items-end mt-3">
                        <div class="col">
                            <div id="mail-filter-navlist">
                                <ul class="nav nav-tabs nav-tabs-custom nav-success gap-1 text-center border-bottom-0"
                                    role="tablist">
                                    <li class="nav-item">
                                        <button class="nav-link fw-semibold active" id="pills-primary-tab"
                                            data-bs-toggle="pill" data-bs-target="#pills-primary" type="button" role="tab"
                                            aria-controls="pills-primary" aria-selected="true">
                                            <i class="ri-mail-unread-line align-bottom d-inline-block"></i>
                                            <span class="ms-1 d-none d-sm-inline-block">Recibidos</span>
                                        </button>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="pills-primary" role="tabpanel"
                        aria-labelledby="pills-primary-tab">
                        <div class="message-list-content mx-n4 px-4 message-list-scroll" data-simplebar>
                            <div class="row">
                            <div class="{{$column}}">
                                <div class="table-responsive table-card mb-1 mt-2 ">
                                    <table class="table table-nowrap align-middle mb-0" id="orderTable">
                                        <tbody class="list form-check-all">
                                            @foreach($tblrecords as $key => $record)
                                            <tr tr class="border-bottom table-row" 
                                                style="cursor: pointer;" 
                                                wire:click="verMensaje({{ $record->id }})">
                                                <td style="width: 40px;">
                                                    <div class="form-check checkbox-wrapper-mail fs-14">
                                                        <input class="form-check-input" type="checkbox" id="checkbox-{{$key}}">
                                                        <button type="button" class="btn text-warning p-0 favourite-btn fs-15 ms-1">
                                                            <i class="ri-star-fill align-bottom"></i>
                                                        </button>
                                                    </div>
                                                </td>

                                                <td class="fw-semibold text-dark" style="width: 150px;">
                                                    {{$record->nombres}}
                                                </td>

                                                <td class="text-muted text-truncate" style="max-width: 700px;">
                                                    <span class="fw-semibold subject-title text-dark">{{$record->categoria}}</span>
                                                    <span> – </span>
                                                    <span class="teaser">{{$record->comentario}}</span>
                                                </td>

                                                <td class="text-end text-muted" style="width: 90px; white-space: nowrap;">
                                                    {{ \Carbon\Carbon::parse($record->created_at)->format('M j') }}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{$tblrecords->links('')}}
                                </div>
                            </div>
                            <div class="col-lg-4" style="{{$display}}">
                                <div class="email-detail-show">
                                    <div class="p-4 d-flex flex-column h-100">
                                        <div class="pb-4 border-bottom border-bottom-dashed">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="">
                                                        <button type="button" class="btn btn-soft-danger btn-icon btn-sm fs-16 close-btn-email" wire:click="Cerrar()">
                                                            <i class="ri-close-fill align-bottom"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="hstack gap-sm-1 align-items-center flex-wrap email-topbar-link">
                                                        <button class="btn btn-ghost-secondary btn-icon btn-sm fs-16" wire:click="Eliminar({{ $eliminarId }})">
                                                            <i class="ri-delete-bin-5-fill align-bottom"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mx-n4 px-4 email-detail-show-scroll">
                                            @if(!empty($mensaje))
                                            <div class="mt-4 mb-3">
                                                @if($mensaje->categoria=="S")
                                                <h5 class="fw-bold email-subject-title">Sugerencia</h5>
                                                @else
                                                <h5 class="fw-bold email-subject-title">Queja</h5>
                                                @endif 
                                            </div>
                                            <div class="accordion accordion-flush">
                                                <div class="accordion-item border-dashed left">
                                                    <div class="accordion-header">
                                                        <a role="button" class="btn w-100 text-start px-0 bg-transparent shadow-none collapsed"
                                                            data-bs-toggle="collapse" href="#email-collapseOne" aria-expanded="true"
                                                            aria-controls="email-collapseOne">
                                                            <div class="d-flex align-items-center text-muted">
                                                                <div class="flex-shrink-0 avatar-xs me-3">
                                                                    <img src="{{ URL::asset('assets/images/users/avatar-3.jpg') }}" alt=""
                                                                        class="img-fluid rounded-circle">
                                                                </div>
                                                                <div class="flex-grow-1 overflow-hidden">
                                                                    <h5 class="fs-14 text-truncate email-user-name mb-0">{{$mensaje->nombres}}</h5>
                                                                    
                                                                </div>
                                                                <div class="flex-shrink-0 align-self-start">
                                                                    <div class="text-muted fs-12">{{$mensaje->created_at}}</div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>

                                                    <!--<div id="email-collapseOne" class="accordion-collapse collapse">-->
                                                        <div class="accordion-body text-body px-0">
                                                            <div>
                                                                <p>{{$mensaje->comentario}}</p>
                                                            </div>
                                                            <div><i class="ri-phone-fill align-bottom fs-15"></i> {{$mensaje->telefono}}</div>
                                                            <div><i class="ri-mail-line align-bottom fs-15"></i> {{$mensaje->email}}</div>
                                                            <div><i class="ri-user-fill fs-15"></i> {{$mensaje->usuario}}</div>
                                                        </div>
                                                    <!--</div>-->
                                                </div>
                                                <!-- end accordion-item -->
                                            </div>
                                            @endif
                                            <!-- end accordion -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end email-content -->
    </div>
    <!-- end email wrapper -->

    
</div>
