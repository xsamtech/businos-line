<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->uuid('uuid')->unique()->nullable()->after('id');
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('phone', 20)->nullable()->unique();
            $table->text('address_1')->nullable();
            $table->text('address_2')->nullable();
            $table->string('country')->default('France');
            $table->string('city')->nullable();
            $table->string('department')->nullable();
            $table->string('status')->default('pending')->index();
            $table->timestamp('phone_verified_at')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->string('last_login_ip', 45)->nullable();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('users', fn (Blueprint $table) => $table->dropColumn(['uuid', 'firstname', 'lastname', 'phone', 'address_1', 'address_2', 'country', 'city', 'department', 'status', 'phone_verified_at', 'last_login_at', 'last_login_ip', 'deleted_at']));
    }
};
