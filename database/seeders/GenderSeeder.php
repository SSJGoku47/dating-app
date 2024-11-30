<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gender;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genders = ['Male', 'Female', 'Non-Binary', 'Other'];

        foreach ($genders as $gender) {
            Gender::create(['name' => $gender]);
        }
    }
}
