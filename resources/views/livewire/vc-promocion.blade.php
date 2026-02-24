<div>
    <form autocomplete="off" id="certificado_form">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row g-3">
                        <div class="col-xxl-4 col-sm-4">
                            <select class="form-select" name="cmbperiodo" wire:model="tipoDoc" disabled>
                                <option value="PP">Certificado de Promoción</option>
                            </select>
                        </div>
                        <div class="col-xxl-2 col-sm-4">
                            <select class="form-select" name="cmbperiodo" wire:model="periodoId">
                                <option value="">Periodo Lectivo</option>
                                @foreach ($tblperiodos as $recno)
                                    <option value="{{$recno->id}}">{{$recno->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xxl-4 col-sm-4">
                        </div>
                        <div class="col-xxl-2 col-sm-4">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <p style="margin-top:0; margin-bottom:0;">Error!, Existen campos vacios..</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xxl-2 mb-3">
                            <label class="form-label" for="project-title-input">Emisión</label>
                            <input type="date" class="form-control" id="fechaActual" data-provider="flatpickr" data-date-format="d-m-Y" data-time="true" wire:model="fecha" disabled> 
                        </div>
                        <div class="col-xxl-10 mb-3">
                            <label class="form-label" for="project-title-input">Estudiante</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="estudiante-input" placeholder="Nombres Completos"  wire:model="nombres" required>
                                <a class="btn btn-info add-btn" wire:click="search()"><i class="ri-user-search-fill me-1 align-bottom"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xxl-4 mb-3">
                            <label class="form-label" for="project-title-input">Identificación</label>
                            <input type="text" class="form-control" id="nui-input" wire:model="nui" disabled>
                        </div>
                        <div class="col-xxl-6 mb-3">
                            <label class="form-label" for="project-title-input">Curso</label>
                            <select class="form-select" name="cmbperiodo" wire:model="cursoId" disabled>
                                <option value="">-</option>
                                @foreach ($tblcursos as $curso)
                                    <option value="{{$curso->id}}">{{$curso->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xxl-6 mb-3">
                            <label class="form-label" for="project-title-input">Promovido</label>
                            <select class="form-select" name="cmbperiodo" wire:model="paseCursoId" required>
                                <option value="">-</option>
                                @foreach ($tblcursos as $curso)
                                    <option value="{{$curso->id}}">{{$curso->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-header">
                            <label class="form-label">Firman</label>
                        </div>
                        <div class="card-body text-center mb-3">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <input type="text" class="form-control border-0 text-center" name="identidad" id="billinginfo-firstName" placeholder="" wire:model="rector">
                                        <label class="form-label" for="project-title-input">RECTORADO</label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <input type="text" class="form-control border-0 text-center" name="identidad" id="billinginfo-firstName" placeholder="" wire:model="secretaria">
                                        <label class="form-label" for="project-title-input">SECRETARIA GENERAL</label>
                                    </div>
                                </div>
                            </div>                                                            
                        </div>
                        <!-- end card body -->
                    </div>
                    
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->

            
            <!-- end card -->
            <div class="text-end mb-4">
                <button type="button" class="btn btn-danger w-sm" wire:click='print("P")'><i class="ri-printer-line align-bottom me-1"></i>Imprimir</button>
                <button type="button" class="btn btn-success w-sm" wire:click='print("D")'><i class="ri-download-2-line align-bottom me-1"></i>PDF</button>
            </div>
        </div>
        <!-- end col -->
        <div class="col-lg-4"> 
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Ficha</h5>
                </div>
                <div class="card-body text-center mb-3">
                    <img src="@if ($foto != '') {{ URL::asset('storage/fotos/'.$foto) }}@else{{ URL::asset('assets/images/users/sin-foto.jpg') }} @endif"
                    class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="user-profile-image">                                                    
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Datos</h5>
                </div>
                <div class="card-body">
                    <fieldset {{$control}}>
                    <div class="mb-3">
                        <label for="choices-categories-input" class="form-label">Documento No.</label>
                        <input type="text" class="form-control" id="documento-input" placeholder="Documento" wire:model="documento">
                    </div>
                    <div class="mb-3">
                        <label for="choices-categories-input" class="form-label">Fecha Registro</label>
                        <input type="date" class="form-control" id="fechaActual" data-provider="flatpickr" data-date-format="d-m-Y" data-time="true" wire:model="fechaMatricula"> 
                    </div>
                    <div class="mb-3">
                        <label for="choices-categories-input" class="form-label">Folio No.</label>
                        <input type="text" class="form-control" id="folio-input" placeholder="Folio" wire:model="folio">
                    </div>
                    <div class="mb-3">
                        <label for="choices-categories-input" class="form-label">Matricula No.</label>
                        <input type="text" class="form-control" id="matricula-input" placeholder="Matricula" wire:model="matricula">
                    </div>
                    </fieldset>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->


        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
    </form>



    <!-- Modal -->
    <div class="modal fade" id="inviteMembersModal" tabindex="-1" aria-labelledby="inviteMembersModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header p-3 ps-4 bg-soft-success">
                    <h5 class="modal-title" id="inviteMembersModalLabel">Members</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="search-box mb-3">
                        <input type="text" class="form-control bg-light border-light" placeholder="Search here...">
                        <i class="ri-search-line search-icon"></i>
                    </div>

                    <div class="mb-4 d-flex align-items-center">
                        <div class="me-2">
                            <h5 class="mb-0 fs-13">Members :</h5>
                        </div>
                        <div class="avatar-group justify-content-center">
                            <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip"
                                data-bs-trigger="hover" data-bs-placement="top" title="Brent Gonzalez">
                                <div class="avatar-xs">
                                    <img src="{{ URL::asset('build/images/users/avatar-3.jpg') }}" alt="" class="rounded-circle img-fluid">
                                </div>
                            </a>
                            <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip"
                                data-bs-trigger="hover" data-bs-placement="top" title="Sylvia Wright">
                                <div class="avatar-xs">
                                    <div class="avatar-title rounded-circle bg-secondary">
                                        S
                                    </div>
                                </div>
                            </a>
                            <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip"
                                data-bs-trigger="hover" data-bs-placement="top" title="Ellen Smith">
                                <div class="avatar-xs">
                                    <img src="{{ URL::asset('build/images/users/avatar-4.jpg') }}" alt="" class="rounded-circle img-fluid">
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="mx-n4 px-4" data-simplebar style="max-height: 225px;">
                        <div class="vstack gap-3">
                            <div class="d-flex align-items-center">
                                <div class="avatar-xs flex-shrink-0 me-3">
                                    <img src="{{ URL::asset('build/images/users/avatar-2.jpg') }}" alt="" class="img-fluid rounded-circle">
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="fs-13 mb-0"><a href="#" class="text-body d-block">Nancy Martino</a>
                                    </h5>
                                </div>
                                <div class="flex-shrink-0">
                                    <button type="button" class="btn btn-light btn-sm">Add</button>
                                </div>
                            </div>
                            <!-- end member item -->
                            <div class="d-flex align-items-center">
                                <div class="avatar-xs flex-shrink-0 me-3">
                                    <div class="avatar-title bg-soft-danger text-danger rounded-circle">
                                        HB
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="fs-13 mb-0"><a href="#" class="text-body d-block">Henry Baird</a></h5>
                                </div>
                                <div class="flex-shrink-0">
                                    <button type="button" class="btn btn-light btn-sm">Add</button>
                                </div>
                            </div>
                            <!-- end member item -->
                            <div class="d-flex align-items-center">
                                <div class="avatar-xs flex-shrink-0 me-3">
                                    <img src="{{ URL::asset('build/images/users/avatar-3.jpg') }}" alt="" class="img-fluid rounded-circle">
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="fs-13 mb-0"><a href="#" class="text-body d-block">Frank Hook</a></h5>
                                </div>
                                <div class="flex-shrink-0">
                                    <button type="button" class="btn btn-light btn-sm">Add</button>
                                </div>
                            </div>
                            <!-- end member item -->
                            <div class="d-flex align-items-center">
                                <div class="avatar-xs flex-shrink-0 me-3">
                                    <img src="{{ URL::asset('build/images/users/avatar-4.jpg') }}" alt="" class="img-fluid rounded-circle">
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="fs-13 mb-0"><a href="#" class="text-body d-block">Jennifer Carter</a>
                                    </h5>
                                </div>
                                <div class="flex-shrink-0">
                                    <button type="button" class="btn btn-light btn-sm">Add</button>
                                </div>
                            </div>
                            <!-- end member item -->
                            <div class="d-flex align-items-center">
                                <div class="avatar-xs flex-shrink-0 me-3">
                                    <div class="avatar-title bg-soft-success text-success rounded-circle">
                                        AC
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="fs-13 mb-0"><a href="#" class="text-body d-block">Alexis Clarke</a>
                                    </h5>
                                </div>
                                <div class="flex-shrink-0">
                                    <button type="button" class="btn btn-light btn-sm">Add</button>
                                </div>
                            </div>
                            <!-- end member item -->
                            <div class="d-flex align-items-center">
                                <div class="avatar-xs flex-shrink-0 me-3">
                                    <img src="{{ URL::asset('build/images/users/avatar-7.jpg') }}" alt="" class="img-fluid rounded-circle">
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="fs-13 mb-0"><a href="#" class="text-body d-block">Joseph Parker</a>
                                    </h5>
                                </div>
                                <div class="flex-shrink-0">
                                    <button type="button" class="btn btn-light btn-sm">Add</button>
                                </div>
                            </div>
                            <!-- end member item -->
                        </div>
                        <!-- end list -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light w-xs" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success w-xs">Invite</button>
                </div>
            </div>
            <!-- end modal-content -->
        </div>
        <!-- modal-dialog -->
    </div>
    <!-- end modal -->

    <div wire.ignore.self class="modal fade" id="showModalBuscar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" >
            <div class="modal-content modal-content border-0">
                
                <div class="modal-header p-3 bg-light">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <span> Buscar Estudiante &nbsp;</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                </div>
                
                <form autocomplete="off" wire:submit.prevent="">
                    <div class="modal-body">                                        
                            @livewire('vc-modal-search',['opcion' => 'PROMOCION'])                                      
                    </div>
                    <div class="modal-footer">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
                
            </div>
        </div>
    </div>

</div>
