<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="paymentList">
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form>
                        <div class="row g-3">
                            <div class="col-xxl-2 col-sm-4">
                                <label for="lblgrupo" class="form-label badge bg-soft-primary text-dark form-control fs-12">Periodo Lectivo</label>
                                <div>
                                    <select class="form-select" name="cmbperiodo" wire:model="filters.srv_periodo" id="cmbperiodo">
                                        <option value="">Select Period</option>
                                        @foreach ($tblperiodos as $periodo)
                                            <option value="{{$periodo->id}}">{{$periodo->descripcion}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                           <div class="col-xxl-2 col-sm-4">
                                <label for="lblgrupo" class="form-label badge bg-soft-primary text-dark form-control fs-12">Modalidad</label>
                                <div>
                                    <select class="form-select" name="cmbgrupo" wire:model="filters.srv_grupo" id="cmbgrupo">
                                        <option value="">Todos</option>
                                        @foreach ($tblgenerals as $general)
                                            @if ($general->superior == 1)
                                            <option value="{{$general->id}}">{{$general->descripcion}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xxl-2 col-sm-2">
                                <label for="lblgrupo" class="form-label badge bg-soft-primary text-dark form-control fs-12">Fecha de Emisión</label>
                                <div class="">
                                        <input type="date" class="form-control" id="fechaActual" data-provider="flatpickr" data-date-format="d-m-Y" data-time="true" wire:model="filters.srv_fecha"> 
                                </div>
                            </div>
                            <div class="col-xxl-2 col-sm-2">
                                <label for="lblgrupo" class="form-label badge bg-soft-primary text-dark form-control fs-12">Fecha de Pago</label>
                                <div class="">
                                        <input type="date" class="form-control" id="fechaActual" data-provider="flatpickr" data-date-format="d-m-Y" data-time="true" wire:model="filters.srv_fechapago"> 
                                </div>
                            </div>
                            <div class="col-xxl-2 col-sm-4">
                                <label for="lblconsultar" class="form-label text-white">.</label>
                                <button type="button" class="btn btn-primary w-100" wire:click=""><i
                                        class="me-1 align-bottom"></i>Consultar
                                </button>
                            </div>
                            <div class="col-md-auto ms-auto">
                                <div class="hstack text-nowrap gap-2">
                                    <a href="/download-pdf/{{$datos}}" class="btn btn-success"><i class="ri-download-2-line align-bottom me-1"></i>Download PDF</a>
                                    <a href="/liveWire-pdf/{{$datos}}" class="btn btn-danger" target="_blank"><i class="ri-printer-fill align-bottom me-1"></i> Print</a>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-sm-4">
                                <div class="search-box">
                                    <input type="text" class="form-control search"
                                        placeholder="Search for contact..." wire:model="filters.srv_nombre">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
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
                                        <th class="sort" data-sort="id"> Receipt</th>
                                        <th class="sort" data-sort="description">Names</th>
                                        <th class="sort" data-sort="modality">Course</th>
                                        <th class="sort" data-sort="level">Description</th>
                                        <th class="sort" data-sort="degree">Payment Method</th>
                                        <th class="sort" data-sort="">Amount</th>
                                        <th class="sort" data-sort="">Discount</th>
                                        <th class="sort" data-sort="">Payment</th>
                                        <th class="sort" data-sort="">User</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                @foreach ($tblrecords as $record)    
                                    <tr>
                                        <td>{{$record->documento}}</td>
                                        <td>{{$record->apellidos}} {{$record->nombres}}</td> 
                                        <td>{{$record->descripcion}} {{$record->paralelo}}</td> 
                                        <td>{{$record->detalle}}</td>
                                        <td>{{$record->tipopago}}</td>
                                        <td>{{number_format($record->saldo + $record->credito,2)}}</td>
                                        <td>{{number_format($record->descuento,2)}}</td>
                                        <td>{{number_format($record->pago,2)}}</td>
                                        <td>{{$record->usuario}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{$tblrecords->links('')}}
                    </div>

                    <!-- Modal -->
                    <div wire.ignore.self class="modal fade flip" id="deleteOrder" tabindex="-1" aria-hidden="true" wire:model='selectId'>
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body p-5 text-center">
                                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                        colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px">
                                    </lord-icon>
                                    <div class="mt-4 text-center">
                                        <h4>You are about to delete the record ?</h4>
                                        <p class="text-muted fs-15 mb-4">Deleting the record will remove
                                            all of
                                            your information from our database.</p>
                                        <div class="hstack gap-2 justify-content-center remove">
                                            <button class="btn btn-link link-success fw-medium text-decoration-none"
                                                data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i>
                                                Close</button>
                                            <button class="btn btn-danger" id="delete-record"  wire:click="deleteData()"> Yes,
                                                Delete It</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--end modal -->
                </div>
            </div>

        </div>
        <!--end col-->
    </div>
    <!--end row-->

</div>
