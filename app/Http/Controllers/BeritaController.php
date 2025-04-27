<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class BeritaController extends Controller
{
    public function index()
    {
        $today = Carbon::now()->toDateString();
        $lastUpdate = Cache::get('last_berita_update');
        
        $berita = Berita::first();

        if ($berita) {
            if ($today > $lastUpdate) {
                $berita->update([
                    'acara' => '-',
                    'pakaian' => 'tidak ada',
                ]);
                Cache::put('last_berita_update', $today, now()->addDay());
            }
        }

        return view('berita.list', compact('berita'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'acara' => 'required|string',
            'pakaian' => 'required|in:batik,bebas,muslim,seragam,tidak ada'
        ]);
    
        $today = Carbon::now()->toDateString();
        $lastUpdate = Cache::get('last_berita_update');
    
        $berita = Berita::first();
    
        if ($berita) {
            if ($today > $lastUpdate) {
                $berita->update([
                    'acara' => '-',
                    'pakaian' => 'tidak ada',
                ]);
                Cache::put('last_berita_update', $today, now()->addDay());
            } else {
                $berita->update([
                    'acara' => $request->acara,
                    'pakaian' => $request->pakaian,
                ]);
            }
        } else {
            Berita::create([
                'acara' => $request->acara,
                'pakaian' => $request->pakaian,
            ]);
            Cache::put('last_berita_update', $today, now()->addDay());
        }
    
        return redirect()->back()->with('success', 'Data berhasil diperbarui.');
    }
}
