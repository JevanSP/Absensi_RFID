<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PoinSiswa extends Model
{
    protected $table = 'poin_siswa';

    protected $fillable = [
        'siswa_id',
        'poin_kategori_id',
        'user_id',
        'keterangan',
        'tanggal',
    ];

    public function Siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function PoinKategori()
    {
        return $this->belongsTo(PoinKategori::class);
    }

    public function kategori()
    {
        return $this->belongsTo(PoinKategori::class, 'poin_kategori_id');
    }

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
