<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row g-3">
                        <div class="col-xxl-4 col-sm-4">
                            <select class="form-select" name="cmbperiodo" wire:model="tipoDoc">
                                <option value="MF">Matricula con Folio</option>
                                <option value="MA">Matricula</option>
                                <option value="PA">Pasantias</option>
                                <option value="CO">Conducta</option>
                                <option value="AP">Aprovechamiento</option>
                                <option value="PR">Pase Reglamentario</option>
                                <option value="AR">Aceptacion Pase Reglamentario</option>
                                <option value="RR">Rezago con Refrendación</option>
                                <option value="SD">Constancia Subsecretaria y Distrito</option>
                                <option value="ND">No Constancia Subsecretaria y Distrito</option>
                                <option value="LI">Libreta</option>
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
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label" for="project-title-input">Estudiante</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="estudiante-input" placeholder="Nombres Completos"  wire:model="nombres" required>
                            <a class="btn btn-info add-btn" wire:click="search()"><i class="ri-user-search-fill me-1 align-bottom"></i></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xxl-4 mb-3">
                            <label class="form-label" for="project-title-input">Identificación</label>
                            <input type="text" class="form-control" id="nui-input" placeholder="Identificación" wire:model="nui" required>
                        </div>
                        <div class="col-xxl-8 mb-3">
                            <label class="form-label" for="project-title-input">Curso/Paralelo</label>
                            <select class="form-select" name="cmbperiodo" wire:model="cursoId" required>
                                <option value="">Curso</option>
                                @foreach ($tblcursos as $curso)
                                    <option value="{{$curso->id}}">{{$curso->servicio->descripcion}} {{$curso->paralelo}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        @if ($tipoDoc=='PA')
                        <div class="col-xxl-8 mb-3">
                            <label class="form-label" for="project-title-input">Especialización</label>
                            <input type="text" class="form-control" id="bachilleren" placeholder="Especializacion" wire:model="bachilleren">
                        </div>
                        @endif
                        @if ($tipoDoc=='CO')
                        <div class="col-xxl-4 mb-3">
                            <label class="form-label" for="project-title-input">Conducta Cualitativa</label>
                            <select class="form-select" name="cmbperiodo" wire:model="escala">
                                <option value="">Seleccione Conducta</option>
                                <option value="A">Muy Satisfactorio</option>
                                <option value="B">Satisfactorio</option>
                                <option value="C">Poco Satisfactorio</option>
                                <option value="D">Mejorable</option>
                                <option value="E">Insatisfactorio</option>
                            </select>
                        </div>
                        @endif
                        <div class="col-xxl-2 mb-3">
                           @if ($tipoDoc=='CO' || $tipoDoc=='AP')
                            <label class="form-label" for="project-title-input">Nota</label>
                            <input type="text" class="form-control" id="nota" placeholder="nota" wire:model="nota">
                            @endif
                        </div>
                    </div> 
                    <div class="row mb-3">
                        <div class="mb-3">
                            <label class="form-label"></label>
                            @if ($tipoDoc=='MF')
                                <div id="ckeditor-classic">
                                    <p><strong>Certifico:</strong></p>
                                    <p>Que el (la) alumno <strong>{{$nombres}}</strong> previo el cumplimiento de los registros legales y reglamentarios se matriculo en el 
                                    <strong>{{$nomcurso}}</strong> en la jornada matutina de este plantel</p> 
                                    <p>asi consta registrado en el libro de matricula correspondiente al año lectivo</p>
                                    <p><strong>{{$periodo}}</strong></p>
                                    <div class="row">
                                        <div class="col-xxl-3">
                                            <p><strong>FOLIO N. {{$folio}}</strong></p>
                                        </div>
                                        <div class="col-xxl-3">
                                            <p><strong>MATRICULA N. {{$matricula}}</strong></p>
                                        </div>
                                    </div>                          
                                </div>
                            @endif
                            @if ($tipoDoc=='MA')
                                <div id="ckeditor-classic">
                                    <p>El Rectorado y la Secretaría de la Unidad Educativa American School certifica que el (la) alumno 
                                    <strong>{{$nombres}}</strong> con C.I. <strong>{{$nui}}</strong> del 
                                    <strong>{{$nomcurso}}</strong>, estuvo matriculado (a) en el periodo <strong>{{$periodo}}</strong>
                                    , con código AMIE 09H02249 en la Secretaría de Educación</p>
                                    <p>CORREO: info@americanschool.edu.ec - PAGINA WEB: www.americanschool.edu.ec</p>
                                    <div class="row">
                                        <div class="col-xxl-12">
                                            <p><br><br>Así consta en los registros del plantel a los cuales me remito</p>
                                        </div>
                                    </div>                          
                                </div>
                            @endif
                            @if ($tipoDoc=='PA')
                                <div id="ckeditor-classic">
                                <p>Mediante el presente documento se Certifica que el (la) estudiante: <strong>{{$nombres}}</strong>, titular de la
                                cédula de identidad {{$nui}}, <strong>{{$bachilleren}} de la Unidad Educativa AMERICAN SCHOOL</strong>, desempeño y
                                desarrolló las Actividades y Tareas programadas durante su Pasantías en nuestra Institución, por un total de 120 Horas,
                                demostrando alto compromiso de responsabilidad, dedicación, y cumplimiento de labores asignadas.<br><br>
                                Certificado que se expide a petición de la parte interesada en la ciudad de Guayaquil a los {{date('d',strtotime($fecha))}}
                                días del mes de {{$mes[(int)date('m',strtotime($fecha))]}} de {{date('Y',strtotime($fecha))}}.
                                </p>
                                </div>
                            @endif
                            @if ($tipoDoc=='CO')
                                <div id="ckeditor-classic">
                                <p>El suscrito Rectorado y Secretaìa del colegio particular "AMERICAN SCHOOL" Certifica que el (la) Sr (Srta): 
                                <strong>{{$nombres}}</strong>, Obtuvo la siguiente conducta en el <strong>{{$bachilleren}}</strong>.<br><br></p>
                                <div class="row">
                                    <div class="col-xxl-3">
                                        <p><strong>{{$escala}}</strong>({{$nota}})<strong> EN CONDUCTA</strong></p>
                                    </div>
                                    <div class="col-xxl-3">
                                        <p>En el periodo Lectivo <strong>{{$periodo}}</strong></p>
                                    </div>
                                </div>
                                <p><br><br> Así consta en los registros del plantel a los cuales me remito de uds.
                                </p>
                                </div>
                            @endif
                            @if ($tipoDoc=='AP')
                                <div id="ckeditor-classic">
                                <p>El Rectorado y Secretaría de la Unidad Educativa "AMERICAN SCHOOL" Certifica que el Alumno (a)
                                <strong>{{$nombres}}</strong>,con C.I <strong>{{$nui}}</strong> Alumno del <strong>{{$bachilleren}}</strong>,
                                periodo lectivo <strong>{{$periodo}}</strong>, obtuvo el siguiente aprovechamiento:</p>
                                <div class="row">
                                    <div class="col-xxl-3">
                                        <p>({{$nota}}) {{$escala}}</p>
                                    </div>
                                </div>
                                <p><br><br> Así consta en los registros del plantel a los cuales me remito de uds.
                                </p>
                                </div>
                            @endif
                            @if ($tipoDoc=='PR')
                                <div id="ckeditor-classic">
                                <p>Agradeciéndole de antemano por su gentil gestión solicito a Ud muy respetuosamente el pase reglamentario
                                para que el Sr (ita) <strong>{{$nombres}} con C.I. {{$nui}}</strong>, pueda contiuar sus estudios en nuestro
                                plantel en el {{$bachilleren}} en el actual periodo {{$periodo}}.<br><br>
                                de Uds.
                                </p>
                                </div>
                            @endif
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
                <button type="button" class="btn btn-danger w-sm" wire:click='print'><i class="ri-printer-line align-bottom me-1"></i> Print</button>
                <button type="submit" class="btn btn-success w-sm"><i class="ri-download-2-line align-bottom me-1"></i>Download PDF</button>
            </div>
        </div>
        <!-- end col -->
        <div class="col-lg-4">
            @if ($tipoDoc != 'PR')
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
            @endif

            <div class="card">
                @if ($tipoDoc != 'PR')
                <div class="card-header">
                    <h5 class="card-title mb-0">Matrícula</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="choices-categories-input" class="form-label">Documento No.</label>
                        <input type="text" class="form-control" id="project-title-input" placeholder="Documento" wire:model="documento">
                    </div>
                    <div class="mb-3">
                        <label for="choices-categories-input" class="form-label">Fecha Registro</label>
                        <input type="date" class="form-control" id="fechaActual" data-provider="flatpickr" data-date-format="d-m-Y" data-time="true" wire:model="fecha"> 
                    </div>
                    <div class="mb-3">
                        <label for="choices-categories-input" class="form-label">Folio No.</label>
                        <input type="text" class="form-control" id="project-title-input" placeholder="Folio" wire:model="folio">
                    </div>
                    <div class="mb-3">
                        <label for="choices-categories-input" class="form-label">Matricula No.</label>
                        <input type="text" class="form-control" id="project-title-input" placeholder="Matricula" wire:model="matricula">
                    </div>
                </div>
                @endif 
                @if ($tipoDoc == 'PR')
                <div class="card-header">
                    <h5 class="card-title mb-0">Datos</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="choices-categories-input" class="form-label">Fecha Solicitud</label>
                        <input type="date" class="form-control" id="fechaActual" data-provider="flatpickr" data-date-format="d-m-Y" data-time="true" wire:model="dtfecha"> 
                    </div>
                    <div class="mb-3">
                        <label for="choices-categories-input" class="form-label">Titulo</label>
                        <input type="text" class="form-control" id="project-title-input" placeholder="Titulo" wire:model="dttitulo" required>
                    </div>
                    <div class="mb-3">
                        <label for="choices-categories-input" class="form-label">Rector</label>
                        <input type="text" class="form-control" id="project-title-input" placeholder="Rector" wire:model="dtnombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="choices-categories-input" class="form-label">Institución</label>
                        <input type="text" class="form-control" id="project-title-input" placeholder="Institucion" wire:model="dtinstitucion" required>
                    </div>
                    <div class="mb-3">
                        <label for="choices-categories-input" class="form-label">Ciudad</label>
                        <input type="text" class="form-control" id="project-title-input" placeholder="Institucion" wire:model="dtciudad" required>
                    </div>
                </div>
                @endif 
                <!-- end card body -->
            </div>
            <!-- end card -->


        </div>
        <!-- end col -->
    </div>
    <!-- end row -->



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
                            @livewire('vc-modal-search',['opcion' => 'cert'])                                      
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
