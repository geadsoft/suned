<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EstudiantesController extends Controller
{

    public function subject()
    {      
        return view('student/asignaturas');
    }

    public function subject_view($data)
    {      
        return view('student/asignaturasview',['data' => $data]);
    }

    public function school_schedule()
    {      
        return view('student/horarios');
    }

}
