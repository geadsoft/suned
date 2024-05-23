<div>
    <table class="table table-nowrap align-middle" id="orderTable">
        <thead class="text-muted table-primary text-center">
            <tr class="text-uppercase">
                <th style="width: 75px;">ID</th>
                <th>Producto</th>
                <th style="width: 200px;">Unidad</th>
                <th style="width: 200px;">Cantidad</th>
                <th style="width: 200px;">Precio</th>
                <th style="width: 200px;">Total</th>
                <th style="width: 80px;">...</th>
            </tr>
        </thead>
        <tbody>
         @foreach ($detalle as $key => $recno) 
        <tr class="invtra">
            <td>
                <input type="text" class="form-control form-control" id="linea-{{$recno['linea']}}" wire:model="detalle.{{$key}}.linea" disabled>
            </td>
            <td>
                <div class="input-group">
                    <input type="text" class="form-control form-control p-1" id="producto-{{$recno['linea']}}" wire:model="detalle.{{$key}}.producto" readonly>
                    <button type="button" wire:click.prevent="search({{$key}})" class="btn dropdown bg-light" 
                        data-bs-target="" id="btn-{{$recno['linea']}}"><i class="ri-share-box-fill align-bottom me-1"></i>
                    </button>
                </div>
            </td>
            <td>
                <select class="form-select" id="unidad-{{$recno['linea']}}" wire:model="detalle.{{$key}}.unidad" disabled>
                    <option value="UND">Unidad</option>
                </select>
            </td>
            <td class="text-end">
                <input type="number" class="form-control product-price text-end" id="cantidad-{{$recno['linea']}}" step="1" 
                    placeholder="0.00" wire:model="detalle.{{$key}}.cantidad" wire:focusout='calcular({{$key}})'/>
            </td>
            <td class="text-end">
                <input type="number" class="form-control product-price text-end" id="precio-{{$recno['linea']}}" step="0.01" 
                    placeholder="0.00" wire:model="detalle.{{$key}}.precio" wire:focusout='calcular({{$key}})'/>
            </td> 
            <td class="text-end">
                <input type="number" class="form-control product-price text-end" id="total-{{$recno['linea']}}" step="0.01" 
                    placeholder="0.00" wire:model="detalle.{{$key}}.total" readonly/>
            </td>
            <td>
                <ul class="list-inline hstack gap-2 mb-0">
                    <li class="list-inline-item" data-bs-toggle="tooltip"
                        data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                        <a class="text-danger d-inline-block remove-item-btn"
                            data-bs-toggle="modal" href="" wire:click.prevent="removeItem({{$recno['linea']}})">
                            <i class="ri-delete-back-2-fill fs-16"></i>
                        </a>
                    </li>
                </ul>
            </td>           
        </tr>
        <script>
            {{$total=$total+$recno['total']}}
            {{$cantidad=$cantidad+$recno['cantidad']}}
        </script>
        @endforeach
        <tr>
            <td></td>
            <td></td>
            <td class="text-end"><strong>TOTAL</strong></td>
            <td class="text-end"><strong>{{number_format($cantidad,2)}}</strong></td>
            <td></td>
            <td class="text-end"><strong>{{number_format($total,2)}}</strong></td>
        <tr>
        </tbody>
    </table>
    <div class="mb-3">
        <button type="button" wire:click.prevent="add()" class="btn btn-soft-secondary w-sm">Agregar Detalle</button>
    </div>
</div>
