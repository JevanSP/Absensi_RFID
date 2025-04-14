<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

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
            $user = User::where('username', $request->username)->first();

            // Cek apakah user ditemukan dan password cocok
            if ($user && Hash::check($request->password, $user->password)) {
                Auth::login($user);        
                if ($user->role === 'siswa') {
                    return redirect()->route('dashboard.siswa');
                } else {
                    return redirect()->route('dashboard.admin_guru');
                }
            } else {
                return redirect()->back()->withErrors(['login' => 'Invalid username or password.']);
            }
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
