<?php

namespace App\Http\Livewire;

use App\Models\TmGeneralidades;
use App\Models\TmPeriodosLectivos;
use App\Models\TmCursos;
use App\Models\TmServicios;
use App\Models\TmMatricula;
use App\Models\TmSedes;
use App\Models\TmReportes;
use App\Models\TrCalificacionesCabs;
use App\Models\TrCalificacionesDets;
use App\Models\TmAsignaturas;
use App\Models\TdBoletinFinal;


use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Luecano\NumeroALetras\NumeroALetras;
use PDF;

use Illuminate\Support\Facades\DB;

class VcPromocion extends Component
{
    public $tblperiodo, $control="disabled";
    public $tipoDoc="PP", $periodoId, $cursoId, $nombres, $nui="", $documento, $fecha, $folio=0, $matricula=0, $nomcurso="", $fechaMatricula;
    public $periodo, $foto="", $rector, $secretaria, $coordinador, $bachilleren="", $nota=0, $escala=''; 
    public $dttitulo="", $dtnombre="", $dtinstitucion="", $dtcargo="", $dtfecha, $refrendacion=0, $pagina=0, $fprorroga, $documentos="";
    public $especializacion="",$paseCursoId,$matriculaId=0,$registrar;
    public $refescala=[
        'EX' => 'Demuestra destacado desempeño en cada fase de desarrollo del proyecto escolar lo que constituye un excente aporte a su formación integral.',
        'MB' => 'Demuestra muy buen desempeño en cada fase de desarrollo del proyecto escolar lo que constituye un aporte a su formación integral.',
        'B'  => 'Demuestra buen desempeño en cada fase de desarrollo del proyecto escolar lo que constituye un aporte a su formación integral.',
        'R'  => 'Demuestra regular desempeño en cada fase de desarrollo del proyecto escolar lo que constituye un aporte a su formación integral.'
    ];

    public $mes = [
        1 => 'Enero',
        2 => 'Febrero',
        3 => 'Marzo',
        4 => 'Abril',
        5 => 'Mayo',
        6 => 'Junio',
        7 => 'Julio',
        8 => 'Agosto',
        9 => 'Septiembre',
        10=> 'Octubre',
        11=> 'Noviembre',
        12=> 'Diciembre',
    ];

    protected $listeners = ['setPersona'];
    
    public function mount()
    {
        $sede = TmSedes::orderBy('id','desc')->first();
        
        $this->rector      = $sede['rector'];
        $this->secretaria  = $sede['secretaria'];
        $this->coordinador = $sede['coordinador'];
        
        $año   = date('Y');
        $periodo = TmPeriodosLectivos::where('periodo',$año)->first();

        $this->tblperiodos = TmPeriodosLectivos::orderBy('periodo','desc')->get();
        $this->periodoId = $periodo['id'];
        $this->periodo   = $periodo['descripcion'];

        $ldate = date('Y-m-d H:i:s');
        $this->fecha   = date('Y-m-d',strtotime($ldate));
        $this->dtfecha = date('Y-m-d',strtotime($ldate));
    }
    
    public function render()
    {

        if ($this->tipoDoc == 'PA' || $this->tipoDoc == 'AR'){
            $tblcursos   = TmServicios::query()
            ->where('nivel_id',11)
            ->where('modalidad_id',2)
            ->orderByRaw('nivel_id,grado_id')
            ->get();
        }else{
            $tblcursos   = TmServicios::query()
            ->where('modalidad_id',2)
            ->orderByRaw('nivel_id,grado_id')
            ->get();
        }
                
        return view('livewire.vc-promocion',[
            'tblperiodos' => $this->tblperiodos,
            'tblcursos' => $tblcursos,
        ]);
    }

    public function search(){

        $this->dispatchBrowserEvent('show-form');

    }

    public function setPersona($idMatricula){

        $this->matriculaId = $idMatricula;
        $tblmatricula    = TmMatricula::find($idMatricula);
        $this->documento =  $tblmatricula['documento'];
        $this->cursoId   =  $tblmatricula->curso_id;
        $this->periodoId =  $tblmatricula->periodo_id;
        $this->fechaMatricula =  date('Y-m-d',strtotime($tblmatricula->fecha)); 

        $objData = DB::Select("select truncate(rownr/100,0) + folio as folio, rownr, documento 
        from (
        SELECT (@row := @row + 1) as rownr,  t.documento, p.folio
        FROM tm_matriculas t, tm_periodos_lectivos p, (SELECT @row := 0) r
        where t.periodo_id = p.id and p.id = ".$tblmatricula['periodo_id'].") as d 
        where documento = '".$this->documento."'");
        
        foreach ($objData as $row){
            $this->folio     = $row->folio; 
            $this->documento = $row->documento;
            $this->matricula = substr($row->documento,-4); 
        }
        
        $cursos     = TmCursos::find($this->cursoId);
        $servicio   = TmServicios::find($cursos->servicio_id);
        $this->cursoId = $cursos->servicio_id;

        $this->nomcurso  = $servicio->descripcion;
        
        $especializacion = $servicio->especializacion->descripcion;

        if ($servicio->nivel_id==11){

            if ($especializacion =='Contabilidad' or $especializacion =='Informática' ){
                $this->bachilleren = "Bachiller de Servicio en ".$especializacion;
            }else{
                $this->bachilleren = "Bachillerato General Unificado en Ciencias";
            }

            if ($this->tipoDoc=='CO' || $this->tipoDoc=='AP'){
                $grado = $cursos->grado->descripcion;
                $array = [
                    'Primero' => 'PRIMER AÑO',
                    'Segundo' => 'SEGUNDO AÑO',
                    'Tercero' => 'TERCER AÑO',
                ];
    
                $this->bachilleren = $array[$grado]." BACHILLERATO GENERAL UNIFICADO EN CIENCIAS";
            }

        }else{
            $this->bachilleren = $this->nomcurso;
        }

        $this->nombres = $tblmatricula->estudiante->apellidos.' '.$tblmatricula->estudiante->nombres;
        $this->nui     = $tblmatricula->estudiante->identificacion;
        $this->foto    = $tblmatricula->estudiante->foto;

        $contents   = Storage::disk('public')->exists('fotos/'.$this->foto);
        
        if($contents==false){
            $this->foto='';
        }

        $this->periodo = $tblmatricula->periodo->descripcion;

        $this->dispatchBrowserEvent('hide-form');

    }

    public function updatedCursoId(){
        
        $servicio = TmServicios::find($this->cursoId);
        
        $this->nomcurso  = $servicio->descripcion;
        
        $especializacion = $servicio->especializacion->descripcion;

        if ($servicio->nivel_id==11){

            if ($especializacion =='Contabilidad' || $especializacion =='Informática' ){
                $this->bachilleren = "Bachiller de Servicio en ".$especializacion;
            }else{
                $this->bachilleren = "Bachillerato General Unificado en Ciencias";
            }

        }else{
            $this->bachilleren = $this->nomcurso;
        }

        if ($this->tipoDoc=='CO' || $this->tipoDoc=='AP' || $this->tipoDoc=='PR' || $this->tipoDoc=='AR' ){
            $grado = $servicio->grado->descripcion;
            $array = [
                'Primero' => 'PRIMER AÑO DE ',
                'Segundo' => 'SEGUNDO AÑO DE ',
                'Tercero' => 'TERCER AÑO DE ',
            ];

            $this->bachilleren = $array[$grado].strtoupper($this->bachilleren);
        }

        if ($this->tipoDoc=='RR'){
            $this->bachilleren = $especializacion;
        }

    }

    public function updatedtipoDoc(){

        if ($this->tipoDoc == 'MF'){
            $this->control="";
        }else{
            $this->control="disabled";
        }

    }

    public function validar(){

        switch ($this->tipoDoc) {
            case 'MF':

                $this ->validate([
                    'nombres' => 'required',
                    'periodo' => 'required',
                    'nomcurso' => 'required',
                    'documento' => 'required',
                    'fecha' => 'required',
                    'folio'  => 'required',
                    'matricula' => 'required',
                    'rector' => 'required',
                    'secretaria' => 'required',
                ]);
                
                break;
            case 'MA':

                $this ->validate([
                    'nombres' => 'required',
                    'periodo' => 'required',
                    'nomcurso' => 'required',
                    'nui' => 'required',
                    'rector' => 'required',
                    'secretaria' => 'required',
                ]);

                break;
            case 'PA':
                
                $this ->validate([
                    'nombres' => 'required',
                    'periodo' => 'required',
                    'nomcurso' => 'required',
                    'nui' => 'required',
                    'bachilleren' => 'required',
                    'rector' => 'required',
                    'secretaria' => 'required',
                ]);

                break;
            case 'CO':

                $this ->validate([
                    'nombres' => 'required',
                    'periodo' => 'required',
                    'nomcurso' => 'required',
                    'nui' => 'required',
                    'escala' => 'required',
                    'nota' => 'required',
                    'rector' => 'required',
                    'secretaria' => 'required',
                ]);

                break;
            case 'AP':

                $this ->validate([
                    'nombres' => 'required',
                    'periodo' => 'required',
                    'nomcurso' => 'required',
                    'nui' => 'required',
                    'nota' => 'required',
                    'rector' => 'required',
                    'secretaria' => 'required',
                ]);


                break;
            case 'PR':

                $this ->validate([
                    'dtfecha' => 'required',
                    'nombres' => 'required',
                    'periodo' => 'required',
                    'nomcurso' => 'required',
                    'dttitulo' => 'required',
                    'dtnombre' => 'required',
                    'dtcargo'  => 'required',
                    'dtinstitucion' => 'required',
                    'rector' => 'required',
                    'secretaria' => 'required',
                ]); 

                break;
            case 'AR':

                $this ->validate([
                    'dtfecha' => 'required',
                    'nombres' => 'required',
                    'periodo' => 'required',
                    'nomcurso' => 'required',
                    'dttitulo' => 'required',
                    'dtnombre' => 'required',
                    'dtcargo'  => 'required',
                    'dtinstitucion' => 'required',
                    'rector' => 'required',
                    'secretaria' => 'required',
                ]); 

                break;
            case 'ER':
                
                $this ->validate([
                    'dtfecha' => 'required',
                    'nombres' => 'required',
                    'periodo' => 'required',
                    'nomcurso' => 'required',
                    'dttitulo' => 'required',
                    'dtnombre' => 'required',
                    'dtcargo'  => 'required',
                    'dtinstitucion' => 'required',
                    'rector' => 'required',
                    'secretaria' => 'required',
                ]); 

                break;
            case 'RR':

                $this ->validate([
                    'nombres' => 'required',
                    'nui' => 'required',
                    'periodo' => 'required',
                    'bachilleren' => 'required',
                    'nota' => 'required',
                    'dtfecha' => 'required',
                    'refrendacion' => 'required',
                    'pagina'  => 'required',
                    'fprorroga' => 'required',
                    'documentos' => 'required',
                    'rector' => 'required',
                    'secretaria' => 'required',
                ]); 

                break;
            case 'SD':

                $this ->validate([
                    'nombres' => 'required',
                    'nui' => 'required',
                    'periodo' => 'required',
                    'bachilleren' => 'required',
                    'nota' => 'required',
                    'dtfecha' => 'required',
                    'refrendacion' => 'required',
                    'pagina'  => 'required',
                    'rector' => 'required',
                    'secretaria' => 'required',
                ]); 

                break;
            case 'ND':

                $this ->validate([
                    'nombres' => 'required',
                    'nui' => 'required',
                    'periodo' => 'required',
                    'rector' => 'required',
                    'secretaria' => 'required',
                ]); 

                break;
            case 'PP':

                $this ->validate([
                    'fecha' => 'required',
                    'nombres' => 'required',
                    'nui' => 'required',
                    'periodo' => 'required',
                    'nomcurso' => 'required',
                    'paseCursoId' => 'required',
                    'rector' => 'required',
                    'secretaria' => 'required',
                ]); 
                break;
        }

    }

    public function print($modo){

        $this->validar();

        if ($this->tipoDoc!='ND'){

            foreach($this->tblperiodos as $row){
                if ($row['id'] == $this->periodoId){
                    $this->periodo = $row['descripcion'];
                    break; 
                }
            }

        }

        $ldate  = date('Y-m-d H:i:s');

        $data     = TmReportes::where('tipo',$this->tipoDoc)->first();
        $nomcurso_pase ='';

        if ($this->tipoDoc=='PP'){
            $servicio = TmServicios::find($this->paseCursoId);
            $nomcurso_pase = $servicio->descripcion;
        }
    
        if ($data!=null){

            $reporte = TmReportes::find($data->id);
            $reporte->update([
                'emision' => date('Y-m-d',strtotime($ldate)),
                'periodo' => $this->periodo,
                'identificacion' => $this->nui,
                'nombres' => $this->nombres,
                'curso' => $this->nomcurso,
                'especializacion' => $this->bachilleren,
                'folio' => $this->folio,
                'matricula' => $this->matricula,
                'fecha' => $this->dtfecha,
                'nota' => $this->nota,
                'escala' => $this->escala,
                'asunto' => $this->dttitulo,
                'destinatario' => $this->dtnombre,
                'institucion' => $this->dtinstitucion,
                'cargo' => $this->dtcargo,
                'refrendacion' => $this->refrendacion,
                'pagina' => $this->pagina,
                'fprorroga' => date('Y-m-d',strtotime($this->fprorroga)),
                'documento' => $this->documentos,
                'matricula_id' => $this->matriculaId,
                'curso_promovido' => $nomcurso_pase,
                'rector' => $this->rector,
                'secretaria' => $this->secretaria,
                'coordinador' => $this->coordinador,
            ]);

        }else{
                
            $reporte = TmReportes::Create([
                'tipo' => $this->tipoDoc,
                'emision' => date('Y-m-d',strtotime($ldate)),
                'periodo' => $this->periodo,
                'identificacion' => $this->nui,
                'nombres' => $this->nombres,
                'curso' => $this->nomcurso,
                'especializacion' => $this->bachilleren,
                'folio' => $this->folio,
                'matricula' => $this->matricula,
                'fecha' => $this->dtfecha,
                'nota' => $this->nota,
                'escala' => $this->escala,
                'asunto' => $this->dttitulo,
                'destinatario' => $this->dtnombre,
                'institucion' => $this->dtinstitucion,
                'cargo' => $this->dtcargo,
                'refrendacion' => $this->refrendacion,
                'pagina' => $this->pagina,
                'fprorroga' => date('Y-m-d',strtotime($this->fprorroga)),
                'documento' => $this->documentos,
                'matricula_id' => $this->matriculaId,
                'curso_promovido' => $nomcurso_pase,
                'rector' => $this->rector,
                'secretaria' => $this->secretaria,
                'coordinador' => $this->coordinador,
            ]);

        }

        if ($modo=='P'){
            //return redirect()->to('/preview-pdf/certificado-promocion/'.$reporte['id']);
            $this->dispatchBrowserEvent('openPdf', [
                'url' => url('/preview-pdf/certificado-promocion/'.$reporte['id'])
            ]);
        }else{
            return redirect()->to('/download-pdf/certificados/'.$reporte['id']); 
        }

    }

    public function calificaciones($matricula){

        $pases = DB::table('tm_pase_cursos as p')
        ->join('tm_matriculas as m', 'm.id', '=', 'p.matricula_id')
        ->where('p.matricula_id',$matricula['id'])
        ->where('p.estado',"A")
        ->select('m.curso_id', 'p.modalidad_id', 'p.estudiante_id')
        ->first();

        if(!empty($pases)){
            $matricula['curso_id'] = $pases->curso_id; 
        }

        $notas = TdBoletinFinal::query()
        ->join('tm_asignaturas as a','a.id','=','td_boletin_finals.asignatura_id')
        ->join('tm_generalidades as g','g.id','=','a.area_id')
        ->select('td_boletin_finals.*','a.descripcion as materia','g.descripcion as area')
        ->where('td_boletin_finals.periodo_id',$matricula['periodo_id'])
        ->where('td_boletin_finals.curso_id',$matricula['curso_id'])
        ->where('td_boletin_finals.persona_id',$matricula['estudiante_id'])
        ->orderBy('g.descripcion')
        ->get();

                
        $objnotas = [];
        $total=0;
        foreach($notas as $record){
            $data['area']    = $record['area'];
            $data['materia'] = $record['materia']; 

            /*if ($record['escala_cualitativa']!=''){
                $data['nota']  = $record['escala_cualitativa']; 
                $data['letra'] = $this->refescala[$record['escala_cualitativa']];
            }else{*/
                $data['nota'] = $record['promedio_final'];
                $total =$total+$record['promedio_final'];
                $formatter = new NumeroALetras();
                $notaletra = $formatter->toWords($record['promedio_final'], 2);
                $data['letra'] = $notaletra;
            /*}*/
            
            array_push($objnotas, $data);
        }
        $promedio = round($total/count($objnotas), 2);
        $data['area']='';
        $data['materia'] = '';
        $data['nota'] = $promedio;

        $formatter = new NumeroALetras();
        $notaletra = $formatter->toWords($promedio, 2);
        $data['letra']=$notaletra;
        array_push($objnotas, $data);

        return $objnotas;
    }

    public function promedio($matricula){

        $notas = TrCalificacionesDets::query()
        ->join('tr_calificaciones_cabs as c','c.id','=','tr_calificaciones_dets.calificacioncab_id')
        ->join('tm_asignaturas as a','a.id','=','c.asignatura_id')
        ->join('tm_generalidades as g','g.id','=','a.area_id')
        ->select('tr_calificaciones_dets.*','a.descripcion as materia','g.descripcion as area')
        ->where('tr_calificaciones_dets.estudiante_id',$matricula['estudiante_id'])
        ->where('c.periodo_id',$matricula['periodo_id'])
        ->where('c.curso_id',$matricula['curso_id'])
        ->where('c.parcial','P1')
        ->where('c.evaluacion','N')
        ->select('g.descripcion as area','a.descripcion as materia','tr_calificaciones_dets.calificacion')
        ->get();

        return $notas;
    }

    public function liveWirePDF($idReporte)
    { 
        $sede  = TmSedes::orderBy('id','desc')->first();
        $data  = TmReportes::find($idReporte);
        $matricula = TmMatricula::find($data['matricula_id']);

        $this->foto    = $data['identificacion'].'.jpg';

        $contents   = Storage::disk('public')->exists('fotos/'.$this->foto);
        
        if($contents==false){
            $this->foto='';
        }

        $formatter = new NumeroALetras();
        $numletra = $formatter->toWords($data['nota'], 2);

        $mes  = ["01" => 'Enero', "02" => 'Febrero', "03" => 'Marzo', "04" => 'Abril', "05" => 'Mayo', "06" => 'Junio',
        "07" => 'Julio', "08" => 'Agosto', "09" => 'Septiembre', "10" => 'Octubre', "11" => 'Noviembre', "12" => 'Diciembre'];

        $notas = $this->calificaciones($matricula);
        $pdf = PDF::loadView('reports/certificado_promocion',[
            'data'  => $data,
            'sede'  => $sede,
            'notas' => $notas,
            'mes'   => $mes,
        ]);

        return $pdf->setPaper('a4')->stream('Certificado de Promoción.pdf');
        
    }

    public function downloadPDF($idReporte)
    {
        $sede  = TmSedes::orderBy('id','desc')->first();
        $data = TmReportes::find($idReporte);

        $this->foto    = $data['identificacion'].'.jpg';

        $contents   = Storage::disk('public')->exists('fotos/'.$this->foto);
        
        if($contents==false){
            $this->foto='';
        }

        $formatter = new NumeroALetras();
        $numletra = $formatter->toWords($data['nota'], 2);

        $mes  = ["01" => 'Enero', "02" => 'Febrero', "03" => 'Marzo', "04" => 'Abril', "05" => 'Mayo', "06" => 'Junio',
        "07" => 'Julio', "08" => 'Agosto', "09" => 'Septiembre', "10" => 'Octubre', "11" => 'Noviembre', "12" => 'Diciembre'];


        $notas = $this->calificaciones($matricula);
        $pdf = PDF::loadView('reports/certificado_promocion',[
            'data'  => $data,
            'sede'  => $sede,
            'notas' => $notas,
            'mes'   => $mes,
        ]);

        return $pdf->download('Certificado de Promoción.pdf');

    }


}
