<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VehicleCategory
;
class VehicleCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VehicleCategory::create(['name' => 'Two Wheeler']);
        VehicleCategory::create(['name' => 'Three Wheeler']);
        VehicleCategory::create(['name' => 'Four Wheeler']);
        VehicleCategory::create(['name' => 'Commercial']);
    }
}
