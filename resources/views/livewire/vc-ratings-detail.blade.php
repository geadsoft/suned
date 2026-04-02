<div>
    <div class="d-flex align-items-center">
        <h5 class="card-title mb-0 flex-grow-1"><strong>Cuadro de Calificaciones de Estudiantes</strong></h5>
    </div>
    <hr style="color: #0056b2;" />
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="orderList">
                <div class="card-body border border-dashed border-end-0 border-start-0 ">
                    <form>
                        <div class="row mb-3">
                            <div class="col-xxl-2">
                                
                                <label class="form-label mt-2 me-5" for="selperiodo">Periodo Lectivo</label>
                                <select class="form-select" id="selperiodo" wire:model="periodoId" required> 
                                    @foreach ($tblperiodos as $periodo)
                                        <option value="{{$periodo->id}}">{{$periodo->descripcion}}</option>
                                    @endforeach
                                </select>    
                            </div>
                            <div class="col-xxl-2">
                                <label class="form-label mt-2 me-5" for="selgrupo">Grupo</label>
                                <select class="form-select" id="selgrupo" wire:model="grupoId" required> 
                                    <option value="">Seleccionar</option>
                                    @foreach ($tblgenerals as $general)
                                        @if ($general->superior == 1)
                                        <option value="{{$general->id}}">{{$general->descripcion}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xxl-3"> 
                                <label class="form-label mt-2 me-5" for="selnivel">Programa de Estudio</label>
                                <select class="form-select" id="selnivel" wire:model="servicioId" required> 
                                    <option value="" selected>Seleccionar</option>
                                    @foreach ($tblservicios as $servicio)
                                        <option value="{{$servicio->id}}">{{$servicio->descripcion}}</option>
                                    @endforeach
                                </select>            
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
                        <div class="table-responsive mb-1">
                            <table class="table table-sm table-nowrap align-middle" style="width:100%; font-size: 11px;">
                                @if ($detalles != null) 
                                <thead class="text-muted table-light">
                                    <tr class="text-uppercase text-center">
                                        <th>N°</th>
                                        <th>Nómina</th>
                                        <th rowspan="2" style="height:120px; width:30px; padding:0;">
                                            <div style="
                                                display:flex;
                                                justify-content:center;
                                                align-items:center;
                                                height:100%;
                                                transform: rotate(-90deg);
                                                white-space: nowrap;
                                                font-size: 12px;">
                                                Comportamiento
                                            </div>
                                        </th>
                                        @foreach ($asignaturas as $data)
                                        <th colspan="5" style="background-color:#75736F; color:white;">{{$data['descripcion']}}</th>
                                        <th style="background-color:white; color:white;"></th>
                                        @endforeach
                                    </tr>
                                    <tr style="height:100px;">
                                        <th colspan="3"></th>
                                        @foreach ($asignaturas as $data)
                                        <th style="height:120px; width:30px; padding:0;">
                                            <div style="
                                                display:flex;
                                                justify-content:center;
                                                align-items:center;
                                                height:100%;
                                                transform: rotate(-90deg);
                                                white-space: nowrap;
                                                font-size: 12px;">
                                                I Trimestre
                                            </div>
                                        </th>
                                        <th style="height:120px; width:30px; padding:0;">
                                            <div style="
                                                display:flex;
                                                justify-content:center;
                                                align-items:center;
                                                height:100%;
                                                transform: rotate(-90deg);
                                                white-space: nowrap;
                                                font-size: 12px;">
                                                II Trimestre
                                            </div>
                                        </th>
                                        <th style="height:120px; width:30px; padding:0;">
                                            <div style="
                                                display:flex;
                                                justify-content:center;
                                                align-items:center;
                                                height:100%;
                                                transform: rotate(-90deg);
                                                white-space: nowrap;
                                                font-size: 12px;">
                                                III Trimestre
                                            </div>
                                        </th>
                                        <th style="height:120px; width:30px; padding:0;">
                                            <div style="
                                                display:flex;
                                                justify-content:center;
                                                align-items:center;
                                                height:100%;
                                                transform: rotate(-90deg);
                                                white-space: nowrap;
                                                font-size: 12px;">
                                                Promedio
                                            </div>
                                        </th>
                                        <th style="height:120px; width:30px; padding:0;">
                                            <div style="
                                                display:flex;
                                                justify-content:center;
                                                align-items:center;
                                                height:100%;
                                                transform: rotate(-90deg);
                                                white-space: nowrap;
                                                font-size: 12px;">
                                                Pr. Final
                                            </div>
                                        </th>
                                        <th></th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @foreach ($alumnos as $key => $alumno)
                                    @php
                                        $idPersona = $alumno['persona_id'];
                                    @endphp
                                    <tr>
                                        <td>{{ $detalles[$idPersona]['linea'] ?? '' }}</td>
                                        <td>{{ $detalles[$idPersona]['nombres'] ?? '' }}</td>
                                        <td>{{ $detalles[$idPersona]['comportamiento'] ?? '' }}</td>
                                        @foreach ($asignaturas as $asignatura)
                                            @php
                                                $idasignatura = $asignatura['asignatura_id'];
                                                $nota = $detalles[$idPersona][$idasignatura] ?? null;
                                            @endphp
                                            <td class="text-center">{{ number_format($nota['1T'],2) ?? '' }}</td>
                                            <td class="text-center">{{ number_format($nota['2T'],2) ?? '' }}</td>
                                            <td class="text-center">{{ number_format($nota['3T'],2) ?? '' }}</td>
                                            <td class="text-center">{{ number_format($nota['PR'],2) ?? '' }}</td>
                                            <td class="text-center">{{ number_format($nota['PF'],2) ?? '' }}</td>
                                            <td></td>
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
