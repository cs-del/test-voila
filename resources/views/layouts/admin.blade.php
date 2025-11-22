<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Admin Panel - Creative CMS">
    <title>@yield('title', 'Admin Panel') - Creative CMS</title>
    
    <!-- Alpine.js for interactive components -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Chart.js for data visualization -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>
    
    <!-- Tailwind CSS via CDN for modern styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'display': ['Inter', 'system-ui', 'sans-serif'],
                        'body': ['Inter', 'system-ui', 'sans-serif']
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-in': 'slideIn 0.3s ease-out',
                        'scale-in': 'scaleIn 0.4s ease-out',
                    }
                }
            }
        }
    </script>
    
    <!-- Custom CSS for admin-specific styling -->
    <style>
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideIn {
            from { transform: translateX(-100%); }
            to { transform: translateX(0); }
        }
        
        @keyframes scaleIn {
            from { transform: scale(0.95); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
        
        .admin-sidebar {
            background: linear-gradient(180deg, #1f2937 0%, #111827 100%);
        }
        
        .admin-card {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
        }
        
        .admin-card:hover {
            box-shadow: 0 10px 25px 0 rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }
        
        .sidebar-link {
            position: relative;
            overflow: hidden;
        }
        
        .sidebar-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 3px;
            background: linear-gradient(180deg, #7c3aed, #3b82f6);
            transform: scaleY(0);
            transition: transform 0.3s ease;
        }
        
        .sidebar-link:hover::before,
        .sidebar-link.active::before {
            transform: scaleY(1);
        }
        
        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .stats-card.success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }
        
        .stats-card.warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }
        
        .stats-card.danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        }
        
        .table-row:hover {
            background-color: #f9fafb;
        }
        
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        .status-published {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .status-draft {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .status-pending {
            background-color: #e0f2fe;
            color: #0c4a6e;
        }
        
        .status-approved {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .status-rejected {
            background-color: #fee2e2;
            color: #991b1b;
        }
    </style>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Quill.js WYSIWYG Editor -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    
    <!-- Quill.js Custom Styles -->
    <style>
        .ql-container {
            font-family: 'Inter', sans-serif;
            font-size: 14px;
        }
        
        .ql-editor {
            min-height: 300px;
            max-height: 600px;
        }
        
        .quill-wrapper {
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            background: white;
        }
        
        .quill-wrapper:focus-within {
            border-color: #7c3aed;
            box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
        }
        
        .ql-toolbar {
            border-top: 1px solid #d1d5db;
            border-left: 1px solid #d1d5db;
            border-right: 1px solid #d1d5db;
            border-bottom: none;
            border-radius: 0.375rem 0.375rem 0 0;
            background: #f9fafb;
        }
        
        .ql-container {
            border-bottom: 1px solid #d1d5db;
            border-left: 1px solid #d1d5db;
            border-right: 1px solid #d1d5db;
            border-top: none;
            border-radius: 0 0 0.375rem 0.375rem;
        }
    </style>
    
    @stack('styles')
</head>
<body class="h-full bg-gray-50 font-body">
    <div class="min-h-full">
        <!-- Mobile menu overlay -->
        <div class="fixed inset-0 flex z-40 md:hidden" role="dialog" aria-modal="true" style="display: none;">
            <div class="fixed inset-0 bg-gray-600 bg-opacity-75" aria-hidden="true"></div>
            
            <div class="relative flex-1 flex flex-col max-w-xs w-full bg-gray-800">
                <div class="absolute top-0 right-0 -mr-12 pt-2">
                    <button type="button" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" id="close-mobile-menu">
                        <span class="sr-only">Close sidebar</span>
                        <i class="fas fa-times text-white h-6 w-6"></i>
                    </button>
                </div>
                
                <!-- Mobile sidebar content -->
                <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto admin-sidebar">
                    <div class="flex-shrink-0 flex items-center px-4">
                        <div class="flex items-center space-x-2">
                            <div class="w-8 h-8 bg-gradient-to-r from-purple-600 to-blue-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-palette text-white text-sm"></i>
                            </div>
                            <span class="text-white text-lg font-bold">Creative CMS</span>
                        </div>
                    </div>
                    <nav class="mt-5 px-2 space-y-1">
                        <a href="{{ route('admin.dashboard') }}" 
                           class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }} text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-base font-medium rounded-md">
                            <i class="fas fa-tachometer-alt mr-3"></i>
                            Dashboard
                        </a>
                        <a href="{{ route('admin.articles.index') }}" 
                           class="sidebar-link {{ request()->routeIs('admin.articles.*') ? 'active' : '' }} text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-base font-medium rounded-md">
                            <i class="fas fa-newspaper mr-3"></i>
                            Articles
                        </a>
                        <a href="{{ route('admin.categories.index') }}" 
                           class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }} text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-base font-medium rounded-md">
                            <i class="fas fa-folder mr-3"></i>
                            Categories
                        </a>
                        <a href="{{ route('admin.comments.index') }}" 
                           class="sidebar-link {{ request()->routeIs('admin.comments.*') ? 'active' : '' }} text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-base font-medium rounded-md">
                            <i class="fas fa-comments mr-3"></i>
                            Comments
                        </a>
                        <a href="{{ route('admin.contacts.index') }}" 
                           class="sidebar-link {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }} text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-base font-medium rounded-md">
                            <i class="fas fa-envelope mr-3"></i>
                            Contact Messages
                        </a>
                    </nav>
                </div>
                <div class="flex-shrink-0 flex bg-gray-700 p-4">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-r from-purple-600 to-blue-600 rounded-full flex items-center justify-center">
                            <span class="text-white text-sm font-semibold">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </span>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-white">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-300">{{ auth()->user()->role }}</p>
                        </div>
                        <a href="{{ route('home') }}" class="ml-auto text-gray-300 hover:text-white">
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Static sidebar for desktop -->
        <div class="hidden md:flex md:w-64 md:flex-col md:fixed md:inset-y-0">
            <div class="flex-1 flex flex-col min-h-0 admin-sidebar">
                <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
                    <div class="flex items-center flex-shrink-0 px-4">
                        <div class="flex items-center space-x-2">
                            <div class="w-8 h-8 bg-gradient-to-r from-purple-600 to-blue-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-palette text-white text-sm"></i>
                            </div>
                            <span class="text-white text-lg font-bold">Creative CMS</span>
                        </div>
                    </div>
                    <nav class="mt-8 flex-1 px-2 space-y-1">
                        <a href="{{ route('admin.dashboard') }}" 
                           class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }} text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <i class="fas fa-tachometer-alt mr-3"></i>
                            Dashboard
                        </a>
                        <a href="{{ route('admin.articles.index') }}" 
                           class="sidebar-link {{ request()->routeIs('admin.articles.*') ? 'active' : '' }} text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <i class="fas fa-newspaper mr-3"></i>
                            Articles
                        </a>
                        <a href="{{ route('admin.categories.index') }}" 
                           class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }} text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <i class="fas fa-folder mr-3"></i>
                            Categories
                        </a>
                        <a href="{{ route('admin.comments.index') }}" 
                           class="sidebar-link {{ request()->routeIs('admin.comments.*') ? 'active' : '' }} text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <i class="fas fa-comments mr-3"></i>
                            Comments
                        </a>
                        <a href="{{ route('admin.contacts.index') }}" 
                           class="sidebar-link {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }} text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <i class="fas fa-envelope mr-3"></i>
                            Contact Messages
                        </a>
                    </nav>
                </div>
                <div class="flex-shrink-0 flex bg-gray-700 p-4">
                    <div class="flex items-center w-full">
                        <div class="w-8 h-8 bg-gradient-to-r from-purple-600 to-blue-600 rounded-full flex items-center justify-center">
                            <span class="text-white text-sm font-semibold">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </span>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-medium text-white">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-300">{{ ucfirst(auth()->user()->role) }}</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('home') }}" 
                               class="text-gray-300 hover:text-white"
                               title="View Site">
                                <i class="fas fa-external-link-alt text-sm"></i>
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" 
                                        class="text-gray-300 hover:text-white"
                                        title="Logout">
                                    <i class="fas fa-sign-out-alt text-sm"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main content -->
        <div class="md:pl-64 flex flex-col flex-1">
            <div class="sticky top-0 z-10 md:hidden pl-1 pt-1 sm:pl-3 sm:pt-3 bg-gray-50">
                <button type="button" 
                        class="-ml-0.5 -mt-0.5 h-12 w-12 inline-flex items-center justify-center rounded-md text-gray-500 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" 
                        id="open-mobile-menu">
                    <span class="sr-only">Open sidebar</span>
                    <i class="fas fa-bars h-6 w-6"></i>
                </button>
            </div>
            
            <!-- Top navigation -->
            <div class="bg-white shadow-sm border-b border-gray-200">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center">
                            <h1 class="text-2xl font-semibold text-gray-900">@yield('page-title', 'Dashboard')</h1>
                        </div>
                        <div class="flex items-center space-x-4">
                            <!-- Quick actions -->
                            <a href="{{ route('admin.articles.create') }}" 
                               class="bg-gradient-to-r from-purple-600 to-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:from-purple-700 hover:to-blue-700 transition-all duration-200">
                                <i class="fas fa-plus mr-2"></i>
                                New Article
                            </a>
                            
                            <!-- Notifications -->
                            <div class="relative" x-data="{ open: false }">
                                <button type="button"
                                        @click="open = !open"
                                        class="bg-white p-2 rounded-full text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <span class="sr-only">View notifications</span>
                                    <i class="fas fa-bell text-lg"></i>
                                    @php
                                        $pendingCommentsCount = \App\Models\Comment::where('status', 'pending')->count();
                                        $unreviewedContactsCount = \App\Models\Contact::whereNull('reviewed_at')->count();
                                        $totalNotifications = $pendingCommentsCount + $unreviewedContactsCount;
                                    @endphp
                                    @if($totalNotifications > 0)
                                        <span class="absolute -top-1 -right-1 h-4 w-4 bg-red-500 rounded-full flex items-center justify-center">
                                            <span class="text-xs font-medium text-white">{{ $totalNotifications }}</span>
                                        </span>
                                    @endif
                                </button>
                                
                                <!-- Dropdown -->
                                <div x-show="open"
                                     @click.away="open = false"
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-150"
                                     x-transition:leave-start="opacity-100 scale-100"
                                     x-transition:leave-end="opacity-0 scale-95"
                                     class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 z-50"
                                     style="display: none;">
                                    <div class="p-4">
                                        <h3 class="text-sm font-semibold text-gray-900 mb-3">Notifications</h3>
                                        
                                        @if($totalNotifications > 0)
                                            <div class="space-y-3">
                                                @if($pendingCommentsCount > 0)
                                                    <a href="{{ route('admin.comments.index', ['status' => 'pending']) }}"
                                                       class="block p-3 bg-yellow-50 hover:bg-yellow-100 rounded-lg transition">
                                                        <div class="flex items-center">
                                                            <div class="flex-shrink-0">
                                                                <i class="fas fa-comments text-yellow-600"></i>
                                                            </div>
                                                            <div class="ml-3 flex-1">
                                                                <p class="text-sm font-medium text-gray-900">
                                                                    {{ $pendingCommentsCount }} Pending Comment{{ $pendingCommentsCount > 1 ? 's' : '' }}
                                                                </p>
                                                                <p class="text-xs text-gray-500">Click to review</p>
                                                            </div>
                                                            <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                                                        </div>
                                                    </a>
                                                @endif
                                                
                                                @if($unreviewedContactsCount > 0)
                                                    <a href="{{ route('admin.contacts.index', ['status' => 'unreviewed']) }}"
                                                       class="block p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition">
                                                        <div class="flex items-center">
                                                            <div class="flex-shrink-0">
                                                                <i class="fas fa-envelope text-blue-600"></i>
                                                            </div>
                                                            <div class="ml-3 flex-1">
                                                                <p class="text-sm font-medium text-gray-900">
                                                                    {{ $unreviewedContactsCount }} New Message{{ $unreviewedContactsCount > 1 ? 's' : '' }}
                                                                </p>
                                                                <p class="text-xs text-gray-500">Click to view</p>
                                                            </div>
                                                            <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                                                        </div>
                                                    </a>
                                                @endif
                                            </div>
                                        @else
                                            <div class="text-center py-6">
                                                <i class="fas fa-check-circle text-green-500 text-3xl mb-2"></i>
                                                <p class="text-sm text-gray-500">No new notifications</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
                    <div class="bg-green-50 border border-green-200 rounded-md p-4 animate-fade-in">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-green-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            
            @if(session('error'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
                    <div class="bg-red-50 border border-red-200 rounded-md p-4 animate-fade-in">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-circle text-red-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            
            <!-- Page Content -->
            <main class="flex-1">
                <div class="py-6">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    
    <!-- JavaScript -->
    <script>
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('open-mobile-menu');
        const mobileMenuOverlay = document.querySelector('[role="dialog"]');
        const closeMobileMenuButton = document.getElementById('close-mobile-menu');
        
        if (mobileMenuButton && mobileMenuOverlay) {
            mobileMenuButton.addEventListener('click', function() {
                mobileMenuOverlay.style.display = 'flex';
            });
            
            closeMobileMenuButton.addEventListener('click', function() {
                mobileMenuOverlay.style.display = 'none';
            });
            
            // Close menu when clicking outside
            mobileMenuOverlay.addEventListener('click', function(e) {
                if (e.target === mobileMenuOverlay) {
                    mobileMenuOverlay.style.display = 'none';
                }
            });
        }
        
        // Auto-hide alerts
        setTimeout(function() {
            const alerts = document.querySelectorAll('.animate-fade-in');
            alerts.forEach(function(alert) {
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.remove();
                }, 300);
            });
        }, 5000);
    </script>
    
    @stack('scripts')
</body>
</html>