<div>
    <div class="col-12">
        <div class="mb-3">
            <label class="text">Modalidad</label>
            <select class="form-select" name="modalidad" id="event-modalidad"  wire:model="modalidadId">
                <option value="">Seleccione Modalidad</option>
                @foreach ($modalidad as $grupo) 
                    <option value="{{$grupo->id}}">{{$grupo->descripcion}}</option>
                @endforeach 
            </select>
            <div class="invalid-feedback">Por favor seleccione una actividad de evento válida</div>
        </div>
    </div>
    <div class="col-12">
        <div class="table-responsive scroll">
            <table class="table table-sm align-middle table-nowrap">
                <thead class="text-muted table-light">
                    <tr class="text-uppercase">
                        <th scope="col" style="width: 50px;">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="checkAll" wire:click="checkall()">
                            </div>
                        </th>
                        <th scope="col" style="width: 150px;">Nivel</th>
                        <th scope="col">Grado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tbldetails as $key => $grupo) 
                    <tr>
                        <th scope="row">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="chk_child-{{$key}}" wire:model="tbldetails.{{$key}}.seleccionar">
                            </div>
                        </th>
                        <td class="nivel-{{$key}}">{{$grupo['nivel']}}</td>                        
                        <td class="nivel-{{$key}}">{{$grupo['grado']}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
