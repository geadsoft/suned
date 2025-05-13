<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="orderList">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Clases Virtuales</h5>
                        <div class="flex-shrink-0">
                            
                        </div>
                    </div>
                </div>
                <!--<div class="card-body border border-dashed border-end-0 border-start-0">
                    <form>
                        <div class="row g-3 mb-3">
                            <div class="col-xxl-5 col-sm-6">
                                <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false  wire:model="filters.paralelo">
                                    <option value="">Seleccione Paralelo</option>
                                   @foreach ($tblparalelo as $paralelo) 
                                    <option value="{{$paralelo->id}}">{{$paralelo->descripcion}}</option>
                                    @endforeach 
                                </select>
                            </div>
                            
                            <div class="col-xxl-1 col-sm-4">
                                <div>
                                    <button type="button" class="btn btn-primary w-100" onclick="SearchData();"> <i
                                            class="ri-equalizer-fill me-1 align-bottom"></i>
                                        Filters
                                    </button>
                                </div>
                            </div>
                           
                        </div>
                        
                    </form>
                </div>-->
                <div class="card-body pt-0">
                    <div>
                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle" id="orderTable">
                                <thead class="text-muted table-light">
                                    <tr class="text-uppercase">
                                        <!--<th>Fecha</th>-->
                                        <th>Asignatura</th>
                                        <th>Curso</th>
                                        <th>Paralelo</th>
                                        <th>Unirse</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                @foreach ($tblrecords as $record)
                                    <tr>
                                        <!--<td> {{date('d/m/Y',strtotime($record['fecha']))}}</td>-->
                                        <td>{{$record['asignatura']}}</td>
                                        <td>{{$record['curso']}}</td>
                                        <td>{{$record['aula']}}</td>
                                        <td>
                                        <a class="btn btn-success btn-sm" id="external-url" href="{{$record['enlace']}}" target="_blank" src="about:blank">Ir a la reunión <i class="fas fa-external-link-alt"></i></a>
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

