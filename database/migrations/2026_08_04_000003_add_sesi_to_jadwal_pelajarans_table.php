<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jadwal_pelajarans', function (Blueprint $table) {
            $table->string('sesi')->nullable()->default('Pagi')->after('jam_selesai');
        });
    }

    public function down(): void
    {
        Schema::table('jadwal_pelajarans', function (Blueprint $table) {
            $table->dropColumn('sesi');
        });
    }
};
