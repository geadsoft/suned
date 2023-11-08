<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TmCalificaciones extends Controller
{
    public function index()
    {
        return view('academic/ratings');
    }

    public function addCalificacion()
    {
        return view('academic/ratingsadd');
    }
}
