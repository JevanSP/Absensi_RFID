<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PoinSiswa extends Model
{
    protected $table = 'poin_siswa';

    protected $fillable = [
        'siswa_id',
        'kategori_id',
        'guru_id',
        'keterangan',
        'tanggal',
    ];

    public function Siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
}
