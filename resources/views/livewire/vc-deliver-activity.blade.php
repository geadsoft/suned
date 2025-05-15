<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card mt-n4 mx-n4 mb-n5">
                <div class="bg-soft-warning">
                    <div class="card-body pb-4 mb-5">
                        <div class="row">
                            <div class="col-md">
                                <div class="row align-items-center">
                                    <div class="col-md-auto">
                                        <div class="avatar-md mb-md-0 mb-4">
                                            <div class="avatar-title bg-white rounded-circle">
                                                <img src="{{ URL::asset('assets/images/companies/img-4.png') }}" alt="" class="avatar-sm" />
                                            </div>
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-md">
                                        <h4 class="fw-semibold" id="ticket-title" >{{$record->nombre}}</h4>
                                        <div class="hstack gap-3 flex-wrap">
                                           
                                            <div class="vr"></div>
                                            <div class="text-muted">Fecha Registro: <span class="fw-medium " id="create-date">{{date('d/m/Y',strtotime($record->created_at))}}</span></div>
                                            <div class="vr"></div>
                                            <div class="text-muted">Fecha Vencimiento: <span class="fw-medium" id="due-date">{{date('d/m/Y',strtotime($record->fecha))}}</span></div>
                                            <div class="vr"></div>
                                        
                                        </div>
                                    </div><!--end col-->
                                </div><!--end row-->
                            </div><!--end col-->
                            
                        </div><!--end row-->
                    </div><!-- end card body -->
                </div>
            </div><!-- end card -->
        </div><!-- end col -->
    </div><!-- end row -->

    <div class="row">
        <div class="col-xxl-12">
            <div class="card">
                <div class="card-body p-4">
                    <h6 class="fw-semibold text-uppercase mb-3">Descripción</h6>
                    <!--<p class="text-muted">It would also help to know what the errors are - it could be something simple like a message saying delivery is not available which could be a problem with your shipping templates. Too much or too little spacing, as in the example below, can make things unpleasant for the reader. The goal is to make your text as comfortable to read as possible. On the note of consistency, color consistency is a MUST. If you’re not trying to create crazy contrast in your design, then a great idea would be for you to use a color palette throughout your entire design. It will subconsciously interest viewers and also is very pleasing to look at. <a href="javascript:void(0);" class="link-secondary text-decoration-underline">Example</a></p>
                    <h6 class="fw-semibold text-uppercase mb-3">Create an Excellent UI for a Dashboard</h6>
                    <ul class="text-muted vstack gap-2 mb-4">
                        <li>Pick a Dashboard Type</li>
                        <li>Categorize information when needed</li>
                        <li>Provide Context</li>
                        <li>On using colors</li>
                        <li>On using the right graphs</li>
                    </ul>-->
                    <!--<textarea id="editor">
                        <p class="text-muted" disabled>{{$texteditor}}</p>     
                    </textarea>-->
                    <div id="elemnt">
                    </div>
                    <div class="profile-timeline">
                        <div class="accordion accordion-flush" id="accordionFlushExample">
                        
                            <div class="accordion-item border-0">
                                <div class="accordion-header" id="headingOne">
                                    <a class="accordion-button p-2 shadow-none" data-bs-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 avatar-xs">
                                                <div class="avatar-title bg-light text-success rounded-circle">
                                                    <i class="ri-folder-2-line"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="fs-15 mb-0 fw-semibold">Order Placed - <span class="fw-normal"></span></h6>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body ms-2 ps-5 pt-0">
                                        <p class="text-muted">@lang('translation.'.(date('l',strtotime($record->fecha)))),
                                            {{date('d',strtotime($record->fecha))}} de @lang('months.'.(date('m',strtotime($record->fecha)))) del {{date('Y',strtotime($record->fecha))}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item border-0">
                                <div class="accordion-header" id="headingFive">
                                    <a class="accordion-button p-2 shadow-none" data-bs-toggle="collapse" href="#collapseFile" aria-expanded="false">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 avatar-xs">
                                                <div class="avatar-title bg-light text-success rounded-circle">
                                                    <i class="mdi mdi-package-variant"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="fs-14 mb-0 fw-semibold"></h6>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!--end accordion-->
                    </div>
                    <textarea id="editor" style="visibility:hidden;" wire:model="texteditor">   
                    </textarea>
                    <div class="mt-4" style="{{$display_estado}}">
                        <h6 class="fw-semibold text-uppercase mb-3">Estado de la Entrega</h6>
                        <div class="alert border-dashed alert-dark" role="alert">
                            <div class="table-responsive">
                                <table class="table mb-0 table-borderless">
                                    <tbody>
                                        <tr>
                                            <th style="width: 350px;"><span class="">Estado de la Entrega</span></th>
                                            <td>No Entregado</td>
                                            <td>.</td>
                                        </tr>
                                        <tr>
                                            <th><span class="">Estado de la Calificación</span></th>
                                            <td>No Calificado</td>
                                        </tr>
                                        <tr>
                                            <th><span class="">Fecha de Entrega</span></th>
                                            <td>@lang('translation.'.(date('l',strtotime($record->fecha)))),
                                            {{date('d',strtotime($record->fecha))}} de @lang('months.'.(date('m',strtotime($record->fecha)))) del {{date('Y',strtotime($record->fecha))}}</td>
                                        </tr>
                                        <tr>
                                            <th><span class="">Tiempo Restante</span></th>
                                            <td>.</td>
                                        </tr>
                                        <tr>
                                            <th><span class="">Ultima Modificación</span></th>
                                            <td>.</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary"><i class="ri-upload-2-line align-bottom me-1"></i>Agregar Entrega</button>
                    </div>
                </div><!--end card-body-->
                
                
                <!-- end card body -->
            </div><!--end card-->
            
        </div>


        <!--<div class="col-xxl-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Ticket Details</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table class="table table-borderless align-middle mb-0">
                            <tbody>
                                <tr>
                                    <td class="fw-medium">Ticket</td>
                                    <td>#VLZ<span id="t-no">135</span> </td>
                                </tr>
                                <tr>
                                    <td class="fw-medium">Client</td>
                                    <td id="t-client">Themesbrand</td>
                                </tr>
                                <tr>
                                    <td class="fw-medium">Project</td>
                                    <td>Velzon - Admin Dashboard</td>
                                </tr>
                                <tr>
                                    <td class="fw-medium">Assigned To:</td>
                                    <td>
                                        <div class="avatar-group">
                                            <a href="javascript:void(0);" class="avatar-group-item" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" data-bs-original-title="Erica Kernan">
                                                <img src="{{ URL::asset('assets/images/users/avatar-4.jpg') }}" alt="" class="rounded-circle avatar-xs" />
                                            </a>
                                            <a href="javascript:void(0);" class="avatar-group-item" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" data-bs-original-title="Alexis Clarke">
                                                <img src="{{ URL::asset('assets/images/users/avatar-10.jpg') }}" alt="" class="rounded-circle avatar-xs" />
                                            </a>
                                            <a href="javascript:void(0);" class="avatar-group-item" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" data-bs-original-title="James Price">
                                                <img src="{{ URL::asset('assets/images/users/avatar-3.jpg') }}" alt="" class="rounded-circle avatar-xs" />
                                            </a>
                                            <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" data-bs-original-title="Add Members">
                                                <div class="avatar-xs">
                                                    <div class="avatar-title fs-16 rounded-circle bg-light border-dashed border text-primary">
                                                        +
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-medium">Status:</td>
                                    <td>
                                        <select class="form-select" id="t-status" data-choices data-choices-search-false aria-label="Default select example">
                                            <option value>Stauts</option>
                                            <option value="New" selected>New</option>
                                            <option value="Open">Open</option>
                                            <option value="Inprogress">Inprogress</option>
                                            <option value="Closed">Closed</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-medium">Priority</td>
                                    <td>
                                        <span class="badge bg-danger" id="t-priority">High</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-medium">Create Date</td>
                                    <td id="c-date">20 Dec, 2021</td>
                                </tr>
                                <tr>
                                    <td class="fw-medium">Due Date</td>
                                    <td id="d-date">29 Dec, 2021</td>
                                </tr>
                                <tr>
                                    <td class="fw-medium">Last Activity</td>
                                    <td>14 min ago</td>
                                </tr>
                                <tr>
                                    <td class="fw-medium">Labels</td>
                                    <td class="hstack text-wrap gap-1">
                                        <span class="badge badge-soft-primary">Admin</span>
                                        <span class="badge badge-soft-primary">UI</span>
                                        <span class="badge badge-soft-primary">Dashboard</span>
                                        <span class="badge badge-soft-primary">Design</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title fw-semibold mb-0">Files Attachment</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center border border-dashed p-2 rounded">
                        <div class="flex-shrink-0 avatar-sm">
                            <div class="avatar-title bg-light rounded">
                                <i class="ri-file-zip-line fs-20 text-primary"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1"><a href="javascript:void(0);">Velzon-admin.zip</a></h6>
                            <small class="text-muted">3.2 MB</small>
                        </div>
                        <div class="hstack gap-3 fs-16">
                            <a href="javascript:void(0);" class="text-muted"><i class="ri-download-2-line"></i></a>
                            <a href="javascript:void(0);" class="text-muted"><i class="ri-delete-bin-line"></i></a>
                        </div>
                    </div>
                    <div class="d-flex  align-items-center border border-dashed p-2 rounded mt-2">
                        <div class="flex-shrink-0 avatar-sm">
                            <div class="avatar-title bg-light rounded">
                                <i class="ri-file-ppt-2-line fs-20 text-danger"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1"><a href="javascript:void(0);">Velzon-admin.ppt</a></h6>
                            <small class="text-muted">4.5 MB</small>
                        </div>
                        <div class="hstack gap-3 fs-16">
                            <a href="javascript:void(0);" class="text-muted"><i class="ri-download-2-line"></i></a>
                            <a href="javascript:void(0);" class="text-muted"><i class="ri-delete-bin-line"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>-->
    </div>
    

</div>
