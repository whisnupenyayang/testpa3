<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CounselorController;

Route::get('/', function () {
    return redirect('/konselor/dashboard');
});

Route::get('/konselor/dashboard', [CounselorController::class, 'index'])->name('counselor.dashboard');
Route::get('/konselor/prioritas', [CounselorController::class, 'prioritas'])->name('counselor.prioritas');
Route::get('/konselor/semua-mahasiswa', [CounselorController::class, 'semuaMahasiswa'])->name('counselor.semua-mahasiswa');
Route::post('/konselor/update-status/{nim}', [CounselorController::class, 'updateStatus'])->name('counselor.update-status');
Route::get('/konselor/chart-data', [CounselorController::class, 'getChartData'])->name('counselor.chart-data');
Route::get('/konselor/top-students', [CounselorController::class, 'getTopStudents'])->name('counselor.top-students');
Route::get('/konselor/detail/{nim}', [CounselorController::class, 'showDetail'])->name('counselor.detail');
Route::post('/konselor/scan', [CounselorController::class, 'scanLevel3'])->name('counselor.scan');
Route::post('/konselor/summary', [CounselorController::class, 'getSummary'])->name('counselor.summary');

// --- FITUR EDUKASI ---
use App\Http\Controllers\EducationController;
Route::prefix('konselor/edukasi')->name('counselor.education.')->group(function () {
    Route::get('/', [EducationController::class, 'index'])->name('index');
    
    // Modules
    Route::get('/modules', [EducationController::class, 'moduleIndex'])->name('modules.index');
    Route::get('/modules/create', [EducationController::class, 'moduleCreate'])->name('modules.create');
    Route::post('/modules', [EducationController::class, 'moduleStore'])->name('modules.store');
    Route::get('/modules/{module}/edit', [EducationController::class, 'moduleEdit'])->name('modules.edit');
    Route::put('/modules/{module}', [EducationController::class, 'moduleUpdate'])->name('modules.update');
    Route::delete('/modules/{module}', [EducationController::class, 'moduleDestroy'])->name('modules.destroy');

    // Challenges
    Route::get('/challenges', [EducationController::class, 'challengeIndex'])->name('challenges.index');
    Route::get('/challenges/create', [EducationController::class, 'challengeCreate'])->name('challenges.create');
    Route::post('/challenges', [EducationController::class, 'challengeStore'])->name('challenges.store');
    Route::get('/challenges/{challenge}/edit', [EducationController::class, 'challengeEdit'])->name('challenges.edit');
    Route::put('/challenges/{challenge}', [EducationController::class, 'challengeUpdate'])->name('challenges.update');
    Route::delete('/challenges/{challenge}', [EducationController::class, 'challengeDestroy'])->name('challenges.destroy');
});

// --- DEBUG ROUTE UNTUK PENGETESAN (HAPUS SETELAH DIGUNAKAN) ---
Route::get('/debug/seed-if001', function () {
    $nim = 'IF-001';
    
    // 1. Buat/Update Mahasiswa
    \App\Models\Student::updateOrCreate(['nim' => $nim], [
        'name' => 'Mahasiswa Test Predictive',
        'gender' => 'Laki-laki',
        'prodi' => 'IF',
        'password' => \Illuminate\Support\Facades\Hash::make('password'),
        'mental_level' => null, 
    ]);

    // 2. Buat Check-in Negatif SEBANYAK 14 HARI (Untuk memicu Predictive Level 3)
    // Kita hapus data lama dulu agar bersih
    \App\Models\DailyCheckin::where('nim', $nim)->delete();
    \App\Models\JournalText::where('nim', $nim)->delete();

    for ($i = 13; $i >= 0; $i--) {
        $date = now()->subDays($i);
        \App\Models\DailyCheckin::create([
            'nim' => $nim,
            'mood_id' => 2, // Sedih
            'feeling_id' => 11, // Cemas
            'created_at' => $date,
            'updated_at' => $date
        ]);
    }

    // 3. Buat Jurnal AMAN (Agar terbukti Level 3 berasal dari TREN, bukan dari teks)
    \App\Models\JournalText::create([
        'nim' => $nim,
        'description' => 'Hari ini saya hanya makan nasi goreng di kantin. Suasananya biasa saja.',
        'created_at' => now(),
    ]);

    // 4. Jalankan AI Klasifikasi
    \App\Http\Controllers\CounselorController::classifyAndSave($nim);

    return "Data dummy if001 (14 Hari Negatif) berhasil dibuat. Jurnal diset 'Aman'. Silakan cek Dashboard Konselor.";
});