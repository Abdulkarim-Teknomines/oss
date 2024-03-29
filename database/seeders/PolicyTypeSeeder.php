<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PolicyType;
class PolicyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PolicyType::create(['name' => 'Family']);
        PolicyType::create(['name' => 'Individual']);
        PolicyType::create(['name' => 'Other']);
    }
}
