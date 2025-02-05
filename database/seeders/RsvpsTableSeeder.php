<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Rsvp;
use App\Models\Event;
use App\Models\User;

class RsvpsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $user1 = User::where('email', 'student@pugc.edu.pk')->first();
        $user2 = User::where('email', 'student@pugc.com')->first();

        $event1 = Event::where('title', 'Tech Talk: Laravel Basics')->first();
        $event2 = Event::where('title', 'Tech Talk: Laravel Advanced')->first();

        Rsvp::create([
            'id' => Str::uuid(),
            'user_id' => $user1->id,
            'event_id' => $event1->id,
            'status' => true
        ]);

        Rsvp::create([
            'id' => Str::uuid(),
            'user_id' => $user1->id,
            'event_id' => $event2->id,
            'status' => true
        ]);

        Rsvp::create([
            'id' => Str::uuid(),
            'user_id' => $user2->id,
            'event_id' => $event2->id,
            'status' => true
        ]);
    }
}
