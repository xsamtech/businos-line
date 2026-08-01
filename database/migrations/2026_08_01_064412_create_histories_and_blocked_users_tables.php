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
        Schema::create('histories', function (Blueprint $table) {
            $table->id();
            $table->text('word')->nullable();
            $table->string('entity', 40)->nullable()->index();
            $table->unsignedBigInteger('entity_id')->nullable();
            $table->string('action', 30)->nullable()->index();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('blocked_users', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->longText('complaint')->nullable();
            $table->boolean('is_unlocked')->default(false)->index();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('about_title_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blocked_users');
        Schema::dropIfExists('histories');
    }
};
