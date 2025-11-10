<div>
   <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Explorar Libros</h5>
                        <!--<div>
                            <a class="btn btn-success" data-bs-toggle="collapse" wire:click='add'><i class="mdi mdi-gamepad-round align-bottom"></i>  Agregar</a>
                        </div>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
    <div class="row row-cols-xxl-5 row-cols-xl-4 row-cols-lg-3 row-cols-md-2 row-cols-1" id="explorecard-list">
         @foreach($tblrecords as $key => $records)
        <div class="col list-element">
            <div class="card explore-box card-animate">
                <div class="explore-place-bid-img">
                    <input type="hidden" class="form-control" id="prodctData-{{$key}}">
                    <div class="d-none"></div>
                    <img src="{{asset(str_replace('public/', '', $records->portada))}}" alt="" class="card-img-top explore-img" />
                    <div class="bg-overlay"></div>
                    <div class="place-bid-btn">
                        <a href="/subject/flipbook-viewer/{{$records->drive_id}}" class="btn btn-success" target="_blank"><i class="ri-share-box-fill align-bottom me-1"></i>Visualizar</a>
                    </div>
                </div>
                <div class="bookmark-icon position-absolute top-0 end-0 p-2">
                    <button type="button" class="btn btn-icon-{{$key}}" data-bs-toggle="button" aria-pressed="true"><i class="mdi mdi-cards-heart fs-16"></i></button>
                </div>
                <div class="card-body">
                    <p class="fw-medium mb-0 float-end"><i class="mdi mdi-hexagram text-success align-middle"></i></p>
                    <h5 class="mb-1"><a href="apps-nft-item-details">{{$records->nombre}}</a></h5>
                    <p class="text-muted mb-0">Autor: {{$records->autor}}</p>
                </div>
                <div class="card-footer border-top border-top-dashed">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 fs-14">
                            <i class="ri-price-tag-3-fill text-warning align-bottom me-1"></i> Asignatura: <span class="fw-medium">{{$records->asignatura->descripcion}}</span>
                        </div>
                        <!--<h5 class="flex-shrink-0 fs-14 text-primary mb-0">'+ prodctData.price + 'ETH</h5>-->
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>