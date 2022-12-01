<div>
    <div class="mb-3"> 
        <select type="select" class="form-select" data-trigger name="periodo_id" id="cmbperiodoId" wire:model="periodoId">
        <option value="0">Select Lective Period</option>
        @foreach ($tblperiodos as $periodo)
            <option value="{{$periodo->id}}">{{$periodo->descripcion}}</option>
        @endforeach
        </select>
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
            <option value="{{$servicio->grado_id}}">{{$servicio->descripcion}}</option>
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
