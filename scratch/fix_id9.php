<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\JadwalPelajaran;

$j9 = JadwalPelajaran::find(9);
if ($j9 && substr($j9->jam_mulai, 0, 2) === '00') {
    $j9->jam_mulai = '12:48:00';
    $j9->save();
    echo "ID 9 fixed jam_mulai to 12:48:00\n";
}
