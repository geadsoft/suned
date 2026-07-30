<?php

namespace App\Http\Livewire;
use App\Models\TmSubcategoriasSolicitud;
use App\Models\TcSolicitudes;
use App\Models\TdSolicitudes;
use App\Models\TmPeriodosLectivos;
use App\Models\TmServicios;
use App\Models\TmPersonas;

use Livewire\Component;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class VcSolicitudAdd extends Component
{
    public $detalle=[], $record, $solicitudId=0;
    public $tabActivo;

    public function mount(){

        $this->periodoLectivo = TmPeriodosLectivos::query()
        ->where('estado','<>','C')
        ->orWhere('aperturado',1)
        ->first();
        
        $primeraCategoria = TmSubcategoriasSolicitud::query()
        ->select('categoria')
        ->distinct()
        ->first();

        $this->tabActivo = strtolower($primeraCategoria?->categoria);
        

        $ldate = date('Y-m-d H:i:s');
        $this->record['fecha'] = date('Y-m-d',strtotime($ldate));
        $this->add();
        
    }

    public function render()
    {
        $periodos = TmPeriodosLectivos::query() 
        ->orderBy('periodo','desc')
        ->get();

        $cursos = TmServicios::query() 
        ->get();

        $estudiantes = TmPersonas::query()
        ->where('tipopersona','E')
        ->orderBy('apellidos')
        ->get();

        $servidores = collect([
            1 => 'Servidor 1',
            2 => 'Servidor 2',
        ]);
    
        return view('livewire.vc-solicitud-add',[
            'periodos' => $periodos,
            'cursos' => $cursos,
            'estudiantes' => $estudiantes,
            'servidores' => $servidores
        ]);
    }

    public function add(){

        $this->record['documento']=str_pad($this->periodoLectivo->num_solicitud+1, 7, '0', STR_PAD_LEFT);
        $this->record['solicitante']='';
        $this->record['cedula']='';
        $this->record['estudiante_id']='';
        $this->record['fecha_entrega']='';
        $this->record['servidor']='';
        $this->record['forma_solicitud']='';
        $this->record['celular']='';
        $this->record['telefono']='';
        $this->record['email']='';
        $this->record['comentario']='';
        $this->consulta();

    }

    public function seleccionarTab($categoria)
    {
        $this->tabActivo = $categoria;
    }

    public function consulta(){

       $this->detalle = TmSubcategoriasSolicitud::query()
        ->orderBy('categoria')
        ->orderBy('subcategoria')
        ->get()
        ->groupBy('categoria')
        ->mapWithKeys(function ($registros, $categoria) {

            $clave = Str::slug($categoria, '_');

            return [
                $clave => [
                    'categoria' => $categoria,
                    'subcategorias' => $registros
                        ->map(function ($recno) {
                            return [
                                'id'           => $recno->id,
                                'subcategoria' => $recno->subcategoria,
                                'periodo'      => 0,
                                'curso'        => 0,
                                'entrega'      => $recno->tiempo_entrega,
                            ];
                        })
                        ->toArray(),
                ],
            ];
        })
        ->toArray();

        
    }

    public function guardarSolicitud()
    {

        $this->validate([
            'record.fecha'           => 'required',
            'record.solicitante'     => 'required',
            'record.cedula'          => 'required',
            'record.estudiante_id'   => 'required',
            'record.fecha_entrega'   => 'required',
            'record.servidor'        => 'required',
            'record.forma_solicitud' => 'required',
        ]);

        try {

            DB::transaction(function () {

                $periodo = TmPeriodosLectivos::query()
                    ->lockForUpdate()
                    ->findOrFail($this->periodoLectivo->id);

                $numero = ((int) $periodo->num_solicitud) + 1;

                $periodo->update([
                    'num_solicitud' => $numero,
                ]);

                $solicitud = TcSolicitudes::create([
                    'documento'       => str_pad($numero, 7, '0', STR_PAD_LEFT),
                    'fecha'           => $this->record['fecha'],
                    'solicitante'     => $this->record['solicitante'],
                    'nui'             => $this->record['cedula'],
                    'persona_id'      => $this->record['estudiante_id'],
                    'fecha_entrega'   => $this->record['fecha_entrega'],
                    'servidor'        => $this->record['servidor'],
                    'forma_solicitud' => $this->record['forma_solicitud'],
                    'celular'         => $this->record['celular'] ?? null,
                    'telefono'        => $this->record['telefono'] ?? null,
                    'email'           => $this->record['email'] ?? null,
                    'observacion'     => $this->record['comentario'] ?? null,
                    'estado'          => 'P',
                    'usuario'         => auth()->user()->name,
                ]);

                $this->solicitudId = $solicitud->id;

                foreach ($this->detalle as $grupo) {
                    foreach ($grupo['subcategorias'] ?? [] as $recno) {

                        if (empty($recno['periodo'])) {
                            continue;
                        }

                        TdSolicitudes::create([
                            'solicitud_id'    => $solicitud->id,
                            'subcategoria_id' => $recno['id'],
                            'periodo_id'      => $recno['periodo'],
                            'curso_id'        => $recno['curso'] ?: null,
                            'usuario'         => auth()->user()->name,
                        ]);
                    }
                }
            });

            $this->dispatchBrowserEvent('msg-save');

        } catch (\Throwable $e) {

            report($e);

            $this->dispatchBrowserEvent(
                'msg-show',
                'error',
                'No fue posible guardar la solicitud.'
            );
        }
    }
    

    public function limpiarFormulario()
    {
         $this->dispatchBrowserEvent('refresh-page'); 
    }
    
    public function imprimirSolicitud($id)
    {
        $solicitud = TcSolicitudes::query()
        ->with([
            'persona',
            'detalles.periodo',
            'detalles.curso',
        ])
        ->findOrFail($id);

        

    /*
     * Indexamos los detalles guardados por subcategoria_id
     * para encontrarlos fácilmente.
     */
    $detallesRegistrados = $solicitud->detalles
        ->keyBy('subcategoria_id');

    /*
     * Consultamos todas las subcategorías, aunque no hayan
     * sido seleccionadas en la solicitud.
     */
    $subcategorias = TmSubcategoriasSolicitud::query()
        ->orderByRaw("
            CASE categoria
                WHEN 'Certificados' THEN 1
                WHEN 'Extras' THEN 2
                WHEN 'Graduados' THEN 3
                ELSE 4
            END
        ")
        ->orderBy('id')
        ->get();

    /*
     * Combinamos cada subcategoría con el detalle registrado,
     * si existe.
     */
    $detallesAgrupados = $subcategorias
        ->map(function ($subcategoria) use ($detallesRegistrados) {

            $detalle = $detallesRegistrados->get($subcategoria->id);

            return [
                'id'             => $subcategoria->id,
                'categoria'      => $subcategoria->categoria,
                'subcategoria'   => $subcategoria->subcategoria,
                'tiempo_entrega' => $subcategoria->tiempo_entrega,

                'periodo' => $detalle?->periodo?->descripcion ?? '',
                'curso'   => $detalle?->curso?->descripcion ?? '',

                'seleccionado' => $detalle !== null,
            ];
        })
        ->groupBy('categoria');

        $servidor=[
            1 => 'Servidor 1',
            2 => 'Servidor 2'
        ];

        $pdf = Pdf::loadView(
            'pdf.reporte_solicitud',
            compact('solicitud', 'detallesAgrupados','servidor')
        )->setPaper('a4', 'portrait');

        return $pdf->stream(
            'solicitud-' .
            str_pad($solicitud->documento, 7, '0', STR_PAD_LEFT) .
            '.pdf'
        );

        
    }

}
