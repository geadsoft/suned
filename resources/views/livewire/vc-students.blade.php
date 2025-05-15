<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1"><i class="ri-team-fill align-middle me-2"></i> Información de Estudiantes</h5>
                        <div class="flex-shrink-0">
                        </div>
                    </div>
                </div>
            
        <!--end col-->
        <!--<div class="col-xxl-12">
            <div class="card" id="contactList">-->
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <div class="row mb-3">
                        <label for="record.superior" class="form-label">Cursos Asignados</label>
                        <div class="col-sm-4">
                                <div>
                                    <select class="form-select" name="cmbgrupo" wire:model="filters.cursoId">
                                        <option value="">Todos Cursos</option>
                                        @foreach ($tblcursos as $curso)
                                            <option value="{{$curso->id}}">{{$curso->descripcion}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="card-body">
                    <div>
                        <div class="table-responsive table-card mb-3">
                            <table class="table align-middle table-nowrap table-sm mb-0" id="customerTable">
                                <thead class="text-muted table-light">
                                    <tr class="text-uppercase">
                                        <th scope="col" style="width: 50px;">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    id="checkAll" value="option">
                                            </div>
                                        </th>
                                        <!--<th class="sort" data-sort="id" scope="col">ID</th>-->
                                        <th data-sort="name" scope="col">Identificación</th>
                                        <th data-sort="email_id" scope="col">Apellidos</th>
                                        <th data-sort="company_name" scope="col">Nombres</th>
                                       
                                        <th data-sort="tags" scope="col">Curso</th>
                                        <th data-sort="paralelo" scope="col">Paralelo</th>
                                        <th scope="col">Acción</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                @foreach ($tblrecords as $record)
                                    <tr>
                                        <th scope="row">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="chk_child" value="option1">
                                            </div>
                                        </th>
                                        <td>{{$record->identificacion}}</td>
                                        <td>{{$record->apellidos}}</td>
                                        <td>{{$record->nombres}}</td>
                                       
                                        <td>{{$record->descripcion}}</td>
                                        <td>{{$record->paralelo}}</td>
                                        <td class="text-center">
                                            <a href="#" target="_blank" class="btn btn-soft-secondary btn-sm dropdown" data-bs-toggle="dropdown"
                                                aria-expanded="false" wire:click='printData({{$record->id}})'>Ver Registro
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach    
                                </tbody>
                            </table>
                            <div class="noresult" style="display: none">
                                <div class="text-center">
                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json"
                                        trigger="loop" colors="primary:#121331,secondary:#08a88a"
                                        style="width:75px;height:75px">
                                    </lord-icon>
                                    <h5 class="mt-2">Sorry! No Result Found</h5>
                                    <p class="text-muted mb-0">We've searched more than 150+ contacts We
                                        did not find any
                                        contacts for you search.</p>
                                </div>
                            </div>
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
