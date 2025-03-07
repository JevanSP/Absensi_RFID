<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users'; // Nama tabel di database

    protected $primaryKey = 'id'; // Primary Key

    public $timestamps = true; // Mengaktifkan timestamps (created_at, updated_at)

    protected $fillable = [
        'nama',
        'username',
        'password',
        'role',
        'siswa_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function Siswa()
    {
        return $this->hasOne(Siswa::class, 'siswa_id');
    }

}
