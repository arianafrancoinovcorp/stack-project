<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tenants', function (Blueprint $table) {
            if (!Schema::hasColumn('tenants', 'onboarding_completed')) {
                $table->boolean('onboarding_completed')->default(false)->after('status');
                $table->json('onboarding_steps')->nullable()->after('onboarding_completed');
            }
            
            // Branding fields
            if (!Schema::hasColumn('tenants', 'logo')) {
                $table->string('logo')->nullable()->after('slug');
                $table->string('primary_color')->default('#3B82F6')->after('logo');
                $table->string('secondary_color')->default('#1E40AF')->after('primary_color');
            }
        });
    }

    public function down()
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->dropColumn(['onboarding_completed', 'onboarding_steps', 'logo', 'primary_color', 'secondary_color']);
        });
    }
};