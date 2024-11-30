<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Seeder;

class QuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $questions = [
            [
                'title' => 'What’s your ideal way to spend a weekend?',
                'option_1' => 'Relaxing at home with a book or movie',
                'option_2' => 'Exploring new places and traveling',
                'option_3' => 'Going out for parties or events',
                'option_4' => 'Spending time with family and friends',
            ],
            [
                'title' => 'What’s your favorite type of vacation?',
                'option_1' => 'Beach and sunbathing',
                'option_2' => 'Adventure and hiking',
                'option_3' => 'City exploration and sightseeing',
                'option_4' => 'Cultural and historical tours',
            ],
            [
                'title' => 'How do you usually spend your free evenings?',
                'option_1' => 'Cooking a nice meal at home',
                'option_2' => 'Working out or staying active',
                'option_3' => 'Catching up on TV shows or games',
                'option_4' => 'Meeting friends for dinner or drinks',
            ],
            [
                'title' => 'What’s most important to you in a relationship?',
                'option_1' => 'Trust and honesty',
                'option_2' => 'Shared goals and values',
                'option_3' => 'Spontaneity and fun',
                'option_4' => 'Physical and emotional connection',
            ],
            [
                'title' => 'What’s your go-to activity for unwinding?',
                'option_1' => 'Listening to music or podcasts',
                'option_2' => 'Meditation or yoga',
                'option_3' => 'Binge-watching a favorite series',
                'option_4' => 'Going for a walk or run',
            ],
            [
                'title' => 'What kind of movies do you prefer?',
                'option_1' => 'Romantic comedies or dramas',
                'option_2' => 'Action or thrillers',
                'option_3' => 'Documentaries or biographies',
                'option_4' => 'Sci-fi or fantasy',
            ],
            [
                'title' => 'What’s your favorite kind of social outing?',
                'option_1' => 'A cozy dinner with close friends',
                'option_2' => 'A big party or event',
                'option_3' => 'An outdoor activity like hiking',
                'option_4' => 'A cultural experience like a museum visit',
            ],
            [
                'title' => 'How do you feel about pets?',
                'option_1' => 'I love them and have one or more!',
                'option_2' => 'I like them but don’t have one',
                'option_3' => 'I’m okay with pets but prefer not to own them',
                'option_4' => 'I’m not a pet person',
            ],
            [
                'title' => 'What’s your favorite way to stay active?',
                'option_1' => 'Team sports or group classes',
                'option_2' => 'Solo workouts like running or cycling',
                'option_3' => 'Outdoor adventures like hiking',
                'option_4' => 'I prefer not to work out',
            ],
            [
                'title' => 'What’s your idea of a perfect first date?',
                'option_1' => 'A casual coffee or drink',
                'option_2' => 'A fun activity like bowling or a hike',
                'option_3' => 'A nice dinner at a cozy restaurant',
                'option_4' => 'Something creative or unique like a painting class',
            ],
        ];

        foreach ($questions as $question) {
            Question::create([
                'title' => $question['title'],
                'option_1' => $question['option_1'],
                'option_2' => $question['option_2'],
                'option_3' => $question['option_3'],
                'option_4' => $question['option_4'],
            ]);
        }
    }
}
