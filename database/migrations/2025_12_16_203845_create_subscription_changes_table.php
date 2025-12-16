<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('subscription_changes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subscription_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            $table->string('action'); // created, upgraded, downgraded, canceled, renewed, expired
            $table->foreignId('from_plan_id')->nullable()->constrained('plans');
            $table->foreignId('to_plan_id')->nullable()->constrained('plans');
            
            $table->decimal('amount', 10, 2)->nullable();
            $table->text('notes')->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('subscription_changes');
    }
};
