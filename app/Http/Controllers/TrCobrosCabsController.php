<?php

namespace App\Http\Controllers;

use App\Models\TrCobrosCabs;
use Illuminate\Http\Request;

class TrCobrosCabsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('/financial/encashment');
    }

    public function addencashment()
    {
        return view('financial/encashmentadd');
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
     * @param  \App\Models\TrCobrosCabs  $trCobrosCabs
     * @return \Illuminate\Http\Response
     */
    public function show(TrCobrosCabs $trCobrosCabs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TrCobrosCabs  $trCobrosCabs
     * @return \Illuminate\Http\Response
     */
    public function edit(TrCobrosCabs $trCobrosCabs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TrCobrosCabs  $trCobrosCabs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TrCobrosCabs $trCobrosCabs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TrCobrosCabs  $trCobrosCabs
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrCobrosCabs $trCobrosCabs)
    {
        //
    }
}
