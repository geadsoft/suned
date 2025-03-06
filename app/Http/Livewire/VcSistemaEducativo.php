<?php

namespace App\Http\Livewire;
use App\Models\TmPeriodosLectivos;

use Livewire\Component;

class VcSistemaEducativo extends Component
{
    public $periodo, $plectivo, $metodo;
    public $arrmetodo=[];
    public $arrparcial=[];
    public $arractividad=[];

    public function mount()
    {
        $this->plectivo = TmPeriodosLectivos::where('estado','<>','C')->get();
        
        $this->periodo = 'T';
        $this->addarr($this->periodo);
    }

    public function render()
    {
        return view('livewire.vc-sistema-educativo',[
            'arrmetodo' => $this->arrmetodo,
            'arrparcial' => $this->arrparcial,
            'arractividad' => $this->arractividad,
        ]);
    }


    public function updatedmetodo()
    {
        $this->addarr($this->metodo);
    }

    public function addarr($ciclo)
    {
        $this->arrparcial=[];

        if ($ciclo=="Q"){

            $this->arrmetodo=[
                0 =>  [
                    'linea' => 1,
                    'descripcion' => '1er Quimestre',
                ],
                1 =>  [
                    'linea' => 2,
                    'descripcion' => '2do Quimestre',
                ],
            ];

        }else{

            $this->arrmetodo=[
                0 =>  [
                    'linea' => 1,
                    'descripcion' => '1er Trimestre',
                ],
                1 =>  [
                    'linea' => 2,
                    'descripcion' => '2do Trimestre',
                ],
                2 =>  [
                    'linea' => 3,
                    'descripcion' => '3er Trimestre',
                ],
            ];

        }

        //Parcial
        for ($x=0;$x<=2;$x++) {
            $array = [
                'linea' =>  $x+1,
                'descripcion' => 'Parcial '.$x+1,
                '1er' => false,
                '2do' => false,
                '3er' => false,
            ];
            array_push($this->arrparcial, $array);
        };

    }

    public function addline(){

        $linea = count($this->arractividad);
        $linea = $linea+1;

        $recno=[
            'linea' => $linea,
            'descripcion' => '',
        ];

        array_push($this->arractividad,$recno);
        
    
    }



}
