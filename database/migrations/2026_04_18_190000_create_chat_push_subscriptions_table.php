<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_push_subscriptions', function (Blueprint $table): void {
            $table->id();
            $table->string('discord_user_id');
            $table->string('endpoint_hash', 64)->unique();
            $table->text('endpoint');
            $table->text('public_key')->nullable();
            $table->string('auth_token', 255)->nullable();
            $table->string('content_encoding', 20)->nullable();
            $table->string('user_agent', 500)->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamps();

            $table->index('discord_user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_push_subscriptions');
    }
};
