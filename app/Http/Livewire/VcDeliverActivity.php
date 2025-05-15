<?php

namespace App\Http\Livewire;
use App\Models\TmActividades;

use Livewire\Component;

class VcDeliverActivity extends Component
{
    public $selectId, $record, $display_estado="", $display_text="display:none";
    public $data;
    public $array_attach=[];

    public $arrdoc = [
        'doc' => 'ri-file-word-2-line',
        'docx' => 'ri-file-word-2-line',
        'xls' => 'ri-file-excel-2-line',
        'xlsx' => 'ri-file-excel-2-line',
        'ppt' => ' ri-file-ppt-2-line',
        'pptx' => ' ri-file-ppt-2-line',
        'pdf' => ' ri-file-pdf-line',
    ];

    public $arrcolor = [  
        'doc' => 'text-primary',
        'docx' => 'text-primary',
        'xls' => 'text-success',
        'xlsx' => 'text-success',
        'ppt' => ' text-danger',
        'pptx' => 'text-danger',
        'pdf' => 'text-danger',
    ];

    private function token(){

        $client_id = \Config('services.google.client_id');
        $client_secret = \Config('services.google.client_secret');
        $refresh_token = \Config('services.google.refresh_token');
        $response = Http::post('https://oauth2.googleapis.com/token',[
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'refresh_token' => $refresh_token,
            'grant_type' => 'refresh_token'
        ]);

        $accessToken = json_decode((string)$response->getBody(),true)['access_token'];
        return $accessToken;
    }
    
    public function mount($id){

        $this->selectId = $id;
        $this->load();
        $this->attach_add();
    }
    
    public function render()
    {
        return view('livewire.vc-deliver-activity');

        //$message = "Registro grabado con éxito!";
        //$this->dispatchBrowserEvent('msg-grabar', ['newName' => $message]);
    }

    public function load(){

        $this->record = TmActividades::find($this->selectId);
        $this->texteditor = "";
        $this->data = json_encode($this->record['descripcion']);

    }

    public function entrega(){
        
        $this->display_estado="display:none";
       
        $message = json_decode($this->data);
        $this->dispatchBrowserEvent('entrega', ['newName' => $message]);
    }

    public function attach_add()
    {
        $linea = count($this->array_attach);
        $linea = $linea+1;

        $attach=[
            'id' => 0,
            'linea' => $linea,
            'adjunto' => "",
            'drive_id' => "",
        ];

        array_push($this->array_attach,$attach);
        
    }


    public function attach_del($linea){

        $recnoToDelete = $this->array_attach;
        foreach ($recnoToDelete as $index => $recno)
        {
            if ($recno['linea'] == $linea){
                unset ($recnoToDelete[$index]);
            } 
        }

        $this->reset(['array_attach']);
        $this->array_attach = $recnoToDelete;
    
    }
    
}
