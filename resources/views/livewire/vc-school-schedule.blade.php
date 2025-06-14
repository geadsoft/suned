<div>

    <div class="row mt-4">
        <div class="col-xl-12 col-lg-12">
            <div class="row row-cols-xxl-5 row-cols-lg-3 row-cols-md-2 row-cols-1">
                        @if ($modalidadId <> 3)
                        <div class="col">
                            <div class="card">
                                <a class="card-body alert-dark" data-bs-toggle="collapse" href="#lunes" role="button" aria-expanded="false" aria-controls="lunes">
                                    <h5 class="card-title text-uppercase text-center fw-semibold mb-1 fs-15">Lunes</h5>
                                </a>
                            </div>
                            <!--end card-->
                            <div class="collapse show" id="lunes">
                                @foreach ($objdetalle as $lin => $record)
                                @if(isset($objdetalle[$lin][1]))
                                <div class="card mb-1">
                                
                                    <div class="card-body">
                                        <a class="d-flex align-items-center" data-bs-toggle="collapse" href="#lunes{{$lin}}" role="button" aria-expanded="false" aria-controls="leadDiscovered1">
                                            <div class="flex-shrink-0">
                                                <!--<img src="{{ URL::asset('assets/images/users/avatar-1.jpg') }}" alt="" class="avatar-xs rounded-circle">-->
                                                <img src="{{ URL::asset('assets/images/svg/crypto-icons/audr.svg') }}" alt="" class="avatar-xs rounded-circle">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="fs-14 mb-1">{{$objdetalle[$lin][1]['asignatura']}}</h6>
                                                 <div class="d-flex">
                                                    <div class="flex-shrink-0 avatar-xxs text-muted">
                                                        <i class="ri-time-line"></i>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <small class="text-muted">{{$objdetalle[$lin][1]['hora_ini']}} - {{$objdetalle[$lin][1]['hora_fin']}}</small>
                                                    </div>
                                                </div>
                                                <p class="text-muted mb-0">{{$objdetalle[$lin][1]['docente']}}</p>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="collapse border-top border-top-dashed" id="lunes{{$lin}}">
                                        
                                    </div>
                                </div>
                                @endif
                                @endforeach
                            </div>
                        </div>
                        <!--end col-->

                        <div class="col">
                            <div class="card">
                                <a class="card-body alert-dark" data-bs-toggle="collapse" href="#martes" role="button" aria-expanded="false" aria-controls="martes">
                                    <h5 class="card-title text-uppercase text-center fw-semibold mb-1 fs-15">Martes</h5>
                                </a>
                            </div>
                            <div class="collapse show" id="martes">
                                @foreach ($objdetalle as $lin => $record)
                                @if(isset($objdetalle[$lin][2]))
                                <div class="card mb-1">
                                                                        
                                    <div class="card-body">
                                        <a class="d-flex align-items-center" data-bs-toggle="collapse" href="#martes{{$lin}}" role="button" aria-expanded="false" aria-controls="leadDiscovered1">
                                            <div class="flex-shrink-0">
                                                <img src="{{ URL::asset('assets/images/svg/crypto-icons/audr.svg') }}" alt="" class="avatar-xs rounded-circle">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="fs-14 mb-1">{{$objdetalle[$lin][2]['asignatura']}}</h6>
                                                 <div class="d-flex">
                                                    <div class="flex-shrink-0 avatar-xxs text-muted">
                                                        <i class="ri-time-line"></i>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <small class="text-muted">{{$objdetalle[$lin][2]['hora_ini']}} - {{$objdetalle[$lin][2]['hora_fin']}}</small>
                                                    </div>
                                                </div>
                                                <p class="text-muted mb-0">{{$objdetalle[$lin][2]['docente']}}</p>
                                            </div>
                                        </a>
                                    </div>
                                    <!--<div class="collapse border-top border-top-dashed" id="martes{{$lin}}">
                                        <div class="card-body">
                                            <h6 class="fs-14 mb-1">Por Finalizar<small class="badge bg-danger-subtle text-danger">4 Day</small></h6>
                                            <p class="text-muted">As a company grows however, you find it's not as easy to shout across</p>
                                            <ul class="list-unstyled vstack gap-2 mb-0">
                                                <li>
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 avatar-xxs text-muted">
                                                            <i class="ri-question-answer-line"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="mb-0">Meeting with Thomas</h6>
                                                            <small class="text-muted">Yesterday at 9:12AM</small>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 avatar-xxs text-muted">
                                                            <i class="ri-mac-line"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="mb-0">Product Demo</h6>
                                                            <small class="text-muted">Monday at 04:41PM</small>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 avatar-xxs text-muted">
                                                            <i class="ri-earth-line"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="mb-0">Marketing Team Meeting</h6>
                                                            <small class="text-muted">Monday at 04:41PM</small>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="card-footer hstack gap-2">
                                            <button class="btn btn-warning btn-sm w-100"><i class="ri-phone-line align-bottom me-1"></i> Call</button>
                                            <button class="btn btn-info btn-sm w-100"><i class="ri-question-answer-line align-bottom me-1"></i> Message</button>
                                        </div>
                                    </div>-->
                                </div>
                                @endif
                                @endforeach
                            </div>                           
                        </div>
                        <!--end col-->

                        <div class="col">
                            <div class="card">
                                <a class="card-body alert-dark" data-bs-toggle="collapse" href="#miercoles" role="button" aria-expanded="false" aria-controls="miercoles">
                                    <h5 class="card-title text-uppercase text-center fw-semibold mb-1 fs-15">Miercoles</h5>
                                </a>
                            </div>
                            <!--end card-->
                            <div class="collapse show" id="miercoles">
                                @foreach ($objdetalle as $lin => $record)
                                @if(isset($objdetalle[$lin][3]))
                                <div class="card mb-1">
                                    <div class="card-body">
                                        <a class="d-flex align-items-center" data-bs-toggle="collapse" href="#miercoles{{$lin}}" role="button" aria-expanded="false" aria-controls="leadDiscovered1">
                                            <div class="flex-shrink-0">
                                                <img src="{{ URL::asset('assets/images/svg/crypto-icons/audr.svg') }}" alt="" class="avatar-xs rounded-circle">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="fs-14 mb-1">{{$objdetalle[$lin][3]['asignatura']}}</h6>
                                                 <div class="d-flex">
                                                    <div class="flex-shrink-0 avatar-xxs text-muted">
                                                        <i class="ri-time-line"></i>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <small class="text-muted">{{$objdetalle[$lin][3]['hora_ini']}} - {{$objdetalle[$lin][3]['hora_fin']}}</small>
                                                    </div>
                                                </div>
                                                <p class="text-muted mb-0">{{$objdetalle[$lin][3]['docente']}}</p>
                                            </div>
                                        </a>
                                    </div>
                                    <!--<div class="collapse border-top border-top-dashed" id="miercoles{{$lin}}">
                                        <div class="card-body">
                                            <h6 class="fs-14 mb-1">Nesta Technologies <small class="badge bg-danger-subtle text-danger">4 Days</small></h6>
                                            <p class="text-muted">As a company grows however, you find it's not as easy to shout across</p>
                                            <ul class="list-unstyled vstack gap-2 mb-0">
                                                <li>
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 avatar-xxs text-muted">
                                                            <i class="ri-question-answer-line"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="mb-0">Meeting with Thomas</h6>
                                                            <small class="text-muted">Yesterday at 9:12AM</small>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 avatar-xxs text-muted">
                                                            <i class="ri-mac-line"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="mb-0">Product Demo</h6>
                                                            <small class="text-muted">Monday at 04:41PM</small>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 avatar-xxs text-muted">
                                                            <i class="ri-earth-line"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="mb-0">Marketing Team Meeting</h6>
                                                            <small class="text-muted">Monday at 04:41PM</small>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="card-footer hstack gap-2">
                                            <button class="btn btn-warning btn-sm w-100"><i class="ri-phone-line align-bottom me-1"></i> Call</button>
                                            <button class="btn btn-info btn-sm w-100"><i class="ri-question-answer-line align-bottom me-1"></i> Message</button>
                                        </div>
                                    </div>-->
                                </div>
                                @endif
                                @endforeach
                            </div>
                        </div>
                        <!--end col-->

                        <div class="col">
                            <div class="card">
                                <a class="card-body alert-dark" data-bs-toggle="collapse" href="#jueves" role="button" aria-expanded="false" aria-controls="jueves">
                                    <h5 class="card-title text-uppercase text-center fw-semibold mb-1 fs-15">Jueves</h5>
                                </a>
                            </div>
                            <!--end card-->
                            <div class="collapse show" id="jueves">
                                @foreach ($objdetalle as $lin => $record)
                                @if(isset($objdetalle[$lin][4]))
                                <div class="card mb-1">
                                    <div class="card-body">
                                        <a class="d-flex align-items-center" data-bs-toggle="collapse" href="#jueves{{$lin}}" role="button" aria-expanded="false" aria-controls="leadDiscovered1">
                                            <div class="flex-shrink-0">
                                                <!--<img src="{{ URL::asset('assets/images/users/avatar-1.jpg') }}" alt="" class="avatar-xs rounded-circle">-->
                                                <img src="{{ URL::asset('assets/images/svg/crypto-icons/audr.svg') }}" alt="" class="avatar-xs rounded-circle">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="fs-14 mb-1">{{$objdetalle[$lin][4]['asignatura']}}</h6>
                                                 <div class="d-flex">
                                                    <div class="flex-shrink-0 avatar-xxs text-muted">
                                                        <i class="ri-time-line"></i>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <small class="text-muted">{{$objdetalle[$lin][4]['hora_ini']}} - {{$objdetalle[$lin][4]['hora_fin']}}</small>
                                                    </div>
                                                </div>
                                                <p class="text-muted mb-0">{{$objdetalle[$lin][4]['docente']}}</p>
                                            </div>
                                        </a>
                                    </div>
                                    <!--<div class="collapse border-top border-top-dashed" id="jueves{{$lin}}">
                                        <div class="card-body">
                                            <h6 class="fs-14 mb-1">Nesta Technologies <small class="badge bg-danger-subtle text-danger">4 Days</small></h6>
                                            <p class="text-muted">As a company grows however, you find it's not as easy to shout across</p>
                                            <ul class="list-unstyled vstack gap-2 mb-0">
                                                <li>
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 avatar-xxs text-muted">
                                                            <i class="ri-question-answer-line"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="mb-0">Meeting with Thomas</h6>
                                                            <small class="text-muted">Yesterday at 9:12AM</small>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 avatar-xxs text-muted">
                                                            <i class="ri-mac-line"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="mb-0">Product Demo</h6>
                                                            <small class="text-muted">Monday at 04:41PM</small>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 avatar-xxs text-muted">
                                                            <i class="ri-earth-line"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="mb-0">Marketing Team Meeting</h6>
                                                            <small class="text-muted">Monday at 04:41PM</small>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="card-footer hstack gap-2">
                                            <button class="btn btn-warning btn-sm w-100"><i class="ri-phone-line align-bottom me-1"></i> Call</button>
                                            <button class="btn btn-info btn-sm w-100"><i class="ri-question-answer-line align-bottom me-1"></i> Message</button>
                                        </div>
                                    </div>-->
                                </div>
                                @endif
                                @endforeach
                            </div>
                        </div>
                        <!--end col-->

                        <div class="col">
                            <div class="card">
                                <a class="card-body alert-dark" data-bs-toggle="collapse" href="#viernes" role="button" aria-expanded="false" aria-controls="viernes">
                                    <h5 class="card-title text-uppercase text-center fw-semibold mb-1 fs-15">Viernes</h5>
                                </a>
                            </div>
                            <!--end card-->
                            <div class="collapse show" id="viernes">
                                @foreach ($objdetalle as $lin => $record)
                                @if(isset($objdetalle[$lin][5]))
                                <div class="card mb-1">
                                    <div class="card-body">
                                        <a class="d-flex align-items-center" data-bs-toggle="collapse" href="#viernes{{$lin}}" role="button" aria-expanded="false" aria-controls="leadDiscovered1">
                                            <div class="flex-shrink-0">
                                                <!--<img src="{{ URL::asset('assets/images/users/avatar-1.jpg') }}" alt="" class="avatar-xs rounded-circle">-->
                                                <img src="{{ URL::asset('assets/images/svg/crypto-icons/audr.svg') }}" alt="" class="avatar-xs rounded-circle">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="fs-14 mb-1">{{$objdetalle[$lin][5]['asignatura']}}</h6>
                                                 <div class="d-flex">
                                                    <div class="flex-shrink-0 avatar-xxs text-muted">
                                                        <i class="ri-time-line"></i>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <small class="text-muted">{{$objdetalle[$lin][5]['hora_ini']}} - {{$objdetalle[$lin][5]['hora_fin']}}</small>
                                                    </div>
                                                </div>
                                                <p class="text-muted mb-0">{{$objdetalle[$lin][5]['docente']}}</p>
                                            </div>
                                        </a>
                                    </div>
                                    <!--<div class="collapse border-top border-top-dashed" id="viernes{{$lin}}">
                                        <div class="card-body">
                                            <h6 class="fs-14 mb-1">Nesta Technologies <small class="badge bg-danger-subtle text-danger">4 Days</small></h6>
                                            <p class="text-muted">As a company grows however, you find it's not as easy to shout across</p>
                                            <ul class="list-unstyled vstack gap-2 mb-0">
                                                <li>
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 avatar-xxs text-muted">
                                                            <i class="ri-question-answer-line"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="mb-0">Meeting with Thomas</h6>
                                                            <small class="text-muted">Yesterday at 9:12AM</small>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 avatar-xxs text-muted">
                                                            <i class="ri-mac-line"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="mb-0">Product Demo</h6>
                                                            <small class="text-muted">Monday at 04:41PM</small>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 avatar-xxs text-muted">
                                                            <i class="ri-earth-line"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="mb-0">Marketing Team Meeting</h6>
                                                            <small class="text-muted">Monday at 04:41PM</small>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="card-footer hstack gap-2">
                                            <button class="btn btn-warning btn-sm w-100"><i class="ri-phone-line align-bottom me-1"></i> Call</button>
                                            <button class="btn btn-info btn-sm w-100"><i class="ri-question-answer-line align-bottom me-1"></i> Message</button>
                                        </div>
                                    </div>-->
                                </div>
                                @endif
                                @endforeach
                            </div>
                        </div>
                        <!--end col-->
                        @else

                        <div class="col">
                            <div class="card">
                                <a class="card-body alert-dark" data-bs-toggle="collapse" href="#sabado" role="button" aria-expanded="false" aria-controls="viernes">
                                    <h5 class="card-title text-uppercase text-center fw-semibold mb-1 fs-15">Sábado</h5>
                                </a>
                            </div>
                            <!--end card-->
                            <div class="collapse show" id="sabado">
                                @foreach ($objdetalle as $lin => $record)
                                @if(isset($objdetalle[$lin][6]))
                                <div class="card mb-1">
                                    <div class="card-body">
                                        <a class="d-flex align-items-center" data-bs-toggle="collapse" href="#sabado{{$lin}}" role="button" aria-expanded="false" aria-controls="leadDiscovered1">
                                            <div class="flex-shrink-0">
                                                <!--<img src="{{ URL::asset('assets/images/users/avatar-1.jpg') }}" alt="" class="avatar-xs rounded-circle">-->
                                                <img src="{{ URL::asset('assets/images/svg/crypto-icons/audr.svg') }}" alt="" class="avatar-xs rounded-circle">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="fs-14 mb-1">{{$objdetalle[$lin][6]['asignatura']}}</h6>
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 avatar-xxs text-muted">
                                                        <i class="ri-time-line"></i>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <small class="text-muted">{{$objdetalle[$lin][6]['hora_ini']}} - {{$objdetalle[$lin][6]['hora_fin']}}</small>
                                                    </div>
                                                </div>
                                                <p class="text-muted mb-0">{{$objdetalle[$lin][6]['docente']}}</p>
                                            </div>
                                        </a>
                                    </div>
                                    <!--<div class="collapse border-top border-top-dashed" id="sabado{{$lin}}">
                                        <div class="card-body">
                                            <h6 class="fs-14 mb-1">Nesta Technologies <small class="badge bg-danger-subtle text-danger">4 Days</small></h6>
                                            <p class="text-muted">As a company grows however, you find it's not as easy to shout across</p>
                                            <ul class="list-unstyled vstack gap-2 mb-0">
                                                <li>
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 avatar-xxs text-muted">
                                                            <i class="ri-question-answer-line"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="mb-0">Meeting with Thomas</h6>
                                                            <small class="text-muted">Yesterday at 9:12AM</small>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 avatar-xxs text-muted">
                                                            <i class="ri-mac-line"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="mb-0">Product Demo</h6>
                                                            <small class="text-muted">Monday at 04:41PM</small>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 avatar-xxs text-muted">
                                                            <i class="ri-earth-line"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="mb-0">Marketing Team Meeting</h6>
                                                            <small class="text-muted">Monday at 04:41PM</small>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="card-footer hstack gap-2">
                                            <button class="btn btn-warning btn-sm w-100"><i class="ri-phone-line align-bottom me-1"></i> Call</button>
                                            <button class="btn btn-info btn-sm w-100"><i class="ri-question-answer-line align-bottom me-1"></i> Message</button>
                                        </div>
                                    </div>-->
                                </div>
                                @endif
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
            <!--<div class="card">
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
                                                        <div class="d-flex">
                                                            <div class="flex-grow-1">
                                                                <h6 class="mb-0">0<i class="ri-star-fill align-bottom text-warning"></i></h6>
                                                            </div>
                                                            <h6 class="flex-shrink-0 text-danger mb-0"><i class="ri-time-line align-bottom"></i>5</h6>
                                                        </div>
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
            <div>-->
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
