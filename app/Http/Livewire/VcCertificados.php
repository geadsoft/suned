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

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Luecano\NumeroALetras\NumeroALetras;
use PDF;

use Illuminate\Support\Facades\DB;

class VcCertificados extends Component
{
    public $tblperiodo, $control="";
    public $tipoDoc="MF", $periodoId, $cursoId, $nombres, $nui="", $documento, $fecha, $folio=0, $matricula=0, $nomcurso="";
    public $periodo, $foto="", $rector, $secretaria, $coordinador, $bachilleren="", $nota=0, $escala=''; 
    public $dttitulo="", $dtnombre="", $dtinstitucion="", $dtcargo="", $dtfecha, $refrendacion=0, $pagina=0, $fprorroga, $documentos="";
    public $especializacion="",$paseCursoId,$matriculaId=0;

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
        
        $this->tblperiodos = TmPeriodosLectivos::orderBy('periodo','desc')->get();
        $this->periodoId = $this->tblperiodos['0']['id'];
        $this->periodo   = $this->tblperiodos['0']['descripcion'];

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
                
        return view('livewire.vc-certificados',[
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
        $this->fecha     =  date('Y-m-d',strtotime($tblmatricula['fecha']));
        $this->cursoId   =  $tblmatricula->curso_id;

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

    public function print($modo){

        if ($this->tipoDoc!='ND'){

            foreach($this->tblperiodos as $row){
                if ($row['id'] = $this->periodoId){
                    $this->periodo = $row['descripcion'];
                    break; 
                }
            }

        }

        $ldate  = date('Y-m-d H:i:s');

        $data = TmReportes::where('tipo',$this->tipoDoc)->first();

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
                'rector' => $this->rector,
                'secretaria' => $this->secretaria,
                'coordinador' => $this->coordinador,
            ]);

        }

        if ($modo=='P'){
            return redirect()->to('/preview-pdf/certificados/'.$reporte['id']);
        }else{
            return redirect()->to('/download-pdf/certificados/'.$reporte['id']); 
        }

    }

    public function liveWirePDF($idReporte)
    { 
        $sede  = TmSedes::orderBy('id','desc')->first();
        $data  = TmReportes::find($idReporte);
        $matricula = TmMatricula::find($data['matricula_id']);

        $notas = TrCalificacionesDets::query()
        ->join('tr_calificaciones_cabs as c','c.id','=','tr_calificaciones_dets.calificacioncab_id')
        ->join('tm_asignaturas as a','a.id','=','c.asignatura_id')
        ->join('tm_generalidades as g','g.id','=','a.area_id')
        ->select('tr_calificaciones_dets.*','a.descripcion as materia','g.descripcion as area')
        ->where('tr_calificaciones_dets.estudiante_id',$matricula['estudiante_id'])
        ->where('c.periodo_id',$matricula['periodo_id'])
        ->where('c.curso_id',$matricula['curso_id'])
        ->get();

        dd($matricula);

        $this->foto    = $data['identificacion'].'.jpg';

        $contents   = Storage::disk('public')->exists('fotos/'.$this->foto);
        
        if($contents==false){
            $this->foto='';
        }

        $formatter = new NumeroALetras();
        $numletra = $formatter->toWords($data['nota'], 2);

        $mes  = ["01" => 'Enero', "02" => 'Febrero', "03" => 'Marzo', "04" => 'Abril', "05" => 'Mayo', "06" => 'Junio',
        "07" => 'Julio', "08" => 'Agosto', "09" => 'Septiembre', "10" => 'Octubre', "11" => 'Noviembre', "12" => 'Diciembre'];

        $arraydcto = [
            'AC' => 'Acta',
            'TI' => 'Título',
            'AT' => 'Acta y TÍtulo',
        ];

        switch ($data['tipo']) {
            case 'MF':
                
                $pdf = PDF::loadView('reports/matricula_folio',[
                    'data'  => $data,
                    'mes'   => $mes,
                    'foto'  => $this->foto,
                ]);
        
                return $pdf->setPaper('a4')->stream('Certificado Folio.pdf');

                break;
            case 'MA':
                
                $pdf = PDF::loadView('reports/certificado_matricula',[
                    'data'  => $data,
                    'mes'   => $mes,
                ]);
        
                return $pdf->setPaper('a4')->stream('Certificado Matrícula.pdf');

                break;
            case 'PA':
                
                $pdf = PDF::loadView('reports/certificado_pasantias',[
                    'data'  => $data,
                    'mes'   => $mes,
                ]);
        
                return $pdf->setPaper('a4')->stream('Certificado Pasantias.pdf');

                break;
            case 'CO':
                
                $pdf = PDF::loadView('reports/certificado_conducta',[
                    'data'  => $data,
                    'mes'   => $mes,
                    'numletra' => $numletra,
                ]);
        
                return $pdf->setPaper('a4')->stream('Certificado Conducta.pdf');

                break;
            case 'AP':
                
                $pdf = PDF::loadView('reports/certificado_aprovechamiento',[
                    'data'  => $data,
                    'mes'   => $mes,
                    'numletra' => $numletra,
                ]);
        
                return $pdf->setPaper('a4')->stream('Certificado Aprovechamiento.pdf');

                break;
            case 'PR':
                
                $pdf = PDF::loadView('reports/certificado_pase',[
                    'data'  => $data,
                    'mes'   => $mes,
                ]);
        
                return $pdf->setPaper('a4')->stream('Solicitud Pase Reglamentado.pdf');

                break;
            case 'AR':

                $pdf = PDF::loadView('reports/certificado_acepta_pase',[
                    'data'  => $data,
                    'mes'   => $mes,
                ]);
        
                return $pdf->setPaper('a4')->stream('Solicitud Aceptación Pase Reglamentado.pdf');
            
            case 'ER':

                    $pdf = PDF::loadView('reports/certificado_emision_pase',[
                        'data'  => $data,
                        'mes'   => $mes,
                    ]);
            
                    return $pdf->setPaper('a4')->stream('Solicitud Emisión Pase Reglamentado.pdf');
    
                break;
            case 'RR':

                $pdf = PDF::loadView('reports/certificado_rezago',[
                    'data'  => $data,
                    'mes'   => $mes,
                    'arraydcto' =>  $arraydcto,
                ]);
        
                return $pdf->setPaper('a4')->stream('Certificado Rezago Refrendación.pdf');

                break;
            case 'SD':

                $pdf = PDF::loadView('reports/certificado_distritosi',[
                    'data'  => $data,
                    'mes'   => $mes,
                ]);
        
                return $pdf->setPaper('a4')->stream('Certificado Subsecretaría y Distrito.pdf');

                break;
            case 'ND':

                $pdf = PDF::loadView('reports/certificado_distritono',[
                    'data'  => $data,
                    'mes'   => $mes,
                ]);
        
                return $pdf->setPaper('a4')->stream('Certificado Subsecretaría y Distrito.pdf');

                break;
            case 'PP':

                    $pdf = PDF::loadView('reports/certificado_promocion',[
                        'data'  => $data,
                        'sede'  => $sede,
                        'notas' => $notas,
                    ]);
            
                    return $pdf->setPaper('a4')->stream('Certificado de Promoción.pdf');
    
                    break;
        }
        
    }

    public function downloadPDF($idReporte)
    {

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

        $arraydcto = [
            'AC' => 'Acta',
            'TI' => 'Título',
            'AT' => 'Acta y TÍtulo',
        ];

        switch ($data['tipo']) {
            case 'MF':
                
                $pdf = PDF::loadView('reports/matricula_folio',[
                    'data'  => $data,
                    'mes'   => $mes,
                    'foto'  => $this->foto,
                ]);
        
                return $pdf->download('Certificado Folio.pdf');

                break;
            case 'MA':
                
                $pdf = PDF::loadView('reports/certificado_matricula',[
                    'data'  => $data,
                    'mes'   => $mes,
                ]);
        
                return $pdf->download('Certificado Matrícula.pdf');

                break;
            case 'PA':
                
                $pdf = PDF::loadView('reports/certificado_pasantias',[
                    'data'  => $data,
                    'mes'   => $mes,
                ]);
        
                return $pdf->download('Certificado Pasantias.pdf');

                break;
            case 'CO':
                
                $pdf = PDF::loadView('reports/certificado_conducta',[
                    'data'  => $data,
                    'mes'   => $mes,
                    'numletra' => $numletra,
                ]);
        
                return $pdf->download('Certificado Conducta.pdf');

                break;
            case 'AP':
                
                $pdf = PDF::loadView('reports/certificado_aprovechamiento',[
                    'data'  => $data,
                    'mes'   => $mes,
                    'numletra' => $numletra,
                ]);
        
                return $pdf->download('Certificado Aprovechamiento.pdf');

                break;
            case 'PR':
                
                $pdf = PDF::loadView('reports/certificado_pase',[
                    'data'  => $data,
                    'mes'   => $mes,
                ]);
        
                return $pdf->download('Solicitud Pase Reglamentado.pdf');

                break;
            case 'AR':

                $pdf = PDF::loadView('reports/certificado_acepta_pase',[
                    'data'  => $data,
                    'mes'   => $mes,
                ]);

                return $pdf->download('Solicitud Aceptación Pase Reglamentado.pdf');
            
            case 'ER':

                    $pdf = PDF::loadView('reports/certificado_emision_pase',[
                        'data'  => $data,
                        'mes'   => $mes,
                    ]);
            
                    return $pdf->download('Solicitud Emisión Pase Reglamentado.pdf');
    
                break;
            case 'RR':

                $pdf = PDF::loadView('reports/certificado_rezago',[
                    'data'  => $data,
                    'mes'   => $mes,
                    'arraydcto' =>  $arraydcto,
                ]);
        
                return $pdf->download('Certificado Rezago Refrendación.pdf');

                break;
            case 'SD':

                $pdf = PDF::loadView('reports/certificado_distritosi',[
                    'data'  => $data,
                    'mes'   => $mes,
                ]);
        
                return $pdf->download('Certificado Subsecretaría y Distrito.pdf');

                break;
            case 'ND':

                $pdf = PDF::loadView('reports/certificado_distritono',[
                    'data'  => $data,
                    'mes'   => $mes,
                ]);
        
                return $pdf->download('Certificado Subsecretaría y Distrito.pdf');

                break;
        }


    }


}
