<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ekstrakurikulers', function (Blueprint $table) {
            $table->id();
            $table->string('nama_ekskul');
            $table->string('kategori')->default('Umum');
            $table->string('pembina')->nullable();
            $table->string('hari_latihan')->nullable();
            $table->string('jam_latihan')->nullable();
            $table->string('lokasi')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ekstrakurikulers');
    }
};
