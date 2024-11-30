<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hobby;

class HobbySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hobbies = [
            'Traveling', 'Cooking', 'Photography', 'Dance', 'Exercise', 'Gardening', 
            'Reading', 'Music', 'Art', 'Volunteering', 'Hiking', 'Gaming', 
            'Crafting', 'Social Media', 'Yoga', 'Writing', 'Cycling', 'Martial Arts', 
            'Scuba Diving', 'Pet Care', 'Café and bars', 'Running', 'Swimming', 
            'Team Sports', 'Baking', 'Investing', 'Parties', 'Concerts', 
            'Collections', 'TV & Film',
        ];

        foreach ($hobbies as $hobby) {
            Hobby::create(['name' => $hobby]);
        }
    }
}
