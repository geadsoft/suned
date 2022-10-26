<?php

namespace App\Http\Controllers;

use App\Models\TmMatricula;
use Illuminate\Http\Request;

class TmMatriculaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('academic/registration');
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
     * @param  \App\Models\TmMatricula  $tmMatriculaEstudiante
     * @return \Illuminate\Http\Response
     */
    public function show(TmMatricula $tmMatricula)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TmMatricula  $tmMatriculaEstudiante
     * @return \Illuminate\Http\Response
     */
    public function edit(TmMatricula $tmMatricula)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TmMatricula  $tmMatriculaEstudiante
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TmMatricula $tmMatricula)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TmMatricula $tmMatriculaEstudiante
     * @return \Illuminate\Http\Response
     */
    public function destroy(TmMatricula $tmMatricula)
    {
        //
    }
}
