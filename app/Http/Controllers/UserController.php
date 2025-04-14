<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Siswa;
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
        $data_siswa = Siswa::whereNotIn('id', User::where('role', 'siswa')->pluck('siswa_id'))->get();
        return view("user.$role", compact('users', 'title', 'data_siswa'));
    }

    /**
     * Simpan user baru
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'siswa_id' => 'required_if:role,siswa|exists:siswa,id',
            'nama' => 'nullable|string',
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string',
            'role' => 'required|in:admin,guru,siswa',
        ]);

        if ($request->role == 'siswa') {
            $siswa = Siswa::findOrFail($request->siswa_id);
            $validatedData['nama'] = $siswa->nama_siswa;
        }

        User::create([
            'nama'           => $validatedData['nama'],
            'username'       => $validatedData['username'],
            'password'       => bcrypt($validatedData['password']),
            'password_plain' => $validatedData['password'], // Simpan password asli
            'role'           => $validatedData['role'],
            'siswa_id'       => $validatedData['role'] === 'siswa' ? $validatedData['siswa_id'] : null,
        ]);

        return back()->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Update user
     */
    public function update(Request $request, User $user)
    {
        if ($request->role == 'siswa') {
            $siswa = Siswa::findOrFail($request->siswa_id);
            $validatedData['nama'] = $siswa->nama_siswa; // Ambil nama dari tabel siswa
        }

        $validatedData = $request->validate([
            'nama' => 'required',
            'username' => 'required|unique:users,username,' . $user->id,
            'role' => 'required',
            'siswa_id' => $request->role == 'siswa' ? 'required' : 'nullable',
        ]);

        $user->update([
            'nama'           => $validatedData['nama'],
            'username'       => $validatedData['username'],
            'password'       => $request->password ? bcrypt($request->password) : $user->password,
            'password_plain' => $request->password ? $request->password : $user->password_plain, // Update password asli
            'role'           => $validatedData['role'],
            'siswa_id'       => $validatedData['role'] === 'siswa' ? $validatedData['siswa_id'] : null,
        ]);
        
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
