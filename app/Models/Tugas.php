<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    use HasFactory;

    protected $table = 'tugas';

    protected $fillable = ['guru_id', 'kelas', 'mata_pelajaran', 'judul', 'deskripsi', 'foto', 'deadline'];

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }

    public function submissions()
    {
        return $this->hasMany(TugasSubmission::class, 'tugas_id');
    }
}
