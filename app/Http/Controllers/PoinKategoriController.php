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
        $request->validate([
            'kategori' => 'required|string',
            'nama' => 'required|string',
            'poin' => 'required|integer',
        ]);

        PoinKategori::create($request->all());

        return redirect()->route('poin_kategori.indexByCategory', ['category' => $request->kategori])->with('success', 'Data Berhasil Ditambahkan');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $poinKategori = PoinKategori::find($id);
        $poinKategori->update($request->all());
        return redirect()->route('poin_kategori.indexByCategory', ['category' => $poinKategori->kategori])->with('success', 'Data Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $poinKategori = PoinKategori::find($id);
        $category = $poinKategori->kategori;
        $poinKategori->delete();
        return redirect()->route('poin_kategori.indexByCategory', ['category' => $category])->with('success', 'Data Berhasil Dihapus');
    }

    /**
     * Store a newly created resource in storage.
     */
    
}
