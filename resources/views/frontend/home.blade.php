@extends('layouts.app')

@section('title', 'Home - FH Digital')

@section('content')
<!-- Hero Section -->
<section class="relative overflow-hidden bg-gradient-to-br from-purple-900 via-blue-900 to-indigo-900">
    <div class="absolute inset-0 bg-black opacity-50"></div>
    <div class="relative max-w-7xl mx-auto py-24 px-4 sm:py-32 sm:px-6 lg:px-8 lg:py-40">
        <div class="text-center animate-fade-in">
            <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">
                <span class="block">Welcome to</span>
                <span class="block bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent">
                    FH Digital
                </span>
            </h1>
            <p class="mt-6 max-w-2xl mx-auto text-xl text-gray-300">
                Discover cutting-edge insights on technology, design, development, and digital innovation. 
                Join our community of creative professionals and thought leaders.
            </p>
            <div class="mt-10 flex justify-center space-x-4">
                <a href="#articles" class="bg-gradient-to-r from-purple-600 to-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:from-purple-700 hover:to-blue-700 transition-all duration-200 transform hover:scale-105">
                    Explore Articles
                </a>
                <a href="{{ route('contact') }}" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-gray-900 transition-all duration-200">
                    Get in Touch
                </a>
            </div>
        </div>
    </div>
    
    <!-- Floating Elements -->
    <div class="absolute top-20 left-10 w-20 h-20 bg-purple-500 rounded-full opacity-20 animate-float"></div>
    <div class="absolute top-40 right-20 w-16 h-16 bg-blue-500 rounded-full opacity-20 animate-float" style="animation-delay: 1s;"></div>
    <div class="absolute bottom-20 left-20 w-12 h-12 bg-pink-500 rounded-full opacity-20 animate-float" style="animation-delay: 2s;"></div>
</section>

<!-- Search and Filter Section -->
<section id="articles" class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 sm:text-4xl">Latest Articles</h2>
            <p class="mt-4 text-lg text-gray-600">Discover insights and inspiration from our creative community</p>
        </div>
        
        <!-- Search and Filter Form -->
        <div class="mb-8 bg-gray-50 p-6 rounded-xl">
            <form method="GET" action="{{ route('home') }}" class="flex flex-col md:flex-row gap-4 items-end">
                <div class="flex-1">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search Articles</label>
                    <div class="relative">
                        <input type="text" name="search" id="search" value="{{ request('search') }}" 
                               class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500" 
                               placeholder="Search for articles...">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                    </div>
                </div>
                
                <div class="w-full md:w-64">
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Filter by Category</label>
                    <select name="category" id="category" class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <button type="submit" class="bg-gradient-to-r from-purple-600 to-blue-600 text-white px-6 py-2 rounded-lg font-semibold hover:from-purple-700 hover:to-blue-700 transition-all duration-200">
                    Filter
                </button>
                
                @if(request('search') || request('category'))
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-purple-600 px-4 py-2">
                        <i class="fas fa-times mr-1"></i>Clear
                    </a>
                @endif
            </form>
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
                            <div class="h-48 bg-gradient-to-br from-purple-400 to-blue-400 flex items-center justify-center">
                                <i class="fas fa-image text-white text-4xl opacity-50"></i>
                            </div>
                        @endif
                        
                        <div class="p-6">
                            <!-- Categories -->
                            <div class="flex flex-wrap gap-2 mb-3">
                                @foreach($article->categories as $category)
                                    <a href="{{ route('category.show', $category->slug) }}" 
                                       class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                       style="background-color: {{ $category->color }}20; color: {{ $category->color }};">
                                        {{ $category->name }}
                                    </a>
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
                            <div class="flex items-center justify-between text-sm text-gray-500">
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
                            
                            <!-- Comments count -->
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <div class="flex items-center justify-between">
                                    <a href="{{ route('article.show', $article->slug) }}" 
                                       class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                                        Read more →
                                    </a>
                                    @if($article->approvedComments->count() > 0)
                                        <span class="text-gray-500 text-sm">
                                            <i class="fas fa-comment mr-1"></i>
                                            {{ $article->approvedComments->count() }} comments
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
            <div class="text-center py-12">
                <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-search text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No articles found</h3>
                <p class="text-gray-500 mb-6">Try adjusting your search or filter criteria.</p>
                <a href="{{ route('home') }}" class="text-purple-600 hover:text-purple-800 font-medium">
                    View all articles
                </a>
            </div>
        @endif
    </div>
</section>

<!-- Featured Categories -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 sm:text-4xl">Explore Categories</h2>
            <p class="mt-4 text-lg text-gray-600">Find content that matches your interests</p>
        </div>
        
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($categories->take(6) as $category)
                <a href="{{ route('category.show', $category->slug) }}" 
                   class="group relative p-6 bg-white rounded-xl border border-gray-200 hover:border-purple-300 hover:shadow-lg transition-all duration-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-12 h-12 rounded-lg flex items-center justify-center"
                             style="background-color: {{ $category->color }}20;">
                            <i class="fas fa-folder text-lg" style="color: {{ $category->color }};"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900 group-hover:text-purple-600 transition-colors">
                                {{ $category->name }}
                            </h3>
                            <p class="text-sm text-gray-500">{{ $category->articles->count() }} articles</p>
                        </div>
                    </div>
                    @if($category->description)
                        <p class="mt-4 text-sm text-gray-600">{{ Str::limit($category->description, 100) }}</p>
                    @endif
                </a>
            @endforeach
        </div>
        
        <div class="text-center mt-12">
            <a href="#" class="text-purple-600 hover:text-purple-800 font-medium">
                View all categories →
            </a>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-16 bg-gradient-to-r from-purple-900 to-blue-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold text-white sm:text-4xl">Ready to get started?</h2>
        <p class="mt-4 text-xl text-purple-100">
            Join our community and start creating amazing content today.
        </p>
        <div class="mt-8 flex justify-center space-x-4">
            <a href="{{ route('contact') }}" 
               class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-purple-900 transition-all duration-200">
                Contact Us
            </a>
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
// Add loading states to form
document.querySelector('form').addEventListener('submit', function() {
    const submitBtn = this.querySelector('button[type="submit"]');
    if (submitBtn) {
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Loading...';
        submitBtn.disabled = true;
    }
});

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

document.querySelectorAll('.card-hover').forEach(card => {
    card.style.opacity = '0';
    card.style.transform = 'translateY(30px)';
    card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    observer.observe(card);
});
</script>
@endpush