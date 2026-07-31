<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('files', function (Blueprint $t): void {
            $t->id();
            $t->string('file_name')->nullable();
            $t->longText('file_description')->nullable();
            $t->text('file_url')->nullable();
            $t->string('file_type', 30)->default('photo')->index();
            $t->string('mime_type', 100)->nullable();
            $t->unsignedBigInteger('file_size')->nullable();
            $t->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $t->timestamps();
            $t->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
