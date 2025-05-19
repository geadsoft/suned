<?php

namespace App\Http\Controllers;

use App\Models\TmSedes;
use Illuminate\Http\Request;

class TmSedesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sede/headquarters');
    }

    public function periodos()
    {
        return view('academic/periods');
    }

    public function calendario()
    {
        return view('academic/calendario');
    }

    public function calendario_view()
    {
        return view('academic/calendarioview');
    }

    public function system()
    {
        return view('academic/sistema');
    }

    public function pasecurso()
    {
        return view('academic/pasecurso');
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
     * @param  \App\Models\TmSedes  $tmSedes
     * @return \Illuminate\Http\Response
     */
    public function show(TmSedes $tmSedes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TmSedes  $tmSedes
     * @return \Illuminate\Http\Response
     */
    public function edit(TmSedes $tmSedes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TmSedes  $tmSedes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TmSedes $tmSedes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TmSedes  $tmSedes
     * @return \Illuminate\Http\Response
     */
    public function destroy(TmSedes $tmSedes)
    {
        //
    }
}
