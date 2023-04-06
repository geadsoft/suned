<div>
    <form autocomplete="off" wire:submit.prevent="updateMatricula">
        <div class="modal-body">
            <div class="table-responsive table-card mb-1">
                <table class="table table-nowrap align-middle" id="orderTable">
                    <thead class="text-muted table-light">
                        <tr class="text-uppercase">
                            <th> Concepto</th>
                            <th>Valor Original</th>
                            <th>Valor Actual</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($tblrecords as $fil => $data)  
                        <tr>
                            <td>
                            <input type="text" style="" class="form-control" value="{{$data[1]}}" disabled/>
                            </td>
                            <td>
                            <input type="number" step="0.01"  style="" class="form-control product-price" value="{{$data[2]}}" disabled/>
                            </td> 
                            <td>
                            <input type="number" step="0.01"  style="" class="form-control product-price" wire:model="tblrecords.{{$fil}}.{{3}}" {{$eControl}}/>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <div class="hstack gap-2 justify-content-end">
                <button type="button" class="btn btn-primary" wire:click="estado()"><i
                            class="ri-edit-2-fill me-1 align-bottom"></i>Editar</button>
                @if ($eControl=="")
                <button type="submit" class="btn btn-success" id="add-btn">Save</button>
                @endif
            </div>
        </div>
    </form>
</div>
