<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function show($slug)
    {
        $article = Article::published()
                         ->with(['user', 'categories', 'approvedComments'])
                         ->where('slug', $slug)
                         ->firstOrFail();

        // Get related articles
        $relatedArticles = Article::published()
                                 ->where('id', '!=', $article->id)
                                 ->whereHas('categories', function ($query) use ($article) {
                                     $query->whereIn('categories.id', $article->categories->pluck('id'));
                                 })
                                 ->with(['user', 'categories'])
                                 ->limit(3)
                                 ->get();

        return view('frontend.article', compact('article', 'relatedArticles'));
    }

    public function addComment(Request $request, $slug)
    {
        $article = Article::published()->where('slug', $slug)->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'comment' => 'required|string|min:5|max:1000',
        ]);

        Comment::create([
            'article_id' => $article->id,
            'name' => $request->name,
            'email' => $request->email,
            'comment' => $request->comment,
            'status' => 'pending', // Comments need approval
        ]);

        return redirect()->route('article.show', $slug)
                        ->with('success', 'Comment submitted successfully! It will be visible after approval.');
    }
}