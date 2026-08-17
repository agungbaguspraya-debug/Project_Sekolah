<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftaranEkskul extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran_ekskuls';

    protected $fillable = [
        'siswa_id',
        'ekstrakurikuler_id',
        'status',
        'alasan_bergabung',
        'catatan_admin',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function ekstrakurikuler()
    {
        return $this->belongsTo(Ekstrakurikuler::class, 'ekstrakurikuler_id');
    }
}
