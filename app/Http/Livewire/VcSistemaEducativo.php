<?php

namespace App\Http\Livewire;
use App\Models\TmPeriodosLectivos;
use App\Models\TdPeriodoSistemaEducativos;
use App\Models\TmGeneralidades;


use Livewire\Component;

class VcSistemaEducativo extends Component
{
    public $periodoId, $plectivo, $metodo, $aperturado, $eformativa, $esumativa, $detalle=[], $modalidadId, $hora_ini, $hora_fin;
    public $arrmetodo=[];
    public $arrparcial=[];
    public $arractividad=[];
    public $arrescala=[];
    public $arrhora=[];
    public $tblmodalidad=[];

    public $evaluacion = [
        'T' => 'TRIMESTRE',
        'Q' => 'QUIMESTRE',
    ];

    public $romano=[
        1 => 'I',
        2 => 'II',
        3 => 'III',
        4 => 'IV',
        5 => 'V'
    ];

    public function mount()
    {
        $this->plectivo = TmPeriodosLectivos::query()
        ->where('estado','<>','C')
        ->orWhere('aperturado',1)
        ->get();
        $this->periodoId = $this->plectivo[0]['id'];
        
        $this->metodo = 'T';
        $this->loadData();

    }

    public function render()
    {
        $this->tblmodalidad = TmGeneralidades::query()
        ->where('superior',1)
        ->get();

        $this->updatedModalidadId($this->modalidadId);
        
        return view('livewire.vc-sistema-educativo',[
            'arrmetodo' => $this->arrmetodo,
            'arrparcial' => $this->arrparcial,
            'arractividad' => $this->arractividad,
            'tblmodalidad' =>  $this->tblmodalidad,
        ]);
    }

    public function loadData()
    {
        
        $this->arrparcial=[];
        $this->arrmetodo=[];
        $this->arractividad=[];
        $this->arrescala=[];

        $this->tblmodalidad = TmGeneralidades::query()
        ->where('superior',1)
        ->get();
        
        $record = TmPeriodosLectivos::find($this->periodoId);
        $this->metodo = $record['evaluacion'];
        $this->esumativa = $record['evaluacion_sumativa'];
        $this->eformativa = $record['evaluacion_formativa'];
        $this->aperturado = $record['aperturado'];
        $this->modalidadId = $this->tblmodalidad[0]['id'];

        $detalle = TdPeriodoSistemaEducativos::where('periodo_id',$this->periodoId)->get();
        
        $this->arrhora = TdPeriodoSistemaEducativos::query()
        ->where('periodo_id',$this->periodoId)
        ->where('tipo','HC')
        ->where('modalidad_id',$this->modalidadId)
        ->get();

        if ($this->metodo==''){
            $this->metodo = 'T';
            $this->addarr($this->metodo);
        }

        foreach ($detalle as $key => $value) {
            if ($value['tipo']=='EA'){
                $datos = [
                    'linea' => $key+1,
                    'codigo' => $value['codigo'],
                    'descripcion' => $value['descripcion'],
                ];
                array_push($this->arrmetodo,$datos);
            }
        }

        $linea=0;
        $nombre='';
        foreach ($detalle as $key => $value) {
            
            if ($value['tipo']=='PA'){

                if ($nombre != $value['descripcion']) {

                    $campo = $value['evaluacion'];
                    $this->arrparcial[$linea]['linea'] = $linea+1;
                    $this->arrparcial[$linea]['codigo'] = $value['codigo'];
                    $this->arrparcial[$linea]['descripcion'] = $value['descripcion'];
                    foreach ($this->arrmetodo as $metodo){
                        $col = $metodo['codigo'];
                        $this->arrparcial[$linea][$col] = false;
                    }
                    $linea=$linea+1;
                }
                $nombre = $value['descripcion'];
            }
        };

        foreach ($this->arrparcial as $key => $value){
            foreach ($detalle as $data) {
                $campo = $data['evaluacion'];
                if ($data['tipo']=='PA' && $value['codigo']==$data['codigo'] && $campo!=''){
                    $this->arrparcial[$key][$campo] = true;
                } 
            }
        }

        $linea=1;
        foreach ($detalle as $key => $value) {
            if ($value['tipo']=='AC'){
                $recno=[
                    'linea' => $linea,
                    'codigo' => $value['codigo'],
                    'descripcion' => $value['descripcion'],
                ];
        
                array_push($this->arractividad,$recno);
                $linea = $linea+1;
            }
        }

        $linea=1;
        foreach ($detalle as $key => $value) {
            if ($value['tipo']=='EC'){
                $recno=[
                    'valor' => $value['codigo'],
                    'nota' => $value['nota'],
                    'descripcion' => $value['descripcion'],
                    'equivale' => $value['evaluacion'],
                ];
        
                array_push($this->arrescala,$recno);
            }
        }

    }


    public function updatedperiodoId()
    {   

        $this->loadData();
        
    }

    public function updatedmetodo()
    {   

        $this->addarr($this->metodo);
        
    }

    public function updatedModalidadId($id){

        $this->arrhora = TdPeriodoSistemaEducativos::query()
        ->where('periodo_id',$this->periodoId)
        ->where('tipo','HC')
        ->where('modalidad_id',$id)
        ->get();

    }

    public function addarr($ciclo)
    {
        $this->arrparcial=[];
        $this->arrmetodo=[];
        $this->arractividad=[];
        $this->arrescala=[];

        if ($ciclo=="Q"){
            $linea = 2;
        }
        if ($ciclo=="T"){
            $linea = 3;
        }
        
        for ($i = 0; $i < $linea; $i++) {
            
            $datos = [
                'linea' => $i+1,
                'codigo' => ($i+1).$ciclo,
                'descripcion' =>  $this->romano[$i+1].' '.$this->evaluacion[$ciclo],
            ];
            array_push($this->arrmetodo,$datos);
        }

        //Parcial
        for ($x=0;$x<=2;$x++) {

            $this->arrparcial[$x]['linea'] = $x+1;
            $this->arrparcial[$x]['codigo'] = ($x+1).'P';
            $this->arrparcial[$x]['descripcion'] = 'Parcial '.($x+1);
            foreach ($this->arrmetodo as $metodo){
                $col = $metodo['codigo'];
                $this->arrparcial[$x][$col] = false;
            }

        };

    }

    public function addline(){

        $recno = [];
        $linea = count($this->arractividad);
        $linea = $linea+1;

        $recno=[
            'linea' => $linea,
            'codigo' => '',
            'descripcion' => '',
        ];

        array_push($this->arractividad,$recno);
        
    }

    public function addescala(){

        $recno = [];
        $linea = count($this->arrescala);
        $linea = $linea+1;

        $recno=[
            'valor' => '',
            'nota' => '',
            'descripcion' => '',
            'equivale' => '',
        ];

        array_push($this->arrescala,$recno);
        
    }

    public function addhora(){

        $this->dispatchBrowserEvent('show-form');

    }

    public function grabaHora(){

       TdPeriodoSistemaEducativos::Create([
            'periodo_id' => $this->periodoId,
            'tipo' => 'HC',
            'codigo' => '',
            'evaluacion' => '',
            'descripcion' => '',
            'nota' => 0,
            'modalidad_id' => $this->modalidadId,
            'hora_ini' =>$this->hora_ini,
            'hora_fin' =>$this->hora_fin,
            'usuario' => auth()->user()->name,
        ]);

        $this->dispatchBrowserEvent('hide-form');
        return redirect(request()->header('Referer'));
    }

    public function createData(){


        $this ->validate([
            'periodoId' => 'required',
            'metodo' => 'required',
            'aperturado' => 'required',
            'eformativa' => 'required',
            'esumativa' => 'required',
        ]);


        $record = TmPeriodosLectivos::find($this->periodoId);
        $record->update([
            'evaluacion' => $this->metodo,
            'evaluacion_formativa' => $this->eformativa,
            'evaluacion_sumativa' => $this->esumativa,
            'aperturado' => $this->aperturado,
        ]);
        
        //Metodo
        foreach ($this->arrmetodo as $index => $data)
        {          
            $dataRow['periodo_id'] =  $this->periodoId;
            $dataRow['tipo'] =  'EA';
            $dataRow['codigo'] =  $data['codigo'];
            $dataRow['evaluacion'] =  '';
            $dataRow['descripcion'] =  $data['descripcion'];
            $dataRow['nota'] =  0;
            $dataRow['usuario'] = auth()->user()->name;
            array_push($this->detalle,$dataRow);
        }

        //Parcial
        foreach ($this->arrparcial as $index => $data)
        {   
            foreach ($this->arrmetodo as $metodo){

                $col = $metodo['codigo'];

                if ($data[$col]==false){
                    $col = '';
                }
                     
                $dataRow['periodo_id'] =  $this->periodoId;
                $dataRow['tipo'] =  'PA';
                $dataRow['codigo'] =  $data['codigo'];
                $dataRow['evaluacion'] =  $col;
                $dataRow['descripcion'] =  $data['descripcion'];
                $dataRow['nota'] =  0;
                $dataRow['usuario'] = auth()->user()->name;
                array_push($this->detalle,$dataRow);
            }
        
        }

        //Actividades
        foreach ($this->arractividad as $index => $data)
        {   
            $dataRow['periodo_id'] =  $this->periodoId;
            $dataRow['tipo'] =  'AC';
            $dataRow['codigo'] =  $data['codigo'];
            $dataRow['evaluacion'] =  '';
            $dataRow['descripcion'] =  $data['descripcion'];
            $dataRow['nota'] =  0;
            $dataRow['usuario'] = auth()->user()->name;
            array_push($this->detalle,$dataRow);
        }

        //Escala
        foreach ($this->arrescala as $index => $data)
        {   

            $dataRow['periodo_id'] =  $this->periodoId;
            $dataRow['tipo'] =  'EC';
            $dataRow['codigo'] =  $data['valor'];
            $dataRow['evaluacion'] =  $data['equivale'];
            $dataRow['descripcion'] =  $data['descripcion'];
            $dataRow['nota'] =  $data['nota'];
            $dataRow['usuario'] = auth()->user()->name;
            array_push($this->detalle,$dataRow);
        }

        TdPeriodoSistemaEducativos::where('periodo_id',$this->periodoId)->delete();
        TdPeriodoSistemaEducativos::insert($this->detalle);    
    
        
    } 


}
