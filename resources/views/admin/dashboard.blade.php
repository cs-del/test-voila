@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Stats Overview -->
    <div class="mb-8">
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Total Articles -->
            <div class="admin-card stats-card overflow-hidden">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-newspaper text-white"></i>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-white text-opacity-80 truncate">
                                    Total Articles
                                </dt>
                                <dd class="text-lg font-medium text-white">
                                    {{ number_format($stats['total_articles']) }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-white bg-opacity-10 px-5 py-3">
                    <div class="text-sm">
                        <span class="text-white text-opacity-80">
                            {{ $stats['published_articles'] }} published
                        </span>
                    </div>
                </div>
            </div>

            <!-- Categories -->
            <div class="admin-card stats-card success overflow-hidden">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-folder text-white"></i>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-white text-opacity-80 truncate">
                                    Categories
                                </dt>
                                <dd class="text-lg font-medium text-white">
                                    {{ number_format($stats['total_categories']) }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-white bg-opacity-10 px-5 py-3">
                    <div class="text-sm">
                        <span class="text-white text-opacity-80">
                            {{ $stats['active_categories'] }} active
                        </span>
                    </div>
                </div>
            </div>

            <!-- Pending Comments -->
            <div class="admin-card stats-card warning overflow-hidden">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-comments text-white"></i>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-white text-opacity-80 truncate">
                                    Comments
                                </dt>
                                <dd class="text-lg font-medium text-white">
                                    {{ number_format($stats['pending_comments']) }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-white bg-opacity-10 px-5 py-3">
                    <div class="text-sm">
                        <span class="text-white text-opacity-80">
                            {{ $stats['approved_comments'] }} approved
                        </span>
                    </div>
                </div>
            </div>

            <!-- Contact Messages -->
            <div class="admin-card stats-card danger overflow-hidden">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-envelope text-white"></i>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-white text-opacity-80 truncate">
                                    Messages
                                </dt>
                                <dd class="text-lg font-medium text-white">
                                    {{ number_format($stats['total_contacts']) }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-white bg-opacity-10 px-5 py-3">
                    <div class="text-sm">
                        <span class="text-white text-opacity-80">
                            {{ $stats['unreviewed_contacts'] }} unreviewed
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-semibold text-gray-900">Analytics Overview</h2>
        </div>
        
        <!-- Charts Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Articles by Category Chart -->
            <div class="admin-card">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Articles by Category</h3>
                </div>
                <div class="p-6">
                    <div class="relative h-64">
                        <canvas id="articlesByCategoryChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Articles Status Distribution -->
            <div class="admin-card">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Articles Status</h3>
                </div>
                <div class="p-6">
                    <div class="relative h-64">
                        <canvas id="articlesStatusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Articles Over Time Chart -->
            <div class="admin-card">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Articles Created Over Time</h3>
                </div>
                <div class="p-6">
                    <div class="relative h-64">
                        <canvas id="articlesOverTimeChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Comments Status Distribution -->
            <div class="admin-card">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Comments Status</h3>
                </div>
                <div class="p-6">
                    <div class="relative h-64">
                        <canvas id="commentsStatusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Recent Articles -->
        <div class="admin-card">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900">Recent Articles</h3>
                    <a href="{{ route('admin.articles.index') }}" class="text-sm text-purple-600 hover:text-purple-800">
                        View all →
                    </a>
                </div>
            </div>
            <div class="p-6">
                @if($recentArticles->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentArticles as $article)
                            <div class="flex items-start space-x-3">
                                @if($article->featured_image)
                                    <img src="{{ Storage::url($article->featured_image) }}" 
                                         alt="{{ $article->title }}" 
                                         class="w-12 h-12 rounded-lg object-cover">
                                @else
                                    <div class="w-12 h-12 bg-gradient-to-br from-purple-400 to-blue-400 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-image text-white text-sm"></i>
                                    </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">
                                        <a href="{{ route('admin.articles.show', $article) }}" class="hover:text-purple-600">
                                            {{ $article->title }}
                                        </a>
                                    </p>
                                    <div class="flex items-center space-x-2 mt-1">
                                        <span class="status-badge {{ $article->status === 'published' ? 'status-published' : 'status-draft' }}">
                                            {{ $article->status }}
                                        </span>
                                        <span class="text-xs text-gray-500">{{ $article->user->name }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-newspaper text-gray-300 text-3xl mb-2"></i>
                        <p class="text-gray-500">No articles yet</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Recent Contact Messages -->
        <div class="admin-card">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900">Recent Messages</h3>
                    <a href="{{ route('admin.contacts.index') }}" class="text-sm text-purple-600 hover:text-purple-800">
                        View all →
                    </a>
                </div>
            </div>
            <div class="p-6">
                @if($recentContacts->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentContacts as $contact)
                            <div class="flex items-start space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-r from-purple-600 to-blue-600 rounded-full flex items-center justify-center">
                                    <span class="text-white text-sm font-semibold">
                                        {{ strtoupper(substr($contact->name, 0, 1)) }}
                                    </span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">
                                        {{ $contact->name }}
                                    </p>
                                    <p class="text-xs text-gray-500 truncate">{{ $contact->subject }}</p>
                                    <div class="flex items-center space-x-2 mt-1">
                                        <span class="status-badge {{ is_null($contact->reviewed_at) ? 'status-pending' : 'status-approved' }}">
                                            {{ is_null($contact->reviewed_at) ? 'new' : 'reviewed' }}
                                        </span>
                                        <span class="text-xs text-gray-500">{{ $contact->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-envelope text-gray-300 text-3xl mb-2"></i>
                        <p class="text-gray-500">No messages yet</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Pending Comments Section -->
    @if($pendingComments->count() > 0)
        <div class="admin-card mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900">Pending Comments</h3>
                    <a href="{{ route('admin.comments.index') }}" class="text-sm text-purple-600 hover:text-purple-800">
                        View all →
                    </a>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($pendingComments as $comment)
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-2 mb-2">
                                        <span class="font-medium text-gray-900">{{ $comment->name }}</span>
                                        <span class="text-sm text-gray-500">on</span>
                                        <a href="{{ route('article.show', $comment->article->slug) }}" 
                                           class="text-sm text-purple-600 hover:text-purple-800">
                                            {{ Str::limit($comment->article->title, 40) }}
                                        </a>
                                    </div>
                                    <p class="text-sm text-gray-700">{{ Str::limit($comment->comment, 150) }}</p>
                                    <p class="text-xs text-gray-500 mt-2">{{ $comment->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="flex items-center space-x-2 ml-4">
                                    <form method="POST" action="{{ route('admin.comments.approve', $comment) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                                class="bg-green-600 text-white px-3 py-1 rounded text-xs hover:bg-green-700">
                                            Approve
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.comments.reject', $comment) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                                class="bg-red-600 text-white px-3 py-1 rounded text-xs hover:bg-red-700">
                                            Reject
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="admin-card text-center p-6">
            <div class="w-12 h-12 mx-auto mb-4 bg-gradient-to-r from-purple-600 to-blue-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-plus text-white text-xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Create Article</h3>
            <p class="text-gray-600 text-sm mb-4">Write and publish a new article</p>
            <a href="{{ route('admin.articles.create') }}" 
               class="bg-gradient-to-r from-purple-600 to-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:from-purple-700 hover:to-blue-700">
                Get Started
            </a>
        </div>

        <div class="admin-card text-center p-6">
            <div class="w-12 h-12 mx-auto mb-4 bg-gradient-to-r from-green-600 to-emerald-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-folder-plus text-white text-xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Add Category</h3>
            <p class="text-gray-600 text-sm mb-4">Create a new content category</p>
            <a href="{{ route('admin.categories.create') }}" 
               class="bg-gradient-to-r from-green-600 to-emerald-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:from-green-700 hover:to-emerald-700">
                Create
            </a>
        </div>

        <div class="admin-card text-center p-6">
            <div class="w-12 h-12 mx-auto mb-4 bg-gradient-to-r from-blue-600 to-cyan-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-chart-line text-white text-xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">View Analytics</h3>
            <p class="text-gray-600 text-sm mb-4">Check your content performance</p>
            <a href="#" 
               class="bg-gradient-to-r from-blue-600 to-cyan-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:from-blue-700 hover:to-cyan-700">
                Coming Soon
            </a>
        </div>
    </div>

    <!-- System Status -->
    <div class="admin-card">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">System Status</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Storage Used</span>
                        <span class="text-sm font-medium text-gray-900">
                            {{ number_format((disk_free_space(storage_path()) / 1024 / 1024 / 1024), 1) }} GB free
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Database Size</span>
                        <span class="text-sm font-medium text-gray-900">
                            {{ number_format(\DB::connection()->getPdo()->query('SELECT ROUND(SUM(data_length + index_length) / 1024 / 1024, 1) FROM information_schema.tables WHERE table_schema = DATABASE()')->fetchColumn(), 1) }} MB
                        </span>
                    </div>
                </div>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Laravel Version</span>
                        <span class="text-sm font-medium text-gray-900">{{ app()->version() }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">PHP Version</span>
                        <span class="text-sm font-medium text-gray-900">{{ PHP_VERSION }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Chart.js configuration
const chartColors = {
    primary: '#7c3aed',
    secondary: '#3b82f6',
    success: '#10b981',
    warning: '#f59e0b',
    danger: '#ef4444',
    info: '#06b6d4',
    purple: '#8b5cf6',
    pink: '#ec4899',
    indigo: '#6366f1',
    teal: '#14b8a6',
};

// Animate stats cards on load
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.admin-card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        
        setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });

    // Initialize Charts
    initializeCharts();
});

function initializeCharts() {
    // Articles by Category Chart (Doughnut)
    const articlesByCategoryCtx = document.getElementById('articlesByCategoryChart');
    if (articlesByCategoryCtx) {
        new Chart(articlesByCategoryCtx, {
            type: 'doughnut',
            data: {
                labels: @json($chartData['articles_by_category']['labels']),
                datasets: [{
                    data: @json($chartData['articles_by_category']['data']),
                    backgroundColor: [
                        chartColors.primary,
                        chartColors.secondary,
                        chartColors.success,
                        chartColors.warning,
                        chartColors.danger,
                        chartColors.info,
                        chartColors.purple,
                        chartColors.pink,
                    ],
                    borderWidth: 0,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': ' + context.parsed + ' articles';
                            }
                        }
                    }
                }
            }
        });
    }

    // Articles Status Chart (Pie)
    const articlesStatusCtx = document.getElementById('articlesStatusChart');
    if (articlesStatusCtx) {
        new Chart(articlesStatusCtx, {
            type: 'pie',
            data: {
                labels: ['Published', 'Draft'],
                datasets: [{
                    data: [@json($chartData['articles_status']['published']), @json($chartData['articles_status']['draft'])],
                    backgroundColor: [chartColors.success, chartColors.warning],
                    borderWidth: 0,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((context.parsed / total) * 100);
                                return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });
    }

    // Articles Over Time Chart (Line)
    const articlesOverTimeCtx = document.getElementById('articlesOverTimeChart');
    if (articlesOverTimeCtx) {
        new Chart(articlesOverTimeCtx, {
            type: 'line',
            data: {
                labels: @json($chartData['articles_over_time']['labels']),
                datasets: [{
                    label: 'Articles Created',
                    data: @json($chartData['articles_over_time']['data']),
                    borderColor: chartColors.primary,
                    backgroundColor: chartColors.primary + '20',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: chartColors.primary,
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            precision: 0
                        },
                        grid: {
                            color: '#f3f4f6'
                        }
                    },
                    x: {
                        grid: {
                            color: '#f3f4f6'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        borderColor: chartColors.primary,
                        borderWidth: 1,
                    }
                }
            }
        });
    }

    // Comments Status Chart (Bar)
    const commentsStatusCtx = document.getElementById('commentsStatusChart');
    if (commentsStatusCtx) {
        new Chart(commentsStatusCtx, {
            type: 'bar',
            data: {
                labels: ['Approved', 'Pending', 'Rejected'],
                datasets: [{
                    label: 'Comments',
                    data: [@json($chartData['comments_status']['approved']), @json($chartData['comments_status']['pending']), @json($chartData['comments_status']['rejected'])],
                    backgroundColor: [
                        chartColors.success,
                        chartColors.warning,
                        chartColors.danger,
                    ],
                    borderColor: [
                        chartColors.success,
                        chartColors.warning,
                        chartColors.danger,
                    ],
                    borderWidth: 0,
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            precision: 0
                        },
                        grid: {
                            color: '#f3f4f6'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        borderColor: chartColors.primary,
                        borderWidth: 1,
                    }
                }
            }
        });
    }
}
</script>
@endpush