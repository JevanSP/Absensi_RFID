<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function index()
    {
        return view('layout.layout');
    }

    public function dashboard()
    {
        return view('dashboard');
    }
}
