<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Jurusan;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = array(
            'title' => 'Siswa',
            'data_siswa'  => Siswa::with('jurusan')->get(
                
            )   
        );      
        return view('data_master.siswa', $data);
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
        Siswa::create([
            'nis' => $request->nis,
            'nama_siswa' => $request->nama_siswa,
            'jenis_kelamin' => $request->jenis_kelamin,
            'kelas' => $request->kelas,
            'jurusan_id' => $request->jurusan,
            'rfid_tag' => $request->rfid_tag,
            'foto' => $request->foto,
        ]); 

        return redirect('/data_siswa');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $siswa = Siswa::find($id);
        $siswa->update([
            'nis' => $request->nis,
            'nama_siswa' => $request->nama_siswa,
            'jenis_kelamin' => $request->jenis_kelamin,
            'kelas' => $request->kelas,
            'jurusan_id' => $request->jurusan,
            'rfid_tag' => $request->rfid_tag,
            'foto' => $request->foto,
        ]);

        return redirect('/data_siswa');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Siswa::find($id);
        $data->delete([
        ]);
        return redirect('/data_siswa');
    }
}
