<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::with(['user', 'categories']);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('excerpt', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $articles = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::all();

        return view('admin.articles.index', compact('articles', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('status', 'active')->get();
        return view('admin.articles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
        ]);

        $slug = Str::slug($request->title) . '-' . time();

        $articleData = [
            'title' => $request->title,
            'slug' => $slug,
            'excerpt' => $request->excerpt,
            'content' => $request->content,
            'status' => $request->status,
            'user_id' => auth()->id(),
        ];

        if ($request->status === 'published' && $request->filled('published_at')) {
            $articleData['published_at'] = $request->published_at;
        } elseif ($request->status === 'published') {
            $articleData['published_at'] = now();
        }

        if ($request->hasFile('featured_image')) {
            $articleData['featured_image'] = $request->file('featured_image')->store('articles', 'public');
        }

        $article = Article::create($articleData);
        $article->categories()->sync($request->categories);

        return redirect()->route('admin.articles.index')
                        ->with('success', 'Article created successfully!');
    }

    public function show(Article $article)
    {
        $article->load(['user', 'categories']);
        return view('admin.articles.show', compact('article'));
    }

    public function edit(Article $article)
    {
        $article->load('categories');
        $categories = Category::where('status', 'active')->get();
        return view('admin.articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
            'status' => 'required|in:draft,published,archived',
            'published_at' => 'nullable|date',
        ]);

        $articleData = [
            'title' => $request->title,
            'excerpt' => $request->excerpt,
            'content' => $request->content,
            'status' => $request->status,
        ];

        if ($request->status === 'published' && $request->filled('published_at')) {
            $articleData['published_at'] = $request->published_at;
        } elseif ($request->status === 'published' && !$article->published_at) {
            $articleData['published_at'] = now();
        } elseif ($request->status !== 'published') {
            $articleData['published_at'] = null;
        }

        if ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($article->featured_image) {
                Storage::disk('public')->delete($article->featured_image);
            }
            $articleData['featured_image'] = $request->file('featured_image')->store('articles', 'public');
        }

        $article->update($articleData);
        $article->categories()->sync($request->categories);

        return redirect()->route('admin.articles.index')
                        ->with('success', 'Article updated successfully!');
    }

    public function destroy(Article $article)
    {
        // Delete featured image if exists
        if ($article->featured_image) {
            Storage::disk('public')->delete($article->featured_image);
        }

        $article->categories()->detach();
        $article->delete();

        return redirect()->route('admin.articles.index')
                        ->with('success', 'Article deleted successfully!');
    }

    public function toggleStatus(Article $article)
    {
        $article->status = $article->status === 'published' ? 'draft' : 'published';
        
        if ($article->status === 'published' && !$article->published_at) {
            $article->published_at = now();
        } elseif ($article->status === 'draft') {
            $article->published_at = null;
        }
        
        $article->save();

        return redirect()->back()->with('success', 'Article status updated successfully!');
    }
}