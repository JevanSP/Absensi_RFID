<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use App\Models\Guru;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function admin()
    {
        $data = array(
            'title' => 'Admin',
            'data_user' => User::where('id', '!=', Auth::id())->get(),
        );
        $data_admin= User::all()->where('role', 'admin');
        return view('user.admin', $data, compact('data_admin'));
    }

    public function guru()
    {
        $data = array(
            'title' => 'Guru',
            'data_user' => User::where('id', '!=', Auth::id())->get(),
        );
        return view('user.guru', $data);
    }

    public function siswa()
    {
        $data = array(
            'title' => 'Siswa',
            'data_user' => User::where('id', '!=', Auth::id())->get(),
        );
        return view('user.siswa', $data);
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
        if ($request->role == 'admin') {
            $adminCount = User::where('role', 'admin')->count();
            if ($adminCount >= 1) {
                return redirect()->back()->with('error', 'Admin sudah ada');
            }
        }

        User::create([
            'ni' => $request->ni,
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => $request->password,
            'role' => 'admin',
        ]);
        return redirect()->back();
    }

    public function addadmin()
    {
        
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
        $user = User::find($id);
        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = User::find($id);
        $data->delete();
        return redirect()->back();
    }
}
