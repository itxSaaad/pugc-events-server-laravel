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
            'id' => (string) Str::uuid(),
            'name' => 'Admin User',
            'email' => 'admin@pugc.edu.pk',
            'password' => Hash::make('Admin@123'),
            'role' => 'admin',
        ]);

        User::create([
            'id' => (string) Str::uuid(),
            'name' => 'Student User',
            'email' => 'student@pugc.edu.pk',
            'password' => Hash::make('Student@123'),
            'role' => 'student',
        ]);

        User::create([
            'id' => (string) Str::uuid(),
            'name' => 'Test User',
            'email' => 'test@pugc.edu.pk',
            'password' => Hash::make('Test@123'),
            'role' => 'student',
        ]);
    }
}
