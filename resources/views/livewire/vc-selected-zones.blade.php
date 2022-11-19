<div>
    <div class="input-group mb-3">
        <label class="input-group-text" for="cmbprovince">Province</label>
        <select class="form-select" id="cmbprovince" wire:model="selectedProvincia" required> 
            <option value="0" selected>Choose...</option>
            @foreach ($tblprovincias as $provincia) 
                <option value="{{$provincia->id}}">{{$provincia->descripcion}}</option>
            @endforeach
        </select>
        <div class="invalid-feedback">
        Please select a valid province.
        </div>
    </div>
    <div class="input-group mb-3">
        <label class="input-group-text" for="cmbcity">Cantón</label>
        <select class="form-select" id="cmbcity" wire:model="selectedCanton" required>
            <option value="0" selected>Choose...</option>
            @if(!is_null($tblcantones))
                @foreach ($tblcantones as $canton) 
                <option value="{{$canton->id}}">{{$canton->descripcion}}</option>
                @endforeach
            @endif
        </select>
        <div class="invalid-feedback">
        Please select a valid cantón.
        </div>
    </div>
    <div class="input-group mb-3">
        <label class="input-group-text" for="cmbparish">Parish </label>
        <select class="form-select" id="cmbparish" wire:model="selectedParroquia" required>
            <option value="0" selected>Choose...</option>
            @if(!is_null($tblparroquias))
                @foreach ($tblparroquias as $parroquia) 
                <option value="{{$parroquia->id}}">{{$parroquia->descripcion}}</option>
                @endforeach
            @endif
        </select>
        <div class="invalid-feedback">
        Please select a valid parish.
        </div>
    </div>
</div>
