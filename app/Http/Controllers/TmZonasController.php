<?php

namespace App\Http\Controllers;

use App\Models\TmZonas;
use Illuminate\Http\Request;

class TmZonasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('config/zone');
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
     * @param  \App\Models\TmZonas  $tmZonas
     * @return \Illuminate\Http\Response
     */
    public function show(TmZonas $tmZonas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TmZonas  $tmZonas
     * @return \Illuminate\Http\Response
     */
    public function edit(TmZonas $tmZonas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TmZonas  $tmZonas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TmZonas $tmZonas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TmZonas  $tmZonas
     * @return \Illuminate\Http\Response
     */
    public function destroy(TmZonas $tmZonas)
    {
        //
    }
}
