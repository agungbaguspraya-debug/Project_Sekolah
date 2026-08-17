<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ekstrakurikuler extends Model
{
    use HasFactory;
    protected $table = 'ekstrakurikulers';

    protected $fillable = [
        'nama_ekskul',
        'kategori',
        'pembina',
        'hari_latihan',
        'jam_latihan',
        'lokasi',
        'deskripsi',
        'foto',
    ];

    public function pendaftaran()
    {
        return $this->hasMany(PendaftaranEkskul::class, 'ekstrakurikuler_id');
    }
}
