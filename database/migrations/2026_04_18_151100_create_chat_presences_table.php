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
        Schema::create('chat_presences', function (Blueprint $table) {
            $table->id();
            $table->string('discord_user_id', 64)->unique();
            $table->string('display_name');
            $table->string('username');
            $table->string('avatar_url')->nullable();
            $table->string('avatar_emoji', 16)->nullable();
            $table->string('color_class', 24)->nullable();
            $table->string('role_key', 24)->nullable();
            $table->timestamp('last_seen_at')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_presences');
    }
};
