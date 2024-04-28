<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\TmGeneralidades;
use App\Models\TmProductos;

class VcProductsAdd extends Component
{
    public $fileimg, $foto, $stock, $productoId;
    public $codigo, $nombre, $descripcion="", $unidad='UND', $talla, $tipoiva="0", $stockmin, $precio, $tipo="B", $categoria=0, $estado='A', $controlastock=true;
    public $tblcategorias=[], $record=[];
    public $arrtalla=[
        '28'=>28,
        '30'=>30,
        '32'=>32,
        '34'=>34,
        '36'=>36,
        '38'=>38,
        '40'=>40,
        '42'=>42,
        '44'=>44,
        '46'=>46,
        '48'=>48,
        '50'=>50,
    ];
    
    public function mount($id)
    {
        $this->tblcategorias = TmGeneralidades::where('superior',11)->get();
        $this->productoId = $id;
        
        if ($id>0){

            $this->edit($id);

        }

    }

    public function render()
    {
        return view('livewire.vc-products-add',[
            'record' => $this->record,
            'tblcategorias' => $this->tblcategorias,
        ]);
    }

    public function add(){
        
        $this->record = new TmProductos;
        $this->record->unidad = 'UND';
        $this->record->tipo = 'B';
        $this->record->tipo_iva = 0;
        $this->record->maneja_stock = true;
        $this->record->precio = 0.00;
        $this->record->estado = 'A';

    }

    public function edit($id){
        
        $record = TmProductos::find($id);
        $this->codigo = $record['codigo'];
        $this->nombre = $record['nombre'];
        $this->descripcion = $record['descripcion'];
        $this->unidad = $record['unidad'];
        $this->talla = $record['talla'];
        $this->categoria = $record['categoria_id'];
        $this->tipo = $record['tipo'];
        $this->tipoiva = $record['tipo_iva'];
        $this->controlastock = $record['maneja_stock'];
        $this->stockmin = $record['stock_min'];
        $this->precio = $record['precio'];
        $this->stock = $record['stock'];
        $this->estado = $record['estado'];
        

    }


    public function createData(){

        $this ->validate([
            'nombre' => 'required',
            'unidad' => 'required',
            'categoria' => 'required',
            'tipo' => 'required',
            'tipoiva' => 'required',
            'controlastock' => 'required',
            'precio' => 'required',
        ]);

        if ($this->productoId>0){

            $this->updateData();            

        }else {

            $secuencia = 1;
            $categoria = TmGeneralidades::find($this->categoria);

            $productos = TmProductos::where('categoria_id',$categoria['id'])
            ->where('talla',$this->talla)
            ->orderby('codigo','desc')
            ->first();

            if (!empty($productos)){
                $secuencia = intval(substr($productos['documento'], -4));
                $secuencia = $secuencia+1;
            }

            $this->codigo = $categoria['codigo'].$this->talla.str_pad($secuencia, 4, "0", STR_PAD_LEFT); 
            
            TmProductos::Create([
                'codigo' => $this->codigo,
                'nombre' => $this->nombre,
                'descripcion' => $this->descripcion,
                'unidad' => $this->unidad,
                'talla' => $this->talla,
                'categoria_id' => $this->categoria,
                'tipo' => $this->tipo,
                'tipo_iva' => $this->tipoiva,
                'maneja_stock' => $this->controlastock,
                'stock_min' => $this->stockmin,
                'precio' => $this->precio,
                'foto' => '',
                'estado' => $this->estado,
                'usuario' => auth()->user()->name,
            ]);

            $message = "Registro grabado con éxito!";
            $this->dispatchBrowserEvent('msg-grabar', ['newName' => $message]);

            return redirect()->to('/inventary/products');
        }
        
    }

    public function updateData(){

        $record = TmProductos::find($this->productoId);
        $record->update([
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'unidad' => $this->unidad,
            'tipo' => $this->tipo,
            'tipo_iva' => $this->tipoiva,
            'maneja_stock' => $this->controlastock,
            'stock_min' => $this->stockmin,
            'precio' => $this->precio,
            'estado' => $this->estado,

        ]);

        $message = "Registro modificado con éxito!";
        $this->dispatchBrowserEvent('msg-grabar', ['newName' => $message]);

        return redirect()->to('/inventary/products');

    }



}
