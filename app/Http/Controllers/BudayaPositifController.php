<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BudayaPositif;

class BudayaPositifController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = array(
            'data_budaya_positif' => BudayaPositif::all(),
            'title' => 'Budaya Positif'
        );
        return view('data_master.budaya_positif', $data);
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
        BudayaPositif::create([
            'budaya_positif' => $request->budaya_positif,
            'poin' => $request->poin,
        ]);
        return redirect('/data_budaya_positif')->with('success', 'Data Berhasil');
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
        $budaya_positif = BudayaPositif::find($id);
        $budaya_positif->update([
            'budaya_positif' => $request->budaya_positif,
            'poin' => $request->poin,
        ]);
        return redirect('/data_budaya_positif')->with('success', 'Data Berhasil');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = BudayaPositif::find($id);
        $data->delete([
        ]);
        return redirect('/data_budaya_positif')->with('success', 'Data Berhasil');
    }
}
