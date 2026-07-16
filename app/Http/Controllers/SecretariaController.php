<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SecretariaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function certificados()
    {
        return view('secretary/certificados');
    }

    public function documentos()
    {
        return view('secretary/documentacion');
    }

    public function registrar_documentos()
    {
        return view('secretary/registrar_documentacion');
    }

    public function recepcion_documentos()
    {
        return view('secretary/recepcion_documentacion');
    }

    public function retirar_documentos()
    {
        return view('secretary/retirar_documentacion');
    }

    public function ratings()
    {
        return view('secretary/calificacion');
    }

    public function reportCas()
    {
        return view('secretary/reportecas');
    }

    public function titlesFile()
    {
        return view('secretary/titulosactas');
    }

    public function requests()
    {
        return view('secretary/solicitudes');
    }

    public function promotion()
    {
        return view('secretary/promocion');
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
