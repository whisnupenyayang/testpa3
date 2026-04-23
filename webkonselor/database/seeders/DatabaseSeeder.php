<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'nip' => 'DOS-001',
            'name' => 'Dr. Sarah (Konselor Utama)',
            'email' => 'sarah@konselor.com',
            'password' => Hash::make('password'),
        ]);

        $students = [
            [
                'nim' => 'MHS-001',
                'name' => 'Whisnu',
                'gender' => 'Laki-laki',
                'prodi' => 'TRPL',
                'password' => Hash::make('password'),
                'point' => 150,
            ],
            [
                'nim' => 'MHS-002',
                'name' => 'Budi',
                'gender' => 'Laki-laki',
                'prodi' => 'TRPL',
                'password' => Hash::make('password'),
                'point' => 0,
            ],
            [
                'nim' => 'MHS-003',
                'name' => 'Siti',
                'gender' => 'Perempuan',
                'prodi' => 'SI',
                'password' => Hash::make('password'),
                'point' => 50,
            ],
        ];

        foreach ($students as $student) {
            \App\Models\Student::create($student);
        }

        $this->call([
            MoodFeelingSeeder::class,
        ]);

        \App\Models\Module::create([
            'title' => 'Teknik Napas 4-7-8',
            'description' => 'Cara cepat meredakan cemas.',
            'content_url' => null,
            'role' => 'user',
            'reward_point' => 50,
            'status' => true,
        ]);

        \App\Models\Challenge::create([
            'title' => 'Kenali Emosimu',
            'description' => 'Kuis interaktif tentang manajemen stres.',
            'total_questions' => 10,
            'reward_point' => 100,
            'status' => true,
        ]);

        // Using names or finding models is better for NoSQL, 
        // but to keep it simple we just create checkins.
        $checkins = [
            [
                'nim'        => 'MHS-001',
                'mood_id'    => 6, // Takut
                'feeling_id' => 21, // Cemas
                'created_at' => now()->subDays(2),
            ],
            [
                'nim'        => 'MHS-001',
                'mood_id'    => 6, // Takut
                'feeling_id' => 24, // Gelisah
                'created_at' => now()->subDays(1),
            ],
            [
                'nim'        => 'MHS-001',
                'mood_id'    => 5, // Sedih
                'feeling_id' => 17, // Pilu
                'created_at' => now(),
            ],
        ];

        foreach ($checkins as $c) {
            \App\Models\DailyCheckin::create($c);
        }

        $this->call([
            JournalEntrySeeder::class,
        ]);

    }
}
