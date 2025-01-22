<div>
    <form id="createactivity-form" autocomplete="off">
        <div class="row">
            <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header  border-0">
                            <div class="d-flex align-items-center">
                                <h6 class="card-title mb-0 flex-grow-1 text-primary fw-semibold"><i
                                            class="ri-calendar-check-fill align-middle me-1 text-primary fs-20"></i>Ver Detalle del Curso</h5>
                            </div>
                        </div>
                        <div class="card-body border border-dashed border-end-0 border-start-0">  
                            <div class="row align-items-start mb-3">
                                <div class="col-sm-2">
                                    <div class="mb-3">
                                        <label for="asignatura-input" class="form-label form-control border-0 fw-semibold fs-14">Sección:</label>
                                    </div>
                                    <div class="mb-3">
                                        <label for="curso-input" class="form-label form-control border-0 fw-semibold fs-14">Asignatura:</label>
                                    </div>
                                    <div class="mb-3">
                                        <label for="termino-input" class="form-label form-control border-0 fw-semibold fs-14">Curso:</label>
                                    </div>
                                </div>
                                <div class="col-sm-10">  
                                    <div class="mb-3">
                                        <label class="form-control border-0 fs-14 text-uppercase">{{$seccion}}</label>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-control border-0 fs-14 text-uppercase">{{$asignatura}}</label>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-control border-0 fs-14 text-uppercase">{{$curso}}</label>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive mb-3">
                                <label class="form-label form-control border-0 fw-semibold fs-14">Estudiantes:</label>
                                <div class="search-box mb-3">
                                    <input type="text" class="form-control search"
                                        placeholder="Buscar por nombre o apellidos" wire:model="search">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                                <table class="table table-nowrap align-middle" id="orderTable">
                                    <thead class="text-muted table-light">
                                        <tr class="text-uppercase">
                                            <th class="sort">Apellidos</th>
                                            <th class="sort">Nombre</th>
                                            <th class="sort">Fecha Nacimiento</th>
                                            <th class="sort">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                     @foreach ($tblrecords as $record) 
                                    <tr>
                                    <td>{{$record["apellidos"]}}</td>
                                    <td>{{$record["nombres"]}}</td>
                                    <td>{{date('d/m/Y',strtotime($record["fechanacimiento"]))}}</td>
                                    <td>{{$record["estado"]}}</td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>                     
                            </div>
                            <div class="d-flex align-items-start gap-3 mt-4">
                                <a class="btn btn-soft-info w-sm" href="/teachers/courses"><i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>Volver al Listado</a>
                            </div>

                        </div>
                    </div>
                    <!-- end card -->

                   
            </div>
            <!-- end col -->

            
        </div>
        <!-- end row -->
    </form>
</div>

