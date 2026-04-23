<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JournalEntrySeeder extends Seeder
{
    public function run()
    {
        $entries = [
            [
                'nim' => 'MHS-001', 
                'description' => 'Hari ini merasa sangat cemas karena deadline PKM dan tugas akhir (TA) makin dekat, tapi dosen pembimbing susah banget dihubungi.',
                'created_at' => Carbon::now()->subDays(3),
            ],
            [
                'nim' => 'MHS-001', 
                'description' => 'Revisi sistem manajemen dari dosen ternyata banyak banget. Rasanya capek dan ingin menyerah saja ngodingnya.',
                'created_at' => Carbon::now()->subDays(2),
            ],
            [
                'nim' => 'MHS-001', 
                'description' => 'Masih kepikiran soal revisi kemarin. Takut kalau sidang nanti ditanya hal-hal yang belum kupahami soal arsitektur microservices.',
                'created_at' => Carbon::now()->subDays(1),
            ],
            [
                'nim' => 'MHS-002', 
                'description' => 'Akhirnya proposal ACC! Lega banget rasanya bisa tidur nyenyak malam ini tanpa kepikiran revisi.',
                'created_at' => Carbon::now(),
            ]
        ];

        foreach ($entries as $entry) {
            \App\Models\JournalText::create($entry);
        }
    }
}