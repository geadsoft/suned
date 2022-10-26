<?php

namespace App\Http\Controllers;

use App\Models\TmCursos;
use Illuminate\Http\Request;

class TmCursosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('academic/course');
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
     * @param  \App\Models\TmCursos  $tmCursos
     * @return \Illuminate\Http\Response
     */
    public function show(TmCursos $tmCursos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TmCursos  $tmCursos
     * @return \Illuminate\Http\Response
     */
    public function edit(TmCursos $tmCursos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TmCursos  $tmCursos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TmCursos $tmCursos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TmCursos  $tmCursos
     * @return \Illuminate\Http\Response
     */
    public function destroy(TmCursos $tmCursos)
    {
        //
    }
}
