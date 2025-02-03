<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'id' => Str::uuid(),
            'name' => 'Admin User',
            'email' => 'admin@pugc.com',
            'password' => Hash::make('Admin@123'),
            'role' => 'admin',
        ]);

        User::create([
            'id' => Str::uuid(),
            'name' => 'Student User',
            'email' => 'student@pugc.com',
            'password' => Hash::make('Student@123'),
            'role' => 'student',
        ]);
    }
}
