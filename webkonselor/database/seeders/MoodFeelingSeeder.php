<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MoodFeelingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Seed Moods (7 moods)
        $moods = [
            'Senang',    // 1
            'Antusias',  // 2
            'Netral',    // 3
            'Terkejut',  // 4
            'Sedih',     // 5
            'Takut',     // 6
            'Marah',     // 7
        ];

        foreach ($moods as $idx => $mood) {
            \App\Models\Mood::create([
                'mood_id'   => $idx + 1,
                'mood_name' => $mood,
                'mood_code' => strtoupper($mood),
            ]);
        }

        // 2. Seed Feelings (28 feelings)
        $feelings = [
            // Kelompok Senang (1-8)
            'Gembira',    // 1
            'Bangga',     // 2
            'Bersyukur',  // 3
            'Ceria',      // 4
            'Semangat',   // 5
            'Energik',    // 6
            'Kagum',      // 7
            'Bergairah',  // 8
            // Kelompok Netral (9-12)
            'Biasa Saja', // 9
            'Stabil',     // 10
            'Tenang',     // 11
            'Santai',     // 12
            // Kelompok Terkejut (13-16)
            'Tercengang', // 13
            'Penasaran',  // 14
            'Tertarik',   // 15
            'Gelagapan',  // 16
            // Kelompok Sedih (17-20)
            'Pilu',       // 17
            'Depresi',    // 18
            'Kesepian',   // 19
            'Putus Asa',  // 20
            // Kelompok Takut (21-24)
            'Cemas',      // 21
            'Khawatir',   // 22
            'Panik',      // 23
            'Gelisah',    // 24
            // Kelompok Marah (25-28)
            'Kesal',      // 25
            'Jengkel',    // 26
            'Benci',      // 27
            'Kecewa',     // 28
        ];

        foreach ($feelings as $idx => $feeling) {
            \App\Models\Feeling::create([
                'feeling_id'   => $idx + 1,
                'feeling_name' => $feeling,
                'feeling_code' => strtoupper(str_replace(' ', '_', $feeling)),
            ]);
        }
    }
}
