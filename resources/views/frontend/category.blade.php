@extends('layouts.app')

@section('title', $category->name . ' - Creative Digital Agency')

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
                        <span class="text-gray-500 ml-1">{{ $category->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>
</div>

<!-- Category Header -->
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center animate-fade-in">
            <div class="flex justify-center mb-6">
                <div class="w-20 h-20 rounded-xl flex items-center justify-center"
                     style="background-color: {{ $category->color }}20;">
                    <i class="fas fa-folder text-4xl" style="color: {{ $category->color }};"></i>
                </div>
            </div>
            
            <h1 class="text-4xl font-extrabold text-gray-900 sm:text-5xl mb-4">
                {{ $category->name }}
            </h1>
            
            @if($category->description)
                <p class="text-xl text-gray-600 max-w-3xl mx-auto mb-6">
                    {{ $category->description }}
                </p>
            @endif
            
            <div class="flex justify-center items-center space-x-6 text-gray-500">
                <div class="flex items-center">
                    <i class="fas fa-newspaper mr-2"></i>
                    <span>{{ $articles->total() }} {{ Str::plural('Article', $articles->total()) }}</span>
                </div>
                <div class="w-px h-6 bg-gray-300"></div>
                <div class="flex items-center">
                    <i class="fas fa-calendar mr-2"></i>
                    <span>Last updated {{ $articles->count() > 0 ? $articles->first()->published_at->diffForHumans() : 'never' }}</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Articles Grid -->
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($articles->count() > 0)
            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                @foreach($articles as $article)
                    <article class="bg-white rounded-xl shadow-sm overflow-hidden card-hover animate-slide-up">
                        @if($article->featured_image)
                            <div class="aspect-w-16 aspect-h-9">
                                <img src="{{ Storage::url($article->featured_image) }}" 
                                     alt="{{ $article->title }}" 
                                     class="w-full h-48 object-cover">
                            </div>
                        @else
                            <div class="h-48 flex items-center justify-center"
                                 style="background: linear-gradient(135deg, {{ $category->color }}40, {{ $category->color }}20);">
                                <i class="fas fa-image text-4xl" style="color: {{ $category->color }}; opacity: 0.5;"></i>
                            </div>
                        @endif
                        
                        <div class="p-6">
                            <!-- All categories for this article -->
                            <div class="flex flex-wrap gap-2 mb-3">
                                @foreach($article->categories as $articleCategory)
                                    @if($articleCategory->id === $category->id)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                              style="background-color: {{ $category->color }}30; color: {{ $category->color }};">
                                            <i class="fas fa-star mr-1"></i>
                                            {{ $articleCategory->name }}
                                        </span>
                                    @else
                                        <a href="{{ route('category.show', $articleCategory->slug) }}" 
                                           class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600 hover:bg-gray-200">
                                            {{ $articleCategory->name }}
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                            
                            <!-- Title -->
                            <h3 class="text-xl font-semibold text-gray-900 mb-2 line-clamp-2">
                                <a href="{{ route('article.show', $article->slug) }}" class="hover:text-purple-600 transition-colors">
                                    {{ $article->title }}
                                </a>
                            </h3>
                            
                            <!-- Excerpt -->
                            <p class="text-gray-600 mb-4 line-clamp-3">{{ $article->excerpt }}</p>
                            
                            <!-- Meta -->
                            <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-gradient-to-r from-purple-600 to-blue-600 rounded-full flex items-center justify-center">
                                        <span class="text-white text-xs font-semibold">
                                            {{ strtoupper(substr($article->user->name, 0, 1)) }}
                                        </span>
                                    </div>
                                    <span class="ml-2">{{ $article->user->name }}</span>
                                </div>
                                <span>{{ $article->published_at->format('M d, Y') }}</span>
                            </div>
                            
                            <!-- Read more and comments -->
                            <div class="pt-4 border-t border-gray-200">
                                <div class="flex items-center justify-between">
                                    <a href="{{ route('article.show', $article->slug) }}" 
                                       class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                                        Read more →
                                    </a>
                                    @if($article->approvedComments->count() > 0)
                                        <span class="text-gray-500 text-sm">
                                            <i class="fas fa-comment mr-1"></i>
                                            {{ $article->approvedComments->count() }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-12 flex justify-center">
                {{ $articles->links() }}
            </div>
        @else
            <div class="text-center py-16">
                <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-folder-open text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No articles in this category yet</h3>
                <p class="text-gray-500 mb-8">Check back later for new content in {{ $category->name }}.</p>
                <a href="{{ route('home') }}" 
                   class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 transition-all duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Browse All Articles
                </a>
            </div>
        @endif
    </div>
</section>

<!-- Related Categories -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 sm:text-4xl">Explore More Categories</h2>
            <p class="mt-4 text-lg text-gray-600">Discover content across different topics</p>
        </div>
        
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @php
                $relatedCategories = \App\Models\Category::where('id', '!=', $category->id)
                                                       ->where('status', 'active')
                                                       ->withCount('articles')
                                                       ->orderBy('articles_count', 'desc')
                                                       ->take(4)
                                                       ->get();
            @endphp
            
            @foreach($relatedCategories as $relatedCategory)
                <a href="{{ route('category.show', $relatedCategory->slug) }}" 
                   class="group relative p-6 bg-white rounded-xl border border-gray-200 hover:border-purple-300 hover:shadow-lg transition-all duration-200">
                    <div class="flex items-center justify-center mb-4">
                        <div class="w-16 h-16 rounded-xl flex items-center justify-center"
                             style="background-color: {{ $relatedCategory->color }}20;">
                            <i class="fas fa-folder text-2xl" style="color: {{ $relatedCategory->color }};"></i>
                        </div>
                    </div>
                    <div class="text-center">
                        <h3 class="text-lg font-semibold text-gray-900 group-hover:text-purple-600 transition-colors mb-2">
                            {{ $relatedCategory->name }}
                        </h3>
                        <p class="text-sm text-gray-500">{{ $relatedCategory->articles_count }} {{ Str::plural('article', $relatedCategory->articles_count) }}</p>
                        @if($relatedCategory->description)
                            <p class="text-xs text-gray-400 mt-2 line-clamp-2">{{ Str::limit($relatedCategory->description, 60) }}</p>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-16 bg-gradient-to-r from-purple-900 to-blue-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold text-white sm:text-4xl">Want to contribute?</h2>
        <p class="mt-4 text-xl text-purple-100">
            Share your knowledge with our community and help others learn.
        </p>
        <div class="mt-8">
            @auth
                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'editor')
                    <a href="{{ route('admin.articles.create') }}" 
                       class="bg-white text-purple-900 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-all duration-200 transform hover:scale-105">
                        Write an Article
                    </a>
                @else
                    <a href="{{ route('contact') }}" 
                       class="bg-white text-purple-900 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-all duration-200 transform hover:scale-105">
                        Contact Us
                    </a>
                @endif
            @else
                <a href="{{ route('register') }}" 
                   class="bg-white text-purple-900 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-all duration-200 transform hover:scale-105">
                    Join Our Community
                </a>
            @endauth
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush

@push('scripts')
<script>
// Animate cards on scroll
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

document.querySelectorAll('.animate-slide-up').forEach(card => {
    card.style.opacity = '0';
    card.style.transform = 'translateY(30px)';
    card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    observer.observe(card);
});

// Add loading state to pagination links
document.querySelectorAll('.pagination a').forEach(link => {
    link.addEventListener('click', function() {
        const cards = document.querySelectorAll('.animate-slide-up');
        cards.forEach(card => {
            card.style.opacity = '0.5';
        });
    });
});
</script>
@endpush