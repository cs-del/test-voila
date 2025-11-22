@extends('layouts.admin')

@section('title', $article->title)
@section('page-title', 'Article Details')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $article->title }}</h1>
            <p class="mt-1 text-sm text-gray-500">Created {{ $article->created_at->diffForHumans() }}</p>
        </div>
        <div class="mt-4 sm:mt-0 flex space-x-3">
            <a href="{{ route('admin.articles.edit', $article) }}" 
               class="bg-purple-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-purple-700">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <a href="{{ route('article.show', $article->slug) }}" 
               target="_blank"
               class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700">
                <i class="fas fa-external-link-alt mr-2"></i>View Live
            </a>
            <a href="{{ route('admin.articles.index') }}" 
               class="bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-700">
                <i class="fas fa-arrow-left mr-2"></i>Back
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Featured Image -->
            @if($article->featured_image)
                <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                    <img src="{{ Storage::url($article->featured_image) }}" 
                         alt="{{ $article->title }}" 
                         class="w-full h-96 object-cover">
                </div>
            @endif

            <!-- Article Content -->
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Content</h2>
                <div class="prose max-w-none">
                    {!! nl2br(e($article->content)) !!}
                </div>
            </div>

            <!-- Comments Section -->
            <div class="bg-white shadow-sm rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">
                        Comments ({{ $article->comments->count() }})
                    </h2>
                </div>
                
                @if($article->comments->count() > 0)
                    <div class="space-y-4">
                        @foreach($article->comments->take(5) as $comment)
                            <div class="border-l-4 {{ $comment->status === 'approved' ? 'border-green-500' : ($comment->status === 'pending' ? 'border-yellow-500' : 'border-red-500') }} pl-4 py-2">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center space-x-2">
                                        <span class="font-medium text-gray-900">{{ $comment->name }}</span>
                                        <span class="status-badge status-{{ $comment->status }}">
                                            {{ $comment->status }}
                                        </span>
                                    </div>
                                    <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-sm text-gray-700">{{ Str::limit($comment->comment, 150) }}</p>
                            </div>
                        @endforeach
                    </div>
                    
                    @if($article->comments->count() > 5)
                        <div class="mt-4 text-center">
                            <a href="{{ route('admin.comments.index', ['article' => $article->slug]) }}" 
                               class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                                View all comments →
                            </a>
                        </div>
                    @endif
                @else
                    <p class="text-gray-500 text-center py-4">No comments yet</p>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Status Card -->
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Status</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Status</span>
                        <span class="status-badge status-{{ $article->status }}">
                            {{ ucfirst($article->status) }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Author</span>
                        <span class="text-sm font-medium text-gray-900">{{ $article->user->name }}</span>
                    </div>
                    @if($article->published_at)
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Published</span>
                            <span class="text-sm font-medium text-gray-900">
                                {{ $article->published_at->format('M d, Y') }}
                            </span>
                        </div>
                    @endif
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Updated</span>
                        <span class="text-sm font-medium text-gray-900">
                            {{ $article->updated_at->diffForHumans() }}
                        </span>
                    </div>
                </div>

                <div class="mt-4 pt-4 border-t border-gray-200">
                    <form method="POST" action="{{ route('admin.articles.toggle-status', $article) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-purple-600 to-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:from-purple-700 hover:to-blue-700">
                            <i class="fas fa-sync-alt mr-2"></i>
                            Toggle Status
                        </button>
                    </form>
                </div>
            </div>

            <!-- Categories Card -->
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Categories</h3>
                <div class="flex flex-wrap gap-2">
                    @forelse($article->categories as $category)
                        <a href="{{ route('category.show', $category->slug) }}" 
                           target="_blank"
                           class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium"
                           style="background-color: {{ $category->color }}20; color: {{ $category->color }};">
                            <i class="fas fa-folder mr-1"></i>
                            {{ $category->name }}
                        </a>
                    @empty
                        <p class="text-gray-500 text-sm">No categories assigned</p>
                    @endforelse
                </div>
            </div>

            <!-- Excerpt Card -->
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Excerpt</h3>
                <p class="text-sm text-gray-700">{{ $article->excerpt }}</p>
            </div>

            <!-- Actions Card -->
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions</h3>
                <div class="space-y-2">
                    <a href="{{ route('admin.articles.edit', $article) }}" 
                       class="block w-full text-center bg-purple-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-purple-700">
                        <i class="fas fa-edit mr-2"></i>Edit Article
                    </a>
                    <form method="POST" action="{{ route('admin.articles.destroy', $article) }}" 
                          onsubmit="return confirm('Are you sure you want to delete this article?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="block w-full bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-700">
                            <i class="fas fa-trash mr-2"></i>Delete Article
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
