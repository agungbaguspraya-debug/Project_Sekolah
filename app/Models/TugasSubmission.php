<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TugasSubmission extends Model
{
    use HasFactory;

    protected $table = 'tugas_submissions';

    protected $fillable = ['tugas_id', 'siswa_id', 'catatan', 'file_path', 'dikumpulkan_pada', 'nilai', 'respon_guru'];

    public function tugas()
    {
        return $this->belongsTo(Tugas::class, 'tugas_id');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
}
