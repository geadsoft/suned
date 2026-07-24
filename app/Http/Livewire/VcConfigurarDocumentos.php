<?php

namespace App\Http\Livewire;
use App\Models\TmServicios;
use App\Models\TmGeneralidades;
use App\Models\TmExpedientes;
use App\Models\TdExpedienteMatricula;
use App\Models\ViewServiciosEducativos;


use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class VcConfigurarDocumentos extends Component
{
    use WithPagination;

    public $showEditModal=false, $selectId, $record, $servicios;
    public array $serviciosSeleccionados = [];
    public string $buscarServicio = '';

    public function seleccionarModalidad(string $modalidad): void
    {
        $ids = $this->servicios
            ->where('modalidad', $modalidad)
            ->pluck('id')
            ->map(fn ($id) => (string) $id)
            ->toArray();

        $seleccionados = array_map(
            'strval',
            $this->serviciosSeleccionados
        );

        $todosSeleccionados = empty(
            array_diff($ids, $seleccionados)
        );

        if ($todosSeleccionados) {
            // Si ya están todos seleccionados, los desmarca.
            $this->serviciosSeleccionados = array_values(
                array_diff($seleccionados, $ids)
            );
        } else {
            // Agrega los que todavía no estén seleccionados.
            $this->serviciosSeleccionados = array_values(
                array_unique(
                    array_merge($seleccionados, $ids)
                )
            );
        }
    }


    public function render()
    {
        $modalidades = TmGeneralidades::where('superior',1)->get();

        $this->servicios = ViewServiciosEducativos::query()
            ->when(
                $this->buscarServicio,
                function ($query) {
                    $buscar = '%' . $this->buscarServicio . '%';

                    $query->where(function ($subQuery) use ($buscar) {
                        $subQuery
                            ->where('descripcion', 'like', $buscar)
                            ->orWhere('nivel', 'like', $buscar)
                            ->orWhere('modalidad', 'like', $buscar);
                    });
                }
            )
            ->orderBy('modalidad')
            ->orderBy('root')
            ->get();

        $tblrecords =  TmExpedientes::paginate(12);

        return view('livewire.vc-configurar-documentos',[
            'modalidades' => $modalidades,
            'servicios' => $this->servicios,
            'tblrecords' => $tblrecords,
        ]);
    }

    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }

    public function add(){
        
        $this->showEditModal = false;
        $this->reset(['record']);
        $this->record['descripcion']= '';
        $this->record['servicios']= '';
        $this->record['estado']= 'A';      
        $this->dispatchBrowserEvent('show-form');

    }

    public function edit(TmExpedientes $tblrecords ){
        
        $this->showEditModal = true;
        $this->record  = $tblrecords->toArray();

        $this->serviciosSeleccionados = $this->record['servicios'];
       
        $this->selectId = $this -> record['id'];


        $this->dispatchBrowserEvent('show-form');

    }

    public function delete($id)
    {
        $this->selectId = $id;

        $existe = TdExpedienteMatricula::where('expediente_id', $id)->exists();

        if ($existe) {
            $this->dispatchBrowserEvent('show-message', [
                'type'    => 'warning',
                'message' => 'No se puede eliminar el expediente porque tiene registros asociados.',
            ]);
            return;
        }

        $this->dispatchBrowserEvent('show-delete');
    }

    public function deleteData(){
        TmExpedientes::find($this->selectId)->delete();
        $this->dispatchBrowserEvent('hide-delete');
    }

    public function createData()
    {
        $this->validate([
            'record.descripcion' => 'required'
        ]);

        $servicios = $this->serviciosSeleccionados;

        // Seguridad adicional
        if (is_string($servicios)) {
            $servicios = json_decode($servicios, true);
        }

        TmExpedientes::create([
            'descripcion' => $this->record['descripcion'],
            'servicios' => $servicios,
            'estado' => 'A',
            'usuario' => auth()->user()->name,
        ]);

        $this->reset([
            'record',
            'serviciosSeleccionados',
        ]);

        $this->dispatchBrowserEvent('hide-form', [
            'message' => 'Registro grabado con éxito!',
        ]);
    }

    public function updateData()
    {
        $this->validate([
            'record.descripcion' => 'required'
        ]);

        $servicios = $this->serviciosSeleccionados;

        // Seguridad adicional
        if (is_string($servicios)) {
            $servicios = json_decode($servicios, true);
        }

        if ($this->selectId){
            $record = TmExpedientes::find($this->selectId);
            $record->update([
                'descripcion' => $this -> record['descripcion'],
                'servicios' => $servicios,
            ]);
            
        }

        $this->reset([
            'record',
            'serviciosSeleccionados',
        ]);

        $this->dispatchBrowserEvent('hide-form', [
            'message' => 'Registro actualizado con éxito!',
        ]);
    }
    
}
