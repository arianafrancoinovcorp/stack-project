<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        $tables = [
            'entities',
            'contacts',
            'contact_functions',
            'items',
            'proposals',
            'proposal_lines',
            'orders',
            'order_lines',
            'activities',
            'calendar_types',
            'calendar_actions',
            'calendar_knowledges',
            'types'
        ];

        foreach ($tables as $table) {
            // checks if table exists
            if (Schema::hasTable($table)) {
                // adds if it doesnt exist
                if (!Schema::hasColumn($table, 'tenant_id')) {
                    Schema::table($table, function (Blueprint $table) {
                        $table->foreignId('tenant_id')->after('id')->nullable()->constrained()->onDelete('cascade');
                        $table->index('tenant_id');
                    });
                }
            }
        }
    }

    public function down()
    {
        $tables = [
            'entities', 'contacts', 'contact_functions', 'items',
            'proposals', 'proposal_lines', 'orders', 'order_lines', 'activities',
            'calendar_types', 'calendar_actions', 'calendar_knowledges', 'types'
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table) && Schema::hasColumn($table, 'tenant_id')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->dropForeign(['tenant_id']);
                    $table->dropColumn('tenant_id');
                });
            }
        }
    }
};