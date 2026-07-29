<?php

namespace App\Http\Livewire;

use App\Models\TmReportes;
use App\Models\TmSedes;
use App\Models\TmSubcategoriasSolicitud;
use App\Models\TcSolicitudes;



use Livewire\Component;
use Livewire\WithPagination;
use PDF;

class VcSolicitudes extends Component
{
    use WithPagination;

    public $resumen, $mostrarPanel=false, $categorias=[];
    public $solicitud=[];
    public $record;
    public $solicitudId;
    public $estadoSolicitud;
    public $observacionEstado;

    public $estado=[
        'P' => ['valor'=>'Pendiente','color' => 'badge-soft-warning'],
        'L' => ['valor'=>'Listo','color' => 'badge-soft-success'],
        'R' => ['valor'=>'Realizado y Entregado','color' => 'badge-soft-info'],
        'A' => ['valor'=>'Anulado','color' => 'badge-soft-danger'],
    ];

    public $filters=[
        'buscar' => '',
    ];

    public $servidores=[
        1 => 'Servidor 1',
        2 => 'Servidor 2'
    ];

    public function mount()
    {
        $this->add();
    }

    public function render()
    {
        
        $solicitudes = TcSolicitudes::query()
        ->with([
            'persona',
            'detalles.subcategoria',
        ])

        ->when(
            !empty($this->filters['buscar']),
            function ($query) {

                $buscar = trim($this->filters['buscar']);

                $query->where(function ($subQuery) use ($buscar) {

                    // Buscar por solicitante
                    $subQuery->where(
                        'solicitante',
                        'like',
                        "%{$buscar}%"
                    )

                    // Buscar por nombres o apellidos de la persona
                    ->orWhereHas('persona', function ($personaQuery) use ($buscar) {

                        $personaQuery->where(function ($q) use ($buscar) {
                            $q->where('nombres', 'like', "%{$buscar}%")
                                ->orWhere('apellidos', 'like', "%{$buscar}%")
                                ->orWhereRaw(
                                    "CONCAT(apellidos, ' ', nombres) LIKE ?",
                                    ["%{$buscar}%"]
                                )
                                ->orWhereRaw(
                                    "CONCAT(nombres, ' ', apellidos) LIKE ?",
                                    ["%{$buscar}%"]
                                );
                        });

                    });

                });
            }
        )
        ->orderby('documento','desc')
        ->paginate(10);

        $valores = TcSolicitudes::query()
        ->selectRaw("
            COUNT(*) AS total,
            SUM(CASE WHEN estado = 'P' THEN 1 ELSE 0 END) AS pendientes,
            SUM(CASE WHEN estado = 'L' THEN 1 ELSE 0 END) AS listos,
            SUM(CASE WHEN estado = 'R' THEN 1 ELSE 0 END) AS entregados
        ")
        ->first();

        $this->resumen['pendientes'] = $valores->pendientes;
        $this->resumen['listo'] = $valores->listos;
        $this->resumen['entregados'] = $valores->entregados;
        $this->resumen['total'] = $valores->total;
        
        return view('livewire.vc-solicitudes',[
            'estudiantes' => [],
            'subcategorias' => $this->categorias,
            'solicitudes' => $solicitudes 
        ]);

    }
    
    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }

    public function updatedFiltersBuscar()
    {
        $this->resetPage();
    }

    public function add(){
        
        $this->reset(['record']);
        $this->record['id']=null;
        $this->record['categoria']= '';
        $this->record['subcategoria']= '';
        $this->record['tiempo_entrega']= '';     

    }
    
    public function edit(TmSubcategoriasSolicitud $tblSubcategorias ){
        
        $this->record  = $tblrecords->toArray();

    }

    public function createData(){

        $this ->validate([
            'record.categoria' => 'required',
            'record.subcategoria' => 'required',
            'record.tiempo_entrega' => 'required',
        ]);    

        $registro = TmSubcategoriasSolicitud::query()->firstOrNew([
            'id' => $this->record['id'],
        ]);

        $registro->categoria =
        $this->record['categoria']
            ? $this->record['categoria']
            : null;

        $registro->subcategoria =
        $this->record['subcategoria']
            ? $this->record['subcategoria']
            : null;

        $registro->tiempo_entrega =
        $this->record['tiempo_entrega']
            ? $this->record['tiempo_entrega']
            : null;
        
        $registro->usuario =
            auth()->user()?->name;

        $registro->save();

        $this->categorias = TmSubcategoriasSolicitud::query()
            ->where('categoria', $this->record['categoria'])
            ->get();

        $categoria = $this->record['categoria'];
        $this->add();
        $this->record['categoria']=$categoria;
        
    }

    public function abrirPanel(string $categoria): void
    {
        $this->add();

        $this->record['categoria'] = $categoria;

        $this->categorias = TmSubcategoriasSolicitud::query()
            ->where('categoria', $this->record['categoria'])
            ->get();

        $this->mostrarPanel = true;
        
    }
    
    public function cerrarPanel(): void
    {
        $this->mostrarPanel = false;
        $this->add();
    }

    public function abrirCambioEstado($id)
    {
        $solicitud = TcSolicitudes::findOrFail($id);

        $this->solicitudId       = $solicitud->id;
        $this->estadoSolicitud   = $solicitud->estado;
        $this->observacionEstado = $solicitud->observacion;

        $this->dispatchBrowserEvent('mostrar-modal-estado');
    }

    public function cambiarEstado()
    {
        
        $this->validate([
            'solicitudId' => 'required',
            'estadoSolicitud' => 'required|in:P,L,R',
        ]);

        $solicitud = TcSolicitudes::findOrFail($this->solicitudId);

        $solicitud->update([
            'estado' => $this->estadoSolicitud,
            'observacion' => $this->observacionEstado,
            'usuario' => auth()->user()->name,
        ]);

        $this->dispatchBrowserEvent('ocultar-modal-estado');
        $this->dispatchBrowserEvent('msg-save');

        $this->reset([
            'solicitudId',
            'estadoSolicitud',
            'observacionEstado',
        ]);

    }

}
