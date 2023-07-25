<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="paymentList">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Consulta de Valores</h5>
                        <div class="col-md-auto ms-auto">
                            <div class="hstack text-nowrap gap-2">
                                <div>
                                    <select class="form-select" name="cmbperiodo" wire:model="filters.srv_periodo" id="cmbperiodo" >
                                        <option value="">Select Period</option>
                                        @foreach ($tblperiodos as $periodo)
                                            <option value="{{$periodo->id}}">{{$periodo->descripcion}}</option>
                                        @endforeach
                                    </select>
                                </div>
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
                        </div>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form>
                        <div class="row g-3">
                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <select class="form-select" name="cmbnivel" wire:model="filters.srv_nivel" id="cmbnivel">
                                        <option value="">Seleccione Nivel</option>
                                        @foreach ($tblniveles as $nivel)
                                            <option value="{{$nivel->id}}">{{$nivel->descripcion}}</option>
                                        @endforeach
                                        <option value="0">Todos</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <select class="form-select" name="cmbcurso" wire:model="filters.srv_curso" id="cmbcurso">
                                        <option value="">Curso</option>
                                        @foreach ($tblcursos as $curso)
                                            <option value="{{$curso->id}}">{{$curso->servicio->descripcion}} {{$curso->paralelo}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <select class="form-select" name="cmbreferencia" wire:model="referencia" id="cmbmes">
                                        <option value="">Tipo Valor</option>
                                        <option value="MAT">Matricula</option>
                                        <option value="PLA">Plataforma</option>
                                        <option value="PLE">Plataforma Español</option>
                                        <option value="PLI">Plataforma Ingles</option>
                                        <option value="PEN">Pensión</option>
                                        <option value="DGR">Derecho de Grado</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <select class="form-select" name="cmbcampo" wire:model="tipo" id="cmbcampo">
                                        <option value="saldo">Valor en deuda</option>
                                        <option value="credito">Valor cancelado</option>
                                        <option value="debito">Valor a pagar</option>
                                    </select>
                                </div>
                            </div>
                            <!--<div class="col-xxl-1 col-sm-4">
                                <button type="button" class="btn btn-primary w-100" wire:click=""><i
                                        class="ri-equalizer-fill me-1 align-bottom"></i>Todos
                                </button>
                            </div>-->
                            <div class="col-md-auto ms-auto">
                                <div class="hstack text-nowrap gap-2">
                                    <a href="/download-pdf/generic-report/Download,{{$datos}}" class="btn btn-success"><i class="ri-download-2-line align-bottom me-1"></i>Download PDF</a>
                                    <a href="/preview-pdf/generic-report/Preview,{{$datos}}" class="btn btn-danger" target="_blank"><i class="ri-printer-fill align-bottom me-1"></i> Print</a>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row g-3">
                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <select class="form-select" name="cmbrelacion" wire:model="relacion" id="cmbrelacion">
                                        <option value="=">Igual que</option>
                                        <option value="<">Menor que</option>
                                        <option value="<=">Menor o igual que</option>
                                        <option value=">">Mayor que</option>
                                        <option value=">=">Mayor o igual que</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <input type="number" class="form-control product-price" id="inputvalor" step="0.01" 
                                    placeholder="0.00" wire:model="valor"/>
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

