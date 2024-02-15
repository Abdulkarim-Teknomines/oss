<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CompanyName;
class CompanyNameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CompanyName::create(['name' => 'LIC']);
        CompanyName::create(['name' => 'AEGON']);
        CompanyName::create(['name' => 'DHFL']);
    }
}
