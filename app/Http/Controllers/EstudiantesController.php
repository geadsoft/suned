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

    public function deliver_activity($id,$data)
    {      
        return view('student/entregar_actividad',[
            'id' => $id,
            'data' => $data,
        ]);
    }

    public function student_activities()
    {      
        return view('student/actividades');
    }

    public function student_resources()
    {      
        return view('student/recursos');
    }

    public function resources_view($id)
    {
        return view('teachers/recursosview',[
            'id' => $id,
            'action' => 'estudiante'
        ]);
    }

    public function assistance()
    {      
        return view('student/asistencias');
    }

    public function student_grades()
    {      
        return view('student/calificaciones');
    }

    public function note_activity()
    {      
        return view('student/calificaciones_actividades');
    }

    public function report_card()
    {      
        return view('student/boletin_calificaciones');
    }

    public function qualify_conduct()
    {      
        return view('student/evalua_conducta');
    }

    public function partial_bulletin()
    {      
        return view('student/boletin_calificaciones_parcial');
    }

    public function final_bulletin()
    {      
        return view('student/boletin_calificaciones_final');
    }

}
