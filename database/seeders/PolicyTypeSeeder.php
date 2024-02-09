<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Policytype;

class PolicyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Policytype::create(['name' => 'Family']);
        Policytype::create(['name' => 'Individual']);
        Policytype::create(['name' => 'Other']);
    }
}
