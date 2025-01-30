<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggaran;

class PelanggaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = array(
            'data_pelanggaran' => Pelanggaran::all(),
            'title' => 'Pelanggaran'
        );
        return view('data_master.pelanggaran', $data);
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
        Pelanggaran::create([
            'pelanggaran' => $request->pelanggaran,
            'poin' => $request->poin,
        ]);
        return redirect('/data_pelanggaran')->with('success', 'Data Berhasil');
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
        $pelanggaran = Pelanggaran::find($id);
        $pelanggaran->update([
            'pelanggaran' => $request->pelanggaran,
            'poin' => $request->poin,
        ]);
        return redirect('/data_pelanggaran')->with('success', 'Data Berhasil');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Pelanggaran::find($id);
        $data->delete([
        ]);
        return redirect('/data_pelanggaran')->with('success', 'Data Berhasil');
    }
}
