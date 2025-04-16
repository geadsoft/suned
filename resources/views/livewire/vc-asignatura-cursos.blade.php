<div>
    <div class="mb-3">
        <label for="choices-publish-status-input" class="form-label fw-semibold">Asignatura</label>
        <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false wire:model="asignaturaId">
        <option value="">Seleccione Asignatura</option>
        @foreach ($tblasignatura as $asignatura) 
            <option value="{{$asignatura->id}}">{{$asignatura->descripcion}}</option>
            @endforeach 
        </select>
    </div>
    <div class="mb-3">
        <label for="choices-publish-status-input" class="form-label fw-semibold">Paralelos Asignados</label>
        <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false wire:model.defer="cursoId" required>
        <option value="">Seleccione Paralelo</option>
        @foreach ($tblparalelo as $paralelo) 
            <option value="{{$paralelo->id}}">{{$paralelo->descripcion}}</option>
            @endforeach 
        </select>
    </div>
</div>
