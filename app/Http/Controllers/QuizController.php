<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    /**
     * Display the quiz page
     * 
     * Menampilkan halaman quiz interaktif
     * Load quiz pertama yang aktif
     */
    public function index()
    {
        // Get first active quiz or null
        $quiz = Quiz::active()->orderBy('id')->first();
        $quizzes = Quiz::active()->count();
        
        return view('quiz.index', compact('quiz', 'quizzes'));
    }

    /**
     * Get next quiz in sequence
     */
    public function getNextQuiz(Request $request)
    {
        $currentQuizId = $request->input('current_quiz_id');
        
        $nextQuiz = Quiz::active()
            ->where('id', '>', $currentQuizId)
            ->orderBy('id')
            ->first();
        
        if (!$nextQuiz) {
            // If no more quizzes, get first one (loop)
            $nextQuiz = Quiz::active()->orderBy('id')->first();
        }
        
        return response()->json([
            'id' => $nextQuiz->id,
            'question' => $nextQuiz->question,
            'image' => $nextQuiz->image,
            'difficulty' => $nextQuiz->difficulty,
            'points' => $nextQuiz->points,
        ]);
    }

    /**
     * Submit answer for a quiz
     * 
     * Handle submission jawaban user
     * Cek benar/salah, simpan ke database
     */
    public function submit(Request $request)
    {
        $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'answer' => 'required|in:hoaks,fakta',
            'time_spent' => 'required|integer|min:0',
        ]);

        $quiz = Quiz::findOrFail($request->input('quiz_id'));
        $user = Auth::user();
        
        $isCorrect = $request->input('answer') === $quiz->type;
        
        // Save answer
        $answer = Answer::create([
            'user_id' => $user->id,
            'quiz_id' => $quiz->id,
            'answer' => $request->input('answer'),
            'is_correct' => $isCorrect,
            'time_spent' => $request->input('time_spent'),
        ]);

        // Calculate score
        $score = $isCorrect ? $quiz->points : 0;
        
        // Update user total score
        $user->total_score += $score;
        $user->updateLevel();
        
        return response()->json([
            'correct' => $isCorrect,
            'correct_answer' => $quiz->type,
            'explanation' => $quiz->explanation,
            'points' => $score,
            'total_score' => $user->total_score,
            'level' => $user->level,
        ]);
    }

    /**
     * Get quiz statistics
     */
    public function statistics()
    {
        $user = Auth::user();
        $totalAnswers = $user->answers()->count();
        $correctAnswers = $user->answers()->where('is_correct', true)->count();
        $accuracy = $totalAnswers > 0 ? round(($correctAnswers / $totalAnswers) * 100, 2) : 0;
        
        return response()->json([
            'total_answers' => $totalAnswers,
            'correct_answers' => $correctAnswers,
            'accuracy' => $accuracy,
            'total_score' => $user->total_score,
            'level' => $user->level,
        ]);
    }
}