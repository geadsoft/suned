<div>
    <div class="card-header">
        <div class="row g-3 mb-3">
            <table class="table table-borderless table-sm align-middle mb-0" style="width:100%">
                <tbody>
                    <tr>
                        <td> <strong>Estudiante:</strong> </td>
                        <td> {{$nombres}} </td>
                        <td> </td>
                        <td> <strong>Periodo Lectivo:</strong> </td>
                        <td>
                            <select class="form-select" name="cmbnivel" wire:model="periodoId">
                                <option value="">Seleccione Periodo</option>
                                @foreach ($tblperiodos as $periodo)
                                    <option value="{{$periodo->id}}">{{$periodo->descripcion}}</option>
                                @endforeach
                            </select> 
                        </td>
                    </tr>
                    <tr>
                        <td> <strong>Identificación:</strong> </td>
                        <td> {{$nui}} </td>
                        <td> </td>
                        <td> <strong>Curso:</strong> </td>
                        <td>
                            <select class="form-select" name="cmbcurso" wire:model="servicioId">
                                <option value="">Seleccione Curso</option>
                                @foreach ($tblservicios as $servicio)
                                    <option value="{{$servicio->id}}">{{$servicio->descripcion}}</option>
                                @endforeach
                            </select> 
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <input type="file" name="file" wire:model.prevent="" class="form-control">
        </div>
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs-custom card-header-tabs border-bottom-0" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#addpagos" role="tab">
                            <h5 class="card-title flex-grow-1 mb-0 text-primary fs-14">
                                <i class="ri-folder-open-line align-middle me-1 text-success"></i>
                                    Documentación</h5>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#addproduct-metadata" role="tab">
                            <h5 class="card-title flex-grow-1 mb-0 text-primary fs-14">
                                <i class="ri-drag-drop-line align-middle me-1 text-success"></i>
                                    Grado</h5>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="addpagos" role="tabpanel">
                        <div class="row">
                            <div class="table-responsive">
                                
                                    <table class="table table-sm align-middle">
                                        <thead class="text-muted table-light">
                                            <tr class="text-uppercase">
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody class="list form-check-all">
                                            @foreach ($objdocument as $key => $data)
                                                <tr class="doc{{$key}}">
                                                    <td>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="chk{{$key}}">
                                                            <label class="form-check-label" for="frmchk{{$key}}"> {{$objdocument[$key]['name']}}</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3">
                                                    <button type="button" class="btn btn-soft-success fw-medium" wire:click.prevent="uploadFiles()"><i class="ri-upload-2-fill align-bottom me-1"></i>Cargar</button>
                                                </td> 
                                            </tr>
                                        </tfoot>
                                    </table>
                                
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="addproduct-metadata" role="tabpanel">
                        <div class="table-responsive mb-3">
                            
                                <table class="table table-sm align-middle">
                                    <thead class="text-muted table-light">
                                        <tr class="text-uppercase">
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody class="list form-check-all">
                                        @foreach ($tblgrados as $key => $grado)
                                            <tr class="grado{{$key}}">
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="chkgr{{$key}}">
                                                        <label class="form-check-label" for="frmchkgr{{$key}}"> {{$grado['descripcion']}}</label>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
