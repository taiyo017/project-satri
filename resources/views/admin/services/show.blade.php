<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ $service->title }}
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Service Details
                </p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('services.edit', $service) }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white rounded-lg transition-all duration-200 hover:shadow-lg hover:scale-[1.02]"
                    style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Service
                </a>
                <a href="{{ route('services.index') }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Services
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        {{-- Service Details Card --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800/50">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                    <svg class="w-5 h-5" style="color: #1363C6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Service Information
                </h3>
            </div>
            <div class="p-6 space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Title --}}
                    <div>
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Title</label>
                        <p class="mt-1 text-base font-semibold text-gray-900 dark:text-white">{{ $service->title }}</p>
                    </div>

                    {{-- Slug --}}
                    <div>
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">URL Slug</label>
                        <p class="mt-1 text-base text-gray-900 dark:text-white">/{{ $service->slug }}</p>
                    </div>

                    {{-- Status --}}
                    <div>
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</label>
                        <div class="mt-1">
                            @if ($service->status === 'published')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-sm font-medium">
                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                                    Published
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 text-sm font-medium">
                                    <span class="w-1.5 h-1.5 bg-gray-400 rounded-full"></span>
                                    Draft
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Featured --}}
                    <div>
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Featured</label>
                        <div class="mt-1">
                            @if ($service->is_featured)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400 text-sm font-medium">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    Yes
                                </span>
                            @else
                                <span class="text-gray-500 dark:text-gray-400 text-sm">No</span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Featured Image --}}
                @if ($service->image)
                    <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400 block mb-3">Featured Image</label>
                        <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->title }}"
                            class="w-full max-w-2xl h-64 object-cover rounded-xl border-2 border-gray-200 dark:border-gray-700">
                    </div>
                @endif

                {{-- Short Description --}}
                @if ($service->short_description)
                    <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400 block mb-2">Short Description</label>
                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ $service->short_description }}</p>
                    </div>
                @endif

                {{-- Full Description --}}
                @if ($service->description)
                    <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400 block mb-2">Full Description</label>
                        <div class="prose dark:prose-invert max-w-none text-gray-700 dark:text-gray-300">
                            {!! nl2br(e($service->description)) !!}
                        </div>
                    </div>
                @endif

                {{-- Timestamps --}}
                <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Created At</label>
                            <p class="mt-1 text-sm text-gray-700 dark:text-gray-300">
                                {{ $service->created_at->format('M d, Y h:i A') }}
                            </p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Updated</label>
                            <p class="mt-1 text-sm text-gray-700 dark:text-gray-300">
                                {{ $service->updated_at->format('M d, Y h:i A') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
