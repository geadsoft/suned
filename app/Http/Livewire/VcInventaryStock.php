<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\TmGeneralidades;
use App\Models\TrInventarioDets;

class VcInventaryStock extends Component
{
    public $detalle = [];
    public $tblcategorias=[];
    public $filters=[
        'fechaini' => '',
        'fechafin' => '',
    ];

       public $movimiento=[
        1 => ['codigo' => 'SA', 'nombre' => 'Saldo Anterior', 'valor' => '1'], 
        2 => ['codigo' => 'II', 'nombre' => '(+)Inventario Inicial', 'valor' => '1'], 
        3 => ['codigo' => 'CL', 'nombre' => '(+)Compras Locales', 'valor' => '1'], 
        4 => ['codigo' => 'IA', 'nombre' => '(+)Ingreso por Ajuste', 'valor' => '1'], 
        5 => ['codigo' => 'DI', 'nombre' => '(-)Devolución por Compra', 'valor' => '1'], 
        6 => ['codigo' => 'VE', 'nombre' => '(-)Venta', 'valor' => '1'], 
        7 => ['codigo' => 'EG', 'nombre' => '(-)Egreso por Ajuste', 'valor' => '1'], 
        8 => ['codigo' => 'DE', 'nombre' => '(+)Devolución por Venta', 'valor' => '1'],
        9 => ['codigo' => 'ED', 'nombre' => 'Stock Disponible', 'valor' => '0'],
    ];

    public function mount()
    {
        $this->tblcategorias = TmGeneralidades::where('superior',11)->get();
        $this->load();

        $ldate = date('Y-m-d H:i:s');
        $ldate = date('Y',strtotime($ldate)).'-'.date('m',strtotime($ldate)).'-01';
       
        $fechaini = date('Y-m-d',strtotime($ldate));

        $ldate = date('Y-m-d H:i:s');
        $fechafin = date('Y-m-d',strtotime($ldate));

        $this->filters['fechaini'] = $fechaini;
        $this->filters['fechafin'] = $fechafin;   
    
    }

    public function render()
    {
        $this->consulta();
        return view('livewire.vc-inventary-stock');
    }

    public function load()
    {

        foreach ($this->tblcategorias as $key => $recno){
            $array=[];
            $array['codigo']=$recno['id'];
            $array['nombre']=$recno['descripcion'];
            $arrdet=[];

            foreach ($this->movimiento as $mov){
                $arrtalla = $this->newarray();
                $arrtalla['nombre'] = $mov['nombre'];
                $arrdet[$mov['codigo']] = $arrtalla;
            }
            
            $array['data']=$arrdet;
            $this->detalle[$recno['id']] = $array;    
        }

    }

    public function consulta(){

        /* Saldo Anterior */
        $invtra = TrInventarioDets::query()
        ->join("tm_productos as p","p.id","=","tr_inventario_dets.producto_id")
        ->join("tm_generalidades as g","g.id","=","p.categoria_id")
        ->when($this->filters['fechaini'],function($query){
            return $query->where('tr_inventario_dets.fecha','<',"{$this->filters['fechaini']}");
        })
        ->selectRaw('sum(cantidad) as cantidad, g.id, talla, "SA" as mov')
        ->groupBy('g.id','talla')
        ->get()->toArray();

        foreach($invtra as $data){
            
            $cat = $data['id'];
            $mov = $data['mov'];
            $talla = $data['talla'];
            $valor = $data['cantidad'];

            $this->detalle[$cat]['data'][$mov][$talla] = $valor ;
        }

        /* Movimientos */
        $invtra = TrInventarioDets::query()
        ->join("tm_productos as p","p.id","=","tr_inventario_dets.producto_id")
        ->join("tm_generalidades as g","g.id","=","p.categoria_id")
        /*->when($this->filters['fechaini'],function($query){
            return $query->where('tr_inventario_dets.fecha','>=',"{$this->filters['fechaini']}");
        })
        ->when($this->filters['fechafin'],function($query){
            return $query->where('tr_inventario_dets.fecha','<=',"{$this->filters['fechafin']}");
        })*/
        ->where('tr_inventario_dets.fecha','>=',date('Ymd',strtotime($this->filters['fechaini'])))
        ->where('tr_inventario_dets.fecha','<=',date('Ymd',strtotime($this->filters['fechafin'])))
        ->selectRaw('sum(cantidad) as cantidad, g.id, talla, tr_inventario_dets.movimiento as mov')
        ->groupBy('g.id','talla','mov')
        ->get();
    


        foreach($invtra as $data){
            
            $cat = $data['id'];
            $mov = $data['mov'];
            $talla = $data['talla'];
            $valor = $data['cantidad'];

            $this->detalle[$cat]['data'][$mov][$talla] = $valor ;
        }
        
        /* Stock */
        foreach ($this->detalle as $cat => $record){

            $i     = 28;
            $stock = 0;
            while ($i <= 50):
                $stock = 0; 
                $val = 0;               
                foreach ($this->movimiento as $data){
                    $val  = $this->detalle[$cat]['data'][$mov][$i];
                    $stock  = $stock + ($val*intval($data['valor']));   
                }                
                $this->detalle[$cat]['data']['ED'][$i] = $stock;
                $i=$i+2; 
            endwhile; 
        }
        
        /* Totales */
        foreach ($this->detalle as $cat => $record){
            
            foreach ($this->movimiento as $data){
                $mov  = $data['codigo'];
                $cant = 0; 

                if($cat==110){
                    $cant = $cant + $this->detalle[$cat]['data'][$mov][0];
                }else{

                    $i = 28;
                    while ($i <= 50):
                        $cant = $cant + $this->detalle[$cat]['data'][$mov][$i];
                        $i=$i+2;
                    endwhile;

                }
                $this->detalle[$cat]['data'][$mov]['total'] = $cant;               
            }
                
        }

    }

    public function newarray(){
        
        $arrtalla=[
            'codigo' =>'',
            'nombre'=>'',
            '0'=>'0',
            '28'=>0,
            '30'=>0,
            '32'=>0,
            '34'=>0,
            '36'=>0,
            '38'=>0,
            '40'=>0,
            '42'=>0,
            '44'=>0,
            '46'=>0,
            '48'=>0,
            '50'=>0,
            'total' => 0,
        ];
        return $arrtalla;
    }



}
