<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengaturanAbsensi extends Model
{
    use HasFactory;

    protected $table = 'pengaturan_absensi';
    protected $fillable = ['jam_masuk', 'jam_pulang'];

    public function Absensi()
    {
        return $this->hasMany(Absensi::class, 'pengaturan_absensi_id');
    }
}
