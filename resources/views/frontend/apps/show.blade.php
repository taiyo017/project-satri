@extends('frontend.layouts.app')

@section('title', $app->name . ' - Download')

@section('content')
{{-- Hero Section with App Info --}}
<section class="relative bg-gradient-to-br from-[#1363C6] via-[#115CB8] to-[#0D4A8F] dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 overflow-hidden py-16 md:py-24">
    {{-- Background Pattern --}}
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: linear-gradient(rgba(255,255,255,.15) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.15) 1px, transparent 1px); background-size: 60px 60px;"></div>
    </div>

    {{-- Gradient Orbs --}}
    <div class="absolute top-10 right-10 w-96 h-96 bg-[#4CAFF9] rounded-full opacity-20 blur-3xl"></div>
    <div class="absolute bottom-10 left-10 w-80 h-80 bg-[#4CAFF9] rounded-full opacity-20 blur-3xl"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 sm:px-10 md:px-16 lg:px-20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            {{-- Left: App Info --}}
            <div class="text-center lg:text-left">
                <div class="flex items-center justify-center lg:justify-start gap-4 mb-6">
                    @if ($app->icon)
                        <img src="{{ asset('storage/' . $app->icon) }}" alt="{{ $app->name }}"
                            class="w-24 h-24 md:w-32 md:h-32 rounded-3xl shadow-2xl border-4 border-white/20">
                    @else
                        <div class="w-24 h-24 md:w-32 md:h-32 rounded-3xl shadow-2xl border-4 border-white/20 flex items-center justify-center bg-white/10 backdrop-blur-sm">
                            <svg class="w-12 h-12 md:w-16 md:h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif
                </div>

                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                    {{ $app->name }}
                </h1>

                @if ($app->category)
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full mb-6"
                        style="background-color: {{ $app->category->color }}30; border: 2px solid {{ $app->category->color }};">
                        <span class="font-semibold text-sm" style="color: {{ $app->category->color }};">
                            {{ $app->category->name }}
                        </span>
                    </div>
                @endif

                @if ($app->short_description)
                    <p class="text-xl text-white/90 mb-8 leading-relaxed">
                        {{ $app->short_description }}
                    </p>
                @endif

                <div class="flex flex-wrap items-center justify-center lg:justify-start gap-4 text-white/80 text-sm mb-8">
                    @if ($app->latestVersion)
                        <div class="flex items-center gap-2 bg-white/10 backdrop-blur-sm px-4 py-2 rounded-full">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                            <span class="font-semibold">Version {{ $app->latestVersion->version_number }}</span>
                        </div>
                    @endif
                    <div class="flex items-center gap-2 bg-white/10 backdrop-blur-sm px-4 py-2 rounded-full">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        <span class="font-semibold">{{ number_format($app->download_count) }} Downloads</span>
                    </div>
                    @if ($app->is_featured)
                        <div class="flex items-center gap-2 bg-yellow-500/20 backdrop-blur-sm px-4 py-2 rounded-full border-2 border-yellow-500/50">
                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <span class="font-semibold text-yellow-400">Featured</span>
                        </div>
                    @endif
                </div>

                <a href="{{ route('frontend.apps.download', $app->slug) }}"
                    class="group inline-flex items-center justify-center gap-3 bg-white text-[#1363C6] font-bold rounded-full px-8 py-4 text-lg transition-all duration-300 hover:shadow-2xl hover:shadow-white/30 hover:scale-105 active:scale-95">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    <span>Download for {{ ucfirst($platform) }}</span>
                </a>
            </div>

            {{-- Right: QR Code --}}
            @if ($app->qrCode && $app->qrCode->qr_code_path)
                <div class="flex items-center justify-center lg:justify-end">
                    <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-2xl border-4 border-white/20 backdrop-blur-sm">
                        <img src="{{ $app->qrCode->getQrCodeUrl() }}" alt="QR Code"
                            class="w-48 h-48 md:w-56 md:h-56">
                        <p class="text-center text-gray-600 dark:text-gray-400 mt-4 font-semibold">
                            Scan to Download
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

{{-- About Section --}}
@if ($app->description)
    <section class="py-16 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-6 sm:px-10 md:px-16 lg:px-20">
            <div class="max-w-4xl mx-auto">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-6 text-center">
                    About this app
                </h2>
                <div class="prose prose-lg dark:prose-invert max-w-none text-gray-600 dark:text-gray-400 leading-relaxed">
                    {!! nl2br(e($app->description)) !!}
                </div>
            </div>
        </div>
    </section>
@endif

{{-- Screenshots Section --}}
@if ($app->screenshots->count() > 0)
    <section class="py-16 bg-gray-50 dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-6 sm:px-10 md:px-16 lg:px-20">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-12 text-center">
                Screenshots
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($app->screenshots->take(6) as $screenshot)
                    <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2">
                        <img src="{{ $screenshot->getImageUrl() }}" alt="Screenshot"
                            class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-300">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

{{-- What's New Section --}}
@if ($app->latestVersion && $app->latestVersion->release_notes)
    <section class="py-16 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-6 sm:px-10 md:px-16 lg:px-20">
            <div class="max-w-4xl mx-auto">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center bg-[#1363C6]/10">
                        <svg class="w-6 h-6 text-[#1363C6]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white">
                        What's New
                    </h2>
                </div>
                <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700 rounded-2xl p-8 border border-gray-200 dark:border-gray-600">
                    <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line leading-relaxed">{{ $app->latestVersion->release_notes }}</p>
                </div>
            </div>
        </div>
    </section>
@endif

{{-- Reviews Section --}}
<section class="py-16 bg-gradient-to-b from-white to-gray-50 dark:from-gray-900 dark:to-gray-800" 
    x-data="{
        showModal: false,
        rating: 0,
        reviewer_name: '',
        reviewer_email: '',
        review: '',
        submitting: false,
        errors: {},
        successMessage: '',
        
        submitReview() {
            this.submitting = true;
            this.errors = {};
            this.successMessage = '';
            
            fetch('{{ route('frontend.apps.reviews.store', $app->slug) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    rating: this.rating,
                    reviewer_name: this.reviewer_name,
                    reviewer_email: this.reviewer_email,
                    review: this.review
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.successMessage = data.message;
                    setTimeout(() => {
                        this.showModal = false;
                        location.reload();
                    }, 2000);
                } else {
                    this.errors = data.errors || {};
                }
            })
            .catch(error => {
                console.error('Error:', error);
                this.errors = { general: ['An error occurred. Please try again.'] };
            })
            .finally(() => {
                this.submitting = false;
            });
        }
    }">
    <div class="max-w-7xl mx-auto px-6 sm:px-10 md:px-16 lg:px-20">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Left: Rating Overview --}}
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 border border-gray-200 dark:border-gray-700 sticky top-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Rating Overview</h3>
                    
                    <div class="text-center mb-6">
                        <div class="text-5xl font-bold text-gray-900 dark:text-white mb-2">
                            {{ number_format($app->average_rating, 1) }}
                        </div>
                        <div class="flex items-center justify-center gap-1 mb-2">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg class="w-6 h-6 {{ $i <= round($app->average_rating) ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            @endfor
                        </div>
                        <p class="text-gray-600 dark:text-gray-400">Based on {{ $app->review_count }} {{ Str::plural('review', $app->review_count) }}</p>
                    </div>

                    {{-- Rating Breakdown --}}
                    @php
                        $ratingCounts = $app->approvedReviews()->selectRaw('rating, COUNT(*) as count')->groupBy('rating')->pluck('count', 'rating');
                        $totalReviews = $app->review_count ?: 1;
                    @endphp
                    <div class="space-y-2 mb-6">
                        @for ($i = 5; $i >= 1; $i--)
                            @php
                                $count = $ratingCounts[$i] ?? 0;
                                $percentage = ($count / $totalReviews) * 100;
                            @endphp
                            <div class="flex items-center gap-3">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300 w-8">{{ $i }} ★</span>
                                <div class="flex-1 h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                    <div class="h-full bg-yellow-400 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                                </div>
                                <span class="text-sm text-gray-600 dark:text-gray-400 w-12 text-right">{{ $count }}</span>
                            </div>
                        @endfor
                    </div>

                    <button @click="showModal = true"
                        class="w-full px-6 py-3 bg-gradient-to-r from-[#1363C6] to-[#0d4a94] text-white font-semibold rounded-xl hover:shadow-xl hover:shadow-[#1363C6]/30 transition-all duration-300 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Write a Review
                    </button>
                </div>
            </div>

            {{-- Right: Reviews List --}}
            <div class="lg:col-span-2">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Customer Reviews</h3>
                
                <div class="space-y-6">
                    @forelse ($app->approvedReviews()->latest()->get() as $review)
                        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-[#1363C6] to-[#0d4a94] flex items-center justify-center text-white font-bold text-lg flex-shrink-0">
                                    {{ strtoupper(substr($review->reviewer_name, 0, 1)) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-4 mb-2">
                                        <div class="flex-1 min-w-0">
                                            <h4 class="font-semibold text-gray-900 dark:text-white truncate">{{ $review->reviewer_name }}</h4>
                                            <div class="flex items-center gap-2 mt-1">
                                                <div class="flex items-center gap-0.5">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                        </svg>
                                                    @endfor
                                                </div>
                                                <span class="text-sm text-gray-500 dark:text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-1 px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs font-semibold rounded-full flex-shrink-0">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                            Verified
                                        </div>
                                    </div>
                                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ $review->review }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-16">
                            <div class="w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">No reviews yet</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-6">Be the first to share your experience with this app!</p>
                            <button @click="showModal = true"
                                class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-[#1363C6] to-[#0d4a94] text-white font-semibold rounded-xl hover:shadow-xl hover:shadow-[#1363C6]/30 transition-all duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Write the First Review
                            </button>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- Review Form Modal --}}
    <div x-show="showModal" 
        x-cloak
        @click.self="showModal = false"
        @keydown.escape.window="showModal = false"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
        
        <div @click.stop
            class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-95">
            
            {{-- Modal Header --}}
            <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-700">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Write a Review</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Share your experience with {{ $app->name }}</p>
                </div>
                <button @click="showModal = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Success Message --}}
            <div x-show="successMessage" class="mx-6 mt-6 p-4 bg-green-100 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-lg">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <p class="text-green-700 dark:text-green-300 font-medium" x-text="successMessage"></p>
                </div>
            </div>

            {{-- Modal Body --}}
            <form @submit.prevent="submitReview" class="p-6 space-y-6">
                {{-- Rating --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-3">
                        Your Rating <span class="text-red-500">*</span>
                    </label>
                    <div class="flex items-center gap-2">
                        <template x-for="i in 5" :key="i">
                            <button type="button" @click="rating = i" class="focus:outline-none transition-transform hover:scale-110">
                                <svg class="w-10 h-10 transition-colors" :class="i <= rating ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600 hover:text-yellow-200'" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </button>
                        </template>
                        <span x-show="rating > 0" class="ml-3 text-lg font-semibold text-gray-700 dark:text-gray-300" x-text="rating + ' / 5'"></span>
                    </div>
                    <template x-if="errors.rating">
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400" x-text="errors.rating[0]"></p>
                    </template>
                </div>

                {{-- Name --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                        Your Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" x-model="reviewer_name" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-[#1363C6] focus:border-transparent transition-all"
                        placeholder="Enter your full name">
                    <template x-if="errors.reviewer_name">
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400" x-text="errors.reviewer_name[0]"></p>
                    </template>
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                        Your Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" x-model="reviewer_email" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-[#1363C6] focus:border-transparent transition-all"
                        placeholder="your.email@example.com">
                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        Your email will not be published
                    </p>
                    <template x-if="errors.reviewer_email">
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400" x-text="errors.reviewer_email[0]"></p>
                    </template>
                </div>

                {{-- Review --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                        Your Review <span class="text-red-500">*</span>
                    </label>
                    <textarea x-model="review" required rows="5"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-[#1363C6] focus:border-transparent transition-all resize-none"
                        placeholder="Tell us about your experience with this app... (minimum 10 characters)"></textarea>
                    <div class="flex items-center justify-between mt-2">
                        <p class="text-xs text-gray-500 dark:text-gray-400" x-text="review.length + ' / 1000 characters'"></p>
                        <template x-if="errors.review">
                            <p class="text-sm text-red-600 dark:text-red-400" x-text="errors.review[0]"></p>
                        </template>
                    </div>
                </div>

                {{-- General Error --}}
                <template x-if="errors.general">
                    <div class="p-4 bg-red-100 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-lg">
                        <p class="text-red-700 dark:text-red-300 text-sm" x-text="errors.general[0]"></p>
                    </div>
                </template>

                {{-- Submit Button --}}
                <div class="flex items-center gap-3 pt-4">
                    <button type="submit" :disabled="submitting || rating === 0"
                        class="flex-1 px-6 py-3 bg-gradient-to-r from-[#1363C6] to-[#0d4a94] text-white font-semibold rounded-xl hover:shadow-xl hover:shadow-[#1363C6]/30 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                        <svg x-show="submitting" class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span x-text="submitting ? 'Submitting...' : 'Submit Review'"></span>
                    </button>
                    <button type="button" @click="showModal = false"
                        class="px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-semibold rounded-xl hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                        Cancel
                    </button>
                </div>

                <p class="text-xs text-center text-gray-500 dark:text-gray-400 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Your review will be published after approval by our team
                </p>
            </form>
        </div>
    </div>
</section>

{{-- Back Button --}}
<section class="py-12 bg-gray-50 dark:bg-gray-800">
    <div class="max-w-7xl mx-auto px-6 sm:px-10 md:px-16 lg:px-20 text-center">
        <a href="{{ route('frontend.apps.index') }}"
            class="inline-flex items-center gap-2 text-gray-600 dark:text-gray-400 hover:text-[#1363C6] dark:hover:text-[#4CAFF9] transition-colors font-semibold">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to all apps
        </a>
    </div>
</section>

<style>
    [x-cloak] { display: none !important; }
</style>

@endsection
