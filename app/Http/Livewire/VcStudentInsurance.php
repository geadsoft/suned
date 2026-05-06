<?php

namespace App\Http\Livewire;
use App\Models\TmMatricula;
use App\Models\TmGeneralidades;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use PDF;

class VcStudentInsurance extends Component
{
    use WithPagination;

    public $filters=[
        'modalidadId' => [],
        'startDate' => '',
        'endDate' => '',
        'cursoId' => '',
        'print' => false
    ];

    public function mount()
    {

        $modalidad = TmGeneralidades::where('superior', 1)->pluck('id')->toArray();

        $this->filters['modalidadId'] = $modalidad;
        

    }

    public function render()
    {
        $tblgenerals = TmGeneralidades::where('superior',1)->get();

        $tblrecords = TmMatricula::from('tm_matriculas as m')
        ->join('tm_personas as p', 'p.id', '=', 'm.estudiante_id')
        ->join('tm_personas as r', 'r.id', '=', 'm.representante_id')
        ->join('tm_generalidades as g', 'g.id', '=', 'm.modalidad_id')
        ->join('tm_cursos as c', 'c.id', '=', 'm.curso_id')
        ->join('tm_servicios as s', 's.id', '=', 'm.grado_id')
        ->select(
            'p.nombres',
            'p.apellidos',
            'p.identificacion',
            'p.fechanacimiento',
            DB::raw("CONCAT(r.nombres,' ',r.apellidos) as representante"),
            'r.telefono',
            'r.email',
            's.descripcion',
            'c.paralelo',
            'g.descripcion as modalidad',
            'm.fecha'
        )
        ->when(!empty($this->filters['modalidadId']),function($query){
            return $query->whereIn('m.modalidad_id', $this->filters['modalidadId']);
        })
        ->whereBetween('m.fecha', [$this->filters['startDate'], $this->filters['endDate']])
        ->paginate(12);

        $filtros = json_encode($this->filters);
        
        return view('livewire.vc-student-insurance',[
            'tblgenerals' => $tblgenerals,
            'tblrecords' => $tblrecords,
            'datos' => $filtros,
        ]);
    }

    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }

    public function reporte(){

        $reporte = TmMatricula::from('tm_matriculas as m')
        ->join('tm_personas as p', 'p.id', '=', 'm.estudiante_id')
        ->join('tm_personas as r', 'r.id', '=', 'm.representante_id')
        ->join('tm_generalidades as g', 'g.id', '=', 'm.modalidad_id')
        ->join('tm_cursos as c', 'c.id', '=', 'm.curso_id')
        ->join('tm_servicios as s', 's.id', '=', 'm.grado_id')
        ->select(
            'p.nombres',
            'p.apellidos',
            'p.identificacion',
            'p.fechanacimiento',
            DB::raw("CONCAT(r.nombres,' ',r.apellidos) as representante"),
            'r.telefono',
            'r.email',
            's.descripcion',
            'c.paralelo',
            'g.descripcion as modalidad',
            'm.fecha'
        )
        ->when(!empty($this->filters['modalidadId']),function($query){
            return $query->whereIn('m.modalidad_id', $this->filters['modalidadId']);
        })
        ->whereBetween('m.fecha', [$this->filters['startDate'], $this->filters['endDate']])
        ->get();

        return $reporte;

    }


    public function printPDF($objdata)
    { 
        $data = json_decode($objdata);
        $this->filters['modalidadId'] = $data->modalidadId;
        $this->filters['startDate']  =  $data->startDate;
        $this->filters['endDate']    =  $data->endDate;
        $this->filters['cursoId']    =  $data->cursoId;

        $reporte = $this->reporte();
        $fecha = date('Y-m-d H:i:s');

        $pdf = PDF::loadView('reports/seguro_estudiantil',[
            'tblrecords' => $reporte,
            'data' =>  $this->filters,
            'fecha' => $fecha,
        ]);

        return $pdf->setPaper('a4', 'landscape')
           ->stream('Seguro Estudiantil.pdf');
        
    }

    public function downloadPDF($objdata)
    {
        $data = json_decode($objdata);
        $this->filters['modalidadId'] = $data->modalidadId;
        $this->filters['startDate']  =  $data->startDate;
        $this->filters['endDate']    =  $data->endDate;
        $this->filters['cursoId']    =  $data->cursoId;

        $reporte = $this->reporte();
        $fecha = date('Y-m-d H:i:s');

        $pdf = PDF::loadView('reports/seguro_estudiantil',[
            'tblrecords' => $reporte,
            'data' =>  $this->filters,
            'fecha' => $fecha,
        ]);

        return $pdf->setPaper('a4', 'landscape')
            ->download('Seguro Estudiantil.pdf');

    }

    public function exportExcel(){

        $data = json_encode($this->filters);
        return Excel::download(new ListadoIngresosExport($data), 'Conciliar Ingresos.xlsx');

    }

}
