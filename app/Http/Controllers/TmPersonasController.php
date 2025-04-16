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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TmPersonas  $tmPersonas
     * @return \Illuminate\Http\Response
     */
    public function show(TmPersonas $tmPersonas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TmPersonas  $tmPersonas
     * @return \Illuminate\Http\Response
     */
    public function edit(TmPersonas $tmPersonas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TmPersonas  $tmPersonas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TmPersonas $tmPersonas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TmPersonas  $tmPersonas
     * @return \Illuminate\Http\Response
     */
    public function destroy(TmPersonas $tmPersonas)
    {
        //
    }
}
