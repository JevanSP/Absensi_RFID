<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SiswaImport;

class SiswaController extends Controller
{
    public function index()
    {
        $title = 'Data Siswa';
        $data_siswa = Siswa::with('kelas')->get();
        $data_kelas = Kelas::all();
        return view('data_master.siswa.siswa', compact('data_siswa', 'title', 'data_kelas'));
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

    public function update_rfid(Request $request, string $id): RedirectResponse
    {
        $siswa = Siswa::findOrFail($id);

        $request->validate([
            'rfid_tag' => 'required|string|unique:siswa,rfid_tag,' . $id,
        ]);

        $siswa->update($request->only('rfid_tag'));
        return redirect()->route('siswa.data_siswa')->with('success', 'RFID berhasil diperbarui!');
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


    public function import_excel_store(Request $request): RedirectResponse
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls|max:10240', // Max 10MB
        ], [
            'file_excel.required' => 'File Excel wajib diunggah.',
            'file_excel.mimes' => 'File harus berformat .xlsx atau .xls.',
        ]);

        try {
            // Inisialisasi Import Class
            $import = new SiswaImport;

            Excel::import($import, $request->file('file_excel'));

            // Cek jika ada baris yang gagal
            if ($import->failures()->isNotEmpty()) {
                // Kumpulkan pesan error
                $errorMessages = 'Beberapa data gagal diimpor: <br>';
                foreach ($import->failures() as $failure) {
                    $row = $failure->row();
                    $attribute = $failure->attribute();
                    $errors = implode(', ', $failure->errors());
                    $errorMessages .= "Baris $row (Kolom $attribute): $errors. <br>";
                }
                return redirect()->route('siswa.data_siswa')->with('error', $errorMessages);
            }
        } catch (\Exception $e) {
            return redirect()->route('siswa.data_siswa')->with('error', 'Gagal mengimpor data. Pastikan format file sudah benar. Error: ' . $e->getMessage());
        }

        return redirect()->route('siswa.data_siswa')->with('success', 'Semua data siswa dari Excel berhasil diimpor!');
    }

    // SiswaController.php
    public function import_excel_form()
    {
        $title = 'Import Data Siswa (Excel)';
        return view('data_master.siswa.import_siswa', compact('title'));
    }
}
