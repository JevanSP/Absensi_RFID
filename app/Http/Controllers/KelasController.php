<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = array(
            'title' => 'Kelas',
            'data_kelas'   => Kelas::all(),
        );
        return view('data_master.kelas', $data);
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
        Kelas::create([
            'tingkatan' => $request->tingkatan,
            'nama' => $request->nama,
        ]);

        return redirect('/data_kelas')->with('success', 'Data Berhasil Ditambahkan');
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
        Kelas::where('id', $id)->update([
            'tingkatan' => $request->tingkatan,
            'nama' => $request->nama,
        ]);

        return redirect('/data_kelas')->with('success', 'Data Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Kelas::find($id);
        $data->delete([
        ]);
        return redirect('/data_kelas');
    }
}
