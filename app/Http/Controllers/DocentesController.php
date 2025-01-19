<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocentesController extends Controller
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

    //Actividades
    public function activity_index()
    {
        return view('teachers/actividades');
    }

    public function activity_add()
    {
        return view('teachers/actividadadd',['id' => 0]);
    }

    public function activity_edit($id)
    {
        return view('teachers/actividadadd',['id' => $id]);
    }

    public function activity_view($id)
    {
        return view('teachers/actividadview',['id' => $id]);
    }


    // Clases Virutales
    public function classes_index()
    {
        return view('teachers/clasevirtual');
    }


    //Actividades
    public function exams_index()
    {
        return view('teachers/examenes');
    }

    public function exams_add()
    {
        return view('teachers/examenadd',['id' => 0]);
    }

    public function exams_edit($id)
    {
        return view('teachers/examenadd',['id' => $id]);
    }

    public function exams_view($id)
    {
        return view('teachers/examenview',['id' => $id]);
    }

}
