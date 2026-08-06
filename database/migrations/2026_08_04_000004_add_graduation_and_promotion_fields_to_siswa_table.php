<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->string('tahun_lulus')->nullable()->after('status');
            $table->decimal('total_nilai', 8, 2)->nullable()->after('tahun_lulus');
            $table->string('foto_kenangan')->nullable()->after('total_nilai');
            $table->string('status_kenaikan')->nullable()->after('foto_kenangan'); // 'Naik Kelas', 'Tinggal Kelas', 'Lulus'
            $table->text('pesan_kenaikan')->nullable()->after('status_kenaikan');
        });
    }

    public function down(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->dropColumn(['tahun_lulus', 'total_nilai', 'foto_kenangan', 'status_kenaikan', 'pesan_kenaikan']);
        });
    }
};
