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
        Schema::create('discord_gallery_media', function (Blueprint $table) {
            $table->id();
            $table->string('discord_attachment_id')->unique();
            $table->string('source_message_id')->index();
            $table->string('source_channel_id')->index();
            $table->string('title');
            $table->text('media_url');
            $table->string('media_type', 16)->index();
            $table->string('mime_type')->nullable();
            $table->unsignedInteger('width')->nullable();
            $table->unsignedInteger('height')->nullable();
            $table->string('author_name')->nullable();
            $table->timestamp('posted_at')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discord_gallery_media');
    }
};
