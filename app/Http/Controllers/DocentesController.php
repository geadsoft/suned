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
        return view('auth.auth-signin-cover');
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

    public function classes_join()
    {
        return view('teachers/unirsevirtual');
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

    public function suppletory_index()
    {
        return view('teachers/supletorios');
    }

    public function suppletory_add()
    {
        return view('teachers/supletorioadd',['id' => 0]);
    }

    public function suppletory_edit($id)
    {
        return view('teachers/supletorioadd',['id' => $id]);
    }

    public function suppletory_view($id)
    {
        return view('teachers/supletorioview',['id' => $id]);
    }

    //Cursos Asignados
    public function courses_index()
    {
        return view('teachers/cursos');
    }

    public function courses_view($id)
    {
        return view('teachers/cursosview',['id' => $id]);
    }

    //Calificacion
    public function calificar_actividad()
    {
        return view('teachers/calificaractividad');
    }

    public function calificar_examen()
    {
        return view('teachers/calificarexamen');
    }

    public function calificar_supletorio()
    {
        return view('teachers/calificarsupletorio');
    }

    public function calificacion_total()
    {
        return view('teachers/calificacion_total');
    }

    public function calificacion_detallada()
    {
        return view('teachers/calificacion_detallada');
    }

    public function calificacion_examen()
    {
        return view('teachers/calificacion_examen');
    }

    public function informe_parcial()
    {
        return view('teachers/informe_parcial');
    }

    public function informe_trimestral()
    {
        return view('teachers/informe_trimestral');
    }

    public function asistencia_diaria()
    {
        return view('teachers/asistencia_diaria');
    }

    public function justificar_faltas()
    {
        return view('teachers/justificar_faltas');
    } 
    
    public function estudiantes()
    {
        return view('teachers/estudiantes');
    } 

    public function calendario_view()
    {
        return view('/academic/calendarioview');
    } 
    
    public function resources()
    {
        return view('/teachers/recursos');
    } 

    public function resources_add()
    {
        return view('/teachers/recursosadd',[
            'id' => 0,
            'action' => 'add'
        ]);
    } 

    public function resources_edit($id)
    {
        return view('teachers/recursosadd',[
            'id' => $id,
            'action' => 'edit'
        ]);
    }

    public function resources_view($id)
    {
        return view('teachers/recursosview',[
            'id' => $id,
            'action' => 'view'
        ]);
    }

}
