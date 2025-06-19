<div>
    <form id="createactivity-form" autocomplete="off" wire:submit.prevent="{{ 'createData' }}" class="needs-validation" >
        <div class="row">
            <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header  border-0">
                            <div class="d-flex align-items-center">
                                <h6 class="card-title mb-0 flex-grow-1 text-primary fw-semibold"><i
                                            class="ri-calendar-check-fill align-middle me-1 text-primary fs-20"></i>Ver Recurso</h5>
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
                                            <td class="fw-semibold fs-14" width="17%" >Nombre del Recurso</td>
                                            <td class="fs-14">{{$nombre}}</td>
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
                                    @foreach ($array_attach as $key => $file) 
                                    <div class="d-flex align-items-center border border-dashed p-2 rounded">
                                        
                                        <div class="flex-shrink-0 avatar-sm">
                                            <div class="avatar-title bg-light rounded">
                                                <i class="ri-attachment-2 fs-20 text-info"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1">
                                            <!--<a href="{{ route('archivo.descargar', ['id' => $file['id']]) }}" target="_blank">
                                                {{ $file['adjunto'] }}
                                            </a>-->
                                            <a href="{{ route('archivo.descargar', ['id' => $file['id']]) }}" download> {{$file['adjunto']}}</a>
                                            </h6>
                                        </div>
                                        <!--<div class="hstack gap-3 fs-16">
                                            <a type="button" class="text-muted" wire:click='download_drive({{$file['id']}})'><i class="ri-download-2-line"></i></a>
                                        </div>-->
                                    </div>
                                    @endforeach
                                    </tbody>
                                </table> 
                                 <!-- warning Alert -->
                                 @if (empty($array_attach))
                                    <div class="alert alert-warning" role="alert">
                                        <strong> No existen adjuntos para este recurso </strong>
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
                            
                            <div class="d-flex align-items-start gap-3 mt-4">
                                @if($accion=='docente')
                                <a class="btn btn-soft-info w-sm" href="/subject/resources"><i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>Volver al Listado</a>
                                @else
                                <a class="btn btn-soft-info w-sm" href="/student/resources"><i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>Volver al Listado</a>
                                @endif
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


