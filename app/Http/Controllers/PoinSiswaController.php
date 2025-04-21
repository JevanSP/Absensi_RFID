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
        $poinKategori = PoinKategori::where('kategori', $kategori)->get();
        $poinSiswa = PoinSiswa::with(['siswa.kelas', 'poinKategori', 'user'])
            ->whereHas('poinKategori', function ($query) use ($kategori) {
                $query->where('kategori', $kategori);
            })
            ->get();


        $siswa = Siswa::all();
        $title = "Poin " . ucfirst(str_replace('_', ' ', $kategori));
        $user = Auth::user();
        return view("poin.budaya_positif", compact('poinSiswa', 'title', 'poinKategori', 'siswa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'poin_kategori_id' => 'required|exists:poin_kategori,id',
            'poin' => 'required|integer',
            'keterangan' => 'nullable|string',
            'tanggal' => 'required|date',
            'kategori' => 'required|string|in:prestasi,pelanggaran,budaya_positif',
        ]);

        // Pastikan kategori pada poin kategori sama dengan kategori yang dipilih
        $poinKategori = PoinKategori::find($request->poin_kategori_id);
        if ($poinKategori && $poinKategori->kategori !== $request->kategori) {
            return redirect()->back()->with('error', 'Kategori poin tidak sesuai dengan kategori yang dipilih');
        }

        PoinSiswa::create([
            'siswa_id' => $request->siswa_id,
            'poin_kategori_id' => $request->poin_kategori_id,
            'poin' => $request->poin,
            'user_id' => Auth::id(),
            'keterangan' => $request->keterangan,
            'tanggal' => $request->tanggal,
            'kategori' => $request->kategori,
        ]);

        return redirect()->route('poin_siswa.index', ['kategori' => $request->kategori])->with('success', 'Data Berhasil Ditambahkan');
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'poin_kategori_id' => 'required|exists:poin_kategori,id',
            'poin' => 'required|integer',
            'keterangan' => 'nullable|string',
            'tanggal' => 'required|date',
            'kategori' => 'required|string|in:prestasi,pelanggaran,budaya_positif',
        ]);

        $poinSiswa = PoinSiswa::find($id);
        $poinSiswa->update([
            'siswa_id' => $request->siswa_id,
            'poin_kategori_id' => $request->poin_kategori_id,
            'poin' => $request->poin,
            'keterangan' => $request->keterangan,
            'tanggal' => $request->tanggal,
            'kategori' => $request->kategori,
        ]);

        return redirect()->route('poin_siswa.index', ['kategori' => $request->kategori])->with('success', 'Data Berhasil Diupdate');
    }

    public function destroy($id)
    {
        $poinSiswa = PoinSiswa::find($id);
        $kategori = $poinSiswa->kategori;
        $poinSiswa->delete();
        return redirect()->route('poin_siswa.index', ['kategori' => $kategori])->with('success', 'Data Berhasil Dihapus');
    }
}
