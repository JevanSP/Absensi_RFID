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
        'pengaturan_absensi_id',
        'tanggal',
        'status',
        'jam_masuk',
        'jam_pulang',
        'keterangan',
    ];

    public function Siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function PengaturanAbsensi()
    {
        return $this->belongsTo(PengaturanAbsensi::class, 'pengaturan_absensi_id');
    }
    
}
