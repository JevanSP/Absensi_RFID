<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BeritaController extends Controller
{
    public function index()
    {
        if (!Cache::has('berita_reset')) {
            session()->forget('berita');
            Cache::put('berita_reset', true, now()->endOfDay());
        }

        session()->put('berita', array_merge([
            'acara' => null,
            'pakaian' => ['Baju Batik', 'Baju Bebas', 'Baju Muslim', 'Belum Ditentukan'],
        ], session('berita', [])));

        return view('berita.list');
    }

    public function update(Request $request)
    {
        $request->validate([
            'acara' => 'nullable|string|max:255',
            'pakaian' => 'nullable|array',
            'pakaian.*' => 'string|max:255',
        ]);

        session()->put('berita.acara', $request->input('acara'));
        session()->put('berita.pakaian', $request->input('pakaian', []));
        return redirect()->back()->with('success', 'Data berhasil diperbarui.');
    }
}
