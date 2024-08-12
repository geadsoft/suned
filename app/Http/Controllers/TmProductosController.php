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
        return view('inventary/registers',['id' => 0]);
    }

    public function editregister($id)
    {
        return view('inventary/registers',['id' => $id]);
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
        return view('inventary/report',['tipo' => 'PRD']);
    }

    public function utilidad()
    {
        return view('inventary/utility');
    }

    public function productosVendidos()
    {
        return view('inventary/soldproducts');
    }

    public function details()
    {
        return view('inventary/report',['tipo' => 'DET']);
    }

}
