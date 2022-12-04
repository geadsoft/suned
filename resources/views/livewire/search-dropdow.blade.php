<div>
    <div wire.ignore.self class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" >
            <div class="modal-content">
                
                <div class="modal-header bg-light p-3">
                    <h5 class="modal-title" id="exampleModalLabel">
                            <span>Record the Payment of: &nbsp;</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                </div>
                <form autocomplete="off" wire:submit.prevent="SaveData">
                    
                    <div class="modal-card-body">
                        <div class="id" id="modal-id">
                            <input type="text" autocomplete="off" class="form-control" placeholder="Search" wire:model="filters.srv_nombre"/>
                        </div>
                         <div class="dropdown-menu" style="">
                            <div class="dropdown-content" style="">
                                @if(!is_null($tblrecords))
                                    @foreach ($tblrecords as $record)  
                                        <a class="dropdown-item"><p>{{ $record['nombres'] }} {{ $record['apellidos'] }}</p></a>
                                    @endforeach
                                @endif
                            </div>
                        </div>


                        <!--<div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle" id="orderTable">
                                <tbody class="list form-check-all">
                                @if(!is_null($tblrecords))
                                    @foreach ($tblrecords as $record)    
                                        <tr>
                                            <td>{{$record->apellidos}} {{$record->nombres}}</td>
                                            <td>
                                                <ul class="list-inline hstack gap-2 mb-0">
                                                    <li class="list-inline-item edit" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                                        <a href="" wire:click.prevent="edit({{ $record }})">
                                                            <i class="ri-pencil-fill fs-16"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>-->
                    </div>
                    <div class="modal-footer">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success" id="add-btn">Save Record</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
