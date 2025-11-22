@extends('layouts.admin')

@section('title', 'Create Category')
@section('page-title', 'Create Category')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Create New Category</h1>
            <p class="mt-1 text-sm text-gray-500">Add a new category to organize your content</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('admin.categories.index') }}" 
               class="bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-700">
                <i class="fas fa-arrow-left mr-2"></i>Back to Categories
            </a>
        </div>
    </div>

    <!-- Form -->
    <form method="POST" action="{{ route('admin.categories.store') }}">
        @csrf
        
        <div class="bg-white shadow-sm rounded-lg p-6 space-y-6">
            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                    Category Name <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="name" 
                       id="name" 
                       value="{{ old('name') }}"
                       required
                       class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-purple-500 focus:border-purple-500 @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                    Description
                </label>
                <textarea name="description" 
                          id="description" 
                          rows="4" 
                          class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-purple-500 focus:border-purple-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Brief description of the category</p>
            </div>

            <!-- Color -->
            <div>
                <label for="color" class="block text-sm font-medium text-gray-700 mb-1">
                    Color <span class="text-red-500">*</span>
                </label>
                <div class="flex items-center space-x-3">
                    <input type="color" 
                           name="color" 
                           id="color" 
                           value="{{ old('color', '#667eea') }}"
                           required
                           class="h-10 w-20 border border-gray-300 rounded cursor-pointer @error('color') border-red-500 @enderror">
                    <span id="color-value" class="text-sm text-gray-600 font-mono">{{ old('color', '#667eea') }}</span>
                    <div class="flex-1">
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-600">Preview:</span>
                            <div id="color-preview" 
                                 class="px-4 py-2 rounded-full text-sm font-medium"
                                 style="background-color: {{ old('color', '#667eea') }}20; color: {{ old('color', '#667eea') }};">
                                <i class="fas fa-folder mr-1"></i>
                                <span id="preview-text">New Category</span>
                            </div>
                        </div>
                    </div>
                </div>
                @error('color')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Choose a color to represent this category</p>
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                    Status <span class="text-red-500">*</span>
                </label>
                <select name="status" 
                        id="status" 
                        required
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-purple-500 focus:border-purple-500 @error('status') border-red-500 @enderror">
                    <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Inactive categories won't be visible on the frontend</p>
            </div>

            <!-- Info Box -->
            <div class="bg-blue-50 rounded-lg p-4">
                <div class="flex items-start">
                    <i class="fas fa-info-circle text-blue-500 mt-0.5 mr-3"></i>
                    <div>
                        <h4 class="text-sm font-medium text-blue-900">URL Slug</h4>
                        <p class="text-sm text-blue-700 mt-1">
                            The URL slug will be automatically generated from the category name.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.categories.index') }}" 
                   class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg text-sm font-medium hover:bg-gray-300">
                    Cancel
                </a>
                <button type="submit" 
                        class="bg-gradient-to-r from-purple-600 to-blue-600 text-white px-6 py-2 rounded-lg text-sm font-medium hover:from-purple-700 hover:to-blue-700">
                    <i class="fas fa-save mr-2"></i>Create Category
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
// Update color preview in real-time
const colorInput = document.getElementById('color');
const colorValue = document.getElementById('color-value');
const colorPreview = document.getElementById('color-preview');
const nameInput = document.getElementById('name');
const previewText = document.getElementById('preview-text');

colorInput.addEventListener('input', function() {
    const color = this.value;
    colorValue.textContent = color;
    colorPreview.style.backgroundColor = color + '20';
    colorPreview.style.color = color;
});

nameInput.addEventListener('input', function() {
    previewText.textContent = this.value || 'New Category';
});
</script>
@endpush
