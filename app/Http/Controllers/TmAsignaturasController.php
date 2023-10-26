<?php

namespace App\Http\Controllers;

use App\Models\TmAsignaturas;
use Illuminate\Http\Request;

class TmAsignaturasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sede/asignaturas');
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
     * @param  \App\Models\TmAsignaturas  $tmAsignaturas
     * @return \Illuminate\Http\Response
     */
    public function show(TmAsignaturas $tmAsignaturas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TmAsignaturas  $tmAsignaturas
     * @return \Illuminate\Http\Response
     */
    public function edit(TmAsignaturas $tmAsignaturas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TmAsignaturas  $tmAsignaturas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TmAsignaturas $tmAsignaturas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TmAsignaturas  $tmAsignaturas
     * @return \Illuminate\Http\Response
     */
    public function destroy(TmAsignaturas $tmAsignaturas)
    {
        //
    }
}
