<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ContactFunction;

class ContactFunctionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $functions = [
            'CEO',
            'CFO',
            'Manager',
            'Assistant',
            'Sales',
            'Support',
            'Technician',
            'Administration',
            'Marketing',
            'HR'
        ];

        foreach ($functions as $func) {
            ContactFunction::create([
                'name' => $func,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
