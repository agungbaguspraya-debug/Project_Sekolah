<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('gurus', function (Blueprint $table) {
            $table->enum('kategori', ['guru', 'staff'])->default('guru')->after('id');
            $table->string('posisi')->nullable()->after('kategori');
            $table->string('mata_pelajaran')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gurus', function (Blueprint $table) {
            $table->dropColumn(['kategori', 'posisi']);
        });
        
        // Changing it back to non-nullable is tricky if there's null data.
        // We'll leave it out or run a DB statement safely.
        DB::statement('ALTER TABLE gurus MODIFY mata_pelajaran VARCHAR(255) NOT NULL;');
    }
};
