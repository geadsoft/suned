<div>
   
    <div class="row mt-4">
         @foreach ($tblrecords as $record) 
        <div class="col-xl-3 col-lg-6">
            <div class="card ribbon-box right overflow-hidden">
                <div class="card-body text-center p-4">
                    <!--<div class="ribbon ribbon-info ribbon-shape trending-ribbon"><i
                            class="ri-flashlight-fill text-white align-bottom"></i> <span
                            class="trending-ribbon-text">Trending</span></div>-->
                    <img src="{{ URL::asset('assets/images/companies/img-1.png') }}" alt="" height="45">
                    <h5 class="mb-1 mt-4"><a href="{{URL::asset('/apps-ecommerce-seller-details')}}" class="link-primary">{{$record['asignatura']}}</a></h5>
                    <p class="text-muted mb-4">{{$record['docente']}}</p>
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div id="chart-seller1" data-colors='["--vz-danger"]'></div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-lg-4 border-end-dashed border-end">
                            <h5>0</h5>
                            <span class="text-muted">Recursos</span>
                        </div>
                        <div class="col-lg-4">
                            <h5>{{$record['actividad']}}</h5>
                            <span class="text-muted">Actividades</span>
                        </div>
                        <div class="col-lg-4">
                            @if($record['clases']>0)
                                <h5><i class="ri-vidicon-line fs-18 text-success"></i></h5>
                            @else
                                <h5><i class="las la-video-slash fs-18"></i></h5>
                            @endif
                            <span class="text-muted">Clase Virtual</span>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="/student/subject-view/{{$record['data']}}" class="btn btn-light w-100">Ver Detalle</a>
                    </div>
                </div>
            </div>
        </div>
         @endforeach
    </div>
   
    <!--end row-->
</div>
