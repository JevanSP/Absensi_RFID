<?php

namespace App\Http\Controllers;

use App\Models\PoinKategori;
use Illuminate\Http\Request;

class PoinKategoriController extends Controller
{
    /**
     * Display a listing of the resource by category.
     */
    public function indexByCategory($category)
    {
        $validCategories = ['pelanggaran', 'budaya_positif', 'prestasi'];
        if (!in_array($category, $validCategories)) {
            abort(404);
        }

        $poinKategori = PoinKategori::where('kategori', $category)->get();
        $title = "Data " . ucfirst(str_replace('_', ' ', $category));
        return view("data_master.$category", compact('poinKategori', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'kategori' => 'required|string|in:pelanggaran,budaya_positif,prestasi',
            'nama' => 'required|string',
            'poin' => 'required|integer',
        ]);

        // Menyimpan data baru
        PoinKategori::create([
            'kategori' => $request->kategori,
            'nama' => $request->nama,
            'poin' => $request->poin,
        ]);

        return redirect()->route('poin_kategori.indexByCategory', ['category' => $request->kategori])->with('success', 'Data Berhasil Ditambahkan');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'kategori' => 'required|string|in:pelanggaran,budaya_positif,prestasi',
            'nama' => 'required|string',
            'poin' => 'required|integer',
        ]);

        // Cari PoinKategori berdasarkan ID
        $poinKategori = PoinKategori::find($id);
        if (!$poinKategori) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        // Perbarui data
        $poinKategori->update([
            'kategori' => $request->kategori,  // Pastikan kategori dikirim dan diperbarui
            'nama' => $request->nama,
            'poin' => $request->poin,
        ]);

        return redirect()->route('poin_kategori.indexByCategory', ['category' => $poinKategori->kategori])->with('success', 'Data Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Cari PoinKategori berdasarkan ID
        $poinKategori = PoinKategori::find($id);
        if (!$poinKategori) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        // Simpan kategori sebelum dihapus untuk digunakan di redirect
        $category = $poinKategori->kategori;

        // Hapus data
        $poinKategori->delete();

        return redirect()->route('poin_kategori.indexByCategory', ['category' => $category])->with('success', 'Data Berhasil Dihapus');
    }
}
