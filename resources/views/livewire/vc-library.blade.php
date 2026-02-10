<div>
   <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Explorar Libros</h5>
                        <div>
                            <a class="btn btn-success" data-bs-toggle="collapse" wire:click='add'><i class="mdi mdi-gamepad-round align-bottom"></i>  Agregar</a>
                        </div>
                    </div>
                    <div class="collaps show" id="collapseExample">
                        <div class="row mt-3 g-3">
                            <div class="col-sm-4">
                                <h6 class="text-uppercase fs-12 mb-2">Buscar</h6>
                                <input type="text" class="form-control" placeholder="Search product name" autocomplete="off" id="searchProductList" wire:model="filters.buscar">
                            </div>
                            <div class="col-sm-2">
                                <h6 class="text-uppercase fs-12 mb-2">Modalidad</h6>
                                <select class="form-control" data-choices name="select-category" data-choices-search-false id="select-category" wire:model="filters.modalidadId">
                                    <option value=""> --- Seleccione --- </option>
                                    @foreach($tblmodalidad as $modalidad)
                                        <option value="{{$modalidad->id}}">{{$modalidad->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <h6 class="text-uppercase fs-12 mb-2">Asignatura</h6>
                                <select class="form-control" data-choices name="file-type" data-choices-search-false id="file-type" wire:model="filters.asignaturaId">
                                    <option value=""> --- Seleccione --- </option>
                                    @foreach($tblasignaturas as $asignatura)
                                        <option value="{{$asignatura->id}}">{{$asignatura->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--<div class="col-lg-12">
            <div class="d-flex align-items-center mb-4">
                <div class="flex-grow-1">
                    <p class="text-muted fs-15 mb-0">Result: 8745</p>
                </div>
                <div class="flex-shrink-0">
                    <div class="dropdown">
                        <a class="text-muted fs-14 dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            All View
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>-->
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
                    <button type="button" class="btn btn-icon-{{$key}}" data-bs-toggle="button" aria-pressed="true" wire:click="eliminar({{$records->id}})"><i class="mdi mdi-delete-forever fs-16"></i></button>
                </div>
                <div class="card-body">
                    <p class="fw-medium mb-0 float-end"><i class="mdi mdi-hexagram text-success align-middle"></i></p>
                    <h5 class="mb-1"><a href="apps-nft-item-details">{{$records->nombre}}</a></h5>
                    <p class="text-muted mb-0">{{$records->autor}}</p>
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

    <div class="modal fade show" id="addBookModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content border-0">
                
                <div class="modal-body">
                    <form autocomplete="off" wire:submit.prevent="{{ $showEditModal ? 'updateData' : 'createData' }}" id="memberlist-form" class="needs-validation">
                        <div class="row">
                            <div class="col-lg-7">
                                <input type="hidden" id="memberid-input" class="form-control" value="">
                                <div class="px-4 pt-4 mb-3">
                                    <div class="modal-team-cover position-relative mb-0 mt-n4 mx-n4 rounded-top overflow-hidden">
                                        <!--<img src="{{ URL::asset('assets/images/small/img-9.jpg') }}" alt="" id="cover-img" class="img-fluid">-->
                                        @if (!empty($record['portada']))
                                            <img src="{{ $record['portada']->temporaryUrl() }}" alt="" class="card-img-top explore-img" >
                                        @else
                                            <img id="img-portada" src="{{ asset('assets/images/small/img-9.jpg') }}" alt="" class="card-img-top explore-img">
                                        @endif

                                        <div class="d-flex position-absolute start-0 end-0 top-0 p-3">
                                            <div class="flex-grow-1">
                                                <h5 class="modal-title text-white" id="createMemberLabel">Portada</h5>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <div class="d-flex gap-3 align-items-center">
                                                    <div>
                                                        <label for="cover-image-input" class="mb-0" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Select Cover Image" data-bs-original-title="Select Cover Image">
                                                            <div class="avatar-xs">
                                                                <div class="avatar-title bg-light border rounded-circle text-muted cursor-pointer">
                                                                    <i class="ri-image-fill"></i>
                                                                </div>
                                                            </div>
                                                        </label>
                                                        <input class="form-control d-none" value="" id="cover-image-input" type="file" accept="image/png, image/gif, image/jpeg" wire:model="record.portada">
                                                    </div>
                                                    <button type="button" class="btn-close btn-close-white" id="createMemberBtn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="teammembersName" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="teammembersName" placeholder="Ingrse Nombre" wire:model="record.nombre" required>
                                    <div class="invalid-feedback">Por favor, ingrese el nombre del libro</div>
                                </div>
                                <div class="mb-3">
                                    <label for="designation" class="form-label">Autor</label>
                                    <input type="text" class="form-control" id="designation" placeholder="Ingrese Autor" wire:model="record.autor" required>
                                    <div class="invalid-feedback">Por favor, ingrese el autor del libro</div>
                                </div>
                                <div class="mb-3">
                                    <label for="designation" class="form-label">Asignatura</label>
                                    <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false  wire:model="record.asignaturaId" required>
                                        <option value="">Seleccione Asignatura</option>
                                        <option value=""> --- Seleccione ---- </option>
                                        @foreach ($tblasignaturas as $asignatura) 
                                        <option value="{{$asignatura->id}}">{{$asignatura->descripcion}}</option>
                                        @endforeach 
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Cursos</h5>
                                    </div>
                                    <div class="card-body">
                                        <ul class="nav nav-tabs nav-tabs-custom nav-success mb-3" role="tablist">
                                        @foreach ($tblparalelo as $modalidad => $niveles)
                                        <li class="nav-item">
                                            <a class="nav-link {{ $modalidad == 'Presencial' ? 'active' : '' }} py-3" data-bs-toggle="tab" id="{{$modalidad}}" href="#detalle-{{$modalidad}}" role="tab"
                                                aria-selected="true">
                                                <i class=" me-1 align-bottom"></i> {{$modalidad}}
                                            </a>
                                        </li>
                                        @endforeach
                                        <div class="tab-content text-muted">
                                            @foreach ($tblparalelo as $modalidad => $niveles)
                                                <div class="tab-pane fade {{ $modalidad == 'Presencial' ? 'show active' : '' }}"
                                                    id="detalle-{{$modalidad}}"
                                                    role="tabpanel">
                                                    @foreach ($niveles as $nivel => $cursos)
                                                        <li>
                                                            <em>{{ $nivel }}</em>
                                                            <ul>
                                                                @foreach ($cursos as $curso)
                                                                    <li>
                                                                        <label>
                                                                            <input type="checkbox" wire:model.defer="selectedCursos" value="{{ $curso->id }}">
                                                                            {{ $curso->curso }}
                                                                        </label>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </li>
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        </div>
                                        </ul>
                                        <!--@foreach ($tblparalelo as $modalidad => $niveles)
                                        <strong>{{ $modalidad }}</strong>
                                        <ul>
                                            @foreach ($niveles as $nivel => $cursos)
                                                <li>
                                                    <em>{{ $nivel }}</em>
                                                    <ul>
                                                        @foreach ($cursos as $curso)
                                                            <li>
                                                                <label>
                                                                    <input type="checkbox" wire:model="selectedCursos" value="{{ $curso->id }}">
                                                                    {{ $curso->curso }}
                                                                </label>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @endforeach
                                        </ul>
                                        @endforeach-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="designation" class="form-label">Archivo</label>
                            <div class="input-group">
                            <input type="file" id="file" wire:model="record.archivo"  accept=".pdf" class="form-control" required>
                            {{-- Indicador de carga --}}
                            </div>
                            <div wire:loading wire:target="record.archivo" class="text-danger" required>
                                Cargando archivo...
                            </div>
                        </div>
                        @if ($errors->has('record.archivo'))
                            <div class="alert alert-danger">
                                {{ $errors->first('record.archivo') }}
                            </div>
                        @endif
                        <div class="hstack gap-2 justify-content-end">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-success" id="addNewMember">Grabar</button>
                        </div>
                        

                    </form>
                </div>
            </div>
            <!--end modal-content-->
        </div>
        <!--end modal-dialog-->
    </div>
</div>