<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $adminId = User::where('role', 'admin')->first()->id;

        Event::create([
            'id' => Str::uuid(),
            'title' => 'Tech Talk: Laravel Basics',
            'description' => 'An informative talk on Laravel framework for beginners.',
            'department' => 'Computer Science',
            'date' => '2025-03-01',
            'time' => '14:00:00',
            'location' => 'Room 101',
            'created_by' => $adminId
        ]);

        Event::create([
            'id' => Str::uuid(),
            'title' => 'Tech Talk: Laravel Advanced',
            'description' => 'An informative talk on Laravel framework for advanced users.',
            'department' => 'Computer Science',
            'date' => '2025-03-15',
            'time' => '14:00:00',
            'location' => 'Room 101',
            'created_by' => $adminId
        ]);

        Event::create([
            'id' => Str::uuid(),
            'title' => 'Tech Talk: React Basics',
            'description' => 'An informative talk on React framework for beginners.',
            'department' => 'Computer Science',
            'date' => '2025-04-01',
            'time' => '14:00:00',
            'location' => 'Room 101',
            'created_by' => $adminId
        ]);
    }
}
