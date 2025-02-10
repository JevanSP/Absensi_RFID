<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Tampilkan daftar user berdasarkan role
     */
    public function getIndexByRole($role)
    {
        $validRoles = ['admin', 'guru', 'siswa'];
        if (!in_array($role, $validRoles)) {
            abort(404); // Jika role tidak valid, tampilkan halaman 404
        }

        $users = User::where('role', $role)->get();
        $title = "Data " . ucfirst($role);
        return view("user.$role", compact('users', 'title'));
    }

    /**
     * Simpan user baru
     */
    public function store(Request $request)
    {
        User::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        return redirect("/user/{$request->role}");
    }

    /**
     * Update user
     */
    public function update(Request $request, User $user)
    {
        $user->update(array_filter([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => $request->password ? bcrypt($request->password) : null,
        ]));

        return back();
    }

    /**
     * Hapus user
     */
    public function destroy(User $user)
    {
        $user->delete();
        return back();
    }
}
