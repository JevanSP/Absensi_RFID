<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;
    
    protected $table = 'absensi';

    protected $fillable = [
        'siswa_id',
        'tanggal',
        'status',
        'jam_masuk',
        'jam_pulang',
        'keterangan'
    ];

    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }

    public function pengaturanAbsensi()
    {
        return $this->belongsTo(PengaturanAbsensi::class, 'pengaturan_absensi_id');
    }
    
}
