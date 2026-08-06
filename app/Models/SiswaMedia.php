<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiswaMedia extends Model
{
    use HasFactory;

    protected $table = 'siswa_media';

    protected $fillable = [
        'siswa_id',
        'file_path',
        'file_type',
        'caption',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
}
