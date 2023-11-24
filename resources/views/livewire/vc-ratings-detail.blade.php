<div>
    <div class="d-flex align-items-center">
        <h5 class="card-title mb-0 flex-grow-1"><strong>Cuadro de Calificaciones de Estudiantes</strong></h5>
    </div>
    <hr style="color: #0056b2;" />
    <div class="mb-3">
        <label for="cmbgrupo" class="form-label">Búsqueda</label>
    </div>
                       

    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="orderList">
                <div class="card-body border border-dashed border-end-0 border-start-0 ">
                    <form>
                        <label for="cmbgrupo" class="form-label">Filtros</label>
                        <div class="row mb-3">
                            <div class="col-xxl-6 col-sm-6">
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label class="form-label mt-2 me-5" for="selperiodo">Periodo Lectivo</label>
                                    </div>
                                    <div class="col-lg-9">
                                        <select class="form-select" id="selperiodo" wire:model="periodoId" required> 
                                            @foreach ($tblperiodos as $periodo)
                                                <option value="{{$periodo->id}}">{{$periodo->descripcion}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label class="form-label mt-2 me-5" for="selnivel">Programa de Estudio</label>
                                    </div>
                                    <div class="col-lg-9">
                                        <select class="form-select" id="selnivel" wire:model="servicioId" required> 
                                            <option value="" selected>Seleccionar</option>
                                            @foreach ($tblservicios as $servicio)
                                                <option value="{{$servicio->id}}">{{$servicio->descripcion}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> 
                                
                                                 
                            </div>
                            <div class="col-xxl-6 col-sm-6">
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label class="form-label mt-2 me-5" for="selgrupo">Grupo</label>
                                    </div>
                                    <div class="col-lg-9">
                                        <select class="form-select" id="selgrupo" wire:model="grupoId" required> 
                                            <option value="">Seleccionar</option>
                                            @foreach ($tblgenerals as $general)
                                                @if ($general->superior == 1)
                                                <option value="{{$general->id}}">{{$general->descripcion}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label class="form-label mt-2 me-5" for="selcurso">Sección</label>
                                    </div>
                                    <div class="col-lg-9">
                                        <select class="form-select" id="selcurso" wire:model="cursoId" required> 
                                            <option value="0" selected>Seleccionar</option>
                                            @foreach ($tblcursos as $curso)
                                                <option value="{{$curso->id}}">{{$curso->paralelo}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-12 text-end">
                                        <a wire:click="" id="btnlimpiar" class ="btn btn-soft-primary w-sm">Limpiar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @if ($mostrar)
            <div class="card" id="orderList">
                <div class="card-body">
                    <div class="hstack gap-2 justify-content-end mb-3">
                        <a href="/preview-pdf/ratings/{{$datos}}" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"><i class="ri-printer-fill align-bottom fs-22"></i></a>
                        <a href="/download-pdf/ratings/{{$datos}}" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"><i class="ri-download-2-line align-bottom fs-22"></i></a>
                        <a href="" wire:click.prevent="exportExcel()" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"><i class="ri-file-excel-2-line align-bottom fs-22"></i></a>
                    </div>
                    <div>
                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle" style="width:100%">
                                @if ($detalles != null) 
                                <thead class="text-muted table-light">
                                    <tr class="text-uppercase text-center">
                                        <th>N°</th>
                                        <th>Nómina</th>
                                        <th rowspan="2" style="transform: rotate(90deg);">Comportamiento</th>
                                        @foreach ($tblcomponentes as $data)
                                        <th colspan="5">{{$data['descripcion']}}</th>
                                        @endforeach
                                        
                                    </tr>
                                    <tr style="height:100px;">
                                        <th colspan="3"></th>
                                        @foreach ($tblcomponentes as $data)
                                        <th style="transform: rotate(90deg);">I Trimestre</th>
                                        <th style="transform: rotate(90deg);">II Trimestre</th>
                                        <th style="transform: rotate(90deg);">III Trimestre</th>
                                        <th style="transform: rotate(90deg);">Promedio</th>
                                        <th style="transform: rotate(90deg);">Pr. Final</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    
                                    @foreach ($detalles as $key => $record)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$record['nombres']}}</td>
                                        <td>{{$record['comportamiento']}}</td>
                                        @foreach ($tblcomponentes as $data)
                                        <script>
                                            {{$n1 = 'P1_'.$data['asignatura_id'] }}
                                            {{$n2 = 'P2_'.$data['asignatura_id'] }}
                                            {{$n3 = 'P3_'.$data['asignatura_id'] }}
                                            {{$pr = 'PR_'.$data['asignatura_id'] }}
                                            {{$nf = 'PF_'.$data['asignatura_id'] }}
                                        </script>
                                            <td>
                                                <input type="text" style="width:80px" class="form-control form-control-sm product-price bg-light border-0"
                                                id="col{{$key}}-1" value="{{$record[$n1]}}" disabled/>
                                            </td>
                                            <td>
                                                <input type="text" style="width:80px" class="form-control form-control-sm product-price bg-light border-0"
                                                id="col{{$key}}-2" value="{{$record[$n2]}}" disabled/>
                                            </td>
                                            <td>
                                                <input type="text" style="width:80px" class="form-control form-control-sm product-price bg-light border-0"
                                                id="col{{$key}}-3" value="{{$record[$n3]}}" disabled/>
                                            </td>
                                            <td>
                                                <input type="text" style="width:80px" class="form-control form-control-sm product-price bg-light border-0"
                                                id="col{{$key}}-4" value="{{$record[$pr]}}" disabled/>
                                            </td>
                                            <td>
                                                <input type="text" style="width:80px" class="form-control form-control-sm product-price bg-light border-0"
                                                id="col{{$key}}-5" value="{{$record[$nf]}}" disabled/>
                                            </td>
                                        @endforeach
                                        
                                    </tr>
                                    @endforeach
                                
                                </tbody>
                                @endif 
                            </table>
                            
                        </div>
                    </div>
                </div>        
            </div>
            @endif      
                
            
        </div>
        <!--end col-->
    </div>
</div>
