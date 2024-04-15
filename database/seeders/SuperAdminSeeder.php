<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Creating Super Admin User
        $superAdmin = User::create([
            'name' => 'Hemant', 
            'user_id'=>'USR00001',
            'middle_name'=>'d',
            'surname'=>'Gupta',
            'mobile_number'=>9666456904,
            'emergency_contact_number'=>9666456904,
            'pancard_number'=>'PQDDE8494N',
            'adharcard_number'=>'385712437697',
            'email' => 'hemant@ossdm.com',
            'blood_group_id'=>1,
            'country_id'=>1,
            'state_id'=>8,
            'city_id'=>7,
            'address'=>'Address',
            'birth_date'=>Carbon::create('1985-04-04'),
            'password' => Hash::make('ossdm@123456'),
            'parent_id'=>'0',
            'isActive'=>0       // 0 active // 1 inactive
        ]);
        $superAdmin->assignRole('Super Admin');

        // Creating Admin User
        // $admin = User::create([
        //     'name' => 'Abdul', 
        //     'email' => 'abdul@gmail.com',
        //     'password' => Hash::make('123456')
        // ]);
        // $admin->assignRole('Admin');

        // Creating Product Manager User
        // $productManager = User::create([
        //     'name' => 'Sandeep', 
        //     'email' => 'sandeep@gmail.com',
        //     'password' => Hash::make('123456')]);
        // $productManager->assignRole('Product Manager');
        
        // $productManager = User::create([
        //     'name' => 'Manali', 
        //     'email' => 'manali@gmail.com',
        //     'password' => Hash::make('123456')]);
        //     $productManager->assignRole('Product Manager');
    }
}