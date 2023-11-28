<div>
    <div class="row">
        <div class="col-lg-12">
        <form autocomplete="off" wire:submit.prevent="{{ 'createData' }}">
            <div class="card">
                <div class="card-header border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Listado de Estudiantes</h5>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    
                        <div class="row mb-3">
                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <select class="form-select" name="cmbgrupo" wire:model="grupoId">
                                        <option value="">Seccionar Grupo</option>
                                        @foreach ($tblgrupos as $grupo)
                                        <option value="{{$grupo['id']}}">{{$grupo['descripcion']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <select class="form-select" name="cmbgrupo" wire:model="gradoId">
                                        <option value="">Seccionar Grado</option>
                                        @foreach ($tblgrados as $grado)
                                        <option value="{{$grado['id']}}">{{$grado['descripcion']}}</option>
                                        @endforeach  
                                    </select>
                                </div>
                            </div>
                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <select class="form-select" name="cmbnivel" wire:model="cursoId">
                                        <option value="">Seleccionar Curso</option>
                                        @foreach ($tblcursos as $curso)
                                        <option value="{{$curso['id']}}">{{$curso['paralelo']}}</option>
                                         @endforeach  
                                    </select>
                                </div>
                            </div>
                           
                            <!--end col-->
                            <div class="col-xxl-1 col-sm-4">
                                <div>
                                    <button type="button" class="btn btn-primary w-100" wire:click="deleteFilters()"> <i
                                            class="ri-delete-bin-5-line me-1 align-bottom"></i>
                                        Filters
                                    </button>
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                   
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
                            <table class="table table-nowrap table-sm align-middle mb-0" id="customerTable">
                                <thead class="text-muted table-light">
                                    <tr class="text-uppercase">
                                        <th class="text-center"></th>
                                        <th class="text-center" colspan="6">Estudiante</th>
                                        <th class="text-center" colspan="6">Representante</th>
                                        <th class="text-center" colspan="2">Datos de Ingresos Cas</th>
                                    </tr>
                                    <tr class="text-uppercase">
                                        <th>..</th>
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
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                @foreach ($tblrecords as $fil => $record)
                                    <tr> 
                                        <td>
                                            <input class="form-check-input" type="checkbox" id="chk-{{$fil}}"  wire:click="addCAS({{ $record }})">
                                        </td>
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
            <div class="card">
                <div class="card-header border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Ingreso CAS</h5>
                        <div class="flex-shrink-0">
                            <a href="" wire:click.prevent="exportExcel()" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"><i class="ri-file-excel-2-line align-bottom fs-22"></i></a>
                        </div>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">             
                    <div class="table-responsive table-card mb-3">
                        <table class="table table-nowrap table-sm align-middle mb-0" id="customerTable">
                            <thead class="text-muted table-light">
                                <tr class="text-uppercase">
                                    <th class="text-center"></th>
                                    <th class="text-center" colspan="6">Estudiante</th>
                                    <th class="text-center" colspan="6">Representante</th>
                                    <th class="text-center" colspan="2">Datos de Ingresos Cas</th>
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
                                </tr>
                            </thead>
                            <tbody class="list form-check-all">
                            @foreach ($ingCas as $fil => $cas)
                                <tr> 
                                    @if ($cas['tipoidentificacion']=='C')
                                    <td>{{$cas['identificacion']}}</td>
                                    <td></td>
                                    @else
                                    <td></td>
                                    <td>{{$cas['identificacion']}}</td>
                                    @endif                                     
                                    <td>{{date('d/m/Y',strtotime($cas['fechanacimiento']))}}</td>
                                    <td>{{$cas['nacest']}}</td>
                                    <td>{{$cas['apellidos']}}</td>
                                    <td>{{$cas['nombres']}}</td>
                                    
                                    @if ($cas['tiponui']=='C')
                                    <td>{{$cas['nui']}}</td>
                                    <td></td>
                                    @else
                                    <td></td>
                                    <td>{{$cas['nui']}}</td>
                                    @endif
                                    <td>{{$cas['nacrepresentante']}}</td>
                                    <td>{{$cas['aperepresentante']}}</td>
                                    <td>{{$cas['nomrepresentante']}}</td>
                                    <td>{{$pariente[$cas['pariente']]}}</td>
                                    <td>{{$cas['dirrepresentante']}}</td>
                                    <td>{{$cas['telfrepresentante']}}</td>
                                </tr>
                            @endforeach 
                            </tbody>
                        </table>
                    </div>   
                    <div class="text-end">
                        <button type="submit" class="btn btn-success w-sm">Grabar</button>
                        <a class="btn btn-secondary w-sm"><i class="me-1 align-bottom"></i>Cancelar</a>
                    </div>                
            </div>
            </form>
          
        </div>
                <!--end col-->
    </div>
    <!--end row-->
</div>
