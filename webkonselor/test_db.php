<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$student = App\Models\Student::where('nim', 'IF-001')->first();
echo "Nama: " . $student->name . "\n";
echo "Level: " . $student->mental_level . "\n";
echo "Label: " . $student->mental_label . "\n";
echo "Red Flag: " . $student->mental_red_flag . "\n";
