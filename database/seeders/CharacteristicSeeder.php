<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Characteristic;

class CharacteristicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $characteristics = [
            'Adventurous', 'Humorous', 'Empathetic', 'Creative', 'Ambitious', 'Open-minded', 
            'Optimistic', 'Active', 'Health-conscious', 'Social', 'Introverted', 
            'Travel-loving', 'Bookworm', 'Foodie', 'Music Enthusiast', 'Animal Lover', 
            'Tech-savvy', 'Family-oriented', 'Romantic', 'Supportive', 'Honest', 
            'Witty', 'Spontaneous', 'Culturally Aware', 'Environmentally Conscious', 
            'Goal-oriented', 'Open to Experiences',
        ];

        foreach ($characteristics as $characteristic) {
            Characteristic::create(['name' => $characteristic]);
        }
    }
}
