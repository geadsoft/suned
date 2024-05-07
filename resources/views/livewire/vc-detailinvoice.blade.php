<div>
    <div class="row">
        <div class="card">
        <h5 class="card-title">Productos y Servicios</h5>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-borderless table-sm align-middle mb-0">
            <thead class="text-muted table-light">
                <tr class="text-uppercase">
                    <!--<th scope="col" style="width: 40px;">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                id="checkAll" value="option">
                        </div>
                    </th>-->
                    <!--<th class="sort" data-sort="id" scope="col">ID</th>-->
                    <th scope="col" style="width: 60px;">#</th>
                    <th scope="col" style="width: 150px;">Código</th>
                    <th scope="col">Descripción</th>
                    <th scope="col" style="width: 60px;">Cantidad</th>
                    <th scope="col" style="width: 145px;">Precio</th>
                    <th scope="col" style="width: 145px;">Total</th>
                    <th scope="col" style="width: 70px;"> Acción </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tbldetails as $key => $product) 
                    <tr class="text-center" wire:key="{{$key}}">
                        <td class="text-start p-1">  
                            <input type="text" class="form-control bg-light border-0 p-1" value="{{$product['linea']}}" readonly>
                        </td>
                        <td class="text-start p-1">  
                            <input type="text" class="form-control bg-light border-0 p-1" value="{{$product['codigo']}}" readonly>
                        </td>
                        <td class="text-start">  
                            <input type="text" class="form-control bg-light border-0 p-1" value="{{$product['descripcion']}}" readonly>
                        </td>
                        <td> 
                            <input type="text" class="form-control bg-light border-0 p-1" value="{{$product['cantidad']}}" readonly>
                        </td>
                        <td> 
                            <input type="number" class="form-control product-price bg-light border-0 p-1" value="{{number_format($product['precio'],2)}}" readonly/>
                        </td>
                        <td>
                            <input type="number" class="form-control product-price bg-light border-0 p-1" value="{{number_format($product['total'],2)}}" readonly/>
                        </td>
                        <td> 
                            <button class="btn" wire:click.prevent="removeItem({{$product['linea']}})"><i class="ri-delete-back-2-fill fs-16 text-danger" title="Eliminar"></i></button>
                        </td>
                    </tr>
                @endforeach
                <!--@if (empty($tbldetails))
                    <tr class="text-center" wire:key="1">
                        <th scope="row">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="chk_child" value="option1">
                            </div>
                            <td> 
                                <input type="text" class="form-control bg-light border-0" value="1" readonly>
                            </td>
                            <td class="text-start">  
                                <input type="text" class="form-control bg-light border-0" value="" readonly>
                            </td>
                            <td class="text-start">  
                                <input type="text" class="form-control bg-light border-0" value="" readonly>
                            </td>
                            <td> 
                                <input type="text" class="form-control bg-light border-0" value="1" readonly>
                            </td>
                            <td> 
                                <input type="number" class="form-control product-price bg-light border-0" value="0.00"/>
                            </td>
                            <td>  
                                <input type="number" class="form-control product-price bg-light border-0" value="0.00" readonly/>
                            </td>
                            <td>  
                                <button class="btn"><i class="ri-delete-back-2-fill fs-16 text-danger" title="Eliminar"></i></button>
                            </td>
                        </th>
                    </tr>
                @endif-->
            </tbody>
        </table>
    </div>
</div>
