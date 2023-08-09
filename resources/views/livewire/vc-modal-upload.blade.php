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
                                <option value="">Seleccione Periodo</option>
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
        <div class="table-responsive table-card mb-3">
            <div style="overflow-x:auto;">
                <table class="table table-sm align-middle" style="width:100%">
                    <tbody class="list form-check-all">
                        @foreach ($objdocument as $key => $data)
                            <tr class="detalle">
                                <td>
                                    <input type="text" class="form-control" id="billinginfo-firstName" placeholder="Enter ID" wire:model="objdocument.{{$key}}.name" disabled>
                                </td>
                                <td>
                                    @if ($objdocument[$key]['archivo'] != "")
                                        <div class="input-group">
                                        <a href="" wire:click.prevent="delete({{$key}})" class="input-group-text btn btn-soft-danger"><i class="ri-delete-bin-6-line align-bottom fs-16"></i></a>
                                        <input type="text" name="archivo.{{$key}}" wire:model.prevent="objdocument.{{$key}}.archivo" class="form-control">
                                        <a href="" wire:click.prevent="export({{$objdocument[$key]['id']}})" class="input-group-text btn btn-soft-primary"><i class="ri-download-2-line align-bottom fs-16"></i></a>
                                        </div>
                                    @else
                                        <input type="file" name="file.{{$key}}" wire:model.prevent="objdocument.{{$key}}.file" class="form-control">
                                    @endif
                                </td>
                                <td>
                                    @if ($objdocument[$key]['file'] != "" || $objdocument[$key]['archivo'] != "")
                                        <a class="text-success d-inline-block"><i class="ri-check-line fs-21"></i></a>
                                    @else 
                                        <a class="text-danger d-inline-block"><i class="ri-close-line fs-21"></i></a>
                                    @endif
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
</div>
