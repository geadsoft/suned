<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Listado de Estudiantes</h5>
                        <div class="flex-shrink-0">
                            <a href="" wire:click.prevent="exportExcel()" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"><i class="ri-file-excel-2-line align-bottom fs-22"></i></a>
                            <!--<select class="form-select" name="cmbnivel" wire:model="filters.srv_periodo">
                                <option value="">Seleccionar Periodo</option>
                                @foreach ($tblperiodos as $periodo)
                                    <option value="{{$periodo->id}}">{{$periodo->descripcion}}</option>
                                @endforeach
                            </select>-->
                        </div>
                    </div>
                </div>
            
        <!--end col-->
        <!--<div class="col-xxl-12">
            <div class="card" id="contactList">-->
                <!--<div class="card-body border border-dashed border-end-0 border-start-0">
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <div class="search-box">
                                <input type="text" class="form-control search"
                                    placeholder="Search for contact..." wire:model="filters.srv_nombre">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>-->
                <div class="card-body">
                    <div>
                        <div class="table-responsive table-card mb-3">
                            <table class="table align-middle table-nowrap mb-0" id="customerTable">
                                <thead class="text-muted table-light">
                                    <tr class="text-uppercase">
                                        <th class="text-center" colspan="6">Estudiante</th>
                                        <th class="text-center" colspan="6">Representate</th>
                                        <th class="text-center" colspan="3">Datos de Ingresos Cas</th>
                                    </tr>
                                    <tr class="text-uppercase">
                                        <th>CI</th>
                                        <th>Pasaporte</th>
                                        <th>Fecha Nacimiento</th>
                                        <th>Nacionalidad</th>
                                        <th>Apellidos</th>
                                        <th>Nombres</th>
                                        <th>CI</th>
                                        <th>Pasaporte</th>
                                        <th>Nacionalidad</th>
                                        <th>Apellidos</th>
                                        <th>Nombres</th>
                                        <th>Parentesco</th>
                                        <th>Dirección</th>
                                        <th>Teléfono</th>
                                        <th>Celular</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                @foreach ($tblrecords as $record)
                                    <tr> 
                                        @if ($record->tipoidentificacion=='C')
                                        <td>{{$record->identificacion}}</td>
                                        <td></td>
                                        @else
                                        <td></td>
                                        <td>{{$record->identificacion}}</td>
                                        @endif                                     
                                        <td>{{date('d/m/Y',strtotime($record->fechanacimiento))}}</td>
                                        <td>{{$record->nacest}}</td>
                                        <td>{{$record->apellidos}}</td>
                                        <td>{{$record->nombres}}</td>
                                        
                                        @if ($record->tiponui=='C')
                                        <td>{{$record->nui}}</td>
                                        <td></td>
                                        @else
                                        <td></td>
                                        <td>{{$record->nui}}</td>
                                        @endif
                                        <td>{{$record->nacrepresentante}}</td>
                                        <td>{{$record->aperepresentante}}</td>
                                        <td>{{$record->nomrepresentante}}</td>
                                        <td>{{$pariente[$record->pariente]}}</td>
                                        <td>{{$record->dirrepresentante}}</td>
                                        <td>{{$record->telfrepresentante}}</td>
                                        <td></td>
                                    </tr>
                                @endforeach    
                                </tbody>
                            </table>
                        </div>
                        {{$tblrecords->links('')}}
                    </div>
                

                </div>
            <!--</div>-->
            <!--end card-->
            </div>
        </div>
                <!--end col-->
    </div>
    <!--end row-->
</div>