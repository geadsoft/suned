<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="orderList">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Documentos Generados</h5>
                        <div class="flex-shrink-0">
                            <a class="btn btn-success add-btn" href="/sri/create-invoice"><i
                            class="ri-add-line me-1 align-bottom"></i> Nueva Factura</a>
                        </div>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form>
                        <div class="row mb-3">
                            <div class="col-xxl-4 col-sm-6">
                                <div class="search-box">
                                    <input type="text" class="form-control search"
                                        placeholder="Buscar por nombre o apellidos" wire:model="filters.srv_nombre">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-2 col-sm-4">
                                <div class="">
                                    <input type="date" class="form-control" id="fechaIni" data-provider="flatpickr" data-date-format="d-m-Y" data-time="true" wire:model="filters.srv_fechaini"> 
                                </div>
                            </div>
                            <div class="col-xxl-2 col-sm-4">
                                <div class="">
                                    <input type="date" class="form-control" id="fechaFin" data-provider="flatpickr" data-date-format="d-m-Y" data-time="true" wire:model="filters.srv_fechafin"> 
                                </div>
                            </div>
                            <div class="col-xxl-2 col-sm-4">
                                 <select class="form-select" name="cmbdato" wire:model="filterdata">
                                    <option value="G">Grabado</option>
                                    <option value="F">Firmado</option>
                                    <option value="A">Autorizado</option>
                                    <option value="X">Anulado</option>
                                </select>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-1 col-sm-4">
                                <div>
                                    <button type="button" class="btn btn-primary w-100" wire:click=""> <i
                                            class="ri-delete-bin-5-line me-1 align-bottom"></i>
                                        Filtros
                                    </button>
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                
                            </div>
                        </div>
                        <!--end row-->
                    </form>
                </div>
                <div class="card-body pt-0">
                    <div>
                        <ul class="nav nav-tabs nav-tabs-custom nav-success mb-3" role="tablist">
                        </ul>

                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle" id="orderTable">
                                <thead class="text-muted table-light">
                                    <tr class="text-uppercase">
                                        
                                        <th  data-sort="description">Fecha Emisión</th>
                                        <th  data-sort="modality">Serie</th>
                                        <th  data-sort="level">Secuencial</th>
                                        <th  data-sort="degree">Cliente</th>
                                        <th  data-sort="">Clave de Acceso</th>
                                        <th  data-sort="">Subtotal</th>
                                        <th  data-sort="">Iva</th>
                                        <th  data-sort="">Total</th>
                                        <th  data-sort="">Estado</th>
                                        <th class="text-center" data-sort="">Acción</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                @foreach ($tblrecords as $record)    
                                    <tr>
                                        
                                        <td> {{date('d/m/Y',strtotime($record->fecha))}}</td> 
                                        <td>{{$record->establecimiento}}-{{$record->puntoemision}}</td> 
                                        <td>{{$record->documento}}</td> 
                                        <td>{{$record->apellidos}} {{$record->nombres}}</td>
                                        <td>{{$record->autorizacion}}</td>
                                        <td>{{number_format($record->subtotal,2)}}</td>
                                        <td>{{number_format($record->impuesto,2)}}</td>
                                        <td>{{number_format($record->neto,2)}}</td>
                                        <td>
                                        <span class="badge badge-soft-success text-uppercase">{{$estado[$record->estado]}}</span>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                            <li class="list-inline-item" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="Ver">
                                                <a href="" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle dropdown"><i class="ri-eye-fill  align-bottom me-1 fs-16"></i></a>
                                            </li>
                                            @if ($record->autorizacion=='')
                                            <li class="list-inline-item" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="Firmar y Enviar">
                                                <a href="" wire:click.prevent="enviaRIDE({{$record->id}})" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle dropdown"><i class="ri-send-plane-fill align-bottom me-1 fs-16"></i></a>
                                            </li>
                                            @else
                                            <li class="list-inline-item" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="Enviar">
                                                <a href="" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle dropdown"><i class="ri-mail-send-line align-bottom me-1 fs-16"></i></a>
                                            </li>
                                            @endif  
                                            <li class="list-inline-item" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="Imprimir">
                                                <a href="/invoice/genera/{{$record->id}}" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle dropdown" target="_blank"><i class="ri-printer-fill align-bottom me-1 fs-16"></i></a>
                                            </li>
                                            <li class="list-inline-item" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="Valores Facturados">
                                                <a href="" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle dropdown" target="_blank"><i class="ri-exchange-dollar-fill align-bottom me-1 fs-16"></i></a>
                                            </li>
                                            </div>
                                        </td>
                                        
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{$tblrecords->links('')}}
                    </div>
                    
                    

                </div>
            </div>

        </div>
        <!--end col-->
    </div>
    <!--end row-->

</div>

