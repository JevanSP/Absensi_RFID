<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';

    protected $fillable = [
        'nis',
        'nama_siswa',
        'jenis_kelamin',
        'kelas_id',
        'rfid_tag',
        'foto'
    ];

    public function Kelas():BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function User()
    {
        return $this->hasOne(User::class, 'siswa_id');
    }

    public function Absensi()
    {
        return $this->hasMany(Absensi::class, 'siswa_id');
    }

    public function PoinSiswa()
    {
        return $this->hasMany(PoinSiswa::class, 'siswa_id');
    }

}

