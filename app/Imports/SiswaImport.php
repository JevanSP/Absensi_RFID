<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\Kelas;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithValidation;

class SiswaImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $kelas = Kelas::where('nama', $row['nama_kelas'])->first();

        if (!$kelas) {
            
            return null;
        }
        $fotoPath = null;
        if (!empty($row['nama_file_foto'])) {
            $fotoPath = 'siswa/' . $row['nama_file_foto'];
        }

        return new Siswa([
            'nis'           => $row['nis'],
            'nama_siswa'    => $row['nama_siswa'],
            'jenis_kelamin' => strtoupper($row['jenis_kelamin']),
            'kelas_id'      => $kelas->id,
            'rfid_tag'      => $row['rfid_tag'] ?? null, 
            'foto'          => $fotoPath, 
        ]);
    }

    
    public function rules(): array
    {
        return [
            'nis'           => 'required|unique:siswa,nis',
            'nama_siswa'    => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P,l,p',
            'nama_kelas'    => 'required|string', 
            'rfid_tag'      => 'nullable|unique:siswa,rfid_tag',
            'nama_file_foto' => 'nullable|string',
        ];
    }

    
    public function headingRow(): int
    {
        return 1; 
    }
}
