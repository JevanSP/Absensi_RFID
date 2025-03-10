<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Jurusan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Data Siswa';
        $data_siswa = Siswa::with('jurusan')->get();
        return view('data_master.siswa.siswa', compact('data_siswa', 'title'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Tambah Siswa';
        $data_jurusan = Jurusan::all();
        return view('data_master.siswa.add_siswa', compact('data_jurusan', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $image = $request->file('foto');
        $image->storeAs('public/siswa/', $image->hashName());

        //create product
        Siswa::create([
            'nis'            => $request->nis,
            'nama_siswa'     => $request->nama_siswa,
            'jenis_kelamin'  => $request->jenis_kelamin,
            'kelas'          => $request->kelas,
            'jurusan_id'     => $request->jurusan_id,
            'rfid_tag'       => $request->rfid_tag,
            'foto'           => $image->hashName(),
        ]);

        return redirect('/data_siswa')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = 'Update - Siswa';
        $data_siswa = Siswa::with('jurusan')->find($id);
        $data_jurusan = Jurusan::all();
        return view('data_master.siswa.edit_siswa', compact('data_siswa', 'data_jurusan', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request , string $id): RedirectResponse
    {
        $siswa = Siswa::findOrFail($id);    

        // Check if a new image is uploaded
        if ($request->hasFile('foto')) {

            // Upload the new image
            $image = $request->file('foto');
            $image->storeAs('public/siswa/', $image->hashName());

            // Delete the old image from storage (if it exists)
            if ($siswa->foto && Storage::exists('public/siswa/' . $siswa->foto)) {
                Storage::delete('public/siswa/' . $siswa->foto);
            }

            // Update the product with the new image
            $siswa->update([
                'nis'            => $request->nis,
                'nama_siswa'     => $request->nama_siswa,
                'jenis_kelamin'  => $request->jenis_kelamin,
                'kelas'          => $request->kelas,
                'jurusan_id'     => $request->jurusan_id,
                'rfid_tag'       => $request->rfid_tag,
                'foto'           => $image->hashName(),
            ]);
        } else {

            // Update the product without changing the image
            $siswa->update([
                'nis'            => $request->nis,
                'nama_siswa'     => $request->nama_siswa,
                'jenis_kelamin'  => $request->jenis_kelamin,
                'kelas'          => $request->kelas,
                'jurusan_id'     => $request->jurusan_id,
                'rfid_tag'       => $request->rfid_tag,
            ]);
        }

        return redirect()->route('/data_siswa')->with('success', 'siswa updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $siswa = Siswa::findOrFail($id);

        Storage::delete('public/siswa/' . $siswa->foto);
        $siswa->delete();
        return redirect('/data_siswa')->with('success', 'Data Berhasil Dihapus!');
    }
}
