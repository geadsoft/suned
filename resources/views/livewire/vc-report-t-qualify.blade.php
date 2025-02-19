<div>
    <form id="createactivity-form" autocomplete="off" wire:submit.prevent="{{ 'createData' }}" class="needs-validation" >
        <div class="row">
            <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="choices-publish-status-input" class="form-label fw-semibold">Paralelos Asignados</label>
                                <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false wire:model="filters.paralelo"  wire:change="consulta()">
                                   @foreach ($tblparalelo as $paralelo) 
                                    <option value="{{$paralelo->id}}">{{$paralelo->descripcion}}</option>
                                    @endforeach 
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="choices-publish-status-input" class="form-label fw-semibold">Término</label>
                                <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false wire:model="filters.termino"  wire:change="consulta()">
                                    <option value="1T" selected>Primer Trimestre</option>
                                    <option value="2T">Segundo Trimestre</option>
                                    <option value="3T">Tercer Trimestre</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                
                                    <label for="choices-publish-status-input" class="form-label fw-semibold">Bloque</label>
                                    <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false wire:model="filters.bloque"  wire:change="consulta()">
                                        <option value="1P" selected>Primer Parcial</option>
                                    </select>
                                
                                <!--<div class="col-sm-6">
                                    <label for="choices-publish-status-input" class="form-label fw-semibold">Tipo Actividad</label>
                                    <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false wire:model="filters.actividad"  wire:change="consulta()">
                                        <option value="AI">Actividad Individual</option>
                                        <option value="AG">Actividad Grupal</option>
                                    </select>
                                </div>-->
                            </div>
                        </div>
                    </div>
                    <!-- end card -->

                    <!--<div class="text-end mb-3">
                        <button type="submit" class="btn btn-success w-sm">Submit</button>
                    </div>-->
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        
                        <div class="mb-3">
                            <div class="row g-3 mb-3">
                            <div class="col-md-auto ms-auto text-end">
                                <div class="hstack text-nowrap gap-2">
                                    <a href="/preview-pdf/calificacion_total" wire:click.prevent="imprimir()" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"><i class="ri-printer-fill fs-22"></i></a>
                                    <a href="" wire:click.prevent="exportExcel()" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"><i class="ri-file-excel-2-line align-bottom fs-22"></i></a>
                                </div>
                            </div>
                            </div>
                            <table class="table table-bordered table-sm fs-12" id="orderTable">
                                <thead class="table-light">
                                    <tr><th colspan="5">
                                        <p class="text-end" style="margin: 0px;">Fecha: 10/02/2025</p>
                                        <p class="text-end" style="margin: 0px;">Hora: 21:54:36</p>
                                        <div class="col-4"><img class="img-fluid" style="position: absolute;top: 18%; left: 2%; width: 15%;height:60pt;" src="{{ URL::asset('assets/images/American Schooll.png')}}" alt=""></div>
                                        <p class="text-center" style="margin: 0px;">UNIDAD EDUCATIVA AMERICAN SCHOOL - {{$nivel}}</p>
                                        <p class="text-center" style="margin: 0px;">ACTA DE CALIFICACIONES</p>
                                        <p class="text-center" style="margin: 0px;">{{$subtitulo}}</p>
                                        <p class="text-center" style="margin: 0px;">{{$docente}}/{{$asignatura}}</p>
                                        <p class="text-center" style="margin: 0px;">{{$curso}}</p>
                                        </th>
                                    </tr>
                                    <tr class="text-uppercase text-muted">
                                        <th class="align-middle text-center" style="width: 800px;">NOMBRES</th>
                                        <th class="align-middle text-center" >
                                        <span style="writing-mode: vertical-rl; transform: rotate(180deg);" style="width: 50px;">Actividad Individual</span>
                                        </th>
                                        <th  class="align-middle text-center">
                                        <span style="writing-mode: vertical-rl; transform: rotate(180deg);" style="width: 50px;">Actividad Grupal</span>
                                        </th>
                                        <th class="align-middle text-center">
                                        <span style="writing-mode: vertical-rl; transform: rotate(180deg);" style="width: 50px;">Promedio</span>
                                        </th>
                                        <th class="align-middle text-center">
                                        <span style="writing-mode: vertical-rl; transform: rotate(180deg);" style="width: 50px;">Cualitativa</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($tblrecords as $fil => $data)
                                <tr id="{{$fil}}" class="detalle">
                                    @if ($fil=='X')
                                    <td>
                                        <input type="text" class="form-control bg-white border-0 text-end" id="nombre-{{$fil}}" value="{{$data["nombres"]}}" disabled/>
                                    </td>
                                    @else
                                    <td>
                                        <input type="text" class="form-control bg-white border-0" id="nombre-{{$fil}}" value="{{$data["nombres"]}}" disabled/>
                                    </td>
                                    @endif
                                     <td>   
                                        <input type="number" step="0.01" class="form-control product-price border-0 bg-white text-center"
                                            id="ai-{{$fil}}" value="{{$data["ai"]}}" disabled/>
                                    </td>
                                     <td>   
                                        <input type="number" step="0.01" class="form-control product-price border-0 bg-white text-center"
                                            id="ag-{{$fil}}" value="{{$data["ag"]}}" disabled/>
                                    </td>
                                    <td>   
                                        <input type="number" step="0.01" class="form-control product-price border-0 bg-white text-center"
                                            id="promedio-{{$fil}}" value="{{$data["promedio"]}}" disabled/>
                                    </td>
                                    <td>   
                                        <input type="number" step="0.01" class="form-control product-price border-0 bg-white text-center"
                                            id="letra-{{$fil}}" value="{{$data["cualitativa"]}}" disabled/>
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
</div>
