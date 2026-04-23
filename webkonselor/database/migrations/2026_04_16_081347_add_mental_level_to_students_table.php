<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            // Level hasil klasifikasi IndoBERT: 1, 2, atau 3
            $table->unsignedTinyInteger('mental_level')->nullable()->after('point');
            // Label teks level (Level 1 / 2 / 3)
            $table->string('mental_label')->nullable()->after('mental_level');
            // Confidence score dari model (0-100)
            $table->float('mental_confidence')->nullable()->after('mental_label');
            // Red flag yang ditemukan (jika ada)
            $table->string('mental_red_flag')->nullable()->after('mental_confidence');
            // Kapan terakhir kali di-scan
            $table->timestamp('mental_scanned_at')->nullable()->after('mental_red_flag');
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn([
                'mental_level',
                'mental_label',
                'mental_confidence',
                'mental_red_flag',
                'mental_scanned_at',
            ]);
        });
    }
};
