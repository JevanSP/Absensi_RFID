<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;
use Illuminate\Http\Request;

class PartialController extends Controller
{
    public function header_admin_guru()
    {
        $user = Auth::user();
        if (!$user || ($user->ruole !== 'admin' && $user->role !== 'guru')) {
            abort(403, 'Unauthorized action.');
        }
        return view('partials.header', compact('user'));
    }

    public function header_siswa()
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'siswa') {
            abort(403, 'Unauthorized action.');
        }
        $siswa = Siswa::where('id', $user->siswa_id)->first();
        return view('partials.header_siswa', compact('user', 'siswa'));
    }
}
