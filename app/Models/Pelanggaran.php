<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggaran extends Model
{
    use HasFactory;

    protected $table = 'pelanggarans';

    protected $fillable = ['siswa_id', 'nama_pelanggaran', 'point', 'tanggal'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
}
