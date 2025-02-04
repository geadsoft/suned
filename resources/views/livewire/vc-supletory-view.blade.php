<div>
    <form id="createactivity-form" autocomplete="off" wire:submit.prevent="{{ 'createData' }}" class="needs-validation" >
        <div class="row">
            <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header  border-0">
                            <div class="d-flex align-items-center">
                                <h6 class="card-title mb-0 flex-grow-1 text-primary fw-semibold"><i
                                            class="ri-calendar-check-fill align-middle me-1 text-primary fs-20"></i>Ver Exámen Supletorio</h5>
                            </div>
                        </div>
                        <div class="card-body border border-dashed border-end-0 border-start-0">  
                            <div class="row align-items-start mb-3">
                                <div class="col-sm-2">
                                    <div class="mb-3">
                                        <label for="asignatura-input" class="form-label form-control border-0 fw-semibold fs-14">Asignatura</label>
                                    </div>
                                    <div class="mb-3">
                                        <label for="curso-input" class="form-label form-control border-0 fw-semibold fs-14">Curso</label>
                                    </div>
                                    <div class="mb-3">
                                        <label for="termino-input" class="form-label form-control border-0 fw-semibold fs-14">Tipo de Exámen</label>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nombre-input" class="form-label form-control border-0 fw-semibold fs-14">Nombre de Exámen</label>
                                    </div>
                                    <div class="mb-3">
                                        <label for="puntaj-input" class="form-label form-control border-0 fw-semibold fs-14">Puntaje</label>
                                    </div>
                                    <div class="mb-3">
                                        <label for="fecha-input" class="form-label form-control border-0 fw-semibold fs-14">Fecha Limite de Entrega</label>
                                    </div>
                                    <div class="mb-3">
                                        <label for="descripcion-input" class="form-label form-control border-0 fw-semibold fs-14">Descripcion de Actividad</label>
                                    </div>
                                   
                                </div>
                                <div class="col-sm-10">  
                                    <div class="mb-3">
                                        <label class="form-control border-0 fs-14">{{$asignatura}}</label>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-control border-0 fs-14">{{$curso}}</label>
                                    </div>
                                    <div class="mb-3">
                                      <label class="form-control border-0 fs-14">{{$arrtermino[$termino]}}</label>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-control border-0 fs-14">{{$nombre}}</label>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-control border-0 fs-14">{{$puntaje}}</label>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-control border-0 fs-14"> @lang('translation.'.(date('l',strtotime($fecha)))),
                                            {{date('d',strtotime($fecha))}} de @lang('months.'.(date('m',strtotime($fecha)))) del {{date('Y',strtotime($fecha))}}
                                        </label>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-control border-0 fs-14">{{$descripcion}}</label>
                                    </div>
                                    
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label form-control border-0 fw-semibold fs-14">Archivos Adjuntos</label>
                                <table class="table table-nowrap align-middle" id="orderTable">
                                    <tbody>
                                    @foreach ($array_attach as $key => $recno) 
                                    <tr class="det-{{$recno['linea']}}">
                                    <td>
                                        <div class="input-group">
                                        <input type="file" id="file-{{$recno['linea']}}" wire:model.prevent="" class="form-control">
                                        </div>
                                    </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                 <!-- warning Alert -->
                                 @if (empty($array_attach))
                                    <div class="alert alert-warning" role="alert">
                                        <strong> No existen adjuntos para esta actividad </strong>
                                    </div> 
                                 @endif                     
                            </div>

                            <div class="mb-3">
                                <label class="form-label form-control border-0 fw-semibold fs-14">Links Externos</label>
                            </div>
                            <!--<div class="mb-3">
                                <label class="form-label fw-semibold" for="product-title-input">Envíos de Estudiantes</label>
                                <input type="text" class="form-control" id="product-title-input" value="" placeholder="Ingrese enlace externo" wire:model.defer="enlace">
                            </div>-->
                            <div class="alert alert-warning" role="alert">
                                <strong> Esta actividad no tiene respuestas de estudiantes. </strong>
                            </div>

                            <div class="d-flex align-items-start gap-3 mt-4">
                                <a class="btn btn-soft-info w-sm" href="/activities/exams"><i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>Volver al Listado</a>
                            </div>

                        </div>
                    </div>
                    <!-- end card -->

                   
            </div>
            <!-- end col -->

            
        </div>
        <!-- end row -->
    </form>
</div>

