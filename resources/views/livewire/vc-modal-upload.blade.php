<div>
    <div class="card-header">
        <div class="row g-3 mb-3">
            <div class="col-md-2">
                <label>Estudiante:</label>
            </div>
            <div class="col-md-10">
                <label>{{$nombres}}</label>
            </div>
        </div>
        <div class="row g-3 mb-3">
            <div class="col-md-2">
                <label>Curso:</label>
            </div>
            <div class="col-md-10">
                <label>{{$curso}}</label>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive table-card mb-3">
            <div style="overflow-x:auto;">
                <table class="table table-sm align-middle" style="width:100%">
                    <tbody class="list form-check-all">
                        @foreach ($objdocument as $key => $data)
                            <tr class="detalle">
                                <td>
                                    <input type="text" class="form-control" id="billinginfo-firstName" placeholder="Enter ID" wire:model="objdocument.{{$key}}.name" disabled>
                                </td>
                                <td>
                                    <input type="file" name="archivo.{{$key}}" wire:model.prevent="objdocument.{{$key}}.file" class="form-control">
                                </td>
                                <td>
                                    @if ($objdocument[$key]['file'] != "")
                                        <a class="text-success d-inline-block"><i class="ri-check-line fs-21"></i></a>
                                    @else 
                                        <a class="text-danger d-inline-block"><i class="ri-close-line fs-21"></i></a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3">
                                <button type="button" class="btn btn-soft-success fw-medium" wire:click.prevent="uploadFiles()"><i class="ri-upload-2-fill align-bottom me-1"></i>Cargar</button>
                            </td> 
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
