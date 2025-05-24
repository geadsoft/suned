<div>
    <div class="mb-3">
        <label for="choices-publish-status-input" class="form-label fw-semibold">Modalidad</label>
        <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false wire:model="modalidadId">
        <option value="">Seleccione Modalidad</option>
        @foreach ($tblmodalidad as $modalidad) 
            <option value="{{$modalidad->id}}">{{$modalidad->descripcion}}</option>
            @endforeach 
        </select>
    </div>
    <div class="mb-3">
        <label for="choices-publish-status-input" class="form-label fw-semibold">Asignatura</label>
        <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false wire:model="asignaturaId" {{$eSelectA}}>
        <option value="">Seleccione Asignatura</option>
        @foreach ($tblasignatura as $asignatura) 
            <option value="{{$asignatura->id}}">{{$asignatura->descripcion}}</option>
            @endforeach 
        </select>
    </div>
    <div class="mb-3">
        <label for="choices-publish-status-input" class="form-label fw-semibold">Paralelos Asignados</label>
        <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false wire:model="cursoId" required {{$eSelectC}}>
        <option value="">Seleccione Paralelo</option>
        @foreach ($tblparalelo as $paralelo) 
            <option value="{{$paralelo->id}}">{{$paralelo->descripcion}}</option>
            @endforeach 
        </select>
    </div>
</div>
