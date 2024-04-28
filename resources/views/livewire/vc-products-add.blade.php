<div>
    <form id="createproduct-form" autocomplete="off" wire:submit.prevent="{{ 'createData' }}" class="needs-validation">
        <div class="row">
            <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                                
                                <div class="mb-3">
                                    <label class="form-label" for="product-title-input">Código</label>
                                    <input type="hidden" class="form-control" id="formAction" name="formAction" value="add">
                                    <input type="text" class="form-control d-none" id="product-id-input">
                                    <input type="text" class="form-control" id="product-title-input" value="" placeholder="Ingrese cóidgo de producto" wire:model.defer="codigo" readonly>
                                    <div class="invalid-feedback">Por favor ingrese código de producto.</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="product-title-input">Nombre</label>
                                    <input type="hidden" class="form-control" id="formAction" name="formAction" value="add">
                                    <input type="text" class="form-control d-none" id="product-id-input">
                                    <input type="text" class="form-control" id="product-title-input" value="" placeholder="Ingrese nombre de producto" wire:model.defer="nombre" required>
                                    <div class="invalid-feedback">Por favor ingrese código de producto.</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="product-title-input">Descripción</label>
                                    <textarea class="form-control" id="billingAddress" rows="3" placeholder="Descripción de producto" wire:model.defer="descripcion"></textarea>
                                </div>
                        </div>
                    </div>
                    <!-- end card -->

                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-tabs-custom card-header-tabs border-bottom-0" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#addproduct-general-info"
                                        role="tab">
                                        Información General
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- end card header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="addproduct-general-info" role="tabpanel">
                                    <div class="row">
                                        <div class="col-lg-3 col-sm-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="manufacturer-name-input">Unidad</label>
                                                <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false wire:model.defer="unidad" disabled>
                                                    <option value="UND" selected>Unidad</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="manufacturer-name-input">Talla</label>
                                                <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false wire:model.defer="talla" {{( $productoId>0 ) ? "disabled" : ''}}>
                                                    <option value="">Seleccione talla</option>
                                                    @foreach ($arrtalla as $key)
                                                        <option value="{{$key}}">{{$key}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="manufacturer-name-input">Tipo IVA</label>
                                                <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false wire:model.defer="tipoiva" required>
                                                    <option value="0" selected>Tarifa 0%</option>
                                                    <option value="2">Tarifa 12%</option>
                                                    <option value="3">Tarifa 14%</option>
                                                    <option value="4">Tarifa 15%</option>
                                                    <option value="5">Tarifa 5%</option>
                                                    <option value="6">No Objeto de Impuesto</option>
                                                    <option value="7">Exento de IVA</option>
                                                    <option value="8">IVA diferenciado</option>
                                                    <option value="10">Tarifa 13%</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-sm-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="stocks-input">Stocks</label>
                                                <input type="number" class="form-control" id="stocks-input" placeholder="Stocks" wire:model.defer="stock" disabled>
                                                <div class="invalid-feedback">Please Enter a product stocks.</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="product-discount-input">Stock Minimo</label>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="product-discount-addon"></span>
                                                    <input type="number" class="form-control" id="stocks-min-input" step="0.01" placeholder="0.00" aria-label="discount" aria-describedby="product-discount-addon" wire:model.defer="stockmin">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="product-price-input">Precio</label>
                                                <div class="input-group has-validation mb-3">
                                                    <span class="input-group-text" id="product-price-addon">$</span>
                                                    <input type="number" class="form-control" id="product-price-input" step="0.01" placeholder="0.00" aria-label="Price" aria-describedby="product-price-addon" wire:model.defer ="precio" required>
                                                    <div class="invalid-feedback">Por favor ingrese precio del producto.</div>
                                                </div>

                                            </div>
                                        </div>
                                        <!-- end col -->
                                    </div>
                                    <!-- end row -->
                                   
                                        <div class="mb-3">
                                            <label class="form-label" for="manufacturer-name-input"></label>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" wire:model="controlastock" required>
                                                    <label class="form-check-label" for="estado">Maneja Stocks</label>
                                                </div>
                                        </div>
                                    
                                </div>
                                <!-- end tab-pane -->

                                
                            </div>
                            <!-- end tab content -->
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->
                    <div class="text-end mb-3">
                        <button type="submit" class="btn btn-success w-sm">Grabar</button>
                    </div>
            </div>
            <!-- end col -->

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Imagen</h5>
                    </div>
                    <div class="card-body text-center">
                        <div class="mb-4">
                            <h5 class="fs-14 mb-1">Imagen del producto</h5>
                            <p class="text-muted">Agregar imagen principal del producto.</p>
                            <div class="text-center">
                                <div class="position-relative d-inline-block mx-auto  mb-4">
                                    <div class="position-absolute top-100 start-100 translate-middle">
                                        <label for="product-image-input" class="mb-0"  data-bs-toggle="tooltip" data-bs-placement="right" title="Select Image">
                                            <div class="avatar-xs">
                                                <div class="avatar-title bg-light border rounded-circle text-muted cursor-pointer">
                                                    <i class="ri-image-fill"></i>
                                                </div>
                                            </div>
                                        </label>
                                        <input class="form-control d-none" value="" id="product-image-input" type="file"
                                            accept="image/png, image/gif, image/jpeg" wire:model="fileimg">
                                    </div>
                                    <div class="avatar-lg">
                                        <div class="avatar-title bg-light rounded">
                                            <!--<img src="" id="product-img" class="avatar-md h-auto" />-->
                                            @if ($fileimg)
                                                <img src="{{ $fileimg->temporaryURL() }}"
                                                    class="avatar-xl h-auto" alt="user-profile-image">
                                            @else
                                                <img src="@if ($foto != '') {{ URL::asset('storage/fotos/'.$foto) }}@else{{ URL::asset('assets/images/products/producto-sin-imagen.jpg') }} @endif"
                                                    class="avatar-xl h-auto" alt="user-profile-image">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                        <br>
                        </div>
                     </div>
                 </div>
                <div class="card">
                    <!--<div class="card-header">
                        <h5 class="card-title mb-0">Publish</h5>
                    </div>-->
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="choices-publish-status-input" class="form-label">Estado</label>
                            <select class="form-select" id="choices-publish-status-input" wire:model.defer="estado" required>
                                <option value="A" selected>Activo</option>
                                <option value="I">Inactivo</option>
                            </select>
                        </div>
                        <div>
                            <label for="choices-publish-visibility-input" class="form-label">Tipo</label>
                            <select class="form-select" id="choices-publish-visibility-input" wire:model.defer="tipo">
                                <option value="B" selected>Bien</option>
                                <option value="S">Servicio</option>
                            </select>
                        </div>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Categoria</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-2">Seleccione Categoria de Producto</p>
                            <select class="form-select" id="choices-category-input" name="choices-category-input" wire:model.defer="categoria"  {{( $productoId>0 ) ? "disabled" : ''}} required>
                                <option value="">...</option>
                                @foreach ($tblcategorias as $categoria)
                                    <option value="{{$categoria['id']}}">{{$categoria['descripcion']}}</option>
                                @endforeach
                            </select>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
                

            </div>
        </div>
        <!-- end row -->
    </form>
</div>
