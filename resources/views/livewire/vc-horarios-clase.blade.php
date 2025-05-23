<div>
    <div class="row">
        <div class="card-body row">
            <div class="col-lg-4">
            </div>
            <div class="col-lg-4">
                <div class="mb-3">
                    <div class="row">
                        <div class="col-lg-4">
                            <label for="cmbgrupo" class="form-label">Filas</label>
                        </div>
                        <div class="col-lg-8">
                            <div class="input-group">
                            <input type="text" class="form-control" name="identidad" id="billinginfo-firstName" placeholder="Enter ID" wire:model="filas">
                            <a id="btnstudents" class ="input-group-text btn btn-soft-secondary" wire:click="newdetalle()"><i class="ri-user-search-fill me-1"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
            </div>
        </div>
    </div>
    <div class="card-body pt-0">
        <div class="table-responsive table-card mb-1">
            <table class="table table-nowrap align-middle" id="orderTable">
                <thead class="text-muted table-light">
                    <tr class="text-uppercase">
                        <th class="sort" style="width: 200px;">Hora</th>
                        @if($modalidadId==3)
                            <th class="sort">Sabado</th>
                        @else
                        <th class="sort">Lunes</th>
                        <th class="sort">Martes</th>
                        <th class="sort">Miercoles</th>
                        <th class="sort">Jueves</th>
                        <th class="sort">Viernes</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="list form-check-all">
                    @foreach ($objdetalle as $fil => $record)    
                    <tr>    
                        <td>
                            <select id="hora{{$fil}}" class="form-select" data-choices data-choices-search-false id="cmbgrupo" wire:model="objdetalle.{{$fil}}.7">
                            <option value=""> - </option>
                            @foreach ($horas as $hora)
                                <option value="{{$hora->id}}">{{$hora->hora_ini}} - {{$hora->hora_fin}}</option>
                            @endforeach
                            </select>
                        </td>
                        @for ($col=1;$col<=6;$col++)
                            @if($modalidadId==3 && $col==6)
                            <td>
                                <select id="f{{$fil}}-col{{$col}}" class="form-select" data-choices data-choices-search-false id="cmbgrupo" wire:model="objdetalle.{{$fil}}.{{$col}}">
                                <option value=""> - </option>
                                @foreach ($tblmaterias as $materia)
                                    <option value="{{$materia->id}}">{{$materia->descripcion}}</option>
                                @endforeach
                                </select>
                            </td>
                            @endif
                            @if($modalidadId!=3 && $col<=5)
                            <td>
                                <select id="f{{$fil}}-col{{$col}}" class="form-select" data-choices data-choices-search-false id="cmbgrupo" wire:model="objdetalle.{{$fil}}.{{$col}}">
                                <option value=""> - </option>
                                @foreach ($tblmaterias as $materia)
                                    <option value="{{$materia->id}}">{{$materia->descripcion}}</option>
                                @endforeach
                                </select>
                            </td>
                            @endif
                        @endfor
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="d-flex align-items-start gap-3 mt-4">
        <a type="button" href="/headquarters/schedules" class="btn btn-light btn-label previestab"
            data-previous="pills-bill-registration-tab"><i
                class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>Volver Horario de Clases</a>
        <a id="btnsave" class ="btn btn-success w-sm right ms-auto" wire:click="createData()"><i class="ri-save-3-fill label-icon align-middle fs-16 me-2"></i>Grabar</a>
    </div>
</div>
