<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MutualFundType;

class MutualFundTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MutualFundType::create(['name' => 'One Time']);
        MutualFundType::create(['name' => 'Sip']);
    }
}
