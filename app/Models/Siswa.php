<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    // Sesuaikan dengan nama tabel di migration
    protected $table = 'siswa';

    protected $fillable = [
        'nis', 'nama', 'kelas', 'jurusan', 'foto', 'status',
        'tahun_lulus', 'total_nilai', 'foto_kenangan', 'status_kenaikan', 'pesan_kenaikan'
    ];

    // Kalau tabel punya created_at/updated_at (default Laravel), biarkan true
    // Kalau migration kamu tidak bikin timestamps, baru set false
    public $timestamps = true;

    public function pelanggaran()
    {
        return $this->hasMany(Pelanggaran::class, 'siswa_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'siswa_id');
    }

    public function media()
    {
        return $this->hasMany(SiswaMedia::class, 'siswa_id');
    }
}
