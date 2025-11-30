<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vat;

class VatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Vat::create(['name' => 'Standard', 'percentage' => 23, 'status' => 'active']);
        Vat::create(['name' => 'Reduced', 'percentage' => 6, 'status' => 'active']);
        Vat::create(['name' => 'Zero', 'percentage' => 0, 'status' => 'active']);
    }
}
