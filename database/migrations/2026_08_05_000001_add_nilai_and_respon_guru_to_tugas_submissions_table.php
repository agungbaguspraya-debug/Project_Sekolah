<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tugas_submissions', function (Blueprint $table) {
            $table->integer('nilai')->nullable()->after('file_path');
            $table->text('respon_guru')->nullable()->after('nilai');
        });

        // Modify deadline in tugas table to DATETIME
        try {
            DB::statement("ALTER TABLE tugas MODIFY deadline DATETIME NOT NULL");
        } catch (\Exception $e) {
            // Fallback if alter table fails or column is already datetime
        }
    }

    public function down(): void
    {
        Schema::table('tugas_submissions', function (Blueprint $table) {
            $table->dropColumn(['nilai', 'respon_guru']);
        });

        try {
            DB::statement("ALTER TABLE tugas MODIFY deadline DATE NOT NULL");
        } catch (\Exception $e) {
        }
    }
};
