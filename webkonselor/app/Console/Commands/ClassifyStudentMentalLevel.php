<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Student;
use App\Models\JournalText;
use App\Models\DailyCheckin;
use Carbon\Carbon;

class ClassifyStudentMentalLevel extends Command
{
    protected $signature   = 'classify:students
                                {--force : Paksa scan semua mahasiswa meskipun tidak ada jurnal baru}';

    protected $description = 'Klasifikasi level mental semua mahasiswa menggunakan IndoBERT. '
                           . 'Hanya memproses mahasiswa yang punya jurnal baru sejak scan terakhir.';

    public function handle(): int
    {
        $now = Carbon::now();
        $this->info("[{$now->format('Y-m-d H:i:s')}] Memulai klasifikasi level mental mahasiswa...");

        // Ambil mahasiswa yang memiliki minimal 1 jurnal
        $students = Student::with(['journalTexts' => function ($q) {
            $q->orderBy('created_at', 'desc');
        }])->get()->filter(fn($s) => $s->journalTexts->isNotEmpty());

        if ($students->isEmpty()) {
            $this->warn('Tidak ada mahasiswa dengan jurnal. Selesai.');
            return Command::SUCCESS;
        }

        $force   = $this->option('force');
        $updated = 0;
        $skipped = 0;
        $failed  = 0;

        $bar = $this->output->createProgressBar($students->count());
        $bar->start();

        foreach ($students as $student) {
            // Cek apakah ada jurnal baru atau scan terakhir sudah lebih dari 24 jam (opsional, tapi idealnya cek ada data baru)
            if (!$force && $student->mental_scanned_at) {
                $hasNewData = $student->journalTexts
                    ->where('created_at', '>', $student->mental_scanned_at)
                    ->isNotEmpty();

                // Juga cek apakah ada checkin baru setelah scan terakhir
                $hasNewCheckin = DailyCheckin::where('nim', $student->nim)
                    ->where('created_at', '>', $student->mental_scanned_at)
                    ->exists();

                if (!$hasNewData && !$hasNewCheckin) {
                    $skipped++;
                    $bar->advance();
                    continue;
                }
            }

            // --- Logika Sinkron dengan CounselorController ---
            
            // 1. Ambil histori mood & feeling 14 hari terakhir
            $historyInput = DailyCheckin::with(['mood', 'feeling'])
                ->where('nim', $student->nim)
                ->orderBy('created_at', 'desc')
                ->take(14)
                ->get()
                ->map(function($checkin) {
                    return [
                        'mood'    => $checkin->mood->mood_name    ?? 'Biasa',
                        'feeling' => $checkin->feeling->feeling_name ?? 'Kalem'
                    ];
                })
                ->toArray();

            // 2. Info jurnal terakhir & teks gabungan
            $lastJournal = $student->journalTexts->first();
            $daysSinceLastJournal = $lastJournal ? now()->diffInDays($lastJournal->created_at) : 99;
            $allText = $student->journalTexts->pluck('description')->implode(' ');

            try {
                $response = Http::timeout(30)->post('http://127.0.0.1:8001/api/classify', [
                    'nim'                     => $student->nim,
                    'text'                    => $allText,
                    'mood_history'            => $historyInput,
                    'days_since_last_journal' => (int)$daysSinceLastJournal,
                ]);

                if ($response->successful()) {
                    $data = $response->json('data');

                    $student->update([
                        'mental_level'      => $data['level']      ?? null,
                        'mental_label'      => $data['label']      ?? null,
                        'mental_confidence' => $data['confidence'] ?? null,
                        'mental_red_flag'   => $data['red_flag']   ?? null,
                        'mental_scanned_at' => now(),
                    ]);

                    $updated++;
                } else {
                    $failed++;
                }
            } catch (\Exception $e) {
                $failed++;
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        $this->info("✅ Selesai: {$updated} diperbarui, {$skipped} dilewati (tidak ada data baru), {$failed} gagal.");

        return Command::SUCCESS;
    }
}
