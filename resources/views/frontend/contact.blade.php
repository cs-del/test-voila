@extends('layouts.app')

@section('title', 'Contact Us - Creative Digital Agency')

@section('content')
<!-- Hero Section -->
<section class="py-20 bg-gradient-to-br from-purple-900 via-blue-900 to-indigo-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="animate-fade-in">
            <div class="w-20 h-20 mx-auto mb-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                <i class="fas fa-envelope text-white text-3xl"></i>
            </div>
            
            <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">
                Get in Touch
            </h1>
            <p class="mt-6 max-w-2xl mx-auto text-xl text-purple-100">
                Have a project in mind or just want to say hello? We'd love to hear from you. 
                Let's create something amazing together.
            </p>
        </div>
    </div>
</section>

<!-- Contact Form and Info -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid gap-12 lg:grid-cols-2">
            <!-- Contact Form -->
            <div class="bg-gray-50 rounded-2xl p-8">
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Send us a message</h2>
                    <p class="text-lg text-gray-600">
                        Fill out the form below and we'll get back to you as soon as possible.
                    </p>
                </div>
                
                <form action="{{ route('contact.store') }}" method="POST" class="space-y-6" id="contactForm">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Full Name *
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name') }}"
                                   class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500 @error('name') border-red-500 @enderror" 
                                   placeholder="Your full name"
                                   required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email Address *
                            </label>
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   value="{{ old('email') }}"
                                   class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500 @error('email') border-red-500 @enderror" 
                                   placeholder="your@email.com"
                                   required>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                            Subject *
                        </label>
                        <select name="subject" 
                                id="subject" 
                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500 @error('subject') border-red-500 @enderror" 
                                required>
                            <option value="">Select a subject</option>
                            <option value="General Inquiry" {{ old('subject') == 'General Inquiry' ? 'selected' : '' }}>General Inquiry</option>
                            <option value="Project Collaboration" {{ old('subject') == 'Project Collaboration' ? 'selected' : '' }}>Project Collaboration</option>
                            <option value="Support" {{ old('subject') == 'Support' ? 'selected' : '' }}>Support</option>
                            <option value="Partnership" {{ old('subject') == 'Partnership' ? 'selected' : '' }}>Partnership</option>
                            <option value="Other" {{ old('subject') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('subject')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                            Message *
                        </label>
                        <textarea name="message" 
                                  id="message" 
                                  rows="6" 
                                  class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500 @error('message') border-red-500 @enderror" 
                                  placeholder="Tell us about your project or inquiry..."
                                  required>{{ old('message') }}</textarea>
                        @error('message')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   id="consent" 
                                   name="consent" 
                                   class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                            <label for="consent" class="ml-2 block text-sm text-gray-700">
                                I agree to the <a href="#" class="text-purple-600 hover:text-purple-800">privacy policy</a>
                            </label>
                        </div>
                        
                        <button type="submit" 
                                id="submitBtn"
                                class="bg-gradient-to-r from-purple-600 to-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:from-purple-700 hover:to-blue-700 transition-all duration-200 transform hover:scale-105">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Send Message
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Contact Information -->
            <div class="space-y-8">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Let's connect</h2>
                    <p class="text-lg text-gray-600 mb-8">
                        We're here to help bring your ideas to life. Whether you're a startup looking 
                        for digital solutions or an established business wanting to innovate, 
                        we're excited to work with you.
                    </p>
                </div>
                
                <!-- Contact Methods -->
                <div class="space-y-6">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-r from-purple-600 to-blue-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-envelope text-white text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-1">Email Us</h3>
                            <p class="text-gray-600">hello@creativecms.com</p>
                            <p class="text-gray-600">support@creativecms.com</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-r from-purple-600 to-blue-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-phone text-white text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-1">Call Us</h3>
                            <p class="text-gray-600">+1 (555) 123-4567</p>
                            <p class="text-gray-600">Mon - Fri, 9AM - 6PM EST</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-r from-purple-600 to-blue-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-map-marker-alt text-white text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-1">Visit Us</h3>
                            <p class="text-gray-600">123 Creative Street</p>
                            <p class="text-gray-600">Design District, NY 10001</p>
                        </div>
                    </div>
                </div>
                
                <!-- Social Links -->
                <div class="pt-8 border-t border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Follow Us</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center hover:bg-blue-100 hover:text-blue-600 transition-colors">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center hover:bg-blue-600 hover:text-white transition-colors">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center hover:bg-pink-100 hover:text-pink-600 transition-colors">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center hover:bg-blue-700 hover:text-white transition-colors">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center hover:bg-red-100 hover:text-red-600 transition-colors">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>
                
                <!-- FAQ Link -->
                <div class="bg-gradient-to-r from-purple-50 to-blue-50 p-6 rounded-xl">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Quick Response</h3>
                    <p class="text-gray-600 mb-4">
                        We typically respond to all inquiries within 24 hours during business days.
                    </p>
                    <div class="flex items-center text-sm text-purple-600">
                        <i class="fas fa-clock mr-2"></i>
                        <span>Average response time: 4 hours</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section (placeholder) -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 sm:text-4xl">Find Us</h2>
            <p class="mt-4 text-lg text-gray-600">Located in the heart of the design district</p>
        </div>
        
        <div class="bg-gray-200 h-96 rounded-xl flex items-center justify-center">
            <div class="text-center">
                <i class="fas fa-map-marked-alt text-6xl text-gray-400 mb-4"></i>
                <p class="text-gray-500 text-lg">Interactive map would be here</p>
                <p class="text-gray-400">123 Creative Street, Design District, NY 10001</p>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-16 bg-gradient-to-r from-purple-900 to-blue-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold text-white sm:text-4xl">Ready to start your project?</h2>
        <p class="mt-4 text-xl text-purple-100">
            Let's discuss how we can help bring your vision to life.
        </p>
        <div class="mt-8">
            <a href="#contact" 
               class="bg-white text-purple-900 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-all duration-200 transform hover:scale-105">
                Send a Message
            </a>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
// Form submission handling
document.getElementById('contactForm').addEventListener('submit', function(e) {
    const submitBtn = document.getElementById('submitBtn');
    const consent = document.getElementById('consent');
    
    // Check if consent is given
    if (!consent.checked) {
        e.preventDefault();
        alert('Please agree to the privacy policy before submitting.');
        consent.focus();
        return;
    }
    
    // Show loading state
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Sending...';
    submitBtn.disabled = true;
});

// Character counter for message textarea
const messageTextarea = document.getElementById('message');
const maxLength = 1000;
const counter = document.createElement('div');
counter.className = 'text-right text-sm text-gray-500 mt-1';
messageTextarea.parentNode.appendChild(counter);

function updateCounter() {
    const remaining = maxLength - messageTextarea.value.length;
    counter.textContent = `${remaining} characters remaining`;
    
    if (remaining < 0) {
        counter.className = 'text-right text-sm text-red-500 mt-1';
    } else if (remaining < 50) {
        counter.className = 'text-right text-sm text-yellow-600 mt-1';
    } else {
        counter.className = 'text-right text-sm text-gray-500 mt-1';
    }
}

messageTextarea.addEventListener('input', updateCounter);
updateCounter(); // Initial call

// Smooth scroll to contact form
document.querySelectorAll('a[href="#contact"]').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('contactForm').scrollIntoView({
            behavior: 'smooth'
        });
    });
});
</script>
@endpush