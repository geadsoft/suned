<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TmProductosController extends Controller
{
    public function index()
    {
        return view('inventary/products');
    }

    public function add()
    {
        return view('inventary/productsadd',['id' => 0]);
    }

    public function edit($id)
    {
        return view('inventary/productsadd',['id' => $id]);
    }

    public function register()
    {
        return view('inventary/registers');
    }

    public function movements()
    {
        return view('inventary/movements');
    }

    public function kardex()
    {
        return view('inventary/kardex');
    }

    public function stock()
    {
        return view('inventary/stocks');
    }

    public function report()
    {
        return view('inventary/report');
    }

}
