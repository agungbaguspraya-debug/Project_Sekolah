<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPelajaran extends Model
{
    use HasFactory;

    protected $table = 'jadwal_pelajarans';

    protected $fillable = ['kelas', 'hari', 'mata_pelajaran', 'guru_id', 'jam_mulai', 'jam_selesai', 'sesi'];

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }
}
