<div>
    <form id="createproduct-form" autocomplete="off" wire:submit.prevent="{{ 'createData' }}">
        <div class="row">
            <div class="col-xl-12">                    
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h5 class="card-title flex-grow-1 mb-0 text-primary"><i
                            class="ri-shopping-bag-line me-1 text-success"></i>
                            Pase de Curso</h5>
                            <div class="flex-shrink-0">
                                <div class="text-end">
                                    <button type="submit" class="btn btn-success w-sm">Grabar</button>
                                </div>                           
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-3">
                            </div> 
                            <div class="col-xl-6">
                                <div class="input-group mb-3">
                                    <label for="" class="form-label fs-15 mt-2  me-5">Estudiante</label>
                                    <input type="text" class="form-control" name="identidad" id="billinginfo-firstName" placeholder="Buscar Estudiante.." wire:model="persona" required>
                                    <a id="btnstudents" class ="input-group-text btn btn-soft-secondary"  wire:click="buscar()"><i class="ri-user-search-fill me-1"></i></a>
                                </div>
                            </div>
                            <div class="col-xl-3">
                            </div> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-1">  
                        </div>
                        <div class="col-xl-5">
                            <div class="card ">
                                <div class="card-header">
                                    <h5 class="card-title mb-0"><i class="ri-map-pin-line align-middle me-1 text-muted"></i> Curso Actual </h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3"> 
                                        <input type="text" class="form-control" id="txtperiodo" placeholder="Enter your Names" wire:model.defer="periodo" disabled>
                                    </div> 
                                    <div class="mb-3"> 
                                        <select type="select" class="form-select" data-trigger name="grupo_id" id="cmbgrupoId" wire:model="grupoId" disabled>
                                        <option value="">Modalidad</option>
                                        @foreach ($tblgenerals as $general)
                                            @if ($general->superior == 1)
                                            <option value="{{$general->id}}">{{$general->descripcion}}</option>
                                            @endif
                                        @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3"> 
                                        <select type="select" class="form-select" data-trigger name="nivel_id" id="cmbnivelId" wire:model="nivelId" disabled>
                                        <option value="">Nivel</option>
                                        @foreach ($tblgenerals as $general)
                                            @if ($general->superior == 2)
                                            <option value="{{$general->id}}">{{$general->descripcion}}</option>
                                            @endif
                                        @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3"> 
                                        <select type="select" class="form-select" data-trigger name="record.grado_id" id="cmbgradoId" wire:model="gradoId" disabled>
                                        <option value="">Curso</option>
                                        @if(!is_null($tblservicios))
                                        @foreach ($tblservicios as $servicio)
                                            <option value="{{$servicio->id}}">{{$servicio->descripcion}}</option>
                                        @endforeach
                                        @endif
                                        </select>
                                    </div>  
                                    <div class="mb-3"> 
                                        <select class="form-select" id="cmbcursoId" wire:model="cursoId" disabled>
                                            <option value="">Sección</option>
                                            @if(!is_null($tblcursos))
                                                @foreach ($tblcursos as $curso)
                                                    <option value="{{$curso->id}}">{{$curso->paralelo}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <div class="col-xl-5">

                            <div class="card ">
                                <div class="card-header">
                                    <h5 class="card-title mb-0"><i class=" ri-share-forward-2-line align-middle me-1 text-muted"></i> Traslado </h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3"> 
                                        <input type="text" class="form-control" id="txtperiodo" placeholder="Enter your Names" wire:model.defer="periodo" disabled>
                                    </div> 
                                    <div class="mb-3"> 
                                        <select type="select" class="form-select" data-trigger name="grupo_id" id="cmbgrupoId" wire:model="pase_grupoId" wire:change="asignacurso" required>
                                        <option value="">Seleccione Modalidad</option>
                                        @foreach ($tblgenerals as $general)
                                            @if ($general->superior == 1)
                                            <option value="{{$general->id}}">{{$general->descripcion}}</option>
                                            @endif
                                        @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3"> 
                                        <select type="select" class="form-select" data-trigger name="nivel_id" id="cmbnivelId" wire:model="pase_nivelId" required>
                                        <option value="">Seleccione Nivel</option>
                                        @foreach ($tblgenerals as $general)
                                            @if ($general->superior == 2)
                                            <option value="{{$general->id}}">{{$general->descripcion}}</option>
                                            @endif
                                        @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3"> 
                                        <select type="select" class="form-select" data-trigger name="record.grado_id" id="cmbgradoId" wire:model="pase_gradoId" wire:change="asignaseccion" required>
                                        <option value="">Seleccione Curso</option>
                                        @if(!is_null($tblservicios_pase))
                                        @foreach ($tblservicios_pase as $servicio)
                                            <option value="{{$servicio->id}}">{{$servicio->descripcion}}</option>
                                        @endforeach
                                        @endif
                                        </select>
                                    </div>  
                                    <div class="mb-3"> 
                                        <select class="form-select" id="cmbcursoId" wire:model="pase_cursoId" required>
                                            <option value="">Seleccione Paralelo</option>
                                            @if(!is_null($tblcursos_pase))
                                                @foreach ($tblcursos_pase as $curso)
                                                    <option value="{{$curso->id}}">{{$curso->paralelo}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <div class="col-xl-1">
                        </div> 
                    </div>
                    
                </div>
                <!-- end card --> 
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive mb-1">
                            <table class="table table-nowrap align-middle" id="orderTable">
                                <thead class="text-muted table-light">
                                    <tr class="text-uppercase">
                                        <th class="sort" data-sort="fecha">Matricula</th>
                                        <th class="sort" data-sort="documento">Estudiante</th>
                                        <th class="sort" data-sort="referencia">Cursos Anterior</th>
                                        <th class="sort" data-sort="descripcion">Cursos Actual</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                @foreach ($tblrecords as $record)
                                    <tr>
                                        <td>{{$record->documento}}</td>
                                        <td>{{$record->estudiante->apellidos}} {{$record->estudiante->nombres}}</td>
                                        <td>
                                            <div>
                                            <i class=""></i><a class="text-muted">{{$record->nomModalidad}}</a>
                                            </div>
                                            <div>
                                                {{$record->descripcion}}  <span class="badge badge-soft-info text-info fs-12">{{$record->paralelo}}</span> 
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                            <i class=""></i><a class="text-muted">{{$record->modalidad->descripcion}}</a>
                                            </div>
                                            <div>
                                                {{$record->grado->descripcion}}  <span class="badge badge-soft-info text-info fs-12">{{$record->curso->paralelo}}</span> 
                                            </div>
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
    <div wire.ignore.self class="modal fade" id="showModalBuscar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" >
            <div class="modal-content modal-content border-0">
                
                <div class="modal-header p-3 bg-light">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <span> Buscar Estudiante &nbsp;</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                </div>
                
                <form autocomplete="off" wire:submit.prevent="">
                    <div class="modal-body">                                        
                            @livewire('vc-modal-search',['opcion' => 'PASE'])                                       
                    </div>
                    <div class="modal-footer">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <!--<button type="button" wire:click.prevent="add()" class="btn btn-success" id="add-btn">Continuar</button>-->
                        </div>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
    
</div>
