<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Division;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Division::factory()->create([
            'div_name' => 'SPR',
            'div_desc' => 'Sparepart',
        ]);

        Division::factory()->create([
            'div_name' => 'LUB RTL',
            'div_desc' => 'Lubricant Retail',
        ]);
        
        Division::factory()->create([
            'div_name' => 'LUB IDS',
            'div_desc' => 'Lubricant Industry',
        ]);
    }
}
