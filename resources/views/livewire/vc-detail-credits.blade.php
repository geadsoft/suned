<div>
    <div class="row">
        <div class="card">
        <h5 class="card-title">Productos y Servicios</h5>
        </div>
    </div>
    <div class="table-responsive">
        <table class="invoice-table table table-borderless table-nowrap mb-0">
            <thead class="text-muted table-light">
                <tr class="text-uppercase">
                    <th scope="col" style="width: 60px;">#</th>
                    <th scope="col" style="width: 150px;">Código</th>
                    <th scope="col">Descripción</th>
                    <th scope="col" style="width: 60px;">Cantidad</th>
                    <th scope="col" style="width: 145px;">Precio</th>
                    <th scope="col" style="width: 145px;">Total</th>
                    <th scope="col">Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tbldetails as $key => $recno) 
                <tr class="invtra">
                    <td>
                        <input type="text" class="form-control form-control p-1" id="linea-{{$recno['linea']}}" wire:model="tbldetails.{{$key}}.linea" disabled>
                    </td>
                    <td>
                        <input type="text" class="form-control form-control p-1" id="codigo-{{$recno['linea']}}" wire:model="tbldetails.{{$key}}.codigo" readonly>
                    </td>
                    <td>
                        <input type="text" class="form-control form-control p-1" id="descripcion-{{$recno['linea']}}" wire:model="tbldetails.{{$key}}.descripcion">
                    </td>
                    <td class="text-end">
                        <input type="number" class="form-control product-price text-end p-1" id="cantidad-{{$recno['linea']}}" step="1" 
                            placeholder="0.00" wire:model="tbldetails.{{$key}}.cantidad" wire:focusout='calcular({{$key}})'/>
                    </td>
                    <td class="text-end">
                        <input type="number" class="form-control product-price text-end p-1" id="precio-{{$recno['linea']}}" step="0.01" 
                            placeholder="0.00" wire:model="tbldetails.{{$key}}.precio" wire:focusout='calcular({{$key}})'/>
                    </td> 
                    <td class="text-end">
                        <input type="number" class="form-control product-price text-end p-1" id="total-{{$recno['linea']}}" step="0.01" 
                            placeholder="0.00" wire:model="tbldetails.{{$key}}.total" readonly/>
                    </td>
                    <td>
                        <ul class="list-inline hstack gap-2 mb-0">
                            <li class="list-inline-item" data-bs-toggle="tooltip"
                                data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                <a class="text-danger d-inline-block remove-item-btn"
                                    data-bs-toggle="modal" href="" wire:click.prevent="delete({{$recno['linea']}})">
                                    <i class="ri-delete-back-2-fill fs-16"></i>
                                </a>
                            </li>
                        </ul>
                    </td>           
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mb-3">
            <button type="button" wire:click.prevent="add()" class="btn btn-soft-secondary w-sm">Agregar Detalle</button>
        </div>
    </div>
    
</div>
