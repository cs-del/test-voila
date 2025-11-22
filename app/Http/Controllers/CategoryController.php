<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Article;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show($slug)
    {
        $category = Category::where('slug', $slug)
                           ->where('status', 'active')
                           ->firstOrFail();

        $articles = Article::published()
                          ->whereHas('categories', function ($query) use ($category) {
                              $query->where('categories.id', $category->id);
                          })
                          ->with(['user', 'categories'])
                          ->orderBy('published_at', 'desc')
                          ->paginate(6);

        return view('frontend.category', compact('category', 'articles'));
    }
}