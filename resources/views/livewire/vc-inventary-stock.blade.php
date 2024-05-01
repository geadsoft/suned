
<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="orderList">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Stock</h5>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form>
                        <div class="row g-3">
                            <div class="col-xxl-2 col-sm-4">
                                <div class="">
                                        <input type="date" class="form-control" id="fechaini" data-provider="flatpickr" data-date-format="d-m-Y" data-time="true" wire:model="filters.fechaini"> 
                                </div>
                            </div>
                            <div class="col-xxl-2 col-sm-4">
                                <div class="">
                                        <input type="date" class="form-control" id="fechafin" data-provider="flatpickr" data-date-format="d-m-Y" data-time="true" wire:model="filters.fechafin"> 
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body pt-0">
                    <div>
                        @foreach ($detalle as $cat => $record)
                        <div class="card" id="orderList">
                            <div class="card-header  border-0">
                                <div class="d-flex align-items-center">
                                    <h5 class="card-title mb-0 flex-grow-1">{{$record['nombre']}}</h5>
                                </div>
                            </div>
                            <div class="card-body border border-dashed border-end-0 border-start-0">
                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle" id="orderTable">
                                <thead class="text-muted table-light">
                                    <tr class="text-uppercase">
                                        <th>Movimiento</th>
                                        <th class="text-end">NN</th>
                                        <th class="text-end">28</th>
                                        <th class="text-end">30</th>
                                        <th class="text-end">32</th>
                                        <th class="text-end">34</th>
                                        <th class="text-end">36</th>
                                        <th class="text-end">38</th>
                                        <th class="text-end">40</th>
                                        <th class="text-end">42</th>
                                        <th class="text-end">44</th>
                                        <th class="text-end">46</th>
                                        <th class="text-end">48</th>
                                        <th class="text-end">50</th>
                                        <th class="text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @foreach ($movimiento as $data)
                                        @if ( ($detalle[$cat]['data'][$data['codigo']]=='SA' || $detalle[$cat]['data'][$data['codigo']]=='ED') || $detalle[$cat]['data'][$data['codigo']]['total']>0)
                                        <tr>
                                            <td>{{$detalle[$cat]['data'][$data['codigo']]['nombre']}}</td>
                                            <td class="text-end">{{$detalle[$cat]['data'][$data['codigo']]['0']}}</td>
                                            <td class="text-end">{{$detalle[$cat]['data'][$data['codigo']]['28']}}</td>
                                            <td class="text-end">{{$detalle[$cat]['data'][$data['codigo']]['30']}}</td>
                                            <td class="text-end">{{$detalle[$cat]['data'][$data['codigo']]['32']}}</td>
                                            <td class="text-end">{{$detalle[$cat]['data'][$data['codigo']]['34']}}</td>
                                            <td class="text-end">{{$detalle[$cat]['data'][$data['codigo']]['36']}}</td>
                                            <td class="text-end">{{$detalle[$cat]['data'][$data['codigo']]['38']}}</td>
                                            <td class="text-end">{{$detalle[$cat]['data'][$data['codigo']]['40']}}</td>
                                            <td class="text-end">{{$detalle[$cat]['data'][$data['codigo']]['42']}}</td>
                                            <td class="text-end">{{$detalle[$cat]['data'][$data['codigo']]['44']}}</td>
                                            <td class="text-end">{{$detalle[$cat]['data'][$data['codigo']]['46']}}</td>
                                            <td class="text-end">{{$detalle[$cat]['data'][$data['codigo']]['48']}}</td>
                                            <td class="text-end">{{$detalle[$cat]['data'][$data['codigo']]['50']}}</td>
                                            <td class="text-end">{{$detalle[$cat]['data'][$data['codigo']]['total']}}</td>
                                        </tr>
                                        @endif 
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        </div>
                        </div>
                        
                        @endforeach
                    </div>

                </div>
            </div>

        </div>
        <!--end col-->
    </div>
    <!--end row-->
</div>
