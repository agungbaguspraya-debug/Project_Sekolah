<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\JadwalPelajaran;

$schedules = JadwalPelajaran::all();
echo "Found " . $schedules->count() . " schedule items:\n";

foreach ($schedules as $j) {
    echo "ID {$j->id} | {$j->kelas} | {$j->mata_pelajaran} | {$j->jam_mulai} - {$j->jam_selesai}\n";
    
    // Check if jam_selesai is earlier than jam_mulai (e.g. 13:40 - 02:44)
    $startSec = strtotime($j->jam_mulai);
    $endSec = strtotime($j->jam_selesai);
    
    if ($endSec < $startSec) {
        // Fix 12-hour offset (add 12 hours to jam_selesai)
        $newEndSec = $endSec + (12 * 3600);
        $j->jam_selesai = date('H:i:s', $newEndSec);
        $j->save();
        echo " -> FIXED jam_selesai to: {$j->jam_selesai}\n";
    }
}
