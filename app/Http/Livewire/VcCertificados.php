<?php

namespace App\Http\Livewire;

use App\Models\TmGeneralidades;
use App\Models\TmPeriodosLectivos;
use App\Models\TmCursos;
use App\Models\TmMatricula;
use App\Models\TmSedes;
use App\Models\TmReportes;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Luecano\NumeroALetras\NumeroALetras;
use PDF;

class VcCertificados extends Component
{
    public $tblperiodo;
    public $tipoDoc="MF", $periodoId, $cursoId, $nombres, $nui, $documento, $fecha, $folio=0, $matricula=0, $nomcurso;
    public $periodo, $foto="", $rector, $secretaria, $coordinador, $bachilleren, $nota=0, $escala=''; 
    public $dttitulo='', $dtnombre='', $dtinstitucion='', $dtciudad='', $dtfecha;

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

        if ($this->tipoDoc == 'PA'){
            $tblcursos   = TmCursos::query()
            ->where('periodo_id',$this->periodoId)
            ->where('nivel_id',11)
            ->orderByRaw('nivel_id,grado_id,paralelo')
            ->get();
        }else{
            $tblcursos   = TmCursos::query()
            ->where('periodo_id',$this->periodoId)
            ->orderByRaw('nivel_id,grado_id,paralelo')
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

        $tblmatricula    = TmMatricula::find($idMatricula);
        $this->documento =  $tblmatricula['documento'];
        $this->fecha     =  date('Y-m-d',strtotime($tblmatricula['fecha']));
        $this->cursoId   =  $tblmatricula['curso_id'];

        $cursos         = TmCursos::find($this->cursoId);
        $this->nomcurso    = $cursos->servicio->descripcion;
        
        $especializacion = $cursos->especializacion->descripcion;

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
        
        $cursos = TmCursos::find($this->cursoId);
        $this->nomcurso  = $cursos->servicio->descripcion;
        
        $especializacion = $cursos->especializacion->descripcion;

        if ($especializacion =='Contabilidad' || $especializacion =='Informática' ){
            $this->bachilleren = "Bachiller de Servicio en ".$especializacion;
        }else{
            $this->bachilleren = "Bachillerato General Unificado en Ciencias";
        }

        if ($this->tipoDoc=='CO' || $this->tipoDoc=='AP' || $this->tipoDoc=='PR' ){
            $grado = $cursos->grado->descripcion;
            $array = [
                'Primero' => 'PRIMER AÑO DE ',
                'Segundo' => 'SEGUNDO AÑO DE ',
                'Tercero' => 'TERCER AÑO DE ',
            ];

            $this->bachilleren = $array[$grado].strtoupper($this->bachilleren);
        }

    }

    public function print(){

        foreach($this->tblperiodos as $row){
            if ($row['id'] = $this->periodoId){
                $this->periodo = $row['descripcion'];
                break; 
            }
        }

        $ldate  = date('Y-m-d H:i:s');
                
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
            'fecha' => $this->fecha,
            'nota' => $this->nota,
            'escala' => $this->escala,
            'asunto' => $this->dttitulo,
            'destinatario' => $this->dtnombre,
            'institucion' => $this->dtinstitucion,
            'ciudad' => $this->dtciudad,
            'rector' => $this->rector,
            'secretaria' => $this->secretaria,
            'coordinador' => $this->coordinador,
        ]);

        return redirect()->to('/preview-pdf/certificados/'.$reporte['id']); 

    }

    public function liveWirePDF($idReporte)
    { 
        
        $data = TmReportes::find($idReporte);
        $formatter = new NumeroALetras();
        $numletra = $formatter->toWords($data['nota'], 2);

        $mes  = ["01" => 'Enero', "02" => 'Febrero', "03" => 'Marzo', "04" => 'Abril', "05" => 'Mayo', "06" => 'Junio',
        "07" => 'Julio', "08" => 'Agosto', "09" => 'Septiembre', "10" => 'Octubre', "11" => 'Noviembre', "12" => 'Diciembre'];

        switch ($data['tipo']) {
            case 'MF':
                
                $pdf = PDF::loadView('reports/matricula_folio',[
                    'data'  => $data,
                    'mes'   => $mes,
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
    
                break;
            case 'RR':

                break;
            case 'SD':

                break;
            case 'ND':

                break;
            case 'LI':

                break;
        }
        
    }


}
