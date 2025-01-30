<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurusan;

class JurusanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = array(
            'title' => 'Jurusan',
            'data_jurusan'   => Jurusan::all(),
        );
        return view('data_master.jurusan', $data);
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
        Jurusan::create([
            'jurusan' => $request->jurusan,
            'singkatan' => $request->singkatan,
        ]);

        return redirect('/data_jurusan');
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
        Jurusan::where('id', $id)->update([
            'jurusan' => $request->jurusan,
            'singkatan' => $request->singkatan,
        ]);

        return redirect('/data_jurusan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Jurusan::find($id);
        $data->delete([
        ]);
        return redirect('/data_jurusan');
    }
}
