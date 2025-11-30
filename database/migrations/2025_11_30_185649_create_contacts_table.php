<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entity_id')->constrained('entities')->cascadeOnDelete();
            $table->string('first_name');
            $table->string('last_name');
            $table->foreignId('function_id')->nullable()->constrained('contact_functions')->nullOnDelete();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->boolean('rgpd_consent')->default(false);
            $table->text('notes')->nullable();
            $table->enum('status', ['active','inactive'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
