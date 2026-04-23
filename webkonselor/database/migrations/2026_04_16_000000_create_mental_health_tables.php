<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->string('nim')->primary();
            $table->string('name');
            $table->string('gender');
            $table->string('password');
            $table->integer('point')->default(0);
            $table->integer('energy_score')->default(100);
            $table->string('phone_number')->nullable();
            $table->timestamps();
        });

        Schema::create('counselors', function (Blueprint $table) {
            $table->string('nip')->primary();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('moods', function (Blueprint $table) {
            $table->bigIncrements('mood_id');
            $table->string('mood_name');
            $table->string('mood_code')->nullable();
            $table->timestamps();
        });

        Schema::create('feelings', function (Blueprint $table) {
            $table->bigIncrements('feeling_id');
            $table->string('feeling_name');
            $table->string('feeling_code')->nullable();
            $table->timestamps();
        });

        Schema::create('modules', function (Blueprint $table) {
            $table->bigIncrements('module_id');
            $table->string('title');
            $table->text('description');
            $table->string('content_url')->nullable();
            $table->string('role')->nullable();
            $table->integer('reward_point')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        Schema::create('challenges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('description');
            $table->integer('total_questions')->default(0);
            $table->integer('reward_point')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        Schema::create('daily_checkins', function (Blueprint $table) {
            $table->bigIncrements('daily_checkin_id');
            $table->string('nim');
            $table->unsignedBigInteger('mood_id');
            $table->unsignedBigInteger('feeling_id');
            $table->timestamps();

            $table->foreign('nim')->references('nim')->on('students')->onDelete('cascade');
            $table->foreign('mood_id')->references('mood_id')->on('moods')->onDelete('cascade');
            $table->foreign('feeling_id')->references('feeling_id')->on('feelings')->onDelete('cascade');
        });

        Schema::create('journal_texts', function (Blueprint $table) {
            $table->bigIncrements('journal_id');
            $table->string('nim');
            $table->text('description');
            $table->timestamps();

            $table->foreign('nim')->references('nim')->on('students')->onDelete('cascade');
        });

        Schema::create('ai_analyses', function (Blueprint $table) {
            $table->bigIncrements('analysis_id');
            $table->unsignedBigInteger('daily_checkin_id')->nullable();
            $table->string('final_label')->nullable();
            $table->text('text_analysis')->nullable();
            $table->timestamps();

            $table->foreign('daily_checkin_id')->references('daily_checkin_id')->on('daily_checkins')->onDelete('cascade');
        });

        Schema::create('notifications', function (Blueprint $table) {
            $table->bigIncrements('notification_id');
            $table->string('nim')->nullable();
            $table->string('nip')->nullable();
            $table->unsignedBigInteger('analysis_id')->nullable();
            $table->string('recipient_role');
            $table->text('message');
            $table->timestamps();

            $table->foreign('nim')->references('nim')->on('students')->onDelete('set null');
            $table->foreign('nip')->references('nip')->on('counselors')->onDelete('set null');
            $table->foreign('analysis_id')->references('analysis_id')->on('ai_analyses')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('ai_analyses');
        Schema::dropIfExists('journal_texts');
        Schema::dropIfExists('daily_checkins');
        Schema::dropIfExists('challenges');
        Schema::dropIfExists('modules');
        Schema::dropIfExists('feelings');
        Schema::dropIfExists('moods');
        Schema::dropIfExists('counselors');
        Schema::dropIfExists('students');
    }
}
;
