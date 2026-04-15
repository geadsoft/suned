<?php

namespace App\Http\Livewire;
use App\Models\TmSedes;
use App\Models\TrCalificacionesCabs;
use App\Models\TmPeriodosLectivos;
use App\Models\TmGeneralidades;
use App\Models\TmCursos;
use App\Models\TmServicios;
use App\Models\TmHorarios;
use App\Models\TmPersonas;
use App\Models\TdBoletinFinal;
use App\Models\TdPeriodoSistemaEducativos;
use App\Models\TdConductas;

use Livewire\Component;
use Livewire\WithPagination;
use App\Exports\RatingsDetailExport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\Exportable;
use PDF;

class VcRatingsDetail extends Component
{
    use Exportable;

    public $tblservicios=[],$tblcursos=[],$detalles=[], $alumnos, $asignaturas, $datos, $consulta=[];
    public $materias;
    public $selectId,$grupoId,$servicioId,$periodoId,$cursoId,$mostrar=false;
    public $filters=[
        'periodoId'=> 0,
        'grupoId'  => 0,
        'gradoId'  => 0,
        'cursoId'  => 0,
    ];

    public function mount(){

        $this->tblgenerals  = TmGeneralidades::whereRaw('superior in (1,2,4)')->get();
        $this->tblperiodos  = TmPeriodosLectivos::orderBy("periodo","desc")->get();
    
        $this->periodoId    = $this->tblperiodos[0]['id'];
        $this->grupoId      = "";

    }
    
    public function render()
    { 
        $this->tblservicios = TmHorarios::query()
        ->join("tm_servicios as s","s.id","=","tm_horarios.servicio_id")
        ->join("tm_cursos as c","c.id","=","tm_horarios.curso_id")
        ->where("tm_horarios.periodo_id",$this->periodoId)
        ->where('tm_horarios.grupo_id',$this->grupoId)
        ->selectRaw('c.id, concat(s.descripcion," ",c.paralelo) as descripcion')
        ->get();
    
        return view('livewire.vc-ratings-detail',[
            'detalles'    => $this->detalles,
            'tblperiodos' => $this->tblperiodos,
            'tblgenerals' => $this->tblgenerals,
        ]);
    }

    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }

    public function updatedgrupoId($id){   
        
        $this->cursoId  = '';
        $this->detalles = [];

    }

    public function updatedservicioId($id){
        
        $this->cursoId = $id;
        $this->loadData(); 
    }

    public function boletin(){

        $records = TdBoletinFinal::query()
        ->join('tm_personas as p', 'p.id', '=', 'td_boletin_finals.persona_id')
        ->join('tm_asignaturas as m', 'm.id', '=', 'td_boletin_finals.asignatura_id')
        ->when($this->cursoId, function ($query) {
            return $query->where('curso_id', $this->cursoId);
        })
        ->where('periodo_id', $this->periodoId)
        ->select(
            'td_boletin_finals.*',
            'p.apellidos',
            'p.nombres',
            'm.descripcion as asignatura'
        )
        ->orderBy('p.apellidos')
        ->orderBy('m.descripcion')
        ->get();

        return $records;

    }

    public function loadData(){   

        $this->detalles = $this->notas();

        if (count($this->detalles)>0) {
            $this->mostrar = true;
        }

        $this->filters['periodoId'] = $this->periodoId;
        $this->filters['grupoId'] = $this->grupoId;
        $this->filters['gradoId'] = $this->servicioId;
        $this->filters['cursoId'] = $this->cursoId;
        $this->datos = json_encode($this->filters);

    }

    public function notas(){

        $records = $this->boletin();

        $this->alumnos = $records
        ->groupBy('persona_id')
        ->map(function ($items) {
            return [
                'persona_id' => $items->first()->persona_id,
                'apellidos'  => $items->first()->apellidos,
                'nombres'    => $items->first()->nombres,
            ];
        })
        ->values();

        $this->asignaturas = $records
        ->groupBy('asignatura_id')
        ->map(function ($items) {
            return [
                'asignatura_id' => $items->first()->asignatura_id,
                'descripcion'   => $items->first()->asignatura,
            ];
        })
        ->values();

        $linea=1;
        $detalle = [];

        //Conducta
        $escalas = TdPeriodoSistemaEducativos::query()
        ->where("periodo_id",$this->periodoId)
        ->where("modalidad_id",$this->grupoId)
        ->where("tipo","EC")
        ->selectRaw("*,nota + case when nota=10 then 0 else 0.99 end as nota2")
        ->get()->toArray();

        $arrconducta = TdConductas::query()
        ->join("td_periodo_sistema_educativos as s", function($join){
            $join->on("s.periodo_id","=","td_conductas.periodo_id")
                ->on("s.codigo","=","td_conductas.evaluacion")
                ->where("s.tipo","EC");
        })
        ->where("td_conductas.periodo_id", $this->periodoId)
        ->where("td_conductas.modalidad_id", $this->grupoId)
        ->where("td_conductas.curso_id", $this->cursoId)
        ->whereIn("td_conductas.persona_id", $this->alumnos->pluck('persona_id'))
        ->select('termino', 'td_conductas.evaluacion', 'persona_id','s.nota')
        ->get()
        ->groupBy('persona_id')
        ->map(function ($items) {

            $promedio = round($items->avg('nota'),2);

            return [
                'conducta' => $items->pluck('evaluacion', 'termino')->toArray(),
                'promedio' => $promedio
            ];
        })
        ->toArray();

        foreach ($arrconducta as $persona => $data) {

            $promedio = $data['promedio'];
            $letra = '';

            foreach ($escalas as $eq) {
                if ($promedio >= $eq['nota'] && $promedio <= $eq['nota2']) {
                    $letra = $eq['codigo'];
                    break;
                }
            }

            $arrconducta[$persona]['promedio_letra'] = $letra;
        }

        //Detalle
        foreach ($this->alumnos as $persona)
        {
            $idpersona = $persona['persona_id'];
            $detalles[$idpersona]['linea'] = $linea;
            $detalles[$idpersona]['nombres'] = $persona['apellidos'].' '.$persona['nombres'];
            $detalles[$idpersona]['comportamiento'] = $arrconducta[$idpersona]['promedio_letra'] ?? '';

            foreach($this->asignaturas as $asignatura){
                $idasignatura = $asignatura['asignatura_id'];

                $nota = $records
                ->where('persona_id', $idpersona)
                ->where('asignatura_id', $idasignatura)
                ->first();

                $detalles[$idpersona][$idasignatura]['1T'] = $nota->{'1T_notatrimestre'} ?? 0;
                $detalles[$idpersona][$idasignatura]['2T'] = $nota->{'2T_notatrimestre'} ?? 0;
                $detalles[$idpersona][$idasignatura]['3T'] = $nota->{'3T_notatrimestre'} ?? 0;
                $detalles[$idpersona][$idasignatura]['PR'] = $nota->promedio_anual ?? 0;
                $detalles[$idpersona][$idasignatura]['PF'] = $nota->promedio_final ?? 0;
            }

            $linea = $linea+1;
        }

        return $detalles;

    }

    public function consulta()
    {
        
        $records = TdBoletinFinal::query()
        ->join('tm_personas as p', 'p.id', '=', 'td_boletin_finals.persona_id')
        ->join('tm_asignaturas as m', 'm.id', '=', 'td_boletin_finals.asignatura_id')
        ->when($this->cursoId, function ($query) {
            return $query->where('curso_id', $this->cursoId);
        })
        ->where('periodo_id', $this->periodoId)
        ->select(
            'td_boletin_finals.*',
            'p.apellidos',
            'p.nombres',
            'm.descripcion as asignatura'
        )
        ->orderBy('p.apellidos')
        ->orderBy('m.descripcion')
        ->get();

        $alumnos = $records
        ->groupBy('persona_id')
        ->map(function ($items) {
            return [
                'persona_id' => $items->first()->persona_id,
                'apellidos'  => $items->first()->apellidos,
                'nombres'    => $items->first()->nombres,
            ];
        })
        ->values();

        $asignaturas = $records
        ->groupBy('asignatura_id')
        ->map(function ($items) {
            return [
                'asignatura_id' => $items->first()->asignatura_id,
                'descripcion'   => $items->first()->asignatura,
            ];
        })
        ->values();

        $linea=1;
        $detalle = [];

        //Conducta
        $escalas = TdPeriodoSistemaEducativos::query()
        ->where("periodo_id",$this->periodoId)
        ->where("modalidad_id",$this->grupoId)
        ->where("tipo","EC")
        ->selectRaw("*,nota + case when nota=10 then 0 else 0.99 end as nota2")
        ->get()->toArray();

        $arrconducta = TdConductas::query()
        ->join("td_periodo_sistema_educativos as s", function($join){
            $join->on("s.periodo_id","=","td_conductas.periodo_id")
                ->on("s.codigo","=","td_conductas.evaluacion")
                ->where("s.tipo","EC");
        })
        ->where("td_conductas.periodo_id", $this->periodoId)
        ->where("td_conductas.modalidad_id", $this->grupoId)
        ->where("td_conductas.curso_id", $this->cursoId)
        ->whereIn("td_conductas.persona_id", $this->alumnos->pluck('persona_id'))
        ->select('termino', 'td_conductas.evaluacion', 'persona_id','s.nota')
        ->get()
        ->groupBy('persona_id')
        ->map(function ($items) {

            $promedio = round($items->avg('nota'),2);

            return [
                'conducta' => $items->pluck('evaluacion', 'termino')->toArray(),
                'promedio' => $promedio
            ];
        })
        ->toArray();

        foreach ($arrconducta as $persona => $data) {

            $promedio = $data['promedio'];
            $letra = '';

            foreach ($escalas as $eq) {
                if ($promedio >= $eq['nota'] && $promedio <= $eq['nota2']) {
                    $letra = $eq['codigo'];
                    break;
                }
            }

            $arrconducta[$persona]['promedio_letra'] = $letra;
        }

        //Detalle
        foreach ($alumnos as $persona)
        {
            $idpersona = $persona['persona_id'];
            $detalles[$idpersona]['linea'] = $linea;
            $detalles[$idpersona]['nombres'] = $persona['apellidos'].' '.$persona['nombres'];
            $detalles[$idpersona]['comportamiento'] = $arrconducta[$idpersona]['promedio_letra'] ?? '';

            foreach($asignaturas as $asignatura){
                $idasignatura = $asignatura['asignatura_id'];

                $nota = $records
                ->where('persona_id', $idpersona)
                ->where('asignatura_id', $idasignatura)
                ->first();

                $detalles[$idpersona][$idasignatura]['1T'] = $nota->{'1T_notatrimestre'} ?? 0;
                $detalles[$idpersona][$idasignatura]['2T'] = $nota->{'2T_notatrimestre'} ?? 0;
                $detalles[$idpersona][$idasignatura]['3T'] = $nota->{'3T_notatrimestre'} ?? 0;
                $detalles[$idpersona][$idasignatura]['PR'] = $nota->promedio_anual ?? 0;
                $detalles[$idpersona][$idasignatura]['PF'] = $nota->promedio_final ?? 0;
            }

            $linea = $linea+1;
        }

        return $detalles;

    }

    public function printPDF($objdata)
    {
        $data = json_decode($objdata);
        $this->periodoId = $data->periodoId;
        $this->grupoId   = $data->grupoId;
        $this->servicioId = $data->gradoId;
        $this->cursoId    = $data->cursoId;

        $tblperiodo = TmPeriodosLectivos::find($this->periodoId);
        $tblrecords = $this->notas();
        $tblcia = TmSedes::all()->first();

        $this->consulta['referencia'] = $tblperiodo['descripcion'];
        $this->consulta['nombre'] = $tblcia['nombre'];
        $this->consulta['direccion'] = $tblcia['direccion'];
        $this->consulta['telefono'] = $tblcia['telefono_sede'];
        $this->consulta['email'] = $tblcia['email'];
        $this->consulta['periodo'] = 'PERIODO LECTIVO '.$tblperiodo['descripcion'];
        $this->consulta['codigo'] = $tblcia['codigo'];
        $this->consulta['rector'] = '';
        $this->consulta['secretaria'] = '';

        $pdf = PDF::loadView('reports/calificaciones',[
            'tblrecords'  => $tblrecords,
            'data' => $this->consulta,
            'materias' => $this->materias
        ]);

        return $pdf->setPaper('a4','landscape')->stream('Cuadro de Calificaciones.pdf');

    }

    public function exportExcel()
    {
        $data = json_encode($this->filters);
        return Excel::download(new RatingsDetailExport($data), 'Cuadro de Calificaciones.xlsx');
    }


}
