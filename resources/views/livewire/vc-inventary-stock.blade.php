
<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="orderList">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Movimientos de Inventario</h5>
                        <div class="flex-shrink-0">
                            <a class="btn btn-success add-btn" href="/inventary/register"><i
                            class="ri-add-line align-bottom me-1"></i>Nuevo Registro</a>
                        </div>
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
                        @foreach ($detalle as $record)
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
                                        <th>NN</th>
                                        <th>28</th>
                                        <th>30</th>
                                        <th>32</th>
                                        <th>34</th>
                                        <th>36</th>
                                        <th>38</th>
                                        <th>40</th>
                                        <th>42</th>
                                        <th>44</th>
                                        <th>46</th>
                                        <th>48</th>
                                        <th>50</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @foreach ($record['data'] as $record)
                                        <tr>
                                            <td>{{$record['nombre']}}</td>
                                            <td>{{$record['0']}}</td>
                                            <td>{{$record['28']}}</td>
                                            <td>{{$record['30']}}</td>
                                            <td>{{$record['32']}}</td>
                                            <td>{{$record['34']}}</td>
                                            <td>{{$record['36']}}</td>
                                            <td>{{$record['38']}}</td>
                                            <td>{{$record['40']}}</td>
                                            <td>{{$record['42']}}</td>
                                            <td>{{$record['44']}}</td>
                                            <td>{{$record['46']}}</td>
                                            <td>{{$record['48']}}</td>
                                            <td>{{$record['50']}}</td>
                                            <td></td>
                                        </tr>
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
