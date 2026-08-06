<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gurus', function (Blueprint $table) {
            $table->id();
            $table->string('nip')->nullable()->unique();
            $table->string('nama');
            $table->string('mata_pelajaran');
            $table->string('no_hp')->nullable();
            $table->string('foto')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('piket_gurus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained('gurus')->onDelete('cascade');
            $table->string('hari');
            $table->string('tugas_piket');
            $table->time('jam_mulai')->nullable();
            $table->time('jam_selesai')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('guru_id')->nullable()->after('siswa_id')->constrained('gurus')->onDelete('cascade');
        });

        Schema::table('tugas', function (Blueprint $table) {
            $table->foreignId('guru_id')->nullable()->after('id')->constrained('gurus')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('tugas', function (Blueprint $table) {
            $table->dropForeign(['guru_id']);
            $table->dropColumn('guru_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['guru_id']);
            $table->dropColumn('guru_id');
        });

        Schema::dropIfExists('piket_gurus');
        Schema::dropIfExists('gurus');
    }
};
