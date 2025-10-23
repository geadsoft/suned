<?php

namespace App\Http\Livewire;
use App\Models\TrBuzon;
use Livewire\Component;
use Livewire\WithPagination;

class VcMailboxOpinions extends Component
{
    use WithPagination;
    public $display = "display: none";
    public $column  = "col-lg-12";
    public $mensaje = [];

    public function render()
    {
        
        $tblrecords = TrBuzon::paginate(15);
       
        return view('livewire.vc-mailbox-opinions',[
            'tblrecords' => $tblrecords
        ]);
    }

    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }

    public function verMensaje($id){

        $this->mensaje = TrBuzon::find($id);
       
        $this->display="";
        $this->column="col-lg-8";
       
    }

    public function Cerrar(){
       
        $this->display="display: none";
        $this->column="col-lg-12";
        $this->dispatchBrowserEvent('msj-cerrar');   

       
    }

    public function Eliminar($id){
       
        TrBuzon::find($id)->delete();
        $this->dispatchBrowserEvent('msj-delete');        
       
    }


}
