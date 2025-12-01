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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->time('time');
            $table->integer('duration');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('knowledge_id')->nullable()->constrained('calendar_knowledges')->onDelete('set null');
            $table->foreignId('entity_id')->nullable()->constrained('entities')->onDelete('set null');
            $table->foreignId('type_id')->nullable()->constrained('calendar_types')->onDelete('set null');
            $table->foreignId('action_id')->nullable()->constrained('calendar_actions')->onDelete('set null');
            $table->text('description')->nullable();
            $table->enum('status', ['pending','done'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
