<div>
    <div class="dataTables_scroll">
        <div class="dataTables_scrollBody" style="position: relative; overflow: auto; max-height: 210px; width: 100%;">
            <table id="scroll-vertical" class="table table-sm table-bordered dt-responsive nowrap align-middle mdl-data-table dataTable no-footer dtr-inline" style="width: 100%;" aria-describedby="scroll-vertical_info">
                <tbody>
                    @foreach ($arrpermisos as $key => $permisos) 
                    <tr class="odd">
                        <td class="dtr-control sorting_1" tabindex="0">{{$permisos['id']}}</td>
                        <td>{{$permisos['nombre']}}</td>
                        <td>
                            <input class="form-check-input" type="checkbox" name="chkbill" id="{{$permisos['id']}}-{{$key}}" wire:model.prevent="arrpermisos.{{$key}}.aplicar">
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
