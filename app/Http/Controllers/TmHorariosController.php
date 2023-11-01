<?php

namespace App\Http\Controllers;

use App\Models\TmHorarios;
use Illuminate\Http\Request;

class TmHorariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sede/horarios');
    }

    public function addhorarios()
    {
        return view('sede/horariosadd',['id' => 0]);
    }

    public function edithorarios($id)
    {
        return view('sede/horariosadd',['id' => $id]);
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
     * @param  \App\Models\TmHorarios  $tmHorarios
     * @return \Illuminate\Http\Response
     */
    public function show(TmHorarios $tmHorarios)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TmHorarios  $tmHorarios
     * @return \Illuminate\Http\Response
     */
    public function edit(TmHorarios $tmHorarios)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TmHorarios  $tmHorarios
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TmHorarios $tmHorarios)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TmHorarios  $tmHorarios
     * @return \Illuminate\Http\Response
     */
    public function destroy(TmHorarios $tmHorarios)
    {
        //
    }
}
