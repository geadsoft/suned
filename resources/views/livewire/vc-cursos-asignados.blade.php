<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="orderList">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h6 class="card-title mb-0 flex-grow-1 text-primary fw-semibold"><i
                                            class="ri-calendar-check-fill align-middle me-1 text-primary fs-20"></i>Mis Cursos</h5>
                    </div>
                </div>
                
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <div>
                        <div class="table-responsive mb-1">
                            <table class="table table-nowrap align-middle" id="orderTable">
                                <thead class="text-muted table-light">
                                    <tr class="text-uppercase">
                                        <th class="sort">Sección</th>
                                        <th class="sort">Asignatura</th>
                                        <th class="sort">Curso</th>
                                        <th class="sort">Paralelo</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                @foreach ($tblrecords as $record)    
                                    <tr>
                                        <td class="text-uppercase">{{$record->nivel}}</td>
                                        <td class="text-uppercase">{{$record->asignatura}}</td>
                                        <td class="text-uppercase">{{$record->curso}}</td> 
                                        <td>{{$record->paralelo}}</td>
                                        <td>
                                            <ul class="list-inline hstack gap-2 mb-0">
                                                <li class="list-inline-item" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="Ver">
                                                    <a href="/courses/course-view/{{$record['id']}}"
                                                        class="text-warning d-inline-block">
                                                        <i class="ri-eye-fill fs-16"></i>
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
            </div>

        </div>
        <!--end col-->
    </div>
    <!--end row-->
</div>
