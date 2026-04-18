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
        Schema::create('leaderboard_entries', function (Blueprint $table) {
            $table->id();
            $table->string('player_name');
            $table->string('player_slug')->unique();
            $table->string('avatar_emoji', 16)->default('🎮');
            $table->string('headline')->nullable();
            $table->unsignedInteger('points')->default(0)->index();
            $table->unsignedInteger('wins')->default(0);
            $table->unsignedInteger('events_joined')->default(0);
            $table->string('season', 32)->default('Season 1')->index();
            $table->string('source', 24)->default('manual')->index();
            $table->string('source_reference')->nullable()->index();
            $table->unsignedSmallInteger('sort_order')->default(0)->index();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaderboard_entries');
    }
};
