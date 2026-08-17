<?php
$migrationsDir = __DIR__ . '/database/migrations/';

$migrations = [
    'create_beritas_table.php' => "
            \$table->id();
            \$table->string('judul');
            \$table->string('slug')->unique();
            \$table->text('konten');
            \$table->string('foto')->nullable();
            \$table->date('tanggal_publikasi');
            \$table->boolean('is_highlight')->default(false);
            \$table->timestamps();
    ",
    'create_fasilitas_table.php' => "
            \$table->id();
            \$table->string('nama_fasilitas');
            \$table->text('deskripsi')->nullable();
            \$table->string('foto')->nullable();
            \$table->boolean('is_large')->default(false);
            \$table->timestamps();
    ",
    'create_ekstrakurikulers_table.php' => "
            \$table->id();
            \$table->string('nama_ekstrakurikuler');
            \$table->text('deskripsi')->nullable();
            \$table->string('foto')->nullable();
            \$table->timestamps();
    ",
    'create_prestasis_table.php' => "
            \$table->id();
            \$table->string('judul_prestasi');
            \$table->string('tahun');
            \$table->text('deskripsi');
            \$table->string('foto')->nullable();
            \$table->timestamps();
    ",
    'create_galeris_table.php' => "
            \$table->id();
            \$table->string('judul');
            \$table->string('foto');
            \$table->timestamps();
    ",
    'create_testimonis_table.php' => "
            \$table->id();
            \$table->string('nama');
            \$table->string('peran'); 
            \$table->text('konten');
            \$table->timestamps();
    ",
    'create_faqs_table.php' => "
            \$table->id();
            \$table->string('pertanyaan');
            \$table->text('jawaban');
            \$table->timestamps();
    "
];

$files = scandir($migrationsDir);
foreach ($files as $file) {
    foreach ($migrations as $key => $schema) {
        if (strpos($file, $key) !== false) {
            $content = file_get_contents($migrationsDir . $file);
            $content = preg_replace('/\\$table->id\(\);.*?\\$table->timestamps\(\);/s', trim($schema), $content);
            file_put_contents($migrationsDir . $file, $content);
            echo "Updated Migration: " . $file . "\n";
        }
    }
}

$modelsDir = __DIR__ . '/app/Models/';
$models = ['Berita', 'Fasilitas', 'Ekstrakurikuler', 'Prestasi', 'Galeri', 'Testimoni', 'Faq'];
foreach ($models as $model) {
    $content = "<?php\n\nnamespace App\Models;\n\nuse Illuminate\Database\Eloquent\Factories\HasFactory;\nuse Illuminate\Database\Eloquent\Model;\n\nclass $model extends Model\n{\n    use HasFactory;\n    protected \$guarded = ['id'];\n}\n";
    file_put_contents($modelsDir . $model . '.php', $content);
    echo "Updated Model: " . $model . "\n";
}
