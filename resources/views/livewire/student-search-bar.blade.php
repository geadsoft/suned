<div class="relative">

    <input
        type="text"
        class="form-control"
        placeholder="Search Students..."
        wire:model="query"
        wire:keydown.escape="borrar"
        wire:keydown.tab="borrar"
        wire:keydown.arrow-up="decrementHighlight"
        wire:keydown.arrow-down="incrementHighlight"
        wire:keydown.enter="selectStudent"      
    />

    @if(!empty($query))

        <div class="fixed top-0 bottom-0 left-0 right-0" wire:click="borrar"></div>
        <div class="absolute z-10 w-full bg-white rounded-t-none shadow-lg list-group">

            @if(!empty($students))

                @foreach ($students as $i => $student)
                    <a href="#" wire:click="selectStudent" class="list-item {{ $highlightIndex === $i ? 'highlight' : '' }}"
                    >{{ $student['apellidos'] }} {{ $student['nombres'] }} </a>
                @endforeach
                
            @else
                <div class="list-item"> No results! </div>
            @endif

        <div>

    @endif

</div>


