<?php

namespace App\Http\Controllers;

use App\Models\PoinKategori;
use Illuminate\Http\Request;

class PoinKategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pelanggaran = PoinKategori::where('kategori', 'pelanggaran')->get();
        $budaya = PoinKategori::where('kategori', 'budaya_positif')->get();
        $prestasi = PoinKategori::where('kategori', 'prestasi')->get();
    
        return view('data_master.budaya_positif', compact('budaya',));
        return view('data_master.pelanggaran', compact('pelanggaran',));
        return view('data_master.prestasi', compact('prestasi',));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $pelanggaran = PoinKategori::create([
            'kategori' => 'pelanggaran',
            'nama_pelanggaran' => $request->nama_pelanggaran,
            'poin' => $request->poin,
        ]);

        $budaya = PoinKategori::create([
            'kategori' => 'budaya_positif',
            'nama_budaya' => $request->nama_budaya,
            'poin' => $request->poin,
        ]);

        $prestasi = PoinKategori::create([
            'kategori' => 'prestasi',
            'nama_prestasi' => $request->nama_prestasi,
            'poin' => $request->poin,
        ]);

        return redirect('/data_master')->with('success', 'Data Berhasil');
    }

    /**
     * Display the specified resource.
     */
    public function show(PoinKategori $poinKategori)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PoinKategori $poinKategori)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PoinKategori $poinKategori)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PoinKategori $poinKategori)
    {
        //
    }
}
