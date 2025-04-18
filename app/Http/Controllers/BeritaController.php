<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;

class BeritaController extends Controller
{
    public function index()
    {
        return view('berita.list');
    }


    public function store(Request $request)
    {
        $request->validate([
            'acara' => 'required|string',
            'pakaian' => 'required|string',
        ]);
        Berita::updateOrCreate(
            ['id' => 1], // Assuming you want to update the first record
            [
                'acara' => $request->acara,
                'pakaian' => $request->pakaian,
            ]
        );
        return redirect()->back()->with('success', 'Data berhasil diperbarui.');
    }
}
