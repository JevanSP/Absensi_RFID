<?php

namespace App\Http\Controllers;

use App\Models\PoinKategori;
use App\Models\PoinSiswa;
use Illuminate\Http\Request;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;

class PoinSiswaController extends Controller
{
    public function indexBySiswaCategory($kategori)
    {
        $validCategories = ['pelanggaran', 'budaya_positif', 'prestasi'];
        if (!in_array($kategori, $validCategories)) {
            abort(404); 
        }
        $poinSiswa = PoinSiswa::whereHas('poinKategori', function ($query) use ($kategori) {
            $query->where('nama', $kategori);
        })->get()
            ->map(function ($poin) {
                $poin->kategori_nama = PoinKategori::where('id', $poin->poin_kategori_id)->value('nama');
                return $poin;
            });
        $poinKategori = PoinKategori::where('kategori', $kategori)->get();
        $siswa = Siswa::all();
        $title = "Poin " . ucfirst(str_replace('_', ' ', $kategori));
        return view("poin.$kategori", compact('poinSiswa', 'title', 'poinKategori', 'siswa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'poin_kategori_id' => 'required|exists:poin_kategori,id',
            'poin' => 'required|integer',
            'keterangan' => 'nullable|string',
            'tanggal' => 'required|date',
        ]);

        PoinSiswa::create([
            'siswa_id' => $request->siswa_id,
            'poin_kategori_id' => $request->poin_kategori_id,
            'poin' => $request->poin,
            'user_id' => Auth::id(),
            'keterangan' => $request->keterangan,
            'tanggal' => $request->tanggal,
        ]);

        return redirect()->route('poin_siswa.indexBySiswaCategory', ['category' => $request->kategori])->with('success', 'Data Berhasil Ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'poin_kategori_id' => 'required|exists:poin_kategori,id',
            'poin' => 'required|integer',
            'keterangan' => 'nullable|string',
            'tanggal' => 'required|date',
        ]);

        $poinSiswa = PoinSiswa::find($id);
        $poinSiswa->update([
            'siswa_id' => $request->siswa_id,
            'poin_kategori_id' => $request->poin_kategori_id,
            'poin' => $request->poin,
            'keterangan' => $request->keterangan,
            'tanggal' => $request->tanggal,
        ]);

        return redirect()->route('poin_siswa.indexBySiswaCategory', ['category' => $poinSiswa->kategori])->with('success', 'Data Berhasil Diupdate');
    }

    public function destroy($id)
    {
        $poinSiswa = PoinSiswa::find($id);
        $category = $poinSiswa->kategori;
        $poinSiswa->delete();
        return redirect()->route('poin_siswa.indexBySiswaCategory', ['category' => $category])->with('success', 'Data Berhasil Dihapus');
    }
}
