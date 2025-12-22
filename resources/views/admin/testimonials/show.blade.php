<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h2 class="font-bold text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Testimonial Details') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    View testimonial information
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('testimonials.edit', $testimonial) }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 text-white font-semibold rounded-lg transition-all duration-200 hover:shadow-lg hover:scale-[1.02]"
                    style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>

                <a href="{{ route('testimonials.index') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 font-semibold rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">

        <!-- Flash Messages -->
        @foreach (['success', 'error'] as $msg)
            @if (session($msg))
                <div class="mb-4">
                    <x-alert type="{{ $msg }}" :message="session($msg)" dismissible="true" />
                </div>
            @endif
        @endforeach

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Customer Information -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden shadow-sm">
                    <div
                        class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800/50">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                                style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Customer Information</h3>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Name</p>
                                <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $testimonial->name }}</p>
                            </div>

                            @if ($testimonial->position)
                                <div>
                                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Position</p>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $testimonial->position }}</p>
                                </div>
                            @endif

                            @if ($testimonial->company)
                                <div>
                                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Company</p>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $testimonial->company }}</p>
                                </div>
                            @endif

                            <div>
                                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Rating</p>
                                <div class="flex items-center gap-1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $testimonial->rating)
                                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5 text-gray-300 dark:text-gray-600" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @endif
                                    @endfor
                                    <span class="ml-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                                        ({{ $testimonial->rating }}/5)
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial Content -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden shadow-sm">
                    <div
                        class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800/50">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                                style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Testimonial Message</h3>
                        </div>
                    </div>

                    <div class="p-6">
                        <div
                            class="relative bg-gray-50 dark:bg-gray-900/50 rounded-xl p-6 border-l-4 border-blue-600 dark:border-blue-500">
                            <svg class="absolute top-4 left-4 w-8 h-8 text-blue-600/20 dark:text-blue-500/20"
                                fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                            </svg>
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed relative z-10 pl-8">
                                {{ $testimonial->message }}
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Sidebar -->
            <div class="space-y-6">

                <!-- Photo -->
                @if ($testimonial->photo)
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden shadow-sm">
                        <div
                            class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800/50">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                                    style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Customer Photo</h3>
                            </div>
                        </div>

                        <div class="p-6">
                            <img src="{{ asset('storage/' . $testimonial->photo) }}" alt="{{ $testimonial->name }}"
                                class="w-full h-64 object-cover rounded-xl border-2 border-gray-200 dark:border-gray-700">
                        </div>
                    </div>
                @endif

                <!-- Status & Details -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden shadow-sm">
                    <div
                        class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800/50">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                                style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Details</h3>
                        </div>
                    </div>

                    <div class="p-6 space-y-4">
                        <div>
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-2">Status</p>
                            @if ($testimonial->status === 'active')
                                <span
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs font-medium">
                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                                    Active
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 text-xs font-medium">
                                    <span class="w-1.5 h-1.5 bg-gray-400 rounded-full"></span>
                                    Inactive
                                </span>
                            @endif
                        </div>

                        @if ($testimonial->is_featured)
                            <div>
                                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-2">Featured</p>
                                <span
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400 text-xs font-medium">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    Featured Testimonial
                                </span>
                            </div>
                        @endif

                        <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Created</p>
                            <p class="text-sm text-gray-900 dark:text-white">
                                {{ $testimonial->created_at->format('M d, Y H:i') }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                {{ $testimonial->created_at->diffForHumans() }}
                            </p>
                        </div>

                        <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Last Updated</p>
                            <p class="text-sm text-gray-900 dark:text-white">
                                {{ $testimonial->updated_at->format('M d, Y H:i') }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                {{ $testimonial->updated_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
