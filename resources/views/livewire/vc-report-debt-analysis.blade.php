<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="paymentList">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Registros de Deudas</h5>
                        
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form>
                        <div class="row g-3 mb-3">
                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <select class="form-select" name="cmbperiodo" wire:model="filters.srv_periodoId" id="cmbperiodo">
                                        <option value="">Select Period</option>
                                        @foreach ($tblperiodos as $periodo)
                                            <option value="{{$periodo->id}}">{{$periodo->descripcion}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                           <div class="col-xxl-2 col-sm-4">
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
                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <select class="form-select" name="cmbcurso" wire:model="filters.srv_curso" id="cmbcurso">
                                        <option value="">Todos</option>
                                        @foreach ($tblcursos as $curso)
                                            <option value="{{$curso->id}}">{{$curso->servicio->descripcion}} {{$curso->paralelo}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xxl-1 col-sm-4">
                                <div>
                                    <select class="form-select" name="cmbmes" wire:model="filters.srv_mes" id="cmbmes">
                                        <option value="">Todos</option>
                                        @for ($x=1;$x<=12;$x++)
                                            <option value="{{$x}}">{{$mes[$x]}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-xxl-1 col-sm-4">
                                <div>
                                    <select class="form-select" name="cmbmes" wire:model="filters.srv_periodo" id="cmbmes">
                                        @foreach ($tblperiodos as $data)
                                            <option value="{{$data->periodo}}">{{$data->periodo}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xxl-1 col-sm-4">
                                <button type="button" class="btn btn-primary w-100" wire:click=""><i
                                        class="ri-equalizer-fill me-1 align-bottom"></i>Todos
                                </button>
                            </div>
                            <div class="col-md-auto ms-auto">
                                <div class="hstack text-nowrap gap-2">
                                    <a href="/download-pdf/debt-analysis/Download,{{$datos}}" class="btn btn-success"><i class="ri-download-2-line align-bottom me-1"></i>Download PDF</a>
                                    <a href="/preview-pdf/debt-analysis/Preview,{{$datos}}" class="btn btn-danger" target="_blank"><i class="ri-printer-fill align-bottom me-1"></i> Print</a>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" wire:model="filters.srv_grado">
                                    <label class="form-check-label" for="estado">Mostrar Derecho de Grado</label>
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
                                        <th class="sort" data-sort=""> Matrícula</th>
                                        <th class="sort" data-sort="">Estudiante</th>
                                        <th class="sort" data-sort="">Course</th>
                                        <th class="sort" data-sort="">Description</th>
                                        <th class="sort" data-sort="">Debito</th>
                                        <th class="sort" data-sort="">Descuento</th>
                                        <th class="sort" data-sort="">Credito</th>
                                        <th class="sort" data-sort="">Saldo</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                @foreach ($tblrecords as $record)    
                                    <tr>
                                        <td>{{$record->documento}}</td>
                                        <td>{{$record->apellidos}} {{$record->nombres}}</td> 
                                        <td>{{$record->curso}} {{$record->paralelo}}</td> 
                                        <td>{{$record->glosa}}</td>
                                        <td>{{number_format($record->debito,2)}}</td>
                                        <td>{{number_format($record->descuento,2)}}</td>
                                        <td>{{number_format($record->credito,2)}}</td>
                                        <td>{{number_format($record->saldo,2)}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{$tblrecords->links('')}}
                    </div>

                    <!--end modal -->
                </div>
            </div>

        </div>
        <!--end col-->
    </div>
    <!--end row-->

</div>

