<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlumniTracer extends Model
{
    use HasFactory;

    protected $table = 'alumni_tracers';

    protected $fillable = [
        'siswa_id',
        'status_alumni',
        'nama_instansi',
        'jurusan_atau_jabatan',
        'tahun_masuk',
        'lokasi',
        'catatan',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
}
