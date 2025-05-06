<div>
    <div class="row mt-4">
        
        <div class="col-xl-12 col-lg-12">
            <div class="card-header  border-0">
                <div class="d-flex align-items-center">
                    <h6 class="card-title mb-0 flex-grow-1 text-primary fw-semibold"><i
                                class="ri-stack-line align-middle me-1 text-primary fs-20"></i>{{$asignatura}}</h5>
                </div>
            </div>
            <div class="card ribbon-box right overflow-hidden">
                <div class="card-body p-4">
                    <h6>Bibliografía</h6>
                    <div class="table-responsive">
                    
                        <label for="asignatura-input" class="form-label form-control border-0 fw-semibold fs-12">
                        <i class="mdi mdi-notebook fs-14"></i>Lista de Libros</label>
                        <table class="table align-middle table-nowrap mb-0">
                            <tbody id="file-list">
                                <tr><td><span class="badge badge-soft-warning fs-12">No Asignados</span></td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-body p-4">
                    <h6>Recursos</h6>
                    <div class="table-responsive">
                        <table class="table align-middle table-nowrap mb-0">
                            <tbody id="file-list">
                                <tr><td><span class="badge badge-soft-warning fs-12">No Asignados</span></td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-body p-4">
                    <h6>Actividades</h6>
                    @foreach ($actividad as $record)
                    <div class="vstack gap-2">
                        <div class="border rounded border-dashed p-2">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-sm">
                                        <div class="avatar-title bg-light text-secondary rounded fs-24">
                                            <i class="ri-file-shield-2-line"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <h5 class="fs-13 mb-1"><a href="#" class="text-body text-truncate d-block"><a class="text-secondary fw-semibold text-uppercase">{{$record->nombre}}</a> Fecha: {{date('d/m/Y',strtotime($record->created_at))}} <strong>Hasta:</strong> {{date('d/m/Y',strtotime($record->fecha))}}</a></h5>
                                    <div>
                                        <span class="badge badge-soft-success text-uppercase fs-12">{{$record->actividad}}</span>
                                        <span class="badge badge-soft-primary fs-12">No Calificado</span>
                                        <span class="badge badge-soft-success fs-12">Abierta</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @foreach ($clases as $record)
                    <div class="vstack gap-2">
                        <div class="border rounded border-dashed p-2">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-sm">
                                        <div class="avatar-title bg-light text-secondary rounded fs-24">
                                            <i class="ri-vidicon-2-line"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <h5 class="fs-13 mb-1"><a href="#" class="text-body text-truncate d-block"><a class="text-secondary fw-semibold text-uppercase">{{$record->nombre}}</a> Fecha: {{date('d/m/Y',strtotime($record->created_at))}} <strong>Hasta:</strong> {{date('d/m/Y',strtotime($record->fecha))}}</a></h5>
                                    <div>
                                        <a class="btn btn-secondary btn-sm" id="external-url" href="{{$record->enlace}}" target="_blank" src="about:blank">Ir a la reunión <i class="fas fa-external-link-alt"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <div class="d-flex align-items-start gap-3 mt-4">
                        <a type="button" href="/student/subject" class="btn btn-light btn-label previestab"
                            data-previous="pills-bill-registration-tab"><i
                                class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>Mis Materias</a>
                        
                    </div>
                </div>
                
            </div>
            
        </div>
        
       
    </div>
</div>
