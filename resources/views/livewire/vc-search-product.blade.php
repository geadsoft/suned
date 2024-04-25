<div>
    <div class="relative">
        <div class="search-box mb-3">
            <input id="idproducto" type="text" class="form-control search border border-primary"
                placeholder="Buscar" wire:model="filters" autofocus>
            <i class="ri-search-line search-icon"></i>
        </div>    
        @if(strlen($filters)>2)
        <div class="mb-3">
            @if($results->count()>0)
            <ul class="list-group">
                @foreach($results as $key => $result)
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    
                    <div class="ms-2 me-auto">
                        <a href="" wire:click.prevent="addDetalle({{$result->id}})">
                        <div class="fw-bold">{{$result->codigo}}</div>{{$result->nombre}}
                        </a>
                    </div>
                    <span class="badge bg-primary rounded-pill">{{$result->stock}}</span>
                    
                </li>
                @endforeach
            </ul>
            @else
                <div class="m2 p-2 text-gray-50">
                    No results
                </div>
            @endif        
        </div>
        @endif
        </div>
</div>
