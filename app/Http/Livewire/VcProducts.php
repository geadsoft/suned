<?php

namespace App\Http\Livewire;

use App\Models\TmGeneralidades;
use App\Models\TmProductos;

use Livewire\Component;
use Livewire\WithPagination;

class VcProducts extends Component
{
    use WithPagination;
    public $productoId, $nombre, $record=[];

    public $tblcategorias=[];
    public $filters=[
        'tipo' => 'B',
        'categoria' => '',
        'estado' => 'A'
    ];

    public $unidad=[
        'UND'=>'Unidad',
    ];

    public $iva=[
        '0'=>'Tarifa 0%',
        '2'=>'Tarifa 12%',
        '2'=>'Tarifa 14%',
        '4'=>'Tarifa 15%',
        '5'=>'Tarifa 5%',
        '6'=>'No Objeto de Impuesto',
        '7'=>'Exento de IVA',
        '8'=>'IVA diferenciado',
        '10'=>'Tarifa 13%',
    ];

    public function mount()
    {
        $this->tblcategorias = TmGeneralidades::where('superior',11)->get();
    }
    
    public function render()
    {
        
        $tblrecords = TmProductos::query()
        ->when($this->filters['tipo'],function($query){
            return $query->where('tipo',"{$this->filters['tipo']}");
        })
        ->when($this->filters['categoria'],function($query){
            return $query->where('categoria_id',"{$this->filters['categoria']}");
        })
        ->when($this->filters['estado'],function($query){
            return $query->where('estado',"{$this->filters['estado']}");
        })
        ->paginate(12);

        return view('livewire.vc-products',[
            'tblrecords' => $tblrecords ,
            'tblcategorias' => $this->tblcategorias,
        ]);
    }

    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }

    public function edit($record)
    {
        $productoId = $record['id'];
        return redirect()->to('/inventary/products-edit/'.$productoId);
    }

    public function delete($id)
    {
        $this->record = TmProductos::find($id);
        $this->productoId = $this->record['id'];
        $this->nombre =  $this->record['nombre'];
        $this->dispatchBrowserEvent('show-delete');
    }

    public function deleteData(){
        
        $this->record->update([
            'estado' => 'I',
        ]);

        $this->dispatchBrowserEvent('hide-delete');
    }

}
