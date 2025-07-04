<div>
    <form id="deliver-form">
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
                                                <img src="{{ URL::asset('assets/images/svg/crypto-icons/apex.svg') }}" alt="" class="avatar-sm" />
                                            </div>
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-md">
                                        <h4 class="fw-semibold" id="ticket-title" >{{$record->asignatura}}</h4>
                                        <h5 class="fw-semibold" id="ticket-title" >{{$record->nombre}}</h5>
                                        <div class="hstack gap-3 flex-wrap">
                                           
                                            <div class="vr"></div>
                                            <div class="text-muted">Fecha Registro: <span class="fw-medium " id="create-date">{{date('d/m/Y',strtotime($record->created_at))}}</span></div>
                                            <div class="vr"></div>
                                            <div class="text-muted">Fecha Maxima Entrega: <span class="fw-medium" id="due-date">{{date('d/m/Y H:i:s',strtotime($record->fecha))}}</span></div>
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
                    <h6 class="card fw-semibold text-uppercase mb-3">Descripción</h6>
                    <body onload="addElement({{$descripcion}})">
                        <div id="elemnt" wire:ignore>
                        </div>
                    </body>
                    @if ($record->enlace<>'')
                    <h6 class="card fw-semibold text-uppercase mb-3">Link</h6>
                    <div class="d-flex mb-3">
                        <div class="flex-grow-1 ms-3">
                            <p class="text-muted mb-2">{{$record->enlace}}</p>
                        </div>
                        <div>
                            <a href="{{$record->enlace}}" class="badge bg-primary-subtle text-primary" target="_blank" src="about:blank">Abri Enlace<i class="ri-arrow-right-up-line align-bottom"></i></a>
                        </div>
                    </div>
                    @endif
                    <div class="card">
                        <h6 class="card fw-semibold text-uppercase">Archivos Adjunto</h6>
                        <div class="card-body">
                            @foreach($adjuntos as $file)
                                <div class="d-flex align-items-center border border-dashed p-2 rounded">
                                    
                                    <div class="flex-shrink-0 avatar-sm">
                                        <div class="avatar-title bg-light rounded">
                                            <i class="{{$arrdoc[$file->extension]}} fs-20 {{$arrcolor[$file->extension]}}"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1">
                                            <!--<a href="{{ route('archivo.descargar', ['id' => $file->id]) }}" target="_blank">
                                                {{$file->nombre}}
                                            </a>-->
                                            <a href="{{ route('archivo.descargar', ['id' => $file->id]) }}" download> {{$file->nombre}}</a>
                                        </h6>
                                        <small class="text-muted">@lang('translation.'.(date('l',strtotime($record->fecha)))),
                                                {{date('d',strtotime($record->fecha))}} de @lang('months.'.(date('m',strtotime($record->fecha)))) del {{date('Y',strtotime($record->fecha))}}</small>
                                    </div>
                                    <!--<div class="hstack gap-3 fs-16">
                                        <a type="button" class="text-muted" wire:click='download_drive({{$file->id}})'><i class="ri-download-2-line"></i></a>
                                    </div>-->
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @if($record->subir_archivo=='SI')
                    <div class="mt-4" style="{{$display_estado}}">
                        <h6 class="fw-semibold text-uppercase mb-3">Estado de la Entrega</h6>
                        <div class="alert border-dashed alert-dark" role="alert">
                            <div class="table-responsive">
                                <table class="table mb-0 table-borderless">
                                    <tbody>
                                        @if($estado=="No Entregado")
                                        <tr>
                                            <th style="width: 350px;"><span class="">Estado de la Entrega</span></th>
                                            <td>{{$estado}}</td>
                                            <td>.</td>
                                        </tr>
                                        @else
                                        <tr class="alert-success">
                                            <th style="width: 350px;"><span class="">Estado de la Entrega</span></th>
                                            <td>{{$estado}}</td>
                                            <td>.</td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <th><span class="">Estado de la Calificación</span></th>
                                            <td>No Calificado</td>
                                        </tr>
                                        <tr>
                                            <th><span class="">Fecha de Entrega</span></th>
                                            <td>@lang('translation.'.(date('l',strtotime($record->fecha)))),
                                            {{date('d',strtotime($record->fecha))}} de @lang('months.'.(date('m',strtotime($record->fecha)))) del {{date('Y',strtotime($record->fecha))}}
                                            {{date('H:i',strtotime($record->fecha))}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th><span class="">Tiempo Restante</span></th>
                                            <td>{{$tiempo}}</td>
                                        </tr>
                                        <tr>
                                            <th><span class="">Ultima Modificación</span></th>
                                            @if (empty($entrega))
                                                <td>-</td>
                                            @else
                                            <td>@lang('translation.'.(date('l',strtotime($record->fecha_entrega)))),
                                            {{date('d',strtotime($entrega->fecha))}} de @lang('months.'.(date('m',strtotime($entrega->fecha)))) del {{date('Y',strtotime($entrega->fecha))}}
                                            {{date('H:i',strtotime($entrega->fecha))}}
                                            @endif
                                            </td>
                                        </tr>
                                        @if (!empty($entrega))
                                            <th><span class="">Archivos Enviados</span></th>
                                            <td>
                                                <div class="profile-timeline">
                                                    <div class="accordion accordion-flush" id="accordionFlushExample">
                                                        <div class="accordion-item border-0">
                                                            <div class="accordion-header" id="headingOne">
                                                                <a class="accordion-button p-2 shadow-none" data-bs-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="flex-shrink-0 avatar-xs">
                                                                            <div class="avatar-title bg-success rounded-circle">
                                                                                <i class="ri-folder-5-line"></i>
                                                                            </div>
                                                                        </div>
                                                                        <div class="flex-grow-1 ms-3">
                                                                            <h6 class="fs-15 mb-0 fw-semibold"></span></h6>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        @foreach($files as $file)
                                                    
                                               
                                                        <div class="accordion-item border-0">
                                                            <div class="accordion-header" id="headingFive">
                                                                <a class="accordion-button p-2 shadow-none" data-bs-toggle="collapse" href="#collapseFile" aria-expanded="false">
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="flex-shrink-0 avatar-xs">
                                                                            <div class="avatar-title bg-light {{$arrcolor[$file->extension]}} rounded-circle fs-15">
                                                                                <i class="{{$arrdoc[$file->extension]}}"></i>
                                                                            </div>
                                                                        </div>
                                                                        <div class="flex-grow-1 ms-3">
                                                                            <h6 class="fs-14 mb-0 fw-semibold">{{$file->nombre}}</h6>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </div>
                                                         @endforeach
                                                    </div>
                                                    <!--end accordion-->
                                                </div>
                                            </td>
                                        @endif
                                        <tr>
                                            <th><span class="">Comentario de la Entrega</span></th>
                                            @if (!empty($entrega))
                                            <td>{{ strip_tags(str_replace('</p>', "\n", $entrega->comentario)) }}</td>
                                            @endif
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="row mb-3">
                        <div class="col-xl-3"> 
                            @if($display_estado<>"") 
                            <span class="">Texto en Linea</span>
                            @endif
                        </div>
                        <div class="col-xl-9"> 
                            <div id="editorContainer" style="display: none;" wire:ignore>
                                <textarea id="editor" wire:model="texteditor"></textarea>
                            </div>
                        </div>
                    </div>
                     @if($display_estado<>"") 
                    <div class="row mb-3">
                        <div class="col-xl-3"> 
                            <span class="">Archivos Enviados</span>
                        </div>
                        <div class="col-xl-9 "> 
                            
                            <div class="mt-4 mt-md-0 text-end">
                                <div class="flex-shrink-0">
                                    <button type="button" class="btn btn-soft-info btn-sm" wire:click="attach_add()">
                                    <i class=" ri-add-circle-line me-1 align-bottom"></i>Agregar Archivo</button>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="row mb-3">
                        <div class="col-xl-3"> 
                            <span class=""></span>
                        </div>
                        <div class="col-xl-9"> 
                            <div class="table-responsive table-card mb-1">
                                <table class="table table-nowrap align-middle" id="orderTable">
                                    <tbody>
                                    @foreach ($array_attach as $key => $recno) 
                                    <tr class="det-{{$recno['linea']}}">
                                    @if ($recno['drive_id']!="")
                                    <td>
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon3">Archivo</span>
                                            <input type="text" id="file-{{$recno['linea']}}" wire:model.prevent="array_attach.{{$key}}.adjunto" class="form-control">
                                            <!--<a href="" id="drive-{{$recno['linea']}}" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" wire:click="download()"><i class="ri-download-2-line fs-18"></i></a>
                                            <a id="btnadd-{{$recno['linea']}}" class ="btn btn-icon btn-topbar btn-ghost-success rounded-circle" wire:click="attach_add()"><i class="text-secondaryimary ri-add-fill fs-18"></i></a>-->
                                            <a id="btndel-{{$recno['linea']}}" class ="btn btn-icon btn-topbar btn-ghost-danger rounded-circle" wire:click="attach_del({{$recno['linea']}})"><i class="text-danger ri-delete-bin-5-line fs-18"></i></a>
                                        </div>
                                    </td>
                                    @else
                                    <td>
                                        <div class="input-group">
                                        <input type="file" id="file-{{$recno['linea']}}" wire:model.prevent="array_attach.{{$key}}.adjunto"  accept=".doc,.docx,.xls,.xlsx,.ppt,.pptx,.pdf,.html,.jpg,.png" class="form-control">
                                        <!--<a id="btnadd-{{$recno['linea']}}" class ="btn" wire:click="attach_add()"><i class="text-secondaryimary ri-add-fill fs-16"></i></a>
                                        <a id="btndel-{{$recno['linea']}}" class ="btn" wire:click="attach_del({{$recno['linea']}})"><i class="text-danger ri-subtract-line fs-16"></i></a>-->
                                        </div>
                                        <div wire:loading wire:target="array_attach.{{$key}}.adjunto" class="text-danger">
                                            Cargando archivo...
                                        </div>
                                    </td>
                                    @endif
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="hstack gap-2 d-print-none mt-4">
                                <button type="button" class="btn btn-soft-success" wire:click="createData()"><i class="ri-send-plane-fill align-bottom me-1"></i>Enviar</button>
                                <button type="button" class="btn btn-soft-primary" wire:click="cancel()"><i class="align-bottom me-1"></i>Cancelar</button>
                            </div>
                            
                        </div>
                    </div>
                    @endif 
                    @if($record->subir_archivo=='SI')     
                    <div class="text-center" style="{{$display_estado}}">
                        @if (empty($entrega))
                        <button type="button" class="btn btn-primary" id="btnentrega" wire:click='entrega' ><i class="ri-upload-2-line align-bottom me-1"></i>Agregar Entrega</button>
                        @else
                        <button type="button" class="btn btn-primary" id="btnentrega" wire:click='entrega' ><i class="ri-edit-2-fill align-bottom me-1"></i>Editar Entrega</button>
                        @endif
                        <button type="button" class="btn btn-soft-primary" wire:click="retornar()"><i class="align-bottom me-1"></i>Cancelar</button>
                    </div>
                    @else
                        <div class="text-center" style="{{$display_estado}}">
                            <a type="button" href="/student/activities" class="btn btn-soft-info btn-label previestab"
                    data-previous="pills-bill-registration-tab"><i
                        class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>Mis Actividades</a>
                        </div>
                    @endif
                    
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
    </form>
 
    @if ($showModal)
    <div class="modal-backdrop">
        <div class="modal">
            <div class="spinner"></div>
            <h2 class="mt-4">Enviando tarea... Por favor espera.</h2>
            <p id="progress-text">Progreso: <strong>0%</strong></p>
        </div>
    </div>
    @endif

    <style>
    .modal-backdrop {
        position: fixed; top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.6);
        display: flex; align-items: center; justify-content: center;
        z-index: 9999;
    }
    .modal {
        background: white;
        padding: 30px 40px;
        border-radius: 10px;
        box-shadow: 0px 0px 15px rgba(0,0,0,0.5);
        text-align: center;
    }
    .spinner {
        margin: 0 auto 10px auto;
        border: 6px solid #f3f3f3;
        border-top: 6px solid #3498db;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 1s linear infinite;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    </style>
    


</div>
