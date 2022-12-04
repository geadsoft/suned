<div>
    <div wire:ignore>
        <select class="form-control" id="select2-dropdown">
        <option value=""> Select Student </option>
        @foreach ($students as $student)
            <option value="{{$student->id}}"> {{$student->apellidos}} {{$student->nombres}} </option>
        @endforeach
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded',function(){
        $('#select2-dropdown').select2()
        $('#select2-dropdown').on('change',function(e){
            var pId = $('#select2-dropdown').select2("val")
            var pName = $('#select2-dropdown option:selected').text()
            @this.set('studentSelectedId',pId)
            @this.set('studentSelectedName',pName)
        });
    });
</script>
