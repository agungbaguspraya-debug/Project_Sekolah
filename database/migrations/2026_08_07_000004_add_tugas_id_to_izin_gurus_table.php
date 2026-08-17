<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('izin_gurus', function (Blueprint $table) {
            $table->foreignId('tugas_id')->nullable()->after('alasan')->constrained('tugas')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('izin_gurus', function (Blueprint $table) {
            $table->dropForeign(['tugas_id']);
            $table->dropColumn('tugas_id');
        });
    }
};
