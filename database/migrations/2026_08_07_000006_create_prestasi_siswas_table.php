<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prestasi_siswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->nullable()->constrained('siswa')->onDelete('set null');
            $table->string('nama_siswa');
            $table->string('kelas')->nullable();
            $table->string('judul_prestasi');
            $table->string('kategori')->default('Akademik');
            $table->string('tingkat')->default('Nasional');
            $table->string('peringkat')->default('Juara 1');
            $table->string('tahun')->default(date('Y'));
            $table->string('penyelenggara')->nullable();
            $table->string('foto_bukti')->nullable();
            $table->boolean('tampilkan_di_beranda')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prestasi_siswas');
    }
};
