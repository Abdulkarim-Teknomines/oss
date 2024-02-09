<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Policymode;

class PolicyModeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Policymode::create(['name' => 'Monthly']);
        Policymode::create(['name' => 'Quarterly']);
        Policymode::create(['name' => 'Half Yearly']);
        Policymode::create(['name' => 'Yearly']);
        Policymode::create(['name' => 'Single']);
    }
}
