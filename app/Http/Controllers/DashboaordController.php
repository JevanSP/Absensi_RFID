<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PoinSiswa;
use Illuminate\Support\Facades\Auth;

class DashboaordController extends Controller
{
    public function admin_guru()
    {
        return view('dashboard.list');
    }

    public function siswa()
    {
        $total_poin = PoinSiswa::where('siswa_id', Auth::id())->sum('poin');
        return view('dashboard.siswa');
    }
}
