<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('izin_gurus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained('gurus')->onDelete('cascade');
            $table->enum('jenis', ['Izin', 'Sakit', 'Hadir'])->default('Izin');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->integer('jumlah_hari')->default(1);
            $table->text('alasan');
            $table->text('tugas_siswa')->nullable();
            $table->boolean('minta_guru_pengganti')->default(true);
            $table->foreignId('guru_pengganti_id')->nullable()->constrained('gurus')->onDelete('set null');
            $table->enum('status', ['Pending', 'Disetujui', 'Ditolak'])->default('Pending');
            $table->text('catatan_admin')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('izin_gurus');
    }
};
