<div>
    <div class="row">
        <div class="card-body row">
            <div class="col-lg-4">
            </div>
            <div class="col-lg-4">
                <div class="mb-3">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="form-check form-check-success mb-3">
                                <input class="form-check-input" type="checkbox" id="formCheck8">
                                <label class="form-check-label" for="formCheck8">
                                    El horario impartido es por un único docente
                                </label>
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
            <table class="table table-nowrap table-sm align-middle" id="orderTable">
                <thead class="text-muted table-light">
                    <tr class="text-uppercase">
                        <th class="sort">Componente Plan de Estudios</th>
                        <th class="sort">Docente</th>
                        <th class="sort" style="width: 100px;">...</th>
                    </tr>
                </thead>
                <tbody class="list form-check-all">
                    @foreach ($tblrecords as $record)    
                    <tr>
                        <td class="text-uppercase">{{$record->asignatura->descripcion}}</td>
                        @if ($record['docente_id']==null)
                        <td></td>
                        @else
                        <td>{{$record->docente->apellidos}} {{$record->docente->nombres}}</td>
                        @endif
                        <td>
                            <ul class="list-inline hstack gap-2 mb-0">
                                <li class="list-inline-item edit" data-bs-toggle="tooltip"
                                    data-bs-trigger="hover" data-bs-placement="top" title="Add Course">
                                    <a href=""  wire:click.prevent="add({{ $record }})">
                                        <i class="ri-play-list-add-line fs-16"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item" data-bs-toggle="tooltip"
                                    data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                    <a class="text-danger d-inline-block remove-item-btn"
                                        data-bs-toggle="modal" href="" wire:click.prevent="delete({{ $record->id }})">
                                        <i class="ri-delete-bin-5-fill fs-16"></i>
                                    </a>
                                </li>
                            </ul>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!--<div class="card-body">
        <div class="text-end">
            <a id="btnexit" class ="btn btn-primary w-sm" wire:click="exit()">Cerrar</a>
        </div>
    </div>-->
    <div class="d-flex align-items-start gap-3 mt-4">
        <a type="button" href="/headquarters/schedules" class="btn btn-light btn-label previestab"
            data-previous="pills-bill-registration-tab"><i
                class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>Volver Horario de Clases</a>
    </div>

    <div wire.ignore.self class="modal fade" id="addDocentes" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" >
            <div class="modal-content modal-content border-0">
                
                <div class="modal-header p-3 bg-light">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <span> Docentes &nbsp;</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                </div>
                
                <form autocomplete="off" wire:submit.prevent="">
                    <div class="modal-body">                                        
                            @livewire('vc-modal-personas',[
                                'vista' => 'horarios-docentes',
                                'tipo' => 'D'
                            ])                                       
                    </div>
                    <div class="modal-footer">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
                
            </div>
        </div>
    </div>

</div>
