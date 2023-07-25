<?php

namespace App\Http\Livewire;
use App\Models\TmGeneralidades;
use Livewire\Component;
use Livewire\WithPagination;


class VcGeneralities extends Component
{
    use WithPagination;

    public $showEditModal = false;
    public $selectId;
    public $record=[];
    public $codigo;

    public $sortDirection = 'desc';
    public $sortData = 'codigo';
    public $superior = 0;
    public $ultcod = 0;

    public function render()
    {
        $tblrecords = TmGeneralidades::orderBy('root', 'asc')->paginate(10);        
        return view('livewire.vc-generalities',['tblrecords' => $tblrecords]);
    }

    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }

    /* Accion */

    public function add(){
        
        $this->showEditModal = false;
        $this->reset(['record']);
        $this->record['codigo']= 0;
        $this->record['descripcion']= '';
        $this->record['superior']= 0;
        $this->record['estado']= 'A'; 
        $this->record['root']= '';       
        $this->dispatchBrowserEvent('show-form');

    }

    public function edit(TmGeneralidades $tblrecords ){
        
        $this->showEditModal = true;
        $this->record  = $tblrecords->toArray();
       
        $this->selectId = $this -> record['id'];
        $this->dispatchBrowserEvent('show-form');

    }

    public function delete( $id ){
        
 
        $this->selectId = $id;
        $this->dispatchBrowserEvent('show-delete');

    }


    /* Procesos */

    public function createData(){
        
        $this->setCodigo();

        $this ->validate([
            'record.descripcion' => 'required',
            'record.codigo' => 'required',
            'record.superior' => 'required',
        ]);

        TmGeneralidades::Create([
            'codigo' => $this -> codigo,
            'descripcion' => $this -> record['descripcion'],
            'superior' => $this -> superior,
            'estado' => $this -> record['estado'],
            'root' => $this -> record['root'],
            'usuario' => auth()->user()->name,
        ]);

        $this->dispatchBrowserEvent('hide-form', ['message'=> 'added successfully!']);  
        
    }

    public function updateData(){

        $this ->validate([
            'record.id' => 'required',
            'record.codigo' => 'required',
            'record.descripcion' => 'required',
            'record.superior' => 'required',
            'record.estado'=> 'required',
            'record.root' => 'required',            
        ]);
        
        
        if ($this->selectId){
            $record = TmGeneralidades::find($this->selectId);
            $record->update([
                'descripcion' => $this -> record['descripcion'],
                'estado' => $this -> record['estado'],
            ]);
            
        }
      
        $this->dispatchBrowserEvent('hide-form', ['message'=> 'added successfully!']);
        
    }

    public function deleteData(){
        TmGeneralidades::find($this->selectId)->delete();
        $this->dispatchBrowserEvent('hide-delete');
    }
   
    public function setCodigo(){
        
        $this->superior = $this -> record['superior'];

        if ($this->superior==0){
            
            $this->ultcod = TmGeneralidades::where('superior',0)->orderBy($this->sortData,$this->sortDirection)->first();
            
            if ($this->ultcod==null){
                $this->codigo = 1;  
            } else {  
                $this->codigo = $this->ultcod['codigo']+1;
            }    
                        
        } else {
        
            $this->ultcod = TmGeneralidades::where('superior',$this->superior)->orderBy($this->sortData,$this->sortDirection)->first();

            if ($this->ultcod==null){
                $this->codigo = ($this->superior*100)+1;
            } else {  
                $this->codigo = $this->ultcod['codigo']+1;
            }
            
        }

        $sizevar = strlen($this->codigo);
        $cont=1;
        $root=""; 
        
        while ($cont<=($sizevar)){
            $root = $root.substr(strval($this->codigo),0,$cont).'/';
            $cont = $cont+2;
        }
        
        $this->record['codigo']= $this->codigo;
        $this->record['root']= $root;
 
    }

}
