<div>
    <form id="createactivity-form" autocomplete="off" wire:submit.prevent="{{ 'createData' }}" class="needs-validation" >
        <div class="row">
            <div class="col-lg-12 d-flex gap-3 align-items-stretch">
                <div class="card flex-fill">
                    <div class="card-body">
                        <div class="col-lg-6">
                            <div class="table-responsive mb-1">
                                <table class="table table-sm fs-12" id="orderTable">
                                    <tr class="align-middle">
                                        <td class="text-center">
                                            <label class="form-label mb-0">Periodo</label>
                                        </td>

                                        <td>
                                            <select class="form-select"
                                                id="choices-publish-status-input"
                                                data-choices
                                                data-choices-search-false
                                                wire:model="filters.periodo_id">
                                                @foreach ($periodos as $periodo) 
                                                    <option value="{{$periodo->id}}">
                                                        {{$periodo->periodo}}
                                                    </option>
                                                @endforeach 
                                            </select>
                                        </td>

                                        <td>
                                             <button type="button" wire:click.prevent="generarBoletin()" class="btn btn-soft-danger add-btn form-control" data-bs-toggle="modal" id="create-btn"
                                            data-bs-target=""> Generar Boletin
                                            </button>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        
                        <div class="mb-3">
                            <div class="row g-3 mb-3">
                            <div class="col-md-auto ms-auto text-end">
                                <div class="hstack text-nowrap gap-2">
                                    <a href="/preview-pdf/final-bulletin/{{$datos}}" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" target="_blank"><i class="ri-printer-fill fs-22"></i></a>
                                    <!--<a href="" wire:click.prevent="exportExcel()" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"><i class="ri-file-excel-2-line align-bottom fs-22"></i></a>-->
                                </div>
                            </div>
                            </div>
                            <table class="table table-bordered table-sm fs-12" id="orderTable">
                                <thead class="table-light">
                                    <tr>
                                        <td class="align-middle text-center" style="font-weight: normal; padding: 0px 10px;">Matricula</td>
                                        <td class="align-middle text-center" style="font-weight: normal; padding: 0px 10px;">Identificación</td>
                                        <td class="align-middle text-center" style="font-weight: normal; padding: 0px 10px;">Nombres</td>
                                        <td class="align-middle text-center" style="font-weight: normal; padding: 0px 10px;">Modalidad</td>
                                        <td class="align-middle text-center" style="font-weight: normal; padding: 0px 10px;">Curso</td>
                                        <td class="align-middle text-center" style="font-weight: normal; padding: 0px 10px;">Observación</td>
                                        <td class="align-middle text-center" style="font-weight: normal; padding: 0px 10px;">Acción</td>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($tblpersonas as $fil => $record)
                                <tr id="{{$fil}}" class="detalle">
                                    <td class="align-middle">{{$record["documento"]}}</td>
                                    <td class="align-middle">{{$record["identificacion"]}}</td>
                                    <td class="align-middle">{{$record["apellidos"]}} {{$record["nombres"]}}</td>
                                    <td class="align-middle">{{$cursos[$record->id]['modalidad']}}</td>
                                    <td class="align-middle">{{$cursos[$record->id]['curso']}} {{$cursos[$record->id]['paralelo']}}</td>
                                    <td>
                                        <div class="input-group">
                                            @if(isset($arrComentario[$record->id]['comentario']))
                                            <input type="text" class="form-control bg-white border-0" name="identidad" id="billinginfo-firstName" value="{{$arrComentario[$record->id]['comentario']}}" disabled>
                                            @else
                                            <input type="text" class="form-control bg-white border-0" name="identidad" id="billinginfo-firstName" value="" disabled>
                                            @endif
                                            <a id="btnstudents" class ="input-group-text btn btn-soft-secondary" wire:click.prevent="addNota({{$record->id}})"><i class="ri-message-2-line me-1 fs-15"></i></a>
                                        </div>
                                    </td>
                                    <td class="text-center align-middle">
                                        <a class="text-primary d-flex justify-content-center align-items-center"
                                        style="height: 100%; width: 100%;"
                                        data-bs-toggle="modal"
                                        href="#"
                                        wire:click.prevent="imprimir({{ $record->id }})"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        title="Ver Calificaciones">
                                            <i class="ri-eye-line fs-16"></i>
                                        </a>
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
    </form>

    <!-- Varying modal content -->
    <div wire.ignore.self class="modal fade" id="varyingcontentModal" tabindex="-1" aria-labelledby="varyingcontentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="varyingcontentModalLabel">Observación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <!--<div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Recipient:</label>
                            <input type="text" class="form-control" id="recipient-name">
                        </div>-->
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Message:</label>
                            <textarea class="form-control" id="message-text" wire:model.defer="mensaje"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" wire:click="grabar()" >Grabar</button>
                </div>
            </div>
        </div>
    </div>

</div>

