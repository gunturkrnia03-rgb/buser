<?php

namespace App\Http\Controllers;

use App\Models\Score;
use App\Models\User;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ScoreController extends Controller
{
    /**
     * Display the result page after quiz session
     * 
     * Menampilkan hasil quiz dengan skor, accuracy, dan edukasi
     */
    public function result()
    {
        $user = Auth::user();
        $latestScore = $user->latestScore();
        $answers = $user->answers()->with('quiz')->latest()->take(10)->get();
        
        return view('score.result', compact('user', 'latestScore', 'answers'));
    }

    /**
     * Display the national leaderboard
     * 
     * Menampilkan leaderboard nasional based on total_score
     */
    public function leaderboard()
    {
        // Get top 50 users by total_score
        $leaders = User::orderBy('total_score', 'desc')
            ->limit(50)
            ->get(['id', 'name', 'school', 'total_score', 'level', 'created_at']);
        
        // Get user's rank
        $user = Auth::user();
        $userRank = User::where('total_score', '>', $user->total_score)->count() + 1;
        
        return view('score.leaderboard', compact('leaders', 'userRank', 'user'));
    }

    /**
     * Save session score after quiz completion
     * 
     * Simpan skor sesi quiz ke database
     */
    public function saveSession(Request $request)
    {
        $request->validate([
            'correct_count' => 'required|integer|min:0',
            'total_questions' => 'required|integer|min:1',
        ]);

        $user = Auth::user();
        $correctCount = $request->input('correct_count');
        $totalQuestions = $request->input('total_questions');
        
        // Calculate total score from this session
        $sessionScore = $correctCount * 10; // 10 points per correct answer
        
        // Calculate accuracy
        $accuracy = ($correctCount / $totalQuestions) * 100;
        
        // Save score
        $score = Score::create([
            'user_id' => $user->id,
            'total_score' => $sessionScore,
            'correct_count' => $correctCount,
            'total_questions' => $totalQuestions,
            'accuracy' => $accuracy,
        ]);
        
        // Update user's total score
        $user->total_score += $sessionScore;
        $user->updateLevel();
        
        return response()->json([
            'success' => true,
            'score' => $score,
            'total_score' => $user->total_score,
            'level' => $user->level,
            'accuracy' => $accuracy,
        ]);
    }

    /**
     * Get user's score history
     */
    public function history()
    {
        $user = Auth::user();
        $scores = $user->scores()->orderBy('created_at', 'desc')->paginate(10);
        
        return response()->json($scores);
    }

    /**
     * Get leaderboard data for API
     */
    public function leaderboardApi()
    {
        $leaders = User::orderBy('total_score', 'desc')
            ->limit(20)
            ->get(['name', 'school', 'total_score', 'level']);
        
        return response()->json($leaders);
    }
}