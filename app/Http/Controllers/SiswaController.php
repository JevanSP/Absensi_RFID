<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    public function index()
    {
        $title = 'Data Siswa';
        $data_siswa = Siswa::with('kelas')->get();
        return view('data_master.siswa.siswa', compact('data_siswa', 'title'));
    }

    public function create()
    {
        $title = 'Tambah Siswa';
        $data_kelas = Kelas::all();
        return view('data_master.siswa.add_siswa', compact('data_kelas', 'title'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nis'           => 'required|unique:siswa,nis',
            'nama_siswa'    => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'kelas_id'      => 'required|exists:kelas,id',
            'rfid_tag'      => 'nullable|string|unique:siswa,rfid_tag',
            'foto'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Menyimpan file gambar yang diunggah oleh pengguna (jika ada) ke folder 'siswa' di disk 'public'.
        $imageName = $request->file('foto')?->store('siswa', 'public');

        // Membuat entri baru di tabel 'siswa' menggunakan model Siswa.
        // Data yang disimpan adalah gabungan dari semua input kecuali 'foto' ($request->except('foto')),
        // ditambah dengan nama file gambar yang baru saja disimpan.
        Siswa::create(array_merge($request->except('foto'), ['foto' => $imageName]));

        return redirect()->route('siswa.data_siswa')->with('success', 'Data Berhasil Disimpan!');
    }

    public function edit(string $id)
    {
        $title = 'Update - Siswa';
        $data_siswa = Siswa::findOrFail($id);
        $data_kelas = Kelas::all();
        return view('data_master.siswa.edit_siswa', compact('data_siswa', 'data_kelas', 'title'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $siswa = Siswa::findOrFail($id);

        $request->validate([
            'nis'           => 'required|unique:siswa,nis,' . $id,
            'nama_siswa'    => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'kelas_id'      => 'required|exists:kelas,id',
            'rfid_tag'      => 'nullable|string',
            'foto'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $imageName = $request->file('foto')->store('siswa', 'public');
            if ($siswa->foto) {
                Storage::delete('public/' . $siswa->foto);
            }
            $siswa->foto = $imageName;
        }

        $siswa->update($request->except('foto'));
        return redirect()->route('siswa.data_siswa')->with('success', 'Data siswa berhasil diperbarui!');
    }

    public function destroy(string $id): RedirectResponse
    {
        $siswa = Siswa::findOrFail($id);

        if ($siswa->foto) {
            Storage::delete('public/' . $siswa->foto);
        }

        $siswa->delete();
        return redirect()->route('siswa.data_siswa')->with('success', 'Data Berhasil Dihapus!');
    }
}
