<div>
    <div class="dropdown ms-sm-3 header-item topbar-user">
    <button type="button" class="btn" id="page-header-user-dropdown"
        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="d-flex align-items-center">
            <img class="rounded-circle header-profile-user"
                src="@if (Auth::user()->avatar != '') {{ URL::asset('images/' . Auth::user()->avatar) }}@else{{ URL::asset('assets/images/users/avatar-1.jpg') }} @endif"
                alt="Header Avatar">
            <span class="text-start ms-xl-2">
                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ Auth::user()->name }}</span>
                @if ($datos==null)
                <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">Programador</span>
                @else
                    @if ($datos['tipo']=='E')
                    <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">{{$datos['modalidad']}}</span>
                    <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">{{$datos['curso']}}</span>
                    @else
                    <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">{{$datos['rol']}}</span>
                    @endif
                @endif
            </span>
        </span>
    </button>
    <div class="dropdown-menu dropdown-menu-end">
        <h6 class="dropdown-header">Bienvenido {{ Auth::user()->name }}!</h6>
        
        <a class="dropdown-item" href="/config/profile"><i
                class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span
                class="align-middle">Perfil</span>
        </a>
        @foreach($matricula as $data)
        <a class="dropdown-item" href="" wire:click.prevent="cambiar({{$data->id}})">
            <span class="badge bg-success-subtle text-success mt-1 float-end">Cambiar</span>
            <i class="mdi mdi-account-switch text-muted fs-16 align-middle me-1"></i>
            <span class="align-middle">{{$data->descripcion}}</span>
        </a>
        @endforeach
        <a class="dropdown-item " href="javascript:void();"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                class="bx bx-power-off font-size-16 align-middle me-1"></i> <span
                key="t-logout">Cerrar Sesión</span></a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</div>
    <!--@foreach($matricula as $data)
    <a class="dropdown-item" href="" wire:click.prevent="cambiar({{$data->id}})">
        <span class="badge bg-success-subtle text-success mt-1 float-end">Cambiar</span>
        <i class="mdi mdi-account-switch text-muted fs-16 align-middle me-1"></i>
        <span class="align-middle">{{$data->descripcion}}</span>
    </a>
    @endforeach-->
</div>
