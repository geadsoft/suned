<?php

namespace App\Http\Controllers;

use App\Models\TrFacturasCabs;
use Illuminate\Http\Request;

class TrFacturasCabsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('/financial/createinvoice');
    }

    public function documents($tipo)
    {
        return view('/financial/docelectronics',['tipo' => $tipo]);
    }

    public function ncredits()
    {
        return view('/financial/createcredits');
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
     * @param  \App\Models\TrFacturasCabs  $trFacturasCabs
     * @return \Illuminate\Http\Response
     */
    public function show(TrFacturasCabs $trFacturasCabs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TrFacturasCabs  $trFacturasCabs
     * @return \Illuminate\Http\Response
     */
    public function edit(TrFacturasCabs $trFacturasCabs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TrFacturasCabs  $trFacturasCabs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TrFacturasCabs $trFacturasCabs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TrFacturasCabs  $trFacturasCabs
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrFacturasCabs $trFacturasCabs)
    {
        //
    }
}
