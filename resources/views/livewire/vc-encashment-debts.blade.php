<div>
    <table class="table table-borderless table-sm align-middle mb-0" id="tbldeudas">
        <thead class="table-light text-muted thead-dark">
            <tr>
                <th scope="col" style="width: 50px;">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="checkAll"
                            value="option">
                    </div>
                </th>
                <th style="width: 60px; display:none;" scope="col">id</th>
                <th style="width: 120px;" scope="col">Referencia</th>
                <th scope="col">Descripcion</th>
                <th style="width: 90px;" scope="col" class="text-center">Saldo</th>
                <th style="width: 90px;" scope="col" class="text-center">Descuento</th>
                <th style="width: 90px;" scope="col" class="text-center">Neto</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($tbldeudas as $deuda)  
        <tr id="{{$fila}}" class="deudas">
            <th scope="row" class="deuda-id-{{$fila}}">
                <div class="form-check form-check-success">
                    <input class="form-check-input" type="checkbox" id="chkpago-{{$fila}}" onchange="chkpago({{$fila}})"/>  
                </div>
            </th>
            <td class="text-dark" style="display:none;">
                <input type="text" class="form-control product-price bg-white border-0 text-end" id="id-{{$fila}}" value="{{$deuda->id}}" />
            </td>
            <td class="text-dark">{{$deuda->referencia}}</td>
            <td class="text-dark">
                <input type="text" class="form-control product-price bg-white border-0" id="detalle-{{$fila}}" value="{{$deuda->glosa}}" />
            </td>
            <td class="text-end">
                <input type="number" class="form-control product-price bg-white border-0 text-end" id="saldo-{{$fila}}" step="0.01" 
                    placeholder="0.00" value="{{number_format($deuda->saldo,2)}}" readonly/>
            </td>
            <td class="text-end">
                <input type="number" class="form-control product-price bg-light border-0 text-end" id="desc-{{$fila}}" step="0.01" 
                placeholder="0.00" value="{{number_format($deuda->descuento,2)}}" />
            </td>
            <td class="text-end">
                <input type="number" class="form-control product-price bg-white border-0 text-end" id="neto-{{$fila}}" step="0.01" 
                    placeholder="0.00" value="{{number_format($deuda->saldo,2)}}" readonly/>
            </td>            
        </tr>
        <script>
            {{$fila++}}
        </script>
        @endforeach
        </tbody>
    </table>

</div>
