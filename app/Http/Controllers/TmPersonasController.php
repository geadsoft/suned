<?php

namespace App\Http\Controllers;

use App\Models\TmPersonas;
use Illuminate\Http\Request;

class TmPersonasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('academic/person');
    }

    public function addperson()
    {
        return view('academic/personadd');
    }

    public function editperson($identificacion)
    {
        return view('academic/personadd',['id' => $identificacion]);
    }

    public function agent()
    {
        return view('academic/agent');
    }

    public function personal()
    {
        return view('/sede/personal');
    }

    public function addpersonal()
    {
        return view('/sede/personaladd',['id' => 0]);
    }

    public function editpersonal($personaId)
    {
        return view('/sede/personaladd',['id' => $personaId]);
    }

    public function perfil()
    {
        return view('/config/perfil');
    }

    public function retirar($personaId)
    {
        return view('/teachers/retirar-docente',['id' => $personaId]);
    }
    
}
