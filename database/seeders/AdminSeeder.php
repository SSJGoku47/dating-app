<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();

        //Dummy admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'is_admin' => true,
            'is_active' => true,
            'phone' => '12345678',
            'dob' => '',
            'password' => Hash::make('password'), 
            'role_id' => $adminRole->id,         
        ]);
    }
}   
