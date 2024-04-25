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

    public function edit()
    {
        return view('inventary/products-edit');
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
        return view('products/kardex');
    }
}
