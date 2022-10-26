<?php

namespace App\Http\Controllers;

use App\Models\TmServicios;
use Illuminate\Http\Request;

class TmServiciosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sede/services');
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
     * @param  \App\Models\TmServices  $tmServices
     * @return \Illuminate\Http\Response
     */
    public function show(TmServices $tmServices)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TmServices  $tmServices
     * @return \Illuminate\Http\Response
     */
    public function edit(TmServices $tmServices)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TmServices  $tmServices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TmServices $tmServices)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TmServices  $tmServices
     * @return \Illuminate\Http\Response
     */
    public function destroy(TmServices $tmServices)
    {
        //
    }
}
