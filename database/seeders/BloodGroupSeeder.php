<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Bloodgroup;

class BloodGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $blood_group = [
            // 'create-role',
            'A+',
            'A-',
            'B+',
            'B-',
            'O+',
            'O-',
            'AB+',
            'AB-',
            // 'create-product',
            // 'edit-product',
            // 'delete-product'
         ];
 
          // Looping and Inserting Array's Permissions into Permission Table
         foreach ($blood_group as $group) {
            Bloodgroup::create(['name' => $group]);
          }
    }
}
