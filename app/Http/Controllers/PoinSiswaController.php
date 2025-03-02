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
        $poinKategori = PoinKategori::where('kategori', $category)->first();
        $siswa = Siswa::all();
        $title = "Poin " . ucfirst(str_replace('_', ' ', $category));
        return view("poin.$category", compact('poinSiswa', 'title', 'poinKategori'));
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

        return redirect()->route('poin_siswa.indexByCategory', ['category' => $request->kategori])->with('success', 'Data Berhasil Ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $poinSiswa = PoinSiswa::find($id);
        $poinSiswa->update($request->all());
        return redirect()->route('poin_siswa.indexByCategory', ['category' => $poinSiswa->kategori])->with('success', 'Data Berhasil Diupdate');
    }

    public function destroy($id)
    {
        $poinSiswa = PoinSiswa::find($id);
        $category = $poinSiswa->kategori;
        $poinSiswa->delete();
        return redirect()->route('poin_siswa.indexByCategory', ['category' => $category])->with('success', 'Data Berhasil Dihapus');
    }
}
