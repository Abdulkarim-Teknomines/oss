<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\InsurancePolicyType;

class InsurancePolicyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        InsurancePolicyType::create(['name' => 'Comprehensive']);
        InsurancePolicyType::create(['name' => 'Third Party']);
        InsurancePolicyType::create(['name' => 'Other']);
        InsurancePolicyType::create(['name' => "I Don't Remember"]);
    }
}
