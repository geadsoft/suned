<div>
    <form id="retiroDocente-form" autocomplete="off" wire:submit.prevent="{{ 'updateData' }}">
        <div class="row">
            <div class="col-xl-12">                    
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h5 class="card-title flex-grow-1 mb-0 text-primary"><i
                            class="ri-user-unfollow-line me-1 text-success"></i>
                            {{$this->nombres }}</h5>
                            <!--<div class="flex-shrink-0">
                                <div class="text-end">
                                    <button type="submit" class="btn btn-success w-sm">Grabar</button>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-success w-sm">Grabar</button>
                                </div>                             
                            </div>-->
                            <div class="text-end">
                                <button type="submit" class="btn btn-danger w-sm">Retirar</button>
                                <a class="btn btn-secondary w-sm" href="/headquarters/staff"><i class="me-1 align-bottom"></i>Cancelar</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-4">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="identidad" id="billinginfo-firstName" placeholder="Buscar Docente de reemplazo" wire:model="persona" disabled>
                                    <a id="btnstudents" class ="input-group-text btn btn-soft-secondary"  wire:click="buscar()"><i class="ri-user-search-fill me-1"></i></a>
                                </div>
                            </div>
                            <div class="col-xl-8">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end card --> 
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive  mb-1">
                            <table class="table table-nowrap table-sm align-middle"  id="orderTable">
                                <thead class="text-muted table-light">
                                    <tr class="text-uppercase">
                                        <th scope="col" style="width: 25px;">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="checkAll" wire:click="aplicarTodos">
                                            </div>
                                        </th>
                                        <th class="" style="width: 100px;">Modalidad</th>
                                        <th class="" style="width: 100px;">Curso</th>
                                        <th class="" style="width: 250px;">Asignatura</th>
                                        <th class="" style="width: 250px;">Reemplazo</th>
                                        <th class="" style="width: 50px;">...</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                @foreach ($tblrecords as $key => $record)
                                    <tr>
                                        <th scope="row">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="aplica-{{$key}}" wire:model.prevent="tblrecords.{{$key}}.aplicar"  wire:click="aplicar({{$key}})" >
                                            </div>
                                        </th>
                                        <td>{{$record['modalidad']}}</td>
                                        <td>{{$record['curso']}}</td>
                                        <td>{{$record['asignatura']}}</td>
                                        <td>{{$record['docente']}}</td>
                                        <td>
                                            @if ($record['aplicar'])
                                            <ul class="list-inline hstack gap-2 mb-0">
                                                <li class="list-inline-item" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                                    <a class="text-danger d-inline-block remove-item-btn"
                                                        data-bs-toggle="modal" href="" wire:click.prevent="delete({{$key}})">
                                                        <i class="ri-delete-bin-5-fill fs-16"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>  
                
        </div>
    </form> 
    <div wire.ignore.self class="modal fade" id="addDocentes" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" >
            <div class="modal-content modal-content border-0">
                
                <div class="modal-header p-3 bg-light">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <span> Docentes &nbsp;</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                </div>
                
                <form autocomplete="off" wire:submit.prevent="">
                    <div class="modal-body">                                        
                            @livewire('vc-modal-personas',[
                                'vista' => 'remove-teacher',
                                'tipo' => 'D'
                            ])                                       
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
