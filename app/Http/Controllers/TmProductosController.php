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
        return view('inventary/products-add');
    }

    public function edit()
    {
        return view('inventary/products-edit');
    }

    public function input()
    {
        return view('products/input');
    }

    public function output()
    {
        return view('products/output');
    }

    public function kardex()
    {
        return view('products/kardex');
    }
}
