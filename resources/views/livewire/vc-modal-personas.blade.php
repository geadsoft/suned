<div>
    <div class="row mb-3">
        <div class="col-md-3">
            <div class="card-header">
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-xxl-12 col-sm-6">
            <label for="" class="form-label">Docentes</label>
            <div class="search-box">
                <input id="idnombre" type="text" class="form-control search border border-primary"
                    placeholder="Buscar por apellidos, nombres..." wire:model="filters.srv_nombre">
                <i class="ri-search-line search-icon"></i>
            </div>
            <div class="search-box">
                <input id="idnui" type="text" class="form-control search border border-primary"
                    placeholder="Buscar por identifiacion" wire:model="filters.srv_nui">
                <i class="ri-search-line search-icon"></i>
            </div>
        </div>
    </div>  
    <div class="card-body">
        <div class="table-responsive table-card mb-3">
            <div style="overflow-x:auto;">
            <table class="table table-sm align-middle" style="width:100%">
                <tbody class="list form-check-all">
                    @foreach ($tblrecords as $data)
                        <tr class="detalle">
                            <td>
                                {{$data['apellidos']}} {{$data['nombres']}}
                            </td>
                            <td>
                                {{$data['identificacion']}}
                            </td>
                            <td style="width: 80px;">
                                <ul class="list-inline hstack gap-2 mb-0">
                                    <li class="list-inline-item edit" data-bs-toggle="tooltip"
                                        data-bs-trigger="hover" data-bs-placement="top" title="Continuar">
                                    <a class="btn" wire:click="setPersona({{$data['id']}})"><i class="ri-arrow-right-fill me-1 align-bottom fs-16 text-success"></i></a>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
    </div>
</div>
