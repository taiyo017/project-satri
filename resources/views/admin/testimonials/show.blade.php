<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Testimonial Details') }}
                </h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    View testimonial information
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('testimonials.index') }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    {{ __('Back') }}
                </a>

                <a href="{{ route('testimonials.edit', $testimonial) }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 text-white text-sm font-semibold rounded-lg transition-all duration-200 hover:shadow-lg hover:scale-[1.02]"
                    style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Testimonial
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Customer Info -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Customer Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800/50">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                            <svg class="w-5 h-5" style="color: #1363C6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Customer Information
                        </h3>
                    </div>
                    <div class="p-6 space-y-5">
                        <!-- Photo -->
                        <div class="flex justify-center">
                            @if($testimonial->photo)
                                <img src="{{ asset('storage/' . $testimonial->photo) }}" alt="{{ $testimonial->name }}"
                                    class="w-32 h-32 rounded-full object-cover border-4 border-gray-200 dark:border-gray-700 shadow-lg">
                            @else
                                <div class="w-32 h-32 rounded-full flex items-center justify-center text-white text-4xl font-bold shadow-lg"
                                    style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                                    {{ strtoupper(substr($testimonial->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>

                        <!-- Details -->
                        <div class="space-y-4">
                            <div>
                                <label class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Name</label>
                                <p class="text-base font-semibold text-gray-900 dark:text-white mt-1">{{ $testimonial->name }}</p>
                            </div>

                            @if($testimonial->position)
                                <div>
                                    <label class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Position</label>
                                    <p class="text-base text-gray-900 dark:text-white mt-1">{{ $testimonial->position }}</p>
                                </div>
                            @endif

                            @if($testimonial->company)
                                <div>
                                    <label class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Company</label>
                                    <p class="text-base text-gray-900 dark:text-white mt-1">{{ $testimonial->company }}</p>
                                </div>
                            @endif

                            <div>
                                <label class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Rating</label>
                                <div class="flex items-center gap-1 mt-1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $testimonial->rating)
                                            <svg class="w-6 h-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @else
                                            <svg class="w-6 h-6 text-gray-300 dark:text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @endif
                                    @endfor
                                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">({{ $testimonial->rating }}/5)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800/50">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                            <svg class="w-5 h-5" style="color: #1363C6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Status
                        </h3>
                    </div>
                    <div class="p-6 space-y-5">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Visibility</span>
                            @if($testimonial->status === 'active')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs font-medium">
                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                                    Active
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 text-xs font-medium">
                                    <span class="w-1.5 h-1.5 bg-gray-400 rounded-full"></span>
                                    Inactive
                                </span>
                            @endif
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Featured</span>
                            @if($testimonial->is_featured)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400 text-xs font-medium">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    Yes
                                </span>
                            @else
                                <span class="text-sm text-gray-400 dark:text-gray-500">No</span>
                            @endif
                        </div>

                        <div class="pt-3 border-t border-gray-200 dark:border-gray-700">
                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                <p>Created: {{ $testimonial->created_at->format('M d, Y h:i A') }}</p>
                                <p class="mt-1">Updated: {{ $testimonial->updated_at->format('M d, Y h:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Testimonial Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Message Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800/50">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                            <svg class="w-5 h-5" style="color: #1363C6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                            Testimonial Message
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="relative">
                            <svg class="absolute top-0 left-0 w-8 h-8 text-blue-200 dark:text-blue-900/30" fill="currentColor" viewBox="0 0 32 32">
                                <path d="M10 8c-3.3 0-6 2.7-6 6s2.7 6 6 6c.3 0 .5 0 .8-.1L8 24h4.4l1.6-2.7c1.6-1.1 2.7-3 2.7-5.1 0-3.3-2.7-6-6-6zm12 0c-3.3 0-6 2.7-6 6s2.7 6 6 6c.3 0 .5 0 .8-.1L20 24h4.4l1.6-2.7c1.6-1.1 2.7-3 2.7-5.1 0-3.3-2.7-6-6-6z"/>
                            </svg>
                            
                            <div class="pl-12 pr-4">
                                <p class="text-gray-700 dark:text-gray-300 text-lg leading-relaxed italic">
                                    "{{ $testimonial->message }}"
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SEO Meta Tags Card -->
                @if($testimonial->meta_title || $testimonial->meta_description || $testimonial->meta_keywords)
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800/50">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                                <svg class="w-5 h-5" style="color: #1363C6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                SEO Meta Tags
                            </h3>
                        </div>
                        <div class="p-6 space-y-5">
                            @if($testimonial->meta_title)
                                <div>
                                    <label class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Meta Title</label>
                                    <p class="text-sm text-gray-900 dark:text-white mt-1">{{ $testimonial->meta_title }}</p>
                                </div>
                            @endif

                            @if($testimonial->meta_description)
                                <div>
                                    <label class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Meta Description</label>
                                    <p class="text-sm text-gray-900 dark:text-white mt-1">{{ $testimonial->meta_description }}</p>
                                </div>
                            @endif

                            @if($testimonial->meta_keywords)
                                <div>
                                    <label class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Meta Keywords</label>
                                    <p class="text-sm text-gray-900 dark:text-white mt-1">{{ $testimonial->meta_keywords }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

</x-app-layout>
