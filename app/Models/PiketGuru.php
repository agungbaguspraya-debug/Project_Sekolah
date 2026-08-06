<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PiketGuru extends Model
{
    use HasFactory;

    protected $table = 'piket_gurus';

    protected $fillable = [
        'guru_id',
        'hari',
        'tugas_piket',
        'jam_mulai',
        'jam_selesai',
        'keterangan',
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }
}
