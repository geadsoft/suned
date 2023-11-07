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
                        <th class="sort">Lunes</th>
                        <th class="sort">Martes</th>
                        <th class="sort">Miercoles</th>
                        <th class="sort">Jueves</th>
                        <th class="sort">Viernes</th>
                    </tr>
                </thead>
                <tbody class="list form-check-all">
                    @foreach ($objdetalle as $fil => $record)    
                    <tr>
                            @for ($col=1;$col<=5;$col++)
                            <td>
                                <select id="col-{{$col}}" class="form-select" data-choices data-choices-search-false id="cmbgrupo" wire:model="objdetalle.{{$fil}}.{{$col}}">
                                <option value=""> - </option>
                                @foreach ($tblmaterias as $materia)
                                    <option value="{{$materia->id}}">{{$materia->descripcion}}</option>
                                @endforeach
                                </select>
                            </td>
                            @endfor
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-body">
        <div class="text-end">
            <!--<button  class="btn btn-success w-sm">Grabar</button>-->
            <a id="btnsave" class ="btn btn-success w-sm" wire:click="createData()">Grabar <i class="ri-save-fill"></i></a>
        </div>
    </div>
</div>
