<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IzinGuru extends Model
{
    use HasFactory;

    protected $table = 'izin_gurus';

    protected $fillable = [
        'guru_id',
        'jenis',
        'tanggal_mulai',
        'tanggal_selesai',
        'jumlah_hari',
        'alasan',
        'tugas_id',
        'tugas_siswa',
        'minta_guru_pengganti',
        'guru_pengganti_id',
        'status',
        'catatan_admin',
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }

    public function guruPengganti()
    {
        return $this->belongsTo(Guru::class, 'guru_pengganti_id');
    }

    public function tugas()
    {
        return $this->belongsTo(Tugas::class, 'tugas_id');
    }
}
