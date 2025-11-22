<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Article;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $query = Comment::with('article');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('comment', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('article')) {
            $query->whereHas('article', function ($q) use ($request) {
                $q->where('slug', $request->article);
            });
        }

        $comments = $query->latest()->paginate(10)->withQueryString();
        $articles = Article::published()->get(['id', 'title', 'slug']);

        return view('admin.comments.index', compact('comments', 'articles'));
    }

    public function show(Comment $comment)
    {
        $comment->load('article');
        return view('admin.comments.show', compact('comment'));
    }

    public function approve(Comment $comment)
    {
        $comment->update(['status' => 'approved']);
        return redirect()->back()->with('success', 'Comment approved successfully!');
    }

    public function reject(Comment $comment)
    {
        $comment->update(['status' => 'rejected']);
        return redirect()->back()->with('success', 'Comment rejected successfully!');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return redirect()->route('admin.comments.index')
                        ->with('success', 'Comment deleted successfully!');
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'comments' => 'required|array',
            'comments.*' => 'exists:comments,id',
            'action' => 'required|in:approve,reject,delete',
        ]);

        $comments = Comment::whereIn('id', $request->comments);

        switch ($request->action) {
            case 'approve':
                $comments->update(['status' => 'approved']);
                $message = 'Comments approved successfully!';
                break;
            case 'reject':
                $comments->update(['status' => 'rejected']);
                $message = 'Comments rejected successfully!';
                break;
            case 'delete':
                $comments->delete();
                $message = 'Comments deleted successfully!';
                break;
        }

        return redirect()->back()->with('success', $message);
    }
}