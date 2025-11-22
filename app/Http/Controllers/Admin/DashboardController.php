<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_articles' => Article::count(),
            'published_articles' => Article::where('status', 'published')->count(),
            'draft_articles' => Article::where('status', 'draft')->count(),
            'total_categories' => Category::count(),
            'active_categories' => Category::where('status', 'active')->count(),
            'pending_comments' => Comment::where('status', 'pending')->count(),
            'approved_comments' => Comment::where('status', 'approved')->count(),
            'total_contacts' => Contact::count(),
            'unreviewed_contacts' => Contact::whereNull('reviewed_at')->count(),
            'total_users' => User::count(),
        ];

        $recentArticles = Article::with(['user', 'categories'])
                                ->latest()
                                ->limit(5)
                                ->get();

        $recentContacts = Contact::latest()
                                ->limit(5)
                                ->get();

        $pendingComments = Comment::with('article')
                                 ->where('status', 'pending')
                                 ->latest()
                                 ->limit(5)
                                 ->get();

        // Chart data
        $chartData = $this->getChartData();

        return view('admin.dashboard', compact('stats', 'recentArticles', 'recentContacts', 'pendingComments', 'chartData'));
    }

    private function getChartData()
    {
        // Articles by category
        $categories = Category::withCount('publishedArticles')->get();
        $articlesByCategory = [
            'labels' => $categories->pluck('name')->toArray(),
            'data' => $categories->pluck('published_articles_count')->toArray(),
        ];

        // Articles status distribution
        $articlesStatus = [
            'published' => Article::where('status', 'published')->count(),
            'draft' => Article::where('status', 'draft')->count(),
        ];

        // Articles created over time (last 6 months)
        $articlesOverTime = $this->getArticlesOverTime();
        
        // Comments status distribution
        $commentsStatus = [
            'approved' => Comment::where('status', 'approved')->count(),
            'pending' => Comment::where('status', 'pending')->count(),
            'rejected' => Comment::where('status', 'rejected')->count(),
        ];

        // Contact messages over time (last 6 months)
        $contactsOverTime = $this->getContactsOverTime();

        return [
            'articles_by_category' => $articlesByCategory,
            'articles_status' => $articlesStatus,
            'articles_over_time' => $articlesOverTime,
            'comments_status' => $commentsStatus,
            'contacts_over_time' => $contactsOverTime,
        ];
    }

    private function getArticlesOverTime()
    {
        $months = [];
        $counts = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->format('M Y');
            $counts[] = Article::whereYear('created_at', $date->year)
                              ->whereMonth('created_at', $date->month)
                              ->count();
        }

        return [
            'labels' => $months,
            'data' => $counts,
        ];
    }

    private function getContactsOverTime()
    {
        $months = [];
        $counts = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->format('M Y');
            $counts[] = Contact::whereYear('created_at', $date->year)
                              ->whereMonth('created_at', $date->month)
                              ->count();
        }

        return [
            'labels' => $months,
            'data' => $counts,
        ];
    }
}