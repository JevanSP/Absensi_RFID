<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PoinKategori extends Model
{
    protected $table = 'poin_kategori';

    protected $fillable = [
        'nama',
        'kategori',
        'poin'
    ];

    public function PoinSiswa()
    {
        return $this->hasMany(PoinSiswa::class);
    }
}
