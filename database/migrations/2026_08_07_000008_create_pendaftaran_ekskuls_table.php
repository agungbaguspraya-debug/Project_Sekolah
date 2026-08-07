<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pendaftaran_ekskuls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->foreignId('ekstrakurikuler_id')->constrained('ekstrakurikulers')->onDelete('cascade');
            $table->enum('status', ['Pending', 'Disetujui', 'Ditolak'])->default('Pending');
            $table->text('alasan_bergabung')->nullable();
            $table->text('catatan_admin')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_ekskuls');
    }
};
