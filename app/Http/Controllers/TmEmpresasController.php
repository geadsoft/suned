<?php

namespace App\Http\Controllers;

use App\Models\TmEmpresas;
use Illuminate\Http\Request;

class TmEmpresasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('config/company');
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
     * @param  \App\Models\TmCompanies  $tmCompanies
     * @return \Illuminate\Http\Response
     */
    public function show(TmCompanies $tmCompanies)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TmCompanies  $tmCompanies
     * @return \Illuminate\Http\Response
     */
    public function edit(TmCompanies $tmCompanies)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TmCompanies  $tmCompanies
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TmCompanies $tmCompanies)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TmCompanies  $tmCompanies
     * @return \Illuminate\Http\Response
     */
    public function destroy(TmCompanies $tmCompanies)
    {
        //
    }
}
