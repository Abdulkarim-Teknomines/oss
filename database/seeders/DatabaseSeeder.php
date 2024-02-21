<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            BloodGroupSeeder::class,
            InsurancePolicyTypeSeeder::class,
            MutualFundTypeSeeder::class,
            PolicyModeSeeder::class,
            DepartmentSeeder::class,
            PolicyTypeSeeder::class,
            PptSeeder::class,
            VehicleCategorySeeder::class,
            CountrySateCitySeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            SuperAdminSeeder::class,
        ]);
    }
}