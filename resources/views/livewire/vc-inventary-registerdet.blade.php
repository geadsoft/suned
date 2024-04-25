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
                <th>...</th>
            </tr>
        </thead>
        <tbody>
         @foreach ($detalle as $key => $recno)  
        <tr class="invtra">
            <td>
                <input type="text" class="form-control form-control" id="linea-{{$key}}" wire:model="detalle.{{$key}}.linea" disabled>
            </td>
            <td>
                <div class="input-group">
                <input type="text" class="form-control form-control p-1" id="producto-{{$key}}" wire:model="detalle.{{$key}}.producto">
                <button type="button" wire:click.prevent="search({{$key}})" class="btn dropdown bg-light" 
                    data-bs-target=""><i class="ri-share-box-fill align-bottom me-1"></i>
                </button>
                </div>
            </td>
            <td>
                <select class="form-select" id="unidad-{{$key}}" wire:model="detalle.{{$key}}.unidad" disabled>
                    <option value="UND">Unidad</option>
                </select>
            </td>
            <td class="text-end">
                <input type="number" class="form-control product-price text-end" id="cantidad-{{$key}}" step="0.01" 
                    placeholder="0.00" wire:model="detalle.{{$key}}.cantidad"/>
            </td>
            <td class="text-end">
                <input type="number" class="form-control product-price text-end" id="precio-{{$key}}" step="0.01" 
                    placeholder="0.00" wire:model="detalle.{{$key}}.precio" wire:focusout='calcular({{$key}})'/>
            </td> 
            <td class="text-end">
                <input type="number" class="form-control product-price text-end" id="total-{{$key}}" step="0.01" 
                    placeholder="0.00" wire:model="detalle.{{$key}}.total" readonly/>
            </td>           
        </tr>
        @endforeach
        </tbody>
    </table>
    <div class="mb-3">
        <button type="button" wire:click.prevent="add()" class="btn btn-soft-secondary w-sm">Agregar Detalle</button>
    </div>
</div>
