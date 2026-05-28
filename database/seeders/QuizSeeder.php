<?php

namespace Database\Seeders;

use App\Models\Quiz;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $quiz = Quiz::create([
            'title' => 'Digital Literacy Basics',
            'description' => 'Test your knowledge on identifying hoaxes and staying safe online.',
        ]);

        $q1 = Question::create([
            'quiz_id' => $quiz->id,
            'content' => 'What is the first thing you should check when reading a suspicious news article?',
            'type' => 'multiple_choice',
        ]);

        Answer::create(['question_id' => $q1->id, 'content' => 'The headline', 'is_correct' => false]);
        Answer::create(['question_id' => $q1->id, 'content' => 'The author and source', 'is_correct' => true]);
        Answer::create(['question_id' => $q1->id, 'content' => 'How many likes it has', 'is_correct' => false]);

        $q2 = Question::create([
            'quiz_id' => $quiz->id,
            'content' => 'True or False: Most official organizations use email links to ask for your password.',
            'type' => 'true_false',
        ]);

        Answer::create(['question_id' => $q2->id, 'content' => 'True', 'is_correct' => false]);
        Answer::create(['question_id' => $q2->id, 'content' => 'False', 'is_correct' => true]);
    }
}
