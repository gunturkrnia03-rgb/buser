<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Attempt;
use App\Models\Answer;
use App\Http\Requests\SubmitQuizRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class QuizController extends Controller
{
    /**
     * Display a list of available quizzes.
     */
    public function index(): View
    {
        $quizzes = Quiz::withCount('questions')->get();
        return view('quizzes.index', compact('quizzes'));
    }

    /**
     * Display a specific quiz.
     */
    public function show(Quiz $quiz): View
    {
        $quiz->load('questions.answers');
        return view('quizzes.show', compact('quiz'));
    }

    /**
     * Handle quiz submission and calculate score.
     */
    public function submit(SubmitQuizRequest $request, Quiz $quiz): RedirectResponse
    {
        $submittedAnswers = $request->validated()['answers'];
        $questionIds = $quiz->questions()->pluck('id');

        // Optimasi: Ambil semua jawaban yang benar untuk kuis ini dalam 1 query
        // Serta pastikan jawaban yang dikirim memang milik kuis ini (Data Integrity)
        $correctAnswers = Answer::whereIn('question_id', $questionIds)
            ->where('is_correct', true)
            ->get();

        $correctCount = 0;
        foreach ($submittedAnswers as $questionId => $answerId) {
            // Cek apakah answerId yang dikirim adalah jawaban yang benar untuk kuis ini
            $isCorrect = $correctAnswers->contains(function ($answer) use ($answerId, $questionId) {
                return $answer->id == $answerId && $answer->question_id == $questionId;
            });

            if ($isCorrect) {
                $correctCount++;
            }
        }

        $totalQuestions = $questionIds->count();
        $score = ($totalQuestions > 0) ? round(($correctCount / $totalQuestions) * 100) : 0;

        Attempt::create([
            'user_id' => Auth::id() ?? 2, // Default to Student User ID (2) if not logged in
            'quiz_id' => $quiz->id,
            'score' => $score,
            'completed_at' => now(),
        ]);

        return redirect()->route('quizzes.index')
            ->with('success', "Quiz completed! Your score: {$score}%");
    }
}
