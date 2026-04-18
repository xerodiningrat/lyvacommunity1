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
        Schema::table('chat_messages', function (Blueprint $table) {
            $table->string('message_type', 24)->default('message')->after('id');
            $table->string('avatar_emoji', 16)->nullable()->after('avatar_url');
            $table->string('color_class', 24)->nullable()->after('avatar_emoji');
            $table->string('role_key', 24)->nullable()->after('color_class');
            $table->json('reactions')->nullable()->after('message');
            $table->string('reply_name')->nullable()->after('reactions');
            $table->text('reply_text')->nullable()->after('reply_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chat_messages', function (Blueprint $table) {
            $table->dropColumn([
                'message_type',
                'avatar_emoji',
                'color_class',
                'role_key',
                'reactions',
                'reply_name',
                'reply_text',
            ]);
        });
    }
};
