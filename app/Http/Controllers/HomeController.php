<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the homepage with social media feed
     * 
     * Menampilkan feed media sosial palsu dengan post hoaks & fakta
     * User dapat scroll dan memilih "Ini Hoaks" atau "Ini Fakta"
     */
    public function index()
    {
        // Get all posts ordered by newest
        $posts = Post::orderBy('created_at', 'desc')->get();
        
        return view('home.index', compact('posts'));
    }

    /**
     * User votes on a post (hoaks or fakta)
     * 
     * Handle voting pada post media sosial
     * Tidak menyimpan ke database (hanya simulasi)
     */
    public function vote(Request $request, Post $post)
    {
        $request->validate([
            'vote' => 'required|in:hoaks,fakta',
        ]);

        $userVote = $request->input('vote');
        $isCorrect = $userVote === $post->type;
        
        return response()->json([
            'correct' => $isCorrect,
            'type' => $post->type,
            'explanation' => $post->explanation,
            'title' => $post->title,
        ]);
    }

    /**
     * Filter posts by type
     */
    public function filter(Request $request)
    {
        $type = $request->input('type', 'all');
        
        if ($type === 'hoaks') {
            $posts = Post::hoaks()->orderBy('created_at', 'desc')->get();
        } elseif ($type === 'fakta') {
            $posts = Post::fakta()->orderBy('created_at', 'desc')->get();
        } else {
            $posts = Post::orderBy('created_at', 'desc')->get();
        }
        
        return response()->json($posts);
    }
}