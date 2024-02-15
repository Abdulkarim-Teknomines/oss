<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PolicyMode;

class PolicyModeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PolicyMode::create(['name' => 'Monthly']);
        PolicyMode::create(['name' => 'Quarterly']);
        PolicyMode::create(['name' => 'Half Yearly']);
        PolicyMode::create(['name' => 'Yearly']);
        PolicyMode::create(['name' => 'Single']);
    }
}
