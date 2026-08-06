<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$controller = new App\Http\Controllers\KelasController();
$data = $controller->index()->getData()['groupedKelas'];

foreach ($data as $group => $list) {
    $classNames = array_map(fn($item) => $item->nama_kelas, $list);
    echo "GROUP: [" . $group . "]\n";
    echo "   CLASSES: " . implode(", ", $classNames) . "\n\n";
}
