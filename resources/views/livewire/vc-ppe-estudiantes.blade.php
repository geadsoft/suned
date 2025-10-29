<div>
    <div class="row">
        <div class="col-xxl-12">
            <div class="card" id="pensionlist">
                <div class="card-header">
                    <div class="row g-2">
                        <div class="col-lg-3" >
                            <div>
                                <label for="cmbmodalidad" class="form-label">Modalidad</label>
                                <select id="cmbmodalidad" type="select" class="form-select" data-trigger wire:model="modalidadId">    
                                <option value=""></option>
                                @foreach ($tblgenerals as $general)
                                    @if ($general->superior == 1)
                                    <option value="{{$general->id}}">{{$general->descripcion}}</option>
                                    @endif
                                @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3" >
                            <div>
                                <label for="cmdperiodo" class="form-label">Grado</label>
                                <select type="select" class="form-select" data-trigger id="cmdperiodo" wire:model="gradoId">
                                <option value=""></option>
                                @foreach ($tblgrados as $grado)
                                    <option value="{{$grado->id}}">{{$grado->descripcion}}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div>
                        
                        <div class="table-responsive table-card mb-3">
                            <table class="table align-middle table-nowrap mb-0" id="customerTable">
                                <thead class="table-light">
                                    <tr>
                                        <th class="sort" data-sort="id" scope="col">Modalidad</th>
                                        <th class="sort" data-sort="Descripcion" scope="col">Grado</th>
                                        <th class="sort" data-sort="Descripcion" scope="col">Identificación</th>
                                        <th class="sort" data-sort="modalidad" scope="col">Nombres</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @foreach ($tblrecords as $record) 
                                    <tr>                                           
                                        <td>{{$record->modalidad}}</td>
                                        <td>{{$record->servicio}}</td>
                                        <td>{{$record->identificacion}}</td> 
                                        <td>{{$record->apellidos}} {{$record->nombres}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="noresult" style="display: none">
                                <div class="text-center">
                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                        colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px">
                                    </lord-icon>
                                    <h5 class="mt-2">Sorry! No Result Found</h5>
                                    <p class="text-muted mb-0">We've searched more than 150+ companies
                                        We did not find any
                                        companies for you search.</p>
                                </div>
                            </div>
                        </div>
                        {{$tblrecords->links('')}}
                    </div>
                    <div wire.ignore.self class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-xl">
                            <div class="modal-content border-0">
                                <div class="modal-header p-3" style="background-color:#222454">
                                    <h5 class="modal-title" style="color: #D4D4DD" id="exampleModalLabel" >
                                        
                                            <span>Seleccionar Estudiantes  &nbsp;</span>
                                                                           
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                        id="close-modal"></button>
                                </div>
                                <form autocomplete="off" wire:submit.prevent="{{ 'createData' }}">
                                    <div class="modal-body">
                                            <div class="col-lg-12">
                                                <div>
                                                    <table class="invoice-table table table-sm table-borderless table-nowrap mb-0" id="tblpension">
                                                        <thead class="align-middle">
                                                            <tr class="table-active">
                                                                <th scope="col" style="width: 25px;">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" id="checkAll"
                                                                            wire:click="seleccionar()">
                                                                    </div>
                                                                </th>
                                                                <th scope="col">Identificación</th>
                                                                <th scope="col" class="text-center" colspan="2">Estudiante</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach ($tbldetalle as $index => $detalle)
                                            
                                                        <tr id="{{$index}}" class="product">
                                                            <td> 
                                                                <input type="checkbox" class="form-check-input" id="linea-{{$index}}" wire:model.defer="tbldetalle.{{$index}}.seleccion"/>
                                                            </td>
                                                            <td> 
                                                                <input type="text" class="form-control bg-light border-0 " id="nui-{{$index}}" value = "{{$detalle['nui']}}"/>
                                                            </td>
                                                            <td> 
                                                               <input type="text" class="form-control bg-light border-0 " id="nombre-{{$index}}" value = "{{$detalle['nombres']}}"/>
                                                            </td>
                                                            
                                                        </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                        
                                    </div>
                                    <div class="modal-footer">
                                        <div class="hstack gap-2 justify-content-end">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-success" id="add-btn">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--end add modal-->

                    <div class="modal fade zoomIn" id="deleteData" tabindex="-1" aria-labelledby="deleteRecordLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                        id="btn-close"></button>
                                </div>
                                <div class="modal-body p-5 text-center">
                                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                        colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px">
                                    </lord-icon>
                                    <div class="mt-4 text-center">
                                        <h4 class="fs-semibold">You are about to delete of record ?</h4>
                                        <p class="text-muted fs-14 mb-4 pt-1">Deleting the record, 
                                            removes all your information from our database..</p>
                                        <div class="hstack gap-2 justify-content-center remove">
                                            <button class="btn btn-link link-success fw-medium text-decoration-none"
                                                data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i>
                                                Close</button>
                                            <button class="btn btn-danger" id="delete-record" wire:click="deleteData()">Yes,
                                                Delete It!!</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end delete modal -->

                </div>
            </div>
            <!--end card-->
        </div>
        <!--end col-->
    </div>
</div>

