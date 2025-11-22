@extends('layouts.admin')

@section('title', 'Contact Message Details')
@section('page-title', 'Contact Message')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Contact Message Details</h1>
            <p class="mt-1 text-sm text-gray-500">View and manage contact message</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('admin.contacts.index') }}" 
               class="bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-700">
                <i class="fas fa-arrow-left mr-2"></i>Back to Messages
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Contact Info -->
            <div class="bg-white shadow-sm rounded-lg p-6">
                <div class="flex items-start space-x-4 mb-6">
                    <div class="w-16 h-16 bg-gradient-to-r from-purple-600 to-blue-600 rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="text-white text-2xl font-semibold">
                            {{ strtoupper(substr($contact->name, 0, 1)) }}
                        </span>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $contact->name }}</h3>
                            @if(is_null($contact->reviewed_at))
                                <span class="status-badge status-pending">
                                    Unreviewed
                                </span>
                            @else
                                <span class="status-badge status-approved">
                                    Reviewed
                                </span>
                            @endif
                        </div>
                        <p class="text-sm text-gray-500">
                            <i class="fas fa-envelope mr-1"></i>
                            <a href="mailto:{{ $contact->email }}" class="hover:text-purple-600">
                                {{ $contact->email }}
                            </a>
                        </p>
                        @if($contact->phone)
                            <p class="text-sm text-gray-500 mt-1">
                                <i class="fas fa-phone mr-1"></i>
                                <a href="tel:{{ $contact->phone }}" class="hover:text-purple-600">
                                    {{ $contact->phone }}
                                </a>
                            </p>
                        @endif
                        <p class="text-xs text-gray-400 mt-2">
                            <i class="fas fa-clock mr-1"></i>
                            Received {{ $contact->created_at->format('F d, Y \a\t h:i A') }}
                        </p>
                    </div>
                </div>

                <div class="border-t border-gray-200 pt-6 mb-6">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Subject</h4>
                    <p class="text-base font-medium text-gray-900">{{ $contact->subject }}</p>
                </div>

                <div class="border-t border-gray-200 pt-6">
                    <h4 class="text-sm font-medium text-gray-700 mb-3">Message</h4>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-900 whitespace-pre-wrap">{{ $contact->message }}</p>
                    </div>
                </div>
            </div>

            <!-- Reply Section -->
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Reply</h3>
                <div class="space-y-4">
                    <p class="text-sm text-gray-600">
                        You can reply to this message directly via email:
                    </p>
                    <a href="mailto:{{ $contact->email }}?subject=Re: {{ urlencode($contact->subject) }}" 
                       class="inline-flex items-center bg-blue-600 text-white px-6 py-3 rounded-lg text-sm font-medium hover:bg-blue-700">
                        <i class="fas fa-reply mr-2"></i>
                        Reply via Email
                    </a>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Actions Card -->
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions</h3>
                <div class="space-y-2">
                    <form method="POST" action="{{ route('admin.contacts.mark-reviewed', $contact) }}">
                        @csrf
                        @method('PATCH')
                        @if(is_null($contact->reviewed_at))
                            <button type="submit"
                                    class="w-full bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-700">
                                <i class="fas fa-check mr-2"></i>Mark as Reviewed
                            </button>
                        @else
                            <button type="submit"
                                    class="w-full bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-yellow-700">
                                <i class="fas fa-undo mr-2"></i>Mark as Unreviewed
                            </button>
                        @endif
                    </form>
                    
                    <a href="mailto:{{ $contact->email }}" 
                       class="block w-full text-center bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700">
                        <i class="fas fa-reply mr-2"></i>Reply via Email
                    </a>
                    
                    <form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}" 
                          onsubmit="return confirm('Are you sure you want to delete this message?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-700">
                            <i class="fas fa-trash mr-2"></i>Delete Message
                        </button>
                    </form>
                </div>
            </div>

            <!-- Message Info -->
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Information</h3>
                <div class="space-y-3">
                    <div>
                        <span class="text-sm text-gray-600 block mb-1">Status</span>
                        @if(is_null($contact->reviewed_at))
                            <span class="status-badge status-pending">
                                Unreviewed
                            </span>
                        @else
                            <span class="status-badge status-approved">
                                Reviewed
                            </span>
                        @endif
                    </div>
                    <div>
                        <span class="text-sm text-gray-600 block mb-1">Name</span>
                        <span class="text-sm font-medium text-gray-900">{{ $contact->name }}</span>
                    </div>
                    <div>
                        <span class="text-sm text-gray-600 block mb-1">Email</span>
                        <a href="mailto:{{ $contact->email }}" 
                           class="text-sm font-medium text-purple-600 hover:text-purple-800">
                            {{ $contact->email }}
                        </a>
                    </div>
                    @if($contact->phone)
                        <div>
                            <span class="text-sm text-gray-600 block mb-1">Phone</span>
                            <a href="tel:{{ $contact->phone }}" 
                               class="text-sm font-medium text-purple-600 hover:text-purple-800">
                                {{ $contact->phone }}
                            </a>
                        </div>
                    @endif
                    <div>
                        <span class="text-sm text-gray-600 block mb-1">Received</span>
                        <span class="text-sm font-medium text-gray-900">
                            {{ $contact->created_at->format('M d, Y') }}
                        </span>
                        <span class="text-xs text-gray-500 block">
                            {{ $contact->created_at->diffForHumans() }}
                        </span>
                    </div>
                    @if($contact->reviewed_at)
                        <div>
                            <span class="text-sm text-gray-600 block mb-1">Reviewed</span>
                            <span class="text-sm font-medium text-gray-900">
                                {{ $contact->reviewed_at->format('M d, Y') }}
                            </span>
                            <span class="text-xs text-gray-500 block">
                                {{ $contact->reviewed_at->diffForHumans() }}
                            </span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="bg-gradient-to-br from-purple-50 to-blue-50 rounded-lg p-6 border border-purple-100">
                <div class="flex items-center space-x-3 mb-3">
                    <div class="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-info-circle text-white"></i>
                    </div>
                    <h4 class="text-sm font-semibold text-gray-900">Message Details</h4>
                </div>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Characters:</span>
                        <span class="font-medium text-gray-900">{{ strlen($contact->message) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Words:</span>
                        <span class="font-medium text-gray-900">{{ str_word_count($contact->message) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
