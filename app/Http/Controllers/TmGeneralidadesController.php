<?php

namespace App\Http\Controllers;

use App\Models\TmGeneralidades;
use Illuminate\Http\Request;

class TmGeneralidadesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('config/generality');
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
     * @param  \App\Models\TmGeneralidades  $tmGeneralidades
     * @return \Illuminate\Http\Response
     */
    public function show(TmGeneralidades $tmGeneralidades)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TmGeneralidades  $tmGeneralidades
     * @return \Illuminate\Http\Response
     */
    public function edit(TmGeneralidades $tmGeneralidades)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TmGeneralidades  $tmGeneralidades
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TmGeneralidades $tmGeneralidades)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TmGeneralidades  $tmGeneralidades
     * @return \Illuminate\Http\Response
     */
    public function destroy(TmGeneralidades $tmGeneralidades)
    {
        //
    }
}
