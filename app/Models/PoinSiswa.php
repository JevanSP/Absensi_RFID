<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PoinSiswa extends Model
{
    protected $table = 'poin_siswa';

    protected $fillable = [
        'siswa_id',
        'poin_kategori_id',
        'guru_id',
        'keterangan',
        'tanggal',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function kategoriPoin()
    {
        return $this->belongsTo(PoinKategori::class);
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
