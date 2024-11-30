<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Goal;

class GoalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $goals = [
            'A long-term relationship',
            'A Life Partner',
            'Fun, Casual dates',
            'Intimacy, Without commitment',
            'Marriage',
            'Ethical non-monogamy',
        ];

        foreach ($goals as $goal) {
            Goal::create(['name' => $goal]);
        }
    }
}
