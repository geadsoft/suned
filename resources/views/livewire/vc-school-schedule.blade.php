<div>

    <div class="row mt-4">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Horario de Clases</h4>
                    
                </div>
                <div class="card-body">
                    <div class="live-preview">
                        <div class="table-responsive">
                            <table class="table table-nowrap align-middle" id="orderTable">
                                <thead class="text-muted table-light">
                                    <tr class="text-uppercase text-center">
                                        <th>Lunes</th>
                                        <th>Martes</th>
                                        <th>Miercoles</th>
                                        <th>Jueves</th>
                                        <th>Viernes</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @foreach ($objdetalle as $lin => $record)    
                                    <tr>
                                            @for ($col=1;$col<=5;$col++)
                                            <td>
                                                @if(isset($objdetalle[$lin][$col]))
                                                <div class="card mb-2">
                                                    <div class="card-body">
                                                        <div class="d-flex mb-3">
                                                            <div class="flex-shrink-0 avatar-sm">
                                                                <div class="avatar-title bg-light rounded">
                                                                    <img src="{{ URL::asset('assets/images/svg/crypto-icons/audr.svg') }}" alt="" class="avatar-xxs">
                                                                </div>
                                                            </div>
                                                            <div class="flex-grow-1 ms-3">
                                                                <h5 class="fs-15 mb-1">{{$objdetalle[$lin][$col]['asignatura']}}</h5>
                                                                <p class="text-muted mb-2 fs-10">{{$objdetalle[$lin][$col]['docente']}}</p>
                                                            </div>
                                                            
                                                        </div>
                                                       
                                                    </div>
                                                    <div class="card-body border-top border-top-dashed">
                                                        <div class="row">
                                                            <div class="col-lg-4 border-end-dashed border-end">
                                                                <div class="flex-grow-1">
                                                                <h6 class="mb-0">0<i class="ri-star-fill align-bottom text-warning"></i></h6>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 border-end-dashed border-end">
                                                                <div class="flex-grow-1">
                                                                <h6 class="mb-0">0<i class="ri-notification-3-fill align-bottom text-secondary"></i></h6>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 border-end-dashed border-end">
                                                                <div>
                                                                    @if ($objdetalle[$lin][$col]['clase']==true)
                                                                    <a href="javascript:void(0);" class="badge bg-primary-subtle text-primary">Clase Virtual<i class="ri-arrow-right-up-line align-bottom"></i></a>
                                                                    @endif
                                                                </div>
                                                            </div>                                                            
                                                        </div>
                                                        <!--<div class="d-flex">
                                                            <div class="flex-grow-1">
                                                                <h6 class="mb-0">0<i class="ri-star-fill align-bottom text-warning"></i></h6>
                                                            </div>
                                                            <h6 class="flex-shrink-0 text-danger mb-0"><i class="ri-time-line align-bottom"></i>5</h6>
                                                        </div>-->
                                                    </div>
                                                </div>
                                                @endif
                                            </td>
                                            @endfor
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <div>
        </div>
        
    </div>
    

    <!--<div>
        <div class="row">
            <div class="card-body row">
                <div class="col-lg-4">
                </div>
                <div class="col-lg-4">
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-lg-4">
                                <label for="cmbgrupo" class="form-label">Filas</label>
                            </div>
                            <div class="col-lg-8">
                                <div class="input-group">
                                <input type="text" class="form-control" name="identidad" id="billinginfo-firstName" placeholder="Enter ID" wire:model="filas">
                                <a id="btnstudents" class ="input-group-text btn btn-soft-secondary" wire:click="newdetalle()"><i class="ri-user-search-fill me-1"></i></a>
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
                            <th class="sort">Lunes</th>
                            <th class="sort">Martes</th>
                            <th class="sort">Miercoles</th>
                            <th class="sort">Jueves</th>
                            <th class="sort">Viernes</th>
                        </tr>
                    </thead>
                    <tbody class="list form-check-all">
                        
                    </tbody>
                </table>
            </div>
        </div>
        <div class="d-flex align-items-start gap-3 mt-4">
            <a type="button" href="/headquarters/schedules" class="btn btn-light btn-label previestab"
                data-previous="pills-bill-registration-tab"><i
                    class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>Volver Horario de Clases</a>
            <a id="btnsave" class ="btn btn-success w-sm right ms-auto" wire:click="createData()"><i class="ri-save-3-fill label-icon align-middle fs-16 me-2"></i>Grabar</a>
        </div>
    </div>-->

</div>
