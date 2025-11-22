@extends('layouts.app')

@section('title', $article->title . ' - Creative Digital Agency')

@section('content')
<!-- Breadcrumb -->
<div class="bg-gray-50 py-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-purple-600">
                        <i class="fas fa-home w-4 h-4"></i>
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 w-4 h-4"></i>
                        <a href="{{ route('category.show', $article->categories->first()->slug ?? '') }}" 
                           class="text-gray-700 hover:text-purple-600 ml-1">
                            {{ $article->categories->first()->name ?? 'Uncategorized' }}
                        </a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 w-4 h-4"></i>
                        <span class="text-gray-500 ml-1">{{ Str::limit($article->title, 50) }}</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>
</div>

<!-- Article Header -->
<section class="py-12 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <article class="animate-fade-in">
            <!-- Categories -->
            <div class="flex flex-wrap gap-2 mb-4">
                @foreach($article->categories as $category)
                    <a href="{{ route('category.show', $category->slug) }}" 
                       class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium"
                       style="background-color: {{ $category->color }}20; color: {{ $category->color }};">
                        <i class="fas fa-folder mr-1"></i>
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
            
            <!-- Title -->
            <h1 class="text-4xl font-extrabold text-gray-900 sm:text-5xl mb-6 leading-tight">
                {{ $article->title }}
            </h1>
            
            <!-- Meta Information -->
            <div class="flex flex-wrap items-center gap-6 mb-8 text-gray-600">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gradient-to-r from-purple-600 to-blue-600 rounded-full flex items-center justify-center mr-3">
                        <span class="text-white font-semibold">
                            {{ strtoupper(substr($article->user->name, 0, 1)) }}
                        </span>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900">{{ $article->user->name }}</p>
                        <p class="text-sm">{{ $article->published_at->format('F d, Y') }}</p>
                    </div>
                </div>
                
                <div class="flex items-center">
                    <i class="fas fa-clock mr-2"></i>
                    <span>{{ estimated_reading_time($article->content) }} min read</span>
                </div>
                
                @if($article->approvedComments->count() > 0)
                    <div class="flex items-center">
                        <i class="fas fa-comments mr-2"></i>
                        <span>{{ $article->approvedComments->count() }} {{ Str::plural('comment', $article->approvedComments->count()) }}</span>
                    </div>
                @endif
            </div>
            
            <!-- Featured Image -->
            @if($article->featured_image)
                <div class="mb-8">
                    <img src="{{ Storage::url($article->featured_image) }}" 
                         alt="{{ $article->title }}" 
                         class="w-full h-96 object-cover rounded-xl shadow-lg">
                </div>
            @endif
            
            <!-- Excerpt -->
            <div class="bg-gradient-to-r from-purple-50 to-blue-50 p-6 rounded-xl mb-8 border-l-4 border-purple-500">
                <p class="text-lg text-gray-700 italic">{{ $article->excerpt }}</p>
            </div>
            
            <!-- Article Content -->
            <div class="prose prose-lg max-w-none">
                {!! $article->content !!}
            </div>
            
            <!-- Article Tags/Share -->
            <div class="mt-12 pt-8 border-t border-gray-200">
                <div class="flex flex-wrap items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-600 font-medium">Share:</span>
                        <a href="https://twitter.com/intent/tweet?text={{ urlencode($article->title) }}&url={{ urlencode(request()->url()) }}" 
                           target="_blank" 
                           class="text-blue-500 hover:text-blue-700">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                           target="_blank" 
                           class="text-blue-600 hover:text-blue-800">
                            <i class="fab fa-facebook text-xl"></i>
                        </a>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}" 
                           target="_blank" 
                           class="text-blue-700 hover:text-blue-900">
                            <i class="fab fa-linkedin text-xl"></i>
                        </a>
                        <button onclick="navigator.clipboard.writeText('{{ request()->url() }}')" 
                                class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-link text-xl"></i>
                        </button>
                    </div>
                    
                    <div class="flex items-center space-x-2">
                        <span class="text-gray-600 text-sm">Published on:</span>
                        <span class="text-gray-900 font-medium">{{ $article->published_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>
        </article>
    </div>
</section>

<!-- Comments Section -->
<section class="py-12 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-sm p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-8">
                Comments ({{ $article->approvedComments->count() }})
            </h2>
            
            <!-- Comment Form -->
            <div class="mb-12">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Leave a Comment</h3>
                <form action="{{ route('article.comment', $article->slug) }}" method="POST" class="space-y-6" id="commentForm">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name *</label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name') }}"
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500 @error('name') border-red-500 @enderror" 
                                   required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   value="{{ old('email') }}"
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500 @error('email') border-red-500 @enderror" 
                                   required>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div>
                        <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">Comment *</label>
                        <textarea name="comment" 
                                  id="comment" 
                                  rows="5" 
                                  class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500 @error('comment') border-red-500 @enderror" 
                                  placeholder="Share your thoughts..." 
                                  required>{{ old('comment') }}</textarea>
                        @error('comment')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <p class="text-sm text-gray-600">
                            <i class="fas fa-info-circle mr-1"></i>
                            Your comment will be reviewed before appearing on this page.
                        </p>
                        
                        <button type="submit" 
                                id="submitComment"
                                class="bg-gradient-to-r from-purple-600 to-blue-600 text-white px-6 py-2 rounded-lg font-semibold hover:from-purple-700 hover:to-blue-700 transition-all duration-200 transform hover:scale-105">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Post Comment
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Existing Comments -->
            @if($article->approvedComments->count() > 0)
                <div class="space-y-8">
                    @foreach($article->approvedComments as $comment)
                        <div class="bg-gray-50 rounded-lg p-6 animate-slide-up">
                            <div class="flex items-start space-x-4">
                                <div class="w-10 h-10 bg-gradient-to-r from-purple-600 to-blue-600 rounded-full flex items-center justify-center flex-shrink-0">
                                    <span class="text-white font-semibold text-sm">
                                        {{ strtoupper(substr($comment->name, 0, 1)) }}
                                    </span>
                                </div>
                                
                                <div class="flex-1">
                                    <div class="flex items-center space-x-2 mb-2">
                                        <h4 class="font-semibold text-gray-900">{{ $comment->name }}</h4>
                                        <span class="text-gray-500 text-sm">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-gray-700 leading-relaxed">{{ $comment->comment }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-comments text-gray-400 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No comments yet</h3>
                    <p class="text-gray-500">Be the first to share your thoughts!</p>
                </div>
            @endif
        </div>
    </div>
</section>

<!-- Related Articles -->
@if($relatedArticles->count() > 0)
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 sm:text-4xl">Related Articles</h2>
                <p class="mt-4 text-lg text-gray-600">You might also like these articles</p>
            </div>
            
            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                @foreach($relatedArticles as $relatedArticle)
                    <article class="bg-white rounded-xl shadow-sm overflow-hidden card-hover">
                        @if($relatedArticle->featured_image)
                            <div class="aspect-w-16 aspect-h-9">
                                <img src="{{ Storage::url($relatedArticle->featured_image) }}" 
                                     alt="{{ $relatedArticle->title }}" 
                                     class="w-full h-48 object-cover">
                            </div>
                        @else
                            <div class="h-48 bg-gradient-to-br from-purple-400 to-blue-400 flex items-center justify-center">
                                <i class="fas fa-image text-white text-4xl opacity-50"></i>
                            </div>
                        @endif
                        
                        <div class="p-6">
                            <!-- Categories -->
                            <div class="flex flex-wrap gap-2 mb-3">
                                @foreach($relatedArticle->categories as $category)
                                    <a href="{{ route('category.show', $category->slug) }}" 
                                       class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                       style="background-color: {{ $category->color }}20; color: {{ $category->color }};">
                                        {{ $category->name }}
                                    </a>
                                @endforeach
                            </div>
                            
                            <!-- Title -->
                            <h3 class="text-xl font-semibold text-gray-900 mb-2 line-clamp-2">
                                <a href="{{ route('article.show', $relatedArticle->slug) }}" class="hover:text-purple-600 transition-colors">
                                    {{ $relatedArticle->title }}
                                </a>
                            </h3>
                            
                            <!-- Excerpt -->
                            <p class="text-gray-600 mb-4 line-clamp-3">{{ $relatedArticle->excerpt }}</p>
                            
                            <!-- Meta -->
                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <span>{{ $relatedArticle->published_at->format('M d, Y') }}</span>
                                <a href="{{ route('article.show', $relatedArticle->slug) }}" 
                                   class="text-purple-600 hover:text-purple-800 font-medium">
                                    Read more →
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endif

<!-- Call to Action -->
<section class="py-16 bg-gradient-to-r from-purple-900 to-blue-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold text-white sm:text-4xl">Enjoyed this article?</h2>
        <p class="mt-4 text-xl text-purple-100">
            Subscribe to our newsletter for more creative insights.
        </p>
        <div class="mt-8">
            <a href="{{ route('contact') }}" 
               class="bg-white text-purple-900 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-all duration-200 transform hover:scale-105">
                Get in Touch
            </a>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
// Comment form submission
document.getElementById('commentForm').addEventListener('submit', function(e) {
    const submitBtn = document.getElementById('submitComment');
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Posting...';
    submitBtn.disabled = true;
});

// Copy link notification
function showNotification(message) {
    const notification = document.createElement('div');
    notification.className = 'fixed top-20 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 animate-fade-in';
    notification.innerHTML = '<i class="fas fa-check mr-2"></i>' + message;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

// Animate comments on scroll
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

document.querySelectorAll('.animate-slide-up').forEach(element => {
    element.style.opacity = '0';
    element.style.transform = 'translateY(30px)';
    element.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    observer.observe(element);
});

// Add copy link functionality
const copyButton = document.querySelector('button[onclick]');
if (copyButton) {
    copyButton.addEventListener('click', () => {
        showNotification('Link copied to clipboard!');
    });
}
</script>
@endpush

@push('styles')
<style>
    .prose {
        color: #374151;
        max-width: none;
    }
    
    .prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
        color: #111827;
        font-weight: 700;
        margin-top: 2em;
        margin-bottom: 1em;
    }
    
    .prose h2 {
        font-size: 1.5em;
        border-bottom: 2px solid #e5e7eb;
        padding-bottom: 0.5em;
    }
    
    .prose h3 {
        font-size: 1.25em;
    }
    
    .prose p {
        margin-bottom: 1.25em;
        line-height: 1.75;
    }
    
    .prose ul, .prose ol {
        margin-bottom: 1.25em;
        padding-left: 1.625em;
    }
    
    .prose li {
        margin-bottom: 0.5em;
    }
    
    .prose a {
        color: #7c3aed;
        text-decoration: underline;
        font-weight: 500;
    }
    
    .prose a:hover {
        color: #6d28d9;
    }
    
    .prose strong {
        font-weight: 600;
    }
    
    .prose blockquote {
        font-style: italic;
        border-left: 4px solid #7c3aed;
        padding-left: 1em;
        margin: 1.6em 0;
        color: #6b7280;
    }
</style>
@endpush