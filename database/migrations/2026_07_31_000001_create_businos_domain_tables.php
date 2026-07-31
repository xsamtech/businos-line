<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $t): void {
            $t->id();
            $t->uuid('uuid')->unique();
            $t->json('role_name');
            $t->json('role_description')->nullable();
            $t->string('slug')->unique();
            $t->timestamps();
            $t->softDeletes();
        });
        Schema::create('role_user', function (Blueprint $t): void {
            $t->id();
            $t->foreignId('role_id')->constrained()->cascadeOnDelete();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->boolean('is_default')->default(false);
            $t->timestamp('assigned_at')->nullable();
            $t->timestamps();
            $t->unique(['role_id', 'user_id']);
        });
        Schema::create('about_subjects', function (Blueprint $t): void {
            $t->id();
            $t->uuid('uuid')->unique();
            $t->json('subject');
            $t->json('description')->nullable();
            $t->string('icon', 45)->nullable();
            $t->boolean('is_available')->default(true);
            $t->timestamps();
            $t->softDeletes();
        });
        Schema::create('about_titles', function (Blueprint $t): void {
            $t->id();
            $t->uuid('uuid')->unique();
            $t->text('title');
            $t->string('icon', 45)->nullable();
            $t->foreignId('about_subject_id')->constrained()->cascadeOnDelete();
            $t->timestamps();
            $t->softDeletes();
        });
        Schema::create('about_contents', function (Blueprint $t): void {
            $t->id();
            $t->uuid('uuid')->unique();
            $t->text('subtitle')->nullable();
            $t->longText('content');
            $t->foreignId('about_title_id')->constrained()->cascadeOnDelete();
            $t->timestamps();
            $t->softDeletes();
        });
        Schema::create('about_dashes', function (Blueprint $t): void {
            $t->id();
            $t->json('dash_content');
            $t->foreignId('belongs_to')->nullable()->constrained('about_dashes')->cascadeOnDelete();
            $t->foreignId('about_content_id')->constrained()->cascadeOnDelete();
            $t->timestamps();
            $t->softDeletes();
        });
        Schema::create('savings', function (Blueprint $t): void {
            $t->id();
            $t->uuid('uuid')->unique();
            $t->boolean('is_saving_sent')->default(false);
            $t->decimal('amount', 12, 2)->default(0);
            $t->string('currency', 3)->default('EUR');
            $t->unsignedTinyInteger('month')->index();
            $t->unsignedSmallInteger('year')->index();
            $t->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $t->timestamps();
            $t->softDeletes();
        });
        Schema::create('gains', function (Blueprint $t): void {
            $t->id();
            $t->uuid('uuid')->unique();
            $t->decimal('amount', 12, 2)->default(0);
            $t->string('currency', 3)->default('EUR');
            $t->boolean('is_general_interest_paid')->default(false);
            $t->boolean('is_gain_paid')->default(false);
            $t->unsignedTinyInteger('month')->index();
            $t->unsignedSmallInteger('year')->index();
            $t->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $t->timestamps();
            $t->softDeletes();
        });
        Schema::create('payments', function (Blueprint $t): void {
            $t->id();
            $t->string('reference', 45)->nullable()->unique();
            $t->string('provider', 45)->nullable();
            $t->string('provider_reference')->nullable()->index();
            $t->text('order_number')->nullable();
            $t->decimal('amount', 12, 2)->nullable();
            $t->decimal('amount_customer', 12, 2)->nullable();
            $t->string('phone', 45)->nullable();
            $t->string('currency', 3)->nullable();
            $t->string('channel', 45)->nullable();
            $t->string('reason', 45)->nullable();
            $t->string('entity', 45)->nullable();
            $t->unsignedBigInteger('entity_id')->nullable();
            $t->integer('type')->nullable();
            $t->integer('status')->nullable()->index();
            $t->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $t->timestamps();
        });
        Schema::create('notifications', function (Blueprint $t): void {
            $t->id();
            $t->string('type', 60)->nullable();
            $t->boolean('is_read')->default(false);
            $t->foreignId('from_user_id')->nullable()->constrained('users')->nullOnDelete();
            $t->foreignId('to_user_id')->nullable()->constrained('users')->nullOnDelete();
            $t->foreignId('payment_id')->nullable()->constrained()->nullOnDelete();
            $t->foreignId('saving_id')->nullable()->constrained()->nullOnDelete();
            $t->foreignId('gain_id')->nullable()->constrained()->nullOnDelete();
            $t->timestamps();
        });
    }

    public function down(): void
    {
        foreach (['notifications', 'payments', 'gains', 'savings', 'about_dashes', 'about_contents', 'about_titles', 'about_subjects', 'role_user', 'roles'] as $table) {
            Schema::dropIfExists($table);
        }
    }
};
