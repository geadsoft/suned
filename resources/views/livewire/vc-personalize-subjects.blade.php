<div>
    <form id="createactivity-form" autocomplete="off" enctype="multipart/form-data">
    <div class="card">
        <div class="card-body">
            <div class="row g-2">
                <div class="col-sm-auto ms-auto">
                    <div class="list-grid-nav hstack gap-1">
                        <button type="button" id="grid-view-button"
                            class="btn btn-soft-info nav-link btn-icon fs-14 active filter-button"><i
                                class="ri-grid-fill"></i></button>
                        <button type="button" id="list-view-button"
                            class="btn btn-soft-info nav-link  btn-icon fs-14 filter-button"><i
                                class="ri-list-unordered"></i></button>
                        <button type="button" class="btn btn-danger w-sm" wire:click="grabar">Actualizar</button>
                                
                    </div>
                </div>
                <!--end col-->
            </div>
            <!--end row-->
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div>
                <div class="team-list grid-view-filter row">
                    @foreach($array_materias as $key => $materia)
                    

                    <div class="col" wire:key="materia-{{ $key }}">
                        <div class="card team-box">
                            <div class="team-cover">
                                @if (!empty($array_materias[$key]['fileimg']))
                                    <img src="{{ $array_materias[$key]['fileimg']->temporaryUrl() }}" class="img-fluid">
                                @else
                                    <img id="img-{{$key}}" src="@if ($materia['ruta'] != '') {{ asset('storage/asignatura/'.$materia['imagen']) }} @else {{ asset('assets/images/small/img-9.jpg') }} @endif" class="img-fluid">
                                @endif
                            </div>
                            <div class="card-body p-4">
                                <div class="row align-items-center team-row">
                                    <div class="col team-settings">                            
                                        <div class="row">                                
                                            <div class="col">                                    
                                                <div class="flex-shrink-0 me-2">                                        
                                                    <div>
                                                        <label id="label" for="file-{{ $key }}"  class="mb-0" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Select Cover Image" data-bs-original-title="Select Cover Image">
                                                            <div class="avatar-xs">
                                                                <div class="avatar-title bg-light border rounded-circle text-muted cursor-pointer">
                                                                    <i class="ri-image-fill"></i>
                                                                </div>
                                                            </div>
                                                        </label>
                                                        <input class="form-control d-none" id="file-{{ $key }}" type="file" accept="image/png, image/gif, image/jpeg" wire:model="array_materias.{{$key}}.fileimg">
                                                    </div>
                                                </button>
                                                </div>                                
                                            </div>                                                       
                                        </div>                        
                                    </div>
                                    <div class="col-lg-4 col">
                                        <div class="team-profile-img">
                                            <div class="avatar-lg img-thumbnail rounded-circle flex-shrink-0 mb-1">
                                                <div class="avatar-title bg-soft-primary text-primary rounded-circle">
                                                    <input type="text"  wire:model="array_materias.{{$key}}.abreviatura" class="form-control bg-transparent border-0 shadow-none text-primary avatar-title fs-22 text-center" name="record.descripcion"
                                                placeholder="Enter name" required />
                                                </div>
                                            </div>
                                            <div>
                                                <a data-bs-toggle="offcanvas" aria-controls="offcanvasExample">
                                                    <h5 class="fs-17 mb-1">{{$materia['nombre']}} {{$key}}</h5>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end card-->
                    </div>
                    @endforeach
                    <!--end col-->
                </div>
                <!--end row-->

                <!-- Modal -->
                <div class="modal fade" id="addmembers" tabindex="-1" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0">
                            
                            <div class="modal-body">
                                <form autocomplete="off" id="memberlist-form" class="needs-validation" novalidate>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <input type="hidden" id="memberid-input" class="form-control" value="">
                                            <div class="px-1 pt-1">
                                                <div class="modal-team-cover position-relative mb-0 mt-n4 mx-n4 rounded-top overflow-hidden">
                                                    <img src="{{ URL::asset('assets/images/small/img-12.jpg') }}" alt="" id="cover-img" class="img-fluid">
                                                    <div class="d-flex position-absolute start-0 end-0 top-0 p-3">
                                                        <div class="flex-grow-1">
                                                            <h5 class="modal-title text-white" id="createMemberLabel">Add New Members</h5>
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
                                                                    <input class="form-control d-none" value="" id="cover-image-input" type="file" accept="image/png, image/gif, image/jpeg">
                                                                </div>
                                                                <button type="button" class="btn-close btn-close-white" id="createMemberBtn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-center mb-4 mt-n5 pt-2">
                                                <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                                    @if ($fileimg)
                                                        <img src="{{ $fileimg->temporaryURL() }}"
                                                            class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="user-profile-image">
                                                    @else
                                                        <img src="@if ($foto != '') {{ URL::asset('storage/fotos/'.$foto) }}@else{{ URL::asset('assets/images/users/sin-foto.jpg') }} @endif"
                                                            class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="user-profile-image">
                                                    @endif
                                                    <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                                        <input id="profile-img-file-input" type="file" class="profile-img-file-input" wire:model="fileimg">
                                                        <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                                            <span class="avatar-title rounded-circle bg-light text-body">
                                                                <i class="ri-camera-fill"></i>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="teammembersName" class="form-label">Name</label>
                                                <input type="text" class="form-control" id="teammembersName" placeholder="Enter name"  required>
                                                <div class="invalid-feedback">Please Enter a member name.</div>
                                            </div>

                                            <div class="mb-4">
                                                <label for="designation" class="form-label">Designation</label>
                                                <input type="text" class="form-control" id="designation" placeholder="Enter designation" required>
                                                <div class="invalid-feedback">Please Enter a designation.</div>
                                            </div>
                                            <input type="hidden" id="project-input" class="form-control" value="">
                                            <input type="hidden" id="task-input" class="form-control" value="">

                                            <div class="hstack gap-2 justify-content-end">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-success" id="addNewMember">Add Member</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!--end modal-content-->
                    </div>
                    <!--end modal-dialog-->
                </div>
                <!--end modal-->

            </div>
        </div><!-- end col -->
    </div>
    <!--end row-->
    </form>

    <svg class="bookmark-hide">
        <symbol viewBox="0 0 24 24" stroke="currentColor" fill="var(--color-svg)" id="icon-star">
            <path stroke-width=".4"
                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
            </path>
        </symbol>
    </svg>
    
</div>
