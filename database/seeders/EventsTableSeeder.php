<?php

namespace Database\Seeders;

use App\Models\Event;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Event::create([
            'id' => Str::uuid(),
            'title' => 'Tech Talk: Laravel Basics',
            'description' => 'An informative talk on Laravel framework for beginners.',
            'department' => 'Computer Science',
            'date' => '2025-03-01',
            'time' => '14:00:00',
            'location' => 'Room 101',
            'created_by' => '8e827d4a-67c6-4cd1-a4ae-1e0cfcc41d2e'
        ]);

        Event::create([
            'id' => Str::uuid(),
            'title' => 'Tech Talk: Laravel Advanced',
            'description' => 'An informative talk on Laravel framework for advanced users.',
            'department' => 'Computer Science',
            'date' => '2025-03-15',
            'time' => '14:00:00',
            'location' => 'Room 101',
            'created_by' => '8e827d4a-67c6-4cd1-a4ae-1e0cfcc41d2e'
        ]);

        Event::create([
            'id' => Str::uuid(),
            'title' => 'Tech Talk: React Basics',
            'description' => 'An informative talk on React framework for beginners.',
            'department' => 'Computer Science',
            'date' => '2025-04-01',
            'time' => '14:00:00',
            'location' => 'Room 101',
            'created_by' => '8e827d4a-67c6-4cd1-a4ae-1e0cfcc41d2e'
        ]);
    }
}
