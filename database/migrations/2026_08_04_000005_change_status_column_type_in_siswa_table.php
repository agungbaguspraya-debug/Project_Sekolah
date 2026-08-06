<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Change status column from ENUM to VARCHAR(100) so 'Lulus', 'Pelajar', 'Alumni' are all allowed
        DB::statement("ALTER TABLE `siswa` MODIFY `status` VARCHAR(100) NOT NULL DEFAULT 'Pelajar'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE `siswa` MODIFY `status` ENUM('Pelajar','Lulus Kuliah','Lulus Kerja','Lulus') NOT NULL DEFAULT 'Pelajar'");
    }
};
