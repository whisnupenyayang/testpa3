<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
|--------------------------------------------------------------------------
| Jadwal Klasifikasi Level Mental Mahasiswa
|--------------------------------------------------------------------------
| Berjalan setiap 1 jam, hanya pada jam aktif 05:00–21:00 WIB.
| Hanya memproses mahasiswa yang punya jurnal baru sejak scan terakhir.
|
| Cara menjalankan scheduler:
|   php artisan schedule:work   (development, berjalan terus di terminal)
|   php artisan schedule:run    (cukup 1x, untuk cron production)
|
| Cron untuk production (tambahkan ke Task Scheduler Windows / crontab Linux):
|   * * * * * php /path/to/artisan schedule:run >> /dev/null 2>&1
|
*/
Schedule::command('classify:students')
    ->hourly()
    ->between('05:00', '23:00')
    ->timezone('Asia/Jakarta')
    ->withoutOverlapping()            // tidak jalan bersamaan jika command sebelumnya belum selesai
    ->runInBackground()               // tidak memblok proses lain
    ->appendOutputTo(storage_path('logs/classify-scheduler.log'));
