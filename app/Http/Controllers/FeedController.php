<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\VerifyPostRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FeedController extends Controller
{
    /**
     * Display the simulation feed.
     */
    public function index(): View
    {
        $posts = Post::latest()->get();
        return view('feed.index', compact('posts'));
    }

    /**
     * Verify if the user action correctly identifies a hoax.
     */
    public function verify(VerifyPostRequest $request, Post $post): RedirectResponse
    {
        $isReportingHoax = $request->validated()['action'] === 'report_hoax';
        
        // Correct if user reports a hoax or shares a fact (non-hoax)
        $isCorrect = ($isReportingHoax === (bool) $post->is_hoax);

        if ($isCorrect) {
            return back()->with('success', "Correct! {$post->explanation}");
        }

        return back()->with('error', "Incorrect. {$post->explanation}");
    }
}
