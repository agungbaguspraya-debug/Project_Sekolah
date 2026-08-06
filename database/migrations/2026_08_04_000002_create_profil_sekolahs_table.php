<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profil_sekolahs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sekolah')->default('SMK Negeri 1 SAT System');
            $table->string('npsn_status')->default('10802999 | Negeri');
            $table->string('kepala_sekolah')->default('Dr. H. Ahmad Wijaya, M.Pd.');
            $table->string('akreditasi')->default('A');
            $table->string('jam_operasional')->default('Senin - Jumat (07:00 - 15:30 WIB)');
            $table->text('alamat')->nullable();
            $table->string('email')->nullable();
            $table->string('telepon')->nullable();
            $table->text('visi')->nullable();
            $table->text('misi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profil_sekolahs');
    }
};
