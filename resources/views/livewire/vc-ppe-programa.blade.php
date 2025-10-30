<div>
    <div class="row">
        <div class="col-lg-8">
            <div class="card" id="orderList">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center mb-3">
                        <h5 class="card-title mb-0 flex-grow-1">Actividades</h5>
                        <div class="flex-shrink-0">
                            
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div>
                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle" id="orderTable">
                                <thead class="text-muted table-light">
                                    <tr class="text-uppercase">
                                        <th>Actividad</th>
                                        <th>Fecha Entrega</th>
                                        <th class="text-center">Subir Archivo</th>
                                        <th class="text-center">Nota</th>
                                        <th class="text-center">Acción</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                @foreach ($tblrecords as $record)
                                    <tr>
                                        <td><span class="badge badge-soft-info text-uppercase"> {{$record->actividad}} - </span> {{$record->nombre}}
                                            <div>
                                                <i class="las la-book-open fs-18"></i><a class="text-muted"> {{$arrtipo[$record->tipo]}}</a>
                                            </div>
                                            <div>
                                                <i class="las la-user-check fs-18"></i><a class="text-muted"> {{$record->apellidos}} {{$record->nombres}} </a>
                                            </div>
                                        </td>
                                        <td class="date">@lang('translation.'.(date('l',strtotime($record->fecha_entrega)))),
                                                                {{date('d',strtotime($record->fecha_entrega))}} de @lang('months.'.(date('m',strtotime($record->fecha_entrega)))) del {{date('Y',strtotime($record->fecha_entrega))}}
                                                                , <small class="text-muted"> {{date('H:i',strtotime($record->fecha_entrega))}}</small></td>
                                        <td class="text-center">{{$record->subir_archivo}}</td>
                                        <td class="text-center">0</td>
                                        <td class="text-center">
                                            <ul class="list-inline hstack gap-2 mb-0">
                                                
                                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Abrir">
                                                    <a href="javascript:void(0);" class="view-item-btn" wire:click.prevent="visualizar({{ $record->id }})"><i class="ri-folder-open-line align-bottom text-muted fs-15"></i></a>
                                                </li>
                                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Entrega">
                                                    <a href="javascript:void(0);" class="view-item-btn"><i class="ri-send-plane-fill align-bottom text-muted fs-15"></i></a>
                                                </li>
                                                
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                         {{$tblclases->links('')}}
                        
                    </div>
                </div>

            </div>

        </div>
        <!--end col-->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Clase Virtuales</h5>
                </div>
                <div class="card-body text-center">
                    <div class="card-body">
                    <div class="table-responsive table-card mb-1">
                        <table class="table align-middle table-nowrap mb-0">
                            <thead class="text-muted table-light">
                                <tr class="text-uppercase">
                                    <!--<th>Fecha</th>-->
                                    <th>Docente</th>
                                    <th>Fase</th>
                                    <th>Fecha</th>
                                    <th>Unirse</th>
                                </tr>
                            </thead>
                            <tbody class="list form-check-all">
                            @foreach ($tblclases as $record)
                                <tr>
                                    <td>{{$record->apellidos}} {{$record->nombres}}</td>
                                    <td>{{$record->fase}}</td>
                                    <td> {{date('d/m/Y',strtotime($record->fecha))}}</td>
                                    <td>
                                    <a class="btn btn-soft-info btn-sm shadow-none" id="external-url" href="{{$record->enlace}}" target="_blank" src="about:blank">Ir a la reunión <i class="fas fa-external-link-alt"></i></a>
                                    
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{$tblclases->links('')}}
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    <!--end row-->
    <div wire.ignore.self class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" >
            <div class="modal-content">
                
                <div class="modal-header bg-light p-3">
                    <h5 class="modal-title" id="exampleModalLabel">Visualiza Actividad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                </div>
                <form autocomplete="off">
                    
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="tipo-select" class="form-label fw-semibold">Tipo Actividad</label>
                            <select class="form-select" id="tipo-select" data-choices data-choices-search-false wire:model.defer="activity.actividad" disabled>
                                @foreach ($tblactividad as $actividades) 
                                <option value="{{$actividades->codigo}}">{{$actividades->descripcion}}</option>
                                @endforeach 
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Actividad</label>
                            <input type="text" wire:model.defer="activity.nombre" class="form-control" name="descripcion"
                                placeholder="Enter name" disabled />
                        </div>
                        <div class="row mb-3"> 
                            <div class="col-sm-3">
                                <label for="fechaMaxima" class="form-label fw-semibold">Fecha Máxima de Entrega</label>
                                <input type="date" class="form-control" id="fechaMaxima" data-provider="flatpickr" data-date-format="d-m-Y" data-time="true" wire:model.defer="fechaentrega"  disabled> 
                            </div>
                            <!-- Input Time -->
                            <div class="col-sm-3">
                                <label for="horamaxima" class="form-label">Hora Máxima de Entrega</label>
                                <input type="time" class="form-control" id="horamaxima" wire:model.defer="horaentrega" disabled>
                            </div>
                            <div class="col-sm-3">
                                <label for="archivo-select" class="form-label fw-semibold">Permitir la subida de archivos</label>
                                <select class="form-select" id="archivo-select" data-choices data-choices-search-false wire:model.defer="activity.subir_archivo" disabled>
                                    <option value="SI" selected>SI</option>
                                    <option value="NO">NO</option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label for="puntaje-input" class="form-label fw-semibold">Puntaje</label>
                                <input id="puntaje-input" type="number" min="1" max="10" step="1" class="form-control" value="10" wire:model.defer="activity.puntaje"  disabled>    
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="puntaje-input" class="form-label fw-semibold">Comentario</label>
                            <textarea id="editor" class="form-control w-100" rows="5" wire:model.defer="activity.descripcion" disabled></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold" for="product-title-input">Link externo</label>
                            <input type="text" class="form-control" id="product-title-input" placeholder="Ingrese enlace externo" pattern="https://.*" size="30" wire:model.defer="activity.enlace" disabled>
                            <div class="invalid-feedback">Por favor ingrese enlace externo.</div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-success" id="add-btn">Grabar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end modal -->
</div>


