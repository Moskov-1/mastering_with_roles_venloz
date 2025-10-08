<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            "name"=> "superadmin",
            "email"=> "superadmin@gmail.com",
            "password" => bcrypt(env("DEFAULT_PASSWORD", '12345678')),
        ])->assignRole('super_admin');

        
        User::create([
            "name"=> "admin",
            "email"=> "admin@gmail.com",
            "password" => bcrypt(env("DEFAULT_PASSWORD", '12345678')),
        ])->assignRole('admin');

        User::create([
            "name"=> "user",
            "email"=> "user@gmail.com",
            "password" => bcrypt(env("DEFAULT_PASSWORD", '12345678')),
        ])->assignRole('user');
    }
}
