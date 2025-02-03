<?php

namespace Database\Seeders;

use App\Models\Rsvp;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RsvpsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Rsvp::create([
            'id' => Str::uuid(),
            'event_id' => Str::uuid(),
            'user_id' => Str::uuid(),
            'status' => true,
        ]);
    }
}
