<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Companyname;

class CompanynameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Companyname::create(['name' => 'LIC']);
        Companyname::create(['name' => 'AEGON']);
        Companyname::create(['name' => 'DHFL']);
    }
}
