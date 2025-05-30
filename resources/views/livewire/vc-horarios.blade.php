<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="orderList">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Registros de Horarios Escolares</h5>
                        <div class="flex-shrink-0">
                            <a class="btn btn-success add-btn" href="/headquarters/schedules-add"><i
                            class="ri-add-line me-1 align-bottom"></i> Agregar Horario Escolar</a>
                        </div>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form>
                        <div class="row mb-3">
                            
                            <!--end col-->
                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <select class="form-select" name="cmbnivel" wire:model="filters.srv_periodo">
                                        <option value="">Seleccionar Periodo</option>
                                        @foreach ($tblperiodos as $periodo)
                                            <option value="{{$periodo->id}}">{{$periodo->descripcion}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <select class="form-select" name="cmbgrupo" wire:model="filters.srv_grupo">
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
                                    <select class="form-select" name="cmbgrupo" wire:model="filters.srv_nivel">
                                        <option value="">Seleccionar Nivel</option>
                                        @foreach ($tblgenerals as $general)
                                            @if ($general->superior ==2)
                                            <option value="{{$general->id}}">{{$general->descripcion}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!--<div class="col-xxl-2 col-sm-4">
                                <div>
                                    <select class="form-select" name="cmbgrupo" wire:model="filters.srv_grado">
                                        <option value="">Seleccionar Grado</option>
                                        @foreach ($tblgenerals as $general)
                                            @if ($general->superior ==3)
                                            <option value="{{$general->id}}">{{$general->descripcion}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>-->
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
                                        <th class="sort">Id</th>
                                        <th class="sort">Grupo</th>
                                        <th class="sort">Nivel</th>
                                        <th class="sort">Grado</th>
                                        <th class="sort">Especializacion</th>
                                        <th class="sort">Curso</th>
                                        <th class="sort">Materias/Docentes</th>
                                        <th class="sort" data-sort="">Acción</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                @foreach ($tblrecords as $record)    
                                    <tr>
                                        <td>{{$record->id}}</td>
                                        <td>{{$record->grupo->descripcion}}</td> 
                                        <td>{{$record->servicio->nivel->descripcion}}</td>
                                        <td>{{$record->servicio->grado->descripcion}}</td>
                                        <td>{{$record->servicio->especializacion->descripcion}}</td>
                                        <td>{{$record->curso->paralelo}}</td>
                                        <td>
                                            <ul class="list-inline hstack gap-2 mb-0">
                                                @foreach ($datos as $dt) 
                                                @if ($dt->horario_id == $record->id)
                                                <i>{{$dt->materias}}</i>
                                                <li class="list-inline-item edit" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="Horario">
                                                    <a href="">
                                                        <i class="bx bx-collection fs-16"></i>
                                                    </a>
                                                </li>
                                                <i>{{$dt->docentes}}</i>
                                                <li class="list-inline-item edit" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="Docentes">
                                                    <a href="">
                                                        <i class="ri-user-star-line fs-16"></i>
                                                    </a>
                                                </li> 
                                                @endif 
                                                @endforeach                                              
                                            </ul>
                                        </td>
                                        <td>
                                            <ul class="list-inline hstack gap-2 mb-0">                                           
                                                <li class="list-inline-item edit" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                                    <a href="" wire:click.prevent="edit({{ $record->id }})">
                                                        <i class="ri-pencil-fill fs-16"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                                    <a class="text-danger d-inline-block remove-item-btn"
                                                        data-bs-toggle="modal" href="" wire:click.prevent="delete({{ $record->id }})">
                                                        <i class="ri-delete-bin-5-fill fs-16"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{$tblrecords->links('')}}
                    </div>                                           

                </div>
                <div wire.ignore.self class="modal fade flip" id="deleteOrder" tabindex="-1" aria-hidden="true" wire:model='selectId'>
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body p-5 text-center">
                                <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                    colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px">
                                </lord-icon>
                                <div class="mt-4 text-center">
                                    <h4>¿Estas a punto de eliminar el registro? {{ $selectId }}</h4>
                                    <p class="text-muted fs-15 mb-4">Eliminar el registro eliminará toda su información de nuestra base de datos..</p>
                                    <div class="hstack gap-2 justify-content-center remove">
                                        <button class="btn btn-link link-success fw-medium text-decoration-none"
                                            data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i>
                                            Cerrar</button>
                                        <button class="btn btn-danger" id="delete-record"  wire:click="deleteData()"> Si, Eliminarlo</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!--end col-->
        
    </div>
    <!--end row-->

</div>


