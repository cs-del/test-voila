@extends('layouts.admin')

@section('title', 'Comment Details')
@section('page-title', 'Comment Details')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Comment Details</h1>
            <p class="mt-1 text-sm text-gray-500">View and manage comment</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('admin.comments.index') }}" 
               class="bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-700">
                <i class="fas fa-arrow-left mr-2"></i>Back to Comments
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Comment Content -->
            <div class="bg-white shadow-sm rounded-lg p-6">
                <div class="flex items-start space-x-4 mb-6">
                    <div class="w-16 h-16 bg-gradient-to-r from-purple-600 to-blue-600 rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="text-white text-2xl font-semibold">
                            {{ strtoupper(substr($comment->name, 0, 1)) }}
                        </span>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $comment->name }}</h3>
                            <span class="status-badge status-{{ $comment->status }}">
                                {{ ucfirst($comment->status) }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-500">{{ $comment->email }}</p>
                        <p class="text-xs text-gray-400 mt-1">
                            <i class="fas fa-clock mr-1"></i>
                            {{ $comment->created_at->format('F d, Y \a\t h:i A') }}
                        </p>
                    </div>
                </div>

                <div class="border-t border-gray-200 pt-6">
                    <h4 class="text-sm font-medium text-gray-700 mb-3">Comment</h4>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-900 whitespace-pre-wrap">{{ $comment->comment }}</p>
                    </div>
                </div>
            </div>

            <!-- Article Reference -->
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Article</h3>
                <div class="flex items-start space-x-4">
                    @if($comment->article->featured_image)
                        <img src="{{ Storage::url($comment->article->featured_image) }}" 
                             alt="{{ $comment->article->title }}" 
                             class="w-24 h-24 rounded-lg object-cover">
                    @else
                        <div class="w-24 h-24 bg-gradient-to-br from-purple-400 to-blue-400 rounded-lg flex items-center justify-center">
                            <i class="fas fa-newspaper text-white text-2xl"></i>
                        </div>
                    @endif
                    <div class="flex-1">
                        <h4 class="text-base font-medium text-gray-900 mb-1">
                            <a href="{{ route('admin.articles.show', $comment->article) }}" 
                               class="hover:text-purple-600">
                                {{ $comment->article->title }}
                            </a>
                        </h4>
                        <p class="text-sm text-gray-500 mb-2">{{ Str::limit($comment->article->excerpt, 100) }}</p>
                        <div class="flex items-center space-x-4 text-xs text-gray-500">
                            <span>
                                <i class="fas fa-user mr-1"></i>
                                {{ $comment->article->user->name }}
                            </span>
                            <span>
                                <i class="fas fa-calendar mr-1"></i>
                                {{ $comment->article->created_at->format('M d, Y') }}
                            </span>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('article.show', $comment->article->slug) }}" 
                               target="_blank"
                               class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                                View Article <i class="fas fa-external-link-alt ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Actions Card -->
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions</h3>
                <div class="space-y-2">
                    @if($comment->status === 'pending')
                        <form method="POST" action="{{ route('admin.comments.approve', $comment) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                    class="w-full bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-700">
                                <i class="fas fa-check mr-2"></i>Approve Comment
                            </button>
                        </form>
                        
                        <form method="POST" action="{{ route('admin.comments.reject', $comment) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                    class="w-full bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-yellow-700">
                                <i class="fas fa-times mr-2"></i>Reject Comment
                            </button>
                        </form>
                    @elseif($comment->status === 'approved')
                        <form method="POST" action="{{ route('admin.comments.reject', $comment) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                    class="w-full bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-yellow-700">
                                <i class="fas fa-times mr-2"></i>Reject Comment
                            </button>
                        </form>
                    @elseif($comment->status === 'rejected')
                        <form method="POST" action="{{ route('admin.comments.approve', $comment) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                    class="w-full bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-700">
                                <i class="fas fa-check mr-2"></i>Approve Comment
                            </button>
                        </form>
                    @endif
                    
                    <form method="POST" action="{{ route('admin.comments.destroy', $comment) }}" 
                          onsubmit="return confirm('Are you sure you want to delete this comment?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-700">
                            <i class="fas fa-trash mr-2"></i>Delete Comment
                        </button>
                    </form>
                </div>
            </div>

            <!-- Comment Info -->
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Information</h3>
                <div class="space-y-3">
                    <div>
                        <span class="text-sm text-gray-600 block mb-1">Status</span>
                        <span class="status-badge status-{{ $comment->status }}">
                            {{ ucfirst($comment->status) }}
                        </span>
                    </div>
                    <div>
                        <span class="text-sm text-gray-600 block mb-1">Author Name</span>
                        <span class="text-sm font-medium text-gray-900">{{ $comment->name }}</span>
                    </div>
                    <div>
                        <span class="text-sm text-gray-600 block mb-1">Author Email</span>
                        <a href="mailto:{{ $comment->email }}" 
                           class="text-sm font-medium text-purple-600 hover:text-purple-800">
                            {{ $comment->email }}
                        </a>
                    </div>
                    <div>
                        <span class="text-sm text-gray-600 block mb-1">Submitted</span>
                        <span class="text-sm font-medium text-gray-900">
                            {{ $comment->created_at->format('M d, Y') }}
                        </span>
                        <span class="text-xs text-gray-500 block">
                            {{ $comment->created_at->diffForHumans() }}
                        </span>
                    </div>
                    @if($comment->updated_at != $comment->created_at)
                        <div>
                            <span class="text-sm text-gray-600 block mb-1">Last Updated</span>
                            <span class="text-sm font-medium text-gray-900">
                                {{ $comment->updated_at->format('M d, Y') }}
                            </span>
                            <span class="text-xs text-gray-500 block">
                                {{ $comment->updated_at->diffForHumans() }}
                            </span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
