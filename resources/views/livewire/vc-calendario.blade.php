<div>
    <div class="row">
        <div class="col-12">
            
            <div class="row">
                <div class="col-xl-3">
                    <div class="card card-h-100">
                        <div class="card-body">
                            <button class="btn btn-primary w-100" id="btn-new-event"><i
                                    class="mdi mdi-plus"></i> Crear Nuevo Evento</button>
                            <div id="external-events">
                                <br>
                                <p class="text-muted">Arrastra y suelta tu evento o haz clic en el calendario</p>
                                <div class="external-event bg-soft-success text-success" data-class="bg-soft-success">
                                    <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>Notificación
                                </div>
                                <div class="external-event bg-soft-info text-info" data-class="bg-soft-info">
                                    <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>Comunicado
                                </div>
                                <div class="external-event bg-soft-warning text-warning" data-class="bg-soft-warning">
                                    <i
                                        class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>Reunión
                                </div>
                                <div class="external-event bg-soft-danger text-danger" data-class="bg-soft-danger">
                                    <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>Examenes
                                </div>
                                <div class="external-event bg-soft-primary text-primary" data-class="bg-soft-primary">
                                    <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>General
                                </div>
                            </div>

                        </div>
                    </div>
                    <div>
                        <h5 class="mb-1">Próximos eventos</h5>
                        <p class="text-muted">No te pierdas los eventos programados</p>
                        <div class="pe-2 me-n1 mb-3" data-simplebar style="height: 400px">
                            <div id="upcoming-event-list"></div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body bg-soft-info">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i data-feather="calendar" class="text-info icon-dual-info"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="fs-15">¡Bienvenido a tu Calendario!</h6>
                                    <p class="text-muted mb-0">En caso de que el libro de aplicaciones aparezca aquí. Haga clic en un evento para ver los detalles y administrar el evento de los solicitantes.</p>
                                </div>
                            </div>
                        </div>
                    </div><!--end card-->
                </div> <!-- end col-->

                <div class="col-xl-9">
                    <body onload="loadCalendar({{$arrevent}})">
                    <div class="card card-h-100">
                        <div class="card-body" wire:ignore>
                            <div id="calendar"></div>
                        </div>
                    </div>
                    </body>
                </div><!-- end col -->
            </div><!--end row-->
            

            <div style='clear:both'></div>

            <!-- Add New Event MODAL -->
            <div wire.ignore.self class="modal fade" id="event-modal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl" id="long-modal">
                    <div class="modal-content border-0">
                        <div class="modal-header p-3 bg-soft-info">
                            <h5 class="modal-title" id="modal-title">Evento</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                        </div>
                        <div class="row">
                            <div class="col-xl-6" id="detail-col1">
                                <div class="modal-body p-4">
                                    <form autocomplete="off" wire:submit.prevent="{{ $showEditModal ? 'updateData' : 'createData' }}" class="needs-validation" name="event-form" id="form-event" novalidate>
                                        <div class="text-end">
                                            <a href="#" class="btn btn-sm btn-soft-primary" id="edit-event-btn" data-id="edit-event" onclick="editEvent(this)" role="button">Edit</a>
                                        </div>
                                        <div class="event-details">
                                            <div class="d-flex mb-2">
                                                <div class="flex-grow-1 d-flex align-items-center">
                                                    <div class="flex-shrink-0 me-3">
                                                        <i class="ri-calendar-event-line text-muted fs-16"></i>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="d-block fw-semibold mb-0" id="event-start-date-tag">{{$startdate}}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex mb-2">
                                                <div class="flex-grow-1 d-flex align-items-center">
                                                    <div class="flex-shrink-0 me-3">
                                                        <i class="ri-calendar-event-line text-muted fs-16"></i>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="d-block fw-semibold mb-0" id="event-end-date-tag">{{$enddate}}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--<div class="d-flex align-items-center mb-2">
                                                <div class="flex-shrink-0 me-3">
                                                    <i class="ri-time-line text-muted fs-16"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="d-block fw-semibold mb-0"><span id="event-timepicker1-tag"></span> - <span id="event-timepicker2-tag"></span></h6>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="flex-shrink-0 me-3">
                                                    <i class="ri-map-pin-line text-muted fs-16"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="d-block fw-semibold mb-0"> <span id="event-location-tag"></span></h6>
                                                </div>
                                            </div>-->
                                            <div class="d-flex mb-3">
                                                <div class="flex-shrink-0 me-3">
                                                    <i class="ri-discuss-line text-muted fs-16"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <p class="d-block text-muted mb-0" id="event-description-tag">{{$comentario}}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row event-form">
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label class="text">Actividad</label>
                                                    <select class="form-select d-none" name="actividad" id="event-category"  wire:model.defer="actividad"  required>
                                                        <option value="NO">Notificación</option>
                                                        <option value="CO">Comunicado</option>
                                                        <option value="RE">Reunión</option>
                                                        <option value="EX">Examenes</option>
                                                        <option value="GE">General</option>
                                                    </select>
                                                    <div class="invalid-feedback">Por favor seleccione una actividad de evento válida</div>
                                                </div>
                                            </div><!--end col-->
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label class="text">Nombre</label>
                                                    <input class="form-control d-none" placeholder="Enter event name" type="text" name="title" id="event-title" wire:model.defer="evento"  required/>
                                                    <div class="invalid-feedback">Por favor proporcione un nombre de evento válido</div>
                                                </div>
                                            </div><!--end col-->
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label class="text">Fecha Inicial</label>
                                                    <input type="date" class="form-control" id="event-start-date" placeholder="" wire:model.defer="startdate" required>
                                                </div>
                                            </div><!--end col-->
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label class="text">Fecha Final</label>
                                                    <input type="date" class="form-control" id="event-end-date" placeholder="" wire:model.defer="enddate" required>
                                                </div>
                                            </div><!--end col-->
                                            <input type="hidden" id="eventid" name="eventid" value="" />
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Description</label>
                                                    <textarea type="text" class="form-control" id="event-description" placeholder="Ingrese descripción del evento" wire:model.defer="comentario"></textarea>
                                                </div>
                                            </div><!--end col-->
                                        </div><!--end row-->
                                        <div class="hstack gap-2 justify-content-end">
                                            <button type="button" class="btn btn-soft-danger" id="btn-delete-event"><i class="ri-close-line align-bottom"></i> Eliminar</button>
                                            <button type="submit" class="btn btn-success" id="btn-save-event">Grabar</button>
                                        </div>
                                    </form>
                                </div>
                            </div> <!-- end modal-content-->
                            <div class="col-xl-6" id="detail-col2">
                                <div class="modal-body p-4">
                                    @livewire('vc-nivel-calendar')
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- end modal dialog-->
            </div> <!-- end modal-->
            <!-- end modal-->









        </div>
    </div> <!-- end row-->
</div>

