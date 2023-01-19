<?php

namespace App\Http\Livewire;
use App\Models\TrCobrosCabs;
use PDF;

use Livewire\Component;
use Livewire\WithPagination;

class VcReportDailyCharges extends Component
{
    use WithPagination;

    public $nombre, $fechaini, $fechafin;
    public $filters = [
        'srv_fechaini' => '',
        'srv_fechafin' => '',
        'srv_nombre' => '',
    ];

    public function mount(){
        
        $ldateini = date('Y-m-d H:i:s');
        $ldatefin = date('Y-m-d H:i:s');

        $this->filters['srv_fechaini'] = date('Y-m-d',strtotime($ldateini));
        $this->filters['srv_fechafin'] = date('Y-m-d',strtotime($ldatefin));
        $this->filters['srv_nombre'] = '';

    }

    public function render()
    {
        
        $tblrecords  = $this->consulta();

        return view('livewire.vc-report-daily-charges',[
            'tblrecords' => $tblrecords,
        ]);

    }

    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }

    public function consulta(){
           
        $tblrecords = TrCobrosCabs::query()
        ->join("tm_personas","tm_personas.id","=","tr_cobros_cabs.estudiante_id")
        ->when($this->filters['srv_nombre'],function($query){
            return $query->where('tm_personas.nombres','like','%'.$this->filters['srv_nombre'].'%')
                        ->orWhere('tm_personas.apellidos','like','%'.$this->filters['srv_nombre'].'%');
        })
        //->whereBetween('tr_cobros_cabs.fecha',["'".date('Ymd',strtotime($this->filters['srv_fechaini']))."'","'".date('Ymd',strtotime($this->filters['srv_fechafin']))."'"])
        ->where('tr_cobros_cabs.fecha','>=',date('Ymd',strtotime($this->filters['srv_fechaini'])))
        ->where('tr_cobros_cabs.fecha','<=',date('Ymd',strtotime($this->filters['srv_fechafin'])))
        ->select('tr_cobros_cabs.id','tr_cobros_cabs.fecha','tr_cobros_cabs.documento','tr_cobros_cabs.concepto','tr_cobros_cabs.monto','tr_cobros_cabs.estado','tr_cobros_cabs.usuario','tm_personas.nombres', 'tm_personas.apellidos')
        ->orderBy('tr_cobros_cabs.fecha','desc')
        ->paginate(15);
        
        return $tblrecords;

    }

}
