<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ethnicity;

class EthnicitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $ethnicities = [
            'Asian',
            'Black or African American',
            'Hispanic or Latino',
            'White',
            'Native American or Alaska Native',
            'Middle Eastern or North African',
            'Pacific Islander or Native Hawaiian',
            'Mixed or Multi-Ethnic',
            'Other'
        ];

        foreach ($ethnicities as $ethnicity) {
            Ethnicity::create(['name' => $ethnicity]);
        }
    }
}
