<div>
    <form autocomplete="off" id="certificado_form">
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
                                <option value="ER">Emisión Pase Reglamentario</option>
                                <option value="RR">Rezago con Refrendación</option>
                                <option value="SD">Constancia Subsecretaria y Distrito</option>
                                <option value="ND">No Constancia Subsecretaria y Distrito</option>
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
                    @if($tipoDoc=='PP')
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
                    @else
                    <div class="row">
                        <div class="mb-3">
                            <label class="form-label" for="project-title-input">Estudiante</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="estudiante-input" placeholder="Nombres Completos"  wire:model="nombres" required>
                                <a class="btn btn-info add-btn" wire:click="search()"><i class="ri-user-search-fill me-1 align-bottom"></i></a>
                            </div>
                        </div>
                        <div class="col-xxl-4 mb-3">
                            <label class="form-label" for="project-title-input">Identificación</label>
                            <input type="text" class="form-control" id="nui-input" placeholder="Identificación" wire:model="nui" required>
                        </div>
                        @if($tipoDoc!='RR' && $tipoDoc!='SD' && $tipoDoc!='ND')
                        <div class="col-xxl-2 mb-3">
                            <label class="form-label" for="project-title-input">Periodo Lectivo</label>
                            <input type="text" class="form-control" id="periodo-input" placeholder="Periodo Lectivo" wire:model="periodo" required>
                        </div>
                        <div class="col-xxl-6 mb-3">
                            <label class="form-label" for="project-title-input">Curso</label>
                            <select class="form-select" name="cmbperiodo" wire:model="cursoId" required>
                                <option value="">Curso</option>
                                @foreach ($tblcursos as $curso)
                                    <option value="{{$curso->id}}">{{$curso->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                        @if($tipoDoc=='RR' || $tipoDoc=='SD' )
                        <div class="col-xxl-2 mb-3">
                            <label class="form-label" for="project-title-input">Periodo Lectivo</label>
                            <input type="text" class="form-control" id="periodo-input" placeholder="Periodo Lectivo" wire:model="periodo" required>
                        </div>
                        <div class="col-xxl-6 mb-3">
                            <label class="form-label" for="project-title-input">Especialización</label>
                            <input type="text" class="form-control" id="bachilleren" placeholder="Especializacion" wire:model="bachilleren">
                        </div>
                        @endif
                        @if( $tipoDoc=='ND' )
                        <div class="col-xxl-6 mb-3">
                            <label class="form-label" for="project-title-input">Periodo Lectivo</label>
                            <input type="text" class="form-control" id="periodo-input" placeholder="Periodo Lectivo" wire:model="periodo" required>
                        </div>
                        @endif

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
                        @if ($tipoDoc=='AP')
                        <div class="col-xxl-4 mb-3">
                            <label class="form-label" for="project-title-input">Escala Calificación</label>
                            <select class="form-select" name="cmbperiodo" wire:model="escala">
                                <option value="">Seleccione</option>
                                <option value="EX">Excelente</option>
                                <option value="MB">Muy Bueno</option>
                                <option value="B">Bueno</option>
                                <option value="R">Regular</option>
                            </select>
                        </div>
                        @endif
                        <div class="col-xxl-2 mb-3">
                           @if ($tipoDoc=='CO' || $tipoDoc=='AP' || $tipoDoc=='RR' || $tipoDoc=='SD' )
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
                                    <div class="col-xxl-5">
                                        <p>{{$nota}} ({{$notaletra}}) {{$notaEscala[$escala]}}</p>
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
                            @if ($tipoDoc=='AR')
                                <div id="ckeditor-classic">
                                <p>En atención a la solicitud presentada por el representante legal del estudiante <strong>{{$nombres}}</strong> del 
                                <strong>{{$bachilleren}}</strong> periodo lectivo {{$periodo}} me permito poner a su conocimiento que este <strong>RECTORADO ACEPTA
                                RECIBIRLO CON PASE REGLAMENTARIO</strong> para que continue sus estudios en el plantel de mi dirección.<br><br>
                                Por la atención que se dé a la presente, reitero a usted mis sincero agradecimiento.
                                </p>
                                </div>
                            @endif
                            @if ($tipoDoc=='ER')
                                <div id="ckeditor-classic">
                                <p>Por medio de la presente tengo a bien saludarlo a la vez que pongo a su conocimiento para los fines de la ley, que vista
                                la solicitud presentada por el representante legal del alumno (a) <strong>{{$nombres}}</strong> del 
                                <strong>{{$bachilleren}}</strong>, jornada matutina, periodo lectivo {{$periodo}}, asi como la aceptación por parte del colegio
                                de su acertada dirección para recibirlo, de acuerdo con las facultades que me otorga el reglamento general de ley de educación
                                y cultura en vigencia, exitiendo el pase reglamentado a favor del alumno (a) <strong>{{$nombres}}</strong> (anexo notas correspondiente
                                al primer quimestre)<br><br>
                                Agradezco de antemano, por la atención que se designe brindar a la presente, y me suscribo de usted.
                                </p>
                                </div>
                            @endif
                            @if ($tipoDoc=='RR')
                                <div id="ckeditor-classic">
                                <p>Yo, Gladys Quiroz con C.I 090036728-5, Rectoror (a) de la Unidad Educativa American Shool certifico que el 
                                Sr. (Srta.) <strong>{{$nombres}}</strong> con C.I {{$nui}}, constan en los archivos de la institución, en el periodo lectivo
                                {{$periodo}}, como {{$bachilleren}}, con especializacion {{$especializacion}}, con calificación <strong>{{$nota}}</strong>, graduado 
                                {{$dtfecha}}, con Refrendación #{{$refrendacion}}, Página #{{$pagina}}<br>
                                Por lo cual solicitamos una prorroga hasta el dia {{$fprorroga}} para la entrega del {{$documentos}}
                                </p>
                                </div>
                            @endif
                            @if ($tipoDoc=='SD')
                                <div id="ckeditor-classic">
                                <p>Yo, Gladys Quiroz con C.I 090036728-5, Rectoror (a) de la Unidad Educativa American Shool certifico que el 
                                Sr. (Srta.) <strong>{{$nombres}}</strong> con C.I {{$nui}}, constan en los archivos de la institución, en el periodo lectivo
                                {{$periodo}}, como {{$bachilleren}}, con especializacion {{$especializacion}}, con calificación <strong>{{$nota}}</strong>, graduado 
                                {{$dtfecha}}, con Refrendación #{{$refrendacion}}, Página #{{$pagina}}<br>
                                </p>
                                </div>
                            @endif
                            @if ($tipoDoc=='ND')
                                <div id="ckeditor-classic">
                                <p>Yo, Gladys Quiroz con C.I 090036728-5, Rectoror (a) de la Unidad Educativa American Shool certifico que el 
                                Sr. (Srta.) <strong>{{$nombres}}, NO</strong> constan en los archivos de la institución, en el (los) años lectivo
                                {{$periodo}}.
                                </p>
                                </div>
                            @endif
                        </div>
                    </div>
                    @endif
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
                                        <label class="form-label" for="project-title-input">{{ $tipoDoc == 'PA' ? 'COORDINADOR (A)' : 'SECRETARIA GENERAL' }}</label>
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
                <button type="button" class="btn btn-danger w-sm" wire:click='print("P")'><i class="ri-printer-line align-bottom me-1"></i>Print</button>
                <button type="button" class="btn btn-success w-sm" wire:click='print("D")'><i class="ri-download-2-line align-bottom me-1"></i>Download PDF</button>
            </div>
        </div>
        <!-- end col -->
        <div class="col-lg-4">
            @if ($tipoDoc != 'PR' && $tipoDoc != 'AR' && $tipoDoc != 'ER' && $tipoDoc != 'RR' && $tipoDoc != 'SD')
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
                @if ($tipoDoc != 'PR' && $tipoDoc != 'AR' && $tipoDoc != 'ER' && $tipoDoc != 'RR' && $tipoDoc != 'SD')
                <div class="card-header">
                    <h5 class="card-title mb-0">Matrícula</h5>
                </div>
                <div class="card-body">
                    @if($tipoDoc=='MA')
                    <div class="mb-3">
                        <label for="choices-categories-input" class="form-label">Fecha Solicitud</label>
                        <input type="date" class="form-control" id="fechaActual" data-provider="flatpickr" data-date-format="d-m-Y" data-time="true" wire:model="dtfecha"> 
                    </div>
                    @endif
                    <fieldset {{$control}}>
                    <div class="mb-3">
                        <label for="choices-categories-input" class="form-label">Documento No.</label>
                        <input type="text" class="form-control" id="documento-input" placeholder="Documento" wire:model="documento">
                    </div>
                    <div class="mb-3">
                        <label for="choices-categories-input" class="form-label">Fecha Registro</label>
                        <input type="date" class="form-control" id="fechaActual" data-provider="flatpickr" data-date-format="d-m-Y" data-time="true" wire:model="fecha"> 
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
                @endif 
                @if ($tipoDoc == 'PR' || $tipoDoc == 'AR' || $tipoDoc == 'ER')
                <div class="card-header">
                    <h5 class="card-title mb-0">Datos</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="choices-categories-input" class="form-label">Fecha Solicitud</label>
                        <input type="date" class="form-control" id="fechaActual" data-provider="flatpickr" data-date-format="d-m-Y" data-time="true" wire:model="dtfecha"> 
                    </div>
                    <div class="mb-3">
                        <label for="choices-categories-input" class="form-label">Sigla</label>
                        <input type="text" class="form-control" id="titulo-input" placeholder="Titulo" wire:model="dttitulo" required>
                    </div>
                    <div class="mb-3">
                        <label for="choices-categories-input" class="form-label">Destinatario</label>
                        <input type="text" class="form-control" id="nombre-input" placeholder="Rector" wire:model="dtnombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="choices-categories-input" class="form-label">Cargo</label>
                        <input type="text" class="form-control" id="cargo-input" placeholder="Cargo" wire:model="dtcargo" required>
                    </div>
                    <div class="mb-3">
                        <label for="choices-categories-input" class="form-label">Institución</label>
                        <input type="text" class="form-control" id="institucion-input" placeholder="Institucion" wire:model="dtinstitucion" required>
                    </div>
                </div>
                @endif
                @if ($tipoDoc == 'RR' || $tipoDoc == 'SD')
                <div class="card-header">
                    <h5 class="card-title mb-0">Datos</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="choices-categories-input" class="form-label">Fecha de Grado</label>
                        <input type="date" class="form-control" id="fechaActual" data-provider="flatpickr" data-date-format="d-m-Y" data-time="true" wire:model="dtfecha"> 
                    </div>
                    <div class="mb-3">
                        <label for="choices-categories-input" class="form-label">Refrendación #</label>
                        <input type="numeric" class="form-control" id="refrendacion-input" placeholder="Refredacion #" wire:model="refrendacion" required>
                    </div>
                    <div class="mb-3">
                        <label for="choices-categories-input" class="form-label">Página</label>
                        <input type="numeric" class="form-control" id="pagina-input" placeholder="Página #" wire:model="pagina" required>
                    </div>
                     @if ($tipoDoc == 'RR')
                    <div class="mb-3">
                        <label for="choices-categories-input" class="form-label">Fecha de Prorroga</label>
                        <input type="date" class="form-control" id="fechaProrroga" data-provider="flatpickr" data-date-format="d-m-Y" data-time="true" wire:model="fprorroga">
                    </div>
                    <div class="mb-3">
                        <label for="choices-categories-input" class="form-label">Documento</label>
                        <select class="form-select" name="cmbperiodo" wire:model="documentos">
                            <option value="">Seleccione Documento</option>
                            <option value="AC">Acta</option>
                            <option value="TI">Título</option>
                            <option value="AT">Acta y Título</option>
                        </select>
                    </div>
                    @endif
                </div>
                @endif
                




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
                            @livewire('vc-modal-search',['opcion' => 'CERT'])                                      
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
