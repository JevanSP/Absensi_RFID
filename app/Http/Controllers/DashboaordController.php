<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboaordController extends Controller
{
    public function admin_guru()
    {
        return view('dashboard.list');
    }

    public function siswa()
    {
        return view('dashboard.siswa');
    }
}
