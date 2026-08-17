<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alumni_tracers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->enum('status_alumni', ['Kuliah', 'Bekerja', 'Kuliah & Bekerja', 'Wirausaha', 'Mencari Kerja']);
            $table->string('nama_instansi');
            $table->string('jurusan_atau_jabatan')->nullable();
            $table->string('tahun_masuk')->nullable();
            $table->string('lokasi')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alumni_tracers');
    }
};
