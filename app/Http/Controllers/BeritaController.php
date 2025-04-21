<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;

class BeritaController extends Controller
{
    public function index()
    {
        $berita = Berita::first();
        return view('berita.list', compact('berita'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'acara' => 'required|string',
            'pakaian' => 'required|in:batik,bebas,muslim,seragam,tidak ada'
        ]);
    
        $berita = Berita::first(); // ambil berita pertama (karena cuma 1)
    
        if ($berita) {
            $berita->update([
                'acara' => $request->acara,
                'pakaian' =>    $request->pakaian,
            ]);
        } else {
            Berita::create([
                'acara' => $request->acara,
                'pakaian' => $request->pakaian,
            ]);
        }
    
        return redirect()->back()->with('success', 'Data berhasil diperbarui.');
    }
    
}
