<?php

namespace App\Http\Controllers;

use App\Models\PoinKategori;
use App\Models\PoinSiswa;
use Illuminate\Http\Request;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;


class PoinSiswaController extends Controller
{
    public function indexByCategory($category)
    {
        $validCategories = ['pelanggaran', 'budaya_positif', 'prestasi'];
        if (!in_array($category, $validCategories)) {
            abort(404); 
        }
        $poinSiswa = PoinSiswa::where('kategori', $category)->get();
        $title = "Data " . ucfirst(str_replace('_', ' ', $category));
        return view("poin.$category", compact('poinSiswa', 'title'));
    }

    /**
     * Simpan poin siswa
     */
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'poin_kategori_id' => 'required|exists:kategori_poin,id',
            'keterangan' => 'nullable|string',
            'tanggal' => 'required|date',
        ]);

        PoinSiswa::create([
            'siswa_id' => $request->siswa_id,
            'poin_kategori_id' => $request->poin_kategori_id,
            'user_id' => Auth::id(), // Guru/Admin yang menambahkan
            'keterangan' => $request->keterangan,
            'tanggal' => $request->tanggal,
        ]);

        return redirect()->route('poin.create')->with('success', 'Poin siswa berhasil ditambahkan!');
    }
}
