<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrestasiSiswa extends Model
{
    use HasFactory;

    protected $table = 'prestasi_siswas';

    protected $fillable = [
        'siswa_id',
        'nama_siswa',
        'kelas',
        'judul_prestasi',
        'kategori',
        'tingkat',
        'peringkat',
        'tahun',
        'penyelenggara',
        'foto_bukti',
        'tampilkan_di_beranda',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
}
