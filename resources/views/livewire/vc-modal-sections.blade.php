<div>
    <div class="card-header">
        <h5 class="card-title flex-grow-1 mb-0 text-primary"><i
            class="ri-clockwise-fill align-middle me-1 text-success"></i>
            New Section</h5>
    </div>
    <div class="mb-3"> 
        <select type="select" class="form-select" data-trigger name="grupo_id" id="cmbgrupoId" wire:model="grupoId">
        <option value="">Select Group</option>
        @foreach ($tblgenerals as $general)
            @if ($general->superior == 1)
            <option value="{{$general->id}}">{{$general->descripcion}}</option>
            @endif
        @endforeach
        </select>
    </div>
    <div class="mb-3"> 
        <select type="select" class="form-select" data-trigger name="nivel_id" id="cmbnivelId" wire:model="nivelId">
        <option value="">Select Level</option>
        @foreach ($tblgenerals as $general)
            @if ($general->superior == 2)
            <option value="{{$general->id}}">{{$general->descripcion}}</option>
            @endif
        @endforeach
        </select>
    </div>
    <div class="mb-3"> 
        <select type="select" class="form-select" data-trigger name="record.grado_id" id="cmbgradoId" wire:model="gradoId">
        <option value="">Select Course</option>
        @if(!is_null($tblservicios))
        @foreach ($tblservicios as $servicio)
            <option value="{{$servicio->id}}">{{$servicio->descripcion}}</option>
        @endforeach
        @endif
        </select>
    </div>  
    <div class="mb-3"> 
        <select class="form-select" id="cmbcursoId" wire:model="cursoId">
            <option value="">Select Section</option>
            @if(!is_null($tblcursos))
                @foreach ($tblcursos as $curso)
                    <option value="{{$curso->id}}">{{$curso->paralelo}}</option>
                @endforeach
            @endif
        </select>
    </div> 
</div>

