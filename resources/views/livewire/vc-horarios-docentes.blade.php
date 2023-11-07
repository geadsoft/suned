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
            <table class="table table-nowrap align-middle" id="orderTable">
                <thead class="text-muted table-light">
                    <tr class="text-uppercase">
                        <th class="sort">Componente Plan de Estudios</th>
                        <th class="sort">Docente</th>
                        <th class="sort" style="width: 70px;">...</th>
                    </tr>
                </thead>
                <tbody class="list form-check-all">
                    @foreach ($tblrecords as $record)    
                    <tr>
                        <td class="text-uppercase">{{$record->asignatura->descripcion}}</td>
                        <td>{{$record->docente_id}}</td>
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
    <div class="card-body">
        <div class="text-end">
            <!--<button  class="btn btn-success w-sm">Grabar</button>-->
            <a id="btnsave" class ="btn btn-success w-sm" wire:click="createData()">Grabar <i class="ri-save-fill"></i></a>
        </div>
    </div>
</div>
