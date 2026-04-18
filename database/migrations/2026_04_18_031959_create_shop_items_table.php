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
        Schema::create('shop_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('emoji', 16);
            $table->string('badge_label', 24)->nullable();
            $table->string('badge_class', 8)->nullable();
            $table->unsignedInteger('price');
            $table->string('currency', 24)->default('Robux');
            $table->unsignedTinyInteger('stars')->default(5);
            $table->string('gradient_from', 16);
            $table->string('gradient_to', 16);
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
        Schema::dropIfExists('shop_items');
    }
};
