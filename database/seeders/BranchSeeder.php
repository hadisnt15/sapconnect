<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Branch;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Branch::create([
            'branch_name' => 'HO',
            'branch_desc' => 'HEAD OFFICE',
        ]);
        Branch::create([
            'branch_name' => 'BJN',
            'branch_desc' => 'BANJARMASIN',
        ]);
        Branch::create([
            'branch_name' => 'BTL',
            'branch_desc' => 'BATULICIN',
        ]);
        Branch::create([
            'branch_name' => 'SPT',
            'branch_desc' => 'SAMPIT',
        ]);
        Branch::create([
            'branch_name' => 'PLB',
            'branch_desc' => 'PANGKALANBUN',
        ]);
        Branch::create([
            'branch_name' => 'PLK',
            'branch_desc' => 'PALANGKARAYA',
        ]);
    }
}
