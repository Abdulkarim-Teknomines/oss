<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ppt;
class PptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ppt::create(['name' => 'Regular']);
        Ppt::create(['name' => 'LPPT']);
        Ppt::create(['name' => 'Single']);
    }
}
