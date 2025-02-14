<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Siswa extends Model
{
    protected $table = 'siswa';

    protected $fillable = [
        'nis',
        'nama_siswa',
        'jenis_kelamin',
        'kelas',
        'jurusan_id',
        'rfid_tag',
        'foto'
    ];

    public function Jurusan():BelongsTo
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'siswa_id');
    }
}

