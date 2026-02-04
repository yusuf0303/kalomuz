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
        Schema::create('contest_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
            $table->integer('points')->default(0);
            $table->integer('referrals_count')->default(0);
            $table->boolean('has_joined_bonus')->default(false);
            $table->boolean('instagram_claimed')->default(false);
            $table->timestamp('last_friday_quiz')->nullable();
            $table->timestamps();
        });

        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('referrer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('referred_id')->constrained('users')->onDelete('cascade');
            $table->boolean('is_verified')->default(false);
            $table->timestamps();

            $table->unique(['referrer_id', 'referred_id']);
        });

        Schema::create('quiz_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('quiz_id')->nullable();
            $table->string('quiz_type')->default('custom'); // 'custom' or 'friday'
            $table->integer('score');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_history');
        Schema::dropIfExists('referrals');
        Schema::dropIfExists('contest_users');
    }
};
