<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="paymentList">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Estudiantes Matriculados</h5>
                        <div class="flex-shrink-0">
                            
                            
                            <a href="/preview-pdf/student-insurance/{{$datos}}" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" target="_blank"><i class="ri-printer-fill fs-22"></i></a>
                            <a href="/download-pdf/student-insurance/{{$datos}}" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"><i class="ri-download-2-line fs-22"></i></a>
                            <button type="button" data-bs-toggle="dropdown" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle dropdown">
                                <i class="ri-file-excel-2-line align-bottom fs-22"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form>
                        
                        <div class="row g-3">
                           <div class="col-xxl-2 col-sm-4">
                                <label for="lblgrupo" class="form-label badge bg-soft-primary text-dark form-control fs-12">Modalidad</label>
                                <div>
                                    @foreach ($tblgenerals as $general)
                                        <div class="form-check">
                                            <input 
                                                class="form-check-input" 
                                                type="checkbox" 
                                                value="{{ $general->id }}"
                                                id="modalidad_{{ $general->id }}"
                                                wire:model="filters.modalidadId"
                                            >
                                            <label class="form-check-label" for="modalidad_{{ $general->id }}">
                                                {{ $general->descripcion }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-xxl-2 col-sm-2">
                                <label for="lblgrupo" class="form-label badge bg-soft-primary text-dark form-control fs-12">Fecha Inicial</label>
                                <div class="">
                                        <input type="date" class="form-control" id="fechaActual" data-provider="flatpickr" data-date-format="d-m-Y" data-time="true" wire:model="filters.startDate"> 
                                </div>
                            </div>
                            <div class="col-xxl-2 col-sm-2">
                                <label for="lblgrupo" class="form-label badge bg-soft-primary text-dark form-control fs-12">Fecha Final</label>
                                <div class="">
                                        <input type="date" class="form-control" id="fechaActual" data-provider="flatpickr" data-date-format="d-m-Y" data-time="true" wire:model="filters.endDate"> 
                                </div>
                            </div>
                            <!--<div class="col-xxl-2 col-sm-4">
                                <label for="lblconsultar" class="form-label text-white">.</label>
                                <button type="button" class="btn btn-primary w-100" wire:click=""><i
                                        class="me-1 align-bottom"></i>Consultar
                                </button>
                            </div>-->
                            
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
                                        <th class="sort" data-sort="id">Estudiante</th>
                                        <th class="sort" data-sort="description">Cédula</th>
                                        <th class="sort" data-sort="modality">Fecha Nacimiento</th>
                                        <th class="sort" data-sort="level">Representante</th>
                                        <th class="sort" data-sort="degree">Télefono</th>
                                        <th class="sort" data-sort="">Email</th>
                                        <th class="sort" data-sort="">Curso</th>
                                        <th class="sort" data-sort="">Modalidad</th>
                                        <th class="sort" data-sort="">Fecha Matricula</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                @foreach ($tblrecords as $record)    
                                    <tr>
                                        <td>{{$record->nombres}} {{$record->apellidos}}</td>
                                        <td>{{$record->identificacion}}</td> 
                                        <td>{{date('d/m/Y',strtotime($record->fechanacimiento))}}</td> 
                                        <td>{{$record->representante}}</td>
                                        <td>{{$record->telefono}}</td>
                                        <td>{{$record->email}}</td>
                                        <td>{{$record->descripcion}} {{$record->paralelo}}</td>
                                        <td>{{$record->modalidad}}</td>
                                        <td>{{date('d/m/Y',strtotime($record->fecha))}}</td>
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
