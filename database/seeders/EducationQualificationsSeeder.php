<?php

namespace Database\Seeders;

use App\Models\EducationLevel;
use Illuminate\Database\Seeder;
use App\Models\EducationQualification;

class EducationQualificationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $educationLevels = [
            'No Formal Education',
            'High School Diploma',
            'Some College',
            'Associate Degree',
            'Bachelor\'s Degree',
            'Master\'s Degree',
            'Doctorate (PhD)',
            'Professional Degree (e.g., JD, MD)',
            'Trade School Certification',
            'Vocational Training',
        ];

        foreach ($educationLevels as $level) {
            EducationQualification::create(['name' => $level]);
        }
    }
}
