<div>
    <form id="createactivity-form" autocomplete="off" wire:submit.prevent="{{ 'createData' }}" class="needs-validation" >
        <div class="row">
            <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header  border-0">
                            <div class="d-flex align-items-center">
                                <h6 class="card-title mb-0 flex-grow-1 text-primary fw-semibold"><i
                                            class="ri-calendar-check-fill align-middle me-1 text-primary fs-20"></i>Ver Actividad</h5>
                            </div>
                        </div>
                        <div class="card-body border border-dashed border-end-0 border-start-0"> 
                            <div class="row align-items-start mb-3">
                                <div class="table-responsive">
                                    <table class="table table-borderless table-nowrap">
                                    <tbody>
                                        <tr>
                                            <td class="fw-semibold fs-14" width="17%" >Asignatura</td>
                                            <td class="fs-14">{{$asignatura}}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold fs-14" width="17%" >Curso</td>
                                            <td class="fs-14">{{$curso}}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold fs-14" width="17%" >Termino</td>
                                            <td class="fs-14">{{$arrtermino[$termino]}}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold fs-14" width="17%" >Bloque</td>
                                            <td class="fs-14">{{$arrbloque[$bloque]}}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold fs-14" width="17%" >Tipo Actividad</td>
                                            <td class="fs-14">{{$arractividad[$tipo]}}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold fs-14" width="17%" >Nombre Actividad</td>
                                            <td class="fs-14">{{$nombre}}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold fs-14" width="17%" >Puntaje</td>
                                            <td class="fs-14">{{$puntaje}}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold fs-14" width="17%" >Fecha Limite</td>
                                            <td class="fs-14">@lang('translation.'.(date('l',strtotime($fecha)))),
                                            {{date('d',strtotime($fecha))}} de @lang('months.'.(date('m',strtotime($fecha)))) del {{date('Y',strtotime($fecha))}}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold fs-14" width="17%" >Hora Limite</td>
                                            <td class="fs-14">{{date('H:i',strtotime($fecha))}}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold fs-14" width="17%" >Descripcion de Actividad</td>
                                            <td class="fs-14">
                                                <body onload="addElement({{$descripcion}})">
                                                <div id="elemnt"></div>
                                                </body>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold fs-14" width="17%" >Estado</td>
                                            <td class="border-0 fs-14 badge bg-primary">{{$arrestado[$estado]}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label form-control border-0 fw-semibold fs-14">Archivos Adjuntos</label>
                                <table class="table table-nowrap align-middle" id="orderTable">
                                    <tbody>
                                    @foreach ($array_attach as $key => $recno) 
                                    <div class="d-flex align-items-center border border-dashed p-2 rounded">
                                        
                                        <div class="flex-shrink-0 avatar-sm">
                                            <div class="avatar-title bg-light rounded">
                                                <i class="ri-attachment-2 fs-20 text-info"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1">
                                            <a href="{{ route('archivo.descargar', ['id' => $recno['id']]) }}" target="_blank">
                                                {{ $recno['adjunto'] }}
                                            </a>
                                            </h6>
                                        </div>
                                        <div class="hstack gap-3 fs-16">
                                            <a type="button" class="text-muted" wire:click='download_drive({{$recno['id']}})'><i class="ri-download-2-line"></i></a>
                                        </div>

                                    </div>
                                    @endforeach
                                    </tbody>
                                </table> 
                                 <!-- warning Alert -->
                                 @if (empty($array_attach))
                                    <div class="alert alert-warning" role="alert">
                                        <strong> No existen adjuntos para esta actividad </strong>
                                    </div> 
                                 @endif                     
                            </div>

                            <div class="mb-3">
                                <label class="form-label form-control border-0 fw-semibold fs-14">Links Externos</label>
                                <!--<input type="text" class="form-control" id="product-title-input" placeholder="Ingrese enlace externo" pattern="https://.*" size="30" wire:model.defer="enlace" disabled>-->
                                 @if($enlace<>'')
                                
                                    <div class="d-flex mb-3">
                                        <div class="flex-grow-1 ms-3">
                                            <p class="text-muted mb-2">{{$enlace}}</p>
                                        </div>
                                        <div>
                                           
                                            <a href="{{$enlace}}" class="badge bg-primary-subtle text-primary" target="_blank" src="about:blank">Abri Enlace<i class="ri-arrow-right-up-line align-bottom"></i></a>
                                            
                                        </div>
                                    </div>
                                
                                @endif


                            </div>
                            @if ($this->array_entregas->isEmpty())
                            <div class="alert alert-warning" role="alert">
                                <strong> Esta actividad no tiene respuestas de estudiantes. </strong>
                            </div>
                            @else
                                <div class="mb-3">
                                <table class="table table-nowrap table-sm align-middle" id="orderTable">
                                    <thead class="text-muted table-light">
                                        <tr class="text-uppercase">
                                            <th colspan="2">Entregas</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($personas as $key => $recno) 
                                    <tr class="tr-{{$key}}">
                                    <td>{{$recno->apellidos}} {{$recno->nombres}}</td>
                                    <td>
                                        @foreach ($array_entregas as $entrega) 
                                            @if ($entrega->persona_id == $recno->id)
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 text-muted">
                                                <a class="active"><i class="ri-attachment-2 align-bottom me-2"></i> 
                                                    <span class="file-list-link">{{$entrega->nombre}} <small class="text-muted"> 
                                                    @lang('translation.'.(date('l',strtotime($entrega->created_at)))),
                                                    {{date('d',strtotime($entrega->created_at))}} de @lang('months.'.(date('m',strtotime($entrega->created_at)))) del {{date('Y',strtotime($entrega->created_at))}}
                                                    {{date('H:i',strtotime($entrega->created_at))}}</small> </span>
                                                    </a>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <div class="d-flex gap-3">
                                                        <button type="button" class="btn btn-sm fs-12 btn-link text-body text-decoration-none px-0" wire:click='download_drive({{$entrega['id']}})'>
                                                            <i class="ri-download-2-line text-muted align-bottom me-1" ></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif                                           
                                        @endforeach
                                    </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table> 
                                </div>
                            @endif
                            <div class="d-flex align-items-start gap-3 mt-4">
                                <a class="btn btn-soft-info w-sm" href="/activities/activity"><i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>Volver al Listado</a>
                            </div>

                        </div>
                    </div>
                    <!-- end card -->

                   
            </div>
            <!-- end col -->

            
        </div>
        <!-- end row -->
    </form>
</div>

