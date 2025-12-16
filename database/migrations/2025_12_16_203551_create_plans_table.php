<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Free, Starter, Professional, Enterprise
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            

            $table->decimal('price_monthly', 10, 2)->default(0);
            $table->decimal('price_yearly', 10, 2)->default(0);
            
            $table->integer('max_users')->nullable(); 
            $table->integer('max_entities')->nullable();
            $table->integer('max_proposals')->nullable();
            $table->integer('max_orders')->nullable();
            $table->integer('max_storage_mb')->nullable();
            
            $table->json('features')->nullable();
            
            $table->integer('trial_days')->default(14);
            
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->integer('sort_order')->default(0);
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('plans');
    }
};
