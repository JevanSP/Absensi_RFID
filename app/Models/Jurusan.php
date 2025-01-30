<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jurusan extends Model
{
    protected $table = 'jurusan';

    protected $fillable = [
        'jurusan',
        'singkatan',
    ];

    public function Siswa():HasMany
    {
        return $this->hasMany(Siswa::class,'nama_siswa');
    }

}

